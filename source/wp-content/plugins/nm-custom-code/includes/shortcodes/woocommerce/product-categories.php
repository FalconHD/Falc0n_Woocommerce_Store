<?php
    
	// Shortcode: nm_product_categories
	function nm_shortcode_product_categories( $atts, $content = NULL ) {
		if ( function_exists( 'nm_add_page_include' ) ) {
            nm_add_page_include( 'product_categories' );
        }
		
		global $nm_globals, $woocommerce_loop;
		
        // Global settings
        $nm_globals['is_categories_shortcode'] = true;
        $nm_globals['categories_shortcode_heading_tag'] = isset( $atts['title_tag'] ) ? $atts['title_tag'] : 'h1'; // Categories heading tag
        
		// Set column sizes via the $woocommerce_loop global (large column is set via shortcode attribute)
		$woocommerce_loop['columns_xsmall'] = '1';
        if ( intval( $atts['columns'] ) > 4 ) {
            $woocommerce_loop['columns_small'] = '2';
            $woocommerce_loop['columns_medium'] = '3';
        } else {
            $woocommerce_loop['columns_small'] = '1';
            $woocommerce_loop['columns_medium'] = '2';
        }
		
        // Order by: Change old "term_order" option (not supported anymore)
        if ( isset( $atts['orderby'] ) && $atts['orderby'] == 'term_order' ) {
            $atts['orderby'] = 'menu_order';
        }
        
        // Order: Make sure option is uppercase
        if ( isset( $atts['order'] ) ) {
            $atts['order'] = strtoupper( $atts['order'] );
        }
        
        // Hide empty
        $atts['hide_empty'] = ( isset( $atts['hide_empty'] ) ) ? '1' : '0';
        
        $class = '';
        
        // Layout
        $class .= ( isset( $atts['layout'] ) ) ? 'layout-' . $atts['layout'] : 'layout-default';
        
        // Packery grid
        if ( isset( $atts['packery'] ) && $atts['packery'] === '1' ) {
			if ( function_exists( 'nm_add_page_include' ) ) {
                nm_add_page_include( 'product_categories_masonry' );
            }
			
			$class .= ' masonry-enabled nm-loader';
		}
		
        if ( class_exists( 'WC_Shortcodes' ) ) {
            return '<div class="nm-product-categories ' . esc_attr( $class ) . '">' . WC_Shortcodes::product_categories( $atts ) . '</div>';
        }
	}
	
	add_shortcode( 'nm_product_categories', 'nm_shortcode_product_categories' );
	