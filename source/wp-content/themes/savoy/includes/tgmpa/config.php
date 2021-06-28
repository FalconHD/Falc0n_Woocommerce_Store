<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Savoy for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */
require_once( NM_DIR . '/tgmpa/class-tgm-plugin-activation.php' );

add_action( 'tgmpa_register', 'nm_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function nm_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
    $plugins = array(

        // Include plugins pre-packaged with the theme
        array(
			'name'     				=> 'Envato Market (theme updates)',
			'slug'     				=> 'envato-market',
			'source'   				=> NM_DIR . '/theme-plugins/envato-market.zip',
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '2.0.6', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '' // If set, overrides default API URL and points to an external URL
		),
        array(
			'name'     				=> 'Savoy Theme - Content Elements',
			'slug'     				=> 'nm-custom-code',
			'source'   				=> NM_DIR . '/theme-plugins/nm-custom-code.zip',
			'required' 				=> false,
			'version' 				=> '1.4.9',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> ''
		),
		array(
			'name'     				=> 'Savoy Theme - Portfolio',
			'slug'     				=> 'nm-portfolio',
			'source'   				=> NM_DIR . '/theme-plugins/nm-portfolio.zip',
			'required' 				=> false,
			'version' 				=> '1.2.8',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> ''
		),
        array(
			'name'     				=> 'Savoy Theme - Settings Panel',
			'slug'     				=> 'nm-theme-settings',
			'source'   				=> NM_DIR . '/theme-plugins/nm-theme-settings.zip',
			'required' 				=> false,
			'version' 				=> '1.0.9',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> ''
		),
		array(
			'name'     				=> 'Savoy Theme - Team Members',
			'slug'     				=> 'nm-post-types',
			'source'   				=> NM_DIR . '/theme-plugins/nm-post-types.zip',
			'required' 				=> false,
			'version' 				=> '1.0.8',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> ''
		),
		array(
			'name'     				=> 'Savoy Theme - Wishlist',
			'slug'     				=> 'nm-wishlist',
			'source'   				=> NM_DIR . '/theme-plugins/nm-wishlist.zip',
			'required' 				=> false,
			'version' 				=> '2.4.2',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> ''
		),
        array(
            'name'     				=> 'Instagram Gallery',
			'slug'     				=> 'nm-instagram',
			'source'   				=> NM_DIR . '/theme-plugins/nm-instagram.zip',
			'required' 				=> false,
			'version' 				=> '1.3.5',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> ''
		),
		
		
		// Include plugins from the WordPress Plugin Repository
		array(
			'name'		=> 'WooCommerce',
			'slug'		=> 'woocommerce',
			'required' 	=> false
		),
		array(
			'name' 		=> 'Contact Form 7',
			'slug' 		=> 'contact-form-7',
			'required' 	=> false
		)
		
    );
	
    
    // Page builder
    $page_builder_selection = get_option( 'nm_page_builder_selection', 'wpbakery' );
    if ( $page_builder_selection == 'elementor' ) {
        $plugins[] = array(
			'name'		=> 'Elementor',
			'slug'		=> 'elementor',
			'required' 	=> false
        );
    } else {
        $plugins[] = array(
            'name'          		=> 'WPBakery Page Builder',
            'slug'          		=> 'js_composer',
            'source'            	=> NM_DIR . '/theme-plugins/js_composer.zip',
            'required'          	=> false,
            'version'           	=> '6.6.0',
            'force_activation'      => false,
            'force_deactivation'    => false,
            'external_url'      	=> ''
        );
    }
    
    
	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'nm-framework-admin',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

		/*
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'nm-framework-admin' ),
			'menu_title'                      => __( 'Install Plugins', 'nm-framework-admin' ),
			/* translators: %s: plugin name. * /
			'installing'                      => __( 'Installing Plugin: %s', 'nm-framework-admin' ),
			/* translators: %s: plugin name. * /
			'updating'                        => __( 'Updating Plugin: %s', 'nm-framework-admin' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'nm-framework-admin' ),
			'notice_can_install_required'     => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'nm-framework-admin'
			),
			'notice_can_install_recommended'  => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'nm-framework-admin'
			),
			'notice_ask_to_update'            => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'nm-framework-admin'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				/* translators: 1: plugin name(s). * /
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'nm-framework-admin'
			),
			'notice_can_activate_required'    => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'nm-framework-admin'
			),
			'notice_can_activate_recommended' => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'nm-framework-admin'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'nm-framework-admin'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'nm-framework-admin'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'nm-framework-admin'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'nm-framework-admin' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'nm-framework-admin' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'nm-framework-admin' ),
			/* translators: 1: plugin name. * /
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'nm-framework-admin' ),
			/* translators: 1: plugin name. * /
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'nm-framework-admin' ),
			/* translators: 1: dashboard link. * /
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'nm-framework-admin' ),
			'dismiss'                         => __( 'Dismiss this notice', 'nm-framework-admin' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'nm-framework-admin' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'nm-framework-admin' ),

			'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
		*/
    );

    tgmpa( $plugins, $config );

}
