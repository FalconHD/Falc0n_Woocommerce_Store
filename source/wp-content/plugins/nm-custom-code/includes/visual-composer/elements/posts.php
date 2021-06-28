<?php
	
	// VC element: nm_posts
    vc_map( array(
        'name'			=> __( 'Posts', 'nm-framework-admin' ),
        'category'		=> __( 'Content', 'nm-framework-admin' ),
        'description'	=> __( 'Display posts from the blog', 'nm-framework-admin' ),
        'base'			=> 'nm_posts',
        'icon'			=> 'nm_posts',
        'params'			=> array(
            array(
                'type' 			=> 'textfield',
                'heading' 		=> __( 'Number of Posts', 'nm-framework-admin' ),
                'param_name' 	=> 'num_posts',
                'description' 	=> __( 'Enter max number of posts to display.', 'nm-framework-admin' ),
                'value' 		=> '4'
            ),
            array(
                'type' 			=> 'dropdown',
                'heading' 		=> __( 'Columns', 'nm-framework-admin' ),
                'param_name' 	=> 'columns',
                'description'	=> __( 'Select number of columns to display.', 'nm-framework-admin' ),
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
                'heading' 		=> __( 'Order By', 'nm-framework-admin' ),
                'param_name' 	=> 'orderby',
                'description'	=> __( 'Select posts order-by.', 'nm-framework-admin' ),
                'value' 		=> array(
                    'None'          => 'none',
                    'ID'            => 'ID',
                    'Author'        => 'author',
                    'Title'         => 'title',
                    'Name'          => 'name',
                    'Date'          => 'date',
                    'Random'        => 'rand',
                    'Commen Count'  => 'comment_count',
                    'Menu Order'    => 'menu_order',
                    'IDs Option'    => 'post__in'
                ),
                'std' 			=> 'none'
            ),
            array(
                'type' 			=> 'dropdown',
                'heading' 		=> __( 'Order', 'nm-framework-admin' ),
                'param_name' 	=> 'order',
                'description'	=> __( 'Select posts order.', 'nm-framework-admin' ),
                'value'			=> array(
                    'Descending'	=> 'desc',
                    'Ascending'		=> 'asc'
                ),
                'std'			=> 'asc'
            ),
            array(
                'type' 			=> 'dropdown',
                'heading' 		=> __( 'Category', 'nm-framework-admin' ),
                'param_name' 	=> 'category',
                'description'	=> __( 'Filter by post category.', 'nm-framework-admin' ),
                'value' 		=> ( function_exists( 'nm_get_post_categories' ) ) ? nm_get_post_categories() : array()
            ),
            array(
                'type' 			=> 'textfield',
                'heading' 		=> __( 'IDs', 'nm-framework-admin' ),
                'param_name' 	=> 'ids',
                'description'	=> __( 'Filter posts by entering a comma separated list of IDs.', 'nm-framework-admin' )
            ),
            array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Image Type', 'nm-framework-admin' ),
				'param_name' 	=> 'image_type',
				'description'	=> __( 'Select image type.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Standard image'       => 'standard',
					'CSS background image' => 'background'
				),
				'std' 			=> 'standard'
			),
            array(
                'type' 			=> 'checkbox',
                'heading' 		=> __( 'Post Excerpt', 'nm-framework-admin' ),
                'param_name' 	=> 'post_excerpt',
                'description'	=> __( 'Display post excerpt.', 'nm-framework-admin' ),
                'value'			=> array(
                    __( 'Enable', 'nm-framework-admin' )	=> '1'
                )
            )
        )
    ) );