<?php
/*
	Plugin Name: Savoy Theme - Portfolio
	Plugin URI: http://themeforest.net/item/savoy-minimalist-ajax-woocommerce-theme/12537825
	Description: Portfolio plugin for the Savoy theme.
	Version: 1.2.8
	Author: NordicMade
	Author URI: http://www.nordicmade.com
	Text Domain: nm-portfolio
	Domain Path: /languages/
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/*
 * NM: Portfolio Class
 */
class NM_Portfolio {
	
	/* Init */
	function init() {
		// Constants
		define( 'NM_PORTFOLIO_VERSION', '1.2.8' );
        define( 'NM_PORTFOLIO_DIR', plugin_dir_path( __FILE__ ) );
        define( 'NM_PORTFOLIO_INC_DIR', plugin_dir_path( __FILE__ ) . 'includes' );
		define( 'NM_PORTFOLIO_URI', plugin_dir_url( __FILE__ ) );
		
		// Load plugin text-domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		
		// Enqueue styles
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 99 );
		
		// Post type
		require( NM_PORTFOLIO_INC_DIR . '/post-types/class-portfolio-type.php' );
        
        // Include shortcode
		add_action( 'init', array( $this, 'register_shortcode' ) );
        
        // WPBakery Page Builder (Visual Composer)
        require( NM_PORTFOLIO_INC_DIR . '/visual-composer/init.php' );
        
        // Plugin activation/deactivation hooks
        register_activation_hook( __FILE__, array( &$this, 'activate' ) );
        //register_deactivation_hook( __FILE__, array( &$this, 'deactivate' ) );
	}
	
    
    /* Plugin activation */
	function activate() {
        // Register the post-type before flushing rewrite rules
        global $NM_Portfolio_Type;
        $NM_Portfolio_Type->register_post_type();
        
        // Flush rewrite rules (so the post-type permalink structure works)
        flush_rewrite_rules();
    }
    
    
	/* Plugin deactivation */
	/*function deactivate() {
        // Flush rewrite rules
        flush_rewrite_rules();
    }*/
    
    
	/* Load plugin text-domain */
	function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'nm-portfolio' );
		
		load_textdomain( 'nm-portfolio', WP_LANG_DIR . '/nm-portfolio/nm-portfolio-' . $locale . '.mo' );
		load_plugin_textdomain( 'nm-portfolio', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}
	
	
	/* Enqueue styles */
	function enqueue_styles() {
		wp_enqueue_style( 'nm-portfolio', NM_PORTFOLIO_URI . 'assets/css/nm-portfolio.css', array(), NM_PORTFOLIO_VERSION, 'all' );
	}
    
    
    /* Enqueue scripts */
	function enqueue_scripts() {
		nm_add_page_include( 'portfolio' );
        
        wp_enqueue_script( 'nm-portfolio', NM_PORTFOLIO_URI . 'assets/js/nm-portfolio.min.js', array( 'jquery' ), NM_PORTFOLIO_VERSION, true );
	}
    
    
    /* Include shortcode */
    function register_shortcode() {
        include( NM_PORTFOLIO_INC_DIR . '/shortcodes/portfolio.php' );
    }
	
}


/*
 *  Init
 */
function nm_portfolio_init() {
    // Make sure the theme is activated
    if ( defined( 'NM_THEME_VERSION' ) ) {
        $NM_Portfolio = new NM_Portfolio();
        $NM_Portfolio->init();
    }
}
add_action( 'after_setup_theme', 'nm_portfolio_init' );


/*
 *  Get portfolio template directory
 */
function nm_portfolio_include_dir( $file ) {
    // Get theme/child-theme directory
    $theme_template = get_stylesheet_directory() . '/' . $file;
    
    // Does a file exist in the child-theme directory?
    if ( file_exists( $theme_template ) ) {
        return $theme_template;
    } else {
        return NM_PORTFOLIO_DIR . '/templates/' . $file;
    }
}
