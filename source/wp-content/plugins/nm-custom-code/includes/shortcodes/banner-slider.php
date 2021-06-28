<?php
	
	// Shortcode: nm_banner_slider
	function nm_shortcode_banner_slider( $atts, $content = NULL ) {
		if ( function_exists( 'nm_add_page_include' ) ) {
            nm_add_page_include( 'banner-slider' );
        }
		
		extract( shortcode_atts( array(
			'slider_plugin'              => 'slick',
            'adaptive_height'	         => '',
			'arrows' 			         => '',
			'pagination'		         => '',
            'pagination_alignment'       => 'left',
            'pagination_position_mobile' => 'outside',
			'pagination_color'	         => 'gray',
			'infinite'			         => '',
			'animation'			         => 'slide',
            'speed'				         => '',
			'autoplay'			         => '',
			'background_color'	         => '',
            'banner_text_parallax'       => ''
		), $atts ) );
		
        $slider_class = 'nm-banner-slider';
        
        if ( $slider_plugin == 'slick' ) {
            $slider_class .= ' plugin-slick pagination-color-' . esc_attr( $pagination_color ) . ' slick-slider';
            $slick_options = array();
            
            // Adaptive Height
            if ( strlen( $adaptive_height ) > 0 ) { $slick_options['adaptive-height'] = 'true'; }
            // Arrows
            if ( strlen( $arrows ) > 0 ) { $slick_options['arrows'] = 'true'; }
            // Pagination
            if ( strlen( $pagination ) > 0 ) {
                $slider_class .= ' slick-dots-inside has-pagination pagination-mobile-' . $pagination_position_mobile . ' pagination-' . $pagination_alignment;
                $slick_options['dots'] = 'true';
            } else {
                $slider_class .= ' slick-dots-disabled';
            }
            // Animation
            if ( $animation != 'slide' ) { $slick_options['fade'] = 'true'; }
            // Speed
            if ( strlen( $speed ) > 0 ) { $slick_options['speed'] = intval( $speed ); }
            // Autoplay
            if ( strlen( $autoplay ) > 0 ) { $slick_options['autoplay'] = 'true'; $slick_options['autoplay-speed'] = intval( $autoplay ); }
            // Infinite loop
            if ( strlen( $infinite ) > 0 ) { $slick_options['infinite'] = 'true'; }
            
            // Make it possible to change settings via filter-hook
            $slick_options = apply_filters( 'nm_banner_slider_slick_options', $slick_options );
            
            // Create options data string
            $slider_settings_data = '';
            foreach( $slick_options as $option => $value ) {
                $slider_settings_data .= ' data-' . $option . '="' . $value . '"';
            }
        } else {
            // Enqueue Flickity script (styles are included in "style.css")
            wp_enqueue_script( 'flickity', NM_THEME_URI . '/assets/js/plugins/flickity.pkgd.min.js', array(), '2.2.1', true );
            
            $slider_class .= ' plugin-flickity pagination-color-' . esc_attr( $pagination_color );
            $flickity_options = array();		        
            
            // Adaptive Height
            if ( strlen( $adaptive_height ) > 0 ) { $flickity_options['adaptiveHeight'] = true; }
            // Arrows
            if ( strlen( $arrows ) == 0 ) { $flickity_options['prevNextButtons'] = false; }
            // Pagination
            if ( strlen( $pagination ) == 0 ) {
                $flickity_options['pageDots'] = false;
            } else {
                $slider_class .= ' has-pagination pagination-mobile-' . $pagination_position_mobile . ' pagination-' . $pagination_alignment;
            }
            // Autoplay
            if ( strlen( $autoplay ) > 0 ) { $flickity_options['autoPlay'] = intval( $autoplay ); }
            // Infinite loop
            if ( strlen( $infinite ) > 0 ) { $flickity_options['wrapAround'] = true; }
            // Banner text: Parallax
            if ( strlen( $banner_text_parallax ) > 0 ) { $slider_class .= ' has-text-parallax'; }
            
            // Make it possible to change settings via filter-hook
            $flickity_options = apply_filters( 'nm_banner_slider_flickity_options', $flickity_options );
            
            $slider_settings_data = " data-options='" . json_encode( $flickity_options ) . "'";
        }
        
		// Background color
		$background_color_style = ( strlen( $background_color ) > 0 ) ? 'style="background-color:' . esc_attr( $background_color ) . '"' : '';
				
		$output = '<div class="' . esc_attr( $slider_class ) . '"' . $slider_settings_data . $background_color_style . '>' . do_shortcode( $content ) . '</div>';
						
		return $output;
	}
	
	add_shortcode( 'nm_banner_slider', 'nm_shortcode_banner_slider' );
	