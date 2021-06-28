<?php
	
	// Shortcode: nm_gmap_embed
	function nm_shortcode_gmap_embed( $atts, $content = NULL ) {
		extract( shortcode_atts( array(
			'address'		=> 'Amsterdam, The Netherlands',
			'map_type'		=> '',
			'height'		=> '500',
			'zoom'			=> '10'
		), $atts ) );
		
		return '<div class="nm-gmap-embed" style="height:' . intval( $height ) . 'px"><iframe width="100%" height="100%" src="https://maps.google.com/maps?q=' . urlencode( $address ) . '&t=' . esc_attr( $map_type )  . '&z=' . intval( $zoom ) . '&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no"></iframe></div>';
	}
	
	add_shortcode( 'nm_gmap_embed', 'nm_shortcode_gmap_embed' );
	