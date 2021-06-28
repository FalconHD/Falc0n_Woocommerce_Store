<?php
	
	// VC element: nm_product_search
	vc_map( array(
	   'name'			=> esc_html__( 'Product Search', 'nm-framework-admin' ),
	   'category'		=> esc_html__( 'WooCommerce', 'nm-framework-admin' ),
	   'description'	=> esc_html__( 'Search field for products', 'nm-framework-admin' ),
	   'base'			=> 'nm_product_search',
	   'icon'			=> 'icon-wpb-woocommerce',
	   'params'			=> array(
			array(
				'type' 			=> 'checkbox',
				'heading' 		=> esc_html__( 'Search Button', 'nm-framework-admin' ),
				'param_name' 	=> 'search_button',
				'description'	=> esc_html__( 'Display search button.', 'nm-framework-admin' ),
				'value'			=> array(
					esc_html__( 'Enable', 'nm-framework-admin' ) => '1'
				),
                'std' 			=> '1'
			)
	   )
	) );
	