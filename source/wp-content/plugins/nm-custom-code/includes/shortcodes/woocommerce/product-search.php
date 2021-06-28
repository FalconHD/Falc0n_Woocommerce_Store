<?php
	
	// Shortcode: nm_product_search
	function nm_shortcode_product_search( $atts, $content = NULL ) {
		extract( shortcode_atts( array(
			'search_button'  => '1'
		), $atts ) );
		
        $search_button_html = ( $search_button ) ? '<button type="submit" role="button" class="search-submit"><i class="nm-font nm-font-search-alt"></i></button>' : '';
        
		return '
            <div class="nm-product-search">
                <form role="search" method="get" action="' . esc_url( home_url( '/' ) ) . '">
                    <input type="text" id="nm-shop-search-input" autocomplete="off" value="" name="s" placeholder="' . esc_html__( 'Search store', 'nm-framework' ) . '" />' .
                    $search_button_html . '
                    <input type="hidden" name="post_type" value="product" />
                </form>
            </div>';
	}
	
	add_shortcode( 'nm_product_search', 'nm_shortcode_product_search' );
    