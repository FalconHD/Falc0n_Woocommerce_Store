<?php

	/* Constants & Globals
	==================================================================================================== */
    
	// Uncomment to include un-minified JavaScript files
	//define( 'NM_DEBUG_MODE', TRUE );
	
	// Constants: Folder directories/uri's
	define( 'NM_THEME_DIR', get_template_directory() );
	define( 'NM_DIR', get_template_directory() . '/includes' );
	define( 'NM_THEME_URI', get_template_directory_uri() );
	define( 'NM_URI', get_template_directory_uri() . '/includes' );
	
	// Constant: Framework namespace
	define( 'NM_NAMESPACE', 'nm-framework' );
	
	// Constant: Theme version
	define( 'NM_THEME_VERSION', '2.6.0' );
	
	// Global: Theme options
	global $nm_theme_options;
	
	// Global: Page includes
	global $nm_page_includes;
	$nm_page_includes = array();
	
	// Global: <body> class
	global $nm_body_class;
	$nm_body_class = array();
	
	// Global: Theme globals
	global $nm_globals;
	$nm_globals = array();
	
    // Globals: WooCommerce - Cart panel quantity throttle
    $nm_globals['widget_panel_qty_throttle'] = intval( apply_filters( 'nm_cart_panel_qty_throttle', 0 ) );

    // Globals: WooCommerce - Shop search
    $nm_globals['shop_search_enabled']  = false;
    $nm_globals['shop_search']          = false;
    $nm_globals['shop_search_header']   = false;
    $nm_globals['shop_search_popup']    = false;
    
    // Globals: WooCommerce - Search suggestions
    $nm_globals['shop_search_suggestions_max_results'] = 6;

    // Globals: WooCommerce - Shop header
    $nm_globals['shop_header_centered'] = false;

	// Global: WooCommerce - "Product Slider" shortcode loop
	$nm_globals['product_slider_loop'] = false;
	
	// Global: WooCommerce - Shop image lazy-loading
	$nm_globals['shop_image_lazy_loading'] = false;
	
    // Globals: WooCommerce - Custom variation controls
    $nm_globals['pa_color_slug'] = sanitize_title( apply_filters( 'nm_color_attribute_slug', 'color' ) );
    $nm_globals['pa_variation_controls'] = array(
        'color' => esc_html__( 'Color', 'nm-framework-admin' ),
        'image' => esc_html__( 'Image', 'nm-framework-admin' ),
        'size'  => esc_html__( 'Label', 'nm-framework-admin' )
    );
    $nm_globals['pa_cache'] = array();
    
    
    
    /* Admin localisation (must be placed before admin includes)
    ==================================================================================================== */
    
    if ( defined( 'NM_ADMIN_LOCALISATION' ) && is_admin() ) {
        $language_dir = apply_filters( 'nm_admin_languages_dir', NM_THEME_DIR . '/languages/admin' );
        
        load_theme_textdomain( 'nm-framework-admin', $language_dir );
        load_theme_textdomain( 'redux-framework', $language_dir );
    }
    
    
    
    /* WP Rocket: Deactivate WooCommerce refresh cart fragments cache: https://docs.wp-rocket.me/article/1100-optimize-woocommerce-get-refreshed-fragments
	==================================================================================================== */
    
    $wpr_cart_fragments_cache = apply_filters( 'nm_wpr_cart_fragments_cache', false );
    if ( ! $wpr_cart_fragments_cache ) {
        add_filter( 'rocket_cache_wc_empty_cart', '__return_false' );
    }
    
    
    
    /* Redux theme options framework
	==================================================================================================== */
	
    if ( ! isset( $redux_demo ) ) {
        require( NM_DIR . '/options/options-config.php' );
        // Add "custom code" section via plugin method
        if ( class_exists( 'NM_Custom_Code' ) ) {
            NM_Custom_Code::add_settings_section();
        }
    }

    // Get theme options
    $nm_theme_options = get_option( 'nm_theme_options' );

    // Is the theme options array saved?
    if ( ! $nm_theme_options ) {
        // Save default options array
        require( NM_DIR . '/options/default-options.php' );
    }

    do_action( 'nm_theme_options_set' );

    // Get theme options
    $nm_theme_options = get_option( 'nm_theme_options' );

    // Is the theme options array saved?
    if ( ! $nm_theme_options ) {
        // Save default options array
        require( NM_DIR . '/options/default-options.php' );
    }

    do_action( 'nm_theme_options_set' );
    
    
    
	/* Includes
	==================================================================================================== */        	
    
    // Custom CSS
    require( NM_DIR . '/custom-styles.php' );

	// Helper functions
	require( NM_DIR . '/helpers.php' );
	
	// Admin meta
	require( NM_DIR . '/admin-meta.php' );
	
    // Block editor (Gutenberg)
    require( NM_DIR . '/block-editor/block-editor.php' );
    
	// Visual composer
	require( NM_DIR . '/visual-composer/init.php' );
	
	if ( nm_woocommerce_activated() ) {
        // Globals: WooCommerce - Custom variation controls
        $nm_globals['custom_variation_controls'] = ( $nm_theme_options['product_display_attributes'] || $nm_theme_options['shop_filters_custom_controls'] || $nm_theme_options['product_custom_controls'] ) ? true : false;
        
        // WooCommerce: Wishlist
		$nm_globals['wishlist_enabled'] = class_exists( 'NM_Wishlist' );
        
		// WooCommerce: Functions
		include( NM_DIR . '/woocommerce/woocommerce-functions.php' );
        // WooCommerce: Template functions
		include( NM_DIR . '/woocommerce/woocommerce-template-functions.php' );
        // WooCommerce: Attribute functions
		if ( $nm_globals['custom_variation_controls'] ) {
            include( NM_DIR . '/woocommerce/woocommerce-attribute-functions.php' );
        }
		
		// WooCommerce: Quick view
		if ( $nm_theme_options['product_quickview'] ) {
			$nm_page_includes['quickview'] = true;
			include( NM_DIR . '/woocommerce/quickview.php' );
		}
		
		// WooCommerce: Shop search
        if ( $nm_theme_options['shop_search'] !== '0' ) {
            // Globals: Shop search
			$nm_globals['shop_search_enabled'] = true;
            if ( $nm_theme_options['shop_search'] === 'header' ) {
                $nm_globals['shop_search_header'] = true;
            }
            
            include( NM_DIR . '/woocommerce/search.php' );
            
            // WooCommerce: Search suggestions
            if ( ( $nm_globals['shop_search_header'] && $nm_theme_options['shop_search_suggestions'] ) || defined( 'NM_SUGGESTIONS_INCLUDE' ) ) {
                $nm_globals['shop_search_suggestions_max_results'] = intval( apply_filters( 'nm_shop_search_suggestions_max_results', $nm_theme_options['shop_search_suggestions_max_results'] ) );
                
                include( NM_DIR . '/woocommerce/search-suggestions.php' );
            }
		}
	}
    
    
    
    /* Admin includes
	==================================================================================================== */
    
	if ( is_admin() ) {
        // TGM plugin activation
		require( NM_DIR . '/tgmpa/config.php' );
        
        // Theme setup wizard
        require_once( NM_DIR . '/setup/nm-setup.php' );
        
        if ( nm_woocommerce_activated() ) {
			// WooCommerce: Product details
			include( NM_DIR . '/woocommerce/admin/admin-product-details.php' );
			// WooCommerce: Product categories
			include( NM_DIR . '/woocommerce/admin/admin-product-categories.php' );
            // WooCommerce: Product attributes
			if ( $nm_globals['custom_variation_controls'] ) {
                include( NM_DIR . '/woocommerce/admin/admin-product-attributes.php' );
                include( NM_DIR . '/woocommerce/admin/admin-product-data.php' );
            }
		}
	}
	
    
	
	/* Globals (requires includes)
	==================================================================================================== */
    
    // Globals: Login link
    $nm_globals['login_popup'] = false;
    
    // Globals: Cart link/panel
	$nm_globals['cart_link']   = false;
	$nm_globals['cart_panel']  = false;

    // Globals: Shop filters popup
    $nm_globals['shop_filters_popup'] = false;

	// Globals: Shop filters scrollbar
	$nm_globals['shop_filters_scrollbar'] = false;

	if ( nm_woocommerce_activated() ) {
		// Global: Shop page id
		$nm_globals['shop_page_id'] = ( ! empty( $_GET['shop_page'] ) ) ? intval( $_GET['shop_page'] ) : wc_get_page_id( 'shop' );
		
		// Globals: Login link
		$nm_globals['login_popup'] = ( $nm_theme_options['menu_login_popup'] ) ? true : false;
        
		// Global: Cart link/panel
		if ( $nm_theme_options['menu_cart'] != '0' && ! $nm_theme_options['shop_catalog_mode'] ) {
			$nm_globals['cart_link'] = true;
			
			// Is mini cart panel enabled?
			if ( $nm_theme_options['menu_cart'] != 'link' ) {
				$nm_globals['cart_panel'] = true;
			}
		}
		
        // Globals: Shop filters popup
        if ( $nm_theme_options['shop_filters'] == 'popup' ) {
            $nm_globals['shop_filters_popup'] = true;
        }
        
		// Globals: Shop filters scrollbar
        if ( $nm_theme_options['shop_filters_scrollbar'] ) {
			$nm_globals['shop_filters_scrollbar'] = true;
		}
        
        // Globals: Shop search
        if ( $nm_globals['shop_search_enabled'] && ! $nm_globals['shop_search_header'] ) {
            if ( $nm_globals['shop_filters_popup'] ) {
                $nm_globals['shop_search_popup'] = true; // Show search in filters pop-up
            } else {
                $nm_globals['shop_search'] = true; // Show search in shop header
            }
        }
        
        // Globals: Product gallery zoom
        $nm_globals['product_image_hover_zoom'] = ( $nm_theme_options['product_image_hover_zoom'] ) ? true : false;
	}
	
	
	
	/* Theme Support
	==================================================================================================== */

	if ( ! function_exists( 'nm_theme_support' ) ) {
		function nm_theme_support() {
			global $nm_theme_options;
            
            // Let WordPress manage the document title (no hard-coded <title> tag in the document head)
            add_theme_support( 'title-tag' );
			
			// Enables post and comment RSS feed links to head
			add_theme_support( 'automatic-feed-links' );
			
			// Add thumbnail theme support
			add_theme_support( 'post-thumbnails' );
            
            // WooCommerce
			add_theme_support( 'woocommerce' );
            add_theme_support( 'wc-product-gallery-slider' );
            if ( $nm_theme_options['product_image_zoom'] ) {
                add_theme_support( 'wc-product-gallery-lightbox' );
            }
            
			// Localisation
			// WordPress language directory: wp-content/languages/theme-name/en_US.mo
			load_theme_textdomain( 'nm-framework', trailingslashit( WP_LANG_DIR ) . 'nm-framework' );
			// Child theme language directory: wp-content/themes/child-theme-name/languages/en_US.mo
			load_theme_textdomain( 'nm-framework', get_stylesheet_directory() . '/languages' );
			// Theme language directory: wp-content/themes/theme-name/languages/en_US.mo
			load_theme_textdomain( 'nm-framework', NM_THEME_DIR . '/languages' );
		}
	}
	add_action( 'after_setup_theme', 'nm_theme_support' );
	
	// Maximum width for media
	if ( ! isset( $content_width ) ) {
		$content_width = 1220; // Pixels
	}
	
	
    
	/* Styles
	==================================================================================================== */
	
	function nm_styles() {
		global $nm_theme_options, $nm_globals, $nm_page_includes;
        
        if ( defined( 'NM_DEBUG_MODE' ) && NM_DEBUG_MODE ) {
            $suffix = '';
        } else {
            $suffix = '.min';
        }
        
		// Enqueue third-party styles
		wp_enqueue_style( 'normalize', NM_THEME_URI . '/assets/css/third-party/normalize' . $suffix . '.css', array(), '3.0.2', 'all' );
		wp_enqueue_style( 'slick-slider', NM_THEME_URI . '/assets/css/third-party/slick' . $suffix . '.css', array(), '1.5.5', 'all' );
		wp_enqueue_style( 'slick-slider-theme', NM_THEME_URI . '/assets/css/third-party/slick-theme' . $suffix . '.css', array(), '1.5.5', 'all' );
        wp_enqueue_style( 'magnific-popup', NM_THEME_URI . '/assets/css/third-party/magnific-popup' . $suffix . '.css', array(), '0.9.7', 'all' );
		if ( $nm_theme_options['font_awesome'] ) {
            if ( $nm_theme_options['font_awesome_version'] == '4' ) {
                wp_enqueue_style( 'font-awesome', '//stackpath.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css', array(), false, 'all' );
            } else {
                $font_awesome_cdn_url = apply_filters( 'nm_font_awesome_cdn_url', 'https://kit-free.fontawesome.com/releases/latest/css/free.min.css' );
                wp_enqueue_style( 'font-awesome', $font_awesome_cdn_url, array(), '5.x', 'all' );
            }
		}
		
		// Theme styles: Grid (enqueue before shop styles)
		wp_enqueue_style( 'nm-grid', NM_THEME_URI . '/assets/css/grid.css', array(), NM_THEME_VERSION, 'all' );
		
		// WooCommerce styles		
		if ( nm_woocommerce_activated() ) {
            if ( is_cart() ) {
                // Widget panel: Disable on "Cart" page
                $nm_globals['cart_panel'] = false;
            } else if ( is_checkout() ) {
                // Widget panel: Disable on "Checkout" page
                $nm_globals['cart_panel'] = false;
            }
			
			wp_enqueue_style( 'selectod', NM_THEME_URI . '/assets/css/third-party/selectod' . $suffix . '.css', array(), '3.8.1', 'all' );
			wp_enqueue_style( 'nm-shop', NM_THEME_URI . '/assets/css/shop.css', array(), NM_THEME_VERSION, 'all' );
		}
		
		// Theme styles
		wp_enqueue_style( 'nm-icons', NM_THEME_URI . '/assets/css/font-icons/theme-icons/theme-icons' . $suffix . '.css', array(), NM_THEME_VERSION, 'all' );
		wp_enqueue_style( 'nm-core', NM_THEME_URI . '/style.css', array(), NM_THEME_VERSION, 'all' );
		wp_enqueue_style( 'nm-elements', NM_THEME_URI . '/assets/css/elements.css', array(), NM_THEME_VERSION, 'all' );
	}
	add_action( 'wp_enqueue_scripts', 'nm_styles', 99 );
	
	
    
	/* Scripts
	==================================================================================================== */
	
    /* Scripts: Get Path and Suffix presets (includes un-minified scripts in "debug mode") */
    function nm_scripts_get_presets() {
        $presets = array();
        
        if ( defined( 'NM_DEBUG_MODE' ) && NM_DEBUG_MODE ) {
            $presets['path'] = NM_THEME_URI . '/assets/js/dev/';
            $presets['suffix'] = '';
        } else {
            $presets['path'] = NM_THEME_URI . '/assets/js/';
            $presets['suffix'] = '.min';
        }
        
        return $presets;
    }
    
    
    /* Scripts: Product page  */
    function nm_scripts_product_page( $presets ) {
        global $nm_globals;
        
        if ( $nm_globals['product_image_hover_zoom'] ) {
            wp_enqueue_script( 'easyzoom', NM_THEME_URI . '/assets/js/plugins/easyzoom.min.js', array( 'jquery' ), '2.5.2', true );
        }
        wp_enqueue_script( 'nm-shop-add-to-cart' );
        wp_enqueue_script( 'nm-shop-single-product', $presets['path'] . 'nm-shop-single-product' . $presets['suffix'] . '.js', array( 'jquery', 'nm-shop' ), NM_THEME_VERSION, true );
    }
    
    
    /* Scripts: Enqueue */
	function nm_scripts() {
		if ( ! is_admin() ) {
			global $nm_theme_options, $nm_globals, $nm_page_includes;
			
			
			// Script path and suffix setup (debug mode loads un-minified scripts)
            $presets = nm_scripts_get_presets();
            
            
            // Register scripts
            wp_register_script( 'nm-masonry', NM_THEME_URI . '/assets/js/plugins/masonry.pkgd.min.js', array(), '4.2.2', true ); // Note: Using "nm-" prefix so the included WP version isn't used (it doesn't support the "horizontalOrder" option)
            
            
			// Enqueue scripts
			wp_enqueue_script( 'modernizr', NM_THEME_URI . '/assets/js/plugins/modernizr.min.js', array( 'jquery' ), '2.8.3', true );
            wp_enqueue_script( 'slick-slider', NM_THEME_URI . '/assets/js/plugins/slick.min.js', array( 'jquery' ), '1.5.5', true );
			wp_enqueue_script( 'magnific-popup', NM_THEME_URI . '/assets/js/plugins/jquery.magnific-popup.min.js', array( 'jquery' ), '0.9.9', true );
			wp_enqueue_script( 'nm-core', $presets['path'] . 'nm-core' . $presets['suffix'] . '.js', array( 'jquery' ), NM_THEME_VERSION, true );
			
			
			// Enqueue blog scripts
            wp_enqueue_script( 'nm-blog', $presets['path'] . 'nm-blog' . $presets['suffix'] . '.js', array( 'jquery' ), NM_THEME_VERSION, true );
			
			
			// WP comments script
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
			
			
			if ( nm_woocommerce_activated() ) {
				// Register shop/product scripts
				wp_register_script( 'selectod', NM_THEME_URI . '/assets/js/plugins/selectod.custom.min.js', array( 'jquery' ), '3.8.1', true );
				if ( $nm_theme_options['product_ajax_atc'] && get_option( 'woocommerce_cart_redirect_after_add' ) == 'no' ) {
                    wp_register_script( 'nm-shop-add-to-cart', $presets['path'] . 'nm-shop-add-to-cart' . $presets['suffix'] . '.js', array( 'jquery', 'nm-shop' ), NM_THEME_VERSION, true );
                }
				wp_register_script( 'nm-shop', $presets['path'] . 'nm-shop' . $presets['suffix'] . '.js', array( 'jquery', 'nm-core', 'selectod' ), NM_THEME_VERSION, true );
				wp_register_script( 'nm-shop-quickview', $presets['path'] . 'nm-shop-quickview' . $presets['suffix'] . '.js', array( 'jquery', 'nm-shop', 'wc-add-to-cart-variation' ), NM_THEME_VERSION, true );
				wp_register_script( 'nm-shop-login', $presets['path'] . 'nm-shop-login' . $presets['suffix'] . '.js', array( 'jquery' ), NM_THEME_VERSION, true );
				wp_register_script( 'nm-shop-infload', $presets['path'] . 'nm-shop-infload' . $presets['suffix'] . '.js', array( 'jquery', 'nm-shop' ), NM_THEME_VERSION, true );
				wp_register_script( 'nm-shop-filters', $presets['path'] . 'nm-shop-filters' . $presets['suffix'] . '.js', array( 'jquery', 'nm-shop' ), NM_THEME_VERSION, true );
                
				
				// Login popup
				if ( $nm_globals['login_popup'] ) {
					wp_enqueue_script( 'nm-shop-login' );
                    
                    // Enqueue "password strength meter" script
                    // Note: The code below is from the "../plugins/woocommerce/includes/class-wc-frontend-scripts.php" file
                    if ( ! is_cart() || ! is_checkout() || ! is_account_page() ) {
                        if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) && ! is_user_logged_in() ) {
                            wp_enqueue_script( 'wc-password-strength-meter' );
                            wp_localize_script( 'wc-password-strength-meter', 'wc_password_strength_meter_params', apply_filters( 'wc_password_strength_meter_params', array(
                                'min_password_strength' => apply_filters( 'woocommerce_min_password_strength', 3 ),
                                'i18n_password_error'   => esc_attr__( 'Please enter a stronger password.', 'woocommerce' ),
                                'i18n_password_hint'    => esc_attr( wp_get_password_hint() ),
                            ) ) );
                        }
                    }
				}
                
                
                // Product search
                if ( $nm_globals['shop_search_enabled'] ) {
                    wp_enqueue_script( 'nm-shop-search', $presets['path'] . 'nm-shop-search' . $presets['suffix'] . '.js', array( 'jquery' ), NM_THEME_VERSION, true );
                }
				
                
				// WooCommerce page - Note: Does not include the Cart, Checkout or Account pages
				if ( is_woocommerce() ) {
					// Single product page
					if ( is_product() ) {
                        nm_scripts_product_page( $presets );
					} 
					// Shop page (except Single product, Cart and Checkout)
					else {
						wp_enqueue_script( 'smartscroll', NM_THEME_URI . '/assets/js/plugins/jquery.smartscroll.min.js', array( 'jquery' ), '1.0', true );
						wp_enqueue_script( 'nm-shop-infload' );
						wp_enqueue_script( 'nm-shop-filters' );
					}
				} else {
					// Cart page
					if ( is_cart() ) {
						wp_enqueue_script( 'nm-shop-cart', $presets['path'] . 'nm-shop-cart' . $presets['suffix'] . '.js', array( 'jquery', 'nm-shop' ), NM_THEME_VERSION, true );
					} 
					// Checkout page
					else if ( is_checkout() ) {
						wp_enqueue_script( 'nm-shop-checkout', $presets['path'] . 'nm-shop-checkout' . $presets['suffix'] . '.js', array( 'jquery', 'nm-shop' ), NM_THEME_VERSION, true );
					}
					// Account page
					else if ( is_account_page() ) {
						wp_enqueue_script( 'nm-shop-login' );
					}
				}
			}
			
			
			// Add local Javascript variables
            $local_js_vars = array(
                'themeUri' 				        => NM_THEME_URI,
                'ajaxUrl' 				        => admin_url( 'admin-ajax.php', 'relative' ),
                'woocommerceAjaxUrl'            => ( class_exists( 'WC_AJAX' ) ) ? WC_AJAX::get_endpoint( "%%endpoint%%" ) : '',
				'searchUrl'				        => esc_url_raw( add_query_arg( 's', '%%nmsearchkey%%', home_url( '/' ) ) ), // Code from "WC_AJAX->get_endpoint()" WooCommerce function
                'pageLoadTransition'            => intval( $nm_theme_options['page_load_transition'] ),
                'headerPlaceholderSetHeight'    => intval( apply_filters( 'nm_header_placeholder_set_height', 1 ) ),
                'cartPanelQtyArrows'            => intval( $nm_theme_options['cart_panel_quantity_arrows'] ),
                'cartPanelQtyThrottleTimeout'   => $nm_globals['widget_panel_qty_throttle'],
                'cartPanelShowOnAtc'            => intval( $nm_theme_options['widget_panel_show_on_atc'] ),
                'cartPanelHideOnAtcScroll'      => ( ! defined( 'NM_ATC_SCROLL' ) ) ? 1 : 0,
                'shopFiltersAjax'		        => esc_attr( $nm_theme_options['shop_filters_enable_ajax'] ),
				'shopAjaxUpdateTitle'	        => intval( $nm_theme_options['shop_ajax_update_title'] ),
				'shopImageLazyLoad'		        => intval( $nm_theme_options['product_image_lazy_loading'] ),
                'shopScrollOffset' 		        => intval( $nm_theme_options['shop_scroll_offset'] ),
				'shopScrollOffsetTablet'        => intval( $nm_theme_options['shop_scroll_offset_tablet'] ),
                'shopScrollOffsetMobile'        => intval( $nm_theme_options['shop_scroll_offset_mobile'] ),
                'shopSearch'                    => ( $nm_globals['shop_search_enabled']  ) ? 1 : 0,
                'shopSearchHeader'			    => ( $nm_globals['shop_search_header'] ) ? 1 : 0,
                'shopSearchUrl'                 => esc_url_raw( apply_filters( 'nm_shop_search_url', add_query_arg( array( 'post_type' => 'product', 's' => '%%nmsearchkey%%' ), home_url( '/' ) ) ) ),
                'shopSearchMinChar'		        => intval( $nm_theme_options['shop_search_min_char'] ),
				'shopSearchAutoClose'           => intval( $nm_theme_options['shop_search_auto_close'] ),
                'searchSuggestions'             => intval( $nm_theme_options['shop_search_suggestions'] ),
                'searchSuggestionsInstant'      => intval( $nm_theme_options['shop_search_suggestions_instant'] ),
                'searchSuggestionsMax'          => $nm_globals['shop_search_suggestions_max_results'],
                'shopAjaxAddToCart'		        => ( $nm_theme_options['product_ajax_atc'] && get_option( 'woocommerce_cart_redirect_after_add' ) == 'no' ) ? 1 : 0,
                'shopRedirectScroll'            => intval( $nm_theme_options['product_redirect_scroll'] ),
                'shopCustomSelect'              => intval( $nm_theme_options['product_custom_select'] ),
                'quickviewLinks'                => $nm_theme_options['product_quickview_link_actions'],
                'galleryZoom'                   => intval( $nm_theme_options['product_image_zoom'] ),
                'galleryThumbnailsSlider'       => intval( $nm_theme_options['product_thumbnails_slider'] ),
                'shopYouTubeRelated'            => ( ! defined( 'NM_SHOP_YOUTUBE_RELATED' ) ) ? 1 : 0,
                'productAccordionCloseOpen'     => intval( apply_filters( 'nm_product_accordion_close_open', 1 ) ),
                'checkoutTacLightbox'           => intval( $nm_theme_options['checkout_tac_lightbox'] ),
                'rowVideoOnTouch'               => ( ! defined( 'NM_ROW_VIDEO_ON_TOUCH' ) ) ? 0 : 1,
                'wpGalleryPopup'                => intval( $nm_theme_options['wp_gallery_popup'] ),
                'touchHover'		            => intval( apply_filters( 'nm_touch_hover', 1 ) ),
                'pushStateMobile'               => intval( apply_filters( 'nm_push_state_mobile', 0 ) ),
                'infloadBuffer'                 => intval( apply_filters( 'nm_infload_scroll_buffer', 0 ) ),
                'infloadPreserveScrollPos'      => intval( apply_filters( 'nm_infload_preserve_scroll_position', 1 ) ),
			);
    		wp_localize_script( 'nm-core', 'nm_wp_vars', $local_js_vars );
		}
	}
	add_action( 'wp_enqueue_scripts', 'nm_scripts' );
	
    
    /* Scripts - Content dependent: Uses globals to check for included content */
	function nm_scripts_content_dependent() {
		if ( ! is_admin() ) {
			global $nm_theme_options, $nm_globals, $nm_page_includes;
			
			// Blog
			if ( isset( $nm_page_includes['blog-masonry'] ) ) {
                wp_enqueue_script( 'nm-masonry' );
            }
			
			if ( nm_woocommerce_activated() ) {
                // Product categories
                if ( isset( $nm_page_includes['product_categories_masonry'] ) ) {
                    wp_enqueue_script( 'nm-masonry' );
                }
                
				// Shop/products
				if ( isset( $nm_page_includes['products'] ) ) {
					wp_enqueue_script( 'lazysizes', NM_THEME_URI . '/assets/js/plugins/lazysizes.min.js', array(), '4.0.1', true );
                    wp_enqueue_script( 'selectod' );
					wp_enqueue_script( 'nm-shop-add-to-cart' );
					if ( $nm_theme_options['product_quickview'] ) {
						wp_enqueue_script( 'nm-shop-quickview' );
					}
				} else if ( isset( $nm_page_includes['wishlist-home'] ) ) {
					wp_enqueue_script( 'nm-shop-add-to-cart' );
				}
                
                // Single product: Product page shortcode
                if ( ! is_product() && isset( $nm_globals['is_product'] ) ) {
                    $presets = nm_scripts_get_presets();
                    nm_scripts_product_page( $presets );
                }
				// Single product: Scroll gallery
                if ( isset( $nm_page_includes['product-layout-scroll'] ) ) {
                    wp_enqueue_script( 'pin', NM_THEME_URI . '/assets/js/plugins/jquery.pin.min.js', array( 'jquery' ), '1.0.3', true );
				}
			}
		}
	}
	add_action( 'wp_footer', 'nm_scripts_content_dependent' );
	
    
    
	/* Admin Assets
	==================================================================================================== */
	
	function nm_admin_assets( $hook ) {
		// Styles
		wp_enqueue_style( 'nm-admin-styles', NM_URI . '/assets/css/nm-wp-admin.css', array(), NM_THEME_VERSION, 'all' );
		
        // Menus page
		if ( 'nav-menus.php' == $hook ) {
            // Init assets for the WP media manager - https://codex.wordpress.org/Javascript_Reference/wp.media
            wp_enqueue_media();
            
            wp_enqueue_script( 'nm-admin-menus', NM_URI . '/assets/js/nm-wp-admin-menus.js', array( 'jquery' ), NM_THEME_VERSION );
        }
	}
	add_action( 'admin_enqueue_scripts', 'nm_admin_assets' );
	
	
	
	/* Web fonts
	==================================================================================================== */
	
	/* Adobe Fonts (formerly Typekit) */
	function nm_adobe_fonts() {
		global $nm_theme_options;
		
        $adobe_fonts_stylesheets = array();
        
        // Main/body font
        if ( $nm_theme_options['main_font_source'] === '2' && isset( $nm_theme_options['main_font_adobefonts_project_id'] ) ) {
            $adobe_fonts_stylesheets[] = $nm_theme_options['main_font_adobefonts_project_id'];
            wp_enqueue_style( 'nm-adobefonts-main', '//use.typekit.net/' . esc_attr( $nm_theme_options['main_font_adobefonts_project_id'] ) . '.css' );
        }
        
        // Header font
        if ( $nm_theme_options['header_font_source'] === '2' && isset( $nm_theme_options['header_font_adobefonts_project_id'] ) ) {
            // Make sure stylesheet name is unique (avoid multiple includes)
            if ( ! in_array( $nm_theme_options['header_font_adobefonts_project_id'], $adobe_fonts_stylesheets ) ) {
                $adobe_fonts_stylesheets[] = $nm_theme_options['header_font_adobefonts_project_id'];
                wp_enqueue_style( 'nm-adobefonts-header', '//use.typekit.net/' . esc_attr( $nm_theme_options['header_font_adobefonts_project_id'] ) . '.css' );
            }
        }
        
        // Headings font
        if ( $nm_theme_options['secondary_font_source'] === '2' && isset( $nm_theme_options['secondary_font_adobefonts_project_id'] ) ) {
            // Make sure stylesheet name is unique (avoid multiple includes)
            if ( ! in_array( $nm_theme_options['secondary_font_adobefonts_project_id'], $adobe_fonts_stylesheets ) ) {
                $adobe_fonts_stylesheets[] = $nm_theme_options['secondary_font_adobefonts_project_id'];
                wp_enqueue_style( 'nm-adobefonts-secondary', '//use.typekit.net/' . esc_attr( $nm_theme_options['secondary_font_adobefonts_project_id'] ) . '.css' );
            }
        }
	};
	add_action( 'wp_enqueue_scripts', 'nm_adobe_fonts' );
	
    
    
    /* WP Customizer - Notice
	==================================================================================================== */

    function nm_wpcustomizer_notice() {
        $handle = 'nm-wpcustomizer-notice';
        
        wp_register_script( $handle, NM_URI . '/assets/js/nm-wpcustomizer-notice.js', array( 'customize-controls' ), NM_THEME_VERSION );
        
        $notice = array(
            'notice' => sprintf(
                esc_html( '%sNote:%s Font settings are available on: <a href="%s">Theme Settings > Typography</a>', 'nm-framework-admin' ),
                '<strong>',
                '</strong>',
                admin_url( 'admin.php?page=Savoy&tab=6' )
            )
        );
        
        wp_localize_script( $handle, 'nm_wpcustomizer_notice', $notice );
        wp_enqueue_script( $handle );
    }
    add_action( 'customize_controls_enqueue_scripts', 'nm_wpcustomizer_notice' );
	
	
    
	/* Redux Framework
	==================================================================================================== */
	
	/* Remove redux sub-menu from "Tools" admin menu */
	function nm_remove_redux_menu() {
		remove_submenu_page( 'tools.php', 'redux-about' );
	}
	add_action( 'admin_menu', 'nm_remove_redux_menu', 12 );
	
	
	
	/* Theme Setup
	==================================================================================================== */
    
    /* Video embeds: Wrap video element in "div" container (to make them responsive) */
    function nm_wrap_oembed( $html, $url, $attr ) {
        if ( false !== strpos( $url, 'vimeo.com' ) ) {
            return '<div class="nm-wp-video-wrap nm-wp-video-wrap-vimeo">' . $html . '</div>';
        }
        if ( false !== strpos( $url, 'youtube.com' ) ) {
            return '<div class="nm-wp-video-wrap nm-wp-video-wrap-youtube">' . $html . '</div>';
        }
        
        return $html;
    }
    add_filter( 'embed_oembed_html', 'nm_wrap_oembed', 10, 3 );
    
    function nm_wrap_video_embeds( $html ) {
        return '<div class="nm-wp-video-wrap">' . $html . '</div>';
    }
    add_filter( 'video_embed_html', 'nm_wrap_video_embeds' ); // Jetpack
    
    
    
    /* Body classes
	==================================================================================================== */
    
    function nm_body_classes( $classes ) {
        global $nm_theme_options, $nm_body_class, $nm_globals;
        $woocommerce_activated = nm_woocommerce_activated();
        
        // Make sure $nm_body_class is an array
        $nm_body_class = ( is_array( $nm_body_class ) ) ? $nm_body_class : array();
        
        // Page load transition class
        $nm_body_class[] = 'nm-page-load-transition-' . $nm_theme_options['page_load_transition'];

        // CSS animations preload class
        $nm_body_class[] = 'nm-preload';

        // Top bar class
        if ( $nm_theme_options['top_bar'] ) {
            $nm_body_class[] = 'has-top-bar top-bar-mobile-' . $nm_theme_options['top_bar_mobile'];
        }

        // Header: Classes
        $nm_body_class[] = ( $nm_theme_options['header_fixed'] ) ? 'header-fixed' : '';
        $nm_body_class[] = 'header-mobile-' . $nm_theme_options['header_layout_mobile'];
        
        // Header: Classes - Transparency
        global $post;
        $page_header_transparency = ( $post ) ? get_post_meta( $post->ID, 'nm_page_header_transparency', true ) : array();
        if ( ! empty( $page_header_transparency ) ) {
            $nm_body_class[] = 'header-transparency header-transparency-' . $page_header_transparency;
        } else if ( $nm_theme_options['header_transparency'] ) {
            if ( is_front_page() ) {
                $nm_body_class[] = ( $nm_theme_options['header_transparency_homepage'] !== '0' ) ? 'header-transparency header-transparency-' . $nm_theme_options['header_transparency_homepage'] : '';
            } else if ( is_home() ) { // Note: This is the blog/posts page, not the homepage
                $nm_body_class[] = ( $nm_theme_options['header_transparency_blog'] !== '0' ) ? 'header-transparency header-transparency-' . $nm_theme_options['header_transparency_blog'] : '';
            } else if ( is_singular( 'post' ) ) {
                $nm_body_class[] = ( $nm_theme_options['header_transparency_blog_post'] !== '0' ) ? 'header-transparency header-transparency-' . $nm_theme_options['header_transparency_blog_post'] : '';
            } else if ( $woocommerce_activated ) {
                if ( is_shop() ) {
                    $nm_body_class[] = ( $nm_theme_options['header_transparency_shop'] !== '0' ) ? 'header-transparency header-transparency-' . $nm_theme_options['header_transparency_shop'] : '';
                } else if ( is_product_taxonomy() ) {
                    $nm_body_class[] = ( $nm_theme_options['header_transparency_shop_categories'] !== '0' ) ? 'header-transparency header-transparency-' . $nm_theme_options['header_transparency_shop_categories'] : '';
                } else if ( is_product() ) {
                    $nm_body_class[] = ( $nm_theme_options['header_transparency_product'] !== '0' ) ? 'header-transparency header-transparency-' . $nm_theme_options['header_transparency_product'] : '';
                }
            }
        }

        // Header: Classes - Border
        if ( is_front_page() ) {
            $nm_body_class[] = 'header-border-' . $nm_theme_options['home_header_border'];
        } elseif ( $woocommerce_activated && ( is_shop() || is_product_taxonomy() ) ) {
            $nm_body_class[] = 'header-border-' . $nm_theme_options['shop_header_border'];
        } else {
            $nm_body_class[] = 'header-border-' . $nm_theme_options['header_border'];
        }

        // Widget panel classes
        $nm_body_class[] = 'widget-panel-' . $nm_theme_options['widget_panel_color'];
        if ( $nm_globals['widget_panel_qty_throttle'] > 0 ) {
            $nm_body_class[] = 'widget-panel-qty-throttle';
        }

        // WooCommerce: login
        if ( $woocommerce_activated && ! is_user_logged_in() && is_account_page() ) {
            $nm_body_class[] = 'nm-woocommerce-account-login';
        }
        
        // WooCommerce: Catalog mode
        if ( $nm_theme_options['shop_catalog_mode'] ) {
            $nm_body_class[] = 'nm-catalog-mode';
        }
        
        $body_class = array_merge( $classes, $nm_body_class );
        
        return $body_class;
    }
    add_filter( 'body_class', 'nm_body_classes' );
    
    
    
    /* Header
	==================================================================================================== */
    
    /* Get header classes */
    function nm_header_get_classes() {
        global $nm_globals, $nm_theme_options;
        
        // Layout class
        $header_classes = $nm_theme_options['header_layout'];

        // Scroll class
        $header_scroll_class = apply_filters( 'nm_header_on_scroll_class', 'resize-on-scroll' );
        $header_classes .= ( strlen( $header_scroll_class ) > 0 ) ? ' ' . $header_scroll_class : '';

        // Alternative logo class
        if ( $nm_theme_options['alt_logo'] && isset( $nm_theme_options['alt_logo_visibility'] ) ) {
            $alt_logo_class = '';
            foreach( $nm_theme_options['alt_logo_visibility'] as $key => $val ) {
                if ( $val === '1' ) {
                    $alt_logo_class .= ' ' . $key;
                }
            }
            $header_classes .= $alt_logo_class;
        }
        
        return $header_classes;
    }
    
    
    /* Logo: Get logo */
    function nm_logo() {
        global $nm_theme_options;
        
        if ( isset( $nm_theme_options['logo'] ) && strlen( $nm_theme_options['logo']['url'] ) > 0 ) {
            $logo = array(
                'id'        => $nm_theme_options['logo']['id'],
                'url'       => ( is_ssl() ) ? str_replace( 'http://', 'https://', $nm_theme_options['logo']['url'] ) : $nm_theme_options['logo']['url'],
                'width'     => $nm_theme_options['logo']['width'],
                'height'    => $nm_theme_options['logo']['height']
            );
        } else {
            $logo = array(
                'id'        => '',
                'url'       => NM_THEME_URI . '/assets/img/logo@2x.png',
                'width'     => '232',
                'height'    => '33'
            );
        }
        
        return apply_filters( 'nm_logo', $logo );
    }
    
    /* (Included for backwards compatibility) Logo: Get URL */
    function nm_logo_get_url() {
        global $nm_theme_options;
        
        if ( isset( $nm_theme_options['logo'] ) && strlen( $nm_theme_options['logo']['url'] ) > 0 ) {
            $logo_url = ( is_ssl() ) ? str_replace( 'http://', 'https://', $nm_theme_options['logo']['url'] ) : $nm_theme_options['logo']['url'];
        } else {
            $logo_url = NM_THEME_URI . '/assets/img/logo@2x.png';
        }
        
        return $logo_url;
    }
    
    
    /* Alternative logo: Get logo */
    function nm_alt_logo() {
        global $nm_theme_options;
        
        $logo = null;
        
        if ( $nm_theme_options['alt_logo'] ) {
            // Logo URL
            if ( isset( $nm_theme_options['alt_logo_image'] ) && strlen( $nm_theme_options['alt_logo_image']['url'] ) > 0 ) {
                $logo = array(
                    'id'        => $nm_theme_options['alt_logo_image']['id'],
                    'url'       => ( is_ssl() ) ? str_replace( 'http://', 'https://', $nm_theme_options['alt_logo_image']['url'] ) : $nm_theme_options['alt_logo_image']['url'],
                    'width'     => $nm_theme_options['alt_logo_image']['width'],
                    'height'    => $nm_theme_options['alt_logo_image']['height']
                );
            } else {
                $logo = array(
                    'id'        => '',
                    'url'       => NM_THEME_URI . '/assets/img/logo-light@2x.png',
                    'width'     => '232',
                    'height'    => '33'
                );
            }
        }
        
        return apply_filters( 'nm_alt_logo', $logo );
    }
    
    /* (Included for backwards compatibility) Alternative logo: Get URL */
    function nm_alt_logo_get_url() {
        global $nm_theme_options;
        
        $logo_url = null;
        
        if ( $nm_theme_options['alt_logo'] ) {
            // Logo URL
            if ( isset( $nm_theme_options['alt_logo_image'] ) && strlen( $nm_theme_options['alt_logo_image']['url'] ) > 0 ) {
                $logo_url = ( is_ssl() ) ? str_replace( 'http://', 'https://', $nm_theme_options['alt_logo_image']['url'] ) : $nm_theme_options['alt_logo_image']['url'];
            } else {
                $logo_url = NM_THEME_URI . '/assets/img/logo-light@2x.png';
            }
        }
        
        return $logo_url;
    }
    
    
    
    /* Menus
	==================================================================================================== */
    
	if ( ! function_exists( 'nm_register_menus' ) ) {
		function nm_register_menus() {
			register_nav_menus( array(
				'top-bar-menu'	=> esc_html__( 'Top Bar', 'nm-framework' ),
				'main-menu'		=> esc_html__( 'Header Main', 'nm-framework' ),
				'right-menu'	=> esc_html__( 'Header Secondary (Right side)', 'nm-framework' ),
				'mobile-menu'   => esc_html__( 'Mobile', 'nm-framework-admin' ),
                'footer-menu'	=> esc_html__( 'Footer Bar', 'nm-framework' )
			) );
		}
	}
	add_action( 'init', 'nm_register_menus' );
    
    // Menus: Include custom functions
    require( NM_DIR . '/menus/menus.php' );
    if ( is_admin() ) {
        require( NM_DIR . '/menus/menus-admin.php' );
    }
    
    
    
	/* Blog
	==================================================================================================== */
	
    /* AJAX: Get blog content */
	function nm_blog_get_ajax_content() {
        // Is content requested via AJAX?
        if ( isset( $_REQUEST['blog_load'] ) && nm_is_ajax_request() ) {
            // Include blog content only (no header or footer)
            get_template_part( 'template-parts/blog/content' );
            exit;
        }
    }
    
    
    /* Get static content */
    function nm_blog_get_static_content() {
        global $nm_theme_options;
        
        if ( $nm_theme_options['blog_static_page'] ) {
            if ( function_exists( 'nm_blog_index_vc_styles' ) ) {
                // Custom vcomp styles
                add_action( 'wp_head', 'nm_blog_index_vc_styles', 1000 );
            }
        
            $blog_page = get_page( $nm_theme_options['blog_static_page_id'] );
        } else {
            $blog_page = false;
        }
            
        return $blog_page;
    }
    
    
	/* Post excerpt brackets - [...] */
	function nm_excerpt_read_more( $excerpt ) {
		$excerpt_more = '&hellip;';
		$trans = array(
			'[&hellip;]' => $excerpt_more // WordPress >= v3.6
		);
		
		return strtr( $excerpt, $trans );
	}
	add_filter( 'wp_trim_excerpt', 'nm_excerpt_read_more' );
	
	
	/* Blog categories menu */
	function nm_blog_category_menu() {
		global $wp_query, $nm_theme_options;

		$current_cat = ( is_category() ) ? $wp_query->queried_object->cat_ID : '';
		
		// Categories order
		$orderby = 'slug';
		$order = 'asc';
		if ( isset( $nm_theme_options['blog_categories_orderby'] ) ) {
			$orderby = $nm_theme_options['blog_categories_orderby'];
			$order = $nm_theme_options['blog_categories_order'];
		}
		
		$args = array(
			'type'			=> 'post',
			'orderby'		=> $orderby,
			'order'			=> $order,
			'hide_empty'	=> ( $nm_theme_options['blog_categories_hide_empty'] ) ? 1 : 0,
			'hierarchical'	=> 1,
			'taxonomy'		=> 'category'
		); 
		
		$categories = get_categories( $args );
		
		$current_class_set = false;
		$categories_output = '';
		
		// Categories menu divider
		$categories_menu_divider = apply_filters( 'nm_blog_categories_divider', '<span>&frasl;</span>' );
		
		foreach ( $categories as $category ) {
			if ( $current_cat == $category->cat_ID ) {
				$current_class_set = true;
				$current_class = ' class="current-cat"';
			} else {
				$current_class = '';
			}
			$category_link = get_category_link( $category->cat_ID );
			
			$categories_output .= '<li' . $current_class . '>' . $categories_menu_divider . '<a href="' . esc_url( $category_link ) . '">' . esc_attr( $category->name ) . '</a></li>';
		}
		
		$categories_count = count( $categories );
		
		// Categories layout classes
		$categories_class = ' toggle-' . $nm_theme_options['blog_categories_toggle'];
		if ( $nm_theme_options['blog_categories_layout'] === 'columns' ) {
			$column_small = ( intval( $nm_theme_options['blog_categories_columns'] ) > 4 ) ? '3' : '2';
			$categories_ul_class = 'columns small-block-grid-' . $column_small . ' medium-block-grid-' . $nm_theme_options['blog_categories_columns'];
		} else {
			$categories_ul_class = $nm_theme_options['blog_categories_layout'];
		}
		
		// "All" category class attr
		$current_class = ( $current_class_set ) ? '' : ' class="current-cat"';
		
		$output = '<div class="nm-blog-categories-wrap ' . esc_attr( $categories_class ) . '">';
		$output .= '<ul class="nm-blog-categories-toggle"><li><a href="#" id="nm-blog-categories-toggle-link">' . esc_html__( 'Categories', 'nm-framework' ) . '</a> <em class="count">' . $categories_count . '</em></li></ul>';
		$output .= '<ul id="nm-blog-categories-list" class="nm-blog-categories-list ' . esc_attr( $categories_ul_class ) . '"><li' . $current_class . '><a href="' . esc_url( get_post_type_archive_link( 'post' ) ) . '">' . esc_html__( 'All', 'nm-framework' ) . '</a></li>' . $categories_output . '</ul>';
        $output .= '</div>';
		
		return $output;
	}
    
    
	/* WP gallery */
    add_filter( 'use_default_gallery_style', '__return_false' );
    if ( $nm_theme_options['wp_gallery_popup'] ) {
        /* WP gallery popup: Set page include value */
        function nm_wp_gallery_set_include() {
            nm_add_page_include( 'wp-gallery' );
            return ''; // Returning an empty string will output the default WP gallery
        }
		add_filter( 'post_gallery', 'nm_wp_gallery_set_include' );
	}
	
    
    
	/* Comments
	==================================================================================================== */
    
    /* Comments callback */
	function nm_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
		?>
		<li class="post pingback">
			<p><?php esc_html_e( 'Pingback:', 'nm-framework' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( 'Edit', 'nm-framework' ), ' ' ); ?></p>
		<?php
			break;
			default :
		?>
		<li id="comment-<?php esc_attr( comment_ID() ); ?>" <?php comment_class(); ?>>
            <div class="comment-inner-wrap">
            	<?php if ( function_exists( 'get_avatar' ) ) { echo get_avatar( $comment, '60' ); } ?>
                
				<div class="comment-text">
                    <p class="meta">
                        <strong itemprop="author"><?php printf( '%1$s', get_comment_author_link() ); ?></strong>
                        <time itemprop="datePublished" datetime="<?php echo get_comment_date( 'c' ); ?>"><?php printf( esc_html__( '%1$s at %2$s', 'nm-framework' ), get_comment_date(), get_comment_time() ); ?></time>
                    </p>
                
                    <div itemprop="description" class="description entry-content">
                        <?php if ( $comment->comment_approved == '0' ) : ?>
                            <p class="moderating"><em><?php esc_html_e( 'Your comment is awaiting moderation', 'nm-framework' ); ?></em></p>
                        <?php endif; ?>
                        
                        <?php comment_text(); ?>
                    </div>
                    
                    <div class="reply">
                        <?php 
                            edit_comment_link( esc_html__( 'Edit', 'nm-framework' ), '<span class="edit-link">', '</span><span> &nbsp;-&nbsp; </span>' );
                            
                            comment_reply_link( array_merge( $args, array(
                                'depth' 	=> $depth,
                                'max_depth'	=> $args['max_depth']
                            ) ) );
                        ?>
                    </div>
                </div>
            </div>
		<?php
			break;
		endswitch;
	}
	
    
    
	/* Sidebars & Widgets
	==================================================================================================== */
	
	/* Register/include sidebars & widgets */
	function nm_widgets_init() {
		global $nm_globals, $nm_theme_options;
		
        // Sidebar: Page
		register_sidebar( array(
			'name' 				=> esc_html__( 'Page', 'nm-framework' ),
			'id' 				=> 'page',
			'before_widget'		=> '<div id="%1$s" class="widget %2$s">',
			'after_widget' 		=> '</div>',
			'before_title' 		=> '<h3 class="nm-widget-title">',
			'after_title' 		=> '</h3>'
		) );
        
		// Sidebar: Blog
		register_sidebar( array(
			'name' 				=> esc_html__( 'Blog', 'nm-framework' ),
			'id' 				=> 'sidebar',
			'before_widget'		=> '<div id="%1$s" class="widget %2$s">',
			'after_widget' 		=> '</div>',
			'before_title' 		=> '<h3 class="nm-widget-title">',
			'after_title' 		=> '</h3>'
		) );
        
		// Sidebar: Shop
		if ( $nm_globals['shop_filters_scrollbar'] ) {
            register_sidebar( array(
				'name' 				=> esc_html__( 'Shop', 'nm-framework' ),
				'id' 				=> 'widgets-shop',
				'before_widget'		=> '<li id="%1$s" class="scroll-enabled scroll-type-default widget %2$s"><div class="nm-shop-widget-col">',
				'after_widget' 		=> '</div></div></li>',
				'before_title' 		=> '<h3 class="nm-widget-title">',
				'after_title' 		=> '</h3></div><div class="nm-shop-widget-col"><div class="nm-shop-widget-scroll">'
			));
            
            // Prevent empty widget-titles so the scrollbar container is included
            function nm_widget_title( $title ) {
                if ( strlen( $title ) == 0 ) {
                    $title = '&nbsp;';
                }
                return $title;
            }
            add_filter( 'widget_title', 'nm_widget_title' );
		} else {
            register_sidebar( array(
				'name' 				=> esc_html__( 'Shop', 'nm-framework' ),
				'id' 				=> 'widgets-shop',
				'before_widget'		=> '<li id="%1$s" class="widget %2$s"><div class="nm-shop-widget-col">',
				'after_widget' 		=> '</div></li>',
				'before_title' 		=> '<h3 class="nm-widget-title">',
				'after_title' 		=> '</h3></div><div class="nm-shop-widget-col">'
			) );
		}
		
		// Sidebar: Footer
		register_sidebar( array(
			'name' 				=> esc_html__( 'Footer', 'nm-framework' ),
			'id' 				=> 'footer',
			'before_widget'		=> '<li id="%1$s" class="widget %2$s">',
			'after_widget' 		=> '</li>',
			'before_title' 		=> '<h3 class="nm-widget-title">',
			'after_title' 		=> '</h3>'
		) );
		
		// Sidebar: Visual Composer - Widgetised Sidebar
		register_sidebar( array(
			'name' 				=> esc_html__( '"Widgetised Sidebar" Element', 'nm-framework' ),
			'id' 				=> 'vc-sidebar',
			'before_widget'		=> '<div id="%1$s" class="widget %2$s">',
			'after_widget' 		=> '</div>',
			'before_title' 		=> '<h3 class="nm-widget-title">',
			'after_title' 		=> '</h3>'
		) );
		
		
		// WooCommerce: Unregister widgets
		unregister_widget( 'WC_Widget_Cart' );
	}
	add_action( 'widgets_init', 'nm_widgets_init' ); // Register widget sidebars
	
	
	/* Page includes: Include element */
	function nm_include_page_includes_element() {
		global $nm_page_includes;
		
		$classes = '';
		
		foreach ( $nm_page_includes as $class => $value )
			$classes .= $class . ' ';
		
		echo '<div id="nm-page-includes" class="' . esc_attr( $classes ) . '" style="display:none;">&nbsp;</div>' . "\n\n";
	}
	add_action( 'wp_footer', 'nm_include_page_includes_element' ); // Include "page includes" element
	
    
    
	/* Contact Form 7
	==================================================================================================== */
	
    // Disable default CF7 CSS
    add_filter( 'wpcf7_load_css', '__return_false' );
    