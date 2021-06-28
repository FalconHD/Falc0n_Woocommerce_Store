<?php
	
	// VC element: nm_lightbox
	vc_map( array(
	   'name'			=> esc_html__( 'Lightbox', 'nm-framework-admin' ),
	   'category'		=> esc_html__( 'Content', 'nm-framework-admin' ),
	   'description'	=> esc_html__( 'Lightbox modal with custom content', 'nm-framework-admin' ),
	   'base'			=> 'nm_lightbox',
	   'icon'			=> 'nm_lightbox',
	   'params'			=> array(
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__('Link Type', 'nm-framework-admin' ),
				'param_name' 	=> 'link_type',
				'description'	=> esc_html__( 'Select lightbox link type.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Link'		=> 'link',
					'Button'	=> 'btn', //  Note: Using "button" causes a CSS bug in WP
					'Image'		=> 'image'
				),
				'std' 			=> 'link'
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Title', 'nm-framework-admin' ),
				'param_name' 	=> 'title',
				'description'	=> esc_html__( 'Enter a lightbox link/button title.', 'nm-framework-admin' )
			),
			// Dependency: link_type - btn
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Button Style', 'nm-framework-admin' ),
				'param_name'	=> 'button_style',
				'description'	=> esc_html__( 'Select button style.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Filled'			=> 'filled',
					'Filled Rounded'	=> 'filled_rounded',
					'Border'			=> 'border',
					'Border Rounded'	=> 'border_rounded',
					'Link'				=> 'link'
				),
				'std' 			=> 'filled',
				'dependency'	=> array(
					'element'	=> 'link_type',
					'value'		=> array( 'btn' )
				)
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Button Align', 'nm-framework-admin' ),
				'param_name'	=> 'button_align',
				'value'			=> array(
					'Left' 		=> 'left',
					'Center'	=> 'center',
					'Right' 	=> 'right'
				),
				'std' 			=> 'center',
				'dependency'	=> array(
					'element'	=> 'link_type',
					'value'		=> array( 'btn' )
				)
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Button Size', 'nm-framework-admin' ),
				'param_name' 	=> 'button_size',
				'description'	=> esc_html__( 'Select button size.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Mini'		=> 'xs',
					'Small'		=> 'sm',
					'Normal'	=> 'md',
					'Large'		=> 'lg'
				),
				'std' 			=> 'lg',
				'dependency'	=> array(
					'element'	=> 'link_type',
					'value'		=> array( 'btn' )
				)
			),
			array(
				'type' 			=> 'colorpicker',
				'heading' 		=> esc_html__( 'Button Color', 'nm-framework-admin' ),
				'param_name' 	=> 'button_color',
				'description'	=> esc_html__( 'Select button color.', 'nm-framework-admin' ),
				'dependency'	=> array(
					'element'	=> 'link_type',
					'value'		=> array( 'btn' )
				)
			),
			// /Dependency
			// Dependency: link_type - image
			array(
				'type' 			=> 'attach_image',
				'heading' 		=> esc_html__( 'Link Image', 'nm-framework-admin' ),
				'param_name' 	=> 'link_image_id',
				'description'	=> esc_html__( 'Select image from the media library.', 'nm-framework-admin' ),
				'dependency'	=> array(
					'element'	=> 'link_type',
					'value' 	=> array( 'image' )
				)
			),
			// /Dependency
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__('Lightbox Type', 'nm-framework-admin' ),
				'param_name' 	=> 'content_type',
				'description'	=> esc_html__( 'Select content type.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Image'	=> 'image',
					'Video'	=> 'iframe',
					'HTML'	=> 'inline'
				),
				'std' 			=> 'image'
			),
			// Dependency: content_type - image
			array(
				'type' 			=> 'attach_image',
				'heading' 		=> esc_html__( 'Lightbox Image', 'nm-framework-admin' ),
				'param_name' 	=> 'content_image_id',
				'description'	=> esc_html__( 'Select image from the media library.', 'nm-framework-admin' ),
				'dependency'	=> array(
					'element'	=> 'content_type',
					'value' 	=> array( 'image' )
				)
			),
            array(
				'type' 			=> 'checkbox',
				'heading' 		=> esc_html__( 'Lightbox Image Caption', 'nm-framework-admin' ),
				'param_name' 	=> 'content_image_caption',
				'description' 	=> esc_html__( 'Display image caption.', 'nm-framework-admin' ),
				'value'			=> array(
					esc_html__( 'Enable', 'nm-framework-admin' )	=> '1'
				),
                'dependency'	=> array(
					'element'	=> 'content_type',
					'value' 	=> array( 'image' )
				)
			),
			// /Dependency
			// Dependency: content_type - iframe, inline
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Lightbox Source', 'nm-framework-admin' ),
				'param_name' 	=> 'content_url',
				'description'	=> '
					Insert a Video URL or CSS selector for HTML content:
					<br /><br />
					<strong>YouTube video:</strong> http://www.youtube.com/watch?v=XXXXXXXXXXX
					<br />
					<strong>CSS selector:</strong> #contact-form
				',
				'dependency'	=> array(
					'element'	=> 'content_type',
					'value' 	=> array( 'iframe', 'inline' )
				)
			)
			// /Dependency
	   )
	) );
	