<?php
/**
 * Template Name: Privacy Policy
 *
 * @package SearchForge_Theme
 */

get_header();
?>

<section class="sf-section sf-section--page">
	<div class="sf-container sf-container--narrow">
		<h1 class="sf-page-title">Privacy Policy</h1>

		<div class="sf-content">
			<p><em>Last updated: March 6, 2026</em></p>

			<h2>1. Overview</h2>
			<p>
				Dross:Media GmbH (&ldquo;we&rdquo;, &ldquo;us&rdquo;, or &ldquo;our&rdquo;) operates the SearchForge website at searchforge.drossmedia.de and the SearchForge WordPress plugin. This privacy policy explains how we collect, use, and protect your personal data.
			</p>

			<h2>2. Data Controller</h2>
			<p>
				Dross:Media GmbH<br>
				Stuttgart, Germany<br>
				Email: <a href="mailto:privacy@drossmedia.de">privacy@drossmedia.de</a>
			</p>

			<h2>3. Data We Collect</h2>

			<h3>3.1 Website Visits</h3>
			<p>When you visit searchforge.drossmedia.de, our web server automatically collects:</p>
			<ul>
				<li>IP address (anonymized after 7 days)</li>
				<li>Browser type and version</li>
				<li>Operating system</li>
				<li>Referrer URL</li>
				<li>Pages visited and time of access</li>
			</ul>
			<p>Legal basis: Art. 6 (1) (f) GDPR (legitimate interest in website security and optimization).</p>

			<h3>3.2 License Purchases</h3>
			<p>When you purchase a SearchForge license, we collect:</p>
			<ul>
				<li>Name and email address</li>
				<li>Billing address (for invoicing)</li>
				<li>Payment information (processed by Stripe; we do not store credit card numbers)</li>
			</ul>
			<p>Legal basis: Art. 6 (1) (b) GDPR (contract fulfillment).</p>

			<h3>3.3 SearchForge Plugin</h3>
			<p>The SearchForge WordPress plugin:</p>
			<ul>
				<li><strong>Does NOT send your SEO data to our servers.</strong> All Google Search Console, Bing, GA4, and other data is stored exclusively in your WordPress database.</li>
				<li>Makes license validation calls to our license server (license key, site domain, WordPress version, and plugin version).</li>
				<li>Sends a daily heartbeat for license status verification.</li>
			</ul>
			<p>Legal basis: Art. 6 (1) (b) GDPR (license validation as part of the service contract).</p>

			<h2>4. Third-Party Services</h2>

			<h3>4.1 Stripe (Payment Processing)</h3>
			<p>Payments are processed by Stripe, Inc. Stripe&rsquo;s privacy policy: <a href="https://stripe.com/privacy" target="_blank" rel="noopener">stripe.com/privacy</a></p>

			<h3>4.2 Google Fonts</h3>
			<p>This website uses Google Fonts for typography. Google may collect your IP address when loading fonts. Google&rsquo;s privacy policy: <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">policies.google.com/privacy</a></p>

			<h3>4.3 Cloudflare (CDN)</h3>
			<p>This website uses Cloudflare for content delivery and security. Cloudflare&rsquo;s privacy policy: <a href="https://cloudflare.com/privacypolicy/" target="_blank" rel="noopener">cloudflare.com/privacypolicy</a></p>

			<h2>5. Data Retention</h2>
			<ul>
				<li>Server logs: 7 days</li>
				<li>Customer data: Duration of the business relationship + legal retention periods (10 years for tax-relevant data)</li>
				<li>License validation logs: 90 days</li>
			</ul>

			<h2>6. Your Rights (GDPR)</h2>
			<p>You have the right to:</p>
			<ul>
				<li><strong>Access</strong> your personal data (Art. 15 GDPR)</li>
				<li><strong>Rectification</strong> of inaccurate data (Art. 16 GDPR)</li>
				<li><strong>Erasure</strong> of your data (Art. 17 GDPR)</li>
				<li><strong>Restriction</strong> of processing (Art. 18 GDPR)</li>
				<li><strong>Data portability</strong> (Art. 20 GDPR)</li>
				<li><strong>Object</strong> to processing (Art. 21 GDPR)</li>
				<li><strong>Withdraw consent</strong> at any time (Art. 7 (3) GDPR)</li>
			</ul>
			<p>To exercise these rights, contact: <a href="mailto:privacy@drossmedia.de">privacy@drossmedia.de</a></p>

			<h2>7. Cookies</h2>
			<p>
				This website uses only technically necessary cookies (session management, CSRF protection). We do not use tracking cookies, analytics cookies, or advertising cookies.
			</p>

			<h2>8. Data Security</h2>
			<p>
				We use SSL/TLS encryption for all data transmission. Access to personal data is restricted to authorized personnel. Regular security audits are performed.
			</p>

			<h2>9. Right to Lodge a Complaint</h2>
			<p>
				You have the right to lodge a complaint with a supervisory authority. The competent authority for Baden-W&uuml;rttemberg is:
			</p>
			<p>
				Der Landesbeauftragte f&uuml;r den Datenschutz und die Informationsfreiheit Baden-W&uuml;rttemberg<br>
				<a href="https://www.baden-wuerttemberg.datenschutz.de" target="_blank" rel="noopener">baden-wuerttemberg.datenschutz.de</a>
			</p>

			<h2>10. Changes to This Policy</h2>
			<p>
				We may update this privacy policy from time to time. The current version is always available at <a href="https://searchforge.drossmedia.de/privacy/">searchforge.drossmedia.de/privacy/</a>.
			</p>
		</div>
	</div>
</section>

<?php
get_footer();
