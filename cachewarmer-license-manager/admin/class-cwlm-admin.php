<?php
/**
 * Admin-Menü und Page Registration.
 *
 * @package CacheWarmer_License_Manager
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CWLM_Admin {

    /**
     * Admin-Hooks registrieren.
     */
    public function init(): void {
        add_action( 'admin_menu', [ $this, 'add_menu_pages' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_assets' ] );
    }

    /**
     * Admin-Menü erstellen.
     */
    public function add_menu_pages(): void {
        add_menu_page(
            __( 'CacheWarmer LM', 'cwlm' ),
            __( 'CacheWarmer LM', 'cwlm' ),
            'manage_options',
            'cwlm-dashboard',
            [ $this, 'render_dashboard' ],
            'dashicons-shield',
            30
        );

        add_submenu_page(
            'cwlm-dashboard',
            __( 'Dashboard', 'cwlm' ),
            __( 'Dashboard', 'cwlm' ),
            'manage_options',
            'cwlm-dashboard',
            [ $this, 'render_dashboard' ]
        );

        add_submenu_page(
            'cwlm-dashboard',
            __( 'Lizenzen', 'cwlm' ),
            __( 'Lizenzen', 'cwlm' ),
            'manage_options',
            'cwlm-licenses',
            [ $this, 'render_licenses' ]
        );

        add_submenu_page(
            'cwlm-dashboard',
            __( 'Installationen', 'cwlm' ),
            __( 'Installationen', 'cwlm' ),
            'manage_options',
            'cwlm-installations',
            [ $this, 'render_installations' ]
        );

        add_submenu_page(
            'cwlm-dashboard',
            __( 'Audit Log', 'cwlm' ),
            __( 'Audit Log', 'cwlm' ),
            'manage_options',
            'cwlm-audit',
            [ $this, 'render_audit' ]
        );

        add_submenu_page(
            'cwlm-dashboard',
            __( 'Stripe Events', 'cwlm' ),
            __( 'Stripe Events', 'cwlm' ),
            'manage_options',
            'cwlm-stripe',
            [ $this, 'render_stripe' ]
        );

        add_submenu_page(
            'cwlm-dashboard',
            __( 'Produkte', 'cwlm' ),
            __( 'Produkte', 'cwlm' ),
            'manage_options',
            'cwlm-products',
            [ $this, 'render_products' ]
        );

        add_submenu_page(
            'cwlm-dashboard',
            __( 'Einstellungen', 'cwlm' ),
            __( 'Einstellungen', 'cwlm' ),
            'manage_options',
            'cwlm-settings',
            [ $this, 'render_settings' ]
        );
    }

    /**
     * Admin-Assets laden.
     */
    public function enqueue_assets( string $hook ): void {
        if ( ! str_starts_with( $hook, 'toplevel_page_cwlm' ) && ! str_contains( $hook, 'cwlm-' ) ) {
            return;
        }

        wp_enqueue_style(
            'cwlm-admin',
            CWLM_PLUGIN_URL . 'admin/css/cwlm-admin.css',
            [],
            CWLM_VERSION
        );

        wp_enqueue_script(
            'cwlm-admin',
            CWLM_PLUGIN_URL . 'admin/js/cwlm-admin.js',
            [ 'jquery' ],
            CWLM_VERSION,
            true
        );

        // Chart.js für Dashboard
        if ( str_contains( $hook, 'cwlm-dashboard' ) || str_starts_with( $hook, 'toplevel_page_cwlm' ) ) {
            wp_enqueue_script(
                'chartjs',
                'https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js',
                [],
                '4.4.0',
                true
            );

            wp_enqueue_script(
                'cwlm-dashboard',
                CWLM_PLUGIN_URL . 'admin/js/cwlm-dashboard.js',
                [ 'jquery', 'chartjs' ],
                CWLM_VERSION,
                true
            );
        }

        wp_localize_script( 'cwlm-admin', 'cwlm', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'cwlm_admin' ),
            'rest_url' => rest_url( 'cwlm/v1/' ),
        ] );
    }

    public function render_dashboard(): void {
        if ( file_exists( CWLM_PLUGIN_DIR . 'admin/views/dashboard.php' ) ) {
            include CWLM_PLUGIN_DIR . 'admin/views/dashboard.php';
        } else {
            echo '<div class="wrap"><h1>CacheWarmer License Manager – Dashboard</h1><p>Dashboard-View wird geladen...</p></div>';
        }
    }

    public function render_licenses(): void {
        if ( file_exists( CWLM_PLUGIN_DIR . 'admin/views/licenses.php' ) ) {
            include CWLM_PLUGIN_DIR . 'admin/views/licenses.php';
        } else {
            echo '<div class="wrap"><h1>Lizenzen</h1><p>Lizenzverwaltung wird geladen...</p></div>';
        }
    }

    public function render_installations(): void {
        if ( file_exists( CWLM_PLUGIN_DIR . 'admin/views/installations.php' ) ) {
            include CWLM_PLUGIN_DIR . 'admin/views/installations.php';
        } else {
            echo '<div class="wrap"><h1>Installationen</h1><p>Installationsübersicht wird geladen...</p></div>';
        }
    }

    public function render_audit(): void {
        if ( file_exists( CWLM_PLUGIN_DIR . 'admin/views/audit-log.php' ) ) {
            include CWLM_PLUGIN_DIR . 'admin/views/audit-log.php';
        } else {
            echo '<div class="wrap"><h1>Audit Log</h1><p>Audit-Log wird geladen...</p></div>';
        }
    }

    public function render_stripe(): void {
        if ( file_exists( CWLM_PLUGIN_DIR . 'admin/views/stripe-events.php' ) ) {
            include CWLM_PLUGIN_DIR . 'admin/views/stripe-events.php';
        } else {
            echo '<div class="wrap"><h1>Stripe Events</h1><p>Stripe Events werden geladen...</p></div>';
        }
    }

    public function render_products(): void {
        if ( file_exists( CWLM_PLUGIN_DIR . 'admin/views/products.php' ) ) {
            include CWLM_PLUGIN_DIR . 'admin/views/products.php';
        } else {
            echo '<div class="wrap"><h1>Produkte</h1><p>Produktverwaltung wird geladen...</p></div>';
        }
    }

    public function render_settings(): void {
        if ( file_exists( CWLM_PLUGIN_DIR . 'admin/views/settings.php' ) ) {
            include CWLM_PLUGIN_DIR . 'admin/views/settings.php';
        } else {
            echo '<div class="wrap"><h1>Einstellungen</h1><p>Einstellungen werden geladen...</p></div>';
        }
    }
}
