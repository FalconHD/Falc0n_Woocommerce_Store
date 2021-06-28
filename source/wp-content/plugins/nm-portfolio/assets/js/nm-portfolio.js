(function($) {
	
	'use strict';
	
	/* NM Portfolio */
	window.NM_Portfolio = {
		
		/**
		 *	Initialize Portfolio
		 */
		init: function() {
			var self = this;
			
			self.$pageIncludes = $('#nm-page-includes');
			
            if (self.$pageIncludes.hasClass('portfolio')) {
                var $portfolioGrids = $('.nm-portfolio-grid');

                for (var i = 0; i < $portfolioGrids.length; i++) {
                    var $thisGrid = $($portfolioGrids[i]),
                        $categoriesMenu = $thisGrid.siblings('.nm-portfolio-categories');

                    // Packery layout
                    self.packeryLayout($thisGrid);

                    // Categories
                    if ($categoriesMenu.length && $categoriesMenu.hasClass('js-sorting')) {
                        self.categoriesAnimatedSorting($categoriesMenu);
                    }
                }
            }
		},
        
        /**
         * Packery layout: Init
         */
        packeryLayout: function($portfolioGrid) {
            if ($portfolioGrid.parent('.nm-portfolio').hasClass('packery-enabled')) {
                // Packery settings
                var settings = {
                    itemSelector: 'li',
                    gutter: 0,
                    isInitLayout: false // Disable initial layout
                };

                // Initialize Packery
                $portfolioGrid.packery(settings);

                // Packery event: "layoutComplete"
                $portfolioGrid.packery('once', 'layoutComplete', function() {
                    $portfolioGrid.removeClass('nm-loader').addClass('show');
                });

                // Manually trigger initial layout
                $portfolioGrid.packery();
            }
        },
        
        /**
         * Categories: Enable animated sorting
         */
        categoriesAnimatedSorting: function($categoriesMenu) {
            $categoriesMenu.find('a').on('click', function(e) {
                e.preventDefault();

                var $this = $(this),
                    $thisWrap = $this.closest('.nm-portfolio');

                if ($this.hasClass('current')) {
                    return;
                } else {
                    // Set "current" link
                    $thisWrap.children('.nm-portfolio-categories').children('.current').removeClass('current');
                    $this.parent('li').addClass('current');
                }

                var $thisGrid = $thisWrap.children('.nm-portfolio-grid'),
                    $thisItems = $thisGrid.children('li'),
                    filterSlug = $this.data('filter'),
                    packeryEnabled = $thisWrap.hasClass('packery-enabled') ? true : false;

                // Show/hide elements
                if (filterSlug) {
                    var $item;
                    $thisItems.each(function() {
                        $item = $(this);
                        if ($item.hasClass(filterSlug)) {
                            if (packeryEnabled) {
                                $thisGrid.packery('unignore', $item[0]); // Packery - un-ignore element
                            }

                            $item.removeClass('hide fade-out');
                        } else {
                            if (packeryEnabled) {
                                $thisGrid.packery('ignore', $item[0]); // Packery - ignore element
                            }

                            $item.addClass('hide fade-out');
                        }
                    });
                } else {
                    if (packeryEnabled) {
                        $thisItems.each(function() {
                            $thisGrid.packery('unignore', $(this)[0]); // Packery - unignore element
                        });
                    }

                    $thisItems.removeClass('hide fade-out'); // Show all items
                }

                if (packeryEnabled) {
                    $thisGrid.packery(); // Re-position grid elements
                }
            });
        }
	};
    
    $(window).on('load', function() {
        // Initialize script
        window.NM_Portfolio.init();
    });
	
})(jQuery);
