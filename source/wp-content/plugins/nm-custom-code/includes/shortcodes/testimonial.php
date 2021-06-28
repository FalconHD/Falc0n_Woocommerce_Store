<?php
	
	// Shortcode: nm_testimonial
	function nm_shortcode_nm_testimonial( $atts, $content = NULL ) {
		extract( shortcode_atts( array(
			'image_id'		=> '',
			'signature'		=> '',
			'company'		=> ''
		), $atts ) );
        
		// Image
		$image_class = $image_output = '';
		if ( strlen( $image_id ) > 0 ) {
			$image_class = ' has-image';
			
            $image = wp_get_attachment_image( $image_id, 'full' );
            $image_output = '<div class="nm-testimonial-image">' . $image . '</div>';
		}
		
		// Signature
        $signature_output = '';
		if ( ! empty( $signature ) ) {
            $signature_output = '<div class="nm-testimonial-author"><span>' . $signature . '</span>';
            $signature_output .= ( ! empty( $company ) ) ? ', <em>' . $company . '</em></div>' : '</div>';
        }
		
		return '
			<div class="nm-testimonial' . esc_attr( $image_class ) . '">' .
				$image_output . '
				<div class="nm-testimonial-content">
					<div class="nm-testimonial-description">' . $content . '</div>' .
                    $signature_output . '
				</div>
			</div>';
	}
	
	add_shortcode( 'nm_testimonial', 'nm_shortcode_nm_testimonial' );