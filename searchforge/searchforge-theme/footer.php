</main>

<footer class="sf-footer" role="contentinfo">
	<div class="sf-container sf-footer__inner">
		<div class="sf-footer__brand">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="sf-footer__logo">
				<img src="<?php echo esc_url( SF_THEME_URI ); ?>/assets/images/logo-mark.svg" alt="" width="28" height="28">
				<span class="sf-footer__logo-text"><span class="sf-footer__logo-search">Search</span>Forge</span>
			</a>
			<p class="sf-footer__tagline">SEO data from 8 sources, turned into LLM-ready markdown briefs. Built for WordPress.</p>
		</div>

		<div class="sf-footer__columns">
			<div class="sf-footer__column">
				<h3>Resources</h3>
				<ul>
					<li><a href="/features/">Features</a></li>
					<li><a href="/pricing/">Pricing</a></li>
					<li><a href="/changelog/">Changelog</a></li>
					<li><a href="/enterprise/">Enterprise</a></li>
					<li><a href="https://dross.net/contact/?topic=searchforge">Contact</a></li>
				</ul>
			</div>
			<div class="sf-footer__column">
				<h3>Documentation</h3>
				<ul>
					<li><a href="/docs/getting-started/">Getting Started</a></li>
					<li><a href="/docs/developer/#rest-api-reference">REST API</a></li>
					<li><a href="/docs/developer/#wp-cli-commands">WP-CLI</a></li>
					<li><a href="/docs/developer/#actions-filters">Actions &amp; Filters</a></li>
				</ul>
			</div>
			<div class="sf-footer__column">
				<h3>Data Sources</h3>
				<ul>
					<li><a href="/docs/data-sources/#google-search-console">Google Search Console</a></li>
					<li><a href="/docs/data-sources/#bing-webmaster-tools">Bing Webmaster Tools</a></li>
					<li><a href="/docs/data-sources/#google-analytics-4">Google Analytics 4</a></li>
					<li><a href="/docs/data-sources/#google-trends">Google Trends</a></li>
					<li><a href="/docs/data-sources/#google-keyword-planner">Keyword Planner</a></li>
					<li><a href="/docs/data-sources/#google-business-profile">Business Profile</a></li>
				</ul>
			</div>
			<div class="sf-footer__column">
				<h3>Integrations</h3>
				<ul>
					<li><a href="/docs/integrations/#yoast-seo">Yoast SEO</a></li>
					<li><a href="/docs/integrations/#rank-math">Rank Math</a></li>
					<li><a href="/docs/integrations/#cachewarmer">CacheWarmer</a></li>
					<li><a href="/docs/integrations/#github-gitlab">GitHub Export</a></li>
					<li><a href="/docs/integrations/#notion-export">Notion Export</a></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="sf-footer__bottom">
		<div class="sf-container sf-footer__bottom-inner">
			<p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> SearchForge. All rights reserved.</p>
			<ul class="sf-footer__legal">
				<li><a href="https://dross.net/imprint/?ref=searchforge">Imprint</a></li>
				<li><a href="https://dross.net/privacy-policy/?ref=searchforge">Privacy Policy</a></li>
				<li><a href="https://dross.net/contact/?topic=searchforge">Contact</a></li>
			</ul>
			<p>Made with &hearts; by <a href="https://dross.net/?ref=searchforge">Dross:Media</a></p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
