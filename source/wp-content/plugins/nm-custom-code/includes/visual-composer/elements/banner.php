<?php

	// VC element: nm_banner
	vc_map( array(
		'name'			=> __( 'Banner', 'nm-framework-admin' ),
		'category'		=> __( 'Content', 'nm-framework-admin' ),
		'description'	=> __( 'Responsive banner', 'nm-framework-admin' ),
		'base'			=> 'nm_banner',
		'icon'			=> 'nm_banner',
		'params'		=> array(
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Content Layout', 'nm-framework-admin' ),
				'param_name' 	=> 'layout',
				'description'	=> __( "Select the Banner's content/text layout.", 'nm-framework-admin' ),
				'value' 		=> array(
					'Full width'							=> 'full',
					'Boxed'									=> 'boxed',
					'Boxed (inside full width container)'	=> 'boxed-full-parent'
				),
				'std' 			=> 'full'
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> __( 'Title', 'nm-framework-admin' ),
				'param_name' 	=> 'title',
				'description'	=> __( 'Enter a banner title.', 'nm-framework-admin' )
			),
            array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Title: Size', 'nm-framework-admin' ),
				'param_name' 	=> 'title_size',
				'description'	=> __( 'Select a title size.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Small'		=> 'small',
					'Medium'	=> 'medium',
					'Large'		=> 'large',
                    'Extra Large'		=> 'xlarge'
				),
				'std' 			=> 'medium'
			),
            array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Title: Tag', 'nm-framework-admin' ),
				'param_name' 	=> 'title_tag',
				'description'	=> __( 'Select a title HTML tag.', 'nm-framework-admin' ),
				'value' 		=> array(
					'h1'   => 'h1',
					'h2'   => 'h2',
					'h3'   => 'h3',
                    'h4'   => 'h4',
                    'h5'   => 'h5',
                    'h6'   => 'h6'
				),
				'std' 			=> 'h1'
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> __( 'Subtitle', 'nm-framework-admin' ),
				'param_name' 	=> 'subtitle',
				'description'	=> __( 'Enter a banner subtitle.', 'nm-framework-admin' )
			),
            array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Subtitle: Position', 'nm-framework-admin' ),
				'param_name' 	=> 'subtitle_position',
				'description'	=> __( 'Select subtitle position.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Above Title'  => 'above',
					'Below Title'  => 'below'
				),
				'std' 			=> 'below'
			),
            array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Subtitle: Tag', 'nm-framework-admin' ),
				'param_name' 	=> 'subtitle_tag',
				'description'	=> __( 'Select a subtitle HTML tag.', 'nm-framework-admin' ),
				'value' 		=> array(
					'h1'   => 'h1',
					'h2'   => 'h2',
					'h3'   => 'h3',
                    'h4'   => 'h4',
                    'h5'   => 'h5',
                    'h6'   => 'h6',
                    'p'    => 'p',
                    'div'  => 'div'
				),
				'std' 			=> 'h2'
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Link: Type', 'nm-framework-admin' ),
				'param_name' 	=> 'link_source',
				'description'	=> __( 'Select banner link type.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Standard'			=> 'custom',
					'AJAX Shop Link'	=> 'shop'
				),
				'std' 			=> 'custom'
			),
            array(
				'type' 			=> 'vc_link',
				'heading' 		=> __( 'Link', 'nm-framework-admin' ),
				'param_name' 	=> 'custom_link',
				'description' 	=> __( 'Set a banner link.', 'nm-framework-admin' ),
				'dependency'	=> array(
					'element'	=> 'link_source',
					'value'		=> array( 'custom' )
				)
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> __( 'Link: Title', 'nm-framework-admin' ),
				'param_name' 	=> 'shop_link_title',
				'description'	=> __( 'Enter a link title.', 'nm-framework-admin' ),
				'dependency'	=> array(
					'element'	=> 'link_source',
					'value'		=> array( 'shop' )
				)
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> __( 'Link (URL)', 'nm-framework-admin' ),
				'param_name' 	=> 'shop_link',
				'description'	=> __( 'Enter a valid shop link (archive pages only).', 'nm-framework-admin' ),
				'dependency'	=> array(
					'element'	=> 'link_source',
					'value'		=> array( 'shop' )
				)
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Link: Layout', 'nm-framework-admin' ),
				'param_name' 	=> 'link_type',
				'description'	=> __( 'Select a link layout.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Banner Link'	=> 'banner_link',
					'Text Link'		=> 'text_link',
                    'Button'        => 'link_btn'
				),
				'std' 			=> 'banner_link'
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Text: Color Scheme', 'nm-framework-admin' ),
				'param_name' 	=> 'text_color_scheme',
				'description'	=> __( 'Select text color scheme.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Dark'	=> 'dark',
					'Light'	=> 'light'
				),
				'std' 			=> 'dark'
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Text: Position', 'nm-framework-admin' ),
				'param_name' 	=> 'text_position',
				'description'	=> __( 'Select text position.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Center'		=> 'h_center-v_center',
					'Top Left'		=> 'h_left-v_top',
					'Top Center'	=> 'h_center-v_top',
					'Top Right'		=> 'h_right-v_top',
					'Center Left'	=> 'h_left-v_center',
					'Center Right'	=> 'h_right-v_center',
					'Bottom Left'	=> 'h_left-v_bottom',
					'Bottom Center'	=> 'h_center-v_bottom',
					'Bottom Right'	=> 'h_right-v_bottom'
				),
				'std' 			=> 'h_center-v_center'
			),
            array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Text: Position - Tablet & Mobile', 'nm-framework-admin' ),
				'param_name' 	=> 'text_position_mobile',
				'description'	=> __( 'Select text position on tablet & mobile sized screens.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Inside Banner'    => '',
					'Outside Banner'   => 'alt'
				),
				'std' 			=> ''
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Text: Alignment', 'nm-framework-admin' ),
				'param_name' 	=> 'text_alignment',
				'description'	=> __( 'Select text alignment.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Left'		=> 'align_left',
					'Center'	=> 'align_center',
					'Right'		=> 'align_right'
				),
				'std' 			=> 'align_left'
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> __( 'Text: Max Width', 'nm-framework-admin' ),
				'param_name' 	=> 'text_width',
				'description'	=> __( 'Enter a maximum width for the text (enter numbers only).', 'nm-framework-admin' )
			),
            array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Text: Max Width - Units', 'nm-framework-admin' ),
				'param_name' 	=> 'text_width_units',
				'description'	=> __( 'Text maximum width units.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Percent (%)'      => '%',
                    'Pixels (px)'      => 'px'
				),
				'std' 			=> '%'
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> __( 'Text: Padding', 'nm-framework-admin' ),
				'param_name' 	=> 'text_padding',
				'description'	=> __( 'Text padding (enter numbers only).', 'nm-framework-admin' )
			),
            array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Text: Padding - Units', 'nm-framework-admin' ),
				'param_name' 	=> 'text_padding_units',
				'description'	=> __( 'Text padding units.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Percent (%)'      => '%',
                    'Pixels (px)'      => 'px'
				),
				'std' 			=> '%'
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Text: Animation (Banner Slider)', 'nm-framework-admin' ),
				'param_name' 	=> 'text_animation',
				'description'	=> __( 'Select a text animation (used by the Banner Slider element).', 'nm-framework-admin' ),
				'value' 		=> array(
					'(none)'		=> '',
					'fadeIn'		=> 'fadeIn',
					'fadeInDown'	=> 'fadeInDown',
					'fadeInLeft'	=> 'fadeInLeft',
					'fadeInRight'	=> 'fadeInRight',
					'fadeInUp'		=> 'fadeInUp'
				)
			),
	   		array(
				'type' 			=> 'attach_image',
				'heading' 		=> __( 'Image', 'nm-framework-admin' ),
				'param_name' 	=> 'image_id',
				'description' 	=> __( 'Add a banner image.', 'nm-framework-admin' )
			),
			array(
				'type' 			=> 'attach_image',
				'heading' 		=> __( 'Image: Tablet & Mobile', 'nm-framework-admin' ),
				'param_name' 	=> 'alt_image_id',
                'description' 	=> __( 'Display an alternative banner image on Tablet & Mobile sized screens.', 'nm-framework-admin' )
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Image: Type', 'nm-framework-admin' ),
				'param_name' 	=> 'image_type',
				'description'	=> __( 'Select the banner image type.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Standard Image'	   => 'fluid',
					'CSS Background Image' => 'css'
				),
				'std' 			=> 'fluid'
			),
            array(
				'type' 			=> 'textfield',
				'heading' 		=> __( 'Image: Viewport Height', 'nm-framework-admin' ),
				'param_name' 	=> 'image_viewport_height',
				'description'	=> __( 'Image viewport height (1 = 1% of the available browser height - enter numbers only).', 'nm-framework-admin' ),
				'dependency'	=> array(
					'element'	=> 'image_type',
					'value'		=> array( 'css' )
				)
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> __( 'Image: Minimum Height', 'nm-framework-admin' ),
				'param_name' 	=> 'height',
				'description'	=> __( 'Image minimum height (value is in pixels - enter numbers only).', 'nm-framework-admin' ),
				'dependency'	=> array(
					'element'	=> 'image_type',
					'value'		=> array( 'css' )
				)
			),
            array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Image: Loading', 'nm-framework-admin' ),
				'param_name' 	=> 'image_loading',
                'description'	=> __( 'NOTE: The "Standard" option is recommended when using a parent Banner Slider element.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Standard' => 'eager',
					'Lazy'     => 'lazy'
				),
				'std' 			=> 'eager',
                'dependency'	=> array(
					'element'	=> 'image_type',
					'value'		=> array( 'fluid' )
				)
			),
			array(
				'type' 			=> 'colorpicker',
				'heading' 		=> __( 'Background Color', 'nm-framework-admin' ),
				'param_name' 	=> 'background_color',
				'description' 	=> __( 'Set a background color.', 'nm-framework-admin' )
			)
	   )
	) );
	