<?php
/*
	Plugin Name: Savoy Theme - Team Members
	Plugin URI: http://themeforest.net/item/savoy-minimalist-ajax-woocommerce-theme/12537825
	Description: Team Members plugin for the Savoy theme.
	Version: 1.0.8
	Author: NordicMade
	Author URI: http://www.nordicmade.com
	Text Domain: nm-post-types
	Domain Path: /languages/
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/*
 * NM: Post Types Class
 */
class NM_Post_Types {
	
	/* Init */
	function init() {
		define( 'NM_TEAM_DIR', plugin_dir_path( __FILE__ ) . 'includes/' );
		
		// Load plugin text-domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		
		// Post types
		require( NM_TEAM_DIR . 'post-types/class-team-type.php' );
		
        // Include: Shortcode
		add_action( 'init', array( $this, 'register_shortcode' ) );
		
		// Visual composer
		require( NM_TEAM_DIR . 'visual-composer/init.php' );
	}
	
	
	/* Load plugin text-domain */
	function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'nm-post-types' );
		
		load_textdomain( 'nm-post-types', WP_LANG_DIR . '/nm-post-types/nm-post-types-' . $locale . '.mo' );
		load_plugin_textdomain( 'nm-post-types', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}
	
    
    /* Include shortcode */
    function register_shortcode() {
        include( NM_TEAM_DIR . 'shortcodes/team.php' );
    }
    
	
	/* Post type - Meta box: Verify save action */
	function meta_box_verify_save_action( $post_id, $meta_box_nonce_name ) {
		// NM: WP code - https://codex.wordpress.org/Function_Reference/add_meta_box
		
		/* We need to verify this came from our screen and with proper authorization, because the save_post action can be triggered at other times. */
		
		// Check if our nonce is set.
		if ( ! isset( $_POST[$meta_box_nonce_name] ) ) {
			return false;
		}
	
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST[$meta_box_nonce_name], 'nm-theme' ) ) {
			return false;
		}
	
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return false;
		}
	
		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return false;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return false;
			}
		}
		
		/* OK, it's safe for us to save the data now. */
		return true;
		
		// /NM: WP code
	}
	
}


$NM_Post_Types = new NM_Post_Types();
$NM_Post_Types->init();
