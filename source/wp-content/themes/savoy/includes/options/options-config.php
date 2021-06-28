<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
	}

    // This is your option name where all the Redux data is stored.
    $opt_name = 'nm_theme_options';
	

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // NM: Disable tracking
		'disable_tracking' => true,
		// TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
		'menu_title'			=> __( 'Theme Settings', 'nm-framework-admin' ),
		'page_title'			=> __( 'Theme Settings', 'nm-framework-admin' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => false,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => false,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        'forced_dev_mode_off'  => true,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        'footer_credit'     => '&nbsp;',
		// Footer credit text

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.
		'system_info'          => false,
        // REMOVE

        //'compiler'             => true,
		
        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                )
            )
        )
    );
	
    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */
	
	
    /*
     *
     * ---> START SECTIONS
     *
     */
	
	Redux::setSection( $opt_name, array(
		'title'		=> __( 'General', 'nm-framework-admin' ),
		'icon'		=> 'el-icon-cog',
		'fields'	=> array(
            array(
				'id' 		=> 'full_width_layout',
				'type' 		=> 'switch', 
				'title' 	=> __( 'Full Width Layout', 'nm-framework-admin' ),
				'default'	=> 0,
				'on' 		=> 'Enable',
				'off' 		=> 'Disable'
			),
			array(
				'id' 		=> 'page_load_transition',
				'type' 		=> 'switch', 
				'title' 	=> __( 'Page Load Transition', 'nm-framework-admin' ),
				'default'	=> 0,
				'on' 		=> 'Enable',
				'off' 		=> 'Disable'
			),
			array(
				'id' 		=> 'font_awesome',
				'type' 		=> 'switch', 
				'title' 	=> __( 'Font Awesome', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Include Font Awesome icon library.', 'nm-framework-admin' ),
				'default'	=> 0,
				'on' 		=> 'Enable',
				'off' 		=> 'Disable'
			),
            array(
				'id'		=> 'font_awesome_version',
				'type'		=> 'select',
				'title'		=> __( 'Font Awesome - Version', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Select Font Awesome version.', 'nm-framework-admin' ),
				'options'	=> array( 'latest' => 'Latest', '4' => '4.7.0 (Bootstrap CDN)' ),
				'default'	=> 'latest',
                'required'  => array( 'font_awesome', '=', '1' )
			),
            array(
				'id'		=> 'wp_gallery_popup',
				'type'		=> 'switch', 
				'title'		=> __( 'WordPress Gallery Popup', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Modal popup for the default WordPress Gallery.', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id' 		=> 'page_not_found_show_products',
				'type' 		=> 'switch', 
				'title' 	=> __( 'Page Not Found - Featured Products', 'nm-framework-admin' ),
				'default'	=> 0,
				'on' 		=> 'Enable',
				'off' 		=> 'Disable'
			)
		)
	) );

    Redux::setSection( $opt_name, array(
		'title'		=> __( 'Top Bar', 'nm-framework-admin' ),
		'icon'		=> 'el-icon-minus',
		'fields'	=> array(
			array(
				'id' 		=> 'top_bar',
				'type' 		=> 'switch', 
				'title' 	=> __( 'Top Bar', 'nm-framework-admin' ),
				'default'	=> 0,
				'on' 		=> 'Enable',
				'off' 		=> 'Disable'
			),
            array(
				'id'		=> 'top_bar_mobile',
				'type'		=> 'select',
				'title'		=> __( 'Display on Tablet/Mobile', 'nm-framework-admin' ),
				'options'	=> array( 'none' => 'None', 'lc' => 'Left column', 'rc' => 'Right column' ),
				'default'	=> '0'
			),
            array(
				'id'		=> 'top_bar_text',
				'type'		=> 'textarea',
				'title' 	=> __( 'Text', 'nm-framework-admin' ),
				'subtitle'	=> __( 'HTML allowed.', 'nm-framework-admin' ),
                'default'	=> __( 'Welcome to our shop!', 'nm-framework-admin' ),
				'validate'	=> 'html'
			),
			array(
				'id'			=> 'top_bar_left_column_size',
				'type'			=> 'slider',
				'title'			=> __( 'Text Column Size', 'nm-framework-admin' ),
				'subtitle'		=> __( 'Select size-span of Text column.', 'nm-framework-admin' ),
				'default'		=> 6,
				'min'			=> 1,
				'max'			=> 12,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
			array(
				'id'		=> 'top_bar_social_icons',
				'type'		=> 'select',
				'title'		=> __( 'Social Icons', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Display icons from the "Social Profiles" settings tab.', 'nm-framework-admin' ),
				'options'	=> array( '0' => 'None', 'l_c' => 'Display in Text (left) column', 'r_c' => 'Display in Menu (right) column' ),
				'default'	=> '0'
			)
		)
	) );
	
	Redux::setSection( $opt_name, array(
		'title'		=> __( 'Header', 'nm-framework-admin' ),
		'icon'		=> 'el-icon-chevron-up',
		'fields'	=> array(
			array(
				'id' 		=> 'header_layout',
				'type' 		=> 'image_select',
				'title' 	=> __( 'Layout', 'nm-framework-admin' ),
				'options'	=> array(
                    'centered'              => array( 'alt' => 'Centered logo', 'img' => NM_URI . '/assets/img/option-panel/header-centered.png' ),
					'default' 	            => array( 'alt' => 'Default', 'img' => NM_URI . '/assets/img/option-panel/header-default.png' ),
                    'menu-centered'         => array( 'alt' => 'Centered menu', 'img' => NM_URI . '/assets/img/option-panel/header-menu-centered.png' ),
                    'stacked'               => array( 'alt' => 'Stacked', 'img' => NM_URI . '/assets/img/option-panel/header-stacked.png' ),
                    'stacked-logo-centered' => array( 'alt' => 'Stacked logo centered', 'img' => NM_URI . '/assets/img/option-panel/header-stacked-logo-centered.png' ),
                    'stacked-centered'      => array( 'alt' => 'Stacked centered', 'img' => NM_URI . '/assets/img/option-panel/header-stacked-centered.png' )
				),
				'default' 	=> 'centered'
			),
            array(
				'id'		=> 'header_layout_mobile',
				'type'		=> 'select',
				'title' 	=> __( 'Layout - Mobile', 'nm-framework-admin' ),
                'options'	=> array( 'default' => 'Show Cart link', 'alt' => 'Hide Cart link and left-align Logo' ),
				'default'	=> 'default'
			),
			array(
				'id'		=> 'header_fixed',
				'type'		=> 'switch', 
				'title'		=> __( 'Sticky', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Make header "stick" to the top when scrolling.', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array (
				'id'	=> 'header_info_transparency',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Transparency', 'nm-framework-admin' ) . '</h3>',
			),
            array(
				'id'		=> 'header_transparency',
				'type'		=> 'switch', 
				'title' 	=> __( 'Transparency', 'nm-framework-admin' ),
				'subtitle'	=> __( 'To enable transparency for individual pages, use the "Header Transparency" meta-box when editing a page.', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'header_transparency_homepage',
				'type'		=> 'select',
				'title' 	=> __( 'Transparency - Homepage', 'nm-framework-admin' ),
				'options'	=> array( '0' => 'Disable', 'light' => 'Light', 'dark' => 'Dark' ),
				'default'	=> '0',
                'required'  => array( 'header_transparency', '=', '1' )
			),
            array(
				'id'		=> 'header_transparency_shop',
				'type'		=> 'select',
				'title' 	=> __( 'Transparency - Shop', 'nm-framework-admin' ),
				'options'	=> array( '0' => 'Disable', 'light' => 'Light', 'dark' => 'Dark' ),
				'default'	=> '0',
                'required'  => array( 'header_transparency', '=', '1' )
			),
            array(
				'id'		=> 'header_transparency_shop_categories',
				'type'		=> 'select',
				'title' 	=> __( 'Transparency - Shop Categories', 'nm-framework-admin' ),
				'options'	=> array( '0' => 'Disable', 'light' => 'Light', 'dark' => 'Dark' ),
				'default'	=> '0',
                'required'  => array( 'header_transparency', '=', '1' )
			),
            array(
				'id'		=> 'header_transparency_product',
				'type'		=> 'select',
				'title' 	=> __( 'Transparency - Single Product', 'nm-framework-admin' ),
				'options'	=> array( '0' => 'Disable', 'light' => 'Light', 'dark' => 'Dark' ),
				'default'	=> '0',
                'required'  => array( 'header_transparency', '=', '1' )
			),
            array(
				'id'		=> 'header_transparency_blog',
				'type'		=> 'select',
				'title' 	=> __( 'Transparency - Blog', 'nm-framework-admin' ),
				'options'	=> array( '0' => 'Disable', 'light' => 'Light', 'dark' => 'Dark' ),
				'default'	=> '0',
                'required'  => array( 'header_transparency', '=', '1' )
			),
            array(
				'id'		=> 'header_transparency_blog_post',
				'type'		=> 'select',
				'title' 	=> __( 'Transparency - Blog Post', 'nm-framework-admin' ),
				'options'	=> array( '0' => 'Disable', 'light' => 'Light', 'dark' => 'Dark' ),
				'default'	=> '0',
                'required'  => array( 'header_transparency', '=', '1' )
			),
            array (
				'id'	=> 'header_info_spacing',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Spacing', 'nm-framework-admin' ) . '</h3>',
			),
            array(
				'id'			=> 'header_spacing_top',
				'type'			=> 'slider',
				'title'			=> __( 'Top', 'nm-framework-admin' ),
				'default'		=> 17,
				'min'			=> 0,
				'max'			=> 250,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'			=> 'header_spacing_top_alt',
				'type'			=> 'slider',
				'title'			=> __( 'Top - Sticky, Tablet & Mobile', 'nm-framework-admin' ),
				'subtitle'		=> __( 'Top spacing on "Sticky", Tablet and Mobile.', 'nm-framework-admin'),
				'default'		=> 10,
				'min'			=> 0,
				'max'			=> 250,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'			=> 'logo_spacing_bottom',
				'type'			=> 'slider',
				'title'			=> __( 'Logo - Bottom', 'nm-framework-admin' ),
				'subtitle'		=> __( 'Bottom logo spacing.', 'nm-framework-admin'),
				'default'		=> 0,
				'min'			=> 0,
				'max'			=> 250,
				'step'			=> 1,
				'display_value'	=> 'text',
                'required'		=> array( 'header_layout', 'equals', array( 'stacked', 'stacked-logo-centered', 'stacked-centered' ) )
			),
			array(
				'id'			=> 'header_spacing_bottom',
				'type'			=> 'slider',
				'title'			=> __( 'Bottom', 'nm-framework-admin' ),
				'default'		=> 17,
				'min'			=> 0,
				'max'			=> 250,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'			=> 'header_spacing_bottom_alt',
				'type'			=> 'slider',
				'title'			=> __( 'Bottom - Sticky, Tablet & Mobile', 'nm-framework-admin' ),
				'subtitle'		=> __( 'Bottom spacing on "Sticky", Tablet and Mobile.', 'nm-framework-admin'),
				'default'		=> 10,
				'min'			=> 0,
				'max'			=> 250,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array (
				'id'	=> 'header_info_border',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Border', 'nm-framework-admin' ) . '</h3>',
			),
			array(
				'id'		=> 'header_border',
				'type'		=> 'switch', 
				'title'		=> __( 'Border', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
			array(
				'id'		=> 'home_header_border',
				'type'		=> 'switch', 
				'title'		=> __( 'Border - Homepage', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
			array(
				'id'		=> 'shop_header_border',
				'type'		=> 'switch', 
				'title'		=> __( 'Border - Shop', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array (
				'id'	=> 'header_info_logo',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Logo', 'nm-framework-admin' ) . '</h3>',
			),
			array(
				'id'	=> 'logo',
				'type'	=> 'media', 
				'title'	=> __( 'Image', 'nm-framework-admin' )
			),
			array(
				'id'			=> 'logo_height',
				'type'			=> 'slider',
				'title'			=> __( 'Logo Height', 'nm-framework-admin' ),
				'default'		=> 16,
				'min'			=> 10,
				'max'			=> 500,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
			array(
				'id'			=> 'logo_height_tablet',
				'type'			=> 'slider',
				'title'			=> __( 'Logo Height - Tablet', 'nm-framework-admin' ),
				'default'		=> 16,
				'min'			=> 10,
				'max'			=> 500,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
			array(
				'id'			=> 'logo_height_mobile',
				'type'			=> 'slider',
				'title'			=> __( 'Logo Height - Mobile', 'nm-framework-admin' ),
				'default'		=> 16,
				'min'			=> 10,
				'max'			=> 500,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array (
				'id'	=> 'header_info_alt_logo',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Alternative Logo', 'nm-framework-admin' ) . '</h3>',
			),
			array(
				'id'		=> 'alt_logo',
				'type'		=> 'switch', 
				'title' 	=> __( 'Alternative Logo', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'	=> 'alt_logo_image',
				'type'	=> 'media', 
				'title'	=> __( 'Image', 'nm-framework-admin' ),
                'required'	=> array( 'alt_logo', '=', '1' )
			),
			array(
				'id'		=> 'alt_logo_visibility',
				'type'      => 'checkbox',
				'title'		=> __( 'Visibility', 'nm-framework-admin' ),
				'options'	=> array(
                    'alt-logo-home'                         => __( 'Homepage', 'nm-framework-admin' ),
                    'alt-logo-fixed'                        => __( 'Sticky header', 'nm-framework-admin' ),
                    'alt-logo-tablet'                       => __( 'Tablet header', 'nm-framework-admin' ),
                    'alt-logo-mobile'                       => __( 'Mobile header', 'nm-framework-admin' ),
                    'alt-logo-mobile-menu-open'             => __( 'Tablet/Mobile menu open', 'nm-framework-admin' ),
                    'alt-logo-header-transparency-light'    => __( 'Transparent header - Light', 'nm-framework-admin' ),
                    'alt-logo-header-transparency-dark'     => __( 'Transparent header - Dark', 'nm-framework-admin' )
                ),
				'required'  => array( 'alt_logo', '=', '1' )
			),
            array (
				'id'	=> 'header_info_menu',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Menu', 'nm-framework-admin' ) . '</h3>',
			),
			array(
				'id'			=> 'menu_height',
				'type'			=> 'slider',
				'title'			=> __( 'Menu Height', 'nm-framework-admin' ),
				'default'		=> 50,
				'min'			=> 50,
				'max'			=> 500,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'			=> 'menu_height_tablet',
				'type'			=> 'slider',
				'title'			=> __( 'Menu Height - Tablet', 'nm-framework-admin' ),
				'default'		=> 50,
				'min'			=> 50,
				'max'			=> 500,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'			=> 'menu_height_mobile',
				'type'			=> 'slider',
				'title'			=> __( 'Menu Height - Mobile', 'nm-framework-admin' ),
				'default'		=> 50,
				'min'			=> 50,
				'max'			=> 500,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array (
				'id'	=> 'header_info_menu_login',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Menu - Login/My Account', 'nm-framework-admin' ) . '</h3>',
			),
            array(
				'id'		=> 'menu_login',
				'type'		=> 'switch', 
				'title'		=> __( 'Link', 'nm-framework-admin' ),
				'subtitle'		=> __( 'Display link in header menu.', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
			array(
				'id'		=> 'menu_login_popup',
				'type'		=> 'switch', 
				'title'		=> __( 'Popup', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Login/register popup window.', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable',
				'required'	=> array( 'menu_login', '=', '1' )
			),
			array(
				'id'		=> 'menu_login_icon',
				'type'		=> 'switch', 
				'title'		=> __( 'Icon', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Display menu icon (instead of text).', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable',
				'required'	=> array( 'menu_login', '=', '1' )
			),
            array(
				'id'		=> 'menu_login_icon_html',
				'type'		=> 'text',
				'title'		=> __( 'Icon HTML', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Menu icon markup (must be valid HTML).', 'nm-framework-admin' ),
                'description'   => esc_html( 'Default: <i class="nm-myaccount-icon nm-font nm-font-head"></i>' ),
                'default'	=> '<i class="nm-myaccount-icon nm-font nm-font-head"></i>',
                'validate'	=> 'html',
                'required'	=> array( 'menu_login_icon', '=', '1' )
			),
            array (
				'id'	=> 'header_info_menu_cart',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Menu - Cart', 'nm-framework-admin' ) . '</h3>',
			),
			array(
				'id'		=> 'menu_cart',
				'type'		=> 'select',
				'title'		=> __( 'Link', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Configure link in header menu.', 'nm-framework-admin' ),
				'options'	=> array( 'link' => 'Link (static)', '1' => 'Link to Cart Panel', '0' => 'Disable' ),
				'default'	=> '1'
			),
			array(
				'id'		=> 'menu_cart_icon',
				'type'		=> 'switch', 
				'title'		=> __( 'Icon', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Display menu icon (instead of text).', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable',
				'required'	=> array( 'menu_cart', '!=', '0' )
			),
            array(
				'id'		=> 'menu_cart_icon_html',
				'type'		=> 'text',
				'title'		=> __( 'Icon HTML', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Menu icon markup (must be valid HTML).', 'nm-framework-admin' ),
                'description'   => esc_html( 'Default: <i class="nm-menu-cart-icon nm-font nm-font-cart"></i>' ),
                'default'	=> '<i class="nm-menu-cart-icon nm-font nm-font-cart"></i>',
                'validate'	=> 'html',
                'required'	=> array( 'menu_cart_icon', '=', '1' )
			),
            array(
				'id'		=> 'widget_panel_show_on_atc',
				'type'		=> 'switch', 
				'title'		=> __( 'Cart panel - Show on add-to-cart', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable',
                'required'	=> array( 'menu_cart', '=', '1' )
			),
            array(
				'id'		=> 'widget_panel_color',
				'type'		=> 'select',
				'title'		=> __( 'Cart Panel - Color Scheme', 'nm-framework-admin' ),
				'options'	=> array( 'light' => 'Light', 'dark' => 'Dark' ),
				'default'	=> 'dark',
                'required'	=> array( 'menu_cart', '=', '1' )
			),
            array(
				'id'		=> 'cart_panel_quantity_arrows',
				'type'		=> 'switch', 
				'title'		=> __( 'Cart Panel - Quantity Arrows', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable',
				'required'	=> array( 'menu_cart', '=', '1' )
			),
            array (
				'id'	=> 'header_info_megamenu',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Mega Menu: Full Width', 'nm-framework-admin' ) . '</h3>',
			),
            array(
				'id'			=> 'megamenu_full_max_width',
				'type'			=> 'slider',
				'title'			=> __( 'Maximum Width', 'nm-framework-admin' ),
				'subtitle'		=> __( 'Menu content max-width.', 'nm-framework-admin'),
				'default'		=> 1080,
				'min'			=> 1,
				'max'			=> 3000,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'			=> 'megamenu_full_top_spacing',
				'type'			=> 'slider',
				'title'			=> __( 'Top Spacing', 'nm-framework-admin' ),
				'default'		=> 28,
				'min'			=> 0,
				'max'			=> 250,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'			=> 'megamenu_full_bottom_spacing',
				'type'			=> 'slider',
				'title'			=> __( 'Bottom Spacing', 'nm-framework-admin' ),
				'default'		=> 15,
				'min'			=> 0,
				'max'			=> 250,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array (
				'id'	=> 'header_info_menu_mobile',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Menu: Mobile', 'nm-framework-admin' ) . '</h3>',
			),
            array(
				'id'		=> 'menu_mobile_secondary_menu',
				'type'		=> 'switch', 
				'title'		=> __( 'Secondary Menu', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'menu_mobile_social_icons',
				'type'		=> 'switch', 
				'title'		=> __( 'Social Icons', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			)
		)
	) );
	
	Redux::setSection( $opt_name, array(
		'title'		=> __( 'Footer', 'nm-framework-admin' ),
		'icon'		=> 'el-icon-chevron-down',
		'fields'	=> array(
			array(
				'id'		=> 'footer_sticky',
				'type'		=> 'switch', 
				'title'		=> __( 'Align to Bottom', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Always align footer to the page bottom.', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
			array (
				'id'	=> 'footer_widgets_info',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Widgets', 'nm-framework-admin' ) . '</h3>',
			),
			array(
				'id'		=> 'footer_widgets_layout',
				'type'		=> 'select',
				'title'		=> __( 'Layout', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Select a layout for the widgets section.', 'nm-framework-admin' ),
				'options'	=> array( 'boxed' => 'Boxed', 'full' => 'Full', 'full-nopad' => 'Full (no padding)' ),
				'default'	=> 'boxed'
			),
			array(
				'id'		=> 'footer_widgets_border',
				'type'		=> 'switch',
				'title'		=> __( 'Top Border', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
			array(
				'id'			=> 'footer_widgets_columns',
				'type'			=> 'slider',
				'title'			=> __( 'Columns', 'nm-framework-admin' ),
				'subtitle'		=> __( 'Select the number of widget columns to display.', 'nm-framework-admin' ),
				'default'		=> 2,
				'min'			=> 1,
				'max'			=> 4,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'			=> 'footer_widgets_spacing_top',
				'type'			=> 'slider',
				'title'			=> __( 'Spacing - Top', 'nm-framework-admin' ),
				'default'		=> 55,
				'min'			=> 0,
				'max'			=> 250,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'			=> 'footer_widgets_spacing_top_alt',
				'type'			=> 'slider',
				'title'			=> __( 'Spacing - Top: Tablet & Mobile', 'nm-framework-admin' ),
				'default'		=> 55,
				'min'			=> 0,
				'max'			=> 250,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
			array(
				'id'			=> 'footer_widgets_spacing_bottom',
				'type'			=> 'slider',
				'title'			=> __( 'Spacing - Bottom', 'nm-framework-admin' ),
				'default'		=> 15,
				'min'			=> 0,
				'max'			=> 250,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'			=> 'footer_widgets_spacing_bottom_alt',
				'type'			=> 'slider',
				'title'			=> __( 'Spacing - Bottom: Tablet & Mobile', 'nm-framework-admin' ),
				'default'		=> 15,
				'min'			=> 0,
				'max'			=> 250,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
			array (
				'id'	=> 'footer_bar_info',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Bar', 'nm-framework-admin' ) . '</h3>',
			),
            array(
				'id' 		=> 'footer_bar_layout',
				'type' 		=> 'image_select',
				'title' 	=> __( 'Layout', 'nm-framework-admin' ),
				'options'	=> array(
					'default'   => array( 'alt' => 'Default', 'img' => NM_URI . '/assets/img/option-panel/footer-bar-default.png' ),
                    'stacked'   => array( 'alt' => 'Stacked', 'img' => NM_URI . '/assets/img/option-panel/footer-bar-stacked.png' ),
                    'centered'  => array( 'alt' => 'Centered', 'img' => NM_URI . '/assets/img/option-panel/footer-bar-centered.png' )
				),
				'default' 	=> 'default'
			),
			array(
				'id'	=> 'footer_bar_logo',
				'type'	=> 'media', 
				'title'	=> __( 'Logo Image', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Maximum height is 30 pixels.', 'nm-framework-admin' )
			),
			array(
				'id'		=> 'footer_bar_text',
				'type'		=> 'text',
				'title'		=> __( 'Copyright Text', 'nm-framework-admin' ),
				'validate'	=> 'html'
			),
			array(
				'id'		=> 'footer_bar_text_cr_year',
				'type'		=> 'switch', 
				'title'		=> __( 'Copyright Text - Copyright & Year', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Display copyright symbol (©) and year before the copyright text.', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
			array(
				'id'		=> 'footer_bar_content',
				'type'		=> 'select',
				'title'		=> __( 'Right/Bottom Content', 'nm-framework-admin' ),
				'options'	=> array(
                    'social_icons'      => 'Social icons',
                    'copyright_text'    => 'Copyright text',
                    'social_copyright'  => 'Social icons &amp; Copyright text',
                    'custom'            => 'Custom content'
                ),
				'default'	=> 'copyright_text'
			),
            array(
				'id'		=> 'footer_bar_custom_content',
				'type'		=> 'textarea',
				'title'		=> __( 'Custom Content', 'nm-framework-admin' ),
				'subtitle'	=> __( 'HTML allowed.', 'nm-framework-admin' ),
				'validate'	=> 'html',
                'required'	=> array( 'footer_bar_content', '=', 'custom' )
			),
            array(
				'id'			=> 'footer_bar_spacing_top',
				'type'			=> 'slider',
				'title'			=> __( 'Spacing - Top', 'nm-framework-admin' ),
				'default'		=> 30,
				'min'			=> 0,
				'max'			=> 250,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'			=> 'footer_bar_spacing_top_alt',
				'type'			=> 'slider',
				'title'			=> __( 'Spacing - Top: Tablet & Mobile', 'nm-framework-admin' ),
				'default'		=> 30,
				'min'			=> 0,
				'max'			=> 250,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
			array(
				'id'			=> 'footer_bar_spacing_bottom',
				'type'			=> 'slider',
				'title'			=> __( 'Spacing - Bottom', 'nm-framework-admin' ),
				'default'		=> 30,
				'min'			=> 0,
				'max'			=> 250,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'			=> 'footer_bar_spacing_bottom_alt',
				'type'			=> 'slider',
				'title'			=> __( 'Spacing - Bottom: Tablet & Mobile', 'nm-framework-admin' ),
				'default'		=> 30,
				'min'			=> 0,
				'max'			=> 250,
				'step'			=> 1,
				'display_value'	=> 'text'
			)
		)
	) );
	
	Redux::setSection( $opt_name, array(
		'title'		=> __( 'Styling', 'nm-framework-admin' ),
		'icon'		=> 'el-icon-eye-open',
		'fields'	=> array(
            array(
				'id'	=> 'info_typography',
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Typography', 'nm-framework-admin' ) . '</h3>'
			),
			array(
				'id'			=> 'main_font_color',
				'type'			=> 'color',
				'title'			=> __( 'Font Color', 'nm-framework-admin' ),
				'default'		=> '#777777',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'			=> 'font_strong_color',
				'type'			=> 'color',
				'title'			=> __( 'Font Color - Strong Text', 'nm-framework-admin' ),
                'default'		=> '#282828',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'			=> 'font_subtle_color',
				'type'			=> 'color',
				'title'			=> __( 'Font Color - Subtle Text', 'nm-framework-admin' ),
				'default'		=> '#a1a1a1',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'			=> 'highlight_color',
				'type'			=> 'color',
				'title'			=> __( 'Font Color - Highlighted Text', 'nm-framework-admin' ),
				'default'		=> '#dc9814',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'			=> 'heading_1_color',
				'type'			=> 'color',
				'title'			=> __( 'Heading 1 Color', 'nm-framework-admin' ),
				'default'		=> '#282828',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'			=> 'heading_2_color',
				'type'			=> 'color',
				'title'			=> __( 'Heading 2 Color', 'nm-framework-admin' ),
				'default'		=> '#282828',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'			=> 'heading_3_color',
				'type'			=> 'color',
				'title'			=> __( 'Heading 3 Color', 'nm-framework-admin' ),
				'default'		=> '#282828',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'			=> 'heading_456_color',
				'type'			=> 'color',
				'title'			=> __( 'Heading 4, 5 and 6 Color', 'nm-framework-admin' ),
				'default'		=> '#282828',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'	=> 'info_styling_background',
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Background', 'nm-framework-admin' ) . '</h3>'
			),
			array(
				'id'			=> 'main_background_color',
				'type'			=> 'color',
				'title'			=> __( 'Main Background Color', 'nm-framework-admin' ),
				'default'		=> '#ffffff',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'	=> 'main_background_image',
				'type'	=> 'media', 
				'url'	=> true,
				'title'	=> __( 'Background Image', 'nm-framework-admin' )
			),
			array(
				'id'		=> 'main_background_image_type',
				'type'		=> 'select',
				'title'		=> __( 'Background Image - Type', 'nm-framework-admin' ),
				'options'	=> array( 'fixed' => 'Fixed (full)', 'repeat' => 'Repeat (pattern)' ),
				'default'	=> 'fixed'
			),
            
            array(
				'id'	=> 'info_styling_borders_dividers',
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Borders & Dividers', 'nm-framework-admin' ) . '</h3>'
			),
            array(
				'id'			=> 'borders_color',
				'type'			=> 'color',
				'title'			=> __( 'Borders Color', 'nm-framework-admin' ),
				'default'		=> '#eeeeee',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'			=> 'dividers_color',
				'type'			=> 'color',
				'title'			=> __( 'Dividers Color', 'nm-framework-admin' ),
				'default'		=> '#cccccc',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            
			array(
				'id'	=> 'info_styling_top_bar',
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Top Bar', 'nm-framework-admin' ) . '</h3>'
			),
			array(
				'id'			=> 'top_bar_font_color',
				'type'			=> 'color',
				'title'			=> __( 'Font Color', 'nm-framework-admin' ),
				'default'		=> '#eeeeee',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'			=> 'top_bar_background_color',
				'type'			=> 'color',
				'title'			=> __( 'Background Color', 'nm-framework-admin' ),
				'default'		=> '#282828',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'	=> 'info_styling_header',
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Header', 'nm-framework-admin' ) . '</h3>'
			),
			array(
				'id'			=> 'header_navigation_color',
				'type'			=> 'color',
				'title'			=> __( 'Menu: Font Color', 'nm-framework-admin' ),
				'default'		=> '#707070',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'			=> 'header_navigation_highlight_color',
				'type'			=> 'color',
				'title'			=> __( 'Menu: Font Color - "Hover" State', 'nm-framework-admin' ),
				'transparent'	=> false,
				'default'		=> '#282828',
				'validate'		=> 'color'
			),
			array(
				'id'		=> 'header_background_color',
				'type'		=> 'color',
				'title'		=> __( 'Background Color', 'nm-framework-admin' ),
				'default'	=> '#ffffff',
				'validate'	=> 'color'
			),
			array(
				'id'		=> 'header_home_background_color',
				'type'		=> 'color',
				'title'		=> __( 'Background Color - Homepage', 'nm-framework-admin' ),
				'default'	=> '#ffffff',
				'validate'	=> 'color'
			),
			array(
				'id'		=> 'header_float_background_color',
				'type'		=> 'color',
				'title'		=> __( 'Background Color - Sticky', 'nm-framework-admin' ),
				'default'	=> '#ffffff',
				'validate'	=> 'color'
			),
			array(
				'id'			=> 'header_slide_menu_open_background_color',
				'type'			=> 'color',
				'title'			=> __( 'Background Color - Mobile Menu Open', 'nm-framework-admin' ),
				'default'		=> '#ffffff',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'	=> 'info_styling_header_transparency_light',
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Transparent Header: Light', 'nm-framework-admin' ) . '</h3>'
			),
			array(
				'id'			=> 'header_transparency_light_navigation_color',
				'type'			=> 'color',
				'title'			=> __( 'Menu: Font Color', 'nm-framework-admin' ),
				'default'		=> '#ffffff',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'			=> 'header_transparency_light_navigation_highlight_color',
				'type'			=> 'color',
				'title'			=> __( 'Menu: Font Color - "Hover" State', 'nm-framework-admin' ),
				'transparent'	=> false,
				'default'		=> '#dcdcdc',
				'validate'		=> 'color'
			),
            array(
				'id'			=> 'header_transparency_light_hover_background_color',
				'type'			=> 'color',
				'title'			=> __( 'Background Color - "Hover" State', 'nm-framework-admin' ),
				'transparent'	=> true,
				'default'		=> 'transparent',
				'validate'		=> 'color'
			),
            array(
				'id'	=> 'info_styling_header_transparency_dark',
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Transparent Header: Dark', 'nm-framework-admin' ) . '</h3>'
			),
			array(
				'id'			=> 'header_transparency_dark_navigation_color',
				'type'			=> 'color',
				'title'			=> __( 'Menu: Font Color', 'nm-framework-admin' ),
				'default'		=> '#282828',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'			=> 'header_transparency_dark_navigation_highlight_color',
				'type'			=> 'color',
				'title'			=> __( 'Menu: Font Color - "Hover" State', 'nm-framework-admin' ),
				'transparent'	=> false,
				'default'		=> '#707070',
				'validate'		=> 'color'
			),
            array(
				'id'			=> 'header_transparency_dark_hover_background_color',
				'type'			=> 'color',
				'title'			=> __( 'Background Color - "Hover" State', 'nm-framework-admin' ),
				'transparent'	=> true,
				'default'		=> 'transparent',
				'validate'		=> 'color'
			),
			array(
				'id'	=> 'info_styling_dropdown_menu',
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Dropdown Menu', 'nm-framework-admin' ) . '</h3>'
			),
			array(
				'id'			=> 'dropdown_menu_font_color',
				'type'			=> 'color',
				'title'			=> __( 'Font Color', 'nm-framework-admin' ),
				'transparent'	=> false,
				'default'		=> '#a0a0a0',
				'validate'		=> 'color'
			),
			array(
				'id'			=> 'dropdown_menu_font_highlight_color',
				'type'			=> 'color',
				'title'			=> __( 'Font Color - "Hover" State', 'nm-framework-admin' ),
				'transparent'	=> false,
				'default'		=> '#eeeeee',
				'validate'		=> 'color'
			),
			array(
				'id'			=> 'dropdown_menu_background_color',
				'type'			=> 'color',
				'title'			=> __( 'Background Color', 'nm-framework-admin' ),
				'default'		=> '#282828',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'	=> 'info_styling_dropdown_menu_full',
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Dropdown Menu: Full Width', 'nm-framework-admin' ) . '</h3>'
			),
			array(
				'id'			=> 'dropdown_menu_full_font_color',
				'type'			=> 'color',
				'title'			=> __( 'Font Color', 'nm-framework-admin' ),
				'transparent'	=> false,
				'default'		=> '#777777',
				'validate'		=> 'color'
			),
			array(
				'id'			=> 'dropdown_menu_full_font_highlight_color',
				'type'			=> 'color',
				'title'			=> __( 'Font Color - "Hover" State', 'nm-framework-admin' ),
				'transparent'	=> false,
				'default'		=> '#282828',
				'validate'		=> 'color'
			),
			array(
				'id'			=> 'dropdown_menu_full_background_color',
				'type'			=> 'color',
				'title'			=> __( 'Background Color', 'nm-framework-admin' ),
				'default'		=> '#ffffff',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'	=> 'info_styling_dropdown_menu_thumbnails',
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Dropdown Menu: Thumbnails', 'nm-framework-admin' ) . '</h3>'
			),
            array(
				'id'			=> 'dropdown_menu_thumbnails_border_color',
				'type'			=> 'color',
				'title'			=> __( 'Divider Color', 'nm-framework-admin' ),
                'default'		=> '#eeeeee',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'	=> 'info_styling_slide_menu',
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Mobile Menu', 'nm-framework-admin' ) . '</h3>'
			),
            array(
				'id'			=> 'slide_menu_font_color',
				'type'			=> 'color',
				'title'			=> __( 'Font Color', 'nm-framework-admin' ),
                'default'		=> '#555555',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'			=> 'slide_menu_font_highlight_color',
				'type'			=> 'color',
				'title'			=> __( 'Font Color - "Hover" State', 'nm-framework-admin' ),
                'default'		=> '#282828',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'			=> 'slide_menu_border_color',
				'type'			=> 'color',
				'title'			=> __( 'Divider Color', 'nm-framework-admin' ),
                'default'		=> '#eeeeee',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'			=> 'slide_menu_background_color',
				'type'			=> 'color',
				'title'			=> __( 'Background Color', 'nm-framework-admin' ),
                'default'		=> '#ffffff',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'	=> 'info_styling_button',
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Buttons', 'nm-framework-admin' ) . '</h3>'
			),
			array(
				'id'			=> 'button_font_color',
				'type'			=> 'color',
				'title'			=> __( 'Font Color', 'nm-framework-admin' ),
				'default'		=> '#ffffff',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'			=> 'button_background_color',
				'type'			=> 'color',
				'title'			=> __( 'Background Color', 'nm-framework-admin' ),
				'default'		=> '#282828',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'	=> 'info_styling_button_border',
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Buttons - Border', 'nm-framework-admin' ) . '</h3>'
			),
			array(
				'id'			=> 'button_border_font_color',
				'type'			=> 'color',
				'title'			=> __( 'Font Color', 'nm-framework-admin' ),
				'default'		=> '#282828',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'			=> 'button_border_color',
				'type'			=> 'color',
				'title'			=> __( 'Border Color', 'nm-framework-admin' ),
				'default'		=> '#aaaaaa',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'			=> 'button_border_hover_color',
				'type'			=> 'color',
				'title'			=> __( 'Border Color - "Hover" State', 'nm-framework-admin' ),
				'default'		=> '#282828',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'	=> 'info_styling_footer_widgets',
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Footer Widgets', 'nm-framework-admin' ) . '</h3>'
			),
			array(
				'id'			=> 'footer_widgets_font_color',
				'type'			=> 'color',
				'title'			=> __( 'Font Color', 'nm-framework-admin' ),
				'default'		=> '#777777',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'			=> 'footer_widgets_title_font_color',
				'type'			=> 'color',
				'title'			=> __( 'Font Color - Titles', 'nm-framework-admin' ),
				'default'		=> '#282828',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'			=> 'footer_widgets_highlight_font_color',
				'type'			=> 'color',
				'title'			=> __( 'Font Color - "Hover" State', 'nm-framework-admin' ),
				'default'		=> '#dc9814',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'			=> 'footer_widgets_background_color',
				'type'			=> 'color',
				'title'			=> __( 'Background Color', 'nm-framework-admin' ),
				'default'		=> '#ffffff',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'	=> 'info_styling_footer_bar',
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Footer Bar', 'nm-framework-admin' ) . '</h3>'
			),
			array(
				'id'			=> 'footer_bar_font_color',
				'type'			=> 'color',
				'title'			=> __( 'Font Color', 'nm-framework-admin' ),
				'default'		=> '#aaaaaa',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'			=> 'footer_bar_highlight_font_color',
				'type'			=> 'color',
				'title'			=> __( 'Font Color - "Hover" State', 'nm-framework-admin' ),
				'default'		=> '#eeeeee',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'			=> 'footer_bar_menu_border_color',
				'type'			=> 'color',
				'title'			=> __( 'Divider Color (Mobile)', 'nm-framework-admin' ),
				'default'		=> '#3a3a3a',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'			=> 'footer_bar_background_color',
				'type'			=> 'color',
				'title'			=> __( 'Background Color', 'nm-framework-admin' ),
				'default'		=> '#282828',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'	=> 'info_styling_single_post',
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Blog - Single Post', 'nm-framework-admin' ) . '</h3>'
			),
            array(
				'id'			=> 'single_post_comments_background_color',
				'type'			=> 'color',
				'title'			=> __( 'Comments - Background Color', 'nm-framework-admin' ),
				'default'		=> '#f7f7f7',
                'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'			=> 'single_post_comments_dividers_color',
				'type'			=> 'color',
				'title'			=> __( 'Comments - Dividers Color', 'nm-framework-admin' ),
				'default'		=> '#e7e7e7',
                'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'	=> 'info_styling_shop',
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Shop', 'nm-framework-admin' ) . '</h3>'
			),
            array(
				'id'			=> 'shop_thumbnail_background_color',
				'type'			=> 'color',
				'title'			=> __( 'Thumbnail - Background Color', 'nm-framework-admin' ),
				'default'		=> '#eeeeee',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'			=> 'shop_taxonomy_header_heading_color',
				'type'			=> 'color',
				'title'			=> __( 'Category Banner - Heading Color', 'nm-framework-admin' ),				
				'default'		=> '#282828',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'			=> 'shop_taxonomy_header_description_color',
				'type'			=> 'color',
				'title'			=> __( 'Category Banner - Description Color', 'nm-framework-admin' ),
				'default'		=> '#777777',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'			=> 'sale_flash_font_color',
				'type'			=> 'color',
				'title'			=> __( 'Sale Badge - Font Color', 'nm-framework-admin' ),
				'default'		=> '#282828',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'			=> 'sale_flash_background_color',
				'type'			=> 'color',
				'title'			=> __( 'Sale Badge - Background Color', 'nm-framework-admin' ),
				'default'		=> '#ffffff',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'			=> 'outofstock_flash_font_color',
				'type'			=> 'color',
				'title'			=> __( 'Out-of-Stock Badge - Font Color', 'nm-framework-admin' ),
				'default'		=> '#282828',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'			=> 'outofstock_flash_background_color',
				'type'			=> 'color',
				'title'			=> __( 'Out-of-Stock Badge - Background Color', 'nm-framework-admin' ),
				'default'		=> '#ffffff',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'			=> 'shop_background_color',
				'type'			=> 'color',
				'title'			=> __( 'Background Color', 'nm-framework-admin' ),
				'default'		=> '#ffffff',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'	=> 'info_styling_shop_single_product',
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Single Product', 'nm-framework-admin' ) . '</h3>'
			),
			array(
				'id'			=> 'featured_video_icon_color',
				'type'			=> 'color',
				'title'			=> __( 'Featured Video Icon - Font Color', 'nm-framework-admin' ),
				'default'		=> '#282828',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
			array(
				'id'			=> 'featured_video_background_color',
				'type'			=> 'color',
				'title'			=> __( 'Featured Video Icon - Background Color', 'nm-framework-admin' ),
				'default'		=> '#ffffff',
				'transparent'	=> false,
				'validate'		=> 'color'
			),
            array(
				'id'			=> 'single_product_background_color',
				'type'			=> 'color',
				'title'			=> __( 'Background Color', 'nm-framework-admin' ),
				'default'		=> '#eeeeee',
                'transparent'	=> true,
				'validate'		=> 'color'
			)
		)
	) );

	Redux::setSection( $opt_name, array(
		'title'		=> __( 'Typography', 'nm-framework-admin' ),
		'icon'		=> 'el-icon-font',
		'fields'	=> array(
            // Font
			array (
				'id'	=> 'main_font_info',
				'type'	=> 'info',
				'icon'	=> true,
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Font', 'nm-framework-admin' ) . '</h3>',
			),
			array(
				'id'		=> 'main_font_source',
				'type'		=> 'radio',
				'title'		=> __( 'Font Source', 'nm-framework-admin' ),
				'options'	=> array(
					'1'	=> 'Standard + Google Webfonts', 
					'2'	=> 'Adobe Fonts',
                    '3'	=> 'Custom CSS'
				),
				'default'	=> '1'
			),
			array (
				'id'			=> 'main_font',
				'type'			=> 'typography',
				'title'			=> __( 'Font Face', 'nm-framework-admin' ),
				'line-height'	=> false,
				'text-align'	=> false,
				'font-style'	=> false,
				'font-weight'	=> false,
				'font-size'		=> false,
				'color'			=> false,
				'all_styles'    => true, // Note: Don't disable - Used to generate font-weight(s) based on theme-settings in: "../plugins/nm-theme-settings/includes/options/ReduxCore/inc/fields/typography/field_typography.php" (see "makeGoogleWebfontLink()" function)
                'default'		=> array (
					'font-family'	=> 'Roboto',
					'subsets'		=> '',
				),
				'required'		=> array( 'main_font_source', '=', '1' )
			),
			array(
				'id'		=> 'main_font_adobefonts_project_id',
				'type'		=> 'text',
				'title'		=> __( 'Adobe Fonts - Project ID', 'nm-framework-admin' ),
				'desc'	    => __( 'Enter the ID for your Web Project', 'nm-framework-admin' ),
				'default'	=> '',
				'required'	=> array( 'main_font_source', '=', '2' )
			),
			array (
				'id'		=> 'main_adobefonts_font',
				'type'		=> 'text',
				'title'		=> __( 'Adobe Fonts - Font', 'nm-framework-admin' ),
				'desc'	    => __( 'CSS font name i.e: futura-pt', 'nm-framework-admin' ),
				'default'	=> '',
				'required'	=> array( 'main_font_source', '=', '2' )
			),
			array(
				'id'		=> 'main_font_custom_css',
				'type'		=> 'ace_editor',
				'title' 	=> __( 'Custom CSS', 'nm-framework-admin' ),
				'subtitle' 		=> __( 'Example: body { font-family: "Proxima Nova Regular", sans-serif; }', 'nm-framework-admin' ),
				'mode'		=> 'css',
				'theme'		=> 'chrome',
				'default'	=> '',
				'required'	=> array( 'main_font_source', '=', '3' )
			),
            // Font - Header menus
			array (
				'id'	=> 'header_font_info',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Font - Header Menus', 'nm-framework-admin' ) . '</h3>',
			),
			array(
				'id'		=> 'header_font_source',
				'type'		=> 'radio',
				'title'		=> __('Font Source', 'nm-framework-admin'),
				'options'	=> array(
					'0' => '(none)',
					'1'	=> 'Standard + Google Webfonts', 
					'2'	=> 'Adobe Fonts'
				),
				'default'	=> '0'
			),
			array (
				'id'			=> 'header_font',
				'type'			=> 'typography',
				'title'			=> __( 'Font Face', 'nm-framework-admin' ),
				'line-height'	=> false,
				'text-align'	=> false,
				'font-style'	=> false,
				'font-weight'	=> false,
				'font-size'		=> false,
				'color'			=> false,
                'all_styles'    => true,
                'default'		=> array (
					'font-family'	=> 'Roboto',
					'subsets'		=> '',
				),
				'required'		=> array( 'header_font_source', '=', '1' )
			),
			array(
				'id'		=> 'header_font_adobefonts_project_id',
				'type'		=> 'text',
				'title'		=> __( 'Adobe Fonts - Project ID', 'nm-framework-admin' ), 
				'desc'	    => __( 'Enter the ID for your Web Project', 'nm-framework-admin' ),
				'default'	=> '',
				'required'	=> array( 'header_font_source', '=', '2' )
			),
			array (
				'id'		=> 'header_adobefonts_font',
				'type'		=> 'text',
				'title'		=> __( 'Adobe Fonts - Font', 'nm-framework-admin' ),
				'desc'	    => __( 'CSS font name i.e: futura-pt', 'nm-framework-admin' ),
				'default'	=> '',
				'required'	=> array( 'header_font_source', '=', '2' )
			),
			// Font - Headings
			array (
				'id'	=> 'secondary_font_info',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Font - Headings', 'nm-framework-admin' ) . '</h3>',
			),
			array(
				'id'		=> 'secondary_font_source',
				'type'		=> 'radio',
				'title'		=> __('Font Source', 'nm-framework-admin'),
				'options'	=> array(
					'0' => '(none)',
					'1'	=> 'Standard + Google Webfonts', 
					'2'	=> 'Adobe Fonts'
				),
				'default'	=> '0'
			),
			array (
				'id'			=> 'secondary_font',
				'type'			=> 'typography',
				'title'			=> __( 'Font Face', 'nm-framework-admin' ),
				'line-height'	=> false,
				'text-align'	=> false,
				'font-style'	=> false,
				'font-weight'	=> false,
				'font-size'		=> false,
				'color'			=> false,
                'all_styles'    => true,
                'default'		=> array (
					'font-family'	=> 'Roboto',
					'subsets'		=> '',
				),
				'required'		=> array( 'secondary_font_source', '=', '1' )
			),
			array(
				'id'		=> 'secondary_font_adobefonts_project_id',
				'type'		=> 'text',
				'title'		=> __( 'Adobe Fonts - Project ID', 'nm-framework-admin' ), 
				'desc'	    => __( 'Enter the ID for your Web Project', 'nm-framework-admin' ),
				'default'	=> '',
				'required'	=> array( 'secondary_font_source', '=', '2' )
			),
			array (
				'id'		=> 'secondary_adobefonts_font',
				'type'		=> 'text',
				'title'		=> __( 'Adobe Fonts - Font', 'nm-framework-admin' ),
				'desc'	    => __( 'CSS font name i.e: futura-pt', 'nm-framework-admin' ),
				'default'	=> '',
				'required'	=> array( 'secondary_font_source', '=', '2' )
			),
            // Font sizes
            array (
				'id'	=> 'font_sizes_info',
				'type'	=> 'info',
				'icon'	=> true,
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Font Sizes', 'nm-framework-admin' ) . '</h3>',
			),
            array(
				'id'			=> 'font_size_header_menu',
				'type'			=> 'slider',
				'title'			=> __( 'Header Menu', 'nm-framework-admin' ),
				'default'		=> 16,
				'min'			=> 12,
				'max'			=> 20,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'			=> 'font_size_mobile_menu',
				'type'			=> 'slider',
				'title'			=> __( 'Mobile Menu', 'nm-framework-admin' ),
				'default'		=> 15,
				'min'			=> 10,
				'max'			=> 20,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'			=> 'font_size_mobile_menu_secondary',
				'type'			=> 'slider',
				'title'			=> __( 'Mobile Menu - Secondary', 'nm-framework-admin' ),
				'default'		=> 13,
				'min'			=> 10,
				'max'			=> 20,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'			=> 'font_size_large',
				'type'			=> 'slider',
				'title'			=> __( 'Body Text - Large', 'nm-framework-admin' ),
				'default'		=> 18,
				'min'			=> 14,
				'max'			=> 24,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'			=> 'font_size_medium',
				'type'			=> 'slider',
				'title'			=> __( 'Body Text - Medium', 'nm-framework-admin' ),
				'default'		=> 16,
				'min'			=> 12,
				'max'			=> 20,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'			=> 'font_size_small',
				'type'			=> 'slider',
				'title'			=> __( 'Body Text - Small', 'nm-framework-admin' ),
				'default'		=> 14,
				'min'			=> 8,
				'max'			=> 16,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'			=> 'font_size_xsmall',
				'type'			=> 'slider',
				'title'			=> __( 'Body Text - Extra Small', 'nm-framework-admin' ),
				'default'		=> 12,
				'min'			=> 6,
				'max'			=> 14,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            // Font weight
            array (
				'id'	=> 'font_weight_info',
				'type'	=> 'info',
				'icon'	=> true,
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Font Weight', 'nm-framework-admin' ) . '</h3>',
			),
            array(
				'id'		=> 'font_weight_header_menu',
				'type'		=> 'select',
				'title'		=> __( 'Header Menu', 'nm-framework-admin' ),
				'options'	=> array(
                    'normal' => 'Normal',
                    'bold' => 'Bold',
                    'bolder' => 'Bolder',
                    'inherit' => 'Inherit',
                    'lighter' => 'Lighter',
                    '100' => '100',
                    '200' => '200',
                    '300' => '300',
                    '400' => '400',
                    '500' => '500',
                    '600' => '600',
                    '700' => '700',
                    '800' => '800',
                    '900' => '900'
                ),
				'default'	=> 'normal'
			),
            array(
				'id'		=> 'font_weight_mobile_menu',
				'type'		=> 'select',
				'title'		=> __( 'Mobile Menu', 'nm-framework-admin' ),
				'options'	=> array(
                    'normal' => 'Normal',
                    'bold' => 'Bold',
                    'bolder' => 'Bolder',
                    'inherit' => 'Inherit',
                    'lighter' => 'Lighter',
                    '100' => '100',
                    '200' => '200',
                    '300' => '300',
                    '400' => '400',
                    '500' => '500',
                    '600' => '600',
                    '700' => '700',
                    '800' => '800',
                    '900' => '900'
                ),
				'default'	=> 'normal'
			),
            array(
				'id'		=> 'font_weight_body',
				'type'		=> 'select',
				'title'		=> __( 'Body Text', 'nm-framework-admin' ),
				'options'	=> array(
                    'normal' => 'Normal',
                    'bold' => 'Bold',
                    'bolder' => 'Bolder',
                    'inherit' => 'Inherit',
                    'lighter' => 'Lighter',
                    '100' => '100',
                    '200' => '200',
                    '300' => '300',
                    '400' => '400',
                    '500' => '500',
                    '600' => '600',
                    '700' => '700',
                    '800' => '800',
                    '900' => '900'
                ),
				'default'	=> 'normal'
			),
            array(
				'id'		=> 'font_weight_h1',
				'type'		=> 'select',
				'title'		=> __( 'Heading 1 (h1)', 'nm-framework-admin' ),
				'options'	=> array(
                    'normal' => 'Normal',
                    'bold' => 'Bold',
                    'bolder' => 'Bolder',
                    'inherit' => 'Inherit',
                    'lighter' => 'Lighter',
                    '100' => '100',
                    '200' => '200',
                    '300' => '300',
                    '400' => '400',
                    '500' => '500',
                    '600' => '600',
                    '700' => '700',
                    '800' => '800',
                    '900' => '900'
                ),
				'default'	=> 'normal'
			),
            array(
				'id'		=> 'font_weight_h2',
				'type'		=> 'select',
				'title'		=> __( 'Heading 2 (h2)', 'nm-framework-admin' ),
				'options'	=> array(
                    'normal' => 'Normal',
                    'bold' => 'Bold',
                    'bolder' => 'Bolder',
                    'inherit' => 'Inherit',
                    'lighter' => 'Lighter',
                    '100' => '100',
                    '200' => '200',
                    '300' => '300',
                    '400' => '400',
                    '500' => '500',
                    '600' => '600',
                    '700' => '700',
                    '800' => '800',
                    '900' => '900'
                ),
				'default'	=> 'normal'
			),
            array(
				'id'		=> 'font_weight_h3',
				'type'		=> 'select',
				'title'		=> __( 'Heading 3 (h3)', 'nm-framework-admin' ),
				'options'	=> array(
                    'normal' => 'Normal',
                    'bold' => 'Bold',
                    'bolder' => 'Bolder',
                    'inherit' => 'Inherit',
                    'lighter' => 'Lighter',
                    '100' => '100',
                    '200' => '200',
                    '300' => '300',
                    '400' => '400',
                    '500' => '500',
                    '600' => '600',
                    '700' => '700',
                    '800' => '800',
                    '900' => '900'
                ),
				'default'	=> 'normal'
			),
            array(
				'id'		=> 'font_weight_h456',
				'type'		=> 'select',
				'title'		=> __( 'Heading 4, 5 and 6 (h4, h5, h6)', 'nm-framework-admin' ),
				'options'	=> array(
                    'normal' => 'Normal',
                    'bold' => 'Bold',
                    'bolder' => 'Bolder',
                    'inherit' => 'Inherit',
                    'lighter' => 'Lighter',
                    '100' => '100',
                    '200' => '200',
                    '300' => '300',
                    '400' => '400',
                    '500' => '500',
                    '600' => '600',
                    '700' => '700',
                    '800' => '800',
                    '900' => '900'
                ),
				'default'	=> 'normal'
			),
            // Letter Spacing
            array (
				'id'	=> 'letter_spacing_info',
				'type'	=> 'info',
				'icon'	=> true,
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Letter Spacing', 'nm-framework-admin' ) . '</h3>',
			),
            array(
                'id'        => 'letter_spacing_header_menu',
                'type'      => 'text',
                'title'	    => __( 'Header Menu', 'nm-framework-admin' ),
                //'desc'	    => __( 'Value is in pixels (px)', 'nm-framework-admin' ),
                'validate'  => 'numeric'
            ),
            array(
                'id'        => 'letter_spacing_mobile_menu',
                'type'      => 'text',
                'title'	    => __( 'Mobile Menu', 'nm-framework-admin' ),
                'validate'  => 'numeric'
            ),
            array(
                'id'        => 'letter_spacing_body',
                'type'      => 'text',
                'title'	    => __( 'Body Text', 'nm-framework-admin' ),
                'validate'  => 'numeric'
            ),
            array(
                'id'        => 'letter_spacing_h1',
                'type'      => 'text',
                'title'	    => __( 'Heading 1 (h1)', 'nm-framework-admin' ),
                'validate'  => 'numeric'
            ),
            array(
                'id'        => 'letter_spacing_h2',
                'type'      => 'text',
                'title'	    => __( 'Heading 2 (h2)', 'nm-framework-admin' ),
                'validate'  => 'numeric'
            ),
            array(
                'id'        => 'letter_spacing_h3',
                'type'      => 'text',
                'title'	    => __( 'Heading 3 (h3)', 'nm-framework-admin' ),
                'validate'  => 'numeric'
            ),
            array(
                'id'        => 'letter_spacing_h456',
                'type'      => 'text',
                'title'	    => __( 'Heading 4, 5 and 6 (h4, h5, h6)', 'nm-framework-admin' ),
                'validate'  => 'numeric'
            )
		)
	) );
	
	Redux::setSection( $opt_name, array(
		'title'		=> __( 'Shop', 'nm-framework-admin' ),
		'icon'		=> 'el-icon-shopping-cart',
		'fields'	=> array(
            array(
				'id'		=> 'shop_content_home',
				'type'		=> 'switch',
				'title'		=> __( 'Page Content', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Display page content above WooCommerce shop-catalog.', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'shop_page_id',
				'type'		=> 'select',
				'title'		=> __( 'Page', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Select page to display above WooCommerce shop-catalog', 'nm-framework-admin' ),
				'data'		=> 'pages',
				//'default'	=> 757, // Don't set default page here to avoid changing shop content (set in theme setup if needed instead)
                'required'	=> array( 'shop_content_home', '=', '1' )
			),
            array(
				'id'		=> 'shop_catalog_mode',
				'type'		=> 'switch',
				'title'		=> __( 'Catalog Mode', 'nm-framework-admin' ),
                'subtitle'	=> __( 'Hide prices, add-to-cart buttons etc. from the shop.', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            
			array(
				'id' 	=> 'shop_category_info',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Category', 'nm-framework-admin' ) . '</h3>'
			),
            array(
				'id'		=> 'shop_content_taxonomy',
				'type'		=> 'select',
				'title'		=> __( 'Page Content', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Select content to display on category pages.', 'nm-framework-admin' ),
				'options'	=> array(
                    '0'                 => 'Disable',
                    'taxonomy_header'   => 'Category Banner',
                    'taxonomy_heading'  => 'Category Heading',
                    'shop_page'         => 'Default WooCommerce shop-catalog page (selected above)'
                ),
				'default'	=> 'shop_page'
			),
			array(
				'id'		=> 'shop_category_description',
				'type'		=> 'switch',
				'title'		=> __( 'Description', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Display category description.', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable',
                'required'	=> array( 'shop_content_taxonomy', '!=', 'taxonomy_header' )
			),
            array(
                'id'		=> 'shop_default_description',
                'type'		=> 'textarea',
                'title'		=> __( 'Description - Default', 'nm-framework-admin' ),
                'subtitle'	=> __( 'Alternative description when no category is selected.', 'nm-framework-admin' ),
                'rows'      => 4,
                'validate'	=> 'html',
                'required'	=> array( 'shop_category_description', '=', '1' )
            ),
            array(
				'id'		=> 'shop_description_layout',
				'type'		=> 'select',
				'title'		=> __( 'Description - Layout', 'nm-framework-admin' ),
				'options'	=> array( 'clean' => 'Text only', 'borders' => 'Text with borders' ),
				'default'	=> 'clean',
                'required'	=> array( 'shop_category_description', '=', '1' )
			),
            array(
				'id'		=> 'shop_description_position',
				'type'		=> 'select',
				'title'		=> __( 'Description - Position', 'nm-framework-admin' ),
				'options'	=> array( 'top' => 'Above Products', 'bottom' => 'Below Products' ),
				'default'	=> 'top',
                'required'	=> array( 'shop_category_description', '=', '1' )
			),
            array (
				'id' 	=> 'shop_category_banner_info',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Category Banner', 'nm-framework-admin' ) . '</h3>',
                'required'	=> array( 'shop_content_taxonomy', '=', 'taxonomy_header' )
			),
            array(
				'id'		=> 'shop_taxonomy_header_text_alignment',
				'type'		=> 'select',
				'title'		=> __( 'Text - Alignment', 'nm-framework-admin' ),
				'options'	=> array( 'left' => 'Left', 'center' => 'Center', 'right' => 'Right' ),
				'default'	=> 'center',
                'required'	=> array( 'shop_content_taxonomy', '=', 'taxonomy_header' )
			),
            array(
                'id'		=> 'shop_taxonomy_header_text_max_width',
                'type' 		=> 'text',
                'title' 	=> __( 'Text - Maximum Width', 'nm-framework-admin' ),
                'validate'	=> 'numeric',
                'default'	=> '',
                'required'	=> array( 'shop_content_taxonomy', '=', 'taxonomy_header' )
            ),
            array(
				'id'			=> 'shop_taxonomy_header_image_height',
				'type'			=> 'slider',
				'title'			=> __( 'Image Height', 'nm-framework-admin' ),
				'default'		=> 370,
				'min'			=> 1,
				'max'			=> 1000,
				'step'			=> 1,
				'display_value'	=> 'text',
                'required'	=> array( 'shop_content_taxonomy', '=', 'taxonomy_header' )
			),
            array(
				'id'			=> 'shop_taxonomy_header_image_height_tablet',
				'type'			=> 'slider',
				'title'			=> __( 'Image Height - Tablet', 'nm-framework-admin' ),
				'default'		=> 370,
				'min'			=> 1,
				'max'			=> 1000,
				'step'			=> 1,
				'display_value'	=> 'text',
                'required'	=> array( 'shop_content_taxonomy', '=', 'taxonomy_header' )
			),
            array(
				'id'			=> 'shop_taxonomy_header_image_height_mobile',
				'type'			=> 'slider',
				'title'			=> __( 'Image Height - Mobile', 'nm-framework-admin' ),
				'default'		=> 210,
				'min'			=> 1,
				'max'			=> 1000,
				'step'			=> 1,
				'display_value'	=> 'text',
                'required'	=> array( 'shop_content_taxonomy', '=', 'taxonomy_header' )
			),
			array (
				'id' 	=> 'shop_catalog_info',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Catalog', 'nm-framework-admin' ) . '</h3>',
			),
            array(
				'id' 		=> 'shop_grid',
				'type' 		=> 'image_select',
				'title' 	=> __( 'Grid', 'nm-framework-admin' ),
				'options'	=> array(
                    'default'   => array( 'title' => 'Standard<br>(1-6 columns)', 'img' => NM_URI . '/assets/img/option-panel/shop-grid-default.png' ),
                    'scattered'   => array( 'title' => 'Scattered<br>(2 columns)', 'img' => NM_URI . '/assets/img/option-panel/shop-grid-scattered.png' ),
                    'grid-6n-1-5' => array( 'title' => 'Variable<br>(2 columns)', 'img' => NM_URI . '/assets/img/option-panel/shop-grid-6n-1-5.png' ),
					'grid-10n-1-7' => array( 'title' => 'Variable<br>(3 columns)', 'img' => NM_URI . '/assets/img/option-panel/shop-grid-10n-1-7.png' )
				),
				'default' 	=> 'default'
			),
			array(
				'id'			=> 'shop_columns',
				'type'			=> 'slider',
				'title'			=> __( 'Columns', 'nm-framework-admin' ),
				'default'		=> 4,
				'min'			=> 1,
				'max'			=> 8,
				'step'			=> 1,
				'display_value'	=> 'text',
                'required'	    => array( 'shop_grid', '=', 'default' )
			),
			array(
				'id'			=> 'shop_columns_mobile',
				'type'			=> 'slider',
				'title'			=> __( 'Columns - Mobile', 'nm-framework-admin' ),
				'default'		=> 1,
				'min'			=> 1,
				'max'			=> 2,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
			array(
				'id'			=> 'products_per_page',
				'type'			=> 'slider',
				'title'			=> __( 'Products per Page', 'nm-framework-admin' ),
				'default'		=> 16,
				'min'			=> 1,
				'max'			=> 48,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'		=> 'shop_infinite_load',
				'type'		=> 'select',
				'title'		=> __( 'Infinite Load', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Configure "infinite" product loading.', 'nm-framework-admin' ),
				'options'	=> array( '0' => 'Disable', 'button' => 'Button', 'scroll' => 'Scroll' ),
				'default'	=> 'button'
			),
            array (
				'id' 	=> 'shop_catalog_auto_scroll_info',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Catalog - Auto Scroll', 'nm-framework-admin' ) . '</h3>',
			),
            array(
				'id'			=> 'shop_scroll_offset',
				'type'			=> 'slider',
				'title'			=> __( 'Scroll Offset', 'nm-framework-admin' ),
				'subtitle'		=> __( "Used to offset the shop's scroll position (when a category link is clicked for example).", 'nm-framework-admin' ),
				'default'		=> 70,
				'min'			=> 0,
				'max'			=> 1000,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'			=> 'shop_scroll_offset_tablet',
				'type'			=> 'slider',
				'title'			=> __( 'Scroll Offset - Tablet', 'nm-framework-admin' ),
				'default'		=> 70,
				'min'			=> 0,
				'max'			=> 1000,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'			=> 'shop_scroll_offset_mobile',
				'type'			=> 'slider',
				'title'			=> __( 'Scroll Offset - Mobile', 'nm-framework-admin' ),
				'default'		=> 70,
				'min'			=> 0,
				'max'			=> 1000,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array (
				'id' 	=> 'products_info',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Products', 'nm-framework-admin' ) . '</h3>',
			),
            array(
				'id' 		=> 'products_layout',
				'type' 		=> 'image_select',
				'title' 	=> __( 'Layout', 'nm-framework-admin' ),
				'options'	=> array(
                    'default'   => array( 'title' => 'Standard<br>&nbsp;', 'img' => NM_URI . '/assets/img/option-panel/products-layout-default.png' ),
                    'centered' => array( 'title' => 'Centered<br>&nbsp;', 'img' => NM_URI . '/assets/img/option-panel/products-layout-centered.png' ),
					'static-buttons' => array( 'title' => 'Static Buttons<br>&nbsp;', 'img' => NM_URI . '/assets/img/option-panel/products-layout-static-buttons.png' ),
                    'static-buttons-on-touch' => array( 'title' => 'Static Buttons<br>(on Mobile)', 'img' => NM_URI . '/assets/img/option-panel/products-layout-static-buttons-on-touch.png' ),     
                    'overlay' => array( 'title' => 'Overlay<br>&nbsp;', 'img' => NM_URI . '/assets/img/option-panel/products-layout-overlay.png' )
				),
				'default' 	=> 'default'
			),
			array(
				'id'		=> 'product_sale_flash',
				'type'		=> 'select',
				'title'		=> __( 'Sale Flash', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Product sale flash badges.', 'nm-framework-admin' ),
				'options'	=> array( '0' => 'Disable', 'txt' => 'Display sale Text', 'pct' => 'Display sale Percentage' ),
				'default'	=> 'pct'
			),
			array(
				'id'		=> 'product_image_lazy_loading',
				'type'		=> 'switch',
				'title'		=> __( 'Image Lazy Loading', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Lazy load product-images.', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'	=> 'product_placeholder_image',
				'type'	=> 'media', 
				'title'	=> __( 'Image Lazy Loading - Placeholder', 'nm-framework-admin' ),
                'subtitle'	=> __( 'Display a custom placeholder image while lazy-loading.', 'nm-framework-admin' ),
                'required'	=> array( 'product_image_lazy_loading', '=', '1' )
			),
			array(
				'id'		=> 'product_hover_image_global',
				'type'		=> 'switch',
				'title'		=> __( 'Hover Image', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Display the second gallery image when a product is "hovered".', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'product_display_attributes',
				'type'		=> 'switch',
				'title'		=> __( 'Color/Image Swatches', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Display color/image swatches for variable-product attributes.', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'product_rating',
				'type'		=> 'switch',
				'title'		=> __( 'Rating', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Display star-rating below product title.', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'product_action_link',
				'type'		=> 'switch',
				'title'		=> __( 'Action Link', 'nm-framework-admin' ),
                'subtitle'	=> __( 'Show product action link (e.g. "Add to cart") ', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
			array (
				'id' 	=> 'product_quickview_info',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Quick View', 'nm-framework-admin' ) . '</h3>',
			),
			array(
				'id'		=> 'product_quickview',
				'type'		=> 'switch',
				'title'		=> __( 'Quick View', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'product_quickview_link',
				'type'		=> 'switch',
				'title'		=> __( 'Link', 'nm-framework-admin' ),
                'subtitle'	=> __( 'Show Quick View link (e.g. "Show more")', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'product_quickview_link_actions',
				'type'      => 'checkbox',
				'title'		=> __( 'Link Actions', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Open Quick View when clicking...', 'nm-framework-admin' ),
                'options'	=> array(
                    'thumb' => __( 'Thumbnail', 'nm-framework-admin' ),
                    'title' => __( 'Title', 'nm-framework-admin' ),
                    'link'  => __( 'Link (e.g. "Show more")', 'nm-framework-admin' )
                ),
                'default' => array(
                    'thumb' => '0',
                    'title' => '0',
                    'link'  => '1'
                ),
				'required'	=> array( 'product_quickview', '=', '1' )
			),
			array(
				'id'		=> 'product_quickview_summary_layout',
				'type'		=> 'select',
				'title'		=> __( 'Summary - Layout', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Select product-summary layout.', 'nm-framework-admin' ),
				'options'	=> array( 'align-top' => 'Align to Top (suitable for shorter images)', 'align-bottom' => 'Align to Bottom' ),
				'default'	=> 'align-top',
				'required'	=> array( 'product_quickview', '=', '1' )
			),
			array(
				'id'		=> 'product_quickview_atc',
				'type'		=> 'switch',
				'title'		=> __( 'Summary - Add to Cart Button', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable',
				'required'	=> array( 'product_quickview', '=', '1' )
			),
			array(
				'id'		=> 'product_quickview_details_button',
				'type'		=> 'switch',
				'title'		=> __( 'Summary - Details Button', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable',
				'required'	=> array( 'product_quickview', '=', '1' )
			),
			array (
				'id' 	=> 'cart_info',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Cart', 'nm-framework-admin' ) . '</h3>',
			),
			array(
				'id'		=> 'cart_show_item_price',
				'type'		=> 'switch',
				'title'		=> __( 'Single Item Price', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array (
				'id' 	=> 'checkout_info',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Checkout', 'nm-framework-admin' ) . '</h3>',
			),
			array(
				'id'		=> 'checkout_inline_notices',
				'type'		=> 'switch',
				'title'		=> __( 'Inline Validation Notices', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Display validation notices below input fields.', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'checkout_tac_lightbox',
				'type'		=> 'switch',
				'title'		=> __( 'Terms & Conditions Lightbox', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Display "Terms & conditions" in a lightbox window.', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			)
		)
	) );
	
    Redux::setSection( $opt_name, array(
		'title'		=> __( 'Shop Filters', 'nm-framework-admin' ),
		'icon'		=> 'el-icon-shopping-cart',
		'fields'	=> array(
			array(
				'id'		=> 'shop_header',
				'type'		=> 'switch',
				'title'		=> __( 'Filters Bar', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Display filters bar (categories, filters & search) above shop catalog.', 'nm-framework-admin' ),
                'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
			array(
				'id'		=> 'shop_filters_enable_ajax',
				'type'		=> 'select',
				'title'		=> __( 'AJAX', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Enable AJAX for product filters.', 'nm-framework-admin' ),
				'options'	=> array( '1' => 'Enable', 'desktop' => 'Disable on Touch devices', '0' => 'Disable' ),
				'default'	=> '1'
			),
			array(
				'id'		=> 'shop_ajax_update_title',
				'type'		=> 'switch',
				'title'		=> __( 'AJAX - Update Page Title', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Update page-title after loading a new page.', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable',
				'required'	=> array( 'shop_filters_enable_ajax', '!=', '0' )
			),
			array (
				'id' 	=> 'shop_header_categories_info',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Categories Menu', 'nm-framework-admin' ) . '</h3>',
			),
			array(
				'id'		=> 'shop_categories',
				'type'		=> 'switch',
				'title'		=> __( 'Menu', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'shop_categories_layout',
				'type'		=> 'select',
				'title'		=> __( 'Layout', 'nm-framework-admin' ),
                'options'	=> array( 'list_sep' => 'Divided list', 'list_nosep' => 'Undivided list', 'list-spaced' => 'Evenly spaced list (for Centered categories)' ),
				'default'	=> 'list_sep',
				'required'	=> array( 'shop_categories', '=', '1' )
			),
            array(
				'id'		=> 'shop_categories_thumbnails_layout',
				'type'		=> 'select',
				'title'		=> __( 'Layout - Thumbnails', 'nm-framework-admin' ),
                'options'	=> array( 'thumbnails-top' => 'Above title', '' => 'Left aligned' ),
				'default'	=> 'thumbnails-top',
				'required'	=> array( 'shop_categories_layout', '=', 'list-spaced' )
			),
			array(
				'id'		=> 'shop_categories_top_level',
				'type'		=> 'select',
				//'title'		=> __( 'Display Type', 'nm-framework-admin' ),
				//'options'	=> array( '1' => 'Show top-level categories', '0' => 'Hide top-level categories' ),
                'title'		=> __( 'Sub Categories', 'nm-framework-admin' ),
                'options'	=> array( '1' => 'Display below main menu', '0' => 'Display as main menu' ),
				'default'	=> '1',
				'required'	=> array( 'shop_categories', '=', '1' )
			),
            array(
				'id'		=> 'shop_categories_all_link',
				'type'		=> 'switch',
				'title'		=> __( '"All" Link', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable',
                'required'	=> array( 'shop_categories', '=', '1' )
			),
            array(
				'id'	    => 'shop_categories_all_link_thumbnail',
				'type'	    => 'media', 
				'title'	    => __( '"All" Link - Thumbnail', 'nm-framework-admin' ),
                'required'  => array( 'shop_categories_all_link', '=', '1' )
			),
			array(
				'id'		=> 'shop_categories_back_link',
				'type'		=> 'select',
				'title'		=> __( '"Back" Link', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Display "Back" link on sub-category menus.', 'nm-framework-admin' ),
				'options'	=> array( '0' => 'Disable', '1st' => 'Enable', '2nd' => 'Enable from second sub-category level' ),
				'default'	=> '1st',
				'required'	=> array( 'shop_categories_top_level', '=', '0' )
			),
			array(
				'id'		=> 'shop_categories_hide_empty',
				'type'		=> 'switch',
				'title'		=> __( 'Hide Empty Categories', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable',
				'required'	=> array( 'shop_categories', '=', '1' )
			),
			array(
				'id'		=> 'shop_categories_orderby',
				'type'		=> 'select',
				'title'		=> __( 'Order By', 'nm-framework-admin' ),
				'options'	=> array(
                    'id' => 'ID',
                    'name'          => 'Name/Menu-order',
                    'slug'          => 'Slug',
                    'count'         => 'Count',
                    'term_group'    => 'Term group'
                ),
				'default'	=> 'slug',
				'required'	=> array( 'shop_categories', '=', '1' )
			),
			array(
				'id'		=> 'shop_categories_order',
				'type'		=> 'select',
				'title'		=> __( 'Order', 'nm-framework-admin' ),
				'options'	=> array( 'asc' => 'Ascending', 'desc' => 'Descending' ),
				'default'	=> 'asc',
				'required'	=> array( 'shop_categories', '=', '1' )
			),
			array (
				'id' 	=> 'shop_filters_info',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Filter Widgets', 'nm-framework-admin' ) . '</h3>'
			),
            array(
				'id' 		=> 'shop_filters',
				'type' 		=> 'image_select',
				'title' 	=> __( 'Filters', 'nm-framework-admin' ),
				'options'	=> array(
                    'disabled'  => array( 'title' => __( 'None', 'nm-framework-admin' ), 'img' => NM_URI . '/assets/img/option-panel/filters-none.png' ),
                    'header'    => array( 'title' => __( 'Above Shop', 'nm-framework-admin' ), 'img' => NM_URI . '/assets/img/option-panel/filters-above-shop.png' ),
					'default'   => array( 'title' => __( 'Sidebar', 'nm-framework-admin' ), 'img' => NM_URI . '/assets/img/option-panel/filters-sidebar.png' ),
                    'popup'     => array( 'title' => __( 'Popup', 'nm-framework-admin' ), 'img' => NM_URI . '/assets/img/option-panel/filters-popup.png' )
				),
				'default' 	=> 'disabled'
			),
            array(
				'id'		=> 'shop_filters_custom_controls',
				'type'		=> 'switch',
                'title'		=> __( 'Custom Controls', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Display color/image swatches for variable-product attributes.', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'shop_filters_sidebar_position',
				'type'		=> 'select',
				'title'		=> __( 'Sidebar Position', 'nm-framework-admin' ),
				'options'	=> array( 'left' => 'Left', 'right' => 'Right' ),
				'default'	=> 'left',
				'required'	=> array( 'shop_filters', '=', 'default' )
			),
            array(
				'id'			=> 'shop_filters_columns',
				'type'			=> 'slider',
				'title'			=> __( 'Columns', 'nm-framework-admin' ),
				'default'		=> 4,
				'min'			=> 1,
				'max'			=> 4,
				'step'			=> 1,
				'display_value'	=> 'text',
				'required'	=> array( 'shop_filters', '=', 'header' )
			),
            array(
				'id'		=> 'shop_filters_scrollbar',
				'type'		=> 'switch',
				'title'		=> __( 'Scrollbar', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Show scrollbar for filters with long content.', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
			array(
				'id'			=> 'shop_filters_height',
				'type'			=> 'slider',
				'title'			=> __( 'Scrollbar - Filter Max. Height', 'nm-framework-admin' ),
				'default'		=> 150,
				'min'			=> 80,
				'max'			=> 1000,
				'step'			=> 1,
				'display_value'	=> 'text',
				'required'		=> array( 'shop_filters_scrollbar', '!=', '0' )
			),
			array (
				'id' 	=> 'shop_search_info',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Search', 'nm-framework-admin' ) . '</h3>',
			),
			array(
				'id'		=> 'shop_search',
				'type'		=> 'select',
				'title'		=> __( 'Search', 'nm-framework-admin' ),
				'options'	=> array(
                    '0' => 'Disable',
                    'header'    => 'Display in Header',
                    'shop'      => 'Display above Shop'
                ),
				'default'	=> 'shop'
			),
			/*array(
				'id'		=> 'shop_search_ajax',
				'type'		=> 'switch',
				'title'		=> __( 'AJAX', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Use AJAX for searching.', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),*/
            array(
				'id'		=> 'shop_search_auto_close',
				'type'		=> 'switch',
				'title'		=> __( 'Auto Close', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Close search-field when performing a search.', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
			array(
				'id'			=> 'shop_search_min_char',
				'type'			=> 'slider',
				'title'			=> __( 'Minimum Characters', 'nm-framework-admin' ),
				'subtitle'		=> __( 'Minimum number of characters required to search.', 'nm-framework-admin' ),
				'default'		=> 2,
				'min'			=> 1,
				'max'			=> 10,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
			array(
				'id'		=> 'shop_search_by_titles',
				'type'		=> 'switch',
				'title'		=> __( 'Titles Only', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Search by product titles only.', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array (
				'id' 	=> 'shop_search_suggestions_info',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Search - Suggestions (header)', 'nm-framework-admin' ) . '</h3>',
			),
            array(
				'id'		=> 'shop_search_suggestions',
				'type'		=> 'switch',
				'title'		=> __( 'Suggestions', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Display search suggestions.', 'nm-framework-admin' ),
                'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'shop_search_suggestions_instant',
				'type'		=> 'switch',
				'title'		=> __( 'Instant', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Display suggestions instantly from pre-cached data<br>(product titles are used to find matches).', 'nm-framework-admin' ),
                'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'			=> 'shop_search_suggestions_max_results',
				'type'			=> 'slider',
				'title'			=> __( 'Maximum Results', 'nm-framework-admin' ),
				'default'		=> 6,
				'min'			=> 4,
				'max'			=> 8,
				'step'			=> 1,
				'display_value'	=> 'text'
			)/*,
            array(
				'id'		=> 'shop_search_suggestions_cache',
				'type'		=> 'switch',
				'title'		=> __( 'Cache Results', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'shop_search_suggestions_cache_expiration',
				'type'		=> 'text',
				'title'		=> __( 'Cache Expiration', 'nm-framework-admin' ),
                'subtitle'	=> __( 'Value is in Hours.', 'nm-framework-admin' ),
				'default'	=> 12,
                'validate' => 'numeric',
                'required'	=> array( 'shop_search_suggestions_cache', '=', '1' )
			)*/
		)
	) );

	Redux::setSection( $opt_name, array(
		'title'		=> __( 'Single Product', 'nm-framework-admin' ),
		'icon'		=> 'el-icon-shopping-cart',
		'fields'	=> array(
            array(
				'id' 		=> 'product_layout',
				'type' 		=> 'image_select',
				'title' 	=> __( 'Layout', 'nm-framework-admin' ),
				'options'	=> array(
                    'default'                               => array( 'alt' => 'Vertical Tumbnails', 'img' => NM_URI . '/assets/img/option-panel/product-layout-default.png' ),
					'default-thumbs-h'                      => array( 'alt' => 'Horizontal Thumbnails', 'img' => NM_URI . '/assets/img/option-panel/product-layout-default-thumbs-h.png' ),
                    'scrolling scrolling-single'            => array( 'alt' => 'Scrolling', 'img' => NM_URI . '/assets/img/option-panel/product-layout-scrolling.png' ),
                    'scrolling scrolling-grid'              => array( 'alt' => 'Scrolling Grid', 'img' => NM_URI . '/assets/img/option-panel/product-layout-scrolling-grid.png' ),
                    'scrolling scrolling-variable-grid'     => array( 'alt' => 'Scrolling Variable Grid', 'img' => NM_URI . '/assets/img/option-panel/product-layout-scrolling-variable-grid.png' ),
                    'scrolling scrolling-variable-grid-2'   => array( 'alt' => 'Scrolling Variable Grid 2', 'img' => NM_URI . '/assets/img/option-panel/product-layout-scrolling-variable-grid-2.png' ),
                    'expanded'                              => array( 'alt' => 'Expanded', 'img' => NM_URI . '/assets/img/option-panel/product-layout-expanded.png' )
				),
				'default' 	=> 'default'
			),
			array(
				'id'		=> 'product_navigation_same_term',
				'type'		=> 'switch',
				'title'		=> __( 'Navigation - Same Category', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Navigate within the current category.', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'product_redirect_scroll',
				'type'		=> 'switch',
				'title'		=> __( 'Redirect Scroll', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Scroll to shop after clicking a Breadcrumb, Category or Tag link.', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'single_product_sale_flash',
				'type'		=> 'select',
				'title'		=> __( 'Sale Flash', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Product sale flash badges.', 'nm-framework-admin' ),
				'options'	=> array(
                    '0'         => 'Disable',
                    'txt'       => 'Display sale Text',
                    'pct'       => 'Display sale Percentage',
                    'pct-ap'    => 'Display sale Percentage, after price'
                ),
				'default'	=> '0'
			),
            array (
				'id' 	=> 'product_image_info',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Gallery', 'nm-framework-admin' ) . '</h3>',
			),
			array(
				'id'			=> 'product_image_column_size',
				'type'			=> 'slider',
				'title'			=> __( 'Column Size', 'nm-framework-admin' ),
				'subtitle'		=> __( 'Select size-span of the gallery column.', 'nm-framework-admin' ),
				'default'		=> 7,
				'min'			=> 3,
				'max'			=> 8,
				'step'			=> 1,
				'display_value' => 'text',
                'required'      => array( 'product_layout', '!=', 'expanded' )
			),
			array(
				'id'		=> 'product_image_zoom',
				'type'		=> 'switch',
				'title'		=> __( 'Lightbox', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Lightbox gallery for viewing full-size images.', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
			array(
				'id'		=> 'product_image_hover_zoom',
				'type'		=> 'switch',
				'title'		=> __( 'Zoom', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Mouseover image to zoom and pan.', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'//,
                //'required'	=> array( 'product_layout', '!=', 'scrolling' )
			),
            array(
				'id'			=> 'product_image_max_size',
				'type'			=> 'slider',
				'title'			=> __( 'Tablet/mobile Width', 'nm-framework-admin' ),
				'subtitle'		=> __( 'Maximum gallery width on tablet/mobile.', 'nm-framework-admin' ),
				'default'		=> 500,
				'min'			=> 100,
				'max'			=> 1220,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'		=> 'product_thumbnails_slider',
				'type'		=> 'switch',
				'title'		=> __( 'Thumbnail Slider', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable',
                'required'	=> array( 'product_layout', '=', 'default' )
			),
            array(
				'id'		=> 'product_image_pagination',
				'type'		=> 'switch',
				'title'		=> __( 'Pagination - Tablet/mobile', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Display pagination on tablet/mobile.', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
			array (
				'id' 	=> 'product_details_info',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Details', 'nm-framework-admin' ) . '</h3>',
			),
            array(
				'id'		=> 'product_ajax_atc',
				'type'		=> 'switch',
				'title'		=> __( 'AJAX Add-to-Cart', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Enable AJAX for add-to-cart buttons.', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'qty_arrows',
				'type'		=> 'switch',
				'title'		=> __( 'Quantity Arrows', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'qty_arrows_grouped',
				'type'		=> 'switch',
				'title'		=> __( 'Quantity Arrows - Grouped', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'product_share_buttons',
				'type'		=> 'switch',
				'title'		=> __( 'Share Buttons', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Display social share buttons.', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array (
				'id' 	=> 'product_details_variations_info',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Details - Variations', 'nm-framework-admin' ) . '</h3>',
			),
            array(
				'id'		=> 'product_select_hide_labels',
				'type'		=> 'switch',
				'title'		=> __( 'Hide Labels', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Hide label/name for product variations.', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'product_custom_select',
				'type'		=> 'switch',
				'title'		=> __( 'Custom Dropdown', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Display custom dropdown menu for product variations.', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'product_custom_controls',
				'type'		=> 'switch',
				'title'		=> __( 'Custom Controls', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Display color/image swatches and size labels for variable-product attributes.', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'			=> 'product_swatches_color_radius',
				'type'			=> 'slider',
				'title'			=> __( 'Color Swatches - Radius', 'nm-framework-admin' ),
				'subtitle'		=> __( 'Set the radius/size of Color swatches.', 'nm-framework-admin' ),
				'default'		=> 19,
				'min'			=> 1,
				'max'			=> 100,
				'step'			=> 1,
				'display_value'	=> 'text',
                'required'      => array( 'product_custom_controls', '=', '1' )
			),
            array(
				'id'		=> 'product_swatches_color_tooltip',
				'type'		=> 'switch',
				'title'		=> __( 'Color Swatches - Tooltip', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'			=> 'product_swatches_image_radius',
				'type'			=> 'slider',
				'title'			=> __( 'Image Swatches - Radius', 'nm-framework-admin' ),
				'subtitle'		=> __( 'Set the radius/size of Image swatches.', 'nm-framework-admin' ),
				'default'		=> 19,
				'min'			=> 1,
				'max'			=> 100,
				'step'			=> 1,
				'display_value'	=> 'text',
                'required'      => array( 'product_custom_controls', '=', '1' )
			),
            array(
				'id'		=> 'product_swatches_image_tooltip',
				'type'		=> 'switch',
				'title'		=> __( 'Image Swatches - Tooltip', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array (
				'id' 	=> 'product_tabs_info',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Tabs', 'nm-framework-admin' ) . '</h3>',
			),
            array(
				'id'		=> 'product_tabs_layout',
				'type'		=> 'select',
				'title'		=> __( 'Layout', 'nm-framework-admin' ),
				'options'	=> array( 'default' => 'Separate Column (Tabs)', 'summary' => 'Summary Column (Accordion)' ),
				'default'	=> 'default'
			),
			array(
				'id'		=> 'product_description_layout',
				'type'		=> 'select',
				'title'		=> __( 'Description Width', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Select product description width.', 'nm-framework-admin' ),
				'options'	=> array( 'boxed' => 'Boxed', 'full' => 'Full width' ),
				'default'	=> 'boxed',
                'required'  => array( 'product_tabs_layout', '=', 'default' )
			),
            array (
				'id' 	=> 'product_meta_info',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Meta', 'nm-framework-admin' ) . '</h3>',
			),
            array(
				'id'		=> 'product_meta_layout',
				'type'		=> 'select',
				'title'		=> __( 'Layout', 'nm-framework-admin' ),
				'options'	=> array( 'default' => 'Separate Column', 'summary' => 'Summary Column' ),
				'default'	=> 'default'
			),
            array (
				'id' 	=> 'product_upsell_related_info',
				'icon'	=> true,
				'type'	=> 'info',
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Up-sells &amp; Related Products', 'nm-framework-admin' ) . '</h3>',
			),
            array(
				'id'			=> 'product_upsell_related_columns',
				'type'			=> 'slider',
				'title'			=> __( 'Columns', 'nm-framework-admin' ),
				'default'		=> 4,
				'min'			=> 1,
				'max'			=> 6,
				'step'			=> 1,
				'display_value'	=> 'text'
			),
            array(
				'id'			=> 'product_upsell_related_per_page',
				'type'			=> 'slider',
				'title'			=> __( 'Products per Page', 'nm-framework-admin' ),
				'subtitle'		=> __( 'Select number of up-sell/related products to display.', 'nm-framework-admin' ),
				'default'		=> 4,
				'min'			=> 1,
				'max'			=> 48,
				'step'			=> 1,
				'display_value'	=> 'text'
			)
		)
	) );
	
    Redux::setSection( $opt_name, array(
		'title'		=> __( 'My Account', 'nm-framework-admin' ),
		'icon'		=> 'el el-user',
		'fields'	=> array(
			array(
                'id'		=> 'myaccount_profile_image',
                'type'		=> 'switch',
                'title'		=> __( 'Profile Image', 'nm-framework-admin' ),
                'subtitle'	=> 'Display <a href="http://en.gravatar.com/" target="_blank">gravatar</a> profile image.',
                'default'	=> 1,
                'on'		=> 'Enable',
                'off'		=> 'Disable'
            ),
            array(
                'id' 		=> 'myaccount_dashboard_text',
				'type'		=> 'textarea',
				'title' 	=> __( 'Dashboard Text', 'nm-framework-admin' ),
				'subtitle'	=> __( 'HTML allowed.', 'nm-framework-admin' ),
                'default'	=> '',
				'validate'	=> 'html'
			)
		)
	) );
    
    if ( defined( 'NM_WISHLIST_DIR' ) ) {
        Redux::setSection( $opt_name, array(
            'title'		=> __( 'Wishlist', 'nm-framework-admin' ),
            'icon'		=> 'el-icon-heart',
            'fields'	=> array(
                array(
                    'id'	    => 'wishlist_page_id',
                    'type'	    => 'select',
                    'title'	    => __( 'Wishlist Page', 'nm-framework-admin' ),
                    'data'	    => 'pages'
                ),
                array(
                    'id'		=> 'menu_wishlist',
                    'type'		=> 'switch', 
                    'title'		=> __( 'Header Link', 'nm-framework-admin' ),
                    'subtitle'		=> __( 'Display link in header menu (make sure to select the Wishlist Page above as well).', 'nm-framework-admin' ),
                    'default'	=> 1,
                    'on'		=> 'Enable',
                    'off'		=> 'Disable'
                ),
                array(
                    'id'		=> 'menu_wishlist_icon',
                    'type'		=> 'switch', 
                    'title'		=> __( 'Header Link - Icon', 'nm-framework-admin' ),
                    'subtitle'	=> __( 'Display menu icon (instead of text).', 'nm-framework-admin' ),
                    'default'	=> 1,
                    'on'		=> 'Enable',
                    'off'		=> 'Disable',
                    'required'	=> array( 'menu_wishlist', '=', '1' )
                ),
                array(
                    'id'		=> 'menu_wishlist_icon_html',
                    'type'		=> 'text',
                    'title'		=> __( 'Header Link - Icon HTML', 'nm-framework-admin' ),
                    'subtitle'	=> __( 'Menu icon markup (must be valid HTML).', 'nm-framework-admin' ),
                    'default'	=> '<i class="nm-font nm-font-heart-outline"></i>',
                    'validate'	=> 'html',
                    'required'	=> array( 'menu_wishlist_icon', '=', '1' )
                ),
                array(
                    'id'		=> 'menu_wishlist_count',
                    'type'		=> 'switch', 
                    'title'		=> __( 'Header Link - Count', 'nm-framework-admin' ),
                    'subtitle'		=> __( 'Display current product-count after link.', 'nm-framework-admin' ),
                    'default'	=> 0,
                    'on'		=> 'Enable',
                    'off'		=> 'Disable',
                    'required'	=> array( 'menu_wishlist', '=', '1' )
                ),
                array(
                    'id'		=> 'wishlist_require_login',
                    'type'		=> 'switch', 
                    'title'		=> __( 'Require Login', 'nm-framework-admin' ),
                    'subtitle'		=> __( 'Require login to add products to Wishlist.', 'nm-framework-admin' ),
                    'default'	=> 0,
                    'on'		=> 'Enable',
                    'off'		=> 'Disable'
                ),
                array(
                    'id'		=> 'wishlist_show_variations',
                    'type'		=> 'switch',
                    'title'		=> __( 'Display Variations', 'nm-framework-admin' ),
                    'subtitle'	=> __( 'Display variations for products in the wishlist.', 'nm-framework-admin' ),
                    'default'	=> 0,
                    'on'		=> 'Enable',
                    'off'		=> 'Disable'
                ),
                array(
                    'id'		=> 'wishlist_share',
                    'type'		=> 'switch',
                    'title'		=> __( 'Share Links', 'nm-framework-admin' ),
                    'subtitle'	=> __( 'Display social share links.', 'nm-framework-admin' ),
                    'default'	=> 0,
                    'on'		=> 'Enable',
                    'off'		=> 'Disable'
                ),
                array(
                    'id'		=> 'wishlist_share_title',
                    'type'		=> 'text',
                    'title'		=> __( 'Share Title', 'nm-framework-admin' ),
                    'subtitle'	=> __( 'Enter a title for the social share links.', 'nm-framework-admin' ),
                    'default'	=> 'My Wishlist',
                    'validate'	=> 'no_html',
                    'required'	=> array( 'wishlist_share', '=', '1' )
                ),
                array(
                    'id'		=> 'wishlist_share_text',
                    'type'		=> 'textarea',
                    'title'		=> __( 'Share Text', 'nm-framework-admin' ),
                    'subtitle'	=> __( 'Enter a description for the social share links. Enter <strong>%wishlist_url%</strong> to display the Wishlist URL.', 'nm-framework-admin' ),
                    'rows'      => 4,
                    'validate'	=> 'no_html',
                    'required'	=> array( 'wishlist_share', '=', '1' )
                ),
                array(
                    'id'		=> 'wishlist_share_image_url',
                    'type'		=> 'text',
                    'title'		=> __( 'Share Image URL', 'nm-framework-admin' ),
                    'subtitle'	=> __( 'Enter a image-URL for the social share links.', 'nm-framework-admin' ),
                    'validate'	=> 'url',
                    'required'	=> array( 'wishlist_share', '=', '1' )
                )
            )
        ) );
    }
    
    Redux::setSection( $opt_name, array(
		'title'		=> __( 'Blog', 'nm-framework-admin' ),
		'icon'		=> 'el el-wordpress',
		'fields'	=> array(
			array(
				'id'		=> 'blog_static_page',
				'type'		=> 'switch', 
				'title'		=> __( 'Static Content', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
			array(
				'id'		=> 'blog_static_page_id',
				'type'		=> 'select',
				'title'		=> __( 'Static Content - Page', 'nm-framework-admin' ),
				'subtitle'	=> __( "Select a page to display on the blog's index page.", 'nm-framework-admin' ),
				'data'		=> 'pages',
				'required'	=> array( 'blog_static_page', '=', '1' )
			),
			array (
				'id'	=> 'blog_categories_info',
				'type'	=> 'info',
				'icon'	=> true,
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Categories Menu', 'nm-framework-admin' ) . '</h3>',
			),
            array(
				'id'		=> 'blog_categories',
				'type'		=> 'switch', 
				'title'		=> __( 'Menu', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'blog_categories_hide_empty',
				'type'		=> 'switch',
				'title'		=> __( 'Hide Empty Categories', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable',
				'required'	=> array( 'blog_categories', '=', '1' )
			),
			array(
				'id'		=> 'blog_categories_layout',
				'type'		=> 'select',
				'title'		=> __( 'Layout', 'nm-framework-admin' ),
				'options'	=> array( 'list' => 'Separated list', 'list_nosep' => 'List', 'columns' => 'Columns' ),
				'default'	=> 'list',
                'required'	=> array( 'blog_categories', '=', '1' )
			),
			array(
				'id'			=> 'blog_categories_columns',
				'type'			=> 'slider',
				'title'			=> __( 'Columns', 'nm-framework-admin' ),
				'default'		=> 4,
				'min'			=> 2,
				'max'			=> 5,
				'step'			=> 1,
				'display_value'	=> 'text',
				'required'	=> array( 'blog_categories_layout', '=', 'columns' )
			),
			array(
				'id'		=> 'blog_categories_toggle',
				'type'		=> 'switch', 
				'title'		=> __( 'Toggle', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Display a link to toggle categories on tablet/mobile.', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable',
                'required'	=> array( 'blog_categories', '=', '1' )
			),
			array(
				'id'		=> 'blog_categories_orderby',
				'type'		=> 'select',
				'title'		=> __( 'Order By', 'nm-framework-admin' ),
				'options'	=> array( 'id' => 'ID', 'name' => 'Name', 'slug' => 'Slug', 'count' => 'Count', 'term_group' => 'Term Group' ),
				'default'	=> 'name',
                'required'	=> array( 'blog_categories', '=', '1' )
			),
			array(
				'id'		=> 'blog_categories_order',
				'type'		=> 'select',
				'title'		=> __( 'Order', 'nm-framework-admin' ),
				'options'	=> array( 'asc' => 'Ascending', 'desc' => 'Descending' ),
				'default'	=> 'asc',
                'required'	=> array( 'blog_categories', '=', '1' )
			),
			array (
				'id'	=> 'blog_archive_info',
				'type'	=> 'info',
				'icon'	=> true,
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Archive/Listing', 'nm-framework-admin' ) . '</h3>',
			),
            array(
				'id' 		=> 'blog_layout',
				'type' 		=> 'image_select',
				'title' 	=> __( 'Layout', 'nm-framework-admin' ),
				'options'	=> array(
                    'grid'      => array( 'grid' => 'Grid', 'img' => NM_URI . '/assets/img/option-panel/blog-layout-grid.png' ),
                    'classic'   => array( 'classic' => 'Classic', 'img' => NM_URI . '/assets/img/option-panel/blog-layout-classic.png' ),
                    'list'      => array( 'list' => 'List', 'img' => NM_URI . '/assets/img/option-panel/blog-layout-list.png' )
				),
				'default' 	=> 'grid'
			),
			array(
				'id'			=> 'blog_grid_columns',
				'type'			=> 'slider',
				'title'			=> __( 'Grid - Columns', 'nm-framework-admin' ),
				'default'		=> 3,
				'min'			=> 2,
				'max'			=> 5,
				'step'			=> 1,
				'display_value'	=> 'text',
				'required'	=> array( 'blog_layout', '=', 'grid' )
			),
            array(
				'id'		=> 'blog_grid_masonry',
				'type'		=> 'switch', 
				'title'		=> __( 'Grid - Masonry Layout', 'nm-framework-admin' ),
				'default'	=> 1,
				'on'		=> 'Enable',
				'off'		=> 'Disable',
                'required'	=> array( 'blog_layout', '=', 'grid' )
			),
            array(
				'id'		=> 'blog_sidebar',
				'type'		=> 'select',
				'title'		=> __( 'Sidebar', 'nm-framework-admin' ),
				'options'	=> array( 'none' => 'No sidebar', 'left' => 'Sidebar Left', 'right' => 'Sidebar Right' ),
				'default'	=> 'none',
			),
            array(
				'id'		=> 'blog_show_full_posts',
				'type'		=> 'switch', 
				'title'		=> __( 'Show Full Posts', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'blog_infinite_load',
				'type'		=> 'switch', 
				'title'		=> __( 'Infinite Load', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Replace default pagination with AJAX "infinite" loading.', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
			array (
				'id'	=> 'blog_single_post_info',
				'type'	=> 'info',
				'icon'	=> true,
				'raw'	=> '<h3 style="margin: 0;">' . __( 'Single Post', 'nm-framework-admin' ) . '</h3>',
			),
			array(
				'id'		=> 'single_post_sidebar',
				'type'		=> 'select',
				'title'		=> __( 'Layout', 'nm-framework-admin' ),
				'options'	=> array( 'none' => 'No sidebar', 'left' => 'Sidebar Left', 'right' => 'Sidebar Right' ),
				'default'	=> 'none'
			),
            array(
				'id'		=> 'single_post_display_featured_image',
				'type'		=> 'switch', 
				'title'		=> __( 'Featured Image', 'nm-framework-admin' ),
				'subtitle'	=> __( 'Display featured image above post.', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'		=> 'single_post_featured_image_aspect_ratio',
				'type'		=> 'select',
				'title'		=> __( 'Featured Image - Aspect Ratio', 'nm-framework-admin' ),
				'options'	=> array(
                    'aspect-ratio-original'   => 'Original',
                    'aspect-ratio ratio-1-1'  => '1:1',
                    'aspect-ratio ratio-3-2'  => '3:2',
                    'aspect-ratio ratio-4-3'  => '4:3',
                    'aspect-ratio ratio-16-9' => '16:9'
                ),
				'default'	=> 'aspect-ratio-original',
                'required'	=> array( 'single_post_display_featured_image', '=', 1 )
			),
            array(
				'id'		=> 'single_post_related',
				'type'		=> 'switch', 
				'title'		=> __( 'Related Posts', 'nm-framework-admin' ),
				'default'	=> 0,
				'on'		=> 'Enable',
				'off'		=> 'Disable'
			),
            array(
				'id'			=> 'single_post_related_per_page',
				'type'			=> 'slider',
				'title'			=> __( 'Related Posts - Posts per Page', 'nm-framework-admin' ),
				'subtitle'		=> __( 'Number of related posts to display.', 'nm-framework-admin' ),
				'default'		=> 4,
				'min'			=> 1,
				'max'			=> 48,
				'step'			=> 1,
				'display_value'	=> 'text',
                'required'	=> array( 'single_post_related', '=', '1' )
			),
            array(
				'id'			=> 'single_post_related_columns',
				'type'			=> 'slider',
				'title'			=> __( 'Related Posts - Columns', 'nm-framework-admin' ),
				'default'		=> 4,
				'min'			=> 1,
				'max'			=> 6,
				//'step'			=> 2,
				'display_value'	=> 'text',
                'required'	=> array( 'single_post_related', '=', '1' )
			)
		)
	) );
    
    if ( class_exists( 'NM_Portfolio' ) ) {
        Redux::setSection( $opt_name, array(
            'title'		=> __( 'Portfolio', 'nm-framework-admin' ),
            'icon'		=> 'el el-brush',
            'fields'	=> array(
                array(
                    'id'		=> 'portfolio_gutenberg',
                    'type'		=> 'switch',
                    'title'		=> __( 'Gutenberg Editor', 'nm-framework-admin' ),
                    'subtitle'	=> __( 'Enable Gutenberg editor for Portfolio pages.', 'nm-framework-admin' ),
                    'default'	=> 0,
                    'on'		=> 'Enable',
                    'off'		=> 'Disable'
                ),
                array (
                    'id' 	=> 'portfolio_gallery_info',
                    'icon'	=> true,
                    'type'	=> 'info',
                    'raw'	=> '<h3 style="margin: 0;">' . __( 'Archive/Gallery', 'nm-framework-admin' ) . '</h3>',
                ),
                array(
                    'id'	    => 'portfolio_layout',
                    'type'	    => 'select',
                    'title'	    => __( 'Layout', 'nm-framework-admin' ),
                    'options'   => array( 
                        'standard'  => 'Standard',
                        'overlay'   => 'Overlay'
                    ),
                    'default'   => 'overlay'
                ),
                array(
                    'id'        => 'portfolio_page_layout',
                    'type'      => 'select',
                    'title'     => __( 'Page Width', 'nm-framework-admin' ),
                    'options'	=> array( 
                        'full'          => 'Full',
                        'full-nopad'    => 'Full (no padding)',
                        'boxed'         => 'Boxed'
                    ),
                    'default'   => 'boxed'
                ),
                array(
                    'id'		=> 'portfolio_packery',
                    'type'		=> 'switch',
                    'title'		=> __( 'Masonry Grid', 'nm-framework-admin' ),
                    'subtitle'	=> __( 'Enable "masonry" grid layout.', 'nm-framework-admin' ),
                    'default'	=> 1,
                    'on'		=> 'Enable',
                    'off'		=> 'Disable'
                ),
                array(
                    'id'		=> 'portfolio_items',
                    'type' 		=> 'text',
                    'title' 	=> __( 'Items', 'nm-framework-admin' ),
                    'subtitle'	=> __( 'Number of items to display (leave blank for unlimited).', 'nm-framework-admin' ),
                    'validate'	=> 'numeric',
                    'default'	=> ''
                ),
                array(
                    'id'        => 'portfolio_columns',
                    'type'      => 'select',
                    'title'     => __( 'Items per Row', 'nm-framework-admin' ),
                    'options'	=> array( 
                        '1' => '1',
                        '2' => '2',
                        '3'	=> '3',
                        '4'	=> '4'
                    ),
                    'default'   => '2'
                ),
                array(
                    'id'        => 'portfolio_order_by',
                    'type'      => 'select',
                    'title'     => __( 'Order By', 'nm-framework-admin' ),
                    'options'	=> array( 
                        'date'  => 'Date',
                        'title' => 'Title',
                        'rand'  => 'Random'
                    ),
                    'default'   => 'date'
                ),
                array(
                    'id'	    => 'portfolio_order',
                    'type'	    => 'select',
                    'title'	    => __( 'Order', 'nm-framework-admin' ),
                    'options'   => array(
                        'desc'  => 'Descending',
                        'asc'   => 'Ascending'
                    ),
                    'default'   => 'desc'
                ),
                array (
                    'id' 	=> 'portfolio_categories_info',
                    'icon'	=> true,
                    'type'	=> 'info',
                    'raw'	=> '<h3 style="margin: 0;">' . __( 'Categories Filter', 'nm-framework-admin' ) . '</h3>',
                ),
                array(
                    'id'		=> 'portfolio_categories',
                    'type'		=> 'switch',
                    'title'		=> __( 'Filter', 'nm-framework-admin' ),
                    'default'	=> 1,
                    'on'		=> 'Enable',
                    'off'		=> 'Disable'
                ),
                array(
                    'id'        => 'portfolio_categories_alignment',
                    'type'      => 'select',
                    'title'     => __( 'Alignment', 'nm-framework-admin' ),
                    'options'	=> array( 
                        'left'      => 'Left',
                        'center'    => 'Center',
				        'right'     => 'Right'
                    ),
                    'default'	=> 'left',
                    'required'	=> array( 'portfolio_categories', '=', '1' )
                ),
                array(
                    'id'		=> 'portfolio_categories_js',
                    'type'		=> 'switch',
                    'title'		=> __( 'Animated Sorting', 'nm-framework-admin' ),
                    'default'	=> 1,
                    'on'		=> 'Enable',
                    'off'		=> 'Disable',
                    'required'	=> array( 'portfolio_categories', '=', '1' )
                ),
                array (
                    'id' 	=> 'portfolio_archive_info',
                    'icon'	=> true,
                    'type'	=> 'info',
                    'raw'	=> '<h3 style="margin: 0;">' . __( 'Archive & Permalinks', 'nm-framework-admin' ) . '</h3>',
                ),
                array(
                    'id'		=> 'portfolio_archive',
                    'type'		=> 'switch',
                    'title'		=> __( 'Archive', 'nm-framework-admin' ),
                    'subtitle'	=> sprintf( '%s <br><strong>%s</strong>',
                        __( 'Can be disabled if Portfolio is added via page builder.', 'nm-framework-admin' ),
                        __( 'Note: Re-save the "Settings > Permalinks" page after changing.</strong>', 'nm-framework-admin' )
                    ),
                    'default'	=> 1,
                    'on'		=> 'Enable',
                    'off'		=> 'Disable'
                    //'flush_permalinks' => true // NM: Doesn't seem to work: https://docs.reduxframework.com/core/the-basics/validation/
                ),
                array(
                    'id'		=> 'portfolio_permalink',
                    'type'		=> 'text',
                    'title'		=> __( 'Archive - Permalink', 'nm-framework-admin' ),
                    'subtitle'	=> sprintf( '%s <br><strong>%s</strong>',
                        __( 'Enter base parmalink name for the portfolio.', 'nm-framework-admin' ), 
                        __( 'Note: Re-save the "Settings > Permalinks" page after changing.</strong>', 'nm-framework-admin' )
                    ),
                    'default'	=> 'portfolio',
                    'validate'	=> apply_filters( 'nm_portfolio_permalink_option_validate', '' ) // Use 'unique_slug' to make sure the slug is unique
                    //'flush_permalinks' => true // NM: Doesn't seem to work: https://docs.reduxframework.com/core/the-basics/validation/
                ),
                array(
                    'id'		=> 'portfolio_category_permalink',
                    'type'		=> 'text',
                    'title'		=> __( 'Archive - Category Permalink', 'nm-framework-admin' ),
                    'subtitle'	=> sprintf( '%s <br><strong>%s</strong>',
                        __( 'Enter base parmalink name for portfolio-categories.', 'nm-framework-admin' ),
                        __( 'Note: Re-save the "Settings > Permalinks" page after changing.', 'nm-framework-admin' )
                    ),
                    'default'	=> 'portfolio-category',
                    'validate'	=> apply_filters( 'nm_portfolio_permalink_option_validate', '' ) // Use 'unique_slug' to make sure the slug is unique
                    //'flush_permalinks' => true // NM: Doesn't seem to work: https://docs.reduxframework.com/core/the-basics/validation/
                )
            )
        ) );
    }
    
	Redux::setSection( $opt_name, array(
        'title'		=> __( 'Social Profiles', 'nm-framework-admin' ),
		'icon'		=> 'el-icon-share-alt',
        'fields'    => array(
            array(
                'id'        => 'social_profiles',
                'type'      => 'sortable',
                'title'     => __( 'Enter your social profile URLs', 'nm-framework-admin' ),
                //'label'     => true,
                'subtitle'     => __( 'Drag and drop to change the order of your social profiles.', 'nm-framework-admin' ),
                'mode'      => 'text',
                'options'   => array(
                    'facebook'      => 'Facebook profile URL',
                    'instagram'     => 'Instagram profile URL',
                    'twitter'       => 'Twitter profile URL',
                    'flickr'        => 'Flickr profile URL',
                    'linkedin'      => 'LinkedIn profile URL',
                    'pinterest'     => 'Pinterest profile URL',
                    'rss'           => 'RSS feed URL',
                    'snapchat'      => 'Snapchat profile URL',
                    'behance'       => 'Behance profile URL',
                    'dribbble'      => 'Dribbble profile URL',
                    'ebay'          => 'eBay profile URL',
                    'etsy'          => 'Etsy profile URL',
                    'line'          => 'LINE chat URL',
                    'mixcloud'      => 'MixCloud profile URL',
                    'odnoklassniki' => 'OK.RU profile URL',
                    'soundcloud'    => 'SoundCloud profile URL',
                    'spotify'       => 'Spotify profile URL',
                    'strava'        => 'Strava profile URL',
                    'telegram'      => 'Telegram URL',
                    'tiktok'        => 'TikTok URL',
                    'tumblr'        => 'Tumblr profile URL',
                    'vimeo'         => 'Vimeo profile URL',
                    'vk'            => 'VK profile URL',
                    'weibo'         => 'Weibo profile URL',
                    'whatsapp'      => 'WhatsApp profile URL',
                    'youtube'       => 'YouTube profile URL',
                    'email'         => 'Enter your Email address'
                )
            )
        )
	) );
    
    if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {
        Redux::setSection( $opt_name, array(
            'title'		=> __( 'WPBakery', 'nm-framework-admin' ),
            'icon'		=> 'el-icon-website',
            'fields'	=> array(
                array(
                    'id' 		=> 'vcomp_enable_frontend',
                    'type' 		=> 'switch', 
                    'title' 	=> __( 'Frontend Editor', 'nm-framework-admin' ),
                    'default'	=> 0,
                    'on' 		=> 'Enable',
                    'off' 		=> 'Disable'
                ),
                array(
                    'id' 		=> 'vcomp_stock',
                    'type' 		=> 'switch', 
                    'title' 	=> __( 'Default Elements', 'nm-framework-admin' ),
                    'default'	=> 0,
                    'on' 		=> 'Enable',
                    'off' 		=> 'Disable'
                )
            )
        ) );
    }
    
    /*
     * <--- END SECTIONS
     */
	