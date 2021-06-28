<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.9.0
 NM: Modified */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $woocommerce_loop;

$columns_small = ( intval( $columns ) > 1 ) ? '2' : '1';
$columns_medium = ( intval( $columns ) < 4 ) ? $columns : '4';

$woocommerce_loop['columns'] = $columns; // Note: This variable is filtered in "../savoy/includes/woocommerce/woocommerce-functions.php"
$woocommerce_loop['columns_xsmall'] = $columns_small;
$woocommerce_loop['columns_small'] = $columns_small;
$woocommerce_loop['columns_medium'] = $columns_medium;

if ( $related_products ) : ?>

	<section id="nm-related" class="related products">
        
        <div class="nm-row">
        	<div class="col-xs-12">
                
                <?php
                $heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related products', 'woocommerce' ) );

                if ( $heading ) :
                    ?>
                    <h2><?php echo esc_html( $heading ); ?></h2>
                <?php endif; ?>

                <?php woocommerce_product_loop_start(); ?>

                    <?php foreach ( $related_products as $related_product ) : ?>

                        <?php
                            $post_object = get_post( $related_product->get_id() );
                            
                            setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found
                            
                            wc_get_template_part( 'content', 'product' );
                        ?>

                    <?php endforeach; ?>

                <?php woocommerce_product_loop_end(); ?>
                
            </div>
        </div>

	</section>
    <?php
endif;

wp_reset_postdata();
