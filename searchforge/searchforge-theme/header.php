<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/svg+xml" href="<?php echo esc_url( SF_THEME_URI ); ?>/assets/images/logo-mark.svg">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content">
	<?php esc_html_e( 'Skip to content', 'searchforge-theme' ); ?>
</a>

<header class="sf-header" role="banner">
	<div class="sf-container sf-header__inner">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="sf-header__logo" title="SearchForge — LLM-Ready SEO Data Plugin for WordPress" aria-label="<?php esc_attr_e( 'SearchForge Home', 'searchforge-theme' ); ?>">
			<img class="sf-header__logo-icon" src="<?php echo esc_url( SF_THEME_URI ); ?>/assets/images/logo-mark.svg" alt="" width="40" height="40" aria-hidden="true">
			<span class="sf-header__logo-text"><span class="sf-header__logo-search">Search</span>Forge</span>
		</a>

		<nav class="sf-header__nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'searchforge-theme' ); ?>">
			<?php
			wp_nav_menu( [
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'sf-nav-list',
				'depth'          => 2,
				'fallback_cb'    => 'sf_default_nav',
			] );
			?>
		</nav>

		<div class="sf-header__actions">
			<a href="/pricing/" class="sf-btn sf-btn--primary sf-btn--sm" title="SearchForge Pro — Full SEO Intelligence from €99/yr">Get Pro</a>
		</div>

		<button class="sf-header__toggle" aria-expanded="false" aria-controls="sf-mobile-menu" aria-label="<?php esc_attr_e( 'Toggle navigation', 'searchforge-theme' ); ?>">
			<span class="sf-hamburger"></span>
		</button>
	</div>

	<div id="sf-mobile-menu" class="sf-mobile-menu" hidden>
		<?php
		wp_nav_menu( [
			'theme_location' => 'primary',
			'container'      => false,
			'menu_class'     => 'sf-mobile-nav-list',
			'depth'          => 1,
		] );
		?>
		<a href="/pricing/" class="sf-btn sf-btn--primary sf-btn--block" title="SearchForge Pro — Full SEO Intelligence from €99/yr">Get Pro</a>
	</div>
</header>

<?php get_template_part( 'template-parts/breadcrumb' ); ?>

<main id="main-content" role="main">
<?php

/**
 * Default navigation fallback.
 */
function sf_default_nav(): void {
	echo '<ul class="sf-nav-list">';
	echo '<li><a href="/features/" title="SearchForge Features — Score, AI Briefs, Clustering &amp; More">Features</a></li>';
	echo '<li><a href="/pricing/" title="SearchForge Pricing — Free, Pro, Agency &amp; Enterprise Plans">Pricing</a></li>';
	echo '<li><a href="/docs/" title="SearchForge Documentation — Guides, API Reference &amp; Integrations">Docs</a></li>';
	echo '<li><a href="/changelog/" title="SearchForge Changelog — Latest Updates &amp; Release Notes">Changelog</a></li>';
	echo '<li><a href="/enterprise/" title="SearchForge Enterprise — Unlimited Sites, Priority Support &amp; Audit Log">Enterprise</a></li>';
	echo '</ul>';
}
