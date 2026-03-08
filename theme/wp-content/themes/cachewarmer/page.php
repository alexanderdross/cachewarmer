<?php
/**
 * Default page template.
 * Used for pages that don't have a specific template (e.g., Imprint, Privacy).
 */
$page_og_title = get_the_title() . ' - CacheWarmer';
$page_description = wp_trim_words(get_the_excerpt(), 25, '...');
get_header();
?>

<section class="page-hero">
    <div class="container">
        <h1><?php the_title(); ?></h1>
    </div>
</section>

<section class="section section-white">
    <div class="container max-w-4xl mx-auto">
        <div class="docs-content">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
