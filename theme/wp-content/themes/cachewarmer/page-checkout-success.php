<?php
/**
 * Template Name: Checkout Success
 * Displayed after a successful Stripe Checkout payment.
 */
$page_og_title = 'Payment Successful - CacheWarmer';
$page_description = 'Your CacheWarmer purchase was successful. Your license key will be delivered via email shortly.';
get_header();
cachewarmer_breadcrumb('Payment Successful');
?>

<!-- Success Hero -->
<section class="page-hero">
    <div class="container">
        <div class="checkout-success">
            <div class="checkout-success-icon">
                <?php cachewarmer_icon('check-circle', '', 64); ?>
            </div>
            <h1>Payment Successful</h1>
            <p class="hero-subtitle">Thank you for purchasing CacheWarmer!</p>
        </div>
    </div>
</section>

<!-- License Delivery Info -->
<section class="section section-gray">
    <div class="container">
        <div class="checkout-success-content max-w-3xl mx-auto">

            <div class="checkout-success-card">
                <?php cachewarmer_icon('key', '', 28); ?>
                <div>
                    <h2>Your License Key Is On Its Way</h2>
                    <p>Your license key will be delivered to your email address within the next few seconds. Please also check your spam folder.</p>
                </div>
            </div>

            <div class="checkout-next-steps">
                <h3>Next Steps</h3>
                <div class="grid grid-3 gap-6">
                    <?php
                    cachewarmer_step(1, 'Check Your Email', 'Look for an email from CacheWarmer with your license key (CW-PRO-... or CW-ENT-...).');
                    cachewarmer_step(2, 'Enter Your License', 'Go to your WordPress / Drupal admin panel and enter the key under CacheWarmer &rarr; License.');
                    cachewarmer_step(3, 'Start Warming', 'All premium warming targets are now unlocked. Configure your sitemaps and run your first job.');
                    ?>
                </div>
            </div>

            <div class="checkout-help">
                <p>Need help getting started? Check out our <a href="<?php echo esc_url(home_url('/docs/')); ?>">documentation</a> or <a href="https://dross.net/contact/?topic=cachewarmer">contact support</a>.</p>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>
