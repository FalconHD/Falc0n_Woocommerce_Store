<?php
/*
 *  NM: Visual Composer functions used in shortcodes
 */


/*
 * Used by: Banner shortcode
 * Location: "../js_composer/include/params/vc_link/vc_link.php"
 */
if ( ! function_exists( 'nm_build_link' ) ) {
    /**
     * @param $value
     *
     * @return array
     * @since 4.2
     */
    function nm_build_link( $value ) {
        return nm_parse_multi_attribute( $value, array(
            'url' => '',
            'title' => '',
            'target' => '',
            'rel' => '',
        ) );
    }
}


/*
 * Used by: nm_build_link() function above
 * Location: "../js_composer/include/helpers/helpers.php"
 */
if ( ! function_exists( 'nm_parse_multi_attribute' ) ) {
    /**
     * Parse string like "title:Hello world|weekday:Monday" to array('title' => 'Hello World', 'weekday' => 'Monday')
     *
     * @param $value
     * @param array $default
     *
     * @return array
     * @since 4.2
     */
    function nm_parse_multi_attribute( $value, $default = array() ) {
        $result = $default;
        $params_pairs = explode( '|', $value );
        if ( ! empty( $params_pairs ) ) {
            foreach ( $params_pairs as $pair ) {
                $param = preg_split( '/\:/', $pair );
                if ( ! empty( $param[0] ) && isset( $param[1] ) ) {
                    $result[ $param[0] ] = trim( rawurldecode( $param[1] ) );
                }
            }
        }

        return $result;
    }
}


/*
 * Used by: Feature Box shortcode
 * Location: "../js_composer/include/helpers/helpers.php"
 */
if ( ! function_exists( 'nm_remove_wpautop' ) ) {
    /**
     * @param $content
     * @param bool $autop
     *
     * @return string
     * @since 4.2
     */
    function nm_remove_wpautop( $content, $autop = false ) {

        if ( $autop ) {
            $content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
        }

        return do_shortcode( shortcode_unautop( $content ) );
    }
}