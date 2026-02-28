<?php
/**
 * License management for CacheWarmer.
 *
 * Defines tier-based feature limits and license activation.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CacheWarmer_License {

    const TIER_FREE       = 'free';
    const TIER_PREMIUM    = 'premium';
    const TIER_ENTERPRISE = 'enterprise';

    const LIMITS = array(
        'free' => array(
            'max_urls_per_job'      => 50,
            'max_sitemaps'          => 2,
            'max_external_sitemaps' => 1,
            'max_jobs_per_day'      => 3,
            'log_retention_days'    => 7,
            'cdn_concurrency'       => 2,
            'allowed_targets'       => array( 'cdn', 'indexnow' ),
            'scheduler_enabled'     => false,
            'api_enabled'           => false,
            'export_enabled'        => false,
            'webhooks_enabled'      => false,
            'email_notifications'   => false,
        ),
        'premium' => array(
            'max_urls_per_job'      => 10000,
            'max_sitemaps'          => 25,
            'max_external_sitemaps' => 10,
            'max_jobs_per_day'      => 50,
            'log_retention_days'    => 90,
            'cdn_concurrency'       => 10,
            'allowed_targets'       => array( 'cdn', 'indexnow', 'facebook', 'linkedin', 'twitter', 'google', 'bing' ),
            'scheduler_enabled'     => true,
            'api_enabled'           => true,
            'export_enabled'        => true,
            'webhooks_enabled'      => false,
            'email_notifications'   => true,
        ),
        'enterprise' => array(
            'max_urls_per_job'      => PHP_INT_MAX,
            'max_sitemaps'          => PHP_INT_MAX,
            'max_external_sitemaps' => PHP_INT_MAX,
            'max_jobs_per_day'      => PHP_INT_MAX,
            'log_retention_days'    => 365,
            'cdn_concurrency'       => 20,
            'allowed_targets'       => array( 'cdn', 'indexnow', 'facebook', 'linkedin', 'twitter', 'google', 'bing' ),
            'scheduler_enabled'     => true,
            'api_enabled'           => true,
            'export_enabled'        => true,
            'webhooks_enabled'      => true,
            'email_notifications'   => true,
        ),
    );

    /**
     * Get the current license tier.
     *
     * @return string
     */
    public static function get_tier(): string {
        return get_option( 'cachewarmer_license_tier', self::TIER_FREE );
    }

    /**
     * Get a specific limit value for the current tier.
     *
     * @param string $key Limit key.
     * @return mixed|null
     */
    public static function get_limit( string $key ) {
        $tier = self::get_tier();
        return self::LIMITS[ $tier ][ $key ] ?? null;
    }

    /**
     * Check if a feature is enabled for the current tier.
     *
     * @param string $feature Feature key.
     * @return bool
     */
    public static function can( string $feature ): bool {
        return (bool) self::get_limit( $feature );
    }

    /**
     * Check if a warming target is allowed for the current tier.
     *
     * @param string $target Target name (e.g. 'cdn', 'facebook').
     * @return bool
     */
    public static function is_target_allowed( string $target ): bool {
        $allowed = self::get_limit( 'allowed_targets' );
        return in_array( $target, $allowed, true );
    }

    /**
     * Check if the current tier is Premium or above.
     *
     * @return bool
     */
    public static function is_premium_or_above(): bool {
        return in_array( self::get_tier(), array( self::TIER_PREMIUM, self::TIER_ENTERPRISE ), true );
    }

    /**
     * Check if the current tier is Enterprise.
     *
     * @return bool
     */
    public static function is_enterprise(): bool {
        return self::get_tier() === self::TIER_ENTERPRISE;
    }

    /**
     * Activate a license key.
     *
     * Determines the tier based on the key prefix. In production,
     * this would validate against a remote license server.
     *
     * @param string $license_key The license key to activate.
     * @return array Activation result with tier and status.
     */
    public static function activate( string $license_key ): array {
        update_option( 'cachewarmer_license_key', sanitize_text_field( $license_key ) );

        // Determine tier based on key prefix or server response.
        $tier = self::TIER_FREE;
        if ( strpos( $license_key, 'PRE-' ) === 0 ) {
            $tier = self::TIER_PREMIUM;
        }
        if ( strpos( $license_key, 'ENT-' ) === 0 ) {
            $tier = self::TIER_ENTERPRISE;
        }

        update_option( 'cachewarmer_license_tier', $tier );

        return array(
            'tier'      => $tier,
            'activated' => true,
        );
    }
}
