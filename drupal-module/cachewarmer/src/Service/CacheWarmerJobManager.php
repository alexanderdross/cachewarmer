<?php

namespace Drupal\cachewarmer\Service;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Psr\Log\LoggerInterface;

/**
 * Manages cache warming jobs: creation, processing, and status tracking.
 */
class CacheWarmerJobManager {

  protected CacheWarmerDatabase $database;
  protected CacheWarmerSitemapParser $sitemapParser;
  protected CdnWarmer $cdnWarmer;
  protected FacebookWarmer $facebookWarmer;
  protected LinkedinWarmer $linkedinWarmer;
  protected TwitterWarmer $twitterWarmer;
  protected GoogleIndexer $googleIndexer;
  protected BingIndexer $bingIndexer;
  protected IndexNow $indexNow;
  protected ConfigFactoryInterface $configFactory;
  protected LoggerInterface $logger;

  /**
   * Allowed warming targets.
   */
  protected const ALLOWED_TARGETS = [
    'cdn', 'facebook', 'linkedin', 'twitter', 'google', 'bing', 'indexnow',
  ];

  public function __construct(
    CacheWarmerDatabase $database,
    CacheWarmerSitemapParser $sitemapParser,
    CdnWarmer $cdnWarmer,
    FacebookWarmer $facebookWarmer,
    LinkedinWarmer $linkedinWarmer,
    TwitterWarmer $twitterWarmer,
    GoogleIndexer $googleIndexer,
    BingIndexer $bingIndexer,
    IndexNow $indexNow,
    ConfigFactoryInterface $configFactory,
    LoggerChannelFactoryInterface $loggerFactory,
  ) {
    $this->database = $database;
    $this->sitemapParser = $sitemapParser;
    $this->cdnWarmer = $cdnWarmer;
    $this->facebookWarmer = $facebookWarmer;
    $this->linkedinWarmer = $linkedinWarmer;
    $this->twitterWarmer = $twitterWarmer;
    $this->googleIndexer = $googleIndexer;
    $this->bingIndexer = $bingIndexer;
    $this->indexNow = $indexNow;
    $this->configFactory = $configFactory;
    $this->logger = $loggerFactory->get('cachewarmer');
  }

  /**
   * Creates a new warming job.
   */
  public function createJob(string $sitemapUrl, array $targets, ?string $sitemapId = NULL): array {
    // Validate targets.
    $targets = array_values(array_intersect($targets, self::ALLOWED_TARGETS));
    if (empty($targets)) {
      $targets = self::ALLOWED_TARGETS;
    }

    $job = $this->database->insertJob($sitemapUrl, $targets, $sitemapId);

    $this->logger->info('Created warming job @id for @url', [
      '@id' => $job->id,
      '@url' => $sitemapUrl,
    ]);

    return [
      'jobId' => $job->id,
      'status' => $job->status,
      'sitemapUrl' => $sitemapUrl,
      'targets' => $targets,
      'createdAt' => $job->created_at,
    ];
  }

  /**
   * Processes a warming job.
   */
  public function processJob(string $jobId): void {
    $job = $this->database->getJob($jobId);
    if (!$job) {
      $this->logger->error('Job @id not found', ['@id' => $jobId]);
      return;
    }

    if ($job->status !== 'queued') {
      $this->logger->warning('Job @id is not queued (status: @status)', [
        '@id' => $jobId,
        '@status' => $job->status,
      ]);
      return;
    }

    // Extend execution limits.
    if (function_exists('set_time_limit')) {
      @set_time_limit(0);
    }
    if (function_exists('ini_set')) {
      @ini_set('memory_limit', '512M');
    }

    $this->database->updateJob($jobId, [
      'status' => 'running',
      'started_at' => gmdate('Y-m-d\TH:i:s\Z'),
    ]);

    try {
      // Parse sitemap.
      $entries = $this->sitemapParser->parse($job->sitemap_url);
      $urls = array_map(fn($e) => $e['loc'], $entries);

      $this->database->updateJob($jobId, [
        'total_urls' => count($urls),
      ]);

      if (empty($urls)) {
        $this->database->updateJob($jobId, [
          'status' => 'completed',
          'completed_at' => gmdate('Y-m-d\TH:i:s\Z'),
        ]);
        return;
      }

      $targets = json_decode($job->targets, TRUE) ?: [];
      $config = $this->configFactory->get('cachewarmer.settings');
      $processedCount = 0;

      // Build result callback.
      $onResult = function (string $url, string $status, ?int $httpStatus, int $durationMs, ?string $error) use ($jobId, &$processedCount) {
        $target = 'cdn'; // Will be overridden per-service below.
        $this->database->insertUrlResult($jobId, $url, $target, $status, $httpStatus, $durationMs, $error);
      };

      // Process each target.
      foreach ($targets as $target) {
        if (!$this->isTargetEnabled($target, $config)) {
          continue;
        }

        $targetOnResult = function (string $url, string $status, ?int $httpStatus, int $durationMs, ?string $error) use ($jobId, $target, &$processedCount) {
          $this->database->insertUrlResult($jobId, $url, $target, $status, $httpStatus, $durationMs, $error);
          $processedCount++;
          $this->database->updateJob($jobId, [
            'processed_urls' => $processedCount,
          ]);
        };

        $this->processTarget($target, $urls, $jobId, $targetOnResult);
      }

      $this->database->updateJob($jobId, [
        'status' => 'completed',
        'completed_at' => gmdate('Y-m-d\TH:i:s\Z'),
        'processed_urls' => $processedCount,
      ]);

      // Update sitemap last_warmed_at if linked.
      if (!empty($job->sitemap_id)) {
        $this->database->updateSitemapLastWarmed($job->sitemap_id);
      }

      $this->logger->info('Completed warming job @id: @count results', [
        '@id' => $jobId,
        '@count' => $processedCount,
      ]);
    }
    catch (\Exception $e) {
      $this->database->updateJob($jobId, [
        'status' => 'failed',
        'completed_at' => gmdate('Y-m-d\TH:i:s\Z'),
        'error' => $e->getMessage(),
      ]);
      $this->logger->error('Job @id failed: @error', [
        '@id' => $jobId,
        '@error' => $e->getMessage(),
      ]);
    }
  }

  /**
   * Checks if a target is enabled in config.
   */
  protected function isTargetEnabled(string $target, $config): bool {
    return (bool) $config->get("{$target}.enabled");
  }

  /**
   * Dispatches warming to the appropriate service.
   */
  protected function processTarget(string $target, array $urls, string $jobId, callable $onResult): void {
    switch ($target) {
      case 'cdn':
        $this->cdnWarmer->warm($urls, $jobId, $onResult);
        break;

      case 'facebook':
        $this->facebookWarmer->warm($urls, $jobId, $onResult);
        break;

      case 'linkedin':
        $this->linkedinWarmer->warm($urls, $jobId, $onResult);
        break;

      case 'twitter':
        $this->twitterWarmer->warm($urls, $jobId, $onResult);
        break;

      case 'google':
        $this->googleIndexer->index($urls, $jobId, $onResult);
        break;

      case 'bing':
        $this->bingIndexer->index($urls, $jobId, $onResult);
        break;

      case 'indexnow':
        $this->indexNow->index($urls, $jobId, $onResult);
        break;
    }
  }

  /**
   * Gets a job with aggregated stats.
   */
  public function getJobWithStats(string $jobId): ?array {
    $job = $this->database->getJob($jobId);
    if (!$job) {
      return NULL;
    }

    $stats = $this->database->getJobStats($jobId);

    return [
      'id' => $job->id,
      'sitemap_id' => $job->sitemap_id,
      'sitemap_url' => $job->sitemap_url,
      'status' => $job->status,
      'total_urls' => (int) $job->total_urls,
      'processed_urls' => (int) $job->processed_urls,
      'targets' => json_decode($job->targets, TRUE),
      'started_at' => $job->started_at,
      'completed_at' => $job->completed_at,
      'error' => $job->error,
      'created_at' => $job->created_at,
      'stats' => $stats,
    ];
  }

}
