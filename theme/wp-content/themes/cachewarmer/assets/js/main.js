/**
 * CacheWarmer Theme - Main JavaScript
 */
(function () {
    'use strict';

    // ==========================================
    // 1. Header scroll effect
    // ==========================================
    var header = document.getElementById('site-header');
    var ticking = false;

    function updateHeader() {
        if (window.scrollY > 50) {
            header.classList.add('header-scrolled');
        } else {
            header.classList.remove('header-scrolled');
        }
        ticking = false;
    }

    window.addEventListener('scroll', function () {
        if (!ticking) {
            requestAnimationFrame(updateHeader);
            ticking = true;
        }
    });

    // ==========================================
    // 2. Mobile menu toggle
    // ==========================================
    var menuToggle = document.querySelector('.mobile-menu-toggle');
    var mobileMenu = document.getElementById('mobile-menu');

    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function () {
            var isOpen = !mobileMenu.hidden;
            mobileMenu.hidden = isOpen;
            menuToggle.setAttribute('aria-expanded', String(!isOpen));
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !mobileMenu.hidden) {
                mobileMenu.hidden = true;
                menuToggle.setAttribute('aria-expanded', 'false');
                menuToggle.focus();
            }
        });

        document.addEventListener('click', function (e) {
            if (!mobileMenu.hidden && !mobileMenu.contains(e.target) && !menuToggle.contains(e.target)) {
                mobileMenu.hidden = true;
                menuToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // ==========================================
    // 3. Desktop dropdown menu
    // ==========================================
    var dropdownToggles = document.querySelectorAll('.nav-dropdown-toggle');

    dropdownToggles.forEach(function (toggle) {
        var dropdown = toggle.closest('.nav-dropdown');
        var menu = dropdown ? dropdown.querySelector('.nav-dropdown-menu') : null;

        if (!menu) return;

        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var isOpen = toggle.getAttribute('aria-expanded') === 'true';

            // Close all other dropdowns first
            dropdownToggles.forEach(function (otherToggle) {
                if (otherToggle !== toggle) {
                    otherToggle.setAttribute('aria-expanded', 'false');
                    var otherMenu = otherToggle.closest('.nav-dropdown').querySelector('.nav-dropdown-menu');
                    if (otherMenu) otherMenu.classList.remove('nav-dropdown-open');
                }
            });

            toggle.setAttribute('aria-expanded', String(!isOpen));
            menu.classList.toggle('nav-dropdown-open', !isOpen);
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function (e) {
        dropdownToggles.forEach(function (toggle) {
            var dropdown = toggle.closest('.nav-dropdown');
            if (dropdown && !dropdown.contains(e.target)) {
                toggle.setAttribute('aria-expanded', 'false');
                var menu = dropdown.querySelector('.nav-dropdown-menu');
                if (menu) menu.classList.remove('nav-dropdown-open');
            }
        });
    });

    // Close dropdowns on Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            dropdownToggles.forEach(function (toggle) {
                toggle.setAttribute('aria-expanded', 'false');
                var menu = toggle.closest('.nav-dropdown').querySelector('.nav-dropdown-menu');
                if (menu) menu.classList.remove('nav-dropdown-open');
            });
        }
    });

    // ==========================================
    // 4. Docs sidebar active section
    // ==========================================
    var docsSidebarLinks = document.querySelectorAll('.docs-sidebar-link');
    var docsSections = [];

    if (docsSidebarLinks.length > 0) {
        docsSidebarLinks.forEach(function (link) {
            var href = link.getAttribute('href');
            if (href && href.startsWith('#')) {
                var section = document.getElementById(href.substring(1));
                if (section) {
                    docsSections.push({ link: link, section: section });
                }
            }
        });

        if (docsSections.length > 0 && 'IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        docsSidebarLinks.forEach(function (l) {
                            l.classList.remove('docs-sidebar-link-active');
                        });
                        docsSections.forEach(function (item) {
                            if (item.section === entry.target) {
                                item.link.classList.add('docs-sidebar-link-active');
                            }
                        });
                    }
                });
            }, {
                rootMargin: '-20% 0px -70% 0px'
            });

            docsSections.forEach(function (item) {
                observer.observe(item.section);
            });
        }
    }

    // ==========================================
    // 5. FAQ accordion hash support
    // ==========================================
    var faqItems = document.querySelectorAll('.faq-item[id]');

    // Update URL hash when an FAQ is toggled open
    faqItems.forEach(function (details) {
        details.addEventListener('toggle', function () {
            if (details.open) {
                history.replaceState(null, '', '#' + details.id);
            } else if (window.location.hash === '#' + details.id) {
                history.replaceState(null, '', window.location.pathname + window.location.search);
            }
        });
    });

    // On page load, open and scroll to the FAQ matching the URL hash
    function openFaqFromHash() {
        var hash = window.location.hash;
        if (!hash) return;
        var target = document.querySelector('.faq-item' + hash);
        if (!target) return;
        target.open = true;
        var headerHeight = header ? header.offsetHeight : 0;
        var offset = target.getBoundingClientRect().top + window.pageYOffset - headerHeight - 32;
        window.scrollTo({ top: offset, behavior: 'smooth' });
    }

    openFaqFromHash();
    window.addEventListener('hashchange', openFaqFromHash);

    // ==========================================
    // 6. Tabs
    // ==========================================
    document.querySelectorAll('.tabs').forEach(function (tabContainer) {
        var buttons = tabContainer.querySelectorAll('.tab-btn');
        var parent = tabContainer.parentElement;

        buttons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var target = btn.getAttribute('data-tab');

                buttons.forEach(function (b) { b.classList.remove('tab-btn-active'); });
                btn.classList.add('tab-btn-active');

                if (parent) {
                    parent.querySelectorAll('.tab-content').forEach(function (content) {
                        content.classList.remove('tab-content-active');
                    });
                    var targetContent = parent.querySelector('[data-tab-content="' + target + '"]');
                    if (targetContent) {
                        targetContent.classList.add('tab-content-active');
                    }
                }
            });
        });
    });

    // ==========================================
    // 7. Smooth scroll for anchor links
    // ==========================================
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            var targetId = this.getAttribute('href');
            if (targetId === '#') return;

            var target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                var headerHeight = header ? header.offsetHeight : 0;
                var offset = target.getBoundingClientRect().top + window.pageYOffset - headerHeight - 32;
                window.scrollTo({ top: offset, behavior: 'smooth' });
                history.pushState({}, '', targetId);
            }
        });
    });

    // ==========================================
    // 8. Code block copy buttons
    // ==========================================
    document.querySelectorAll('.code-copy-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var codeBlock = btn.closest('.code-block');
            var code = codeBlock ? codeBlock.querySelector('code') : null;
            if (code && navigator.clipboard) {
                navigator.clipboard.writeText(code.textContent).then(function () {
                    btn.classList.add('copied');
                    setTimeout(function () {
                        btn.classList.remove('copied');
                    }, 2000);
                });
            }
        });
    });

    // ==========================================
    // 9. Billing toggle (monthly / yearly)
    // ==========================================
    var billingToggleBtns = document.querySelectorAll('.billing-toggle-btn');

    billingToggleBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var billing = btn.getAttribute('data-billing');

            billingToggleBtns.forEach(function (b) {
                b.classList.remove('billing-toggle-active');
            });
            btn.classList.add('billing-toggle-active');

            // Toggle price display
            document.querySelectorAll('.price-yearly').forEach(function (el) {
                el.style.display = billing === 'yearly' ? '' : 'none';
            });
            document.querySelectorAll('.price-monthly').forEach(function (el) {
                el.style.display = billing === 'monthly' ? '' : 'none';
            });

            // Toggle period text
            document.querySelectorAll('.period-yearly').forEach(function (el) {
                el.style.display = billing === 'yearly' ? '' : 'none';
            });
            document.querySelectorAll('.period-monthly').forEach(function (el) {
                el.style.display = billing === 'monthly' ? '' : 'none';
            });
        });
    });

    // ==========================================
    // 10. Platform tabs for pricing
    // ==========================================
    var platformTabBtns = document.querySelectorAll('.platform-tabs .tab-btn');

    platformTabBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var platform = btn.getAttribute('data-tab');

            platformTabBtns.forEach(function (b) {
                b.classList.remove('tab-btn-active');
            });
            btn.classList.add('tab-btn-active');

            document.querySelectorAll('.period-wordpress').forEach(function (el) {
                el.style.display = platform === 'wordpress' ? '' : 'none';
            });
            document.querySelectorAll('.period-drupal').forEach(function (el) {
                el.style.display = platform === 'drupal' ? '' : 'none';
            });
            document.querySelectorAll('.period-selfhosted').forEach(function (el) {
                el.style.display = platform === 'selfhosted' ? '' : 'none';
            });
        });
    });

    // ==========================================
    // 11. Stripe Checkout buy buttons
    // ==========================================
    document.querySelectorAll('.cwlm-buy-button').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            if (typeof cwlmCheckout === 'undefined') {
                return;
            }

            // Determine active billing period
            var billingActive = document.querySelector('.billing-toggle-active');
            var billing = billingActive ? billingActive.getAttribute('data-billing') : 'yearly';

            // Determine active platform
            var platformActive = document.querySelector('.platform-tabs .tab-btn-active');
            var platform = platformActive ? platformActive.getAttribute('data-tab') : 'wordpress';

            // Resolve price ID from button data attributes
            var platformKey = { wordpress: 'wp', drupal: 'drupal', selfhosted: 'sh' };
            var prefix = platformKey[platform] || 'wp';
            var priceId = '';
            if (btn.hasAttribute('data-price-wp-yearly')) {
                // Premium card with platform-specific prices
                priceId = btn.getAttribute('data-price-' + prefix + '-' + billing);
                if (!priceId) {
                    priceId = btn.getAttribute('data-price-wp-' + billing);
                }
            } else {
                // Enterprise cards (no platform distinction)
                priceId = btn.getAttribute('data-price-' + billing);
            }

            if (!priceId) {
                window.location.href = 'https://dross.net/contact/?topic=cachewarmer';
                return;
            }

            // Disable button and show loading
            btn.disabled = true;
            var originalText = btn.innerHTML;
            btn.innerHTML = '<span class="btn-spinner"></span> Redirecting&hellip;';

            // Create checkout session via AJAX
            var formData = new FormData();
            formData.append('action', 'cwlm_create_checkout');
            formData.append('nonce', cwlmCheckout.nonce);
            formData.append('price_id', priceId);

            fetch(cwlmCheckout.ajaxUrl, {
                method: 'POST',
                body: formData,
            })
            .then(function (response) { return response.json(); })
            .then(function (result) {
                if (result.success && result.data && result.data.checkout_url) {
                    window.location.href = result.data.checkout_url;
                } else {
                    var msg = (result.data && result.data.message) ? result.data.message : 'Something went wrong. Please try again.';
                    alert(msg);
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            })
            .catch(function () {
                alert('Could not connect to the payment provider. Please try again.');
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        });
    });

})();
