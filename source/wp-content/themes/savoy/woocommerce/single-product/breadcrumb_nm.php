<?php
/**
 *  NM: Single Product breadrumb and navigation
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $nm_globals, $nm_theme_options;

?>

<div class="nm-single-product-top">
    <div class="nm-row">
        <div class="col-xs-9">
            <?php
                // Is the shop displaying on the home-page?
                $shop_on_homepage = ( $nm_globals['shop_page_id'] == intval( get_option('page_on_front') ) );

                /* Breadcrumb */
                woocommerce_breadcrumb( array(
                    'delimiter'   	=> '<span class="delimiter">/</span>',
                    'wrap_before'	=> '<nav id="nm-breadcrumb" class="woocommerce-breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>',
                    'wrap_after'	=> '</nav>',
                    'home'			=> ( $shop_on_homepage ) ? esc_html_x( 'Shop', 'breadcrumb', 'nm-framework' ) : esc_html_x( 'Home', 'breadcrumb', 'woocommerce' )
                ) );
            ?>
        </div>

        <div class="col-xs-3">
            <div class="nm-single-product-menu">
                <?php
                    // Product navigation
                    $navigate_same_term = ( $nm_theme_options['product_navigation_same_term'] ) ? true : false;

                    /* Product navigation */
                    next_post_link( '%link', apply_filters( 'nm_single_product_menu_next_icon', '<i class="nm-font nm-font-media-play flip"></i>' ), $navigate_same_term, array(), 'product_cat' );
                    previous_post_link( '%link', apply_filters( 'nm_single_product_menu_prev_icon', '<i class="nm-font nm-font-media-play"></i>' ), $navigate_same_term, array(), 'product_cat' );
                ?>
            </div>
        </div>
    </div>
</div>
