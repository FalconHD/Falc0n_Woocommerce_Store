<?php
	
	// VC element: nm_social_profiles
	vc_map( array(
	   'name'			=> esc_html__( 'Testimonial', 'nm-framework-admin' ),
	   'category'		=> esc_html__( 'Content', 'nm-framework-admin' ),
	   'description'	=> esc_html__( 'User testimonial', 'nm-framework-admin' ),
	   'base'			=> 'nm_testimonial',
	   'icon'			=> 'nm_testimonial',
	   'params'			=> array(
			array(
				'type' 			=> 'attach_image',
				'heading' 		=> esc_html__( 'Image', 'nm-framework-admin' ),
				'param_name' 	=> 'image_id',
				'description'	=> esc_html__( 'Author image.', 'nm-framework-admin' )
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Signature', 'nm-framework-admin' ),
				'param_name' 	=> 'signature',
				'description'	=> esc_html__( 'Author signature.', 'nm-framework-admin' )
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Company', 'nm-framework-admin' ),
				'param_name' 	=> 'company',
				'description'	=> esc_html__( 'Company signature.', 'nm-framework-admin' )
			),
			array(
                'type'          => 'textarea_html',
				'heading' 		=> esc_html__( 'Description', 'nm-framework-admin' ),
                'param_name'    => 'content',
				'description'	=> esc_html__( 'Testimonial description.', 'nm-framework-admin' )
			)
	   )
	) );
