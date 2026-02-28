<?php

namespace Drupal\cachewarmer\Service;

use Drupal\Core\Config\ConfigFactoryInterface;
use GuzzleHttp\ClientInterface;
use Psr\Log\LoggerInterface;

/**
 * Sends webhook notifications for CacheWarmer events.
 */
class CacheWarmerWebhooks {

  /**
   * The config factory.
   */
  protected ConfigFactoryInterface $configFactory;

  /**
   * The HTTP client.
   */
  protected ClientInterface $httpClient;

  /**
   * The logger.
   */
  protected LoggerInterface $logger;

  /**
   * The license service.
   */
  protected CacheWarmerLicense $license;

  /**
   * Constructs the CacheWarmerWebhooks service.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \GuzzleHttp\ClientInterface $http_client
   *   The HTTP client.
   * @param \Psr\Log\LoggerInterface $logger
   *   The logger.
   * @param \Drupal\cachewarmer\Service\CacheWarmerLicense $license
   *   The license service.
   */
  public function __construct(ConfigFactoryInterface $config_factory, ClientInterface $http_client, LoggerInterface $logger, CacheWarmerLicense $license) {
    $this->configFactory = $config_factory;
    $this->httpClient = $http_client;
    $this->logger = $logger;
    $this->license = $license;
  }

  /**
   * Sends a webhook notification.
   *
   * @param string $event
   *   The event name.
   * @param array $data
   *   The event data.
   */
  public function notify(string $event, array $data): void {
    if (!$this->license->isEnterprise()) {
      return;
    }

    $webhook_url = $this->configFactory->get('cachewarmer.settings')->get('webhook_url');
    if (empty($webhook_url) || !filter_var($webhook_url, FILTER_VALIDATE_URL)) {
      return;
    }

    try {
      $this->httpClient->requestAsync('POST', $webhook_url, [
        'json' => [
          'event' => $event,
          'timestamp' => gmdate('c'),
          'data' => $data,
        ],
        'timeout' => 10,
      ]);
    }
    catch (\Exception $e) {
      $this->logger->warning('Webhook notification failed: @error', ['@error' => $e->getMessage()]);
    }
  }

}
