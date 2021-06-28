<?php
global $nm_theme_options;

$el_class = $el_id = $width = $css = $offset = $css_animation = '';
extract(shortcode_atts(array(
    'el_id'         => '',
    'el_class' 		=> '',
    'width' 		=> '1/1',
    'css' 			=> '',
    'offset' 		=> '',
    'css_animation' => ''
), $atts));

$width = wpb_translateColumnWidthToSpan( $width );
$width = vc_column_offset_class_merge( $offset, $width );
if ( $nm_theme_options['vcomp_enable_frontend'] ) {
    $nm_width = str_replace( 'vc_', '', $width ); // Remove 'vc_' prefix
    $width = $nm_width . ' ' . $width; // Include default and custom column class when front-end editor is enabled
} else {
    $width = str_replace( 'vc_', '', $width ); // Remove 'vc_' prefix
}

$css_classes = array(
    $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation ),
    'nm_column',
    'wpb_column',
    'vc_column_container',
    $width,
    vc_shortcode_custom_css_class( $css )
);

$wrapper_attributes = array();

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
if ( ! empty( $el_id ) ) {
    $wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
$output .= '<div class="vc_column-inner">';
$output .= '<div class="wpb_wrapper">';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output; // Escaped
