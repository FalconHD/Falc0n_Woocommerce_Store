<?php

	$title = $open = '';
	
	extract( shortcode_atts( array(
		'title'	 	=> esc_html__( 'Click to toggle', 'nm-framework' ),
		'el_class'	=> '',
		'open' 		=> 'false',
	), $atts ) );
	
	$elementClass = array(
		'base' 			=> apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_toggle', $this->settings['base'], $atts ),
		'open' 			=> ( $open == 'true' ) ? 'vc_toggle_active' : '',
		'extra' 		=> $this->getExtraClass( $el_class )
	);
	
	$elementClass = trim( implode( ' ', $elementClass ) );
	
	$output = '
		<div class="' . esc_attr( $elementClass ) . '">
			<div class="vc_toggle_title">' . 
				apply_filters( 'wpb_toggle_heading', '<h3>' . esc_html( $title ) . '</h3>', array(
					'title'	=> $title,
					'open'	=> $open
				) ) . '
				<i class="nm-font nm-font-plus-small"></i>
			</div>
			<div class="vc_toggle_content">
				<div class="wpb_text_column">' . 
					apply_filters( 'the_content', $content ) . '
				</div>
			</div>	
		</div>';
	
	echo $output; // Escaped
