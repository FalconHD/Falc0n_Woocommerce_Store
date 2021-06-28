<?php
	
	/* Helper Functions
	=============================================================== */
	
	global $nm_woocommerce_enabled;
	$nm_woocommerce_enabled = ( class_exists( 'woocommerce' ) ) ? true : false;
	
	
	/* Check if WooCommerce is activated */
	function nm_woocommerce_activated() {
		global $nm_woocommerce_enabled;
		return $nm_woocommerce_enabled;
	}
	
	
	/* Check if current request is made via AJAX */
	function nm_is_ajax_request() {
		if ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
			return true;
		}
			
		return false;
	}
	
	
	/* Check if the current page is a WooCommmerce page */
	function nm_is_woocommerce_page() {
		// Get the current body class
		$body_classes = get_body_class();
		
		foreach( $body_classes as $body_class ) {
			// Check if the class contains the word "woocommerce"
			if ( strpos( $body_class, 'woocommerce' ) !== false ) {
				return true;
			}
		}
		
		return false;
	}
	
	
	/* Add page include slug */
	function nm_add_page_include( $slug ) {
		global $nm_page_includes;
		$nm_page_includes[$slug] = true;
	}
	
	
	/* Get post categories */
	function nm_get_post_categories() {
		$args = array(
			'type'			=> 'post',
			'child_of'		=> 0,
			'parent'		=> '',
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 1,
			'exclude'		=> '',
			'include'		=> '',
			'number'		=> '',
			'taxonomy'		=> 'category',
			'pad_counts'	=> false
		);
		
		$categories = get_categories( $args );
		
		$return = array( 'All' => '' );
		
		foreach( $categories as $category ) {
            $return[wp_specialchars_decode( $category->name )] = $category->slug;
		}
		
		return $return;
	};
	
	
	/* Get social media profiles list */
	if ( ! function_exists( 'nm_get_social_profiles' ) ) {
		function nm_get_social_profiles( $wrapper_class = 'nm-social-profiles-list', $return_meta = false ) {
			global $nm_theme_options;
			
            $social_profiles_meta = array(
				'facebook'		=> array( 'title' => 'Facebook', 'icon' => 'nm-font nm-font-facebook' ),
				'instagram'		=> array( 'title' => 'Instagram', 'icon' => 'nm-font nm-font-instagram' ),
				'twitter'		=> array( 'title' => 'Twitter', 'icon' => 'nm-font nm-font-twitter' ),
                'flickr'		=> array( 'title' => 'Flickr', 'icon' => 'nm-font nm-font-flickr' ),
				'linkedin'		=> array( 'title' => 'LinkedIn', 'icon' => 'nm-font nm-font-linkedin' ),
				'pinterest'		=> array( 'title' => 'Pinterest', 'icon' => 'nm-font nm-font-pinterest' ),
                'rss'	        => array( 'title' => 'RSS', 'icon' => 'nm-font nm-font-rss-square' ),
                'snapchat'      => array( 'title' => 'Snapchat', 'icon' => 'nm-font nm-font-snapchat-ghost' ),
                'behance'		=> array( 'title' => 'Behance', 'icon' => 'nm-font nm-font-behance' ),
                'dribbble'		=> array( 'title' => 'Dribbble', 'icon' => 'nm-font nm-font-dribbble' ),
                'ebay'		    => array( 'title' => 'eBay', 'icon' => 'nm-font nm-font-ebay' ),
                'etsy'		    => array( 'title' => 'Etsy', 'icon' => 'nm-font nm-font-etsy' ),
				'line'          => array( 'title' => 'LINE', 'icon' => 'nm-font nm-font-line-app' ),
                'mixcloud'      => array( 'title' => 'MixCloud', 'icon' => 'nm-font nm-font-mixcloud' ),
                'odnoklassniki' => array( 'title' => 'OK.RU', 'icon' => 'nm-font nm-font-odnoklassniki' ),
                'soundcloud'    => array( 'title' => 'SoundCloud', 'icon' => 'nm-font nm-font-soundcloud' ),
                'spotify'       => array( 'title' => 'Spotify', 'icon' => 'nm-font nm-font-spotify' ),
                'strava'        => array( 'title' => 'Strava', 'icon' => 'nm-font nm-font-strava' ),
                'telegram'	    => array( 'title' => 'Telegram', 'icon' => 'nm-font nm-font-telegram' ),
                'tiktok'	    => array( 'title' => 'TikTok', 'icon' => 'nm-font nm-font-tiktok' ),
                'tumblr'	    => array( 'title' => 'Tumblr', 'icon' => 'nm-font nm-font-tumblr' ),
				'vimeo'	        => array( 'title' => 'Vimeo', 'icon' => 'nm-font nm-font-vimeo-square' ),
				'vk'			=> array( 'title' => 'VK', 'icon' => 'nm-font nm-font-vk' ),
				'weibo'			=> array( 'title' => 'Weibo', 'icon' => 'nm-font nm-font-weibo' ),
                'whatsapp'		=> array( 'title' => 'WhatsApp', 'icon' => 'nm-font nm-font-whatsapp' ),
				'youtube'		=> array( 'title' => 'YouTube', 'icon' => 'nm-font nm-font-youtube' ),
                'email'			=> array( 'title' => 'Email', 'icon' => 'nm-font nm-font-envelope' )
			);
            
            // Return meta array?
            if ( $return_meta ) {
                return apply_filters( 'nm_social_profiles_meta', $social_profiles_meta );
            }
            
            $social_profiles = array();
            foreach( $nm_theme_options['social_profiles'] as $slug => $url ) {
                if ( $url !== '' ) {
                    if ( $slug == 'email' ) {
                        $url = 'mailto:' . $url;
                    }
                    $social_profiles[$slug] = array( 'title' => $social_profiles_meta[$slug]['title'], 'url' => $url, 'icon' => $social_profiles_meta[$slug]['icon'] );
                }
            }
            $social_profiles = apply_filters( 'nm_social_profiles', $social_profiles );
            
            $rel_attribute = apply_filters( 'nm_social_profiles_nofollow_attr', 'rel="nofollow"' );
            
            $output = '';
			foreach ( $social_profiles as $slug => $data ) {
                $output .= '<li><a href="' . esc_url( $data['url'] ) . '" target="_blank" title="' . esc_attr( $data['title'] ) . '" ' . $rel_attribute . '><i class="' . esc_attr( $data['icon'] ) . '"></i></a></li>';
            }
			
			return '<ul class="' . $wrapper_class . '">' . $output . '</ul>';
		}
	}
	