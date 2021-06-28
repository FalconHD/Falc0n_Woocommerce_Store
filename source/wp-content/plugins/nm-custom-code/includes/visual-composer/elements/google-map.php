<?php
	
	// VC element: nm_gmap
	vc_map( array(
	   'name'			=> esc_html__( 'Google Map', 'nm-framework-admin' ),
	   'category'		=> esc_html__( 'Content', 'nm-framework-admin' ),
	   'description'	=> esc_html__( 'Embed a Google map', 'nm-framework-admin' ),
	   'base'			=> 'nm_gmap',
	   'icon'			=> 'nm_gmap',
	   'params'			=> array(
           array(
               'type' 			=> 'textfield',
               'heading' 		=> esc_html__( 'API Key (required)', 'nm-framework-admin' ),
               'param_name' 	=> 'api_key',
               'description'	=> sprintf( esc_html__( 'Enter your %sGoogle Maps API key%s.', 'nm-framework-admin' ), '<a href="https://developers.google.com/maps/documentation/javascript/get-api-key">', '</a>' )
           ),
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
					'Custom Roadmap'						=> 'roadmap_custom',
					'Default Roadmap (no custom styles)'	=> 'roadmap',
					'Satellite'								=> 'satellite',
					'Terrain'								=> 'terrain'
				),
				'std' 			=> 'roadmap_custom'
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Map Style', 'nm-framework-admin' ),
				'param_name' 	=> 'map_style',
				'description'	=> esc_html__( 'Select a map style.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Clean Flat'			=> 'clean_flat',
					'Grayscale'				=> 'grayscale',
					'Cooltone Grayscale'	=> 'cooltone_grayscale',
					'Light Monochrome'		=> 'light_monochrome',
					'Dark Monochrome'		=> 'dark_monochrome',
					'Paper'					=> 'paper',
					'Countries'				=> 'countries'
				),
				'std' 			=> 'paper'
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
				'value' 		=> '18',
			),
            array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Minimum Zoom Level', 'nm-framework-admin' ),
				'param_name' 	=> 'min_zoom',
				'description' 	=> esc_html__( 'Minimum map zoom level (1 - 20).', 'nm-framework-admin' ),
				'value' 		=> '1',
			),
			array(
				'type' 			=> 'checkbox',
				'heading' 		=> esc_html__( 'Zoom Controls', 'nm-framework-admin' ),
				'param_name' 	=> 'zoom_controls',
				'description' 	=> esc_html__( 'Display map zoom controls.', 'nm-framework-admin' ),
				'value'			=> array(
					esc_html__( 'Enable', 'nm-framework-admin' )	=> '1'
				)
			),
			array(
				'type' 			=> 'checkbox',
				'heading' 		=> esc_html__( 'Scroll Zoom', 'nm-framework-admin' ),
				'param_name' 	=> 'scroll_zoom',
				'description' 	=> esc_html__( 'Enable mouse-wheel zoom.', 'nm-framework-admin' ),
				'value'			=> array(
					esc_html__( 'Enable', 'nm-framework-admin' )	=> '1'
				)
			),
			array(
				'type' 			=> 'checkbox',
				'heading' 		=> esc_html__( 'Touch Drag', 'nm-framework-admin' ),
				'param_name' 	=> 'touch_drag',
				'description' 	=> esc_html__( 'Enable touch-drag on mobile devices.', 'nm-framework-admin' ),
				'value'			=> array(
					esc_html__( 'Enable', 'nm-framework-admin' )	=> '1'
				)
			),
			array(
				'type' 			=> 'attach_image',
				'heading' 		=> esc_html__( 'Marker Icon', 'nm-framework-admin' ),
				'param_name' 	=> 'marker_icon',
				'description' 	=> esc_html__( 'Custom marker icon.', 'nm-framework-admin' )
			)
	   )
	) );
	