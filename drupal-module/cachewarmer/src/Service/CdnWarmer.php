<?php

namespace Drupal\cachewarmer\Service;

use Drupal\Core\Config\ConfigFactoryInterface;
use GuzzleHttp\ClientInterface;

/**
 * Warms CDN edge caches by requesting URLs with desktop and mobile user agents.
 */
class CdnWarmer {

  protected ClientInterface $httpClient;
  protected ConfigFactoryInterface $configFactory;

  protected const DESKTOP_UA = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';
  protected const MOBILE_UA = 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1';

  public function __construct(ClientInterface $httpClient, ConfigFactoryInterface $configFactory) {
    $this->httpClient = $httpClient;
    $this->configFactory = $configFactory;
  }

  /**
   * Warms the given URLs.
   *
   * @param array $urls
   *   Array of URL strings.
   * @param string $jobId
   *   The job ID.
   * @param callable|null $onResult
   *   Callback: function(string $url, string $status, ?int $httpStatus, int $durationMs, ?string $error)
   */
  public function warm(array $urls, string $jobId, ?callable $onResult = NULL): void {
    $config = $this->configFactory->get('cachewarmer.settings');
    $timeout = (int) ($config->get('cdn.timeout') ?: 30);
    $userAgents = [self::DESKTOP_UA, self::MOBILE_UA];

    foreach ($urls as $url) {
      foreach ($userAgents as $ua) {
        $start = microtime(TRUE);
        try {
          $response = $this->httpClient->request('GET', $url, [
            'timeout' => $timeout,
            'headers' => ['User-Agent' => $ua],
            'http_errors' => FALSE,
          ]);

          $statusCode = $response->getStatusCode();
          $durationMs = (int) ((microtime(TRUE) - $start) * 1000);
          $status = $statusCode < 400 ? 'success' : 'failed';

          if ($onResult) {
            $onResult($url, $status, $statusCode, $durationMs, $status === 'failed' ? "HTTP {$statusCode}" : NULL);
          }
        }
        catch (\Exception $e) {
          $durationMs = (int) ((microtime(TRUE) - $start) * 1000);
          if ($onResult) {
            $onResult($url, 'failed', NULL, $durationMs, $e->getMessage());
          }
        }
      }
    }
  }

}
