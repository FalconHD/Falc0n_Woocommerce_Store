<?php
/*
	Plugin Name: Savoy Theme - Instagram Gallery
	Plugin URI: http://themeforest.net/item/savoy-minimalist-ajax-woocommerce-theme/12537825
	Description: Display Instagram images from your account.
	Version: 1.3.5
	Author: NordicMade
	Author URI: http://www.nordicmade.com
	Text Domain: nm-instagram
	Domain Path: /languages/
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/*
 * NM: Main class
 */
class NM_Instagram {
	
	/* Init */
	function init() {
		// Constants
		define( 'NM_INSTAGRAM_VERSION', '1.3.5' );
        define( 'NM_INSTAGRAM_DIR', plugin_dir_path( __FILE__ ) );
        define( 'NM_INSTAGRAM_INC_DIR', plugin_dir_path( __FILE__ ) . 'includes/' );
		define( 'NM_INSTAGRAM_URI', plugin_dir_url( __FILE__ ) );
		
		// Load plugin text-domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
        
        // Options page
        require_once( NM_INSTAGRAM_INC_DIR . 'class-instagram-options.php' );
        function nm_instagram_options_init() {
            NM_Instagram_Options::get_instance();
        }
        add_action( 'init', 'nm_instagram_options_init' );
        
        // Instagram API
        require_once( NM_INSTAGRAM_INC_DIR . 'class-instagram-api.php' );
        
        // Include shortcode
		add_action( 'init', array( $this, 'include_shortcode' ) );
        
        // Visual Composer
        require( NM_INSTAGRAM_INC_DIR . 'visual-composer/init.php' );
	}
	
    
	/* Load plugin text-domain */
	function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'nm-instagram' );
		
		load_textdomain( 'nm-instagram', WP_LANG_DIR . '/nm-instagram/nm-instagram-' . $locale . '.mo' );
		load_plugin_textdomain( 'nm-instagram', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}
    
    
    /* Include shortcode */
    function include_shortcode() {
        include( NM_INSTAGRAM_INC_DIR . '/shortcodes/instagram.php' );
    }
	
}

$NM_Instagram = new NM_Instagram();
$NM_Instagram->init();