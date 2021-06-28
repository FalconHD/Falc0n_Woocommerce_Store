<?php
	// VC element: nm_portfolio
	vc_map( array(
	   'name'			=> __( 'Portfolio', 'nm-portfolio' ),
	   'category'		=> __( 'Content', 'nm-portfolio' ),
	   'description'	=> __( 'Portfolio grid', 'nm-portfolio' ),
	   'base'			=> 'nm_portfolio',
       'icon'			=> 'nm_portfolio',
	   'params'			=> array(
            array(
				'type' 			=> 'checkbox',
				'heading' 		=> __( 'Categories', 'nm-portfolio' ),
				'param_name' 	=> 'categories',
				'description'	=> __( 'Display category menu.', 'nm-portfolio' ),
				'value'			=> array(
					__( 'Enable', 'nm-portfolio' ) => '1'
				),
				'std'			=> '0'
			),
            array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Categories - Alignment', 'nm-portfolio' ),
				'param_name' 	=> 'categories_alignment',
				'description'	=> __( 'Select category menu alignment.', 'nm-portfolio' ),
				'value' 		=> array(
					'Left'		=> 'left',
					'Center'	=> 'center',
					'Right'		=> 'right'
				),
				'dependency'	=> array(
					'element'	=> 'categories',
					'value'		=> array( '1' )
				),
				'std'			=> 'left'
			),
            array(
				'type' 			=> 'checkbox',
				'heading' 		=> __( 'Categories - Animated Sorting', 'nm-portfolio' ),
				'param_name' 	=> 'categories_js',
				'description'	=> __( 'Animated category sorting.', 'nm-portfolio' ),
				'value'			=> array(
					__( 'Enable', 'nm-portfolio' ) => '1'
				),
                'dependency'	=> array(
					'element'	=> 'categories',
					'value'		=> array( '1' )
				),
				'std'			=> '0'
			),
            array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Layout', 'nm-portfolio' ),
				'param_name' 	=> 'layout',
				'description'	=> __( 'Select portfolio layout.', 'nm-portfolio' ),
				'value' 		=> array(
					'Standard'	=> 'standard',
					'Overlay'	=> 'overlay'
				),
				'std'			=> 'standard'
            ),
            array(
				'type' 			=> 'checkbox',
				'heading' 		=> __( 'Masonry Grid', 'nm-portfolio' ),
				'param_name' 	=> 'packery',
				'description'	=> __( 'Enable "masonry" grid layout.', 'nm-portfolio' ),
				'value'			=> array(
					__( 'Enable', 'nm-portfolio' ) => '1'
				),
				'std'			=> '0'
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> __( 'Items', 'nm-portfolio' ),
				'param_name' 	=> 'items',
				'description'	=> __( 'Number of items to display (leave blank for unlimited).', 'nm-portfolio' ),
				'std'			=> ''
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Items per Row', 'nm-portfolio' ),
				'param_name' 	=> 'columns',
				'description'	=> __( 'Select number of items per row.', 'nm-portfolio' ),
				'value' 		=> array(
					'2'	=> '2',
					'3'	=> '3',
					'4'	=> '4'
				),
				'std'			=> '2'
			),
			array(
				'type' 			=> 'textfield',
                'heading'       => __( "Category (optional)", 'nm-portfolio' ),
				'param_name' 	=> 'category',
                'description'   => __( "Enter slug-name for portfolio category to display.", 'nm-portfolio' ),
				'value' 		=> ''
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> __( 'Item IDs (optional)', 'nm-portfolio' ),
				'param_name' 	=> 'ids',
				'description'	=> __( 'Enter comma separated IDs of portfolio items to display.', 'nm-portfolio' )
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Order By', 'nm-portfolio' ),
				'param_name' 	=> 'order_by',
				'description'	=> __( 'Order portfolio items by.', 'nm-portfolio' ),
				'value' 		=> array(
					'Date'		=> 'date',
					'Title' 	=> 'title',
					'Random'	=> 'rand'
				),
				'std'			=> 'date'
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Order', 'nm-portfolio' ),
				'param_name' 	=> 'order',
				'description'	=> __( 'Portfolio items order.', 'nm-portfolio' ),
				'value' 		=> array(
					'Descending'	=> 'desc',
					'Ascending'		=> 'asc'
				),
				'std'			=> 'desc'
			)
	   )
	) );
	