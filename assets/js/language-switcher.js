/**
 * Nirup Theme - Language Switcher Functionality - COMPLETE FILE
 * File: assets/js/language-switcher.js
 */

(function($) {
    'use strict';

    window.NirupTheme = window.NirupTheme || {};

    window.NirupTheme.LanguageSwitcher = {
        
        // Initialize language switcher
        init: function() {
            this.bindEvents();
            this.log('Language switcher initialized');
        },

        // Bind language switcher events
        bindEvents: function() {
            var self = this;
            
            // Start with dropdown closed
            $('.language-switcher-container').removeClass('active');
            this.log('Language switcher events binding...');
            
            // Language button click - using event delegation
            $(document).off('click.languageSwitcher').on('click.languageSwitcher', '.language-current', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                self.log('Language button clicked');
                
                var $container = $(this).closest('.language-switcher-container');
                var isActive = $container.hasClass('active');
                
                // Close all dropdowns first
                $('.language-switcher-container').removeClass('active');
                
                // Open this one if it wasn't active
                if (!isActive) {
                    self.log('Opening language dropdown');
                    $container.addClass('active');
                } else {
                    self.log('Closing language dropdown');
                }
            });

            // Click outside to close
            $(document).off('click.languageOutside').on('click.languageOutside', function(e) {
                if (!$(e.target).closest('.language-switcher-container').length) {
                    $('.language-switcher-container').removeClass('active');
                }
            });

            // Language option clicks
            $(document).off('click.languageOption').on('click.languageOption', '.language-option a', function(e) {
                self.log('Language option clicked: ' + $(this).text());
                
                var selectedLang = $(this).text().trim();
                var $container = $(this).closest('.language-switcher-container');
                var $currentButton = $container.find('.language-current');
                
                // Update button text (preserve the SVG)
                self.updateCurrentLanguage($currentButton, selectedLang);
                
                // Update current option styling
                $container.find('.language-option').removeClass('current-language');
                $(this).closest('.language-option').addClass('current-language');
                
                // Close dropdown
                $container.removeClass('active');
                
                // Track language change
                self.trackEvent('language_changed', {
                    language: selectedLang,
                    url: $(this).attr('href')
                });
                
                // Let TranslatePress handle the navigation
                // Don't prevent default so the link works
            });

            // Escape key to close
            $(document).off('keydown.languageEscape').on('keydown.languageEscape', function(e) {
                if (e.key === 'Escape') {
                    $('.language-switcher-container').removeClass('active');
                }
            });

            // Keyboard navigation within dropdown
            $(document).off('keydown.languageNav').on('keydown.languageNav', '.language-switcher-container', function(e) {
                self.handleKeyboardNavigation(e, $(this));
            });
            
            this.log('Language switcher events bound');
        },

        // Update current language display
        updateCurrentLanguage: function($button, newLanguage) {
            // Preserve the SVG arrow
            var $svg = $button.find('svg').detach();
            
            // Update text content
            $button.text(newLanguage);
            
            // Re-append the SVG
            $button.append($svg);
            
            this.log('Updated language display to: ' + newLanguage);
        },

        // Handle keyboard navigation
        handleKeyboardNavigation: function(e, $container) {
            var $dropdown = $container.find('.language-dropdown-menu');
            var $options = $dropdown.find('a');
            var $currentButton = $container.find('.language-current');
            var currentIndex = -1;
            
            // Find currently focused option
            $options.each(function(index) {
                if (this === document.activeElement) {
                    currentIndex = index;
                    return false;
                }
            });
            
            switch(e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    if (!$container.hasClass('active')) {
                        $container.addClass('active');
                        $options.first().focus();
                    } else {
                        var nextIndex = (currentIndex + 1) % $options.length;
                        $options.eq(nextIndex).focus();
                    }
                    break;
                    
                case 'ArrowUp':
                    e.preventDefault();
                    if ($container.hasClass('active')) {
                        var prevIndex = currentIndex <= 0 ? $options.length - 1 : currentIndex - 1;
                        $options.eq(prevIndex).focus();
                    }
                    break;
                    
                case 'Enter':
                case ' ':
                    e.preventDefault();
                    if (document.activeElement === $currentButton[0]) {
                        $container.toggleClass('active');
                    } else if ($options.index(document.activeElement) >= 0) {
                        $(document.activeElement).click();
                    }
                    break;
                    
                case 'Escape':
                    $container.removeClass('active');
                    $currentButton.focus();
                    break;
            }
        },

        // Close all dropdowns
        closeAll: function() {
            $('.language-switcher-container').removeClass('active');
            this.log('All language dropdowns closed');
        },

        // Check if dropdown is open
        isOpen: function($container) {
            $container = $container || $('.language-switcher-container');
            return $container.hasClass('active');
        },

        // Track events
        trackEvent: function(eventName, eventData) {
            if (window.NirupTheme && window.NirupTheme.Utils && window.NirupTheme.Utils.trackEvent) {
                window.NirupTheme.Utils.trackEvent(eventName, eventData);
            }
        },

        // Logging utility
        log: function(message) {
            if (window.NirupTheme && window.NirupTheme.Utils && window.NirupTheme.Utils.log) {
                window.NirupTheme.Utils.log('LanguageSwitcher: ' + message);
            } else if (window.console && window.console.log) {
                console.log('[Language Switcher] ' + message);
            }
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        // Small delay to ensure other modules are loaded
        setTimeout(function() {
            window.NirupTheme.LanguageSwitcher.init();
        }, 100);
    });

    // Make available globally for other modules
    $(document).on('nirup:closeAllOverlays', function() {
        if (window.NirupTheme && window.NirupTheme.LanguageSwitcher) {
            window.NirupTheme.LanguageSwitcher.closeAll();
        }
    });

    // Re-initialize on dynamic content load (if needed)
    $(document).on('nirup:reinit', function() {
        if (window.NirupTheme && window.NirupTheme.LanguageSwitcher) {
            window.NirupTheme.LanguageSwitcher.init();
        }
    });

})(jQuery);