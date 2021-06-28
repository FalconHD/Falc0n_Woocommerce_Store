(function($) {
	
	'use strict';
	
	var NM_Wishlist = {
		
		/**
		 *	Init
		 */
		init: function() {
			var self = this;
            
            if (typeof nm_wp_vars == 'undefined') { return; } // NM theme is required ro run script
            
            self.$body          = $('body');
            self.isLoggedIn     = (self.$body.hasClass('logged-in')) ? true : false;
            self.wishlistIds    = [];
            self.cookieExpires  = parseInt(nm_wishlist_vars.wlCookieExpires);
            self.IDsUpdateAjax  = false;
            
            // Header link count
            if (nm_wishlist_vars.wlMenuCount != '0') {
                self.headerLinkCount = true;
                self.$headerLinkLi = $('.nm-menu-wishlist');
                self.$headerLinkCount = self.$headerLinkLi.find('.nm-menu-wishlist-count');
            } else {
                self.headerLinkCount = false;
            }
            
            
            self.setUp();
            
            
			/* Bind: Buttons (sitewide) - "click" event */
			$(document).on('click', '.nm-wishlist-button', function(e) {
				e.preventDefault();
                
                // Is login required?
                if (nm_wishlist_vars.wlLoginRequire != '0' && ! self.$body.hasClass('logged-in')) {
                    var $loginBtn = $('#nm-menu-account-btn');
                    if ($loginBtn.length && $('#nm-login-popup-wrap').length) { // Popup enabled?
                        $loginBtn.trigger('click');
                    } else {
                        window.location.replace(nm_wishlist_vars.wlLoginRedirectUrl);
                    }
                    return;
                }
                
                // Is an Ajax request running?
				if (self.IDsUpdateAjax) {
                    self.IDsUpdateAjax.abort(); // Abort Ajax request
                    self.IDsUpdateAjax = false;
				}
                
                self.buttonToggle(this);
			});
            
            
            /* Bind: Wishlist page "remove" links */
            var $wishlistTable = $('#nm-wishlist-table');
            if ($wishlistTable.length) {
				$wishlistTable.find('.nm-wishlist-remove').on('click', function(e) {
					e.preventDefault();
					var $this = $(this);
					if ($this.hasClass('clicked')) { return; }
					$this.addClass('clicked');
					self.wishlistItemRemove($this, $wishlistTable);
				});
            }
		},
        
        
        /*
         *  Init: Set up (get saved IDs and set button states)
         */
        setUp: function() {
            var self = this;
            
            if (self.isLoggedIn) { 
                // AJAX: Get saved IDs from user-meta
                $.ajax({
                    type: 'POST',
                    url: nm_wp_vars.ajaxUrl,
                    data: { action: 'nm_wishlist_get_ids' },
                    dataType: 'json',
                    cache: false,
                    headers: {'cache-control': 'no-cache'},
                    success: function(json) {
                        if (json.ids) {
                            var idsArray = json.ids;
                            
                            // Update class variable and cookie with saved IDs
                            self.wishlistIds = idsArray;
                            Cookies.set('nm-wishlist-ids', idsArray, { expires: self.cookieExpires });
                        
                            self.headerLinkUpdate();
                            self.buttonsSetState();
                        }
                    }
                });
            } else {
                var ids = Cookies.getJSON('nm-wishlist-ids');
                
                // Does the Wishlist cookie exist?
                if (! ids) {
                    Cookies.set('nm-wishlist-ids', [], { expires: self.cookieExpires });
                } else {
                    self.wishlistIds = ids;
                    
                    self.headerLinkUpdate();
                    self.buttonsSetState();
                }
            }
        },
        
        
        /*
         *  IDs: Update
         */
        IDsUpdate: function() {
            var self = this;
            
            if (self.isLoggedIn) {
                // Convert IDs array to string
                var ids = JSON.stringify(self.wishlistIds);
                
                // AJAX: Save IDs in user-meta
                self.IDsUpdateAjax = $.ajax({
					type: 'POST',
					url: nm_wp_vars.ajaxUrl,
					data: {
						action: 'nm_wishlist_update_ids',
                        nonce: nm_wishlist_vars.wlNonce,
                        ids: ids
					},
					dataType: 'json',
					cache: false,
					headers: {'cache-control': 'no-cache'},
					complete: function() {
                        self.IDsUpdateAjax = false;
                    }
				});
            }
            
            Cookies.set('nm-wishlist-ids', self.wishlistIds, { expires: self.cookieExpires });
        },
        
        
        /*
         *  Buttons (sitewide): Add button classes for added items (classes must be set with JS when page-caching is enabled)
         */
        buttonsSetState: function() {
            var self = this;
            
            for (var i = 0; i < self.wishlistIds.length; i++) { 
                $('#nm-wishlist-item-' + self.wishlistIds[i] + '-button').addClass('added');
            }
            
            // Add class to show buttons
            self.$body.addClass('wishlist-show-buttons');
        },
		
        
        /* Button (single): Set state (change button class and title) */
        buttonSetState: function(productId, isAdding) {
            var self = this,
                $buttons = $('.nm-wishlist-item-' + productId + '-button'); // Get all wishlist buttons with the same product-id

            // Change button(s) title attribute and trigger events
            if (isAdding) {
                $buttons.addClass('added');
                $buttons.attr('title', nm_wishlist_vars.wlButtonTitleRemove);
                self.$body.trigger('wishlist_added_item');
            } else {
                $buttons.removeClass('added');
                $buttons.attr('title', nm_wishlist_vars.wlButtonTitleAdd);
                self.$body.trigger('wishlist_removed_item');
            }
        },
        
        
        /*
         *  Button (single): Add/remove item
         */
        buttonToggle: function(button) {
            var self = this,
                productId = $(button).data('product-id'),
                isAdding = true;
            
            // Does the product-id exist in the cookie array?
            var productIdIndex = $.inArray(productId, self.wishlistIds);

            if (productIdIndex == -1) {
                // Prepend product-id to array (display newly added products first)
                self.wishlistIds.unshift(productId);
            } else {
                // Remove existing product-id from array
                self.wishlistIds.splice(productIdIndex, 1);
                
                isAdding = false;
            }
            
            self.IDsUpdate();
            self.headerLinkUpdate();
            self.buttonSetState(productId, isAdding);
        },
        
        
        /*
         *  Wishlist page: Remove item
         */
        wishlistItemRemove: function($this, $wishlistTable) {
            // Show "loader" overlay
            $('#nm-wishlist-overlay').addClass('show');

            var	self = this,
                $thisUl = $this.closest('ul'),
                productId = $thisUl.data('product-id');
            
            $thisUl.addClass('removing');
            
            // Remove product-id from array
            var productIdIndex = $.inArray(productId, self.wishlistIds);
            if (productIdIndex != -1) {
                self.wishlistIds.splice(productIdIndex, 1);
            }

            self.IDsUpdate();
            self.headerLinkUpdate();

            setTimeout(function() {
                $thisUl.remove();

                self.$body.trigger('wishlist_removed_item');

                // Show "wishlist empty" container?
                if ($wishlistTable.children('ul').length == 0) {
                    $('#nm-wishlist').css('display', 'none');
                    $('#nm-wishlist-empty').addClass('show');
                }

                // Hide "loader" overlay
                $('#nm-wishlist-overlay').removeClass('show');
            }, 500);
        },
        
        
        /*
         *  Header link: Update (class and count)
         */
        headerLinkUpdate: function() {
            var self  = this;
            
            if (self.headerLinkCount) {
                if (self.wishlistIds.length) {
                    self.$headerLinkLi.addClass('has-items');
                    self.$headerLinkCount.text(self.wishlistIds.length);
                } else {
                    self.$headerLinkLi.removeClass('has-items');
                    self.$headerLinkCount.text('0');
                }
            }
        }
	}
	
	$(function() { // Doc ready
		// Initialize script
		NM_Wishlist.init();
	});
	
})(jQuery);