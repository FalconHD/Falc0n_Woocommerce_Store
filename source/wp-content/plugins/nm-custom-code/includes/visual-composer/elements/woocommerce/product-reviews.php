<?php
    
// VC element: nm_product_reviews
vc_map(array(
    'name'			=> esc_html__( 'Product Reviews', 'nm-framework-admin' ),
    'category'		=> esc_html__( 'WooCommerce', 'nm-framework-admin' ),
    'description'	=> esc_html__( 'Product Reviews', 'nm-framework-admin' ),
    'base'			=> 'nm_product_reviews',
    'icon'			=> 'icon-wpb-woocommerce',
    'params'			=> array(
        array(
            'type' 			=> 'textfield',
            'heading' 		=> esc_html__( 'Product ID (optional)', 'nm-framework-admin' ),
            'param_name' 	=> 'product_id',
            'description'	=> esc_html__( 'Enter an ID to display reviews from a single product.', 'nm-framework-admin' )
        ),
        array(
            'type' 			=> 'textfield',
            'heading' 		=> esc_html__( 'Reviews to Display', 'nm-framework-admin' ),
            'param_name' 	=> 'number',
            'description'	=> esc_html__( 'Enter the number of reviews to display.', 'nm-framework-admin' ),
            'std'			=> '8'
        ),
        array(
            'type' 			=> 'dropdown',
            'heading' 		=> esc_html__( 'Layout', 'nm-framework-admin' ),
            'param_name' 	=> 'layout',
            'value' 		=> array(
                'Default'   => 'default',
                'Centered'  => 'centered'
            ),
            'std'			=> 'default'
        ),
        array(
            'type' 			=> 'dropdown',
            'heading' 		=> esc_html__( 'Columns', 'nm-framework-admin' ),
            'param_name' 	=> 'columns',
            'description'	=> esc_html__( 'Select number of columns.', 'nm-framework-admin' ),
            'value' 		=> array(
                '1'	=> '1',
                '2'	=> '2',
                '3'	=> '3',
                '4'	=> '4',
                '5'	=> '5',
                '6'	=> '6'
            ),
            'std'			=> '4'
        ),
        array(
            'type' 			=> 'dropdown',
            'heading' 		=> esc_html__( 'Order By', 'nm-framework-admin' ),
            'param_name' 	=> 'orderby',
            'description'	=> esc_html__( 'Order reviews by.', 'nm-framework-admin' ),
            'value'			=> array(
                'Review Author'     => 'comment_author',
                'Review Date'       => 'comment_date',
                'Review Date GMT'   => 'comment_date_gmt',
                'Review ID'         => 'comment_ID',
                'Product ID'        => 'comment_post_ID',
                'User ID'           => 'user_id',
            ),
            'std'			=> 'comment_date_gmt'
        ),
        array(
            'type' 			=> 'dropdown',
            'heading' 		=> esc_html__( 'Order', 'nm-framework-admin' ),
            'param_name' 	=> 'order',
            'description'	=> esc_html__( 'Reviews order.', 'nm-framework-admin' ),
            'value'			=> array(
                'Descending'	=> 'DESC',
                'Ascending'		=> 'ASC'
            ),
            'std'			=> 'DESC'
        ),
        array(
            'type' 			=> 'checkbox',
            'heading' 		=> esc_html__( 'Product Thumbnail', 'nm-framework-admin' ),
            'param_name' 	=> 'thumbnail',
            'description'	=> esc_html__( 'Display product thumbnail.', 'nm-framework-admin' ),
            'value'			=> array(
                esc_html__( 'Enable', 'nm-framework-admin' ) => '1'
            )
        ),
        array(
            'type' 			=> 'checkbox',
            'heading' 		=> esc_html__( 'Product Title/Link', 'nm-framework-admin' ),
            'param_name' 	=> 'title',
            'description'	=> esc_html__( 'Display product title/link.', 'nm-framework-admin' ),
            'value'			=> array(
                esc_html__( 'Enable', 'nm-framework-admin' ) => '1'
            ),
            'std'			=> '1'
        ),
        array(
            'type' 			=> 'checkbox',
            'heading' 		=> esc_html__( 'Total Reviews Score', 'nm-framework-admin' ),
            'param_name' 	=> 'total',
            'description'	=> esc_html__( 'Display total reviews score.', 'nm-framework-admin' ),
            'value'			=> array(
                esc_html__( 'Enable', 'nm-framework-admin' ) => '1'
            )
        ),
        array(
            'type' 			=> 'checkbox',
            'heading' 		=> esc_html__( 'Slider', 'nm-framework-admin' ),
            'param_name' 	=> 'slider',
            'description'	=> esc_html__( 'Enable slider.', 'nm-framework-admin' ),
            'value'			=> array(
                esc_html__( 'Enable', 'nm-framework-admin' ) => '1'
            )
        ),
        array(
            'type' 			=> 'checkbox',
            'heading' 		=> esc_html__( 'Slider: Arrows', 'nm-framework-admin' ),
            'param_name' 	=> 'arrows',
            'description'	=> esc_html__( 'Display "prev" and "next" arrows.', 'nm-framework-admin' ),
            'value'			=> array(
                esc_html__( 'Enable', 'nm-framework-admin' )	=> '1'
            ),
            'dependency'	=> array(
                'element'	=> 'slider',
                'value'		=> array( '1' )
            )
        ),
        array(
            'type' 			=> 'textfield',
            'heading' 		=> __( 'Slider: Autoplay', 'nm-framework-admin' ),
            'param_name' 	=> 'autoplay',
            'description'	=> __( 'Enter autoplay interval in milliseconds (1 second = 1000 milliseconds).', 'nm-framework-admin' ),
            'dependency'	=> array(
                'element'	=> 'slider',
                'value'		=> array( '1' )
            )
        ),
        array(
            'type' 			=> 'checkbox',
            'heading' 		=> __( 'Slider: Infinite Loop', 'nm-framework-admin' ),
            'param_name' 	=> 'infinite',
            'description'	=> __( 'Infinite loop sliding.', 'nm-framework-admin' ),
            'value'			=> array(
                __( 'Enable', 'nm-framework-admin' )	=> '1'
            ),
            'dependency'	=> array(
                'element'	=> 'slider',
                'value'		=> array( '1' )
            )
        )
    )
));
