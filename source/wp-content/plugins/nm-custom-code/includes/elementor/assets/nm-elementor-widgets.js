(function($) {
    
    'use strict';
    
    /* Document ready */
    var nmDocReady = function(fn) {
        if (document.readyState === 'complete' || document.readyState === 'interactive') { // See if DOM is already available
            setTimeout(fn, 1); // Call on next available tick
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    };
    
    nmDocReady(function() {
        
        var nmTheme = $.nmThemeInstance;
        
        if (! nmTheme/* || ! elementorFrontend.isEditMode()*/) {
            console.log('NM Elementor: Theme instance not found');
            return;
        }
        
        var hasResizeObserver = (window.ResizeObserver) ? true : false;
        
        
        /* Widget functions */
        var utils = {
            isInitialized: function($widget) {
                if ($widget.hasClass('nm-widget-initialized')) { return true; }
                $widget.addClass('nm-widget-initialized');
                return false;
            }
        },
        widgets = {
            bannerSlider: {
                init: function($widgetScope) {
                    var $bannerSlider = $widgetScope.find('.nm-banner-slider');
                    if (utils.isInitialized($bannerSlider)) { return; } // Only initialize once
                    console.log('NM Elementor: Banner Slider - Init');
                    var $banners = $bannerSlider.find('.nm-banner');
                    nmTheme.elementBanner($banners);
                    nmTheme.elementBannerSlider($bannerSlider);
                    if (hasResizeObserver) {
                        widgetsObserver.observe($bannerSlider[0]);
                    }
                },
                update: function(widget) {
                    var $bannerSlider = $(widget);
                    console.log('NM Elementor: Banner Slider - Update');
                    // Slick Slider/Flickity: Update
                    if ($bannerSlider.hasClass('plugin-slick')) {
                        $bannerSlider.slick('setPosition');
                    } else {
                        $bannerSlider.flickity('resize');
                    }
                }
            },
            lightbox: {
                init: function($widgetScope) {
                    var $lightbox = $widgetScope.find('.nm-lightbox');
                    if (utils.isInitialized($lightbox)) { return; } // Only initialize once
                    console.log('NM Elementor: Lightbox - Init');
                    nmTheme.elementLightbox($lightbox);
                }
            },
            portfolio: {
                init: function($widgetScope) {
                    var $portfolioGrid = $widgetScope.find('.nm-portfolio-grid');
                    if (utils.isInitialized($portfolioGrid)) { return; } // Only initialize once
                    if (window.NM_Portfolio) {
                        console.log('NM Elementor: Portfolio - Init');
                        window.NM_Portfolio.packeryLayout($portfolioGrid);
                    }
                    if (hasResizeObserver) {
                        widgetsObserver.observe($portfolioGrid[0]);
                    }
                },
                update: function(widget) {
                    var $portfolioGrid = $(widget);
                    if (window.NM_Portfolio && $portfolioGrid.parent('.nm-portfolio').hasClass('packery-enabled')) {
                        console.log('NM Elementor: Portfolio - Update');
                        $portfolioGrid.packery('layout'); // Update layout
                    }
                }
            },
            postSlider: {
                init: function($widgetScope) {
                    var $postSlider = $widgetScope.find('.nm-post-slider');
                    if (utils.isInitialized($postSlider)) { return; } // Only initialize once
                    console.log('NM Elementor: Post Slider - Init');
                    nmTheme.elementPostSlider($postSlider);
                    if (hasResizeObserver) {
                        widgetsObserver.observe($postSlider[0]);
                    }
                },
                update: function(widget) {
                    var $postSlider = $(widget);
                    console.log('NM Elementor: Post Slider - Update');
                    $postSlider.slick('setPosition');
                }
            },
            productCategories: {
                init: function($widgetScope) {
                    var $productCategories = $widgetScope.find('.nm-product-categories');
                    if (utils.isInitialized($productCategories)) { return; } // Only initialize once
                    console.log('NM Elementor: Product Categories - Init');
                    nmTheme.elementProductCategories($productCategories);
                    if (hasResizeObserver) {
                        widgetsObserver.observe($productCategories[0]);
                    }
                },
                update: function(widget) {
                    var $productCategories = $(widget);
                    if ($productCategories.hasClass('masonry-enabled')) {
                        console.log('NM Elementor: Product Categories - Update');
                        var $categoriesUl = $productCategories.children('.woocommerce').children('ul');
                        $categoriesUl.masonry('layout'); // Update layout
                    }
                }
            },
            productReviewsSlider: {
                init: function($widgetScope) {
                    var $productReviewsSlider = $widgetScope.find('.nm-product-reviews-slider');
                    if (utils.isInitialized($productReviewsSlider)) { return; } // Only initialize once
                    console.log('NM Elementor: Product Reviews Slider - Init');
                    nmTheme.elementProductReviewsSlider($productReviewsSlider);
                    if (hasResizeObserver) {
                        widgetsObserver.observe($productReviewsSlider[0]);
                    }
                },
                update: function(widget) {
                    var $productReviewsSlider = $(widget).find('.nm-product-reviews-ul:first');
                    console.log('NM Elementor: Product Reviews Slider - Update');
                    $productReviewsSlider.slick('setPosition');
                }
            },
            productSlider: {
                init: function($widgetScope) {
                    var $productSlider = $widgetScope.find('.nm-product-slider');
                    if (utils.isInitialized($productSlider)) { return; } // Only initialize once
                    console.log('NM Elementor: Product Slider - Init');
                    nmTheme.elementProductSlider($productSlider);
                    if (hasResizeObserver) {
                        widgetsObserver.observe($productSlider[0]);
                    }
                },
                update: function(widget) {
                    var $productSlider = $(widget).find('.nm-products:first');
                    console.log('NM Elementor: Product Slider - Update');
                    $productSlider.slick('setPosition');
                }
            },
            tabs: {
                init: function($widgetScope) {
                    var $tabs = $widgetScope.find('.nm-elementor-tabs');
                    if (utils.isInitialized($tabs)) { return; } // Only initialize once
                    console.log('NM Elementor: Tabs - Init');
                    nmTheme.elementElementorTabs($tabs);
                }
            }
        },
        widgetAliases = {
            'nm-banner-slider.default': 'bannerSlider',
            'nm-lightbox.default': 'lightbox',
            'nm-portfolio.default': 'portfolio',
            'nm-post-slider.default': 'postSlider',
            'nm-product-categories.default': 'productCategories',
            'nm-product-reviews-slider.default': 'productReviewsSlider',
            'nm-product-slider.default': 'productSlider',
            'nm-tabs.default': 'tabs'
        };
        
        
        /* Widget resize: Use ResizeObserver JS function to update widgets when resized */
        if (hasResizeObserver) {
            var $widget, widgetName, updateTimer = null;
            
            var widgetsObserver = new ResizeObserver(function(resizedWidgets) {
                // Prevent update on init - keep above "setTimeout" so the "nm-rsinit" class is added to all widgets
                if (resizedWidgets.length == 1 && ! $(resizedWidgets[0].target).hasClass('nm-rsinit')) {
                    $(resizedWidgets[0].target).addClass('nm-rsinit');
                    console.log('NM Elementor: ResizeObserver - Init: ' + resizedWidgets[0].target.classList[0]);
                    return false; 
                }
                
                if (updateTimer) { clearTimeout(updateTimer); }
                updateTimer = setTimeout(function() {
                    console.log('NM Elementor: ResizeObserver - Timeout done');
                    resizedWidgets.forEach(widget => {
                        $widget = $(widget.target);
                        
                        // Make sure widget isn't being dragged
                        if ($widget.is(':visible') && ! $widget.closest('.elementor-row').hasClass('elementor-draggable-over')) {
                            widgetName = $widget.closest('.elementor-widget').data('widget_type');
                            widgets[widgetAliases[widgetName]].update(widget.target);
                        }
                    });
                }, 200);
            });
        }
        
        
        /* Elementor init */
        $(window).on('elementor/frontend/init', function() {
            // Add Elementor "ready state" widget hooks: https://developers.elementor.com/creating-a-new-widget/adding-javascript-to-elementor-widgets/
            for (var widgetClass in widgetAliases) {
                if (widgetAliases.hasOwnProperty(widgetClass)) {
                    elementorFrontend.hooks.addAction('frontend/element_ready/' + widgetClass, widgets[widgetAliases[widgetClass]].init);
                }
            }
        });
    });
    
})(jQuery);