<?php
/**
 * Header Template
 */

// Determine current page for active nav highlighting
$current_page = '';
if (is_page('features'))    $current_page = 'features';
if (is_page('docs'))        $current_page = 'docs';
if (is_page('api-keys'))    $current_page = 'api-keys';
if (is_page('pricing'))     $current_page = 'pricing';
if (is_page('changelog'))   $current_page = 'changelog';
if (is_page('wordpress'))   $current_page = 'wordpress';
if (is_page('drupal'))      $current_page = 'drupal';
if (is_page('self-hosted')) $current_page = 'self-hosted';
if (is_page('enterprise'))  $current_page = 'enterprise';

$is_platform_page = in_array($current_page, ['wordpress', 'drupal', 'self-hosted']);

// Allow page templates to set custom meta
$page_description = isset($page_description) ? $page_description : 'CacheWarmer - Cache warming for WordPress, Drupal, and Node.js. Warm CDN caches, update social media previews, and notify search engines.';
$page_og_title = isset($page_og_title) ? $page_og_title : 'CacheWarmer';

// Social sharing images (landscape 1200x630, square 1200x1200)
$theme_img_url = get_template_directory_uri() . '/assets/images';
$og_image_landscape = $theme_img_url . '/og-image-landscape.png';
$og_image_square    = $theme_img_url . '/og-image-square.png';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo esc_attr($page_description); ?>">

    <!-- Canonical URL -->
    <?php
    $canonical_url = is_front_page() ? home_url('/') : get_permalink();
    if ($canonical_url) :
    ?>
    <link rel="canonical" href="<?php echo esc_url($canonical_url); ?>">
    <?php endif; ?>

    <!-- Favicon & Touch Icons -->
    <?php $asset_ver = '1.9.2'; ?>
    <link rel="icon" type="image/svg+xml" href="<?php echo esc_url(get_template_directory_uri() . '/assets/images/favicon.svg?v=' . $asset_ver); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/images/favicon.ico?v=' . $asset_ver); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url(get_template_directory_uri() . '/assets/images/favicon-32x32.png?v=' . $asset_ver); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo esc_url(get_template_directory_uri() . '/assets/images/favicon-16x16.png?v=' . $asset_ver); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url(get_template_directory_uri() . '/assets/images/apple-touch-icon.png?v=' . $asset_ver); ?>">

    <!-- Preload self-hosted fonts -->
    <link rel="preload" href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/fonts/inter-400-latin.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/fonts/outfit-700-latin.woff2" as="font" type="font/woff2" crossorigin>

    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo esc_attr($page_og_title); ?>">
    <meta property="og:description" content="<?php echo esc_attr($page_description); ?>">
    <meta property="og:url" content="<?php echo esc_url($canonical_url ? $canonical_url : home_url('/')); ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="CacheWarmer">
    <!-- OG Image: landscape (primary) -->
    <meta property="og:image" content="<?php echo esc_url($og_image_landscape); ?>">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="<?php echo esc_attr($page_og_title); ?> - CacheWarmer">
    <!-- OG Image: square -->
    <meta property="og:image" content="<?php echo esc_url($og_image_square); ?>">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="1200">
    <meta property="og:image:alt" content="CacheWarmer icon">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?php echo esc_url($canonical_url ? $canonical_url : home_url('/')); ?>">
    <meta name="twitter:title" content="<?php echo esc_attr($page_og_title); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr($page_description); ?>">
    <meta name="twitter:image" content="<?php echo esc_url($og_image_landscape); ?>">
    <meta name="twitter:image:alt" content="<?php echo esc_attr($page_og_title); ?> - CacheWarmer">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <a href="#main-content" class="skip-link" title="Skip to main content">Skip to content</a>

    <header class="header" id="site-header">
        <div class="header-inner container">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="header-logo" title="CacheWarmer - Cache Warming for WordPress, Drupal &amp; Node.js">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.svg?v=' . $asset_ver); ?>" alt="CacheWarmer" class="header-logo-icon" width="36" height="36">
                <span class="header-logo-text">
                    <span class="header-logo-title">CacheWarmer</span>
                    <span class="header-logo-subtitle">for WordPress, Drupal &amp; NodeJS</span>
                </span>
            </a>

            <nav class="nav-desktop" aria-label="Main navigation">
                <a href="<?php echo esc_url(home_url('/features/')); ?>" class="nav-link <?php echo $current_page === 'features' ? 'nav-link-active' : ''; ?>" title="CacheWarmer Features - CDN Warming, Social Media &amp; Search Engine Indexing">Features</a>
                <a href="<?php echo esc_url(home_url('/docs/')); ?>" class="nav-link <?php echo $current_page === 'docs' || $current_page === 'api-keys' ? 'nav-link-active' : ''; ?>" title="CacheWarmer Documentation - Installation, Configuration &amp; API Reference">Docs</a>
                <a href="<?php echo esc_url(home_url('/changelog/')); ?>" class="nav-link <?php echo $current_page === 'changelog' ? 'nav-link-active' : ''; ?>" title="CacheWarmer Changelog - Version History &amp; Release Notes">Changelog</a>
                <a href="<?php echo esc_url(home_url('/enterprise/')); ?>" class="nav-link <?php echo $current_page === 'enterprise' ? 'nav-link-active' : ''; ?>" title="CacheWarmer Enterprise - Multi-Site, White-Label &amp; Priority Support">Enterprise</a>

                <div class="nav-dropdown">
                    <button class="nav-link nav-dropdown-toggle <?php echo $is_platform_page ? 'nav-link-active' : ''; ?>" aria-expanded="false" aria-haspopup="true">
                        Platforms <?php cachewarmer_icon('chevron-down', 'nav-dropdown-chevron', 14); ?>
                    </button>
                    <div class="nav-dropdown-menu" role="menu">
                        <a href="<?php echo esc_url(home_url('/wordpress/')); ?>" class="nav-dropdown-item <?php echo $current_page === 'wordpress' ? 'nav-dropdown-item-active' : ''; ?>" role="menuitem" title="CacheWarmer WordPress Plugin - Automated Cache Warming for WordPress">
                            <?php cachewarmer_icon('wordpress', '', 18); ?> WordPress Plugin
                        </a>
                        <a href="<?php echo esc_url(home_url('/drupal/')); ?>" class="nav-dropdown-item <?php echo $current_page === 'drupal' ? 'nav-dropdown-item-active' : ''; ?>" role="menuitem" title="CacheWarmer Drupal Module - Automated Cache Warming for Drupal">
                            <?php cachewarmer_icon('drupal', '', 18); ?> Drupal Module
                        </a>
                        <a href="<?php echo esc_url(home_url('/self-hosted/')); ?>" class="nav-dropdown-item <?php echo $current_page === 'self-hosted' ? 'nav-dropdown-item-active' : ''; ?>" role="menuitem" title="CacheWarmer Self-Hosted - Deploy with Docker &amp; Node.js">
                            <?php cachewarmer_icon('server', '', 18); ?> Self-Hosted (Node.js)
                        </a>
                    </div>
                </div>

                <div class="nav-dropdown">
                    <button class="nav-link nav-dropdown-toggle" aria-expanded="false" aria-haspopup="true">
                        Get Started <?php cachewarmer_icon('chevron-down', 'nav-dropdown-chevron', 14); ?>
                    </button>
                    <div class="nav-dropdown-menu" role="menu">
                        <a href="<?php echo esc_url(home_url('/docs/')); ?>" class="nav-dropdown-item" role="menuitem" title="CacheWarmer Quick Start Guide">
                            <?php cachewarmer_icon('book', '', 18); ?> Quick Start Guide
                        </a>
                        <a href="<?php echo esc_url(home_url('/api-keys/')); ?>" class="nav-dropdown-item" role="menuitem" title="CacheWarmer API Keys Setup Guide">
                            <?php cachewarmer_icon('key', '', 18); ?> API Keys Setup
                        </a>
                    </div>
                </div>
            </nav>

            <div class="header-actions">
                <a href="<?php echo esc_url(home_url('/pricing/')); ?>" class="nav-link nav-link-icon <?php echo $current_page === 'pricing' ? 'nav-link-active' : ''; ?>" aria-label="Pricing" title="CacheWarmer Pricing - Free, Premium &amp; Enterprise Plans">
                    <?php cachewarmer_icon('shopping-cart', '', 20); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/pricing/')); ?>" class="btn btn-accent btn-sm" title="Get CacheWarmer Pro - Premium Cache Warming Features">Get Pro</a>
            </div>

            <button class="mobile-menu-toggle" aria-label="Toggle menu" aria-expanded="false">
                <?php cachewarmer_icon('menu', '', 24); ?>
            </button>
        </div>

        <div class="mobile-menu" id="mobile-menu" hidden>
            <nav class="mobile-menu-nav" aria-label="Mobile navigation">
                <a href="<?php echo esc_url(home_url('/features/')); ?>" class="nav-link <?php echo $current_page === 'features' ? 'nav-link-active' : ''; ?>" title="CacheWarmer Features - CDN Warming, Social Media &amp; Search Engine Indexing">Features</a>
                <a href="<?php echo esc_url(home_url('/docs/')); ?>" class="nav-link <?php echo $current_page === 'docs' ? 'nav-link-active' : ''; ?>" title="CacheWarmer Documentation - Installation, Configuration &amp; API Reference">Docs</a>
                <a href="<?php echo esc_url(home_url('/changelog/')); ?>" class="nav-link <?php echo $current_page === 'changelog' ? 'nav-link-active' : ''; ?>" title="CacheWarmer Changelog - Version History &amp; Release Notes">Changelog</a>
                <a href="<?php echo esc_url(home_url('/enterprise/')); ?>" class="nav-link <?php echo $current_page === 'enterprise' ? 'nav-link-active' : ''; ?>" title="CacheWarmer Enterprise - Multi-Site, White-Label &amp; Priority Support">Enterprise</a>

                <div class="mobile-nav-group">
                    <span class="mobile-nav-group-title">Platforms</span>
                    <a href="<?php echo esc_url(home_url('/wordpress/')); ?>" class="nav-link <?php echo $current_page === 'wordpress' ? 'nav-link-active' : ''; ?>" title="CacheWarmer WordPress Plugin - Automated Cache Warming for WordPress">
                        <?php cachewarmer_icon('wordpress', '', 18); ?> WordPress Plugin
                    </a>
                    <a href="<?php echo esc_url(home_url('/drupal/')); ?>" class="nav-link <?php echo $current_page === 'drupal' ? 'nav-link-active' : ''; ?>" title="CacheWarmer Drupal Module - Automated Cache Warming for Drupal">
                        <?php cachewarmer_icon('drupal', '', 18); ?> Drupal Module
                    </a>
                    <a href="<?php echo esc_url(home_url('/self-hosted/')); ?>" class="nav-link <?php echo $current_page === 'self-hosted' ? 'nav-link-active' : ''; ?>" title="CacheWarmer Self-Hosted - Deploy with Docker &amp; Node.js">
                        <?php cachewarmer_icon('server', '', 18); ?> Self-Hosted (Node.js)
                    </a>
                </div>

                <div class="mobile-nav-group">
                    <span class="mobile-nav-group-title">Get Started</span>
                    <a href="<?php echo esc_url(home_url('/docs/')); ?>" class="nav-link" title="CacheWarmer Quick Start Guide">
                        <?php cachewarmer_icon('book', '', 18); ?> Quick Start Guide
                    </a>
                    <a href="<?php echo esc_url(home_url('/api-keys/')); ?>" class="nav-link" title="CacheWarmer API Keys Setup Guide">
                        <?php cachewarmer_icon('key', '', 18); ?> API Keys Setup
                    </a>
                </div>

                <a href="<?php echo esc_url(home_url('/pricing/')); ?>" class="nav-link <?php echo $current_page === 'pricing' ? 'nav-link-active' : ''; ?>" title="CacheWarmer Pricing - Free, Premium &amp; Enterprise Plans">
                    <?php cachewarmer_icon('shopping-cart', '', 18); ?> Pricing
                </a>
                <a href="<?php echo esc_url(home_url('/pricing/')); ?>" class="btn btn-accent w-full" title="Get CacheWarmer Pro - Premium Cache Warming Features">Get Pro</a>
            </nav>
        </div>
    </header>

    <main id="main-content">
