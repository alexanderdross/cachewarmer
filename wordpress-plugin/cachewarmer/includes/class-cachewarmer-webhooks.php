<?php
/**
 * Webhook notifications for CacheWarmer.
 *
 * Sends event payloads to a configured webhook URL (Enterprise only).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CacheWarmer_Webhooks {

    /**
     * Send a webhook notification for an event.
     *
     * Only fires for Enterprise tier. Sends a non-blocking POST request
     * with JSON payload to the configured webhook URL.
     *
     * @param string $event Event name (e.g. 'job.completed', 'job.failed').
     * @param array  $data  Event data.
     */
    public static function notify( string $event, array $data ): void {
        if ( ! CacheWarmer_License::is_enterprise() ) {
            return;
        }

        $webhook_url = get_option( 'cachewarmer_webhook_url', '' );
        if ( empty( $webhook_url ) || ! filter_var( $webhook_url, FILTER_VALIDATE_URL ) ) {
            return;
        }

        $payload = wp_json_encode( array(
            'event'     => $event,
            'timestamp' => gmdate( 'c' ),
            'data'      => $data,
        ) );

        wp_remote_post( $webhook_url, array(
            'headers'  => array( 'Content-Type' => 'application/json' ),
            'body'     => $payload,
            'timeout'  => 10,
            'blocking' => false,
        ) );
    }
}
