<?php
	
	/* Helper: Get Contact Form 7 forms */
	function nm_get_cf7_forms() {
		$cf7_forms = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );
		
		$forms = array();
		
		if ( $cf7_forms ) {
			foreach ( $cf7_forms as $form )
				$forms[$form->post_title] = $form->ID;
		} else {
			$forms[esc_html__( 'No contact forms found', 'nm-framework-admin' )] = 0;
		}
		
		return $forms;
	}
	
	
	// VC element: nm_contact_form_7
	vc_map( array(
		'name' 			=> esc_html__( 'Contact Form 7', 'nm-framework-admin' ),
		'category' 		=> esc_html__( 'Content', 'nm-framework-admin' ),
		'description'	=> esc_html__( 'Include Contact Form 7 form', 'nm-framework-admin' ),
		'base' 			=> 'nm_contact_form_7',
		'icon' 			=> 'nm_contact_form_7',
		'params' 		=> array(
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Form title', 'nm-framework-admin' ),
				'param_name'	=> 'title',
				'admin_label'	=> true,
				'description'	=> esc_html__( 'Form title (leave blank if no title is needed).', 'nm-framework-admin' )
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Select form', 'nm-framework-admin' ),
				'param_name' 	=> 'id',
				'description'	=> esc_html__( 'Select a previously created contact-form from the list.', 'nm-framework-admin' ),
				'value' 		=> function_exists( 'nm_get_cf7_forms' ) ? nm_get_cf7_forms() : array()
			)
		)
	) );