<?php
	
	// Shortcode: nm_button
	function nm_shortcode_button( $atts, $content = NULL ) {
		extract( shortcode_atts( array(
			'title'	=> esc_html__( 'Button with Text', 'nm-framework-admin' ),
			'link' 	=> '',
			'style'	=> 'filled',
			'color'	=> '',
			'size' 	=> 'lg',
			'align'	=> 'left'
		), $atts ) );
		
		// Parse link
		$link = ( $link == '||' ) ? '' : $link;
		$link = nm_build_link( $link );
		$a_href = $link['url'];
        $a_title_attr = ( strlen( $link['title'] ) > 0 ) ? ' title="' . esc_attr( $link['title'] ) . '"' : '';
        $a_target_attr = ( strlen( $link['target'] ) > 0 ) ? 'target="' . esc_attr( $link['target'] ) . '"' : '';
		
		// Class
		$button_class = 'nm_btn nm_btn_' . $size . ' nm_btn_' . $style;
		
		// Background style
		$button_style_attr = $bg_style_attr = '';
		if ( strlen( $color ) > 0 ) {
			if ( strpos( $style, 'border' ) !== false ) {
				$button_style_attr = ' style="color:' . esc_attr( $color ) . ';"';
			} else {
				$bg_style_attr = ' style="background-color:' . esc_attr( $color ) . ';"';
			}
		}
		
		$output = '
			<div class="nm_btn_align_' . $align . '">
				<a href="' . esc_url( $a_href ) . '" class="' . esc_attr( $button_class ) . '"' . $a_title_attr . $a_target_attr . $button_style_attr . '>
					<span class="nm_btn_title">' . esc_attr( $title ) . '</span>
					<span class="nm_btn_bg"' . $bg_style_attr . '></span>
				</a>
			</div>';
		
		return $output;
	}
	
	add_shortcode( 'nm_button', 'nm_shortcode_button' );
