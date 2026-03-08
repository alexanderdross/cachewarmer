<?php
/**
 * Default template fallback.
 */
$page_og_title = 'CacheWarmer';
$page_description = 'CacheWarmer - Self-hosted microservice for CDN cache warming, social media cache updates, and search engine indexing.';
get_header();
?>

<div class="section">
    <div class="container text-center">
        <h1>Page</h1>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="docs-content">
                <?php the_content(); ?>
            </div>
        <?php endwhile; endif; ?>
    </div>
</div>

<?php get_footer(); ?>
