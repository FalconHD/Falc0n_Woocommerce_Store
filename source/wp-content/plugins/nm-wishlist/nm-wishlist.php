<?php
/*
	Plugin Name: Savoy Theme - Wishlist
	Plugin URI: http://themeforest.net/item/savoy-minimalist-ajax-woocommerce-theme/12537825
	Description: Wishlist plugin for the Savoy theme.
	Version: 2.4.2
	Author: NordicMade
	Author URI: http://www.nordicmade.com
	Text Domain: nm-wishlist
	Domain Path: /languages/
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/*
 * Class: NM Wishlist
 */
class NM_Wishlist {
	
		
	private $version = '2.4.2';
	private $cookie_name = 'nm-wishlist-ids'; // Wishlist cookie name
	
	
	/*
     *  Constructor
     */
	function __construct() {
		define( 'NM_WISHLIST_DIR', plugin_dir_path( __FILE__ ) );
		
        
        // Load plugin text-domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
        
        
        // Set the wishlist IDs global (returns empty array if no products are added)
		global $nm_wishlist_ids, $nm_wishlist_ids_flipped;
        if ( isset( $_GET['nmwl_share'] ) && ! empty( $_GET['nmwl_share'] ) ) {
            $nm_wishlist_ids = $this->ids_get_from_share_url();
        } else {
            $nm_wishlist_ids = $this->ids_get_saved();
            // Make sure an array is returned
            $nm_wishlist_ids = ( ! is_array( $nm_wishlist_ids ) ) ? array() : $nm_wishlist_ids;
        }
        $nm_wishlist_ids_flipped = array_flip( $nm_wishlist_ids ); // Using "array_flip()" so the indexes/product IDs can be checked with "isset()"
        
        // Social share: Add meta tags
        $add_social_meta = apply_filters( 'nm_wishlist_add_social_meta', true );
        if ( $add_social_meta ) {
            add_action( 'wp_head', array( $this, 'social_share_meta_tags' ), 0 );
        }
        
        
        // Scripts
		add_action( 'wp_footer', array( $this, 'enqueue_scripts' ), 19 );
		
		
        // Register AJAX functions
        add_action( 'wp_ajax_nm_wishlist_get_ids' , array( $this, 'ids_get_json' ) );
        add_action( 'wp_ajax_nm_wishlist_update_ids' , array( $this, 'ids_update' ) );
        
        
        // Login action
        add_action( 'wp_login', array( $this, 'ids_merge' ), 10, 2 );
        
        
		// Wishlist shortcode
		add_shortcode( 'nm_wishlist', array( $this, 'wishlist' ) );
	}
	
	
	/*
     *  Load plugin text-domain
     */
	function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'nm-wishlist' );
		
		load_textdomain( 'nm-wishlist', WP_LANG_DIR . '/nm-wishlist/nm-wishlist-' . $locale . '.mo' );
		load_plugin_textdomain( 'nm-wishlist', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}
	
	
	/*
     *  Build plugin url
     */
	function url( $path ) {
		return plugins_url( $path, __FILE__ );
	}
    
    
    /* 
     *  Social share: Add meta tags
     */
    function social_share_meta_tags() {
        global $nm_theme_options;
        
        $wishlist_page_id = isset( $nm_theme_options['wishlist_page_id'] ) ? intval( apply_filters( 'wpml_object_id', $nm_theme_options['wishlist_page_id'] ) ) : 0;
        
		if ( $wishlist_page_id > 0 && is_page( $wishlist_page_id ) && $nm_theme_options['wishlist_share'] ) {
            global $nm_wishlist_social_meta, $nm_wishlist_ids;
            
            $share_link_url = esc_url( get_permalink( $wishlist_page_id ) . '?nmwl_share=' . implode( ',', $nm_wishlist_ids ) );
            $nm_wishlist_social_meta = apply_filters( 'nm_wishlist_social_header_meta', array(
                'url'         => $share_link_url,
                'type'        => 'product.group',
                'title'       => esc_attr( $nm_theme_options['wishlist_share_title'] ),
                'description' => esc_attr( str_replace( '%wishlist_url%', $share_link_url, $nm_theme_options['wishlist_share_text'] ) ),
                'image'       => esc_url( $nm_theme_options['wishlist_share_image_url'] ),
            ) );
            
            // Fb
            foreach ( $nm_wishlist_social_meta as $name => $content ) {
                echo sprintf( '<meta property="og:%s" content="%s" />', $name, $content );
            }
            echo "\n";
            
            // G+
            echo sprintf( '<meta itemprop="name" content="%s">', $nm_wishlist_social_meta['title'] );
            echo sprintf( '<meta itemprop="description" content="%s">', $nm_wishlist_social_meta['description'] );
            echo sprintf( '<meta itemprop="image" content="%s">', $nm_wishlist_social_meta['image'] );
            echo "\n";
        }
    }
    
    
	/*
     *  Enqueue scripts
     */
	function enqueue_scripts() {
		global $nm_page_includes, $nm_theme_options;
		
        // Enqueue scripts?
        if ( is_product() || isset( $nm_page_includes['products'] ) || isset( $nm_page_includes['wishlist-home'] ) ) {
            $enqueue_scripts = true;
        } else {
            //$enqueue_scripts = apply_filters( 'nm_wishlist_global_scripts', false );
            $enqueue_scripts = ( isset( $nm_theme_options['menu_wishlist_count'] ) && $nm_theme_options['menu_wishlist_count'] ) ? true : false;
        }
        
		if ( $enqueue_scripts ) {
			wp_enqueue_script( 'nm-wishlist', $this->url( 'assets/js/nm-wishlist.min.js' ), array( 'jquery' ), $this->version );
			
			// Add localized Javascript variables
    		$localized_js_vars = array(
                'wlLoginRequire'        => ( isset( $nm_theme_options['wishlist_require_login'] ) ) ? intval( $nm_theme_options['wishlist_require_login'] ) : 0,
                'wlLoginRedirectUrl'    => esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
                'wlNonce'               => wp_create_nonce( 'nm-wishlist-nonce' ),
                'wlCookieExpires'       => apply_filters( 'nm_wishlist_cookie_expires', 30 ),
				'wlButtonTitleAdd'		=> __( 'Add to Wishlist', 'nm-wishlist' ),
				'wlButtonTitleRemove'   => __( 'Remove from Wishlist', 'nm-wishlist' ),
                'wlMenuCount'           => ( isset( $nm_theme_options['menu_wishlist_count'] ) ) ? intval( $nm_theme_options['menu_wishlist_count'] ) : 0
			);
    		wp_localize_script( 'nm-wishlist', 'nm_wishlist_vars', $localized_js_vars );
		}
	}
	
	
	/*
     *  Get wishlist cookie
     */
	function get_cookie() {
		if ( isset( $_COOKIE[$this->cookie_name] ) ) {
            $ids_array = $this->ids_convert_to_array( $_COOKIE[$this->cookie_name] );
            return $ids_array;
		}
		
		return array();
	}
    
    
    /*
     *  IDs: Get from share URL
     */
    function ids_get_from_share_url() {
        $query_string_ids = explode( ',', $_GET['nmwl_share'] );
        $wishlist_ids = array();
        
        foreach( $query_string_ids as $id ) {
            $wishlist_ids[] = (int)$id;
        }
        
        return $wishlist_ids;
    }
    
    
    /*
     *  IDs: Convert string to array
     */
    function ids_convert_to_array( $ids_string ) {
        // Convert string to array
        $ids_array = json_decode( stripslashes( $ids_string ), true );
        
        return $ids_array;
    }
    
    
    /*
     *  IDs: Get saved
     */
	function ids_get_saved() {
        $user_id = get_current_user_id();
        
        if ( $user_id > 0 ) {
            $ids = get_user_meta( $user_id, 'nm_wishlist_ids', true );
        } else {
            $ids = $this->get_cookie();
        }
        
        return $ids;
    }
    
    
    /*
     *  IDs: Get JSON
     */
    function ids_get_json() { 
        global $nm_wishlist_ids;
        echo json_encode( array( 'ids' => $nm_wishlist_ids ), true );
        exit;
    }
    
    
    /*
     *  IDs: Merge from cookie and saved
     */
    function ids_merge( $user_login, $user ) {
        $ids_saved = get_user_meta( $user->ID, 'nm_wishlist_ids', true );
        $ids_saved = ( is_array( $ids_saved ) ) ? $ids_saved : array(); // Make sure returned value is an array
            
        $ids_cookie = $this->get_cookie();
        
        // Merge cookie and saved IDs arrays
        //$ids_merged = $ids_cookie + $ids_saved;
        $ids_merged = ( is_array( $ids_cookie ) ) ? $ids_cookie + $ids_saved : array();
        
        if ( ! empty( $ids_merged ) ) {
            update_user_meta( $user->ID, 'nm_wishlist_ids', $ids_merged );
        }
    }
    
    
    /*
     *  IDs: Update
     */
	function ids_update( $ids_string = '' ) {
		$return_data = array();
        
        // Note: Added $ids_string to make it possible to use this function directly
        if ( isset( $_POST['ids'] ) ) {
            // Validate nonce from AJAX request
            $nonce_bypass = apply_filters( 'nm_wishlist_nonce_bypass', false );
            if ( ! $nonce_bypass && ! check_ajax_referer( 'nm-wishlist-nonce', 'nonce' ) ) {
                wp_send_json_error( 'Invalid security token.' );
                wp_die();
            }
            
            $is_ajax = true;
            $ids_string = $_POST['ids'];
        } else {
            $is_ajax = false;
        }
        
        if ( strlen( $ids_string ) > 0 ) {
            $user_id = get_current_user_id();

            if ( $user_id > 0 ) {
                $ids_array = $this->ids_convert_to_array( $ids_string );
                
                global $nm_wishlist_ids;
                $nm_wishlist_ids = $ids_array;
                
                update_user_meta( $user_id, 'nm_wishlist_ids', $ids_array );
                
                $return_data['ids_count'] = count( $ids_array );
            }
        }
        
        if ( $is_ajax ) {
            echo json_encode( $return_data );
            
            exit;
        }
	}
	
	
	/*
     *  Shortcode: Wishlist
     */
	function wishlist() {
        global $nm_wishlist_ids, $nm_wishlist_loop;
        
        nm_add_page_include( 'wishlist-home' );
        
        // Product query
        if ( ! empty( $nm_wishlist_ids ) ) {
            $posts_per_page = apply_filters( 'nm_wishlist_products_limit', 500 ); // -1 = no limit
            
            $args = apply_filters( 'nm_wishlist_products_query',
                array(
                    'post_type'		 => 'product',
                    'order'			 => 'DESC',
                    'orderby' 		 => 'post__in',
                    'posts_per_page' => $posts_per_page,
                    'post__in'		 => $nm_wishlist_ids
                ),
                $nm_wishlist_ids
            );

            $nm_wishlist_loop = new WP_Query( $args );
        } else {
            $nm_wishlist_loop = false;
        }
        
        // Get theme/child-theme template (if available)
        $wishlist_template = get_stylesheet_directory() . '/wishlist.php'; 
        
        // Include wishlist template
        if ( file_exists( $wishlist_template ) ) {
            include( $wishlist_template );
        } else {
            include( NM_WISHLIST_DIR . 'templates/wishlist.php' );
        }
		
		// Restore original Post Data
		wp_reset_postdata();
	}
	
	
}


/*
 *  Function: Init wishlist class
 */
function nm_wishlist_init() {
	// Make the WooCommerce plugin is activated
	if ( class_exists( 'WooCommerce' ) )  {
		global $NM_Wishlist;
        $NM_Wishlist = new NM_Wishlist();
	}
}
add_action( 'plugins_loaded', 'nm_wishlist_init' );


/*
 *  Function: Include wishlist button
 */
function nm_wishlist_button() {
	global $nm_wishlist_ids_flipped, $product;
	
	$button_class = '';
	$title = NULL;
    $product_id = $product->get_id();
    
	// Is the product added?
	if ( isset( $nm_wishlist_ids_flipped[$product_id] ) ) {
		$button_class = ' added';
		$title = esc_html__( 'Remove from Wishlist', 'nm-wishlist' );
	}
	
	$title = ( $title ) ? $title : esc_html__( 'Add to Wishlist', 'nm-wishlist' );
    $icon = apply_filters( 'nm_wishlist_button_icon', '<i class="nm-font nm-font-heart-o"></i>' );
    
    printf( '<a href="#" id="nm-wishlist-item-%1$s-button" class="nm-wishlist-button nm-wishlist-item-%1$s-button%2$s" data-product-id="%1$s" title="%3$s">%4$s</a>',
        esc_attr( $product_id ),
        $button_class,
        $title,
        $icon
    );
}


/*
 *  Function: Get header link
 */
function nm_wishlist_get_header_link( $allow_icon = true ) {
    global $nm_theme_options;
    
    if ( isset( $nm_theme_options ) ) {
        $wishlist_page_id = isset( $nm_theme_options['wishlist_page_id'] ) ? intval( apply_filters( 'wpml_object_id', $nm_theme_options['wishlist_page_id'] ) ) : 0;
        
        $link_href = get_permalink( $wishlist_page_id );
        $link_title = ( $allow_icon && $nm_theme_options['menu_wishlist_icon'] ) ? $nm_theme_options['menu_wishlist_icon_html'] : '<span class="nm-menu-wishlist-title">' . esc_html__( 'Wishlist', 'nm-wishlist' ) . '</span>';
        
        if ( $nm_theme_options['menu_wishlist_count'] ) {
            global $nm_wishlist_ids;
            $count = count( $nm_wishlist_ids );
            $count_element = ' <span class="nm-menu-wishlist-count">' . $count . '</span>';
        } else {
            $count_element = '';
        }
        
        return '<a href="' . esc_url( $link_href ) . '">' . $link_title . $count_element . '</a>';
    }
    
    return '';
}
