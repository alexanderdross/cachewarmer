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
				<h2 class="sf-card__title"><a href="/docs/getting-started/" title="SearchForge Getting Started Guide — Installation, License & First Sync">Getting Started</a></h3>
				<p class="sf-card__desc">Install the plugin, activate your license, and export your first AI-ready SEO brief in under 10 minutes.</p>
				<ul style="list-style: none; margin-top: var(--space-md);">
					<li style="padding: var(--space-xs) 0;"><a href="/docs/getting-started/#installation" title="SearchForge Installation — WordPress Plugin Setup">Installation</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/getting-started/#license-activation" title="Activate Your SearchForge License Key">License Activation</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/getting-started/#connecting-google-search-console" title="Connect Google Search Console to SearchForge via OAuth">Connecting Google Search Console</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/getting-started/#your-first-data-sync" title="Sync SEO Data from Google Search Console">Your First Data Sync</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/getting-started/#exporting-your-first-brief" title="Export Your First LLM-Ready Markdown Brief">Exporting Your First Brief</a></li>
				</ul>
			</div>

			<!-- Data Sources -->
			<div class="sf-card sf-card--bordered">
				<div class="sf-card__icon" aria-hidden="true">
					<img src="<?php echo esc_url( SF_THEME_URI ); ?>/assets/images/icons/layers.svg" alt="" width="24" height="24">
				</div>
				<h2 class="sf-card__title"><a href="/docs/data-sources/" title="SearchForge Data Sources — GSC, Bing, GA4, Trends, GBP & More">Data Sources</a></h3>
				<p class="sf-card__desc">Configure all 8 SEO data integrations: Google Search Console, Bing Webmaster, GA4, Keyword Planner, Trends, GBP, and Bing Places.</p>
				<ul style="list-style: none; margin-top: var(--space-md);">
					<li style="padding: var(--space-xs) 0;"><a href="/docs/data-sources/#google-search-console" title="Google Search Console Integration — Clicks, Impressions &amp; Rankings">Google Search Console</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/data-sources/#bing-webmaster-tools" title="Bing Webmaster Tools Integration — Bing-Specific Search Data">Bing Webmaster Tools</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/data-sources/#google-analytics-4" title="GA4 Integration — Bounce Rate, Engagement &amp; Conversions">Google Analytics 4</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/data-sources/#google-keyword-planner" title="Google Keyword Planner — Search Volume &amp; Competition Data">Google Keyword Planner</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/data-sources/#google-trends" title="Google Trends Integration — Seasonal Patterns &amp; Rising Queries">Google Trends</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/data-sources/#google-business-profile" title="Google Business Profile — Local SEO Discovery &amp; Actions">Google Business Profile</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/data-sources/#bing-places-for-business" title="Bing Places Integration — Local Search Data on Bing">Bing Places for Business</a></li>
				</ul>
			</div>

			<!-- Features -->
			<div class="sf-card sf-card--bordered">
				<div class="sf-card__icon" aria-hidden="true">
					<img src="<?php echo esc_url( SF_THEME_URI ); ?>/assets/images/icons/score.svg" alt="" width="24" height="24">
				</div>
				<h2 class="sf-card__title"><a href="/docs/features/" title="SearchForge Features — Score, AI Visibility, Competitors & Clustering">Features</a></h3>
				<p class="sf-card__desc">Analysis and intelligence tools: SearchForge Score, AI visibility tracking, competitor intelligence, content briefs, and keyword clustering.</p>
				<ul style="list-style: none; margin-top: var(--space-md);">
					<li style="padding: var(--space-xs) 0;"><a href="/docs/features/#searchforge-score" title="SearchForge Score — Proprietary 0–100 SEO Health Metric">SearchForge Score</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/features/#ai-visibility-monitor" title="AI Visibility Monitor — Track Citations in ChatGPT &amp; Google AI">AI Visibility Monitor</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/features/#competitor-intelligence" title="Competitor SERP Intelligence — Rankings &amp; Content Gaps">Competitor Intelligence</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/features/#ai-content-briefs" title="AI Content Briefs — LLM-Generated SEO Recommendations">AI Content Briefs</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/features/#keyword-clustering" title="Keyword Clustering — Automatic Topic Grouping">Keyword Clustering</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/features/#cannibalization-detection" title="Keyword Cannibalization — Detect Competing Pages">Cannibalization Detection</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/features/#alerts-monitoring" title="SEO Alerts — Ranking Drops, Content Decay &amp; More">Alerts &amp; Monitoring</a></li>
				</ul>
			</div>

			<!-- Export & Output -->
			<div class="sf-card sf-card--bordered">
				<div class="sf-card__icon" aria-hidden="true">
					<img src="<?php echo esc_url( SF_THEME_URI ); ?>/assets/images/icons/export.svg" alt="" width="24" height="24">
				</div>
				<h2 class="sf-card__title"><a href="/docs/export-output/" title="SearchForge Export — Markdown Briefs, llms.txt, ZIP & Scheduled Reports">Export &amp; Output</a></h3>
				<p class="sf-card__desc">Export SEO data as LLM-ready markdown briefs, llms.txt files, bulk ZIP archives, and automated scheduled reports.</p>
				<ul style="list-style: none; margin-top: var(--space-md);">
					<li style="padding: var(--space-xs) 0;"><a href="/docs/export-output/#markdown-briefs" title="Markdown Brief Export — Per-Page LLM-Ready Documents">Markdown Briefs</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/export-output/#combined-master-brief" title="Combined Master Brief — All Sources in One Document">Combined Master Brief</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/export-output/#llms-txt-generation" title="llms.txt Auto-Generation — AI Crawler Discoverability">llms.txt Generation</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/export-output/#zip-bulk-export" title="ZIP Bulk Export — Download All Briefs as Archive">ZIP Bulk Export</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/export-output/#scheduled-exports" title="Scheduled Exports — Automated Email, Cloud &amp; Git Delivery">Scheduled Exports</a></li>
				</ul>
			</div>

			<!-- Developer -->
			<div class="sf-card sf-card--bordered">
				<div class="sf-card__icon" aria-hidden="true">
					<img src="<?php echo esc_url( SF_THEME_URI ); ?>/assets/images/icons/markdown.svg" alt="" width="24" height="24">
				</div>
				<h2 class="sf-card__title"><a href="/docs/developer/" title="SearchForge Developer Docs — REST API, WP-CLI, Hooks & Webhooks">Developer</a></h3>
				<p class="sf-card__desc">REST API reference, WP-CLI commands, WordPress actions and filters, API key authentication, and webhook event subscriptions.</p>
				<ul style="list-style: none; margin-top: var(--space-md);">
					<li style="padding: var(--space-xs) 0;"><a href="/docs/developer/#rest-api-reference" title="SearchForge REST API — Endpoints, Access Levels &amp; Examples">REST API Reference</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/developer/#wp-cli-commands" title="WP-CLI Commands — Terminal Access to SearchForge Data">WP-CLI Commands</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/developer/#actions-filters" title="WordPress Hooks — Actions &amp; Filters for Extending SearchForge">Actions &amp; Filters</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/developer/#api-key-authentication" title="API Key Auth — Static Key Authentication for REST API">API Key Authentication</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/developer/#webhook-events" title="Webhook Events — HTTP Callbacks for CI/CD &amp; Automation">Webhook Events</a></li>
				</ul>
			</div>

			<!-- Integrations -->
			<div class="sf-card sf-card--bordered">
				<div class="sf-card__icon" aria-hidden="true">
					<img src="<?php echo esc_url( SF_THEME_URI ); ?>/assets/images/icons/clustering.svg" alt="" width="24" height="24">
				</div>
				<h2 class="sf-card__title"><a href="/docs/integrations/" title="SearchForge Integrations — Yoast, Rank Math, CacheWarmer, GitHub & More">Integrations</a></h3>
				<p class="sf-card__desc">Works with Yoast SEO, Rank Math, AIOSEO, CacheWarmer, GitHub, GitLab, Notion, and Google Sheets.</p>
				<ul style="list-style: none; margin-top: var(--space-md);">
					<li style="padding: var(--space-xs) 0;"><a href="/docs/integrations/#yoast-seo" title="Yoast SEO Integration — Import Focus Keywords &amp; Metadata">Yoast SEO</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/integrations/#rank-math" title="Rank Math Integration — SEO Score &amp; Schema Data">Rank Math</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/integrations/#aioseo" title="AIOSEO Integration — TruSEO Score &amp; Meta Import">AIOSEO</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/integrations/#cachewarmer" title="CacheWarmer Integration — Auto-Trigger Cache Warming">CacheWarmer</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/integrations/#github-gitlab" title="GitHub &amp; GitLab Push — Version-Controlled SEO Briefs">GitHub &amp; GitLab</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/integrations/#notion-export" title="Notion Export — Sync SEO Data to Notion Databases">Notion Export</a></li>
					<li style="padding: var(--space-xs) 0;"><a href="/docs/integrations/#google-sheets" title="Google Sheets Sync — Export Metrics to Spreadsheets">Google Sheets</a></li>
				</ul>
			</div>

		</div>
	</div>
</section>

<?php
get_footer();
