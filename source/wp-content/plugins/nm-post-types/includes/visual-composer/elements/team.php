<?php
	
	// VC element: nm_team
	vc_map( array(
	   'name'			=> __( 'Team', 'nm-post-types' ),
	   'category'		=> __( 'Content', 'nm-post-types' ),
	   'description'	=> __( 'Team members grid', 'nm-post-types' ),
	   'base'			=> 'nm_team',
	   'icon'			=> 'nm_team',
	   'params'			=> array(
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> __('Columns', 'nm-post-types' ),
				'param_name' 	=> 'columns',
				'description'	=> __( 'Select columns.', 'nm-post-types' ),
				'value' 		=> array(
					'2'	=> '2',
					'3'	=> '3',
					'4'	=> '4',
					'5'	=> '5'
				)
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> __( 'Items', 'nm-post-types' ),
				'param_name' 	=> 'items',
				'description'	=> __( 'Number of items to display.', 'nm-post-types' )
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Image Style', 'nm-post-types' ),
				'param_name' 	=> 'image_style',
				'description'	=> __( 'Select an image style.', 'nm-post-types' ),
				'value' 		=> array(
					'Default'	=> 'default',
					'Rounded'	=> 'rounded'
				)
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Order By', 'nm-framework-admin' ),
				'param_name' 	=> 'orderby',
				'description'	=> __( 'Select members order-by.', 'nm-framework-admin' ),
				'value'			=> array(
					'None'			=> 'none',
					'ID'			=> 'ID',
					'Name'			=> 'name',
					'Date'			=> 'date',
					'Menu Order'	=> 'menu_order',
					'Random'		=> 'rand'
				),
				'std'			=> 'name'
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Order', 'nm-framework-admin' ),
				'param_name' 	=> 'order',
				'description'	=> __( 'Select members order.', 'nm-framework-admin' ),
				'value'			=> array(
					'Descending'	=> 'desc',
					'Ascending'		=> 'asc'
				),
				'std'			=> 'asc'
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> __( "IDs", 'nm-framework-admin' ),
				'param_name' 	=> 'ids',
				'description'	=> __( "Filter members by entering a comma separated list of member/post IDs.", 'nm-framework-admin' )
			)
	   )
	) );
	