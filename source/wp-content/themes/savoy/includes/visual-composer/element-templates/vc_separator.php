<?php
extract( shortcode_atts( array(
    'title' 		=> '',
    'title_size' 	=> 'medium',
    'title_align' 	=> 'separator_align_center',
    'title_tag'     => 'h1',
    'accent_color'	=> '',
    'border_width'	=> '',
    'el_class' 		=> '',
    'el_id'         => ''
), $atts ) );

$wrapper_attributes = array();

$custom_class = ( strlen( $el_class ) > 0 ) ? $this->getExtraClass( $el_class ) : '';
$class = 'nm-divider ' . $title_align . $custom_class;

$wrapper_attributes[] = 'class="' . esc_attr( $class ) . '"';

$title = ( strlen( $title ) > 0 ) ? '<' . $title_tag . ' class="nm-divider-title ' . esc_attr( $title_size ) . '">' . $title . '</' . $title_tag . '>' : '';

$divider_style = ( strlen( $border_width ) > 0 ) ? 'height:' . $border_width . 'px; ' : '';
$divider_style .= ( strlen( $accent_color ) > 0 ) ? 'background:' . $accent_color . ';' : '';

if ( ! empty( $el_id ) ) {
    $wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}

$output = '
    <div ' . implode( ' ', $wrapper_attributes ) . '>' . 
        $title . '
        <div class="nm-divider-line" style="' . esc_attr( $divider_style ) . '"></div>
    </div>';

echo $output; // Escaped
