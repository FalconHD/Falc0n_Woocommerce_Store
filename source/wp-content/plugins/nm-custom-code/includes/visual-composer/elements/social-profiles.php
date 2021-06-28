<?php
	
	// VC element: nm_social_profiles
	vc_map( array(
	   'name'			=> esc_html__( 'Social Profiles', 'nm-framework-admin' ),
	   'category'		=> esc_html__( 'Social', 'nm-framework-admin' ),
	   'description'	=> esc_html__( 'Social media profile icons', 'nm-framework-admin' ),
	   'base'			=> 'nm_social_profiles',
	   'icon'			=> 'nm_social_profiles',
	   'params'			=> array(
			array(
				'type' 			=> 'textfield',
				'heading' 		=> 'Facebook',
				'param_name' 	=> 'social_profile_facebook',
				'description'	=> esc_html__( 'Enter your Facebook profile URL.', 'nm-framework-admin' )
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> 'Instagram',
				'param_name' 	=> 'social_profile_instagram',
				'description'	=> esc_html__( 'Enter your Instagram profile URL.', 'nm-framework-admin' )
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> 'Twitter',
				'param_name' 	=> 'social_profile_twitter',
				'description'	=> esc_html__( 'Enter your Twitter profile URL.', 'nm-framework-admin' )
			),
            array(
				'type' 			=> 'textfield',
				'heading' 		=> 'Flickr',
				'param_name' 	=> 'social_profile_flickr',
				'description'	=> esc_html__( 'Enter your Flickr profile URL.', 'nm-framework-admin' )
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> 'LinedIn',
				'param_name' 	=> 'social_profile_linkedin',
				'description'	=> esc_html__( 'Enter your LinedIn profile URL.', 'nm-framework-admin' )
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> 'Pinterest',
				'param_name' 	=> 'social_profile_pinterest',
				'description'	=> esc_html__( 'Enter your Pinterest profile URL.', 'nm-framework-admin' )
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> 'RSS',
				'param_name' 	=> 'social_profile_rss',
				'description'	=> esc_html__( 'Enter your RSS feed URL.', 'nm-framework-admin' )
            ),
            array(
				'type' 			=> 'textfield',
				'heading' 		=> 'Snapchat',
				'param_name' 	=> 'social_profile_snapchat',
				'description'	=> esc_html__( 'Enter your Snapchat profile URL.', 'nm-framework-admin' )
			),
            array(
				'type' 			=> 'textfield',
				'heading' 		=> 'Behance',
				'param_name' 	=> 'social_profile_behance',
				'description'	=> esc_html__( 'Enter your Behance profile URL.', 'nm-framework-admin' )
			),
            array(
				'type' 			=> 'textfield',
				'heading' 		=> 'Dribbble',
				'param_name' 	=> 'social_profile_dribbble',
				'description'	=> esc_html__( 'Enter your Dribbble profile URL.', 'nm-framework-admin' )
			),
            array(
				'type' 			=> 'textfield',
				'heading' 		=> 'LINE',
				'param_name' 	=> 'social_profile_line',
				'description'	=> esc_html__( 'Enter your LINE chat URL.', 'nm-framework-admin' )
			),
            array(
				'type' 			=> 'textfield',
				'heading' 		=> 'MixCloud',
				'param_name' 	=> 'social_profile_mixcloud',
				'description'	=> esc_html__( 'Enter your MixCloud profile URL.', 'nm-framework-admin' )
			),
            array(
				'type' 			=> 'textfield',
				'heading' 		=> 'SoundCloud',
				'param_name' 	=> 'social_profile_soundcloud',
				'description'	=> esc_html__( 'Enter your SoundCloud profile URL.', 'nm-framework-admin' )
			),
            array(
				'type' 			=> 'textfield',
				'heading' 		=> 'Telegram',
				'param_name' 	=> 'social_profile_telegram',
				'description'	=> esc_html__( 'Enter your Telegram URL.', 'nm-framework-admin' )
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> 'Tumblr',
				'param_name' 	=> 'social_profile_tumblr',
				'description'	=> esc_html__( 'Enter your Tumblr profile URL.', 'nm-framework-admin' )
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> 'Vimeo',
				'param_name' 	=> 'social_profile_vimeo',
				'description'	=> esc_html__( 'Enter your Vimeo profile URL.', 'nm-framework-admin' )
			),
            array(
				'type' 			=> 'textfield',
				'heading' 		=> 'VK',
				'param_name' 	=> 'social_profile_vk',
				'description'	=> esc_html__( 'Enter your VK profile URL.', 'nm-framework-admin' )
			),
            array(
				'type' 			=> 'textfield',
				'heading' 		=> 'Weibo',
				'param_name' 	=> 'social_profile_weibo',
				'description'	=> esc_html__( 'Enter your Weibo profile URL.', 'nm-framework-admin' )
			),
            array(
				'type' 			=> 'textfield',
				'heading' 		=> 'WhatsApp',
				'param_name' 	=> 'social_profile_whatsapp',
				'description'	=> esc_html__( 'Enter your WhatsApp profile URL.', 'nm-framework-admin' )
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> 'YouTube',
				'param_name' 	=> 'social_profile_youtube',
				'description'	=> esc_html__( 'Enter your YouTube profile URL.', 'nm-framework-admin' )
			),
            array(
				'type' 			=> 'textfield',
				'heading' 		=> 'Email',
				'param_name' 	=> 'social_profile_email',
				'description'	=> esc_html__( 'Enter your Email address.', 'nm-framework-admin' )
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Icon Size', 'nm-framework-admin' ),
				'param_name' 	=> 'icon_size',
				'description'	=> esc_html__( 'Select icon size.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Small'		=> 'small',
					'Medium'	=> 'medium',
					'Large'		=> 'large'
				),
				'std' 			=> 'medium'
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Icon Alignment', 'nm-framework-admin' ),
				'param_name' 	=> 'alignment',
				'description'	=> esc_html__( 'Select icon alignment.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Center'	=> 'center',
					'Left'		=> 'left',
					'Right'		=> 'right'
				),
				'std' 			=> 'center'
			)
	   )
	) );
	