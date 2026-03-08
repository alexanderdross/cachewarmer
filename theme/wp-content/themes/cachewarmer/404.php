<?php
/**
 * 404 Error Page Template
 */
$page_og_title = 'Page Not Found - CacheWarmer';
$page_description = 'The page you are looking for does not exist or has been moved.';
get_header();
?>

<div class="error-page">
    <div class="container text-center">
        <div class="error-code">404</div>
        <h1 class="mb-4">Page Not Found</h1>
        <p class="text-muted-foreground mb-8 text-lg">The page you are looking for does not exist or has been moved.</p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary btn-lg" title="CacheWarmer Homepage - Cache Warming for WordPress, Drupal &amp; Node.js">
            <?php cachewarmer_icon('arrow-right', '', 20); ?> Back to Homepage
        </a>
    </div>
</div>

<?php get_footer(); ?>
