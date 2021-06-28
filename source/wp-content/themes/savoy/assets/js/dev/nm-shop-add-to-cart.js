(function($) {
	
	'use strict';
	
	// Extend core script
	$.extend($.nmTheme, {
		
		/**
		 *	Initialize scripts
		 */
		atc_init: function() {
			var self = this;
			
			self.atcBind();
		},
		
		
		/**
		 *	Bind
		 */
		 atcBind: function() {
			var self = this;
			
			// Bind: Single product "add to cart" buttons
			self.$body.on('click', '.single_add_to_cart_button', function(e) {
				var $thisButton = $(this);
				
                // Make sure the add-to-cart button isn't disabled
                if ( $thisButton.is('.disabled') ) { console.log('NM: Add-to-cart button disabled'); return; }
                
				// Only allow simple and variable product types
				if ($thisButton.hasClass('nm-simple-add-to-cart-button') || $thisButton.hasClass('nm-variable-add-to-cart-button')) {
					e.preventDefault();
					
					// Is the quick view open?
					self.quickviewOpen = self.quickviewIsOpen();
					
					if (self.quickviewOpen) {
						$thisButton.addClass('nm-loader nm-loader-light'); // Add preloader to quick view button
					}
					
					// Set button disabled state
					$thisButton.attr('disabled', 'disabled');
					
					var $productForm = $thisButton.closest('form');
					
					if (!$productForm.length) {
						return;
					}
					
					var	data = {
						product_id:				$productForm.find("[name*='add-to-cart']").val(),
						product_variation_data: $productForm.serialize()
					};
					
					// Trigger "adding_to_cart" event
                    self.$body.trigger('adding_to_cart', [$thisButton, data]);
					
					// Submit product form via Ajax
					self.atcAjaxSubmitForm($thisButton, data);
				}
			});
		},
		
		
		/**
		 *	Submit product form via Ajax
		 */
		atcAjaxSubmitForm: function($thisButton, data) {
			var self = this;
			
			if (!data.product_id) {
				console.log('NM (Error): No product id found');
				return;
			}
			
            // Use WooCommerce AJAX endpoint URL
            if (typeof wc_add_to_cart_params !== 'undefined') {
                var ajaxUrl = wc_add_to_cart_params.wc_ajax_url;
            } else {
                console.log('NM: "wc_add_to_cart_params" undefined - WooCommerce AJAX atc disabled');
                var ajaxUrl = nm_wp_vars.woocommerceAjaxUrl;
            }
            ajaxUrl = ajaxUrl.toString().replace('wc-ajax=%%endpoint%%', 'add-to-cart=' + data.product_id + '&nm-ajax-add-to-cart=1');
            
			
			// Submit product form via Ajax
			$.ajax({
				type: 'POST',
				url: ajaxUrl,
				data: data.product_variation_data,
				dataType: 'html',
				cache: false,
				headers: {'cache-control': 'no-cache'},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log('NM: AJAX error - atcAjaxSubmitForm() - ' + errorThrown);
				},
				success: function(response) {
					var $response = $('<div>' + response + '</div>'), // Wrap the returned HTML string so we can get the replacement elements
						$shopNotices = $response.find('#nm-shop-notices-wrap'), // Shop notices
						hasError = ($shopNotices.find('.woocommerce-error').length) ? true : false, // Is there an error notice?
						cartHash = ''; // Note: Add the cart-hash to an element (data attribute) in the redirect template?
						
					// Get replacement elements/values
					// Note: Using ".prop('outerHTML')" to convert the jQuery objects/elements into strings (since they are passed to the "added_to_cart" event below)
					var fragments = {
						'.nm-menu-cart-count': $response.find('.nm-menu-cart-count').prop('outerHTML'), // Header menu cart count
						'#nm-shop-notices-wrap': $shopNotices.prop('outerHTML'),
						'#nm-cart-panel': $response.find('#nm-cart-panel').prop('outerHTML') // Cart panel
					};
                    
					// Replace cart/shop fragments
                    self.shopReplaceFragments(fragments);
					
					// Trigger "added_to_cart" event
					// Note: The "fragments" object is passed to make sure the various shop/cart fragments are updated
                    self.$body.trigger('added_to_cart', [fragments, cartHash]);
					
					if (self.quickviewOpen) {
						// Close quickview modal
						$.magnificPopup.close();
						
						if (hasError) {
							if (self.isShop) {
                                // Smooth-scroll to shop-top
                                self.shopScrollToTop();
                            }
						} else {
							// Is widget/cart panel enabled?
							if (self.$widgetPanel.length) {
								// Only show widget/cart panel if no error notice is returned
								setTimeout(function() {
									self.widgetPanelShow(false, true); // Args: showLoader, addingToCart
								}, 350);
							}
						}
					} else {
						// Remove button disabled state
						$thisButton.removeAttr('disabled');
						
						if (hasError) {
							setTimeout(function() {
								// Hide cart panel and overlay
								$('#nm-widget-panel-overlay').trigger('click');
								
                                if (self.isShop) {
                                    // Smooth-scroll to shop-top
                                    self.shopScrollToTop();
                                }
							}, 500);
						}
					}
					
					$response.empty();
				}
			});
		}
		
	});
	
	// Add extension so it can be called from $.nmThemeExtensions
	$.nmThemeExtensions.add_to_cart = $.nmTheme.atc_init;
	
})(jQuery);
