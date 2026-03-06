<?php
/**
 * Plugin-Deinstallation: Tabellen und Optionen löschen.
 *
 * @package CacheWarmer_License_Manager
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

global $wpdb;
$prefix = $wpdb->prefix . 'cwlm_';

$tables = [
    'rate_limits',
    'stripe_events',
    'stripe_product_map',
    'audit_logs',
    'geo_data',
    'installations',
    'licenses',
];

foreach ( $tables as $table ) {
    $wpdb->query( "DROP TABLE IF EXISTS {$prefix}{$table}" ); // phpcs:ignore WordPress.DB.PreparedSQL
}

delete_option( 'cwlm_version' );

// Cronjobs entfernen
wp_clear_scheduled_hook( 'cwlm_check_expired_licenses' );
wp_clear_scheduled_hook( 'cwlm_cleanup_old_data' );
wp_clear_scheduled_hook( 'cwlm_cleanup_rate_limits' );
wp_clear_scheduled_hook( 'cwlm_check_stale_installations' );
wp_clear_scheduled_hook( 'cwlm_send_expiry_warnings' );
