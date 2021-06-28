<?php
	
	// VC element: nm_button
	vc_map( array(
	   'name'			=> __( 'Button', 'nm-framework-admin' ),
	   'category'		=> __( 'Content', 'nm-framework-admin' ),
	   'description'	=> __( 'Eye catching button', 'nm-framework-admin' ),
	   'base'			=> 'nm_button',
	   'icon'			=> 'nm_button',
	   'params'			=> array(
	   		array(
				'type' 			=> 'textfield',
				'heading' 		=> __( 'Title', 'nm-framework-admin' ),
				'param_name' 	=> 'title',
				'description'	=> __( 'Enter a button title.', 'nm-framework-admin' ),
				'value' 		=> __( 'Button with Text', 'nm-framework-admin' )
			),
			array(
				'type'			=> 'vc_link',
				'heading'		=> __( 'URL (Link)', 'nm-framework-admin' ),
				'param_name'	=> 'link',
				'description'	=> __( 'Set a button link.', 'nm-framework-admin' )
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Style', 'nm-framework-admin' ),
				'param_name'	=> 'style',
				'description'	=> __( 'Select button style.', 'nm-framework-admin' ),
				'value' 		=> array(
					'Filled'			=> 'filled',
					'Filled Rounded'	=> 'filled_rounded',
					'Border'			=> 'border',
					'Border Rounded'	=> 'border_rounded',
					'Link'				=> 'link'
				),
				'std'			=> 'filled'
			),
			array(
				'type' 			=> 'colorpicker',
				'heading' 		=> __( 'Color', 'nm-framework-admin' ),
				'param_name' 	=> 'color',
				'description'	=> __( 'Button color.', 'nm-framework-admin' )
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Size', 'nm-framework-admin' ),
				'param_name'	=> 'size',
				'description'	=> __( 'Select button size.', 'nm-framework-admin' ),
				'value'			=> array(
					'Large'			=> 'lg',
					'Medium'		=> 'md',
					'Small' 		=> 'sm',
					'Extra Small'	=> 'xs'
				),
				'std' 			=> 'lg'
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> __( 'Align', 'nm-framework-admin' ),
				'param_name'	=> 'align',
				'description'	=> __( 'Select button alignment.', 'nm-framework-admin' ),
				'value'			=> array(
					'Left' 		=> 'left',
					'Center'	=> 'center',
					'Right' 	=> 'right'
				),
				'std' 			=> 'left'
			)
		)
	) );
	