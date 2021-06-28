<?php
	
	// Shortcode: nm_banner
	function nm_shortcode_banner( $atts, $content = NULL ) {
		if ( function_exists( 'nm_add_page_include' ) ) {
            nm_add_page_include( 'banner' );
        }
		
		extract( shortcode_atts( array(
			'layout'			    => 'full',
			'title' 			    => '',
            'title_size'		    => 'medium',
			'title_tag'             => 'h1',
            'subtitle' 			    => '',
			'subtitle_position'     => 'below',
            'subtitle_tag'          => 'h2',
			'link_source'		    => 'custom',
			'custom_link'		    => '',
			'shop_link_title'	    => '',
			'shop_link'			    => '',
			'link_type'			    => 'banner_link',
			'text_color_scheme'	    => 'dark',
			'text_position'		    => 'h_center-v_center',
            'text_position_mobile'  => '',
			'text_alignment'	    => 'align_left',
			'text_width'		    => '',
            'text_width_units'      => '%',
			'text_padding'		    => '',
            'text_padding_units'    => '%',
			'text_animation'	    => '',
			'image_id'			    => '',
			'alt_image_id'		    => '',
			'image_type'		    => 'fluid',
            'image_viewport_height' => '',
			'height'			    => '',
            'image_loading'         => 'eager',
			'background_color'	    => ''
		), $atts ) );
		
        $banner_class = '';
        $content_output = '';
        
		// Centered content class
		$banner_class .= ( $layout == 'boxed-full-parent' ) ? 'content-boxed full-width-parent ' : 'content-' . esc_attr( $layout ) . ' ';
		
		// Background color
		$background_color_style = ( strlen( $background_color ) > 0 ) ? 'background-color: ' . esc_attr( $background_color ) . ';' : '';
		
		// Image
		$image_output = '';
		if ( strlen( $image_id ) > 0 ) {
			$image = wp_get_attachment_image_src( $image_id, 'full' );
			
			if ( $image_type == 'fluid' ) {
                //$height_style = ''; // Remove the banner height if a regular image is used
				$image_title = get_the_title( $image_id );
                $image_loading_attr = ( $image_loading == 'lazy' ) ? ' loading="lazy"' : '';
                
				$banner_class .= 'image-type-fluid';
				$image_output .= apply_filters( 'nm_banner_img_output', '<img src="' . esc_url( $image[0] ) . '" alt="' . esc_attr( $image_title ) . '"' . $image_loading_attr . ' />', $image_id );
				
				if ( strlen( $alt_image_id ) > 0 ) {
					$banner_class .= ' has-alt-image';
					$alt_image = wp_get_attachment_image_src( $alt_image_id, 'full' );
					$alt_image_title = get_the_title( $alt_image_id );
                    $image_output .= apply_filters( 'nm_banner_alt_img_output', '<img src="' . esc_url( $alt_image[0] ) . '" class="nm-banner-alt-image img" alt="' . esc_attr( $alt_image_title ) . '"' . $image_loading_attr . ' />', $alt_image_id );
				}
			} else {
				// Image height style
				$image_viewport_height = intval( $image_viewport_height );
                $image_viewport_height = ( $image_viewport_height > 0 ) ? 'height:' . $image_viewport_height . 'vh;' : '';
                $image_min_height = intval( $height );
                $image_min_height = ( $image_min_height > 0 ) ? ' min-height:' . $height . 'px;' : '';
				$height_style = $image_viewport_height . $image_min_height;
				
				$banner_class .= 'image-type-css';
				$image_output .= '<div class="nm-banner-image" style="' . $height_style . ' background-image:url(' . esc_url( $image[0] ) . ');"></div>';
				
				if ( strlen( $alt_image_id ) > 0 ) {
					$banner_class .= ' has-alt-image';
					$alt_image = wp_get_attachment_image_src( $alt_image_id, 'full' );
					$image_output .= '<div class="nm-banner-image nm-banner-alt-image" style="' . $height_style . 'background-image:url(' . esc_url( $alt_image[0] ) . ');"></div>';
				}
			}
			
			$banner_height_style = '';
		} else {
			// No image class
			$banner_class .= 'image-type-none';
			
			// Banner height style
			$banner_height_style = ( intval( $height ) > 0 ) ? 'min-height: ' . $height . 'px; ' : '';
		}
		
		// CSS animation
		if ( strlen( $text_animation ) > 0 ) {
			// Enqueue CSS animation styles
            wp_enqueue_style( 'nm-animate', NM_THEME_URI . '/assets/css/third-party/animate.min.css', array(), '1.0', 'all' );
            
            $animation_class = ' nm-animated';
			$animation_data = ' data-animate="' . esc_attr( $text_animation ) . '"';
		} else {
			$animation_class = '';
			$animation_data = '';
		}
		
		// Text classes
        $banner_class .= ' text-color-' . $text_color_scheme . ' subtitle-' . $subtitle_position;
		
		// Text
        $title = ( strlen( $title ) > 0 ) ? '<' . $title_tag . ' class="nm-banner-title">' . $title . '</' . $title_tag . '>' : '';
        $subtitle = ( strlen( $subtitle ) > 0 ) ? '<' . $subtitle_tag . ' class="nm-banner-subtitle nm-alt-font">' . $subtitle . '</' . $subtitle_tag . '>' : '';
        $content_output .= ( $subtitle_position == 'above' ) ? $subtitle . $title : $title . $subtitle;
		
		// Link
		$link_is_custom = ( $link_source == 'custom' ) ? true : false;
		$link = ( $link_is_custom ) ? $custom_link : $shop_link;
		$banner_link_open_output = $banner_link_close_output = '';
		$link_class = '';
		if ( strlen( $link ) > 0 ) {
			if ( $link_is_custom ) {
                $banner_link = nm_build_link( $link );
                $banner_link_target_attr = ( strlen( $banner_link['target'] ) > 0) ? ' target="' . esc_url( $banner_link['target'] ) . '"' : '';
			} else {
				$link_class = ' nm-banner-shop-link';
                $banner_link = array( 'title' => $shop_link_title, 'url' => $link );
                $banner_link_target_attr = '';
			}
			
			if ( $link_type === 'banner_link' ) {
                $banner_link_open_output = '<a href="' . esc_url( $banner_link['url'] ) . '" class="nm-banner-link nm-banner-link-full' . esc_attr( $link_class ) . '"' . $banner_link_target_attr . '>';
				$banner_link_close_output = '</a>';
			} else {
                $link_class .= ( $link_type == 'link_btn' ) ? ' type-btn' : ' type-txt';
                $content_output .= '<a href="' . esc_url( $banner_link['url'] ) . '" class="nm-banner-link' . esc_attr( $link_class ) . '"' . $banner_link_target_attr . '>' . $banner_link['title'] . '</a>';
			}
		}
		
		// Display banner content?
		if ( strlen( $content_output ) > 0 ) {
			// Text position array
			$text_position = explode( '-', $text_position );
					
			// Text width
			$text_styles = '';
			$text_width = intval( $text_width );
			if ( $text_width > 0 ) {
				$text_styles = 'max-width:' . $text_width . $text_width_units . ';';
			}
			
			// Text padding
			if ( strlen( $text_padding ) > 0 ) {
				$padding_h = intval( $text_padding ) . $text_padding_units;
				$padding_v = ( $text_position[1] === 'v_top' || $text_position[1] === 'v_bottom' ) ? $padding_h : '0';
							
				$text_styles .= ' padding:' . $padding_v . ' ' . $padding_h . ';';
			}
			
			// Content markup
			$content_output = '
				<div class="nm-banner-content">
					<div class="nm-banner-content-inner ' . esc_attr( $text_position[0] . ' ' . $text_position[1] . ' ' . $text_alignment ) . '">
						<div class="nm-banner-text ' . esc_attr( $title_size ) . '" style="' . esc_attr( $text_styles ) . '">
							<div class="nm-banner-text-inner' . esc_attr( $animation_class ) . '"' . $animation_data . '>' . $content_output . '</div>
						</div>
					</div>
				</div>';
            
            // Content alternative layout class
            if ( $text_position_mobile == 'alt' ) {
                $banner_class .= ' alt-mobile-layout';
            }
		}
		
		// Banner markup
		$banner_output = '
			<div class="nm-banner ' . esc_attr( $banner_class ) . '" style="' . esc_attr( $banner_height_style . $background_color_style ) . '">' .
				$banner_link_open_output .
					$image_output .
					$content_output .
				$banner_link_close_output . '
			</div>';
		
		return $banner_output;
	}
	
	add_shortcode( 'nm_banner', 'nm_shortcode_banner' );
	