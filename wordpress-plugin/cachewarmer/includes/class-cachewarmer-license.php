<?php
/**
 * License management for CacheWarmer.
 *
 * Validates license keys via HMAC signature, enforces tier-based
 * feature limits, and auto-downgrades expired licenses to Free.
 *
 * Key format: CW-{TIER}-{HEX16}
 *   TIER = PRO | ENT
 *   HEX16 = 4-char duration (days, hex, 0000 = never) + 12-char HMAC signature
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CacheWarmer_License {

    const TIER_FREE       = 'free';
    const TIER_PREMIUM    = 'premium';
    const TIER_ENTERPRISE = 'enterprise';

    /** @var string HMAC signing secret for key validation. */
    const SIGN_SECRET = 'cw-drossmedia-lic-2026-s3cr3t';

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

    // ──────────────────────────────────────────────
    // Key generation & validation
    // ──────────────────────────────────────────────

    /**
     * Generate a license key.
     *
     * @param string $tier          'premium' or 'enterprise'.
     * @param int    $duration_days Validity in days after activation. 0 = never expires.
     * @return string License key in format CW-{PRO|ENT}-{HEX16}.
     */
    public static function generate_key( string $tier, int $duration_days = 0 ): string {
        $tier_code    = 'enterprise' === $tier ? 'ENT' : 'PRO';
        $duration_hex = str_pad( strtoupper( dechex( $duration_days ) ), 4, '0', STR_PAD_LEFT );
        $payload      = $tier_code . $duration_hex;
        $signature    = strtoupper( substr( hash_hmac( 'sha256', $payload, self::SIGN_SECRET ), 0, 12 ) );

        return 'CW-' . $tier_code . '-' . $duration_hex . $signature;
    }

    /**
     * Validate a license key and extract its data.
     *
     * @param string $key License key.
     * @return array|false Array with 'tier' and 'duration_days', or false if invalid.
     */
    public static function validate_key( string $key ) {
        $key = strtoupper( trim( $key ) );

        if ( ! preg_match( '/^CW-(PRO|ENT)-([0-9A-F]{16})$/', $key, $m ) ) {
            return false;
        }

        $tier_code    = $m[1];
        $hex          = $m[2];
        $duration_hex = substr( $hex, 0, 4 );
        $provided_sig = strtolower( substr( $hex, 4, 12 ) );

        $payload      = $tier_code . $duration_hex;
        $expected_sig = substr( hash_hmac( 'sha256', $payload, self::SIGN_SECRET ), 0, 12 );

        if ( ! hash_equals( $expected_sig, $provided_sig ) ) {
            return false;
        }

        return array(
            'tier'          => 'ENT' === $tier_code ? self::TIER_ENTERPRISE : self::TIER_PREMIUM,
            'duration_days' => hexdec( $duration_hex ),
        );
    }

    // ──────────────────────────────────────────────
    // Activation & expiry
    // ──────────────────────────────────────────────

    /**
     * Activate a license key.
     *
     * Validates the key, stores the tier, and sets the expiry date.
     *
     * @param string $license_key The license key to activate.
     * @return array Activation result.
     */
    public static function activate( string $license_key ): array {
        $license_key = strtoupper( trim( $license_key ) );
        update_option( 'cachewarmer_license_key', sanitize_text_field( $license_key ) );

        $parsed = self::validate_key( $license_key );

        if ( false === $parsed ) {
            update_option( 'cachewarmer_license_tier', self::TIER_FREE );
            delete_option( 'cachewarmer_license_activated_at' );
            delete_option( 'cachewarmer_license_expires_at' );

            return array(
                'tier'      => self::TIER_FREE,
                'activated' => false,
                'error'     => 'Invalid license key.',
            );
        }

        update_option( 'cachewarmer_license_tier', $parsed['tier'] );
        update_option( 'cachewarmer_license_activated_at', time() );

        if ( $parsed['duration_days'] > 0 ) {
            $expires_at = time() + ( $parsed['duration_days'] * DAY_IN_SECONDS );
            update_option( 'cachewarmer_license_expires_at', $expires_at );
        } else {
            update_option( 'cachewarmer_license_expires_at', 0 ); // Never expires.
        }

        return array(
            'tier'       => $parsed['tier'],
            'activated'  => true,
            'expires_at' => $parsed['duration_days'] > 0
                ? gmdate( 'Y-m-d', time() + $parsed['duration_days'] * DAY_IN_SECONDS )
                : 'never',
        );
    }

    /**
     * Get the current license tier, auto-downgrading if expired.
     *
     * @return string
     */
    public static function get_tier(): string {
        $tier = get_option( 'cachewarmer_license_tier', self::TIER_FREE );

        if ( self::TIER_FREE !== $tier ) {
            $expires_at = (int) get_option( 'cachewarmer_license_expires_at', 0 );

            if ( $expires_at > 0 && time() > $expires_at ) {
                // License expired — auto-downgrade.
                update_option( 'cachewarmer_license_tier', self::TIER_FREE );
                return self::TIER_FREE;
            }
        }

        return $tier;
    }

    /**
     * Get the license expiry timestamp (0 = never).
     *
     * @return int
     */
    public static function get_expires_at(): int {
        return (int) get_option( 'cachewarmer_license_expires_at', 0 );
    }

    /**
     * Check if the license has expired.
     *
     * @return bool
     */
    public static function is_expired(): bool {
        $expires_at = self::get_expires_at();
        return $expires_at > 0 && time() > $expires_at;
    }

    // ──────────────────────────────────────────────
    // Tier & feature queries
    // ──────────────────────────────────────────────

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
        return is_array( $allowed ) && in_array( $target, $allowed, true );
    }

    /**
     * Filter an array of targets to only those allowed by the current tier.
     *
     * @param array $targets Requested targets.
     * @return array Allowed targets.
     */
    public static function filter_allowed_targets( array $targets ): array {
        $allowed = self::get_limit( 'allowed_targets' );
        if ( ! is_array( $allowed ) ) {
            return array();
        }
        return array_values( array_intersect( $targets, $allowed ) );
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
}
