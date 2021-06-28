<?php
    
// VC element: product_categories
vc_map(array(
    'name'			=> esc_html__( 'Product Categories', 'nm-framework-admin' ),
    'category'		=> esc_html__( 'WooCommerce', 'nm-framework-admin' ),
    'description'	=> esc_html__( 'Product Categories', 'nm-framework-admin' ),
    'base'			=> 'nm_product_categories',
    'icon'			=> 'icon-wpb-woocommerce',
    'params'			=> array(
        array(
            'type' 			=> 'textfield',
            'heading' 		=> esc_html__( 'Categories to Display', 'nm-framework-admin' ),
            'param_name' 	=> 'number',
            'description'	=> esc_html__( 'Enter the number of product categories to display.', 'nm-framework-admin' )
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
            'description'	=> esc_html__( 'Select categories order-by.', 'nm-framework-admin' ),
            'value'			=> array(
                'None'			=> 'none',
                'ID'			=> 'id',
                'Name'			=> 'name',
                'Product Count' => 'count',
                //'Menu Order'	=> 'term_order',
                'Menu Order'	=> 'menu_order',
                '"IDs" Setting' => 'include'
            ),
            'std'			=> 'name'
        ),
        array(
            'type' 			=> 'dropdown',
            'heading' 		=> esc_html__( 'Order', 'nm-framework-admin' ),
            'param_name' 	=> 'order',
            'description'	=> esc_html__( 'Select categories order.', 'nm-framework-admin' ),
            'value'			=> array(
                'Descending'	=> 'DESC',
                'Ascending'		=> 'ASC'
            ),
            'std'			=> 'ASC'
        ),
        array(
            'type' 			=> 'dropdown',
            'heading' 		=> esc_html__( 'Hide Empty', 'nm-framework-admin' ),
            'param_name' 	=> 'hide_empty',
            'description'	=> esc_html__( 'Hide empty categories.', 'nm-framework-admin' ),
            'value'			=> array(
                'Yes'	=> '1',
                'No'	=> '0'
            ),
            'std'			=> '1'
        ),
        array(
            'type' 			=> 'textfield',
            'heading' 		=> esc_html__( 'Parent', 'nm-framework-admin' ),
            'param_name' 	=> 'parent',
            'description'	=> esc_html__( 'Enter 0 to only display top level categories.', 'nm-framework-admin' )
        ),
        array(
            'type' 			=> 'textfield',
            'heading' 		=> esc_html__( "IDs", 'nm-framework-admin' ),
            'param_name' 	=> 'ids',
            'description'	=> esc_html__( "Filter categories by entering a comma separated list of IDs.", 'nm-framework-admin' )
        ),
        array(
            'type' 			=> 'dropdown',
            'heading' 		=> esc_html__( 'Title Layout', 'nm-framework-admin' ),
            'param_name' 	=> 'layout',
            'description'	=> esc_html__( 'Select layout of category title(s).', 'nm-framework-admin' ),
            'value' 		=> array(
                'Default'   => 'default',
                'Separated' => 'separated'
            ),
            'std' 			=> 'default'
        ),
        array(
            'type' 			=> 'dropdown',
            'heading' 		=> esc_html__( 'Title Tag', 'nm-framework-admin' ),
            'param_name' 	=> 'title_tag',
            'description'	=> esc_html__( 'Select heading-tag for the category titles.', 'nm-framework-admin' ),
            'value' 		=> array(
                'h1'   => 'h1',
                'h2'   => 'h2',
                'h3'   => 'h3',
                'h4'   => 'h4',
                'h5'   => 'h5',
                'h6'   => 'h6'
            ),
            'std' 			=> 'h1'
        ),
        array(
            'type' 			=> 'checkbox',
            'heading' 		=> esc_html__( 'Masonry Grid', 'nm-framework-admin' ),
            'param_name' 	=> 'packery',
            'description'	=> esc_html__( 'Enable masonry grid layout.', 'nm-framework-admin' ),
            'value'			=> array(
                esc_html__( 'Enable', 'nm-framework-admin' ) => '1'
            )
        )
    )
));
