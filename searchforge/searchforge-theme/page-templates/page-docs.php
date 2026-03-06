<?php
/**
 * Template Name: Documentation
 *
 * @package SearchForge_Theme
 */

get_header();
?>

<section class="sf-section sf-section--dark sf-hero" style="padding: var(--space-3xl) 0;">
	<div class="sf-container" style="text-align: center;">
		<h1><span class="sf-gradient-text">Documentation</span></h1>
		<p class="sf-text--inverse-muted" style="font-size: 1.25rem;">
			Everything you need to install, configure, and get the most out of SearchForge.
		</p>
	</div>
</section>

<section class="sf-section">
	<div class="sf-container">
		<div class="sf-grid sf-grid--3">

			<!-- Getting Started -->
			<div class="sf-card sf-card--bordered">
				<div class="sf-card__icon" aria-hidden="true">
					<img src="<?php echo esc_url( SF_THEME_URI ); ?>/assets/images/icons/sync.svg" alt="" width="24" height="24">
				</div>
				<h3 class="sf-card__title">Getting Started</h3>
				<ul style="list-style: none; margin-top: var(--space-md);">
					<li style="padding: var(--space-xs) 0;"><a href="/docs/installation/">Installation</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/activation/">License Activation</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/gsc-setup/">Connecting Google Search Console</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/first-sync/">Your First Data Sync</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/first-brief/">Exporting Your First Brief</a></li>
				</ul>
			</div>

			<!-- Data Sources -->
			<div class="sf-card sf-card--bordered">
				<div class="sf-card__icon" aria-hidden="true">
					<img src="<?php echo esc_url( SF_THEME_URI ); ?>/assets/images/icons/layers.svg" alt="" width="24" height="24">
				</div>
				<h3 class="sf-card__title">Data Sources</h3>
				<ul style="list-style: none; margin-top: var(--space-md);">
					<li style="padding: var(--space-xs) 0;"><a href="/docs/gsc/">Google Search Console</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/bing/">Bing Webmaster Tools</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/ga4/">Google Analytics 4</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/kwp/">Google Keyword Planner</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/trends/">Google Trends</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/gbp/">Google Business Profile</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/bing-places/">Bing Places for Business</a></li>
				</ul>
			</div>

			<!-- Features -->
			<div class="sf-card sf-card--bordered">
				<div class="sf-card__icon" aria-hidden="true">
					<img src="<?php echo esc_url( SF_THEME_URI ); ?>/assets/images/icons/score.svg" alt="" width="24" height="24">
				</div>
				<h3 class="sf-card__title">Features</h3>
				<ul style="list-style: none; margin-top: var(--space-md);">
					<li style="padding: var(--space-xs) 0;"><a href="/docs/score/">SearchForge Score</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/aeo/">AI Visibility Monitor</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/competitors/">Competitor Intelligence</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/briefs/">AI Content Briefs</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/clustering/">Keyword Clustering</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/cannibalization/">Cannibalization Detection</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/alerts/">Alerts &amp; Monitoring</a></li>
				</ul>
			</div>

			<!-- Export & Output -->
			<div class="sf-card sf-card--bordered">
				<div class="sf-card__icon" aria-hidden="true">
					<img src="<?php echo esc_url( SF_THEME_URI ); ?>/assets/images/icons/export.svg" alt="" width="24" height="24">
				</div>
				<h3 class="sf-card__title">Export &amp; Output</h3>
				<ul style="list-style: none; margin-top: var(--space-md);">
					<li style="padding: var(--space-xs) 0;"><a href="/docs/markdown-export/">Markdown Briefs</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/master-brief/">Combined Master Brief</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/llms-txt/">llms.txt Generation</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/zip-export/">ZIP Bulk Export</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/scheduled-exports/">Scheduled Exports</a></li>
				</ul>
			</div>

			<!-- Developer -->
			<div class="sf-card sf-card--bordered">
				<div class="sf-card__icon" aria-hidden="true">
					<img src="<?php echo esc_url( SF_THEME_URI ); ?>/assets/images/icons/markdown.svg" alt="" width="24" height="24">
				</div>
				<h3 class="sf-card__title">Developer</h3>
				<ul style="list-style: none; margin-top: var(--space-md);">
					<li style="padding: var(--space-xs) 0;"><a href="/docs/rest-api/">REST API Reference</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/wp-cli/">WP-CLI Commands</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/hooks/">Actions &amp; Filters</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/api-keys/">API Key Authentication</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/webhooks/">Webhook Events</a></li>
				</ul>
			</div>

			<!-- Integrations -->
			<div class="sf-card sf-card--bordered">
				<div class="sf-card__icon" aria-hidden="true">
					<img src="<?php echo esc_url( SF_THEME_URI ); ?>/assets/images/icons/clustering.svg" alt="" width="24" height="24">
				</div>
				<h3 class="sf-card__title">Integrations</h3>
				<ul style="list-style: none; margin-top: var(--space-md);">
					<li style="padding: var(--space-xs) 0;"><a href="/docs/yoast/">Yoast SEO</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/rank-math/">Rank Math</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/aioseo/">AIOSEO</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/cachewarmer/">CacheWarmer</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/github/">GitHub / GitLab</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/notion/">Notion Export</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/sheets/">Google Sheets</a></li>
				</ul>
			</div>

		</div>
	</div>
</section>

<?php
get_footer();
