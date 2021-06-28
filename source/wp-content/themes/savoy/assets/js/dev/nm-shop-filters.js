(function($) {
	
	'use strict';
	
	// Extend core script
	$.extend($.nmTheme, {
		
		/**
		 *	Initialize scripts
		 */
		filters_init: function() {
			var self = this;
			
			/* Shop filters */
			self.$shopFilterMenu = $('#nm-shop-filter-menu');
			self.$shopSidebarPopupBtn = $('#nm-shop-sidebar-popup-button');
            self.shopSidebarLayout = $('#nm-shop-sidebar').data('sidebar-layout'); // Get the sidebar/filters layout
            self.filterPanelSliding = false;
			self.filterPanelSlideSpeed = 200;
			self.filterPanelHideWidth = 551;
			
			// Shop filters: Toggle function names
			self.shopFilterMenuFnNames = {
				'cat':		'shopFiltersCategoriesToggle',
				'filter':	'shopFiltersSidebarToggle',
                'sidebar':	'shopDefaultSidebarToggle',
				'search':	'shopFiltersSearchToggle'
			};
			
			self.shopFiltersBind();
		},
		
		
		/**
		 *	Shop filters: Bind
		 */
		shopFiltersBind: function() {
			var self = this;
			
            
            /* Bind: Header - Shop links */
			if (self.filtersEnableAjax) {
                self.$header.on('click.nmHeaderShopAjax', '.shop-ajax-link', function(e) {
				    e.preventDefault();
                    
                    var $this = $(this),
                        $topParentMenu = $this.parents('.menu-item').last();
                    
                    // Menu: Hide by disabling CSS :hover
                    $topParentMenu.addClass('no-hover');
                    
                    // Close search panel (if open)
                    self.shopFiltersSearchClose();
                    
                    // Category menu: Remove "current" class
					$('#nm-shop-categories-wrap').find('.current-cat').removeClass('current-cat');
                    
                    // Smooth-scroll to shop
                    var to = self.shopScrollToTop();
                    
                    setTimeout(function() {
                        self.shopGetPage($this.children('a').attr('href'));

                        // Menu: Re-enable CSS :hover
                        setTimeout(function() {
                            $topParentMenu.removeClass('no-hover');
                        }, 100);
                    }, to);
                });
            }
            
            
			/* Bind: Shop filters menu */
			self.$shopFilterMenu.find('a').on('click', function(e) {
				e.preventDefault();
				
				if (self.filterPanelSliding) { return; }
				
				// Remove any visible shop notices
				self.shopRemoveNotices();
					
				self.filterPanelSliding = true;
				
				var to = 0,
					$this = $(this).parent('li'),
					thisData = $this.data('panel');					
				
				// Hide active panel
				if (!$this.hasClass('active')) {
					to = self.shopFiltersHideActivePanel();
				}
				
				$this.toggleClass('active');
				
				// Use "setTimeout()" to allow the active panel to slide-up first (if open)
				setTimeout(function() {
					var fn = self.shopFilterMenuFnNames[thisData];
					self[fn]();
				}, to);
			});
			
			
			/* Bind: Category menu */
			if (self.filtersEnableAjax && self.$pageIncludes.hasClass('shop_categories')) {
                self.$shopWrap.on('click', '#nm-shop-categories-wrap a',  function(e) {
					e.preventDefault();
					
					var $this = $(this),
						$thisLi = $this.parent('li');
				    
					// Close search panel (if open)
                    self.shopFiltersSearchClose();
										
					// Set new "current" class
                    $('#nm-shop-categories-wrap').find('.current-cat').removeClass('current-cat');
					$thisLi.addClass('current-cat');
					
					self.shopGetPage($this.attr('href'));
				});
			}
            
            
            if (self.$shopSidebarPopupBtn.length) {
                self.$shopSidebarPopup = $('#nm-shop-sidebar-popup');
                
                /* Bind: Filters popup button "scroll" and "resize" events */
                var timer = null;
                self.$window.on('scroll.nmShopPopupBtn resize.nmShopPopupBtn', function()  {
                    if (timer) { clearTimeout(timer); }
				    timer = setTimeout(function() {
                        if (! self.$body.hasClass('shop-filters-popup-open')) { // Is the filters popup open?
                            self.shopFiltersPopupButtonToggle();
                        }
                    }, 500);
                });
                
                /* Bind: Filters popup menu button */
                self.$shopSidebarPopupBtn.on('click', function() {
                    self.shopFiltersPopupShow();
                });
                
                /* Bind: Filters popup menu - Reset button */
				$('#nm-shop-sidebar-popup-reset-button').on('click', function(e) {
					e.preventDefault();
                    self.shopFiltersPopupReset();
				});
            }
			
			
			/* Bind: Sidebar widget headings */
            var shopWidgetAnimateToggle = (self.isTouch) ? false : true,
                shopWidgetResizeEvent = false;
            self.$shopWrap.on('click', '#nm-shop-sidebar .nm-widget-title', function(e) {
				var $widgetLi = $(this).closest('li');
                
                if ($widgetLi.hasClass('show')) {
                    if (shopWidgetAnimateToggle) {
                        $widgetLi.children('.nm-shop-widget-col').last().css('height', '');
                    }
                    
                    $widgetLi.removeClass('show');
                } else {
                    var $openWidgetLi = $widgetLi.parent('#nm-shop-widgets-ul').children('.show');
                    
                    if (shopWidgetAnimateToggle) {
                        var $widgetContentCol = $widgetLi.children('.nm-shop-widget-col').last(),
                            widgetHeight = $widgetContentCol.children().first().outerHeight(true)+'px', // Note: Get/save the height -before- adding the CSS (to make the animations in-sync)
                            $openWidgetContentCol = $openWidgetLi.children('.nm-shop-widget-col').last();
                        
                        $widgetContentCol.css('height', widgetHeight);
                        $openWidgetContentCol.css('height', ''); // Close open widget
                        
                        // Hide open widget on-resize (widget height can change)
                        if (!shopWidgetResizeEvent) {
                            shopWidgetResizeEvent = true;
                            // Bind single "resize" event
                            self.$window.one('resize.nmShopWidget', function() {
                                self.shopFiltersWidgetHideOpen();
                                shopWidgetResizeEvent = false;
                            });
                        }
                    }
                    
                    $openWidgetLi.removeClass('show');
                    $widgetLi.addClass('show');
                }
			});
            
            
			/* Bind: Sidebar widgets */
			if (self.filtersEnableAjax && self.$pageIncludes.hasClass('shop_filters')) {
				/* 
				 *	Bind custom widgets:
				 *	- Sorting
				 *	- Price 
				 *	- Color
				 */
				self.$shopWrap.on('click', '#nm-shop-sidebar .nm_widget a', function(e) {
					e.preventDefault();
					self.shopGetPage($(this).attr('href'));
				});
				
				/* Bind: "Product Categories" widget */
				self.$shopWrap.on('click', '#nm-shop-sidebar .widget_product_categories a', function(e) {
					e.preventDefault();
					self.shopGetPage($(this).attr('href'));
				});
				
				/* Bind: "Filter Products by Attribute" widget */
				self.$shopWrap.on('click', '#nm-shop-sidebar .widget_layered_nav a', function(e) {
					e.preventDefault();
					self.shopGetPage($(this).attr('href'));
				});
				
                /* 
                 * Bind: "Filter Products by Attribute" widget --select boxes--
                 *
                 * Note: These select elements have default JS events added by WooCommerce, so the code is only needed after shop-filters are replaced with Ajax
                 */
                self.$document.on('nm_ajax_shop_update_content', function() {
                    // Code based on inline WooCommerce script on shop-catalog page
                    self.$shopWrap.on('change', '#nm-shop-sidebar select.woocommerce-widget-layered-nav-dropdown', function() {
                        var $select = $(this),
                            $form = $select.closest('form'),
                            selectVal = $select.val(),
                            selectClass = $select.attr('class'),
                            filterSlug = selectClass.substr(selectClass.lastIndexOf('_')+1), // Get filter-slug from end of select class name
                            $filterInput = $form.find('input[name="filter_'+filterSlug+'"]');
                        
                        if ($filterInput.length) {
                            $filterInput.val(selectVal);

                            if (! $select.attr('multiple')) {
                                $form.submit(); // Submit form for regular select (multi-select has "apply" button)
                            }
                        }
                    });
                });
                
				/* Bind: "Active Product Filters" widget */
				self.$shopWrap.on('click', '#nm-shop-sidebar .widget_layered_nav_filters a', function(e) {
					e.preventDefault();
					self.shopGetPage($(this).attr('href'));
				});
								
				/* Bind: "Product Tag Cloud" widget */
				self.$shopWrap.on('click', '#nm-shop-sidebar .widget_product_tag_cloud a', function(e) {
					e.preventDefault();
					self.shopGetPage($(this).attr('href'), false, true); // Args: pageUrl, isBackButton, isProductTag
				});
                
                /* Bind: "Filter Products by Rating" widget */
                self.$shopWrap.on('click', '#nm-shop-sidebar .widget_rating_filter a', function(e) {
					e.preventDefault();
					self.shopGetPage($(this).attr('href'));
				});
                
                /* Bind: "Filter Products by Price" (slider) widget */
                self.$body.on('price_slider_change', function(event, min, max) {
                    var $priceSliderForm = $('#nm-shop-sidebar').find('.widget_price_filter').first().find('form'),
                        currMin = parseInt($priceSliderForm.find('#min_price').attr('value')),
                        currMax = parseInt($priceSliderForm.find('#max_price').attr('value'));
                    
                    // Make sure price value(s) have changed
                    if (currMin != min || currMax != max) {
                        var formUrl = $priceSliderForm.attr('action'),
                            formValues = $priceSliderForm.serialize(),
                            pageUrl = formUrl+'?'+formValues;

                        self.shopGetPage(pageUrl);
                    }
                });
			}
		},
		
		
		/**
		 *	Shop filters: Toggle categories
		 */
		shopFiltersCategoriesToggle: function() {
			var self = this,
                $shopCategories = $('#nm-shop-categories-wrap'),
                isOpen = $shopCategories.is(':visible');
			
            if (isOpen) {
                $shopCategories.removeClass('fade-in');
            }
            
			$shopCategories.slideToggle(self.filterPanelSlideSpeed, function() {
                if (!isOpen) {
					$shopCategories.addClass('fade-in');
				} else {
                    $shopCategories.removeClass('force-show').css('display', ''); // Remove "force show" after closing
                }
				
				self.filterPanelSliding = false;
			});
		},
		
		
		/**
		 *	Shop filters: Reset categories (remove classes and inline style)
		 */
		shopFiltersCategoriesReset: function() {
			$('#nm-shop-categories-wrap').removeClass('fade-in force-show').css('display', '');
		},
		
		
		/**
		 *	Shop filters: Toggle sidebar filters/widgets panel
		 */
		shopFiltersSidebarToggle: function() {
			var self = this,
				$shopSidebar = $('#nm-shop-sidebar'),
				isOpen = $shopSidebar.is(':visible');
			
			// Hide filters before sliding-up if sidebar is visible
			if (isOpen) {
				$shopSidebar.removeClass('fade-in');
			}
			
			$shopSidebar.slideToggle(self.filterPanelSlideSpeed, function() {
				// Show filters after sliding-down if sidebar is hidden
				if (!isOpen) {
					$shopSidebar.addClass('fade-in');
				}
				
				self.filterPanelSliding = false;
			});
		},
        
        
        /**
         *  Shop Filters: Hide open widget (in "accordion" layout)
         */
        shopFiltersWidgetHideOpen: function() {
            var $openWidgetLi = $('#nm-shop-widgets-ul').children('.show');
            if ($openWidgetLi.length) {
                $openWidgetLi.find('.nm-widget-title').trigger('click'); // Hide open widget
            }
        },
		
        
        /**
		 *	Shop filters: Toggle sidebar filters/widgets panel
		 */
		shopDefaultSidebarToggle: function() {
			var self = this,
				$shopSidebar = $('#nm-shop-sidebar'),
				isOpen = $shopSidebar.is(':visible');
			
			// Hide filters before sliding-up if sidebar is visible
			if (isOpen) {
				$shopSidebar.removeClass('fade-in');
			}
			
			$shopSidebar.slideToggle(self.filterPanelSlideSpeed, function() {
				// Show filters after sliding-down if sidebar is hidden
				if (!isOpen) {
					$shopSidebar.addClass('fade-in');
				}
				
				self.filterPanelSliding = false;
			});
		},
        
		
		/**
		 *	Shop filters: Toggle search panel
		 */
		shopFiltersSearchToggle: function() {
			var self = this;
			
			// Toggle panel
			self.shopSearchTogglePanel();
			
			// Reset search query
			self.currentSearch = '';
		},
        
        
        /**
		 *	Shop filters: Close search panel (if open)
		 */
		shopFiltersSearchClose: function() {
            var self = this;
            
            if (self.searchEnabled && self.$searchBtn.parent('li').hasClass('active')) {
                self.categoryClicked = true; // Adding this to make sure the shop overlay will not be hidden by the search button click event
                self.$searchBtn.trigger('click');
            }
        },
        
		
		/**
		 *	Shop filters: Hide active panel
		 */
		shopFiltersHideActivePanel: function() {
			var self = this,
				to = 0,
				$activeMenu = self.$shopFilterMenu.children('.active');
			
			// Hide active panel
			if ($activeMenu.length) {
				$activeMenu.removeClass('active');
				
				var activeData = $activeMenu.data('panel');
				
				// Categories panel should remain visible, don't "slideToggle"
				if ($activeMenu.is(':hidden') && activeData == 'cat') {
					self.shopFiltersCategoriesReset();
				} else {
					to = 300;
					
					var fn = self.shopFilterMenuFnNames[activeData];
					self[fn]();
				}
			}
			
			// Return timeout
			return to;
		},
        
        
        /**
         *  Shop filters poup: Toggle button
         */
        shopFiltersPopupButtonToggle: function() {
            var self = this;

            var popupBtnOffset = (self.$shopSidebarPopupBtn.hasClass('visible')) // Offset doesn't include button height
                    ? self.$shopSidebarPopupBtn.offset().top + self.$shopSidebarPopupBtn.outerHeight(true)
                    : self.$shopSidebarPopupBtn.offset().top,
                shopOffset = self.$shopBrowseWrap.offset().top,
                tolerance = 190;

            // Is popup-button below start of the Shop (plus tolerance)?
            if (popupBtnOffset > (shopOffset + tolerance)) {
                self.shopFiltersPopupButtonShow();
            } else {
                self.shopFiltersPopupButtonHide();
            }
        },
        
        
        /**
         *  Shop filters poup: Show button
         */
        shopFiltersPopupButtonShow: function() {
            var self = this;
            self.$shopSidebarPopupBtn.addClass('visible');
        },
        
        
        /**
         *  Shop filters poup: Hide button
         */
        shopFiltersPopupButtonHide: function() {
            var self = this;
            self.$shopSidebarPopupBtn.removeClass('visible');
        },
        
        
        /**
         *  Shop filters poup: Show
         */
        shopFiltersPopupShow: function() {
            var self = this;
            
            self.shopFiltersPopupButtonHide();
            
            self.$shopSidebarPopup.addClass('visible');
            self.$body.addClass('shop-filters-popup-open');

            // Bind: Filters popup outside click
            self.$document.on('mouseup.filtersPopup', function(e) {
                if (! self.$shopSidebarPopup.is(e.target) // If the target of the click isn't the container ...
                    && self.$shopSidebarPopup.has(e.target).length === 0) // Nor a descendant of the container
                {
                    self.shopFiltersPopupHide();
                }
            });
        },
		
        
        /**
         *  Shop filters poup: Hide 
         */
        shopFiltersPopupHide: function() {
            var self = this;
            
            self.$shopSidebarPopup.removeClass('visible');
            
            self.shopFiltersPopupButtonToggle(); // Show popup button (if it should be vivisble)
            
            self.$body.removeClass('shop-filters-popup-open');
            self.$document.off('mouseup.filtersPopup');
            
            setTimeout(function() {
                // Reset search
                //$('#nm-shop-search-input').val('');
                self.searchHideNotice();
            }, self.panelsAnimSpeed);
        },
        
        
        /**
         *  Shop filters poup: Reset
         */
        shopFiltersPopupReset: function() {
            var self = this,            
                resetUrl = location.href.replace(location.search, ''); // Get the current URL without query-strings
            
            self.shopGetPage(resetUrl);
            //NM - for testing: self.shopGetPage(resetUrl+'?filters_popup=1');

            self.shopFiltersPopupHide();
        },
		
        
		/**
		 *	Shop: AJAX load shop page from external link
		 */
		shopExternalGetPage: function(pageUrl) {
			var self = this;
			
			//console.log('NM: shopExternalGetPage() URL: '+pageUrl);
						
			if (pageUrl == window.location.href) {
				// Shop page is already loaded, scroll to shop-top
				self.shopScrollToTop();
			} else {
				// Remove current "active" class from categories menu
				$('#nm-shop-categories-wrap').find('.current-cat').removeClass('current-cat');
			
				// Smooth-scroll to top
				var to = self.shopScrollToTop();
				setTimeout(function() {
					self.shopGetPage(pageUrl); // Load shop page
				}, to);
			}
		},
		
		
		/**
		 *	Shop: AJAX load shop page
		 */
		shopGetPage: function(pageUrl, isBackButton, isProductTag) {
			var self = this;
			
			if (self.shopAjax) { return false; }
			
			if (pageUrl) {
				// Remove any visible shop notices
				self.shopRemoveNotices();
				
                if (self.shopSidebarLayout == 'popup') {
                    // Hide filters popup
                    self.shopFiltersPopupHide();
                }
				
				// Hide active filter panel and scroll/jump to shop-top (if browser has "mobile" width)
				if (self.$body.width() < self.filterPanelHideWidth) {
                    // Show 'loader' overlay
                    self.shopShowLoader(true); // Args: disableAnimation

                    var orgToggleSpeed = self.filterPanelSlideSpeed; // Save original panel slide speed
                    self.filterPanelSlideSpeed = 0; // Disable panel slide speed
                    
                    self.shopFiltersHideActivePanel(); // Hide active filter panel

                    self.filterPanelSlideSpeed = orgToggleSpeed; // Reset panel slide speed
				} else {
                    // Show 'loader' overlay
                    self.shopShowLoader();
				}
				
				// Make sure the URL has a trailing-slash before query args (301 redirect fix)
				pageUrl = pageUrl.replace(/\/?(\?|#|$)/, '/$1');
				
				// Set browser history "pushState" (if not back button "popstate" event)
				if (!isBackButton) {
					self.setPushState(pageUrl);
				}
                    
				self.shopAjax = $.ajax({
					url: pageUrl,
					data: {
						shop_load: 'full',
                        shop_filters_layout: self.shopSidebarLayout
					},
					dataType: 'html',
					cache: false,
					headers: {'cache-control': 'no-cache'},
					
					method: 'POST', // Note: Using "POST" method for the Ajax request to avoid "shop_load" query-string in pagination links
					
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						console.log('NM: AJAX error - shopGetPage() - ' + errorThrown);
						
						// Hide 'loader' overlay (after scroll animation)
						self.shopHideLoader();
						
						self.shopAjax = false;
					},
					success: function(response) {
						// Update shop content
						self.shopUpdateContent(response);
						
						self.shopAjax = false;
					}
				});
			}
		},
        
        
		/**
		 *	Shop: Update shop content with AJAX HTML
		 */
		shopUpdateContent: function(ajaxHTML) {
			var self = this,
				$ajaxHTML = $('<div>' + ajaxHTML + '</div>'); // Wrap the returned HTML string in a dummy 'div' element we can get the elements
			
			// Page title - wp_title()
			if (nm_wp_vars.shopAjaxUpdateTitle) {
				var wpTitle = $ajaxHTML.find('#nm-wp-title').text();
				if (wpTitle.length) {
					// Update document/page title
					document.title = wpTitle;
				}
			}
			
			// Extract elements
            var $ajaxBodyClass = $ajaxHTML.find('#nm-body-class'),
                $ajaxTaxonomyBanner = $ajaxHTML.find('#nm-shop-taxonomy-header'),
                $ajaxTaxonomyHeading = $ajaxHTML.find('.nm-shop-taxonomy-heading'),
                $ajaxCategories = $ajaxHTML.find('#nm-shop-categories-wrap'),
				$ajaxSidebarFilters = $ajaxHTML.find('#nm-shop-widgets-ul'),
				$ajaxShopBrowseWrap = $ajaxHTML.find('#nm-shop-browse-wrap');
            
            // Replace: Body archive/taxonomy class
            if ($ajaxBodyClass.hasClass('post-type-archive')) {
                self.$body.removeClass('tax-product_cat tax-product_tag').addClass('post-type-archive post-type-archive-product');
            } else if ($ajaxBodyClass.hasClass('tax-product_cat')) {
                self.$body.removeClass('post-type-archive post-type-archive-product tax-product_tag').addClass('tax-product_cat');
            } else if ($ajaxBodyClass.hasClass('tax-product_tag')) {
                self.$body.removeClass('post-type-archive post-type-archive-product tax-product_cat').addClass('tax-product_tag');
            }
            
            // Replace: Taxonomy banner
            if ($ajaxTaxonomyBanner.length) {
                var $taxonomyBanner = $('#nm-shop-taxonomy-header');/*,
                    taxonomyBannerURL = $taxonomyBanner.children('.nm-shop-taxonomy-header-inner').css('background-image'),
                    ajaxTaxonomyBannerURL = $ajaxTaxonomyBanner.children('.nm-shop-taxonomy-header-inner').css('background-image');*/
                
                // Make sure banner has changed
                //Removed - Categories might use the same image: if (taxonomyBannerURL !== ajaxTaxonomyBannerURL) {
                    $taxonomyBanner.replaceWith($ajaxTaxonomyBanner);
                //}
                
                $taxonomyBanner.removeClass('hidden');
            } else {
                $('#nm-shop-taxonomy-header').addClass('hidden');
            }
            
            // Replace: Taxonomy heading
            if ($ajaxTaxonomyHeading.length) {
                $('.nm-shop-taxonomy-heading').replaceWith($ajaxTaxonomyHeading);
            } else {
                $('.nm-shop-taxonomy-heading').addClass('hidden');
            }
            
			// Replace: Categories
			if ($ajaxCategories.length) {
				var $shopCategories = $('#nm-shop-categories-wrap');
				
				// Is the category menu open? -add 'force-show' class
				if ($shopCategories.hasClass('fade-in')) {
					$ajaxCategories.addClass('fade-in force-show');
				}
				
				$shopCategories.replaceWith($ajaxCategories); 
			}
            
			// Replace: Sidebar filters
            if ($ajaxSidebarFilters.length) {
                $('#nm-shop-widgets-ul').replaceWith($ajaxSidebarFilters);
                
                self.shopFiltersInitPriceSlider();
            }
            
			// Replace: Shop
			if ($ajaxShopBrowseWrap.length) {
				self.$shopBrowseWrap.replaceWith($ajaxShopBrowseWrap);
			}
			
            self.$document.trigger('nm_ajax_shop_update_content', $ajaxHTML);
            
			// Get the new shop browse wrap
			self.$shopBrowseWrap = $('#nm-shop-browse-wrap');
			
			
			if (! self.shopInfLoadBound) {
				// Bind "infinite load" if enabled (initial shop page didn't have pagination)
				self.infload_init();
			}
			
			
			// Smooth-scroll to top
			var to = self.shopScrollToTop();
			setTimeout(function() {
				// Hide 'loader' overlay (after scroll animation)
				self.shopHideLoader();
			}, to);
		},
        
        
        /**
		 *	Shop widget: Price Slider (Filter Products by Price) - Re-init
         *
         *  NOTE: Code below copied from "../woocommerce/assets/js/frontend/price-slider.js" since no public function is available
		 */
        shopFiltersInitPriceSlider: function() {
            // woocommerce_price_slider_params is required to continue, ensure the object exists
            if ( typeof woocommerce_price_slider_params === 'undefined' ) {
                return false;
            }

            //NM: $( document.body ).bind( 'price_slider_create price_slider_slide', function( event, min, max ) {
            $( document.body ).on( 'price_slider_create price_slider_slide', function( event, min, max ) {

                $( '.price_slider_amount span.from' ).html( accounting.formatMoney( min, {
                    symbol:    woocommerce_price_slider_params.currency_format_symbol,
                    decimal:   woocommerce_price_slider_params.currency_format_decimal_sep,
                    thousand:  woocommerce_price_slider_params.currency_format_thousand_sep,
                    precision: woocommerce_price_slider_params.currency_format_num_decimals,
                    format:    woocommerce_price_slider_params.currency_format
                } ) );

                $( '.price_slider_amount span.to' ).html( accounting.formatMoney( max, {
                    symbol:    woocommerce_price_slider_params.currency_format_symbol,
                    decimal:   woocommerce_price_slider_params.currency_format_decimal_sep,
                    thousand:  woocommerce_price_slider_params.currency_format_thousand_sep,
                    precision: woocommerce_price_slider_params.currency_format_num_decimals,
                    format:    woocommerce_price_slider_params.currency_format
                } ) );

                $( document.body ).trigger( 'price_slider_updated', [ min, max ] );
            });

            function init_price_filter() {
                $( 'input#min_price, input#max_price' ).hide();
                $( '.price_slider, .price_label' ).show();

                var min_price         = $( '.price_slider_amount #min_price' ).data( 'min' ),
                    max_price         = $( '.price_slider_amount #max_price' ).data( 'max' ),
                    step              = $( '.price_slider_amount' ).data( 'step' ) || 1,
                    current_min_price = $( '.price_slider_amount #min_price' ).val(),
                    current_max_price = $( '.price_slider_amount #max_price' ).val();

                $( '.price_slider:not(.ui-slider)' ).slider({
                    range: true,
                    animate: true,
                    min: min_price,
                    max: max_price,
                    step: step,
                    values: [ current_min_price, current_max_price ],
                    create: function() {

                        $( '.price_slider_amount #min_price' ).val( current_min_price );
                        $( '.price_slider_amount #max_price' ).val( current_max_price );

                        $( document.body ).trigger( 'price_slider_create', [ current_min_price, current_max_price ] );
                    },
                    slide: function( event, ui ) {

                        $( 'input#min_price' ).val( ui.values[0] );
                        $( 'input#max_price' ).val( ui.values[1] );

                        $( document.body ).trigger( 'price_slider_slide', [ ui.values[0], ui.values[1] ] );
                    },
                    change: function( event, ui ) {

                        $( document.body ).trigger( 'price_slider_change', [ ui.values[0], ui.values[1] ] );
                    }
                });
            }

            init_price_filter();    
        }
		
	});
	
	// Add extension so it can be called from $.nmThemeExtensions
	$.nmThemeExtensions.filters = $.nmTheme.filters_init;
	
})(jQuery);
