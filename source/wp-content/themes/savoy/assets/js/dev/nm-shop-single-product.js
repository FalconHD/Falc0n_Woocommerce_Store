(function($) {
	
	'use strict';
	
	// Extend core script
	$.extend($.nmTheme, {
		
		/**
		 *	Initialize single product scripts
		 */
		singleProduct_init: function() {
			var self = this;
            
            self.$productWrap            = $('.nm-single-product');
            self.$galleryContainer       = $('.woocommerce-product-gallery');
            self.$galleryWrap            = self.$galleryContainer.find('.woocommerce-product-gallery__wrapper');
            self.$galleryImages          = self.$galleryWrap.children('.woocommerce-product-gallery__image');
            self.galleryThumbnailsSlider = ( nm_wp_vars.galleryThumbnailsSlider != '0' && self.$productWrap.hasClass('thumbnails-vertical')) ? true : false;
            self.zoomEnabled             = (!self.isTouch && $('.woocommerce-product-gallery').hasClass('zoom-enabled'));
            
			
            self.singleProductVariations();
            self.quantityInputsBindButtons($('.summary'));
            self.singleProductFeaturedVideoInit();
			
            
            self.$window.on('load', function() {
                var galleryDeferNum = 0;
                
                /* Gallery: Make sure Flexslider data is available (jQuery ".ready()" can run after ".on('load')") */
                var galleryDeferInit = function() {
                    if (self.galleryData) {
                        if (self.$pageIncludes.hasClass('product-layout-scroll')) {
                            self.singleProductPinSummary();
                        }
                        self.singleProductGalleryInit();
                        self.singleProductGalleryZoomInit();
                    } else {
                        // Prevent infinite loop
                        if (galleryDeferNum < 10) {
                            //console.log('NM: Flexslider not ready, trying again');
                            galleryDeferNum++;
                            self.galleryData = self.$galleryContainer.data('flexslider');
                            setTimeout(function() { galleryDeferInit() }, 100);
                        }
                    }
                }
                
                if (self.$galleryContainer.length) {
                    // Init gallery when more that one image is added
                    if (self.$galleryImages.length > 1) {
                        self.galleryData = self.$galleryContainer.data('flexslider');
                        galleryDeferInit();
                    } else {
                        self.singleProductGalleryZoomInit(); // Init zoom with only one image
                    }
                }
            });
			
            
            /* PhotoSwipe - "Close" button: Prevent click on covered element: https://github.com/woocommerce/woocommerce/issues/25458 */
            var pswpButtonClose = document.querySelector('.pswp__button--close');
            if (pswpButtonClose) {
                pswpButtonClose.addEventListener('pswpTap', function(e) {
                    e.preventDefault(); e.stopPropagation();
                }, true);
            }
            
            
            /* Accordion */
            self.$productAccordion = $('#nm-product-accordion');
            if (self.$productAccordion.length) {
                self.singleProductAccordionBind();
            }
            
            
            /* Review form button */
            self.singleProductReviewFormButton();
            
            
            /* Star-rating: bind click event */
			var $ratingWrap = $('#nm-comment-form-rating');
			$ratingWrap.on('click.nmAddParentClass', '.stars a', function() {
				$ratingWrap.children('.stars').addClass('has-active');
            });
            
            
            if (nm_wp_vars.shopRedirectScroll != '0') {
                /* Bind: Breadcrumbs (add query arg) */
                $('#nm-breadcrumb').find('a').on('click.nmShopRedirect', function(e) {
                    e.preventDefault();
                    self.singleProductRedirectWithHash(this);
                });

                /* Bind: Category and tag links */
                $('#nm-product-meta').find('a').on('click.nmShopRedirect', function(e) {
                    e.preventDefault();
                    self.singleProductRedirectWithHash(this);
                });
            }
		},
        
        
        /**
		 *	Single product: "Pin" summary
		 */
        singleProductPinSummary: function() {
            var self = this;
            
            self.singleProductPinSummaryInit();

            /* Bind: Window "resize" event */
            var timer = null;
            self.$window.on('resize.nmProductDetailsPin', function() {
                if (timer) { clearTimeout(timer); }
                timer = setTimeout(function() {
                    self.singleProductPinSummaryUpdate();
                }, 250);
            });
        },
        
        
        /**
		 *	Single product: "Pin" summary - Init plugin
		 */
        singleProductPinSummaryInit: function() {
            var $productDetailsPinWrap = $('#nm-summary-pin'),
                offsetFix = 0.1; // Adding 0.1 so the "Pin" plugin adds "fixed" styles before page-scroll starts (prevents "flicker" in IE)
            
            $productDetailsPinWrap.pin({
                minWidth: 1080, // Matches "min-width: 1080px" media query
                containerSelector: '.nm-single-product-summary-col',
                padding: {top: $productDetailsPinWrap.offset().top + offsetFix}
            });
        },
        
        
        /**
		 *	Single product: "Pin" - Remove plugin
		 */
        singleProductPinSummaryRemove: function() {
            $('#nm-summary-pin').attr('style', '').removeData('pin');
        },
        
        
        /**
		 *	Single product: "Pin" - Update
		 */
        singleProductPinSummaryUpdate: function() {
            //console.log('NM - Product page: Pin summary update');
            var self = this;
            self.singleProductPinSummaryRemove();
            self.singleProductPinSummaryInit();
            self.$window.trigger('scroll'); // Tigger "scroll" to update product-summary position
        },
        
        
        /**
		 *	Single product: Gallery - Init
		 */
        singleProductGalleryInit: function() {
            // Add "+" icon
            if (nm_wp_vars.galleryZoom != '0') {
                $('.woocommerce-product-gallery').prepend('<a href="#" class="woocommerce-product-gallery__trigger">🔍</a>');
            }
            
            var self = this;
            
            // Is there more than one gallery image?
            // Added in "singleProduct_init" instead: if (self.$galleryImages.length > 1) {
                // Enable thumbnail slider?
                if (self.galleryThumbnailsSlider) {
                    self.$galleryThumbsContainer = self.$galleryContainer.find('.flex-control-thumbs');
                    self.$galleryThumbsContainer.wrapInner('<ol id="nm-product-gallery-thumbs-inner"></ol>');
                    self.$galleryThumbsWrap = $('#nm-product-gallery-thumbs-inner');
                }

                // Set height
                self.singleProductGallerySetHeight();

                // Flexslider: "before" change slide event
                self.galleryData.vars.before = function(slider) {
                    self.singleProductGallerySetHeight();
                };
                
                // Arrows: Set offset
                self.singleProductGalleryArrowsOffset();
                // Arrows: Show
                $('.flex-direction-nav').addClass('show');
                
                /* Bind: Window "resize" event */
                var timer = null;
                self.$window.on('resize.nmProductGallery', function() {
                    if (timer) { clearTimeout(timer); }
                    timer = setTimeout(function() {
                        self.singleProductGallerySetHeight();
                        self.singleProductGalleryArrowsOffset();
                        
                        // Hide variation menu (if open)
                        $('#nm-variations-form').trigger('click');
                    }, 250);
                });
            //}
        },
        
        
        /**
         *	Single product: Gallery - Set height
         */
        singleProductGallerySetHeight: function() {
            var self = this,
                $currentImage = self.galleryData.slides.eq(self.galleryData.animatingTo),
                currentImageHeight = $currentImage.height();

            self.$galleryWrap.css('height', currentImageHeight+'px');

            if (self.galleryThumbnailsSlider) {
                self.singleProductGalleryPositionThumbnail(currentImageHeight);
            }
        },
        
        
        /**
         *	Single product: Gallery - Set thumbnail scroll position
         */
        singleProductGalleryPositionThumbnail: function(currentImageHeight) {
            var self = this;
            
            self.$galleryThumbsContainer.css('height', currentImageHeight+'px');

            var $currentThumb = self.$galleryThumbsWrap.children().eq(self.galleryData.animatingTo),
                thumbPos = Math.round($currentThumb.position().top),
                thumbPosHeight = Math.round(thumbPos + $currentThumb.height()),
                currentPosY = Math.abs(parseInt(self.$galleryThumbsWrap.css('top'))),
                newPosY = null;
            
            // Is thumbnail above the visible viewport?
            if ((thumbPos - currentPosY) <= 50) { // Using 50 as the tolerance
                var $prevThumb = $currentThumb.prev();
                if ($prevThumb.length) {
                    thumbPos = Math.round($prevThumb.position().top);
                }
                newPosY = thumbPos;
            } 
            // Is thumbnail below the visible viewport?
            else if ((thumbPosHeight - currentPosY) >= (currentImageHeight - 50)) { // Using 50 as the tolerance
                var $nextThumb = $currentThumb.next();
                if ($nextThumb.length) {
                    thumbPosHeight = Math.round($nextThumb.position().top + $nextThumb.height());
                }
                newPosY = thumbPosHeight - currentImageHeight;
            }
            
            if (newPosY !== null) {
                self.$galleryThumbsWrap.css('top', '-'+newPosY+'px');
            }
        },
		
        
        /**
		 *	Single product: Redirect to shop with #shop URL hash (scrolls the page to the shop section)
		 */
		singleProductRedirectWithHash: function(shopLink) {
            var url = $(shopLink).attr('href');
            window.location.href = url + '#shop';
        },
		
        
		/**
		 *	Single product: Variations
		 */
		singleProductVariations: function() {
			var self = this,			
                $variationsForm = $('#nm-variations-form');
            
            $variationsForm = ($variationsForm.length) ? $variationsForm : $('.variations_form'); // Some plugins remove the custom "#nm-variations-form" id
            
            /* Init variation controls */
            self.singleProductVariationsInit($variationsForm); // Note: Function is placed in the "nm-shop" file
            
			/* Variations select: "woocommerce_variation_select_change" event */
			$variationsForm.on('woocommerce_variation_select_change', function() {
                // Gallery zoom: Update image (in case a variation image is used)
				if (self.zoomEnabled) {
					self.singleProductZoomUpdateImage();
				}
			});
		},
        
        
        /**
		 *	Single product: Gallery arrows - Set offset
		 */
        singleProductGalleryArrowsOffset: function() {
            var $galleryContainer = $('.woocommerce-product-gallery'),
                $galleryArrows = $galleryContainer.children('.flex-direction-nav').find('a'),
                
                galleryContainerHeight = Math.ceil($galleryContainer.outerHeight()),
                galleryHeight = Math.ceil($galleryContainer.children('.woocommerce-product-gallery__wrapper').height()),
                
                galleryArrowDefaultOffset = $galleryArrows.first().outerHeight() / 2,
                galleryArrowOffset = (galleryContainerHeight > galleryHeight) ? (galleryContainerHeight - galleryHeight) / 2 : 0;
            
            $galleryArrows.css('marginTop', '-'+(galleryArrowDefaultOffset + galleryArrowOffset)+'px');
        },
        
        
        /**
		 *	Single product: Gallery zoom
		 */
        singleProductGalleryZoomInit: function() {
            var self = this;
            
            // Gallery: Hover zoom (EasyZoom)
            if (self.zoomEnabled) {
                var $productGalleryImages = $('.woocommerce-product-gallery__wrapper').children('.woocommerce-product-gallery__image');
                $productGalleryImages.easyZoom();
            }
        },
        
        
        /**
		 *	Single product: Gallery zoom - Update image
		 */
		singleProductZoomUpdateImage: function() {
			var self = this,
				$firstGalleryImage = $('.woocommerce-product-gallery__wrapper').children('.woocommerce-product-gallery__image').first(),
				firstGalleryImageUrl = $firstGalleryImage.children('a').attr('href');
            
            if (firstGalleryImageUrl && firstGalleryImageUrl.length > 0) {
                // Get the zoom plugin API for the first gallery image
                var zoomApi = $firstGalleryImage.data('easyZoom');
                // Swap/update zoom image url
                if (zoomApi) { // Plugins may remove easyZoom data
                    zoomApi.swap(firstGalleryImageUrl);
                }
            }
		},
		
		
		/**
		 *	Single product: Featured video
		 */
		singleProductFeaturedVideoInit: function() {
			var self = this;
			
			self.hasFeaturedVideo = false;
			self.$featuredVideoBtn = $('#nm-featured-video-link');
			
			if (self.$featuredVideoBtn.length) {
				self.hasFeaturedVideo = true;
				
				// Bind: Featured video button
				self.$featuredVideoBtn.on('click', function(e) {
					e.preventDefault();
					
                    // Modal settings
                    var mfpSettings = {
						mainClass: 'nm-featured-video-popup nm-mfp-fade-in',
						closeMarkup: '<a class="mfp-close nm-font nm-font-close2"></a>',
						removalDelay: 180,
						type: 'iframe',
						closeOnContentClick: true,
						closeBtnInside: true
                    };
                    // Modal settings: YouTube - Disable related videos ("rel=0")
                    if (nm_wp_vars.shopYouTubeRelated == '0') {
                        mfpSettings['iframe'] = {
                            patterns: {
                                youtube: {
                                   src: '//www.youtube.com/embed/%id%?rel=0&autoplay=1'
                                }
                            }
                        };
                    }
                    
					// Open video modal
					self.$featuredVideoBtn.magnificPopup(mfpSettings).magnificPopup('open');
				});
			}
		},
        
        
        /**
         *  Single product: Accordion
         */
        singleProductAccordionBind: function() {
            var self = this;
            
            /* Toggle callback */
            var _toggleCallback = function() {
                if (self.$pageIncludes.hasClass('product-layout-scroll')) {
                    self.singleProductPinSummaryUpdate();
                }
            };
            
            /* Toggle selected panel */
            var _togglePanel = function(panel) {
                var $panelHeading = $(panel);
                $panelHeading.parent('.nm-product-accordion-panel').toggleClass('active');
                $panelHeading.next('.nm-product-accordion-content').slideToggle(200, function() { _toggleCallback(); });
            };
            
            /* Toggle selected panel and close open panel */
            var _togglePanels = function(panel) {
                var $panelHeading = $(panel),
                    $panel = $panelHeading.parent('.nm-product-accordion-panel'),
                    $panelContent = $panelHeading.next('.nm-product-accordion-content');
                
                if ($panel.hasClass('open')) {
                    $panel.removeClass('open');
                    $panelContent.slideUp(200, function() { _toggleCallback(); });
                } else {
                    var $panelOpen = self.$productAccordion.children('.open');
                    
                    if ($panelOpen.length) {
                        var $panelOpenContent = $panelOpen.children('.nm-product-accordion-content');
                        
                        $panel.addClass('open');
                        $panelOpen.removeClass('open');
                        
                        $panelContent.slideDown(200);
                        $panelOpenContent.slideUp(200, function() { _toggleCallback(); });
                    } else {
                        $panel.addClass('open');
                        
                        $panelContent.slideDown(200, function() { _toggleCallback(); });
                    }
                }
            };
            
            /* Bind: Accordion headings */
            self.$productAccordion.children('.nm-product-accordion-panel').children('.nm-product-accordion-heading').on('click', function(e) {
                e.preventDefault();
                if (nm_wp_vars.productAccordionCloseOpen != '0') {
                    _togglePanels(this);
                } else {
                    _togglePanel(this);
                }
            });
        },
        
        
        /**
         *  Single product: Review form button
         */
        singleProductReviewFormButton: function() {
            $('#nm-review-form-btn').magnificPopup({
                mainClass: 'nm-review-form-popup nm-mfp-fade-in',
                closeMarkup: '<a class="mfp-close nm-font nm-font-close2"></a>',
                removalDelay: 180,
                closeBtnInside: true,
                items: {
                    src: '#review_form',
                    type: 'inline'
                }
            });
        }
		
	});
	
	// Add extension so it can be called from $.nmThemeExtensions
	$.nmThemeExtensions.singleProduct = $.nmTheme.singleProduct_init;
	
})(jQuery);