<?php
	
	// Shortcode: nm_social_profiles
	function nm_shortcode_social_profiles( $atts, $content = NULL ) {
		extract( shortcode_atts( array(
			'social_profile_facebook'	    => '',
			'social_profile_instagram'	    => '',
			'social_profile_twitter'	    => '',
            'social_profile_flickr'         => '',
            'social_profile_linkedin'	    => '',
			'social_profile_pinterest'	    => '',
			'social_profile_rss'		    => '',
            'social_profile_snapchat'       => '',
            'social_profile_behance'        => '',
            'social_profile_dribbble'       => '',
            'social_profile_line'           => '',
            'social_profile_mixcloud'       => '',
            'social_profile_odnoklassniki'  => '',
            'social_profile_soundcloud'     => '',
            'social_profile_telegram'       => '',
            'social_profile_tiktok'		    => '',
            'social_profile_tumblr'		    => '',
			'social_profile_vimeo'		    => '',
            'social_profile_vk'             => '',
            'social_profile_weibo'          => '',
            'social_profile_whatsapp'       => '',
            'social_profile_youtube'	    => '',
            'social_profile_email'          => '',
			'icon_size'					    => 'medium',
			'alignment'					    => 'center'
		), $atts ) );
		
		$social_profiles = array(
			'facebook'		=> array( 'title' => 'Facebook', 'url' => $social_profile_facebook ),
			'instagram'		=> array( 'title' => 'Instagram', 'url' => $social_profile_instagram ),
			'twitter'		=> array( 'title' => 'Twitter', 'url' => $social_profile_twitter ),
            'flickr'		=> array( 'title' => 'Flickr', 'url' => $social_profile_flickr ),
            'linkedin'		=> array( 'title' => 'LinkedIn', 'url' => $social_profile_linkedin ),
			'pinterest'		=> array( 'title' => 'Pinterest', 'url' => $social_profile_pinterest ),
			'rss-square'	=> array( 'title' => 'RSS', 'url' => $social_profile_rss ),
            'snapchat'      => array( 'title' => 'Snapchat', 'url' => $social_profile_snapchat ),
            'behance'		=> array( 'title' => 'Behance', 'url' => $social_profile_behance ),
            'dribbble'		=> array( 'title' => 'Dribbble', 'url' => $social_profile_dribbble ),
            'line-app'      => array( 'title' => 'LINE', 'url' => $social_profile_line ),
            'mixcloud'      => array( 'title' => 'MixCloud', 'url' => $social_profile_mixcloud ),
            'odnoklassniki' => array( 'title' => 'OK.RU', 'url' => $social_profile_odnoklassniki ),
            'soundcloud'    => array( 'title' => 'SoundCloud', 'url' => $social_profile_soundcloud ),
            'telegram'	    => array( 'title' => 'Telegram', 'url' => $social_profile_telegram ),
            'tiktok'		=> array( 'title' => 'TikTok', 'url' => $social_profile_tiktok ),
            'tumblr'		=> array( 'title' => 'Tumblr', 'url' => $social_profile_tumblr ),
			'vimeo-square'	=> array( 'title' => 'Vimeo', 'url' => $social_profile_vimeo ),
            'vk'			=> array( 'title' => 'VK', 'url' => $social_profile_vk ),
            'weibo'			=> array( 'title' => 'Weibo', 'url' => $social_profile_weibo ),
            'whatsapp'		=> array( 'title' => 'WhatsApp', 'url' => $social_profile_whatsapp ),
            'youtube'		=> array( 'title' => 'YouTube', 'url' => $social_profile_youtube ),
            'envelope'      => array( 'title' => 'Email', 'url' => $social_profile_email )
		);
		
		$output = '';
		foreach ( $social_profiles as $service => $details ) {
            if ( $details['url'] !== '' ) {
                if ( $service == 'envelope' ) {
                    $details['url'] = 'mailto:' . $details['url'];
                }
                
                $output .= '<li><a href="' . esc_url( $details['url'] ) . '" target="_blank" title="' . esc_attr( $details['title'] ) . '" class="dark"><i class="nm-font nm-font-' . esc_attr( $service ) . '"></i></a></li>';
			}
		}
		
		return '<ul class="nm-social-profiles icon-size-' . esc_attr( $icon_size ) . ' align-' . esc_attr( $alignment ) . '">' . $output . '</ul>';
	}
	
	add_shortcode( 'nm_social_profiles', 'nm_shortcode_social_profiles' );
	