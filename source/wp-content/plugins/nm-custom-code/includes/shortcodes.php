<?php

/*
 *	NM: Shortcodes (page elements)
 */

$include_shortcodes = apply_filters( 'nm_include_shortcodes', true );

if ( $include_shortcodes ) {
    /* Include external shortcodes */
    function nm_ce_register_shortcodes() {
        $nm_cf7_enabled = ( defined( 'WPCF7_PLUGIN' ) ) ? true : false; // Check if "CF7" is enabled

        include( NM_CE_INC_DIR . '/shortcodes/banner.php' );
        include( NM_CE_INC_DIR . '/shortcodes/banner-slider.php' );
        include( NM_CE_INC_DIR . '/shortcodes/button.php' );
        if ( $nm_cf7_enabled ) { include( NM_CE_INC_DIR . '/shortcodes/contact-form-7.php' ); }
        include( NM_CE_INC_DIR . '/shortcodes/feature-box.php' );
        include( NM_CE_INC_DIR . '/shortcodes/google-map.php' );
        include( NM_CE_INC_DIR . '/shortcodes/google-map-embed.php' );
        include( NM_CE_INC_DIR . '/shortcodes/lightbox.php' );
        include( NM_CE_INC_DIR . '/shortcodes/post-slider.php' );
        include( NM_CE_INC_DIR . '/shortcodes/posts.php' );
        include( NM_CE_INC_DIR . '/shortcodes/social-profiles.php' );
        include( NM_CE_INC_DIR . '/shortcodes/testimonial.php' );

        if ( function_exists( 'nm_woocommerce_activated' ) && nm_woocommerce_activated() ) {
            // Include external WooCommerce shortcodes
            include( NM_CE_INC_DIR . '/shortcodes/woocommerce/product-categories.php' );
            include( NM_CE_INC_DIR . '/shortcodes/woocommerce/product-reviews.php' );
            include( NM_CE_INC_DIR . '/shortcodes/woocommerce/product-search.php' );
            include( NM_CE_INC_DIR . '/shortcodes/woocommerce/product-slider.php' );
        }
    }
    add_action( 'init', 'nm_ce_register_shortcodes' );
}
