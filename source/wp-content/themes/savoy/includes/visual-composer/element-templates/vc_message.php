<?php
extract( shortcode_atts( array(
    'color' 	=> '',
    'el_class'	=> '',
    'el_id'     => ''
), $atts ) );

$elementClass = 'nm-message-box ' . $color . $this->getExtraClass( $el_class );

$iconClass = 'nm-font nm-font-textsms flip';

switch ( $color ) {
    case 'warning':
        $iconClass = 'nm-font nm-font-textsms flip';
        break;
    case 'success':
        $iconClass = 'nm-font nm-font-thumb-up';
        break;
    case 'danger':
        $iconClass = 'nm-font nm-font-thumb-down';
        break;
    default:
        break;
}

$wrapper_attributes = array();

$wrapper_attributes[] = 'class="' . $elementClass . '"';

if ( ! empty( $el_id ) ) {
    $wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}

$output = '
    <div ' . implode( ' ', $wrapper_attributes ) . '>
        <div class="nm-message-box-icon"><i class="' . esc_attr( $iconClass ) . '"></i></div>
        <div class="nm-message-box-text">' . $content . '</div>
    </div>';

echo $output; // Escaped
