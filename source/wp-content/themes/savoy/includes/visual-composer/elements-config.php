<?php
	global $nm_globals;
	
	
	/* Remove default elements
	================================================== */
	
	if ( ! $nm_globals['vcomp_stock'] ) {
		vc_remove_element( 'vc_section' );
		vc_remove_element( 'vc_text_separator' );
		vc_remove_element( 'vc_gallery' );
		vc_remove_element( 'vc_images_carousel' );
		vc_remove_element( 'vc_teaser_grid' );
		vc_remove_element( 'vc_posts_grid' );
		vc_remove_element( 'vc_carousel' );
		vc_remove_element( 'vc_posts_slider' );
		vc_remove_element( 'vc_button' );
		vc_remove_element( 'vc_button2' );
		vc_remove_element( 'vc_cta_button' );
		vc_remove_element( 'vc_cta_button2' );
		vc_remove_element( 'vc_gmaps' );
		vc_remove_element( 'vc_flickr' );
		vc_remove_element( 'vc_basic_grid' );
		vc_remove_element( 'vc_media_grid' );
		vc_remove_element( 'vc_masonry_grid' );
		vc_remove_element( 'vc_masonry_media_grid' );
		vc_remove_element( 'vc_icon' );
		vc_remove_element( 'vc_btn' );
		vc_remove_element( 'vc_cta' );
		vc_remove_element( 'vc_round_chart' );
		vc_remove_element( 'vc_line_chart' );
		vc_remove_element( 'vc_tta_pageable' );
        vc_remove_element( 'vc_zigzag' );
        vc_remove_element( 'vc_hoverbox' );
	}
	   
	
	// WordPress default Widgets (Appearance > Widgets)
	if ( ! $nm_globals['vcomp_stock'] ) {
		vc_remove_element( 'vc_wp_search' );
		vc_remove_element( 'vc_wp_meta' );
		vc_remove_element( 'vc_wp_recentcomments' );
		vc_remove_element( 'vc_wp_calendar' );
		vc_remove_element( 'vc_wp_pages' );
		vc_remove_element( 'vc_wp_tagcloud' );
		vc_remove_element( 'vc_wp_custommenu' );
		vc_remove_element( 'vc_wp_text' );
		vc_remove_element( 'vc_wp_posts' );
		vc_remove_element( 'vc_wp_categories' );
		vc_remove_element( 'vc_wp_archives' );
		vc_remove_element( 'vc_wp_rss' );
	}
    
	
	/* Custom element params
	================================================== */
	
	// Element: vc_row
	vc_remove_param( 'vc_row', 'full_width' );
	vc_remove_param( 'vc_row', 'gap' );
	vc_remove_param( 'vc_row', 'columns_placement' );
    vc_remove_param( 'vc_row', 'rtl_reverse' );
	vc_remove_param( 'vc_row', 'parallax_speed_bg' );
    vc_remove_param( 'vc_row', 'video_bg_parallax' );
    vc_remove_param( 'vc_row', 'parallax_speed_video' );
    vc_add_param( 'vc_row', array(
		'type' 			=> 'dropdown',
		'heading' 		=> esc_html__( 'Row Type', 'nm-framework-admin' ),
		'param_name' 	=> 'type',
		'description'	=> esc_html__( 'Select row layout.', 'nm-framework-admin' ),
		'weight'		=> 1,
		'value' 		=> array(
			'Full'				=> 'full',
			'Full (no padding)'	=> 'full-nopad',
			'Boxed' 			=> 'boxed'
		)
	) );
	vc_add_param( 'vc_row', array(
		'type' 			=> 'textfield',
		'heading' 		=> esc_html__( 'Maximum Width', 'nm-framework-admin' ),
		'param_name' 	=> 'max_width',
		'value' 		=> '',
		'description'	=> esc_html__( 'Optional: Enter a maximum width (numbers only).', 'nm-framework-admin' ),
		'weight'		=> 1
	) );
	vc_add_param( 'vc_row', array(
		'type' 			=> 'textfield',
		'heading' 		=> esc_html__( 'Minimum Height', 'nm-framework-admin' ),
		'param_name' 	=> 'min_height',
		'value' 		=> '',
		'description'	=> esc_html__( 'Optional: Enter a minimum height (numbers only).', 'nm-framework-admin' ),
		'weight'		=> 1
	) );
	// Modify "vc_row - parallax" param (instead of removing param and adding new)
	function nm_vc_row_param_parallax() {
		// Get param values
		$param = WPBMap::getParam( 'vc_row', 'parallax' );
		
		// Replace param values
		$param['value'] = array(
			esc_html__( 'None', 'nm-framework-admin' ) => '',
			esc_html__( 'Static (fixed background)', 'nm-framework-admin' ) => 'static'
		);
		
		// Finally "mutate" param with new values
		vc_update_shortcode_param( 'vc_row', $param );
	}
	add_action( 'vc_after_init', 'nm_vc_row_param_parallax' );
	
    
	// Element: vc_row_inner
	vc_remove_param( 'vc_row_inner', 'equal_height' );
	vc_remove_param( 'vc_row_inner', 'gap' );
	vc_add_param( 'vc_row_inner', array(
		'type' 			=> 'dropdown',
		'heading' 		=> esc_html__( 'Row Type', 'nm-framework-admin' ),
		'param_name' 	=> 'type',
		'weight'		=> 1,
        'value' 		=> array(
            'Full'				=> 'full',
			'Full (no padding)'	=> 'full-nopad',
			'Boxed' 			=> 'boxed'
		)
	) );
    
    
    // Element: vc_column
    vc_remove_param( 'vc_column', 'video_bg' );
    vc_remove_param( 'vc_column', 'video_bg_url' );
    vc_remove_param( 'vc_column', 'video_bg_parallax' );
    vc_remove_param( 'vc_column', 'parallax' );
    vc_remove_param( 'vc_column', 'parallax_image' );
    vc_remove_param( 'vc_column', 'parallax_speed_video' );
    vc_remove_param( 'vc_column', 'parallax_speed_bg' );
	
	
	// Element: vc_column_text
    vc_remove_param( 'vc_column_text', 'css_animation' );
	
	
	// Element: vc_separator
    vc_remove_param( 'vc_separator', 'css' ); // Disable "Design Options" tab
	vc_remove_param( 'vc_separator', 'color' );
	vc_remove_param( 'vc_separator', 'align' );
	vc_remove_param( 'vc_separator', 'accent_color' );
	vc_remove_param( 'vc_separator', 'style' );
	vc_remove_param( 'vc_separator', 'el_width' );
    vc_remove_param( 'vc_separator', 'css_animation' );	
    vc_add_param( 'vc_separator', array(
		'type' 			=> 'textfield',
		'heading' 		=> esc_html__( 'Title', 'nm-framework-admin' ),
		'param_name' 	=> 'title',
		'holder' 		=> 'div',
		'value' 		=> '',
		'description'	=> esc_html__( 'Separator title.', 'nm-framework-admin' ),
		'weight'		=> 1
	) );
	vc_add_param( 'vc_separator', array(
		'type' 			=> 'dropdown',
		'heading' 		=> esc_html__( 'Title Size', 'nm-framework-admin' ),
		'param_name' 	=> 'title_size',
		'description'	=> esc_html__( 'Select title size.', 'nm-framework-admin' ),
		'value' 		=> array(
			'Large' 	=> 'large',
			'Medium'	=> 'medium',
			'Small' 	=> 'small',
		),
		'weight'		=> 1
	) );
	vc_add_param( 'vc_separator', array(
		'type' 			=> 'dropdown',
		'heading' 		=> esc_html__( 'Title position', 'nm-framework-admin' ),
		'param_name'	=> 'title_align',
		'value' 		=> array(
			esc_html__( 'Align center', 'nm-framework-admin' )	=> 'separator_align_center',
			esc_html__( 'Align left', 'nm-framework-admin' )	=> 'separator_align_left',
			esc_html__( 'Align right', 'nm-framework-admin' )	=> "separator_align_right"
		),
		'description'	=> esc_html__( 'Select title location.', 'nm-framework-admin' ),
		'weight'		=> 1
	) );
    vc_add_param( 'vc_separator', array(
        'type' 			=> 'dropdown',
        'heading' 		=> esc_html__( 'Title Tag', 'nm-framework-admin' ),
        'param_name' 	=> 'title_tag',
        'description'	=> esc_html__( 'Select title HTML tag.', 'nm-framework-admin' ),
        'value' 		=> array(
            'h1'   => 'h1',
            'h2'   => 'h2',
            'h3'   => 'h3',
            'h4'   => 'h4',
            'h5'   => 'h5',
            'h6'   => 'h6'
        ),
        'std' 			=> 'h1',
        'weight'		=> 1
    ) );
	vc_add_param( 'vc_separator', array(
		'type' 			=> 'colorpicker',
		'heading' 		=> esc_html__( 'Custom Border Color', 'nm-framework-admin' ),
		'param_name' 	=> 'accent_color',
		'description'	=> esc_html__( 'Select border color for your element.', 'nm-framework-admin' ),
		'weight'		=> 1
	) );
	
	
	// Element: vc_message
	vc_remove_param( 'vc_message', 'css' ); // Disable "Design Options" tab
	vc_remove_param( 'vc_message', 'color' );
	vc_remove_param( 'vc_message', 'message_box_style' );
	vc_remove_param( 'vc_message', 'style' );
	vc_remove_param( 'vc_message', 'message_box_color' );
	vc_remove_param( 'vc_message', 'icon_type' );
	vc_remove_param( 'vc_message', 'icon_fontawesome' );
	vc_remove_param( 'vc_message', 'icon_openiconic' );
	vc_remove_param( 'vc_message', 'icon_typicons' );
	vc_remove_param( 'vc_message', 'icon_entypo' );
	vc_remove_param( 'vc_message', 'icon_linecons' );
	vc_remove_param( 'vc_message', 'icon_pixelicons' );
    vc_remove_param( 'vc_message', 'icon_monosocial' );
	vc_remove_param( 'vc_message', 'css_animation' );
	vc_add_param( 'vc_message', array(
		'type' 			=> 'dropdown',
		'heading' 		=> esc_html__( 'Message Box Presets', 'nm-framework-admin' ),
		'param_name'	=> 'color',
		'value' 		=> array(
			'Information'	=> 'info',
			'Warning'		=> 'warning',
			'Success' 		=> 'success',
			'Error' 		=> 'danger'
		),
		'description' => esc_html__( 'Select predefined message box design.', 'nm-framework-admin' ),
		'weight'		=> 1
	) );
	
	
	// Element: vc_facebook
	vc_remove_param( 'vc_facebook', 'css' ); // Disable "Design Options" tab
    vc_remove_param( 'vc_facebook', 'css_animation' );

	
	// Element: vc_googleplus
	vc_remove_param( 'vc_googleplus', 'css' ); // Disable "Design Options" tab
    vc_remove_param( 'vc_googleplus', 'css_animation' );
	
	
	// Element: vc_tweetmeme
	vc_remove_param( 'vc_tweetmeme', 'css' ); // Disable "Design Options" tab
    vc_remove_param( 'vc_tweetmeme', 'css_animation' );
	
	
	// Element: vc_pinterest
	vc_remove_param( 'vc_pinterest', 'css' ); // Disable "Design Options" tab
    vc_remove_param( 'vc_pinterest', 'css_animation' );
	
	
	// Element: vc_toggle
	vc_remove_param( 'vc_toggle', 'css' ); // Disable "Design Options" tab
	vc_remove_param( 'vc_toggle', 'style' );
	vc_remove_param( 'vc_toggle', 'color' );
	vc_remove_param( 'vc_toggle', 'size' );
    vc_remove_param( 'vc_toggle', 'el_id' );
	vc_remove_param( 'vc_toggle', 'css_animation' );
	
	
	// Element: vc_single_image
	vc_remove_param( 'vc_single_image', 'css' ); // Disable "Design Options" tab
	vc_remove_param( 'vc_single_image', 'title' );
	vc_remove_param( 'vc_single_image', 'css_animation' );
    if ( ! $nm_globals['vcomp_stock'] ) {
        // Modify "vc_single_image - onclick" param (instead of removing param and adding new)
        function nm_vc_single_image_onclick() {
            // Get param values
            $param = WPBMap::getParam( 'vc_single_image', 'onclick' );
            // Replace param values
            $param['value'] = array(
                esc_html__( 'None', 'nm-framework-admin' ) => '',
                esc_html__( 'Link to large image', 'nm-framework-admin' ) => 'img_link_large',
                //esc_html__( 'Open prettyPhoto', 'nm-framework-admin' ) => 'link_image',
                esc_html__( 'Open custom link', 'nm-framework-admin' ) => 'custom_link',
                //esc_html__( 'Zoom', 'nm-framework-admin' ) => 'zoom',
            );
            // Finally "mutate" param with new values
            vc_update_shortcode_param( 'vc_single_image', $param );
        }
        add_action( 'vc_after_init', 'nm_vc_single_image_onclick' );
    }
	
	
	// Element: vc_tabs
	vc_remove_param( 'vc_tabs', 'title' );
    vc_remove_param( 'vc_tabs', 'css_animation' );
	
	
	// Element: vc_tour
	vc_remove_param( 'vc_tour', 'title' );
    vc_remove_param( 'vc_tour', 'css_animation' );
	
	
	// Element: vc_accordion
	vc_remove_param( 'vc_accordion', 'title' );
    vc_remove_param( 'vc_accordion', 'css_animation' );
	
	
	// Element: vc_widget_sidebar
	vc_remove_param( 'vc_widget_sidebar', 'title' );
	
	
	// Element: vc_video
	vc_remove_param( 'vc_video', 'css' ); // Disable "Design Options" tab
	vc_remove_param( 'vc_video', 'title' );
    vc_remove_param( 'vc_video', 'css_animation' );
	
	
	// Element: vc_progress_bar
	vc_remove_param( 'vc_progress_bar', 'css' ); // Disable "Design Options" tab
	vc_remove_param( 'vc_progress_bar', 'title' );
	vc_remove_param( 'vc_progress_bar', 'bgcolor' );
	vc_remove_param( 'vc_progress_bar', 'custombgcolor' );
	vc_remove_param( 'vc_progress_bar', 'customtxtcolor' );
	vc_remove_param( 'vc_progress_bar', 'options' );
    vc_remove_param( 'vc_progress_bar', 'css_animation' );

	
	// Element: vc_pie
	vc_remove_param( 'vc_pie', 'css' ); // Disable "Design Options" tab
    vc_remove_param( 'vc_pie', 'css_animation' );
	
    
	// Element: vc_empty_space
	vc_remove_param( 'vc_empty_space', 'css' ); // Disable "Design Options" tab
	
	
	// Element: vc_custom_heading
	vc_remove_param( 'vc_custom_heading', 'css' ); // Disable "Design Options" tab
    vc_remove_param( 'vc_custom_heading', 'css_animation' );
    
    
    if ( ! $nm_globals['vcomp_stock'] ) {
        // Element: vc_tta_tabs
        vc_remove_param( 'vc_tta_tabs', 'css' ); // Disable "Design Options" tab
        vc_remove_param( 'vc_tta_tabs', 'title' );
        vc_remove_param( 'vc_tta_tabs', 'style' );
        vc_remove_param( 'vc_tta_tabs', 'shape' );
        vc_remove_param( 'vc_tta_tabs', 'color' );
        vc_remove_param( 'vc_tta_tabs', 'no_fill_content_area' );
        vc_remove_param( 'vc_tta_tabs', 'tab_position' );
        vc_remove_param( 'vc_tta_tabs', 'spacing' );
        vc_remove_param( 'vc_tta_tabs', 'gap' );
        vc_remove_param( 'vc_tta_tabs', 'autoplay' );
        vc_remove_param( 'vc_tta_tabs', 'pagination_style' );
        vc_remove_param( 'vc_tta_tabs', 'pagination_color' );
        vc_remove_param( 'vc_tta_tabs', 'c_icon' );
        vc_remove_param( 'vc_tta_tabs', 'c_position' );
        vc_remove_param( 'vc_tta_tabs', 'css_animation' );
        
        
        // Element: vc_tta_tour
        vc_remove_param( 'vc_tta_tour', 'css' ); // Disable "Design Options" tab
        vc_remove_param( 'vc_tta_tour', 'title' );
        vc_remove_param( 'vc_tta_tour', 'style' );
        vc_remove_param( 'vc_tta_tour', 'shape' );
        vc_remove_param( 'vc_tta_tour', 'color' );
        vc_remove_param( 'vc_tta_tour', 'no_fill_content_area' );
        vc_remove_param( 'vc_tta_tour', 'tab_position' );
        vc_remove_param( 'vc_tta_tour', 'alignment' );
        vc_remove_param( 'vc_tta_tour', 'controls_size' );
        vc_remove_param( 'vc_tta_tour', 'spacing' );
        vc_remove_param( 'vc_tta_tour', 'gap' );
        vc_remove_param( 'vc_tta_tour', 'autoplay' );
        vc_remove_param( 'vc_tta_tour', 'pagination_style' );
        vc_remove_param( 'vc_tta_tour', 'pagination_color' );
        vc_remove_param( 'vc_tta_tour', 'c_icon' );
        vc_remove_param( 'vc_tta_tour', 'c_position' );
        vc_remove_param( 'vc_tta_tour', 'css_animation' );
        
        
        // Element: vc_tta_accordion
        vc_remove_param( 'vc_tta_accordion', 'css' ); // Disable "Design Options" tab
        vc_remove_param( 'vc_tta_accordion', 'title' );
        vc_remove_param( 'vc_tta_accordion', 'style' );
        vc_remove_param( 'vc_tta_accordion', 'shape' );
        vc_remove_param( 'vc_tta_accordion', 'color' );
        vc_remove_param( 'vc_tta_accordion', 'no_fill' );
        vc_remove_param( 'vc_tta_accordion', 'spacing' );
        vc_remove_param( 'vc_tta_accordion', 'gap' );
        vc_remove_param( 'vc_tta_accordion', 'c_align' );
        vc_remove_param( 'vc_tta_accordion', 'autoplay' );
        vc_remove_param( 'vc_tta_accordion', 'c_icon' );
        vc_remove_param( 'vc_tta_accordion', 'c_position' );
        vc_remove_param( 'vc_tta_accordion', 'css_animation' );
        
        
        // Element: vc_tta_section
        vc_remove_param( 'vc_tta_section', 'add_icon' );
        vc_remove_param( 'vc_tta_section', 'i_position' );
        vc_remove_param( 'vc_tta_section', 'i_type' );
        vc_remove_param( 'vc_tta_section', 'i_icon_fontawesome' );
        vc_remove_param( 'vc_tta_section', 'i_icon_openiconic' );
        vc_remove_param( 'vc_tta_section', 'i_icon_typicons' );
        vc_remove_param( 'vc_tta_section', 'i_icon_entypo' );
        vc_remove_param( 'vc_tta_section', 'i_icon_linecons' );
        vc_remove_param( 'vc_tta_section', 'i_icon_monosocial' );
        vc_remove_param( 'vc_tta_section', 'i_icon_material' );
    }
