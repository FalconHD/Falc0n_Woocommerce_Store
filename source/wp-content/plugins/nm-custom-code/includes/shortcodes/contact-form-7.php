<?php
	
	// Shortcode: nm_contact_form_7
	function nm_shortcode_contact_form_7( $atts, $content = NULL ) {
		if ( function_exists( 'nm_add_page_include' ) ) {
            nm_add_page_include( 'contact-form-7' );
        }
		
		extract( shortcode_atts( array(
			'title'	=> '',
			'id'	=> ''
		), $atts ) );
		
		$title_attr = ( strlen( $title ) > 0 ) ? ' title="Contact form"' : '';
		
		$shortcode = '[contact-form-7 id="' . intval( $id ) . '"' . $title_attr . ']';
		
		return do_shortcode( $shortcode );
	}
	
	add_shortcode( 'nm_contact_form_7', 'nm_shortcode_contact_form_7' );
	