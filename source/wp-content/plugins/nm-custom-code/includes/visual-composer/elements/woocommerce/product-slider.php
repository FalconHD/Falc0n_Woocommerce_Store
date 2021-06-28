<?php
	
	// VC element: nm_product_slider
	vc_map( array(
		'name' 			=> esc_html__( 'Product Slider', 'nm-framework-admin' ),
		'category' 		=> esc_html__( 'WooCommerce', 'nm-framework-admin' ),
		'description'	=> esc_html__( 'Display product slider', 'nm-framework-admin' ),
		'base' 			=> 'nm_product_slider',
		'icon' 			=> 'icon-wpb-woocommerce',
		'params' 		=> array(
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Type', 'nm-framework-admin' ),
				'param_name' 	=> 'shortcode',
				'description' 	=> esc_html__( 'Select type of products to display.', 'nm-framework-admin' ),
				'value' 		=> array(
					esc_html__( 'All', 'nm-framework-admin' )				    => 'products',
                    esc_html__( 'Recent', 'nm-framework-admin' )				=> 'recent_products',
					esc_html__( 'Featured Products', 'nm-framework-admin' )		=> 'featured_products',
					esc_html__( 'Sale Products', 'nm-framework-admin' )			=> 'sale_products',
					esc_html__( 'Best Selling Products', 'nm-framework-admin' )	=> 'best_selling_products',
					esc_html__( 'Top Rated Products', 'nm-framework-admin' )	=> 'top_rated_products',
                    esc_html__( 'Product Category', 'nm-framework-admin' )      => 'product_category',
				),
				'std'           => 'recent_products',
                'save_always' 	=> true
			),
            array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Category Slug(s)', 'nm-framework-admin' ),
				'param_name' 	=> 'category',
                'description' 	=> esc_html__( 'Comma-separated list of category slugs.', 'nm-framework-admin' ),
				'dependency'	=> array(
					'element'	=> 'shortcode',
					'value'		=> array( 'product_category' )
				)
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Per page', 'nm-framework-admin' ),
				'value' 		=> 12,
				'param_name' 	=> 'per_page',
				'description' 	=> esc_html__( 'The "per_page" shortcode determines how many products to show on the page', 'nm-framework-admin' ),
				'std'           => '12',
                'save_always'	=> true
			),
			array(
                'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Columns', 'nm-framework-admin' ),
				'value' 		=> 4,
				'param_name' 	=> 'columns',
				'description'	=> esc_html__( 'The columns attribute controls how many columns wide the products should be before wrapping.', 'nm-framework-admin' ),
				'value' 		=> array(
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6'
				),
                'std'           => '4',
                'save_always'	=> true
			),
            array(
                'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Columns - Mobile', 'nm-framework-admin' ),
				'value' 		=> 1,
				'param_name' 	=> 'columns_mobile',
				'value' 		=> array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3'
				),
                'std'           => '1',
                'save_always'	=> true
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Order by', 'nm-framework-admin' ),
				'param_name' 	=> 'orderby',
				'description' 	=> sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'nm-framework-admin' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
				'value' 		=> array(
                    esc_html__( 'Date', 'nm-framework-admin' )          => 'date',
                    esc_html__( 'Title', 'nm-framework-admin' )         => 'title',
					esc_html__( 'ID', 'nm-framework-admin' )            => 'id',
                    esc_html__( 'Menu order', 'nm-framework-admin' )    => 'menu_order',
                    esc_html__( 'Popularity', 'nm-framework-admin' )    => 'popularity',
					esc_html__( 'Random', 'nm-framework-admin' )        => 'rand',
                    esc_html__( 'Rating', 'nm-framework-admin' )        => 'rating',
                    //esc_html__( 'Author', 'nm-framework-admin' ) => 'author',
                    //esc_html__( 'Modified', 'nm-framework-admin' ) => 'modified',
                    //esc_html__( 'Comment count', 'nm-framework-admin' ) => 'comment_count',
				),
				'std'           => 'date',
                'save_always' 	=> true
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Sort order', 'nm-framework-admin' ),
				'param_name' 	=> 'order',
				'description' 	=> sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'nm-framework-admin' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
				'value' 		=> array(
					esc_html__( 'Descending', 'nm-framework-admin' )	=> 'DESC',
					esc_html__( 'Ascending', 'nm-framework-admin' )	=> 'ASC'
				),
				'std' => 'DESC',
                'save_always' 	=> true
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