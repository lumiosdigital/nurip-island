/**
 * Nirup Theme - Main Coordinator
 * File: assets/js/main.js
 * 
 * This file coordinates all theme modules and handles global initialization
 */

(function($) {
    'use strict';

    // Main theme object
    window.NirupTheme = window.NirupTheme || {
        version: '1.0.0',
        modules: {},
        initialized: false
    };

    // Main initialization
    window.NirupTheme.Main = {
        
        // Initialization state
        modulesLoaded: {
            utils: false,
            navigation: false,
            mobileMenu: false,
            search: false,
            languageSwitcher: false,
            analytics: false,
            plugins: false
        },

        // Initialize the theme
        init: function() {
            if (window.NirupTheme.initialized) {
                this.log('Theme already initialized');
                return;
            }

            this.log('Initializing Nirup Theme v' + window.NirupTheme.version);
            
            // Check if all required modules are loaded
            this.checkModules();
            
            // Initialize global features
            this.initGlobalFeatures();
            
            // Set up performance monitoring
            this.setupPerformanceMonitoring();
            
            // Mark as initialized
            window.NirupTheme.initialized = true;
            
            // Fire ready event
            $(document).trigger('nirup:ready');
            
            this.log('Theme initialization complete');
        },

        // Check if all modules are loaded
        checkModules: function() {
            var requiredModules = ['Utils', 'Navigation', 'MobileMenu', 'Search', 'LanguageSwitcher'];
            var missingModules = [];
            
            requiredModules.forEach(function(module) {
                if (!window.NirupTheme[module]) {
                    missingModules.push(module);
                }
            });
            
            if (missingModules.length > 0) {
                console.warn('[Nirup Theme] Missing modules:', missingModules);
                
                // Attempt to initialize missing modules with fallbacks
                this.initializeFallbacks(missingModules);
            } else {
                this.log('All required modules loaded successfully');
            }
        },

        // Initialize fallback functionality for missing modules
        initializeFallbacks: function(missingModules) {
            missingModules.forEach(function(module) {
                switch(module) {
                    case 'Utils':
                        this.initUtilsFallback();
                        break;
                    case 'Navigation':
                        this.initNavigationFallback();
                        break;
                    case 'MobileMenu':
                        this.initMobileMenuFallback();
                        break;
                    case 'Search':
                        this.initSearchFallback();
                        break;
                    case 'LanguageSwitcher':
                        this.initLanguageFallback();
                        break;
                }
            }.bind(this));
        },

        // Initialize global theme features
        initGlobalFeatures: function() {
            this.initKeyboardShortcuts();
            this.initLazyLoading();
            this.initPerformanceOptimizations();
            this.initAccessibilityFeatures();
            this.initErrorHandling();
        },

        // Initialize keyboard shortcuts
        initKeyboardShortcuts: function() {
            $(document).on('keydown', function(e) {
                // Escape key - close all overlays
                if (e.key === 'Escape') {
                    this.closeAllOverlays();
                }
                
                // Ctrl/Cmd + K - open search
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    if (window.NirupTheme.Search && window.NirupTheme.Search.open) {
                        window.NirupTheme.Search.open();
                    }
                }
                
                // Alt + M - toggle mobile menu (accessibility)
                if (e.altKey && e.key === 'm') {
                    e.preventDefault();
                    if (window.NirupTheme.MobileMenu && window.NirupTheme.MobileMenu.toggle) {
                        window.NirupTheme.MobileMenu.toggle();
                    }
                }
            }.bind(this));
        },

        // Initialize lazy loading for images
        initLazyLoading: function() {
            // Simple lazy loading implementation
            if ('IntersectionObserver' in window) {
                var imageObserver = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            var img = entry.target;
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                            imageObserver.unobserve(img);
                        }
                    });
                });

                $('.lazy[data-src]').each(function() {
                    imageObserver.observe(this);
                });
            }
        },

        // Initialize performance optimizations
        initPerformanceOptimizations: function() {
            // Preload critical resources
            this.preloadCriticalResources();
            
            // Optimize animations for reduced motion
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                $('body').addClass('reduce-motion');
            }
            
            // Debounce resize events
            $(window).on('resize', this.debounce(function() {
                $(document).trigger('nirup:resize');
            }, 150));
        },

        // Preload critical resources
        preloadCriticalResources: function() {
            var criticalImages = [
                // Add paths to critical images
            ];
            
            if (window.NirupTheme.Utils && window.NirupTheme.Utils.preloadImages) {
                window.NirupTheme.Utils.preloadImages(criticalImages);
            }
        },

        // Initialize accessibility features
        initAccessibilityFeatures: function() {
            // Skip links
            $('.skip-link').on('click', function(e) {
                var target = $($(this).attr('href'));
                if (target.length) {
                    target.focus();
                    target[0].scrollIntoView();
                }
            });

            // Focus visible improvements
            $('a, button, input, textarea, select').on('focus', function() {
                $(this).addClass('focused');
            }).on('blur', function() {
                $(this).removeClass('focused');
            });

            // Announce page changes to screen readers
            this.announcePageChanges();
        },

        // Announce page changes for accessibility
        announcePageChanges: function() {
            // Create ARIA live region for announcements
            if (!$('#aria-announcements').length) {
                $('<div id="aria-announcements" aria-live="polite" aria-atomic="true" class="screen-reader-text"></div>')
                    .appendTo('body');
            }
        },

        // Initialize error handling
        initErrorHandling: function() {
            // Global error handler
            window.addEventListener('error', function(e) {
                this.handleError(e.error, 'global');
            }.bind(this));

            // Unhandled promise rejections
            window.addEventListener('unhandledrejection', function(e) {
                this.handleError(e.reason, 'promise');
            }.bind(this));
        },

        // Handle errors gracefully
        handleError: function(error, context) {
            this.log('Error caught:', error, context);
            
            // Track error if analytics is available
            if (window.NirupTheme.Analytics && window.NirupTheme.Analytics.trackError) {
                window.NirupTheme.Analytics.trackError(error, context);
            }
            
            // Attempt graceful degradation
            this.attemptGracefulDegradation(error, context);
        },

        // Attempt graceful degradation on errors
        attemptGracefulDegradation: function(error, context) {
            // Implement fallback functionality based on error type
            switch(context) {
                case 'navigation':
                    this.initNavigationFallback();
                    break;
                case 'search':
                    this.initSearchFallback();
                    break;
                // Add more fallback cases as needed
            }
        },

        // Setup performance monitoring
        setupPerformanceMonitoring: function() {
            // Monitor critical performance metrics
            if ('performance' in window && 'measure' in window.performance) {
                window.performance.mark('nirup-theme-init-start');
                
                setTimeout(function() {
                    window.performance.mark('nirup-theme-init-end');
                    window.performance.measure('nirup-theme-init', 'nirup-theme-init-start', 'nirup-theme-init-end');
                    
                    var measure = window.performance.getEntriesByName('nirup-theme-init')[0];
                    this.log('Theme initialization took: ' + measure.duration + 'ms');
                }.bind(this), 0);
            }
        },

        // Close all overlays utility
        closeAllOverlays: function() {
            if (window.NirupTheme.Utils && window.NirupTheme.Utils.closeAllOverlays) {
                window.NirupTheme.Utils.closeAllOverlays();
            } else {
                // Fallback
                $('.search-overlay, .mobile-menu').removeClass('active');
                $('.language-switcher-container').removeClass('active');
                $('body').removeClass('search-open mobile-menu-open');
            }
        },

        // Logging utility
        log: function(message, data) {
            if (window.nirup_theme && window.nirup_theme.debug) {
                console.log('[Nirup Theme Main]', message, data || '');
            }
        },

        // Debounce utility (fallback)
        debounce: function(func, wait) {
            var timeout;
            return function() {
                var context = this, args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    func.apply(context, args);
                }, wait);
            };
        },

        // === FALLBACK METHODS ===

        initUtilsFallback: function() {
            this.log('Initializing Utils fallback');
            // Basic utils fallback
            window.NirupTheme.Utils = {
                log: this.log,
                closeAllOverlays: this.closeAllOverlays.bind(this)
            };
        },

        initNavigationFallback: function() {
            this.log('Initializing Navigation fallback');
            // Basic scroll behavior
            var lastScrollTop = 0;
            $(window).on('scroll', this.debounce(function() {
                var st = $(window).scrollTop();
                if (st > lastScrollTop && st > 100) {
                    $('.site-header, .announcement-bar').addClass('header-hidden');
                } else {
                    $('.site-header, .announcement-bar').removeClass('header-hidden');
                }
                lastScrollTop = st;
            }, 10));
        },

        initMobileMenuFallback: function() {
            this.log('Initializing Mobile Menu fallback');
            // Basic mobile menu toggle
            $('.mobile-menu-toggle').on('click', function() {
                var $menu = $('.mobile-menu');
                var $toggle = $(this);
                $toggle.toggleClass('active');
                $menu.toggleClass('active');
                if ($menu.hasClass('active')) {
                    $menu.show();
                    $('body').addClass('mobile-menu-open');
                } else {
                    $menu.hide();
                    $('body').removeClass('mobile-menu-open');
                }
            });
        },

        initSearchFallback: function() {
            this.log('Initializing Search fallback');
            // Basic search overlay
            $('.search-toggle').on('click', function(e) {
                e.preventDefault();
                $('.search-overlay').show().addClass('active');
                $('body').addClass('search-open');
                setTimeout(function() { $('.search-field').focus(); }, 100);
            });
            
            $('.search-close, .search-overlay').on('click', function(e) {
                if (e.target === this) {
                    $('.search-overlay').removeClass('active').hide();
                    $('body').removeClass('search-open');
                }
            });
        },

        initLanguageFallback: function() {
            this.log('Initializing Language Switcher fallback');
            // Basic language dropdown
            $('.language-current').on('click', function(e) {
                e.preventDefault();
                $(this).closest('.language-switcher-container').toggleClass('active');
            });
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        window.NirupTheme.Main.init();
    });

    // Reinitialize on specific events if needed
    $(document).on('nirup:reinit', function() {
        window.NirupTheme.Main.log('Reinitializing theme');
        window.NirupTheme.initialized = false;
        window.NirupTheme.Main.init();
    });

})(jQuery);