/**
 * Nirup Theme - Search Functionality
 * File: assets/js/search.js
 */

(function($) {
    'use strict';

    window.NirupTheme = window.NirupTheme || {};

    window.NirupTheme.Search = {
        
        // Configuration
        config: {
            animationDuration: 300,
            isOpen: false,
            focusDelay: 350
        },

        // Initialize search functionality
        init: function() {
            this.bindEvents();
            this.setupAccessibility();
            window.NirupTheme.Utils.log('Search module initialized');
        },

        // Bind search events
        bindEvents: function() {
            var self = this;

            // Search toggle button
            $('.search-toggle').on('click', function(e) {
                e.preventDefault();
                self.open();
            });

            // Search close button
            $('.search-close').on('click', function(e) {
                e.preventDefault();
                self.close();
            });

            // Close search when clicking overlay background
            $('.search-overlay').on('click', function(e) {
                if (e.target === this) {
                    self.close();
                }
            });

            // Search form submission
            $('.search-form').on('submit', function() {
                self.handleSearchSubmit($(this));
            });

            // Keyboard events
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && self.config.isOpen) {
                    self.close();
                }
                
                // Ctrl/Cmd + K to open search
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    if (!self.config.isOpen) {
                        self.open();
                    }
                }
            });

            // Focus management within search overlay
            $('.search-overlay').on('keydown', function(e) {
                if (e.key === 'Tab') {
                    self.handleTabNavigation(e);
                }
            });
        },

        // Setup accessibility features
        setupAccessibility: function() {
            var $overlay = $('.search-overlay');
            var $toggle = $('.search-toggle');
            
            // ARIA attributes
            $toggle.attr('aria-label', 'Open search');
            $overlay.attr('role', 'dialog');
            $overlay.attr('aria-modal', 'true');
            $overlay.attr('aria-labelledby', 'search-title');
            
            // Add hidden title for screen readers
            if (!$overlay.find('#search-title').length) {
                $overlay.find('.search-overlay-content').prepend(
                    '<h2 id="search-title" class="screen-reader-text">Search</h2>'
                );
            }
        },

        // Open search overlay
        open: function() {
            var $overlay = $('.search-overlay');
            var $body = $('body');
            var $searchField = $('.search-field');
            
            window.NirupTheme.Utils.log('Opening search overlay');
            
            // Show and activate overlay
            $overlay.show().addClass('active');
            $body.addClass('search-open');
            
            // Set state
            this.config.isOpen = true;
            
            // Focus search field after animation
            setTimeout(function() {
                $searchField.focus();
            }, this.config.focusDelay);
            
            // Track event
            window.NirupTheme.Utils.trackEvent('search_open');
            
            // Store focus for restoration
            this.lastFocusedElement = document.activeElement;
        },

        // Close search overlay
        close: function() {
            var $overlay = $('.search-overlay');
            var $body = $('body');
            
            window.NirupTheme.Utils.log('Closing search overlay');
            
            // Remove active class
            $overlay.removeClass('active');
            $body.removeClass('search-open');
            
            // Hide overlay after animation
            setTimeout(function() {
                $overlay.hide();
            }, this.config.animationDuration);
            
            // Set state
            this.config.isOpen = false;
            
            // Restore focus
            if (this.lastFocusedElement) {
                this.lastFocusedElement.focus();
                this.lastFocusedElement = null;
            }
            
            // Track event
            window.NirupTheme.Utils.trackEvent('search_close');
        },

        // Handle search form submission
        handleSearchSubmit: function($form) {
            var searchTerm = $form.find('.search-field').val().trim();
            
            if (!searchTerm) {
                window.NirupTheme.Utils.log('Empty search attempted');
                return false;
            }
            
            window.NirupTheme.Utils.log('Search performed', { term: searchTerm });
            
            // Add loading state
            window.NirupTheme.Utils.addLoadingState($form.closest('.search-overlay'));
            
            // Track search
            window.NirupTheme.Utils.trackEvent('search_performed', {
                search_term: searchTerm,
                search_length: searchTerm.length
            });
            
            // Let the form submit normally
            return true;
        },

        // Handle tab navigation within search overlay
        handleTabNavigation: function(e) {
            var $overlay = $('.search-overlay');
            var $focusableElements = $overlay.find('input, button, a, [tabindex]').filter(':visible');
            var $firstElement = $focusableElements.first();
            var $lastElement = $focusableElements.last();
            
            // If shift+tab on first element, go to last
            if (e.shiftKey && e.target === $firstElement[0]) {
                e.preventDefault();
                $lastElement.focus();
            }
            // If tab on last element, go to first
            else if (!e.shiftKey && e.target === $lastElement[0]) {
                e.preventDefault();
                $firstElement.focus();
            }
        },

        // Clear search field
        clearSearch: function() {
            $('.search-field').val('');
            window.NirupTheme.Utils.log('Search cleared');
        },

        // Get current state
        isOpen: function() {
            return this.config.isOpen;
        },

        // Force close (useful for other modules)
        forceClose: function() {
            if (this.config.isOpen) {
                this.close();
            }
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        window.NirupTheme.Search.init();
    });

    // Make force close available globally
    $(document).on('nirup:closeAllOverlays', function() {
        window.NirupTheme.Search.forceClose();
    });

    // Remove loading state when page loads
    $(window).on('load', function() {
        window.NirupTheme.Utils.removeLoadingState('.search-overlay');
    });

})(jQuery);