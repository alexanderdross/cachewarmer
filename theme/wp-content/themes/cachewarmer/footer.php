    </main>

    <footer class="footer">
        <div class="footer-inner container">
            <div class="footer-grid footer-grid-4">
                <!-- Column 1: Logo & Description -->
                <div class="footer-col footer-col-brand">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo" title="CacheWarmer - Cache Warming for WordPress, Drupal &amp; Node.js">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.svg?v=1.9.0'); ?>" alt="CacheWarmer" class="footer-logo-icon" width="32" height="32">
                        <span class="header-logo-text">
                            <span class="header-logo-title">CacheWarmer</span>
                            <span class="header-logo-subtitle">for WordPress, Drupal &amp; NodeJS</span>
                        </span>
                    </a>
                    <p>Cache warming for WordPress, Drupal, and Node.js. Warm CDN caches, update social media previews, and notify search engines automatically.</p>
                    <div class="footer-badges">
                        <a href="<?php echo esc_url(home_url('/docs/')); ?>" class="btn btn-outline btn-sm" title="CacheWarmer Documentation - Get Started">
                            <?php cachewarmer_icon('book', '', 16); ?> Documentation
                        </a>
                    </div>
                </div>

                <!-- Column 2: Platforms -->
                <div class="footer-col">
                    <h2 class="footer-col-title">Platforms</h2>
                    <ul class="footer-links">
                        <li><a href="<?php echo esc_url(home_url('/wordpress/')); ?>" title="CacheWarmer WordPress Plugin - Automated Cache Warming for WordPress">WordPress Plugin</a></li>
                        <li><a href="<?php echo esc_url(home_url('/drupal/')); ?>" title="CacheWarmer Drupal Module - Automated Cache Warming for Drupal">Drupal Module</a></li>
                        <li><a href="<?php echo esc_url(home_url('/self-hosted/')); ?>" title="CacheWarmer Self-Hosted - Deploy with Docker &amp; Node.js">Self-Hosted (Node.js)</a></li>
                    </ul>
                </div>

                <!-- Column 3: Resources -->
                <div class="footer-col">
                    <h2 class="footer-col-title">Resources</h2>
                    <ul class="footer-links">
                        <li><a href="<?php echo esc_url(home_url('/features/')); ?>" title="CacheWarmer Features - CDN Warming, Social Media &amp; Search Engine Indexing">Features</a></li>
                        <li><a href="<?php echo esc_url(home_url('/docs/')); ?>" title="CacheWarmer Documentation - Installation, Configuration &amp; API Reference">Documentation</a></li>
                        <li><a href="<?php echo esc_url(home_url('/api-keys/')); ?>" title="CacheWarmer API Keys Setup - Facebook, LinkedIn, Google &amp; Bing">API Keys Setup</a></li>
                        <li><a href="<?php echo esc_url(home_url('/pricing/')); ?>" title="CacheWarmer Pricing - Free, Premium &amp; Enterprise Plans">Pricing</a></li>
                        <li><a href="<?php echo esc_url(home_url('/enterprise/')); ?>" title="CacheWarmer Enterprise - Multi-Site, White-Label &amp; Priority Support">Enterprise</a></li>
                        <li><a href="<?php echo esc_url(home_url('/changelog/')); ?>" title="CacheWarmer Changelog - Version History &amp; Release Notes">Changelog</a></li>
                    </ul>
                </div>

                <!-- Column 4: Warming Targets -->
                <div class="footer-col">
                    <h2 class="footer-col-title">Warming Targets</h2>
                    <ul class="footer-links">
                        <li><a href="<?php echo esc_url(home_url('/features/#cdn-cache-warming')); ?>" title="CDN Cache Warming - Warm Your CDN &amp; Reverse Proxy Caches">CDN Cache Warming</a></li>
                        <li><a href="<?php echo esc_url(home_url('/features/#facebook')); ?>" title="Facebook Cache Warming - Update Open Graph Previews Automatically">Facebook</a></li>
                        <li><a href="<?php echo esc_url(home_url('/features/#linkedin')); ?>" title="LinkedIn Cache Warming - Refresh LinkedIn Post Previews">LinkedIn</a></li>
                        <li><a href="<?php echo esc_url(home_url('/features/#twitter')); ?>" title="Twitter/X Cache Warming - Update Twitter Card Previews">Twitter/X</a></li>
                        <li><a href="<?php echo esc_url(home_url('/features/#indexnow')); ?>" title="IndexNow Protocol - Instant Search Engine Notification">IndexNow</a></li>
                        <li><a href="<?php echo esc_url(home_url('/features/#google')); ?>" title="Google Search Console - Submit URLs for Indexing">Google</a></li>
                        <li><a href="<?php echo esc_url(home_url('/features/#bing')); ?>" title="Bing Webmaster Tools - Submit URLs to Bing for Indexing">Bing</a></li>
                        <li><a href="<?php echo esc_url(home_url('/features/#pinterest')); ?>" title="Pinterest Rich Pin Validator - Refresh Rich Pin Previews">Pinterest</a></li>
                        <li><a href="<?php echo esc_url(home_url('/features/#cloudflare')); ?>" title="Cloudflare Cache Purge + Warm - Enterprise">Cloudflare</a></li>
                        <li><a href="<?php echo esc_url(home_url('/features/#imperva')); ?>" title="Imperva Cache Purge + Warm - Enterprise">Imperva</a></li>
                        <li><a href="<?php echo esc_url(home_url('/features/#akamai')); ?>" title="Akamai Cache Purge + Warm - Enterprise">Akamai</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container flex justify-between items-center">
                <p>&copy; <?php echo esc_html(wp_date('Y')); ?> CacheWarmer. All rights reserved.</p>
                <div class="footer-bottom-links">
                    <a href="https://dross.net/imprint" target="_blank" rel="noopener" title="Imprint - Legal Information">Imprint</a>
                    <a href="https://dross.net/privacy-policy" target="_blank" rel="noopener" title="Privacy Policy - Data Protection Information">Privacy Policy</a>
                    <a href="https://dross.net/contact/?topic=cachewarmer" target="_blank" rel="noopener" title="Contact Dross:Media">Contact</a>
                </div>
                <p class="footer-credit">Made with <span class="footer-heart">&hearts;</span> by <a href="https://dross.net/" target="_blank" rel="noopener" title="Dross:Media - Web Development &amp; Digital Services">Dross:Media</a></p>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>
