<?php
/**
 * Template Name: API Keys Setup
 * API Keys setup guide page template.
 */
$page_og_title = 'API Keys Setup - CacheWarmer';
$page_description = 'Step-by-step guides for configuring Facebook, LinkedIn, IndexNow, Google, Bing, Cloudflare, Imperva, and Akamai integrations.';
get_header();
cachewarmer_breadcrumb('API Keys Setup');
?>

<!-- Hero -->
<section class="page-hero">
    <div class="container">
        <h1>API Keys Setup Guide</h1>
        <p>Step-by-step instructions for configuring each integration.</p>
    </div>
</section>

<section class="section section-gray">
    <div class="container">

        <!-- Facebook -->
        <div class="guide-section" id="facebook">
            <div class="guide-section-header">
                <div class="guide-section-icon"><?php cachewarmer_icon('facebook'); ?></div>
                <div>
                    <h2>Facebook App ID &amp; App Secret</h2>
                    <p class="text-muted-foreground">Required for the Facebook Sharing Debugger module.</p>
                </div>
            </div>
            <div class="guide-steps">
                <div class="guide-step">
                    <div class="guide-step-num">1</div>
                    <div class="guide-step-content">
                        <p><strong>Open the Facebook Developers Portal.</strong> Go to <a href="https://developers.facebook.com?ref=cachewarmer" target="_blank" rel="noopener" title="Facebook Developers Portal - Create a Facebook App">developers.facebook.com</a> and sign in with your Facebook account.</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">2</div>
                    <div class="guide-step-content">
                        <p><strong>Create a new app.</strong> Click "My Apps" &rarr; "Create App". Select the "Business" app type. Enter a name (e.g., <code>CacheWarmer</code>) and create the app.</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">3</div>
                    <div class="guide-step-content">
                        <p><strong>Copy the App ID.</strong> After creation, you'll be redirected to the dashboard. The <strong>App ID</strong> is displayed at the top of the page.</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">4</div>
                    <div class="guide-step-content">
                        <p><strong>Copy the App Secret.</strong> Navigate to Settings &rarr; Basic. Click "Show" next to "App Secret" and confirm with your password. Copy the value.</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">5</div>
                    <div class="guide-step-content">
                        <p><strong>Configure in CacheWarmer.</strong> Enter the App ID and App Secret in your CacheWarmer settings. The access token is automatically composed as <code>app_id|app_secret</code>.</p>
                        <?php cachewarmer_code_block('facebook:
  enabled: true
  appId: "123456789012345"
  appSecret: "abc123def456ghi789jkl012mno345pq"
  rateLimitPerSecond: 10', 'config.yaml'); ?>
                    </div>
                </div>
            </div>
            <?php cachewarmer_callout('The app does not need to be published &mdash; the scrape endpoint works with an App Access Token. Rate limit: max 200 calls/hour per app.', 'info'); ?>
        </div>

        <!-- LinkedIn -->
        <div class="guide-section" id="linkedin">
            <div class="guide-section-header">
                <div class="guide-section-icon"><?php cachewarmer_icon('linkedin'); ?></div>
                <div>
                    <h2>LinkedIn Session / OAuth</h2>
                    <p class="text-muted-foreground">Required for the LinkedIn Post Inspector module.</p>
                </div>
            </div>
            <div class="guide-steps">
                <div class="guide-step">
                    <div class="guide-step-num">1</div>
                    <div class="guide-step-content">
                        <p><strong>Understand the options.</strong> LinkedIn offers two approaches: the Marketing API (OAuth 2.0 flow) for production use, or a session-based approach for personal/development use.</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">2</div>
                    <div class="guide-step-content">
                        <p><strong>Option A: LinkedIn Marketing API.</strong> Register an app at <a href="https://www.linkedin.com/developers/?ref=cachewarmer" target="_blank" rel="noopener" title="LinkedIn Developers - Register an App for OAuth">linkedin.com/developers</a>, configure OAuth 2.0, and obtain an access token through the authorization flow.</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">3</div>
                    <div class="guide-step-content">
                        <p><strong>Option B: Session-based approach.</strong> For personal use, you can extract the <code>li_at</code> session cookie from your browser's developer tools while logged into LinkedIn.</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">4</div>
                    <div class="guide-step-content">
                        <p><strong>Set the environment variable.</strong></p>
                        <?php cachewarmer_code_block('LINKEDIN_SESSION_COOKIE=your_li_at_cookie_value', 'Environment'); ?>
                    </div>
                </div>
            </div>
            <?php cachewarmer_callout('LinkedIn session cookies expire periodically. Monitor for authentication failures and refresh the cookie when needed. LinkedIn also has strict rate limits &mdash; CacheWarmer handles this automatically with configurable delays.', 'warning'); ?>
        </div>

        <!-- IndexNow -->
        <div class="guide-section" id="indexnow">
            <div class="guide-section-header">
                <div class="guide-section-icon"><?php cachewarmer_icon('zap'); ?></div>
                <div>
                    <h2>IndexNow Key</h2>
                    <p class="text-muted-foreground">Required for the IndexNow protocol module (Bing, Yandex, Seznam, Naver).</p>
                </div>
            </div>
            <div class="guide-steps">
                <div class="guide-step">
                    <div class="guide-step-num">1</div>
                    <div class="guide-step-content">
                        <p><strong>Generate a key.</strong> Create a 32-character hexadecimal key:</p>
                        <?php cachewarmer_code_block('openssl rand -hex 16', 'Bash'); ?>
                        <p>Example output: <code>a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6</code></p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">2</div>
                    <div class="guide-step-content">
                        <p><strong>Host the key file.</strong> Create a text file at your web root with the key as both the filename and content:</p>
                        <?php cachewarmer_code_block('# The file should be accessible at:
# https://yourdomain.com/a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6.txt
#
# The file content should be the key itself:
a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6', 'Text'); ?>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">3</div>
                    <div class="guide-step-content">
                        <p><strong>Set the environment variable.</strong></p>
                        <?php cachewarmer_code_block('INDEXNOW_KEY=a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6', 'Environment'); ?>
                    </div>
                </div>
            </div>
            <?php cachewarmer_callout('IndexNow is supported by Bing, Yandex, Seznam, and Naver. Google does not participate in IndexNow &mdash; use the Google Search Console API module instead.', 'info'); ?>
        </div>

        <!-- Google Search Console -->
        <div class="guide-section" id="google">
            <div class="guide-section-header">
                <div class="guide-section-icon"><?php cachewarmer_icon('search'); ?></div>
                <div>
                    <h2>Google Search Console Service Account</h2>
                    <p class="text-muted-foreground">Required for the Google Search Console API module.</p>
                </div>
            </div>
            <div class="guide-steps">
                <div class="guide-step">
                    <div class="guide-step-num">1</div>
                    <div class="guide-step-content">
                        <p><strong>Create a Google Cloud project.</strong> Go to <a href="https://console.cloud.google.com?ref=cachewarmer" target="_blank" rel="noopener" title="Google Cloud Console - Create a Project &amp; Service Account">console.cloud.google.com</a> and create a new project (or select an existing one).</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">2</div>
                    <div class="guide-step-content">
                        <p><strong>Enable the Search Console API.</strong> In the API Library, search for "Google Search Console API" and enable it for your project.</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">3</div>
                    <div class="guide-step-content">
                        <p><strong>Create a service account.</strong> Go to IAM &amp; Admin &gt; Service Accounts &gt; Create Service Account. Download the JSON key file.</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">4</div>
                    <div class="guide-step-content">
                        <p><strong>Add to Search Console.</strong> Copy the service account email (e.g., <code>cachewarmer@project.iam.gserviceaccount.com</code>) and add it as a user in <a href="https://search.google.com/search-console?ref=cachewarmer" target="_blank" rel="noopener" title="Google Search Console - Add Service Account as User">Google Search Console</a> with "Full" access for your property.</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">5</div>
                    <div class="guide-step-content">
                        <p><strong>Set the environment variable.</strong> Point to the JSON key file:</p>
                        <?php cachewarmer_code_block('GOOGLE_SERVICE_ACCOUNT_JSON=./config/google-service-account.json', 'Environment'); ?>
                    </div>
                </div>
            </div>
            <?php cachewarmer_callout('Google imposes a daily quota of 200 URL inspections per property. CacheWarmer manages this automatically, prioritizing new and recently updated URLs.', 'info'); ?>
        </div>

        <!-- Bing Webmaster Tools -->
        <div class="guide-section" id="bing">
            <div class="guide-section-header">
                <div class="guide-section-icon"><?php cachewarmer_icon('search'); ?></div>
                <div>
                    <h2>Bing Webmaster Tools API Key</h2>
                    <p class="text-muted-foreground">Required for the Bing Webmaster Tools API module.</p>
                </div>
            </div>
            <div class="guide-steps">
                <div class="guide-step">
                    <div class="guide-step-num">1</div>
                    <div class="guide-step-content">
                        <p><strong>Sign in to Bing Webmaster Tools.</strong> Go to <a href="https://www.bing.com/webmasters?ref=cachewarmer" target="_blank" rel="noopener" title="Bing Webmaster Tools - Get Your API Key">bing.com/webmasters</a> and sign in with your Microsoft account.</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">2</div>
                    <div class="guide-step-content">
                        <p><strong>Verify your site.</strong> Add and verify ownership of your website if you haven't already.</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">3</div>
                    <div class="guide-step-content">
                        <p><strong>Get your API key.</strong> Navigate to Settings &gt; API Access &gt; API Key. Copy the generated key.</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">4</div>
                    <div class="guide-step-content">
                        <p><strong>Set the environment variable.</strong></p>
                        <?php cachewarmer_code_block('BING_API_KEY=your_bing_api_key_here', 'Environment'); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cloudflare (Enterprise) -->
        <div class="guide-section" id="cloudflare">
            <div class="guide-section-header">
                <div class="guide-section-icon"><?php cachewarmer_icon('cloudflare'); ?></div>
                <div>
                    <h2>Cloudflare API Token <span class="badge badge-pro">Enterprise</span></h2>
                    <p class="text-muted-foreground">Required for the Cloudflare Cache Purge module.</p>
                </div>
            </div>
            <div class="guide-steps">
                <div class="guide-step">
                    <div class="guide-step-num">1</div>
                    <div class="guide-step-content">
                        <p><strong>Open the Cloudflare Dashboard.</strong> Go to <a href="https://dash.cloudflare.com/?ref=cachewarmer" target="_blank" rel="noopener" title="Cloudflare Dashboard">dash.cloudflare.com</a> and select your domain.</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">2</div>
                    <div class="guide-step-content">
                        <p><strong>Copy the Zone ID.</strong> On your domain overview page, find the <strong>Zone ID</strong> in the right sidebar under "API" (a 32-character hex string).</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">3</div>
                    <div class="guide-step-content">
                        <p><strong>Create an API Token.</strong> Go to My Profile &rarr; API Tokens &rarr; "Create Token". Choose "Custom Token" with permissions: <strong>Zone &rarr; Cache Purge &rarr; Purge</strong>. Restrict to your specific zone.</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">4</div>
                    <div class="guide-step-content">
                        <p><strong>Configure in CacheWarmer.</strong></p>
                        <?php cachewarmer_code_block('cloudflare:
  enabled: true
  apiToken: "YOUR_CLOUDFLARE_API_TOKEN"
  zoneId: "YOUR_ZONE_ID"', 'config.yaml'); ?>
                    </div>
                </div>
            </div>
            <?php cachewarmer_callout('The token only needs Cache Purge permission &mdash; no other rights required. Cloudflare allows up to 30 URLs per purge request.', 'info'); ?>
        </div>

        <!-- Imperva (Enterprise) -->
        <div class="guide-section" id="imperva">
            <div class="guide-section-header">
                <div class="guide-section-icon"><?php cachewarmer_icon('imperva'); ?></div>
                <div>
                    <h2>Imperva API Credentials <span class="badge badge-pro">Enterprise</span></h2>
                    <p class="text-muted-foreground">Required for the Imperva Cache Purge module.</p>
                </div>
            </div>
            <div class="guide-steps">
                <div class="guide-step">
                    <div class="guide-step-num">1</div>
                    <div class="guide-step-content">
                        <p><strong>Open the Imperva Console.</strong> Go to <a href="https://my.imperva.com/?ref=cachewarmer" target="_blank" rel="noopener" title="Imperva Management Console">my.imperva.com</a> and sign in.</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">2</div>
                    <div class="guide-step-content">
                        <p><strong>Get your API ID and API Key.</strong> Go to Account Settings &rarr; API Keys. If no key exists, click "Add API Key". Copy both the <strong>API ID</strong> (numeric) and <strong>API Key</strong> (alphanumeric).</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">3</div>
                    <div class="guide-step-content">
                        <p><strong>Find your Site ID.</strong> Go to Websites &rarr; select your site. The <strong>Site ID</strong> is a numeric value found in the URL or under Settings &rarr; General.</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">4</div>
                    <div class="guide-step-content">
                        <p><strong>Configure in CacheWarmer.</strong></p>
                        <?php cachewarmer_code_block('imperva:
  enabled: true
  apiId: "YOUR_IMPERVA_API_ID"
  apiKey: "YOUR_IMPERVA_API_KEY"
  siteId: "YOUR_SITE_ID"', 'config.yaml'); ?>
                    </div>
                </div>
            </div>
            <?php cachewarmer_callout('Imperva uses api_id + api_key in the request body for authentication. Purge propagation is typically under 500ms across the Imperva network.', 'info'); ?>
        </div>

        <!-- Akamai (Enterprise) -->
        <div class="guide-section" id="akamai">
            <div class="guide-section-header">
                <div class="guide-section-icon"><?php cachewarmer_icon('akamai'); ?></div>
                <div>
                    <h2>Akamai EdgeGrid Credentials <span class="badge badge-pro">Enterprise</span></h2>
                    <p class="text-muted-foreground">Required for the Akamai Fast Purge module.</p>
                </div>
            </div>
            <div class="guide-steps">
                <div class="guide-step">
                    <div class="guide-step-num">1</div>
                    <div class="guide-step-content">
                        <p><strong>Open Akamai Control Center.</strong> Go to <a href="https://control.akamai.com/?ref=cachewarmer" target="_blank" rel="noopener" title="Akamai Control Center">control.akamai.com</a> and sign in.</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">2</div>
                    <div class="guide-step-content">
                        <p><strong>Create an API Client.</strong> Go to Identity &amp; Access &rarr; API Clients &rarr; "Create API Client". Select the <strong>CCU APIs</strong> (Content Control Utility) with <strong>READ-WRITE</strong> access.</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">3</div>
                    <div class="guide-step-content">
                        <p><strong>Copy all four credentials.</strong> After creation, immediately copy the <strong>Host</strong>, <strong>Client Token</strong>, <strong>Client Secret</strong>, and <strong>Access Token</strong>. These are only shown once.</p>
                    </div>
                </div>
                <div class="guide-step">
                    <div class="guide-step-num">4</div>
                    <div class="guide-step-content">
                        <p><strong>Configure in CacheWarmer.</strong></p>
                        <?php cachewarmer_code_block('akamai:
  enabled: true
  host: "akaa-xxxxx.luna.akamaiapis.net"
  clientToken: "akab-xxxxx"
  clientSecret: "xxxxx="
  accessToken: "akab-xxxxx"
  network: "production"', 'config.yaml'); ?>
                    </div>
                </div>
            </div>
            <?php cachewarmer_callout('Akamai uses EdgeGrid (EG1-HMAC-SHA256) authentication &mdash; CacheWarmer handles this internally. Up to 50 URLs per invalidation request. Use <code>network: "staging"</code> for testing.', 'info'); ?>
        </div>

    </div>
</section>

<!-- CTA -->
<section class="gradient-hero cta-section-sm">
    <div class="container text-center">
        <h2>API Keys Configured? Start Warming.</h2>
        <p class="hero-subtitle">Check the documentation for installation and deployment.</p>
        <div class="hero-buttons">
            <a href="<?php echo esc_url(home_url('/docs/')); ?>" class="btn btn-white btn-lg" title="CacheWarmer Documentation - Installation &amp; Configuration Guide">
                <?php cachewarmer_icon('book', '', 20); ?> Read the Docs
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
