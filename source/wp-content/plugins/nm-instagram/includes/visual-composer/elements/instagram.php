<?php
	// VC element: nm_instagram
    vc_map( array(
       'name'			=> __( 'Instagram', 'nm-instagram' ),
       'category'		=> __( 'Content', 'nm-instagram' ),
       'description'	=> __( 'Instagram gallery', 'nm-instagram' ),
       'base'			=> 'nm_instagram',
       'icon'			=> 'nm_instagram',
       'params'			=> array(
            array(
                'type' 			=> 'textfield',
                'heading' 		=> __( 'Instagram Username', 'nm-instagram' ),
                'param_name' 	=> 'username_hashtag',
                'description'	=> __( 'Enter Instagram @username or #hashtag', 'nm-instagram' ),
                'std'			=> ''
            ),
            array(
                'type' 			=> 'textfield',
                'heading' 		=> __( 'Image Limit - Max. 12 (Instagram API limit)', 'nm-instagram' ),
                'param_name' 	=> 'image_limit',
                'description'	=> __( 'Number of images to display.', 'nm-instagram' ),
                'std'			=> '12'
            ),
            array(
                'type' 			=> 'dropdown',
                'heading' 		=> __( 'Images per Row', 'nm-instagram' ),
                'param_name' 	=> 'images_per_row',
                'description'   => __( 'Select number of images to display per row.', 'nm-instagram' ),
                'value' 		=> array(
                    '2' => '2',
                    '4' => '4',
                    '6' => '6',
                    '8' => '8'
                ),
                'std'			=> '6'
            ),
            /*array(
                'type' 			=> 'dropdown',
                'heading' 		=> __( 'Image Size', 'nm-instagram' ),
                'param_name' 	=> 'image_size',
                'description'   => __( 'Select image size.', 'nm-instagram' ),
                'value' 		=> array(
                    'Thumbnail' => 'thumbnail',
                    'Small'     => 'small',
                    'Medium'    => 'medium',
                    'Large'     => 'large',
                    'Original'  => 'original'
                ),
                'std'			=> 'medium'
            ),*/
            array(
                'type' 			=> 'dropdown',
                'heading' 		=> __( 'Image Aspect Ratio', 'nm-instagram' ),
                'param_name' 	=> 'image_aspect_ratio_class',
                'description'   => __( 'Select image aspect ratio.', 'nm-instagram' ),
                'value' 		=> array(
                    'Square'    => 'aspect-ratio-square',
                    'Original'  => 'aspect-ratio-original'
                ),
                'std'			=> 'aspect-ratio-square'
            ),
            array(
                'type' 			=> 'checkbox',
                'heading' 		=> __( 'Image Spacing', 'nm-instagram' ),
                'param_name' 	=> 'image_spacing_class',
                'description'	=> __( 'Display spacing between images.', 'nm-instagram' ),
                'value'			=> array(
                    __( 'Enable', 'nm-instagram' ) => 'has-spacing'
                ),
                'std'			=> '0'
            ),
            array(
                'type' 			=> 'dropdown',
                'heading' 		=> __( 'Refresh Interval', 'nm-instagram' ),
                'param_name' 	=> 'transient_time',
                'description'   => __( 'Select how often to check Instagram for new images.', 'nm-instagram' ),
                'value' 		=> array(
                    '1 Hour'    => HOUR_IN_SECONDS,
                    '6 Hours'   => 6 * HOUR_IN_SECONDS,
                    '12 Hours'  => 12 * HOUR_IN_SECONDS,
                    '24 Hours'  => DAY_IN_SECONDS
                ),
                'std'			=> DAY_IN_SECONDS
            ),
            array(
                'type' 			=> 'checkbox',
                'heading' 		=> __( 'User Link', 'nm-instagram' ),
                'param_name' 	=> 'instagram_user_link',
                'description'	=> __( 'Display link to the Instagram user.', 'nm-instagram' ),
                'value'			=> array(
                    __( 'Enable', 'nm-instagram' ) => '1'
                ),
                'std'			=> '0'
            )
	   )
	) );