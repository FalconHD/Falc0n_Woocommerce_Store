<?php
	
	// VC element: nm_feature
	vc_map( array(
	   'name'			=> esc_html__( 'Feature Box', 'nm-framework-admin' ),
	   'category'		=> esc_html__( 'Content', 'nm-framework-admin' ),
	   'description'	=> esc_html__( 'Feature box with image or icon.', 'nm-framework-admin' ),
	   'base'			=> 'nm_feature',
	   'icon'			=> 'nm_feature',
	   'params'			=> array(
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Title', 'nm-framework-admin' ),
				'param_name' 	=> 'title',
				'description'	=> esc_html__( 'Enter a feature title.', 'nm-framework-admin' )
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Sub-title', 'nm-framework-admin' ),
				'param_name' 	=> 'subtitle',
				'description'	=> esc_html__( 'Enter a sub-title.', 'nm-framework-admin' )
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__('Icon Type', 'nm-framework-admin' ),
				'param_name' 	=> 'icon_type',
				'description'	=> esc_html__( 'Select icon type.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Font Icon'	=> 'icon',
					'Image'		=> 'image_id'
				),
				'std' 			=> 'icon'
			),
			array(
				'type' 			=> 'iconpicker',
				'heading' 		=> esc_html__( 'Icon', 'nm-framework-admin' ),
				'param_name' 	=> 'icon',
				'description' 	=> esc_html__( 'Select icon from library.', 'nm-framework-admin' ),
				'value' 		=> 'pe-7s-close',  // Default value to backend editor admin_label
				'settings' 		=> array(
					'type' 			=> 'pixeden', // Default type for icons
					'emptyIcon' 	=> false, // Default true, display an "EMPTY" icon?
					'iconsPerPage'	=> 3000 // Default 100, how many icons per/page to display, we use (big number) to display all icons in single page
				),
				'dependency'	=> array(
					'element'	=> 'icon_type',
					'value'		=> 'icon'
				)
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Icon Style', 'nm-framework-admin' ),
				'param_name' 	=> 'icon_style',
				'description'	=> esc_html__( 'Select an icon style.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Simple'		=> 'simple',
					'Background'	=> 'background',
					'Border'		=> 'border'
				),
				'std' 			=> 'simple',
				'dependency'	=> array(
					'element'	=> 'icon_type',
					'value' 	=> array( 'icon' )
				)
			),
			array(
				'type' 			=> 'colorpicker',
				'heading' 		=> esc_html__( 'Icon Background/Border Color', 'nm-framework-admin' ),
				'param_name' 	=> 'icon_background_color',
				'description' 	=> esc_html__( 'Select icon background/border color.', 'nm-framework-admin' ),
				'dependency'	=> array(
					'element'	=> 'icon_style',
					'value' 	=> array( 'background', 'border' )
				)
			),
			array(
				'type' 			=> 'colorpicker',
				'heading' 		=> esc_html__( 'Icon Color', 'nm-framework-admin' ),
				'param_name' 	=> 'icon_color',
				'description' 	=> esc_html__( 'Select icon color.', 'nm-framework-admin' ),
				'dependency'	=> array(
					'element'	=> 'icon_type',
					'value' 	=> array( 'icon' )
				)
			),
			array(
				'type' 			=> 'attach_image',
				'heading' 		=> esc_html__( 'Image', 'nm-framework-admin' ),
				'param_name' 	=> 'image_id',
				'description'	=> esc_html__( 'Select image from the media library.', 'nm-framework-admin' ),
				'dependency'	=> array(
					'element'	=> 'icon_type',
					'value' 	=> array( 'image_id' )
				)
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Image Style', 'nm-framework-admin' ),
				'param_name' 	=> 'image_style',
				'description'	=> esc_html__( 'Select an image style.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Default'	=> 'default',
					'Rounded'	=> 'rounded'
				),
				'std' 			=> 'default',
				'dependency'	=> array(
					'element'	=> 'icon_type',
					'value' 	=> array( 'image_id' )
				)
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__('Layout', 'nm-framework-admin' ),
				'param_name' 	=> 'layout',
				'description'	=> esc_html__( 'Select a layout.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Default'		=> 'default',
					'Centered'		=> 'centered',
					'Icon Right'	=> 'icon_right',
					'Icon Left'		=> 'icon_left'
				),
				'std' 			=> 'default'
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Top Offset', 'nm-framework-admin' ),
				'param_name' 	=> 'top_offset',
				'description'	=> esc_html__( 'Offset the feature text (numbers only).', 'nm-framework-admin' )
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__('Bottom Spacing', 'nm-framework-admin' ),
				'param_name' 	=> 'bottom_spacing',
				'description'	=> esc_html__( 'Select bottom spacing.', 'nm-framework-admin' ),
				'value' 		=> array(
					'(None)'	=> 'none',
					'Small'		=> 'small',
					'Medium'	=> 'medium',
					'Large'		=> 'large'
				),
				'std' 			=> 'none'
			),
			array(
				'type' 			=> 'textarea_html',
				'heading' 		=> esc_html__( 'Description', 'nm-framework-admin' ),
				'param_name' 	=> 'content', // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
				'description'	=> esc_html__( 'Enter a feature description.', 'nm-framework-admin' )
			),
			array(
				'type' 			=> 'vc_link',
				'heading' 		=> esc_html__( 'Link', 'nm-framework-admin' ),
				'param_name' 	=> 'link',
				'description' 	=> esc_html__( 'Add a link after the description.', 'nm-framework-admin' )
			)
	   )
	) );
	