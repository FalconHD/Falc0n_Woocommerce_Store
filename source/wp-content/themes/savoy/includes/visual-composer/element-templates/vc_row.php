<?php
extract( shortcode_atts( array(
    'full_height'       => '',
    'equal_height'      => '',
    'content_placement' => '',
    'video_bg'		    => '',
    'video_bg_url'		=> 'https://www.youtube.com/watch?v=lMJXxhRFO1k',
    'parallax'			=> '',
    'parallax_image'	=> '',
    'el_id'        		=> '',
    'disable_element'   => '',
    'el_class'        	=> '',
    'css' 				=> '',
    'css_animation'     => '',
    // Custom params
    'type' 				=> 'full',
    'max_width'			=> '',
    'min_height'		=> ''
), $atts ) );

wp_enqueue_script( 'wpb_composer_front_js' );

$output = $row_style = $row_class = $row_flex_class = '';
$wrapper_atts = array();

// Custom ID
if ( ! empty( $el_id ) ) {
    $wrapper_atts[] = 'id="' . esc_attr( $el_id ) . '"';
}

// Custom class
//$el_class = $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$el_class = $this->getExtraClass( $el_class );
// Fix: $css_animation should be empty when animation is disabled but returns "none" instead (see "getCSSAnimation()" in "../js_composer/include/classes/shortcodes/shortcodes.php")
if ( $css_animation !== 'none' ) {
    $el_class .= $this->getCSSAnimation( $css_animation );
}

// Maximum width
if ( strlen( $max_width ) > 0 ) {
    $type = 'boxed nm-row-max-width'; // Set type to "boxed" if max-width is set
    $row_style .= 'max-width:' . intval( $max_width ) . 'px;';
}

// Mininmum height
if ( strlen( $min_height ) > 0 ) {
    $row_style .= ' min-height:' . intval( $min_height ) . 'px;';
}

// Row class start
$row_class = 'nm-row nm-row-' . $type . ' vc_row wpb_row';

// Disable Row
if ( 'yes' === $disable_element ) {
    if ( vc_is_page_editable() ) {
        $row_class .= ' nm-row-hidden';
	} else {
		return '';
	}
}

// Full height class
if ( ! empty( $full_height ) ) {
    nm_add_page_include( 'row-full-height' );

    $row_class .= ' nm-row-full-height';
}

// Row flexbox class: Equal height
if ( ! empty( $equal_height ) ) {
    $row_flex_class .= ' nm-row-equal-height';
}
// Row flexbox class: Content placement
if ( ! empty( $content_placement ) ) {
    $row_flex_class .= ' nm-row-col-' . $content_placement;
}
// Row flexbox class
if ( ! empty( $row_flex_class ) ) {
    $row_class .= ' nm-row-flex' . $row_flex_class;
}

// Video (YouTube) background
if ( ! empty( $video_bg ) && ! empty( $video_bg_url ) ) {
    // Disable parallax
    $parallax = '';

    nm_add_page_include( 'video-background' );

    // Enqueue YouTube JavaScript API
    wp_enqueue_script( 'nm_youtube_iframe_api_js', 'https://www.youtube.com/iframe_api', array(), NM_THEME_VERSION, true );

    $row_class .= ' nm-row-video';
    $wrapper_atts[] = 'data-video-url="' . esc_url( $video_bg_url ) . '"';
}    

// Parallax		
if ( ! empty( $parallax ) ) {
    $row_class .= ' nm-row-parallax nm-row-parallax-' . $parallax;

    // Parallax image
    if ( ! empty ( $parallax_image ) ) {
        $parallax_image_id = preg_replace( '/[^\d]/', '', $parallax_image );
        $parallax_image_src = wp_get_attachment_image_src( $parallax_image_id, 'full' );
        if ( ! empty( $parallax_image_src[0] ) ) {
            $parallax_image_src = $parallax_image_src[0];
        }
        $row_style .= ' background-image:url(' . esc_attr( $parallax_image_src ) . ') !important;';
    }
}

// Row class end
$row_class .= ' ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' );

// Style attribute
if ( strlen( $row_style ) > 0 ) {
    $wrapper_atts[] = 'style="' . esc_attr( $row_style ) . '"';
}
// Class attribute
$wrapper_atts[] = 'class="' . esc_attr( apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $row_class, $this->settings['base'], $atts ) ) . '"';

// Output
$output .= '<div ' . implode( ' ', $wrapper_atts ) . '>';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';

echo $output; // Escaped