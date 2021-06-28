(function($) {
	
	'use strict';
	
	// Extend core script
	$.extend($.nmTheme, {
		
		/**
		 *	Initialize scripts
		 */
		blog_init: function() {
			var self = this;
            
            self.$blogList = $('#nm-blog-list');
            
            
            // Bind: Categories toggle link
			$('#nm-blog-categories-toggle-link').on('click', function(e) {
				e.preventDefault();
				
				var $thisLink = $(this);
				
				$('#nm-blog-categories-list').slideToggle(200, function() {
					var $this = $(this);
					
					$thisLink.toggleClass('active');
					
					if (!$thisLink.hasClass('active')) {
						$this.css('display', '');
					}
				});
			});
            
            
            /* Masonry grid */
            self.$window.on('load', function() {
				if (self.$pageIncludes.hasClass('blog-masonry')) {
					var $blogUl = $('#nm-blog-list');
				    
                    // Initialize Masonry
                    $blogUl.masonry({
                        itemSelector: '.post',
                        gutter: 0,
                        // Disable animation when adding items
                        hiddenStyle: {},
                        visibleStyle: {}
                    });
				}
            });
            
            
            if (self.$blogList) {
                // Bind: Infinite load
                self.blogInfLoadBind();
            }
		},
		
        
        /**
		 *	Blog: Infinite load - Bind
		 */
		blogInfLoadBind: function() {
            var self = this;
            
            self.$blogPaginationWrap = $('#nm-blog-pagination');
            self.$blogInfLoadWrap = $('#nm-blog-infinite-load');
            
			if (self.$blogInfLoadWrap.length) {
                self.$blogInfLoadLink = self.$blogInfLoadWrap.children('a');
                
                /* Bind: "Load" button */
                self.$blogInfLoadLink.on('click', function(e) {
                    e.preventDefault();
                    self.blogInfLoadGetPage();
                });
            }
        },
        
		
		/**
		 *	Blog: Infinite load -  Get next page
		 */
		blogInfLoadGetPage: function() {
			var self = this;
			
			if (self.blogAjax) { return false; }
			
			// Get next blog-page URL
			var nextPageUrl = self.$blogInfLoadLink.attr('href');
            
			if (nextPageUrl) {
				// Show 'loader'
				self.$blogPaginationWrap.addClass('loading nm-loader');
                
				self.blogAjax = $.ajax({
					url: nextPageUrl,
					data: {
                        blog_load: '1'
                    },
                    dataType: 'html',
					cache: false,
					headers: {'cache-control': 'no-cache'},
					method: 'GET',
					error: function(XMLHttpRequest, textStatus, errorThrown) {
                        // Hide 'loader'
						self.$blogPaginationWrap.removeClass('loading nm-loader');
                        
						console.log('NM: AJAX error - blogInfLoadGetPage() - ' + errorThrown);
					},
					success: function(response) {
						var $response = $('<div>' + response + '</div>'), // Wrap the returned HTML string in a dummy 'div' element we can get the elements
							$newElements = $response.find('#nm-blog-list').children();
                        
                        // Hide new elements before they're added
                        $newElements.addClass('fade-out');
						
                        // Masonry: Position new elements
                        if (self.$pageIncludes.hasClass('blog-masonry')) {
                            var $newImages = $newElements.find('img'),
                                $lastNewImage = $newImages.last();
                            
                            // Remove loading="lazy" attribute so the "load" event below works
                            $newImages.removeAttr('loading');
                            
                            // Continue after last image has loaded to prevent incorrect height
                            $lastNewImage.on('load', function() {
                                self.$blogList.masonry('appended', $newElements);
                                
                                self.blogInfLoadPrepButton($response);
                                
                                setTimeout(function() {
                                    // Show new elements
                                    $newElements.removeClass('fade-out');

                                    self.blogAjax = false;
                                }, 300);
                            });
                            
                            // Append new elements
                            self.$blogList.append($newElements);
                        } else {
                            // Append new elements
				            self.$blogList.append($newElements);
                            
                            self.blogInfLoadPrepButton($response);
                            
                            setTimeout(function() {
                                // Show new elements
                                $newElements.removeClass('fade-out');

                                self.blogAjax = false;
                            }, 300);
                        }
					}
				});
			}
		},
        
        
        /**
		 *	Blog: Infinite load - Prep "load" button
		 */
		blogInfLoadPrepButton: function($response) {
            var self = this,
                nextPageUrl = $response.find('#nm-blog-infinite-load').children('a').attr('href');
            
            if (nextPageUrl) {
                self.$blogInfLoadLink.attr('href', nextPageUrl);
                
                // Hide "loader"
                self.$blogPaginationWrap.removeClass('loading nm-loader');
            } else {
                // Hide "load" button (no more products/pages)
                self.$blogPaginationWrap.addClass('all-pages-loaded');
            }
        }
		
	});
	
	// Add extension so it can be called from $.nmThemeExtensions
	$.nmThemeExtensions.blog = $.nmTheme.blog_init;
	
})(jQuery);
