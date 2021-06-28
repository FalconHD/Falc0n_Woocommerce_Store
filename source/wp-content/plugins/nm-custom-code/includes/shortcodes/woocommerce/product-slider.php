<?php
	
	// Shortcode: nm_product_slider
	function nm_shortcode_product_slider( $atts, $content = NULL ) {
		if ( function_exists( 'nm_add_page_include' ) ) {
            nm_add_page_include( 'product-slider' );
        }
		
		extract( shortcode_atts( array(
			'shortcode'  	    => 'products',
            'category'          => '',
			'per_page'          => '12',
			'columns'	        => '4',
            'columns_mobile'    => '1',
			'orderby'	        => 'date',
			'order'		        => 'DESC',
            'arrows'            => '',
            'autoplay'          => '',
            'infinite'          => ''
		), $atts ) );
		
        $columns_escaped = intval( $columns );
        $columns_mobile_escaped = intval( $columns_mobile );
        
        // Add category slug attribute (ID doesn't work anymore)
        $category_param = ( $shortcode == 'product_category' ) ? ' category="' . esc_attr( $category ) . '"' : '';
        
        // Convert deprecated WooCommerce shortcodes to "type" or "visibility" attribute: https://docs.woocommerce.com/document/woocommerce-shortcodes/#section-10
        $shortcode_to_type = array(
            'products'              => '',
            'recent_products'       => '',
            'featured_products'     => 'featured',
            'sale_products'         => 'on_sale',
            'best_selling_products' => 'best_selling',
            'top_rated_products'    => 'top_rated',
            'product_category'      => '',
        );
        if ( isset( $shortcode_to_type[$shortcode] ) && ! empty( $shortcode_to_type[$shortcode] ) ) {
            $type_param = ( $shortcode_to_type[$shortcode] == 'featured' ) ? ' visibility="featured"' : ' ' . $shortcode_to_type[$shortcode] . '="true"';
        } else {
            $type_param = '';
        };
        
        // Slider settings
        $slider_settings = array( 'slides-to-show' => $columns_escaped, 'slides-to-scroll' => $columns_escaped, 'slides-to-show-mobile' => $columns_mobile_escaped );
        if ( $arrows !== '' ) { $slider_settings['arrows'] = 'true'; }
        if ( strlen( $autoplay ) > 0 ) { $slider_settings['autoplay'] = 'true'; $slider_settings['autoplay-speed'] = intval( $autoplay ); }
        if ( strlen( $infinite ) > 0 ) { $slider_settings['infinite'] = 'true'; }
        $slider_settings = apply_filters( 'nm_product_slider_settings', $slider_settings ); // Make it possible to change settings via filter-hook
        
        // Slider settings: Create data attributes string
        $slider_settings_data = '';
        foreach( $slider_settings as $setting => $value ) {
            $slider_settings_data .= ' data-' . $setting . '="' . $value . '"';
        }
        
        $shortcode_string = '[products limit="' . intval( $per_page ) . '" columns="' . $columns_escaped . '" orderby="' . $orderby . '" order="' . $order . '"' . $category_param . $type_param . ']';
        
        return '<div class="nm-product-slider col-' . $columns_escaped . '"' . $slider_settings_data . '>' . do_shortcode( $shortcode_string ) . '</div>';
	}
	
	add_shortcode( 'nm_product_slider', 'nm_shortcode_product_slider' );
	