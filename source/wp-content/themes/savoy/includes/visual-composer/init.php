<?php
    
	/* WPBakery Page Builder: Initialize
	================================================== */
	
	if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {
		global $nm_theme_options, $nm_globals;
		
        
		// Globals: "Stock" features
        $nm_globals['vcomp_enable_frontend'] = ( $nm_theme_options['vcomp_enable_frontend'] != '0' ) ? true : false;
        $nm_globals['vcomp_stock'] = ( $nm_theme_options['vcomp_stock'] != '0' ) ? true : false;
        
        
		// Theme directory
		define( 'NM_VC_DIR', NM_DIR . '/visual-composer/' );
		
		
		// Enable 'theme mode' (disables plugin update message)
		if ( function_exists( 'vc_set_as_theme' ) ) {
			vc_set_as_theme( true );
		}
		
        
        /* Admin body class */
        function nm_vc_admin_body_class( $classes ) {
            $classes .= ' nm-vcomp-stock ';
            return $classes;
        }
        if ( $nm_globals['vcomp_stock'] ) {
            add_filter( 'admin_body_class', 'nm_vc_admin_body_class' );
        }
		
        
		// Disable frontend editor
		if ( ! $nm_globals['vcomp_enable_frontend'] ) {
			vc_disable_frontend();
		}
		
        
        /* Frontend assets */
        function nm_vc_frontend_assets() {
            global $nm_globals;
            
            $style_handle = 'nm_js_composer_front';
            $script_handle = 'nm_composer_front_js';
            
            if ( ! $nm_globals['vcomp_enable_frontend'] && ! $nm_globals['vcomp_stock'] ) {
                // Important: Use the default style/script handles to make sure inline styles/scripts are included (deregistering the default styles/scripts disables these) - https://wordpress.stackexchange.com/questions/262235/dequeue-only-stylesheets-but-not-inline-style-added-using-wp-add-inline-style
                $style_handle = 'js_composer_front';
                $script_handle = 'wpb_composer_front_js';
                
                // Deregister styles
                wp_deregister_style( 'js_composer_front' );

                // Deregister scripts
                wp_deregister_script( 'wpb_composer_front_js' );

                // Disable "enqueueStyle()" function (looks through the content for "vc_row" elements using "preg_match()")
                remove_action( 'wp_enqueue_scripts', array( visual_composer(), 'enqueueStyle' ) ); // "enqueueStyle()" is located in: "../js_composer/include/classes/core/class-vc-base.php"
            } else {
                // Add class to "body" when default elements/resources are enabled (used to override default styling)
                global $nm_body_class;
                $nm_body_class[] = 'nm-wpb-default';
            }
            
            if ( ! $nm_globals['vcomp_stock'] ) {
                // Deregister styles
                wp_deregister_style( 'font-awesome' );
                
                // Enqueue frontend styles (original stylesheet with unused styles removed)
                wp_enqueue_style( $style_handle, NM_THEME_URI . '/assets/css/visual-composer/nm-js_composer.css', array(), NM_THEME_VERSION, 'all' );

                // Enqueue frontend scripts (original file with unused scripts removed)
                wp_enqueue_script( $script_handle, NM_THEME_URI . '/assets/js/visual-composer/nm-js_composer_front.min.js', array( 'jquery' ), NM_THEME_VERSION, true );
            }
            
            /* Scripts that should always be disabled: */
            
            // Causes error on "add to cart" from quick-view: Disable custom WooCommerce add-to-cart script (action is located in: "../js_composer/include/autoload/vendors/woocommerce.php)
            remove_action( 'wp_enqueue_scripts', 'vc_woocommerce_add_to_cart_script' );
        }
        add_action( 'wp_enqueue_scripts', 'nm_vc_frontend_assets', 1 );
        
        
		if ( ! $nm_globals['vcomp_stock'] ) {
            /* "tta" resources (accordions, tabs, tour) */
            function nm_vc_tta_resources() {
                if ( wp_script_is( 'vc_accordion_script' ) || wp_script_is( 'vc_tabs_script' ) ) { // Make sure the stock "tta" scripts are enqueued
                    // Deregister styles
                    wp_deregister_style( 'vc_tta_style' );
                    
                    // Deregister scripts
                    wp_deregister_script( 'vc_accordion_script' );
                    wp_deregister_script( 'vc_tta_autoplay_script' );
                    wp_deregister_script( 'vc_tabs_script' );

                    // Enqueue scripts
                    wp_enqueue_script( 'nm_accordions_tabs', NM_THEME_URI . '/assets/js/visual-composer/nm-accordions-tabs.min.js', array( 'jquery' ), NM_THEME_VERSION, true );
                }
            }
            add_action( 'wp_footer', 'nm_vc_tta_resources', 10 );
        }
		
		
		// Set element template files directory
		$vc_element_templates_dir = NM_VC_DIR . '/element-templates/';
		vc_set_shortcodes_templates_dir( $vc_element_templates_dir );
		
		
		// Check if "CF7" is enabled
		global $nm_cf7_enabled;
		$nm_cf7_enabled = ( defined( 'WPCF7_PLUGIN' ) ) ? true : false;
		
		
		if ( is_admin() ) {
			// Page templates
			include( NM_VC_DIR . '/page-templates.php' );
			
			
			// Include elements configuration
			include( NM_DIR . '/visual-composer/elements-config.php' );
			
            
			// Include custom params
			include( NM_VC_DIR . '/params/iconpicker.php' );
            
            
            if ( ! $nm_globals['vcomp_stock'] ) {
				if ( nm_woocommerce_activated() ) {
					/* Remove default WooCommerce elements */
					function nm_vc_remove_woocommerce_elements() {
						vc_remove_element( 'woocommerce_cart' );
						vc_remove_element( 'woocommerce_checkout' );
						vc_remove_element( 'woocommerce_my_account' );
						vc_remove_element( 'product' );
						vc_remove_element( 'product_page' );
						vc_remove_element( 'product_categories' );
					}
					add_action( 'vc_build_admin_page', 'nm_vc_remove_woocommerce_elements', 11 ); // Hook for admin editor
					add_action( 'vc_load_shortcode', 'nm_vc_remove_woocommerce_elements', 11 ); // Hook for frontend editor
				}
                
                
                /* Remove admin menus */
				function nm_vc_remove_admin_menus() {
					remove_submenu_page( 'vc-general', 'vc-automapper' );
					remove_submenu_page( 'vc-general', 'edit.php?post_type=vc_grid_item' );
				}
				add_action( 'admin_menu', 'nm_vc_remove_admin_menus', 1000 );
                
                
                // Disable shortcode automapper feature
				if ( function_exists( 'vc_automapper' ) ) {
					vc_automapper()->setDisabled( true );
				}
			}
			
			
			/* Remove "vc_teaser" metabox */
			function nm_vc_remove_teaser_metabox() {
				remove_meta_box( 'vc_teaser', '', 'side' );
			}
			add_action( 'admin_head', 'nm_vc_remove_teaser_metabox' );
			
			
			// Set default editor post types (will not be used if the "content_types" VC setting is already saved - see fix below)
			$post_types = array(
				'page',
                'portfolio'
			);
			vc_set_default_editor_post_types( $post_types );
			
			// Default editor post types: Un-comment and refresh WP admin to save/reset the "content_types" VC option
			// NOTE: Remember to comment-out after page refresh!
			//vc_settings()->set( 'content_types', $post_types );
		}
		
		
		/* Remove header meta tag */
		/*function nm_vc_remove_meta() {
			remove_action( 'wp_head', array( visual_composer(), 'addMetaData' ) );
		}
		add_action( 'init', 'nm_vc_remove_meta', 100 );*/
        
        
        
		/*
		 * VC: Output custom styles - The plugin doesn't output custom styles on non-singular pages (like blog-index and shop archives)
		 *
		 * See "addFrontCss()" in "../js_composer/include/classes/core/class-vc-base.php"
		 */
		function nm_vc_addFrontCss( $page_id ) {
			// Get custom styles from the post meta (returns empty strings if no results)
			$post_custom_css = get_post_meta( $page_id, '_wpb_post_custom_css', true );
			$shortcodes_custom_css = get_post_meta( $page_id, '_wpb_shortcodes_custom_css', true );
							
			if ( $post_custom_css != '' || $shortcodes_custom_css != '' ) {
				echo '<style type="text/css" class="nm-vc-styles">' . $post_custom_css . $shortcodes_custom_css . '</style>';
			}
		}
		
		
		/* Shop: Output custom styles for page content on shop archives */
		function nm_shop_vc_styles() {
			if ( is_shop() || is_product_taxonomy() ) {
				$shop_page_content_id = nm_shop_get_page_content_id();
                
				nm_vc_addFrontCss( $shop_page_content_id );
			}
		}
		if ( nm_woocommerce_activated() ) {
			add_action( 'wp_head', 'nm_shop_vc_styles', 1000 );
		}
		
		
		/* Blog: Output custom styles for page content on blog index archive */
		function nm_blog_index_vc_styles() {
			global $nm_theme_options;
			
			nm_vc_addFrontCss( $nm_theme_options['blog_static_page_id'] );
		}
		
	}
