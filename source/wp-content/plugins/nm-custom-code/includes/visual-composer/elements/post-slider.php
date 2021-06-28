<?php
	
	// VC element: nm_post_slider
	vc_map( array(
	   'name'			=> esc_html__( 'Post Slider', 'nm-framework-admin' ),
	   'category'		=> esc_html__( 'Content', 'nm-framework-admin' ),
	   'description'	=> esc_html__( 'Display blog posts in slider', 'nm-framework-admin' ),
	   'base'			=> 'nm_post_slider',
	   'icon'			=> 'nm_post_slider',
	   'params'			=> array(
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Number of Posts', 'nm-framework-admin' ),
				'param_name' 	=> 'num_posts',
				'description' 	=> esc_html__( 'Enter max number of posts to display.', 'nm-framework-admin' ),
				'value' 		=> '8'
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Category', 'nm-framework-admin' ),
				'param_name' 	=> 'category',
				'description'	=> esc_html__( 'Filter by post category.', 'nm-framework-admin' ),
				'value' 		=> function_exists( 'nm_get_post_categories' ) ? nm_get_post_categories() : array()
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Columns', 'nm-framework-admin' ),
				'param_name' 	=> 'columns',
				'description'	=> esc_html__( 'Select slider columns.', 'nm-framework-admin' ),
				'value' 		=> array(
					'2'	=> '2',
                    '3'	=> '3',
					'4'	=> '4',
					'5'	=> '5'
				),
				'std' 			=> '4'
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Image Type', 'nm-framework-admin' ),
				'param_name' 	=> 'image_type',
				'description'	=> esc_html__( 'Select image-type to display.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Fluid'				=> 'fluid',
					'Background (CSS)'	=> 'background'
				),
				'std' 			=> 'fluid'
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Background Image Height', 'nm-framework-admin' ),
				'param_name' 	=> 'bg_image_height',
				'description' 	=> esc_html__( 'Enter a height for the background image.', 'nm-framework-admin' ),
				'value' 		=> '',
				'dependency'	=> array(
					'element'	=> 'image_type',
					'value'		=> 'background'
				)
			),
			array(
				'type' 			=> 'checkbox',
				'heading' 		=> esc_html__( 'Post Excerpt', 'nm-framework-admin' ),
				'param_name' 	=> 'post_excerpt',
				'description'	=> esc_html__( 'Display post excerpt.', 'nm-framework-admin' ),
				'value'			=> array(
					esc_html__( 'Enable', 'nm-framework-admin' )	=> '1'
				)
			),
            array(
				'type' 			=> 'checkbox',
				'heading' 		=> esc_html__( 'Arrows', 'nm-framework-admin' ),
				'param_name' 	=> 'arrows',
				'description'	=> esc_html__( 'Display "prev" and "next" arrows.', 'nm-framework-admin' ),
				'value'			=> array(
					esc_html__( 'Enable', 'nm-framework-admin' )	=> '1'
				)
			),
            array(
				'type' 			=> 'textfield',
				'heading' 		=> __( 'Autoplay', 'nm-framework-admin' ),
				'param_name' 	=> 'autoplay',
				'description'	=> __( 'Enter autoplay interval in milliseconds (1 second = 1000 milliseconds).', 'nm-framework-admin' )
			),
            array(
				'type' 			=> 'checkbox',
				'heading' 		=> __( 'Infinite Loop', 'nm-framework-admin' ),
				'param_name' 	=> 'infinite',
				'description'	=> __( 'Infinite loop sliding.', 'nm-framework-admin' ),
				'value'			=> array(
					__( 'Enable', 'nm-framework-admin' )	=> '1'
				)
			)
	   )
	) );
	