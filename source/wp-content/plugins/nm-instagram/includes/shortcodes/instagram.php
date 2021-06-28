<?php
    /*
     *  Shortcode: nm_instagram - Get template directory
     */
    function nm_shortcode_instagram_template_dir( $file ) {
        // Get theme/child-theme directory
        $theme_template = get_stylesheet_directory() . '/' . $file;

        // Does a file exist in the child-theme directory?
        if ( file_exists( $theme_template ) ) {
            return $theme_template;
        } else {
            return NM_INSTAGRAM_DIR . '/templates/' . $file;
        }
    }
    
    
	/*
     *  Shortcode: nm_instagram
     */
	function nm_shortcode_instagram( $atts, $content = NULL ) {
        global $nm_instagram_gallery;
        $nm_instagram_gallery = array(
            'atts'  => array(),
            'items' => array()
        );
        
        $atts = shortcode_atts( array(
			'username_hashtag'          => '',
            'image_limit'               => 6,
			'images_per_row'            => 6,
            'image_size'                => 'medium',
            'image_aspect_ratio_class'  => 'aspect-ratio-square',
            'image_spacing_class'       => '',
            'transient_time'            => DAY_IN_SECONDS,
            'instagram_user_link'       => ''
		), $atts );
        
        // NOTE; Image size must be set to "original" currently ("../media?size=..." image URLs doesn't work anymore)
        $atts['image_size'] = 'original';
        
        // Get Instagram API
        $api = NM_Instagram_API::getInstance();
        // Get Instagram items/images
        $items = $api->get_items( $atts['username_hashtag'], $atts['image_limit'], $atts['image_limit'] );
        
        if ( isset( $items['error'] ) ) {
            $output = '<p class="nm-instagram-gallery-error">' . wp_kses_post( $items['error'] ) . '</p>';
		} else {
            if ( ! empty( $items ) ) {
                $nm_instagram_gallery['atts'] = $atts;
                $nm_instagram_gallery['items'] = $items;
                $nm_instagram_gallery['follow_link'] = $api->get_follow_link( $atts['username_hashtag'] );
                
                // Include gallery template
                $gallery_template_dir = nm_shortcode_instagram_template_dir( 'nm-instagram-gallery.php' );
                
                ob_start();
                include( $gallery_template_dir );
                $output = ob_get_clean();
            } else {
                $output = '<p class="nm-instagram-gallery-error">' . esc_html__( 'No images available from Instagram.', 'nm-instagram' ) . '</p>';
            }
		}
        
        return $output;
	}
	
	add_shortcode( 'nm_instagram', 'nm_shortcode_instagram' );