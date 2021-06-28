<?php
/*
	Plugin Name: Savoy Theme - Settings Panel
	Plugin URI: http://themeforest.net/item/savoy-minimalist-ajax-woocommerce-theme/12537825
	Description: Enables the theme's settings panel.
	Version: 1.0.9
	Author: NordicMade
	Author URI: http://www.nordicmade.com
	Text Domain: nm-theme-settings
	Domain Path: /languages/
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class NM_Theme_Settings {
	
    /* Init */
	function init() {
        // Constants
        define( 'NM_TS_DIR', plugin_dir_path( __FILE__ ) . 'includes' );
        
        if ( ! class_exists( 'ReduxFramework' ) ) {
            require_once( NM_TS_DIR . '/options/ReduxCore/framework.php' );
            require_once( NM_TS_DIR . '/options/customizer.php' );

            if ( is_admin() ) {
                // Remove dashboard widget
                function nm_redux_remove_dashboard_widget() {
                    remove_meta_box( 'redux_dashboard_widget', 'dashboard', 'side' );
                }
                add_action( 'wp_dashboard_setup', 'nm_redux_remove_dashboard_widget', 100 );
            }
        }
    }
	
}

$NM_Theme_Settings = new NM_Theme_Settings();
$NM_Theme_Settings->init();
