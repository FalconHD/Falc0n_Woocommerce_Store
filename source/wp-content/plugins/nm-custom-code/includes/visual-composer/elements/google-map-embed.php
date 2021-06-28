<?php
	
	// VC element: nm_gmap
	vc_map( array(
	   'name'			=> esc_html__( 'Google Map Embed', 'nm-framework-admin' ),
	   'category'		=> esc_html__( 'Content', 'nm-framework-admin' ),
	   'description'	=> esc_html__( 'Embed a Google Map (no API key needed)', 'nm-framework-admin' ),
	   'base'			=> 'nm_gmap_embed',
	   'icon'			=> 'nm_gmap',
	   'params'			=> array(
           array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Address', 'nm-framework-admin' ),
				'param_name' 	=> 'address',
				'description'	=> esc_html__( 'Address for the map marker (you can type it in any language).', 'nm-framework-admin' ),
				'value' 		=> 'Amsterdam, The Netherlands'
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Map Type', 'nm-framework-admin' ),
				'param_name' 	=> 'map_type',
				'description'	=> esc_html__( 'Select a map type.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Roadmap'      => '',
					'Satellite'    => 'k'
				)
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Map Height', 'nm-framework-admin' ),
				'param_name' 	=> 'height',
				'description'	=> esc_html__( 'Enter a map height.', 'nm-framework-admin' )
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Zoom Level', 'nm-framework-admin' ),
				'param_name' 	=> 'zoom',
				'description' 	=> esc_html__( 'Default map zoom level (1 - 20).', 'nm-framework-admin' ),
				'value' 		=> '10',
			)
	   )
	) );
	