<?php

/*
 *	NM: Visual Composer page elements
 */

if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {
    if ( is_admin() ) {
        /* Include external elements */
        function nm_ce_vc_register_elements() {
            $nm_cf7_enabled = ( defined( 'WPCF7_PLUGIN' ) ) ? true : false; // Check if "CF7" is enabled

            include( NM_CE_INC_DIR . '/visual-composer/elements/banner.php' );
            include( NM_CE_INC_DIR . '/visual-composer/elements/banner-slider.php' );
            include( NM_CE_INC_DIR . '/visual-composer/elements/button.php' );
            if ( $nm_cf7_enabled ) { include( NM_CE_INC_DIR . '/visual-composer/elements/contact-form-7.php' ); }
            include( NM_CE_INC_DIR . '/visual-composer/elements/feature-box.php' );
            include( NM_CE_INC_DIR . '/visual-composer/elements/google-map.php' );
            include( NM_CE_INC_DIR . '/visual-composer/elements/google-map-embed.php' );
            include( NM_CE_INC_DIR . '/visual-composer/elements/lightbox.php' );
            include( NM_CE_INC_DIR . '/visual-composer/elements/post-slider.php' );
            include( NM_CE_INC_DIR . '/visual-composer/elements/posts.php' );
            include( NM_CE_INC_DIR . '/visual-composer/elements/social-profiles.php' );
            include( NM_CE_INC_DIR . '/visual-composer/elements/testimonial.php' );

            if ( function_exists( 'nm_woocommerce_activated' ) && nm_woocommerce_activated() ) {
                // Include external WooCommerce elements
                include( NM_CE_INC_DIR . '/visual-composer/elements/woocommerce/product-categories.php' );
                include( NM_CE_INC_DIR . '/visual-composer/elements/woocommerce/product-reviews.php' );
                include( NM_CE_INC_DIR . '/visual-composer/elements/woocommerce/product-search.php' );
                include( NM_CE_INC_DIR . '/visual-composer/elements/woocommerce/product-slider.php' );
            }
        }
        add_action( 'init', 'nm_ce_vc_register_elements', 2 );
    }
}