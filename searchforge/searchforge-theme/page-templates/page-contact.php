<?php
/**
 * Template Name: Contact
 *
 * @package SearchForge_Theme
 */

get_header();
?>

<section class="sf-section sf-section--dark sf-hero" style="padding: var(--space-3xl) 0;">
	<div class="sf-container" style="text-align: center;">
		<h1><span class="sf-gradient-text">Contact Us</span></h1>
		<p class="sf-text--inverse-muted" style="font-size: 1.25rem;">
			Questions about SearchForge? We&rsquo;re here to help.
		</p>
	</div>
</section>

<section class="sf-section">
	<div class="sf-container sf-container--narrow">
		<div class="sf-grid sf-grid--2">
			<div>
				<h2>Get in Touch</h2>
				<p style="margin-top: var(--space-md); color: var(--sf-text-muted); line-height: 1.8;">
					Whether you have a technical question, need help with your license, or want to discuss Enterprise pricing, we&rsquo;re happy to help.
				</p>

				<div style="margin-top: var(--space-2xl);">
					<h3>General Support</h3>
					<p><a href="mailto:support@drossmedia.de">support@drossmedia.de</a></p>
					<p class="sf-text--muted" style="font-size: 0.875rem;">Response time: within 48 hours (24 hours for Enterprise).</p>
				</div>

				<div style="margin-top: var(--space-xl);">
					<h3>Sales &amp; Enterprise</h3>
					<p><a href="mailto:sales@drossmedia.de">sales@drossmedia.de</a></p>
					<p class="sf-text--muted" style="font-size: 0.875rem;">Volume licensing, custom plans, and partnership inquiries.</p>
				</div>

				<div style="margin-top: var(--space-xl);">
					<h3>Bug Reports &amp; Feature Requests</h3>
					<p><a href="https://github.com/drossmedia/searchforge/issues" target="_blank" rel="noopener">GitHub Issues</a></p>
					<p class="sf-text--muted" style="font-size: 0.875rem;">Report bugs or suggest features on our public issue tracker.</p>
				</div>
			</div>

			<div>
				<h2>Company Details</h2>
				<div style="margin-top: var(--space-md); line-height: 2;">
					<p><strong>Dross:Media GmbH</strong></p>
					<p>Stuttgart, Germany</p>
					<p>
						Web: <a href="https://drossmedia.de" target="_blank" rel="noopener">drossmedia.de</a><br>
						SearchForge: <a href="https://searchforge.drossmedia.de">searchforge.drossmedia.de</a><br>
						CacheWarmer: <a href="https://cachewarmer.drossmedia.de" target="_blank" rel="noopener">cachewarmer.drossmedia.de</a>
					</p>
				</div>

				<div style="margin-top: var(--space-2xl);">
					<h3>Office Hours</h3>
					<p class="sf-text--muted">
						Monday&ndash;Friday, 9:00&ndash;17:00 CET<br>
						Email support available outside office hours.
					</p>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
