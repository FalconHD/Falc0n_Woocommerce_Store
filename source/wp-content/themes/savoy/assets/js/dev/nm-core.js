(function($) {
	
	'use strict';
	
	if (!$.nmThemeExtensions)
		$.nmThemeExtensions = {};
	
	function NmTheme() {
		// Initialize scripts
		this.init();
	};
	
	
	NmTheme.prototype = {
	
		/**
		 *	Initialize
		 */
		init: function() {
			var self = this;
            
            // CSS Classes
            self.classHeaderFixed = 'header-on-scroll';
            self.classMobileMenuOpen = 'mobile-menu-open';
            self.classSearchOpen = 'header-search-open';
            self.classWidgetPanelOpen = 'widget-panel-open';

            // Page elements
            self.$window = $(window);
            self.$document = $(document);
            self.$html = $('html');
            self.$body = $('body');

            // Page includes element
            self.$pageIncludes = $('#nm-page-includes');

            // Page overlay
            self.$pageOverlay = $('#nm-page-overlay');

            // Header
            self.$topBar = $('#nm-top-bar');
            self.$header = $('#nm-header');
            self.$headerPlaceholder = $('#nm-header-placeholder');
            self.headerScrollTolerance = 0;

            // Mobile menu
            self.$mobileMenuBtn = $('#nm-mobile-menu-button');
            self.$mobileMenu = $('#nm-mobile-menu');
            self.$mobileMenuScroller = self.$mobileMenu.children('.nm-mobile-menu-scroll');
            self.$mobileMenuLi = self.$mobileMenu.find('ul li.menu-item');

            // Widget panel
            self.$widgetPanel = $('#nm-widget-panel');
            self.widgetPanelAnimSpeed = 250;

            // Slide panels animation speed
            self.panelsAnimSpeed = 200;

            // Shop
            self.$shopWrap = $('#nm-shop');
            self.isShop = (self.$shopWrap.length) ? true : false;
            self.shopCustomSelect = (nm_wp_vars.shopCustomSelect != '0') ? true : false;

            // Search
            self.searchEnabled = (nm_wp_vars.shopSearch !== '0') ? true : false;
            
            // Check if browser uses the Chromium engine
            self.isChromium = !!window.chrome;
            
            /* Page-load transition */
            if (nm_wp_vars.pageLoadTransition != '0') {
                self.isIos = navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPhone/i);
                if (!self.isIos) {
                    self.$window.on('beforeunload', function(e) {
                        $('#nm-page-load-overlay').addClass('nm-loader'); // Show preloader animation
                        self.$html.removeClass('nm-page-loaded');
                    });
                }
                // Hide page-load overlay - Note: Using the "pageshow" event so the overlay is hidden when the browser "back" button is used (only seems to be needed in Safari though)
                if ('onpagehide' in window) {
                    window.addEventListener('pageshow', function() {
                        setTimeout(function() { self.$html.addClass('nm-page-loaded'); }, 150);
                    }, false);
                } else {
                    setTimeout(function() { self.$html.addClass('nm-page-loaded'); }, 150);
                }
            }
            
			// Remove the CSS transition preload class
			self.$body.removeClass('nm-preload');
			
            // Check for touch device (modernizr)
			self.isTouch = (self.$html.hasClass('touch')) ? true : false;
			
            // Add "has-hover" class - Makes it possible to add :hover selectors for non-touch devices only
            if (self.isTouch) {
                if (nm_wp_vars.touchHover != '0') { self.$html.addClass('has-hover'); }
            } else {
                self.$html.addClass('has-hover');
            }
            
			// Fixed header
			self.headerIsFixed = (self.$body.hasClass('header-fixed')) ? true : false;
			
			// History (browser "back" button): Init
			var enablePushState = (nm_wp_vars.pushStateMobile != '0' || self.$html.hasClass('no-touch')) ? true : false;
            if (enablePushState && self.$html.hasClass('history')) {
				self.hasPushState = true;
				window.history.replaceState({nmShop: true}, '', window.location.href);
			} else {
				self.hasPushState = false;
			}
			
            // Scrollbar
            self.setScrollbarWidth();
            
			// Init header
			self.headerCheckPlaceholderHeight(); // Make sure the header and header-placeholder has the same height
			if (self.headerIsFixed) {
				self.headerSetScrollTolerance();
				self.mobileMenuPrep();
			}
            
            // Init widget panel
			self.widgetPanelPrep();
			
			// Check for old IE browser (IE10 or below)
			var ua = window.navigator.userAgent,
            	msie = ua.indexOf('MSIE ');
			if (msie > 0) {
				self.$html.addClass('nm-old-ie');
			}
            
			// Load extension scripts
			self.loadExtension();
			
			self.bind();
			self.initPageIncludes();
            
			
			// "Add to cart" redirect: Show cart panel
			if (self.$body.hasClass('nm-added-to-cart')) {
				self.$body.removeClass('nm-added-to-cart')
				
                self.$window.on('load', function() {
					// Is widget/cart panel enabled?
					if (self.$widgetPanel.length) {
                        // Show cart panel
                        self.widgetPanelShow(true, true); // Args: showLoader, addingToCart
                        // Hide cart panel "loader" overlay
                        setTimeout(function() { self.widgetPanelCartHideLoader(); }, 1000);
                    }
				});
			}
		},
		
		
		/**
		 *	Extensions: Load scripts
		 */
		loadExtension: function() {
			var self = this;
            
			// Extension: Shop
			if ($.nmThemeExtensions.shop) {
				$.nmThemeExtensions.shop.call(self);
			}
            
            // Extension: Search
            if (self.searchEnabled && $.nmThemeExtensions.search) {
                $.nmThemeExtensions.search.call(self);
            }
				
			// Extension: Shop - Single product
			if ($.nmThemeExtensions.singleProduct) {
				$.nmThemeExtensions.singleProduct.call(self);
			}
				
			// Extension: Shop - Cart
			if ($.nmThemeExtensions.cart) {
				$.nmThemeExtensions.cart.call(self);
			}
			
			// Extension: Shop - Checkout
			if ($.nmThemeExtensions.checkout) {
				$.nmThemeExtensions.checkout.call(self);
			}
            
            // Extension: Blog
			if ($.nmThemeExtensions.blog) {
				$.nmThemeExtensions.blog.call(self);
			}
		},
		
        
		/**
		 *  Helper: Calculate scrollbar width
		 */
		setScrollbarWidth: function() {
			// From Magnific Popup v1.0.0
			var self = this,
				scrollDiv = document.createElement('div');
			scrollDiv.style.cssText = 'width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;';
			document.body.appendChild(scrollDiv);
			self.scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;
			document.body.removeChild(scrollDiv);
			// /Magnific Popup
		},
        
        
        /**
		 *	Helper: Is page vertically scrollable?
		 */
        pageIsScrollable: function() {
            return document.body.scrollHeight > document.body.clientHeight;
            //jQuery alt: return self.$body.height() > self.$window.height();
        },
        
        
        /**
		 *  Helper: Get parameter from current page URL
		 */
        urlGetParameter: function(param) {
            var url = decodeURIComponent(window.location.search.substring(1)),
                urlVars = url.split('&'),
                paramName, i;

            for (i = 0; i < urlVars.length; i++) {
                paramName = urlVars[i].split('=');
                if (paramName[0] === param) {
                    return paramName[1] === undefined ? true : paramName[1];
                }
            }
        },
		
		
		/**
		 *  Helper: Add/update a key-value pair in the URL query parameters 
		 */
		updateUrlParameter: function(uri, key, value) {
			// Remove #hash before operating on the uri
			var i = uri.indexOf('#'),
				hash = i === -1 ? '' : uri.substr(i);
			uri = (i === -1) ? uri : uri.substr(0, i);
			
			var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i"),
				separator = (uri.indexOf('?') !== -1) ? "&" : "?";
			
			if (uri.match(re)) {
				uri = uri.replace(re, '$1' + key + "=" + value + '$2');
			} else {
				uri = uri + separator + key + "=" + value;
			}
			
			return uri + hash; // Append #hash
		},
		
		
		/**
		 *	Helper: Set browser history "pushState" (AJAX url)
		 */
		setPushState: function(pageUrl) {
			var self = this;
			
			// Set browser "pushState"
			if (self.hasPushState) {
				window.history.pushState({nmShop: true}, '', pageUrl);
			}
		},
		
		
		/**
		 *	Header: Check/set placeholder height
		 */
		headerCheckPlaceholderHeight: function() {
			var self = this;
			
            if (nm_wp_vars.headerPlaceholderSetHeight == 0) {
                console.log('NM: Header placeholder height NOT set');
                return false;
            }
            
			// Make sure the header is not fixed/floated
			if (self.$body.hasClass(self.classHeaderFixed)) {
				return;
			}
			
            var headerHeight = Math.round(self.$header.innerHeight()),
				headerPlaceholderHeight = Math.round(parseInt(self.$headerPlaceholder.css('height')));
            
            // Is there a height difference of more than 1 pixel between the header and header-placeholder?
            if (Math.abs(headerHeight - headerPlaceholderHeight) > 1) {
                self.$headerPlaceholder.css('height', headerHeight+'px');
			}
		},
		
		
		/**
		 *	Header: Set scroll tolerance
		 */
		headerSetScrollTolerance: function() {
			var self = this;
			
			self.headerScrollTolerance = (self.$topBar.length && self.$topBar.is(':visible')) ? self.$topBar.outerHeight(true) : 0;
		},
        
        
        /**
		 *	Header: Toggle fixed class
		 */
        headerToggleFixedClass: function(self) {
            if (self.$document.scrollTop() > self.headerScrollTolerance) {
                if (!self.$body.hasClass(self.classHeaderFixed)) {
                    self.$body.addClass(self.classHeaderFixed);
                }
            } else {
                if (self.$body.hasClass(self.classHeaderFixed)) {
                    self.$body.removeClass(self.classHeaderFixed);
                }
            }
        },
		
		
		/**
		 *	Bind scripts
		 */
		bind: function() {
			var self = this;
			
            
			/* Bind: Window resize */
			var timer = null;
			self.$window.resize(function() {
				if (timer) { clearTimeout(timer); }
				timer = setTimeout(function() {
					// Make sure the header and header-placeholder has the same height
					self.headerCheckPlaceholderHeight();
																	
					if (self.headerIsFixed) {
						self.headerSetScrollTolerance();
						self.mobileMenuPrep();
					}
				}, 250);
			});
            
            
            /* Media query matching */
            var _hideMobileMenu = function(mediaQuery) {
                if (mediaQuery.matches && self.$body.hasClass(self.classMobileMenuOpen)) {
                    self.pageOverlayHide();
                }
            },
            _hideHeaderSearch = function(mediaQuery) {
                if (mediaQuery.matches && self.$body.hasClass(self.classSearchOpen)) {
                    self.pageOverlayHide();
                }
            },
            breakpointMobileMenu = window.matchMedia('(min-width: 992px)'),
            breakpointHeaderSearch = window.matchMedia('(max-width: 991px)');
            breakpointMobileMenu.addListener(_hideMobileMenu);
            breakpointHeaderSearch.addListener(_hideHeaderSearch);
            
            
            /* Bind: Mobile "orientationchange" event */
            if (self.isTouch) {
                self.$window.on('orientationchange', function() {
                    self.$body.addClass('touch-orientation-change');
                    setTimeout(function() { 
                        self.$body.removeClass('touch-orientation-change');
                    }, 500);
                });
            }
            
			
			/* Bind: Window scroll (Fixed header) */
			if (self.headerIsFixed) {
                self.$window.on('scroll.nmheader', function() {
                    self.headerToggleFixedClass(self);
                });
                
				self.$window.trigger('scroll');
			}
			
			
			/* Bind: Menus - Sub-menu hover (set position and "bridge" height) */
			var $topMenuItems = $('#nm-top-menu').children('.menu-item'),
				$mainMenuItems = $('#nm-main-menu-ul').children('.menu-item'),
                $secondaryMenuItems = $('#nm-right-menu-ul').children('.menu-item'),
                $menuItems = $().add($topMenuItems).add($mainMenuItems).add($secondaryMenuItems);
            
            $menuItems.mouseenter(function() {
                var $menuItem = $(this),
                    $subMenu = $menuItem.children('.sub-menu');
                
                if ($subMenu.length) {
                    // Sub-menu: Set position/offset (prevents menu from being positioned outside the browser window)
                    var windowWidth = self.$window.innerWidth(),
                        subMenuOffset = $subMenu.offset().left,
                        subMenuWidth = $subMenu.width(),
                        subMenuGap = windowWidth - (subMenuOffset + subMenuWidth);
                    if (subMenuGap < 0) {
                        $subMenu.css('left', (subMenuGap-33)+'px');
                    }
                    
                    // Header sub-menus: Set "bridge" height (prevents menu from closing when hovering outside its parent <li> element)
                    if (! $menuItem.hasClass('bridge-height-set')) {
                        var $headerMenuContainer = $menuItem.closest('nav');
                        if ($headerMenuContainer.length) {
                            $menuItem.addClass('bridge-height-set');
                            var menuBridgeHeight = Math.ceil(($headerMenuContainer.height() - $menuItem.height()) / 2);
                            $subMenu.children('.nm-sub-menu-bridge').css('height', (menuBridgeHeight + 1) + 'px');
                        }
                    }
                }
            }).mouseleave(function() {
                // Reset sub-menu position
                var $subMenu = $(this).children('.sub-menu');
                if ($subMenu.length) {
                    $subMenu.css('left', '');
                }
            });
			
            
            /* Bind: Header - Shop links */
            if (! self.isShop) {
                self.$header.on('click.nmHeaderShopRedirect', '.shop-redirect-link', function(e) {
                    e.preventDefault();
                    var url = $(this).children('a').attr('href');
                    window.location.href = url + '#shop';
                });
            }
			
            
			/* Bind: Mobile menu button */
			self.$mobileMenuBtn.on('click', function(e) {
				e.preventDefault();
				
				if (!self.$body.hasClass(self.classMobileMenuOpen)) {
					self.mobileMenuOpen();
				} else {
					self.mobileMenuClose(true); // Args: hideOverlay
				}
			});
			
			/* Function: Mobile menu - Toggle sub-menu */
			var _mobileMenuToggleSub = function($menu, $subMenu) {
                $menu.toggleClass('active');
				$subMenu.toggleClass('open');
			};
			
			/* Bind: Mobile menu list elements */
			self.$mobileMenuLi.on('click.nmMenuToggle', function(e) {
				e.stopPropagation(); // Prevent click event on parent menu link
                
				var $this = $(this),
					$thisSubMenu = $this.children('ul');
                
                if ($thisSubMenu.length) {
                    // Prevent toggle when "nm-notoggle" class is added -and- the "plus" icon wasn't clicked
                    if ($this.hasClass('nm-notoggle') && ! $(e.target).hasClass('nm-menu-toggle')) { return; }
                    
                    e.preventDefault();
                    _mobileMenuToggleSub($this, $thisSubMenu);
				}
			});
			
			
			/* Bind: Widget panel */
			if (self.$widgetPanel.length) {
				self.widgetPanelBind();
			}
			
			
			/* Bind: Login/register popup */
			if (self.$pageIncludes.hasClass('login-popup')) {
                var nonceValuesUpdated = false;
                
				$('#nm-menu-account-btn').on('click.nmLoginShowPopup', function(e) {
					e.preventDefault();
					
                    // Checkout page fix: Make sure the login form is visible
                    $('#nm-login-wrap').children('.login').css('display', '');
                    
					$.magnificPopup.open({
						mainClass: 'nm-login-popup nm-mfp-fade-in',
						alignTop: true,
						closeMarkup: '<a class="mfp-close nm-font nm-font-close2"></a>',
						removalDelay: 180,
						items: {
							src: '#nm-login-popup-wrap',
							type: 'inline'
						},
						callbacks: {
                            open: function() {
                                if (nonceValuesUpdated) { return; }
                                nonceValuesUpdated = true;
                                
                                // Update popup "nonce" input values so the form can be submitted on cached pages
                                $.ajax({
                                    type: 'POST',
                                    //url: nm_wp_vars.ajaxUrl,
                                    //data: { action: 'nm_ajax_login_get_nonce_fields' },
                                    url: wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nm_ajax_login_get_nonces'),
                                    dataType: 'json',
                                    cache: false,
                                    headers: {'cache-control': 'no-cache'},
                                    success: function(noncesJson) {
                                        $('#woocommerce-login-nonce').attr('value', noncesJson.login);
                                        $('#woocommerce-register-nonce').attr('value', noncesJson.register);
                                    }
                                });
                            },
							close: function() {
								// Make sure the login form is displayed when the modal is re-opened
								$('#nm-login-wrap').addClass('inline fade-in slide-up');
								$('#nm-register-wrap').removeClass('inline fade-in slide-up');
							}
						}
					});
				});
			}
			
			
			/* Bind: Page overlay */
            self.$pageOverlay.on('click', function() {
				self.pageOverlayHide();
			});
		},
		
        
        /**
		 *	Page overlay: Show
		 */
		pageOverlayShow: function() {
            var self = this;
            
            // Mobile menu
            if (self.$body.hasClass(self.classMobileMenuOpen)) {
                self.$pageOverlay.addClass('nm-mobile-menu-overlay');
            // Header search
            } else if (self.$body.hasClass(self.classSearchOpen)) {
                self.$pageOverlay.addClass('nm-header-search-overlay');
            // Widget panel
            } else if (self.$body.hasClass(self.classWidgetPanelOpen)) {
                self.$pageOverlay.addClass('nm-widget-panel-overlay');
            }
            
            self.$pageOverlay.addClass('show');
		},
        
        
        /**
		 *	Page overlay: Hide
		 */
		pageOverlayHide: function() {
            var self = this;
            
            // Mobile menu
            if (self.$body.hasClass(self.classMobileMenuOpen)) {
                self.mobileMenuClose(false); // Args: hideOverlay
            // Header search
            } else if (self.$body.hasClass(self.classSearchOpen)) {
                self.headerSearchTogglePanel();
            // Widget panel
            } else if (self.$body.hasClass(self.classWidgetPanelOpen)) {
                self.widgetPanelHide();
            }
            
            // Trigger "nm_page_overlay_hide" event
            self.$body.trigger('nm_page_overlay_hide');
            
            self.$pageOverlay.addClass('fade-out');
            setTimeout(function() {
                self.$pageOverlay.removeClass(); // Remove all classes from page-overlay element
            }, self.panelsAnimSpeed);
		},
        
		
		/**
		 *	Mobile menu: Prepare (add CSS)
		 */
		mobileMenuPrep: function() {
			var self = this,
				windowHeight = self.$window.height() - self.$header.outerHeight(true);
			
			self.$mobileMenuScroller.css({'max-height': windowHeight+'px', 'margin-right': '-'+self.scrollbarWidth+'px'});
		},
        
        
        /**
		 *	Mobile menu: Open
		 */
		mobileMenuOpen: function(hideOverlay) {
            var self = this,
                headerPosition = self.$header.outerHeight(true);
            
            self.$mobileMenuScroller.css('margin-top', headerPosition+'px');
            
            self.$body.addClass(self.classMobileMenuOpen);
            self.pageOverlayShow();
        },
        
        
        /**
		 *	Mobile menu: Close
		 */
		mobileMenuClose: function(hideOverlay) {
            var self = this;
            
            self.$body.removeClass(self.classMobileMenuOpen);
            
            if (hideOverlay) {
                self.pageOverlayHide();
            }

            // Hide open menus (first level only)
            setTimeout(function() {
                $('#nm-mobile-menu-main-ul').children('.active').removeClass('active').children('ul').removeClass('open');
                $('#nm-mobile-menu-secondary-ul').children('.active').removeClass('active').children('ul').removeClass('open');
            }, 250);
        },
        
        
		/**
		 *	Widget panel: Prepare
		 */
		widgetPanelPrep: function() {
			var self = this;
            
            // Cart panel: Hide scrollbar
            self.widgetPanelCartHideScrollbar();
            
            // Cart panel: Set Ajax state
            self.cartPanelAjax = null;
            
            if (nm_wp_vars.cartPanelQtyArrows != '0') {
                // Cart panel: Bind quantity-input buttons
                self.quantityInputsBindButtons(self.$widgetPanel);

                // Cart panel - Quantity inputs: Bind "blur" event
                self.$widgetPanel.on('blur', 'input.qty', function() {
                    var $quantityInput = $(this),
                        currentVal = parseFloat($quantityInput.val()),
                        max	= parseFloat($quantityInput.attr('max'));

                    // Validate input values
                    if (currentVal === '' || currentVal === 'NaN') { currentVal = 0; }
                    if (max === 'NaN') { max = ''; }

                    // Make sure the value is not higher than the max value
                    if (currentVal > max) { 
                        $quantityInput.val(max);
                        currentVal = max;
                    };

                    // Is the quantity value more than 0?
                    if (currentVal > 0) {
                        self.widgetPanelCartUpdate($quantityInput);
                    }
                });

                // Cart panel - Quantity inputs: Bind "nm_qty_change" event
                self.$document.on('nm_qty_change', function(event, quantityInput) {
                    // Is the widget-panel open?
                    if (self.$body.hasClass(self.classWidgetPanelOpen)) {
                        self.widgetPanelCartUpdate($(quantityInput));
                    }
                });
            }
		},
        
        
		/**
		 *	Widget panel: Bind
		 */
		widgetPanelBind: function() {
			var self = this;
			
			// Touch event handling
			if (self.isTouch) {
				//if (self.headerIsFixed) { // Allow page overlay "touchmove" event if header is not fixed/floating
                // Bind: Page overlay "touchmove" event
                self.$pageOverlay.on('touchmove', function(e) {
                    e.preventDefault(); // Prevent default touch event
                });
				//}
				
				// Bind: Widget panel "touchmove" event
				self.$widgetPanel.on('touchmove', function(e) {				
					e.stopPropagation(); // Prevent event propagation (bubbling)
				});
			}
			
			/* Bind: "Cart" buttons */
			$('#nm-menu-cart-btn, #nm-mobile-menu-cart-btn').on('click.nmAtc', function(e) {
				e.preventDefault();										
				
				// Close the mobile menu first					
				if (self.$body.hasClass(self.classMobileMenuOpen)) {
					var $this = $(this);
                    self.pageOverlayHide();
					setTimeout(function() {
						$this.trigger('click'); // Trigger this function again
					}, self.panelsAnimSpeed);
				} else {
				    self.widgetPanelShow();
                }
			});
			
			/* Bind: "Close" button */
			$('#nm-widget-panel-close').on('click.nmWidgetPanelClose', function(e) {
				e.preventDefault();
                self.pageOverlayHide();
			});
            
            /* Bind: "Continue shopping" button */
			self.$widgetPanel.on('click.nmCartPanelClose', '#nm-cart-panel-continue', function(e) {
				e.preventDefault();
                self.pageOverlayHide();
			});
		},
        
        
		/**
		 *	Widget panel: Show
		 */
		widgetPanelShow: function(showLoader, addingToCart) {
			var self = this;
            
            // Show widget/cart panel on add-to-cart?
            if (addingToCart && nm_wp_vars.cartPanelShowOnAtc == '0') {
                self.shopShowNotices();
                return;
            }
            
			if (showLoader) {
                self.widgetPanelCartShowLoader();
			}
			
            self.$body.addClass('widget-panel-opening '+self.classWidgetPanelOpen);
            self.pageOverlayShow();
            
            setTimeout(function() {
                self.$body.removeClass('widget-panel-opening');
            }, self.widgetPanelAnimSpeed);
		},
        
        
        /**
		 *	Widget panel: Hide
		 */
		widgetPanelHide: function() {
			var self = this;
			
            self.$body.addClass('widget-panel-closing');
            self.$body.removeClass(self.classWidgetPanelOpen);
            
            setTimeout(function() {
                self.$body.removeClass('widget-panel-closing');
            }, self.widgetPanelAnimSpeed);
		},
		
        
        /**
		 *	Widget panel: Cart - Show loader
		 */
		widgetPanelCartShowLoader: function() {
			$('#nm-cart-panel-loader').addClass('show');
		},
        
		
		/**
		 *	Widget panel: Cart - Hide loader
		 */
		widgetPanelCartHideLoader: function() {
            var self = this;
            
			$('#nm-cart-panel-loader').addClass('fade-out');
			setTimeout(function() {
                $('#nm-cart-panel-loader').removeClass('fade-out show');
            }, 200);
		},
        
        
        /**
		 *	Widget panel: Cart - Hide scrollbar
		 */
		widgetPanelCartHideScrollbar: function() {
            var self = this;
            self.$widgetPanel.children('.nm-widget-panel-inner').css('marginRight', '-'+self.scrollbarWidth+'px');
        },
		
		
        /**
		 *	Widget panel: Cart - Update quantity
         *
         *  Note: Based on the "quantity_update" function in "../woocommerce/assets/js/frontend/cart.js"
		 */
        widgetPanelCartUpdate: function($quantityInput) {
            var self = this;
            
            // Is an Ajax request already running?
            if (self.cartPanelAjax) {
                self.cartPanelAjax.abort(); // Abort current Ajax request
            }
            
            // Show thumbnail loader
            $quantityInput.closest('li').addClass('loading');
            
            var $cartForm = $('#nm-cart-panel-form'), // The "#nm-cart-panel-form" element is placed in the "../footer.php" file
                $cartFormNonce = $cartForm.find('#_wpnonce'),
                data = {};
            
            if ( ! $cartFormNonce.length ) {
                console.log( 'NM - widgetPanelCartUpdate: Nonce field not found.' );
                return;
            }
            
            data['nm_cart_panel_update'] = '1';
			data['update_cart'] = '1';
            data[$quantityInput.attr('name')] = $quantityInput.val();
            data['_wpnonce'] = $cartFormNonce.val();
            
			// Make call to actual form post URL.
			self.cartPanelAjax = $.ajax({
				type:     'POST',
				url:      $cartForm.attr('action'),
                data:     data,
				dataType: 'html',
				error: function(XMLHttpRequest, textStatus, errorThrown) {
				    console.log('NM: AJAX error - widgetPanelCartUpdate() - ' + errorThrown);
                    
                    // Hide any visible thumbnail loaders (no need to hide on "success" since the cart panel is replaced)
                    $('#nm-cart-panel .cart_list').children('.loading').removeClass('loading');
                },
                success:  function(response) {
                    // Replace cart fragments
                    $(document.body).trigger('wc_fragment_refresh').trigger('updated_cart_totals');
				},
				complete: function() {
                    self.cartPanelAjax = null; // Reset Ajax state
                }
			});
        },
        
        
        /**
		 *	Shop: Replace fragments
		 */
        shopReplaceFragments: function(fragments) {
            var $fragment;
            $.each(fragments, function(selector, fragment) {
                $fragment = $(fragment);
                if ($fragment.length) {
                    $(selector).replaceWith($fragment);
                }
            });
        },
        
        
        /**
		 *	Quantity inputs: Bind buttons
		 */
		quantityInputsBindButtons: function($container) {
			var self = this,
                clickThrottle,
                clickThrottleTimeout = nm_wp_vars.cartPanelQtyThrottleTimeout;
            
			/* 
			 *	Bind buttons click event
			 *	Note: Modified code from WooCommerce core (v2.2.6)
			 */
			$container.off('click.nmQty').on('click.nmQty', '.nm-qty-plus, .nm-qty-minus', function() {
				if (clickThrottle) { clearTimeout(clickThrottle); }
                
                // Get elements and values
				var $this		= $(this),
					$qty		= $this.closest('.quantity').find('.qty'),
					currentVal	= parseFloat($qty.val()),
					max			= parseFloat($qty.attr('max')),
					min			= parseFloat($qty.attr('min')),
					step		= $qty.attr('step');
				
				// Format values
				if (!currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
				if (max === '' || max === 'NaN') max = '';
				if (min === '' || min === 'NaN') min = 0;
				if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = 1;
                
				// Change the value
				if ($this.hasClass('nm-qty-plus')) {
					if (max && (max == currentVal || currentVal > max)) {
						$qty.val(max);
					} else {
						$qty.val(currentVal + parseFloat(step));
                        clickThrottle = setTimeout(function() { self.quantityInputsTriggerEvents($qty); }, clickThrottleTimeout);
					}
				} else {
					if (min && (min == currentVal || currentVal < min)) {
						$qty.val(min);
					} else if (currentVal > 0) {
						$qty.val(currentVal - parseFloat(step));
                        clickThrottle = setTimeout(function() { self.quantityInputsTriggerEvents($qty); }, clickThrottleTimeout);
					}
				}
			});
		},
        
        
        /**
		 *    Quantity inputs: Trigger events
		 */
        quantityInputsTriggerEvents: function($qty) {
            var self = this;
            
            // Trigger quantity input "change" event
            $qty.trigger('change');

            // Trigger custom event
            self.$document.trigger('nm_qty_change', $qty);
        },
        
        
		/**
		 *	Initialize "page includes" elements
		 */
		initPageIncludes: function() {
			var self = this;
			
            /* VC element: Row - Full height */
            if (self.$pageIncludes.hasClass('row-full-height')) {
                var _rowSetFullHeight = function() {
                    var $row = $('.nm-row-full-height:first');

                    if ($row.length) {
                        var windowHeight = self.$window.height(),
                            rowOffsetTop = $row.offset().top,
                            rowFullHeight;
                        
                        // Set/calculate Row's viewpoint height (vh)
                        windowHeight > rowOffsetTop && (rowFullHeight = 100 - rowOffsetTop / (windowHeight / 100), $row.css('min-height', rowFullHeight+'vh'));
                    }
                }
                
                _rowSetFullHeight(); // Init
                
                /* Bind: Window "resize" event for changing Row height */
                var rowResizeTimer = null;
                self.$window.on('resize.nmRow', function() {
                    if (rowResizeTimer) { clearTimeout(rowResizeTimer); }
                    rowResizeTimer = setTimeout(function() { _rowSetFullHeight(); }, 250);
                });
            }
            
			/* VC element: Row - Video (YouTube) background */
			var rowVideoHide = (self.isTouch && nm_wp_vars.rowVideoOnTouch == 0) ? true : false; // Show video on touch?
            if (!rowVideoHide && self.$pageIncludes.hasClass('video-background')) {
				$('.nm-row-video').each(function() {
					var $row = $(this),
						youtubeUrl = $row.data('video-url');
					
					if (youtubeUrl) {
						var youtubeId = vcExtractYoutubeId(youtubeUrl); // Note: function located in: "nm-js_composer_front(.min).js"
						
						if (youtubeId) {
							insertYoutubeVideoAsBackground($row, youtubeId); // Note: function located in: "nm-js_composer_front(.min).js"
						}
					}
				});
			}
			
            self.$window.on('load', function() {
				
				/* Element: Banner */
				if (self.$pageIncludes.hasClass('banner')) {
                    self.elementBanner($('.nm-banner'));
				}
				
				/* Element: Banner slider */
				if (self.$pageIncludes.hasClass('banner-slider')) {
                    $('.nm-banner-slider').each(function() {
                        self.elementBannerSlider($(this));
                    });
				}
                
                /* Element: Product slider */
				if (self.$pageIncludes.hasClass('product-slider')) {
                    $('.nm-product-slider').each(function() {
                        self.elementProductSlider($(this));
                    });
				}
				
                /* Element: Product reviews slider */
				if (self.$pageIncludes.hasClass('product-reviews-slider')) {
                    $('.nm-product-reviews-slider').each(function() {
                        self.elementProductReviewsSlider($(this));
                    });
				}
                
				/* Element: Post slider */
				if (self.$pageIncludes.hasClass('post-slider')) {
                    $('.nm-post-slider').each(function() {
                        self.elementPostSlider($(this));
                    });
				}
				
				/* WP element: Gallery - popup */
                if (nm_wp_vars.wpGalleryPopup != '0' && self.$pageIncludes.hasClass('wp-gallery')) {
					$('.gallery').each(function() {
						$(this).magnificPopup({
							mainClass: 'nm-wp-gallery-popup nm-mfp-fade-in',
							closeMarkup: '<a class="mfp-close nm-font nm-font-close2"></a>',
							removalDelay: 180,
							delegate: '.gallery-icon > a', // Gallery item selector
							type: 'image',
							gallery: {
								enabled: true,
								arrowMarkup: '<a title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir% nm-font nm-font-angle-right"></a>'
							},
                            image: {
                                titleSrc: function(item) {
                                    // Get title from caption element
                                    var title = item.el.parent().next('.wp-caption-text').text();
                                    return title || '';
                                }
                            },
							closeBtnInside: false
						});
					});
				}
			
			});
			
			
			/* Element: Product categories */
			if (self.$pageIncludes.hasClass('product_categories')) {
                var self = this,
                    $categories = $('.nm-product-categories');

                self.elementProductCategoriesBindLinks($categories);

                if (self.$pageIncludes.hasClass('product_categories_masonry')) {
                    self.$window.on('load', function() {
                        for (var i = 0; i < $categories.length; i++) {
                            self.elementProductCategories($($categories[i]));
                        }
                    });
                }
			}
			
			/* Element: Lightbox */
            if (self.$pageIncludes.hasClass('lightbox')) {
                $('.nm-lightbox').each(function() {
                    self.elementLightbox($(this));
                });
			}
            
            /* Element: Elementor - Tabs */
            if (self.$pageIncludes.hasClass('elementor-tabs')) {
                $('.nm-elementor-tabs').each(function() {
                    self.elementElementorTabs($(this));
                });
            }
		},
        
        
        /**
		 *	Element: Banner
		 */
        elementBanner: function($banners) {
            var self = this;
            
            /* Bind: Banner shop links (AJAX) */
            if (self.isShop && self.filtersEnableAjax) {
                $banners.find('.nm-banner-shop-link').on('click.nmBannerAjax', function(e) {
                    e.preventDefault();
                    var shopUrl = $(this).attr('href');
                    if (shopUrl) {
                        self.shopExternalGetPage($(this).attr('href')); // Smooth-scroll to top, then load shop page
                    }
                });
            }
        },
        
        
        /**
		 *	Element: Banner - Add text animation class
		 */
        elementBannerAddAnimClass: function($slider, currentSlide) {
            // Make sure the slide has changed
            if ($slider.slideIndex != currentSlide) {
                $slider.slideIndex = currentSlide;

                // Remove animation class from previous banner
                if ($slider.$bannerContent) {
                    $slider.$bannerContent.removeClass($slider.bannerAnimation);
                }

                var $slideActive = ($slider.isSlick) ? $slider.find('.slick-track .slick-active') : $slider.children('.flickity-viewport').children('.flickity-slider').children('.is-selected'); // Note: Don't use "currentSlide" index to find the active element (Slick slider's "infinite" setting clones slides)
                $slider.$bannerContent = $slideActive.find('.nm-banner-text-inner');

                if ($slider.$bannerContent.length) {
                    $slider.bannerAnimation = $slider.$bannerContent.data('animate');
                    $slider.$bannerContent.addClass($slider.bannerAnimation);
                }
            }
        },
        
        
        /**
		 *	Element: Banner slider
		 */
        elementBannerSlider: function($slider) {
            var self = this;
            
            $slider.isSlick = ($slider.hasClass('plugin-slick')) ? true : false;

            // Wrap slider's banner elements in a "div" element
            $slider.children().wrap('<div class="nm-banner-slide"></div>');

            if ($slider.isSlick) {
                var slickOptions = {
                    arrows: false,
                    prevArrow: '<a class="slick-prev"><i class="nm-font nm-font-angle-thin-left"></i></a>',
                    nextArrow: '<a class="slick-next"><i class="nm-font nm-font-angle-thin-right"></i></a>',
                    dots: false,
                    edgeFriction: 0,
                    infinite: false,
                    pauseOnHover: false,
                    speed: 350,
                    touchThreshold: 30
                };
                slickOptions = $.extend(slickOptions, $slider.data()); // Extend default slider settings with data attribute settings

                // Slick slider: Event - Init
                $slider.on('init', function() {
                    self.$document.trigger('banner-slider-loaded');
                    self.elementBannerAddAnimClass($slider, 0);
                });

                // Slick slider: Event - After slide change
                $slider.on('afterChange', function(event, slick, currentSlide) {
                    self.elementBannerAddAnimClass($slider, currentSlide);
                });

                // Slick slider: Event - After position/size changes
                $slider.on('setPosition', function(event, slick) {
                    var $slider = slick.$slider,
                        $currentSlide = $(slick.$slides[slick.currentSlide]);
                    self.elementBannerSliderToggleLayoutClass($slider, $currentSlide);
                });

                // Slick slider: Initialize
                $slider.slick(slickOptions);
            } else {
                var sliderOptions = $.extend({}, $slider.data('options')), // Extend default slider options with data attribute options
                    sliderInstance;

                // Flickity: Single event - Initial slide select
                $slider.one('select.flickity', function() {
                    self.$document.trigger('banner-slider-loaded');
                    self.elementBannerAddAnimClass($slider, 0);
                });

                // Flickity: Event - Slide settled at end position
                $slider.on('settle.flickity', function() {
                    var currentSlide = sliderInstance.selectedIndex;
                    self.elementBannerAddAnimClass($slider, currentSlide);
                });

                // Flickity: Initialize
                $slider.flickity(sliderOptions);
                sliderInstance = $slider.data('flickity'); // Get slider instance

                // Flickity: Event: Slide select (keep below .flickity initialization)
                $slider.on('select.flickity', function() {
                    var $slider = $(this),
                        $currentSlide = (sliderInstance) ? $(sliderInstance.selectedElement) : $slider.find('.is-selected'); // In case the instance isn't available
                    self.elementBannerSliderToggleLayoutClass($slider, $currentSlide);
                });
                $slider.trigger('select.flickity'); // Trigger initial event

                // Flickity: Banner text "parallax" effect
                if ($slider.hasClass('has-text-parallax')) {
                    var $text = $slider.find('.nm-banner-text'),
                        x;
                    // Flickity: Event - Triggered when the slider moves
                    $slider.on('scroll.flickity', function(event, progress) {
                        sliderInstance.slides.forEach(function(slide, i) {
                            // Fix for "wrapAround" Flickity option - https://github.com/metafizzy/flickity/issues/468 - Note: This doesn't work with two slides
                            /*if (0 === i) {
                                x = Math.abs(sliderInstance.x) > sliderInstance.slidesWidth ? (sliderInstance.slidesWidth + sliderInstance.x + sliderInstance.slides[sliderInstance.slides.length - 1].outerWidth + slide.target) : slide.target + sliderInstance.x;
                            } else if (i === sliderInstance.slides.length - 1) {
                                x = Math.abs(sliderInstance.x) + sliderInstance.slides[i].outerWidth < sliderInstance.slidesWidth ? (slide.target - sliderInstance.slidesWidth + sliderInstance.x - sliderInstance.slides[i].outerWidth) : slide.target + sliderInstance.x;
                            } else {
                                x = slide.target + sliderInstance.x;
                            }

                            $text[i].style.transform = 'translate3d(' + x * (1/3) + 'px,0,0)';*/
                            // Note: Works with 2 slides, but not with the "wrapAround" option
                            x = (slide.target + sliderInstance.x) * 1/3;
                            $text[i].style.transform = 'translate3d(' + x + 'px,0,0)';
                        });
                    });
                }
            }
        },
        
        
        /**
		 *	Element: Banner slider - Toggle layout class
		 */
        elementBannerSliderToggleLayoutClass: function($slider, $currentSlide) {
            var $currentBanner = $currentSlide.children('.nm-banner');

            // Is the alternative text layout showing?
            if ($currentBanner.hasClass('alt-mobile-layout')) {
                if ($currentBanner.children('.nm-banner-content').css('position') != 'absolute') { // Content container has static/relative position when the alt. layout is showing
                    $slider.addClass('alt-mobile-layout-showing');
                } else {
                    $slider.removeClass('alt-mobile-layout-showing');
                }
            } else {
                $slider.removeClass('alt-mobile-layout-showing');
            }
        },
        
        
        /**
		 *	Element: Product slider
		 */
        elementProductSlider: function($sliderWrap) {
            var $slider = $sliderWrap.find('.nm-products:first'),
                sliderOptions = {
                    adaptiveHeight: true, // NOTE: Doesn't work with multiple slides
                    arrows: false,
                    prevArrow: '<a class="slick-prev"><i class="nm-font nm-font-angle-thin-left"></i></a>',
                    nextArrow: '<a class="slick-next"><i class="nm-font nm-font-angle-thin-right"></i></a>',
                    dots: true,
                    edgeFriction: 0,
                    infinite: false,
                    speed: 350,
                    touchThreshold: 30,
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 518,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                };

            // Extend default slider settings with data attribute settings
            sliderOptions = $.extend(sliderOptions, $sliderWrap.data());

            // Responsive columns
            var colMobile = $sliderWrap.data('slides-to-show-mobile'),
                col_1024 = (parseInt(sliderOptions.slidesToShow) == 2) ? 2 : 3,
                col_768 = (parseInt(colMobile) > 2) ? colMobile : 2,
                col_518 = colMobile;

            // Set responsive columns
            sliderOptions.responsive[0].settings.slidesToShow = col_1024;
            sliderOptions.responsive[0].settings.slidesToScroll = col_1024;
            sliderOptions.responsive[1].settings.slidesToShow = col_768;
            sliderOptions.responsive[1].settings.slidesToScroll = col_768;
            sliderOptions.responsive[2].settings.slidesToShow = col_518;
            sliderOptions.responsive[2].settings.slidesToScroll = col_518;

            $slider.slick(sliderOptions);
        },
        
        
        /**
		 *	Element: Product reviews slider
		 */
        elementProductReviewsSlider: function($sliderWrap) {
            var self = this,
                $slider = $sliderWrap.find('.nm-product-reviews-ul'),
                sliderOptions = {
                    adaptiveHeight: true, // NOTE: Doesn't work with multiple slides
                    arrows: false,
                    prevArrow: '<a class="slick-prev"><i class="nm-font nm-font-angle-thin-left"></i></a>',
                    nextArrow: '<a class="slick-next"><i class="nm-font nm-font-angle-thin-right"></i></a>',
                    dots: true,
                    edgeFriction: 0,
                    infinite: false,
                    speed: 350,
                    touchThreshold: 30,
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 518,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                };

            // Extend default slider settings with data attribute settings
            sliderOptions = $.extend(sliderOptions, $sliderWrap.data());
            
            if (sliderOptions.slidesToShow == 2) {
                // Max. two columns
                sliderOptions.responsive[0].settings.slidesToShow = 2;
                sliderOptions.responsive[0].settings.slidesToScroll = 2;
            }
            
            /* Function: Set slider height based on tallest slide */
            var _sliderSetHeight = function(slider) {
                // Make sure slider is visible (Elementor can trigger resize when dragging)
                if (! $(slider).is(':visible')) { return; }
                
                var activeSlides = [],
                    tallestSlide = 0;

                // Short timeout in order to get correct active slides
                setTimeout(function() {
                    $('.slick-track .slick-active', slider).each(function(item) {
                        activeSlides[item] = $(this).outerHeight();
                    });
                    
                    activeSlides.forEach(function(item) {
                        if (item > tallestSlide) {
                            tallestSlide = item;
                        }
                    });
                    
                    $('.slick-list', slider).css('height', Math.ceil(tallestSlide)+'px');
                }, 10);
            };
            
            // Bind slider init/change/resize events
            $slider.on('init', function(slick) {
                _sliderSetHeight(this);
            });
            $slider.on('beforeChange', function(slick, currentSlide, nextSlide) {
                _sliderSetHeight(this);
            });
            var sliderResizeTimer = null;
            self.$window.on('resize.reviewsSlider', function() {
                if (sliderResizeTimer) { clearTimeout(sliderResizeTimer); }
                sliderResizeTimer = setTimeout(function() { _sliderSetHeight($slider[0]); }, 250);
            });
            
            // Init slider
            $slider.slick(sliderOptions);
        },
        
        
        /**
		 *	Element: Post slider
		 */
        elementPostSlider: function($slider) {
            var sliderOptions = {
                    adaptiveHeight: true, // NOTE: Doesn't work with multiple slides
                    arrows: false,
                    prevArrow: '<a class="slick-prev"><i class="nm-font nm-font-angle-thin-left"></i></a>',
                    nextArrow: '<a class="slick-next"><i class="nm-font nm-font-angle-thin-right"></i></a>',
                    dots: true,
                    edgeFriction: 0,
                    infinite: false,
                    pauseOnHover: false,
                    speed: 350,
                    touchThreshold: 30,
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 518,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                };

            // Extend default slider settings with data attribute settings
            sliderOptions = $.extend(sliderOptions, $slider.data());

            if (sliderOptions.slidesToShow == 2) {
                // Max. two columns
                sliderOptions.responsive[0].settings.slidesToShow = 2;
                sliderOptions.responsive[0].settings.slidesToScroll = 2;
            }

            $slider.slick(sliderOptions);
        },
        
        
        /**
		 *	Element: Product categories
		 */
        elementProductCategories: function($categories) {
            if ($categories.hasClass('masonry-enabled')) {
                var $categoriesUl = $categories.children('.woocommerce').children('ul');

                // Initialize Masonry
                $categoriesUl.masonry({
                    itemSelector: '.product-category',
                    gutter: 0,
                    //horizontalOrder: true,
                    initLayout: false // Disable initial layout
                });

                // Masonry event: "layoutComplete"
                $categoriesUl.masonry('on', 'layoutComplete', function() {
                    $categoriesUl.closest('.nm-product-categories').removeClass('nm-loader'); // Hide preloader
                    $categoriesUl.addClass('show');
                });

                // Trigger initial layout
                $categoriesUl.masonry();
            }
        },
        
        
        /**
		 *	Element: Product categories - Bind shop links
		 */
        elementProductCategoriesBindLinks: function($categories) {
            var self = this;
            
            if (self.isShop && self.filtersEnableAjax) {
                $categories.find('.product-category a').on('click', function(e) {
                    e.preventDefault();
                    // Load shop category page
                    self.shopExternalGetPage($(this).attr('href'));
                });
            }
        },
        
        
        /**
		 *	Element: Lightbox
		 */
        elementLightbox: function($lightbox) {
            $lightbox.on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                var $this = $(this),
                    type = $this.data('mfp-type'),
                    lightboxOptions = {
                        mainClass: 'nm-wp-gallery-popup nm-mfp-zoom-in',
                        closeMarkup: '<a class="mfp-close nm-font nm-font-close2"></a>',
                        removalDelay: 180,
                        type: type,
                        closeBtnInside: false,
                        image: {
                            titleSrc: 'data-mfp-title'
                        }
                    };
                
                lightboxOptions.closeOnContentClick = (type == 'inline') ? false : true; // Disable "closeOnContentClick" for inline/HTML lightboxes
                
                $this.magnificPopup(lightboxOptions).magnificPopup('open');
            });
        },
        
        
        /**
		 *	Element: Elementor - Tabs
		 */
        elementElementorTabs: function($tabs) {
            var $tab, $tabActive;

            $tabs.children('.nm-elementor-tabs-wrapper').children('.nm-elementor-tab').on('click', function(e) {
                e.preventDefault();

                $tab = $(this);
                
                if ($tab.hasClass('nm-elementor-active')) { return; }
                
                $tabActive = $tab.closest('.nm-elementor-tabs-wrapper').children('.nm-elementor-active');
                
                // Change tab "active" class
                $tabActive.removeClass('nm-elementor-active');
                $tab.addClass('nm-elementor-active');

                // Change content "active" class
                $('#'+$tabActive.attr('aria-controls')).removeClass('nm-elementor-active');
                $('#'+$tab.attr('aria-controls')).addClass('nm-elementor-active');
            });
        }
        
	};
	
	
	// Add core script to $.nmTheme so it can be extended
	$.nmTheme = NmTheme.prototype;
    
    
    /**
     *  Document ready (".ready()" doesn't work with nested ".load()" functions in jQuery 3.0+)
     *
     *  Source: http://stackoverflow.com/questions/9899372/pure-javascript-equivalent-to-jquerys-ready-how-to-call-a-function-when-the/9899701#9899701
     */
    $.nmReady = function(fn) {
        // See if DOM is already available
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            // Call on next available tick
            setTimeout(fn, 1);
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    };
    
    
    $.nmReady(function() {
		// Initialize script
		$.nmThemeInstance = new NmTheme();
	});
	
})(jQuery);
