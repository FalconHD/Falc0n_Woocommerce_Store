<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.4.0
 NM: Modified */

defined( 'ABSPATH' ) || exit;

global $woocommerce_loop, $nm_theme_options;

$woocommerce_loop['name']           = 'cross-sells';
$woocommerce_loop['columns']        = apply_filters( 'woocommerce_cross_sells_columns', $nm_theme_options['product_upsell_related_columns'] );
$woocommerce_loop['columns_xsmall'] = '2';
$woocommerce_loop['columns_small']  = '2';
$woocommerce_loop['columns_medium'] = '4';

if ( $cross_sells ) : ?>

	<div class="cross-sells">
        <?php
		$heading = apply_filters( 'woocommerce_product_cross_sells_products_heading', __( 'You may be interested in&hellip;', 'woocommerce' ) );

		if ( $heading ) :
			?>
			<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
        
		<?php woocommerce_product_loop_start(); ?>
        
            <?php foreach ( $cross_sells as $cross_sell ) : ?>
            
                <?php
				 	$post_object = get_post( $cross_sell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'content', 'product' ); ?>

            <?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>

<?php endif;

wp_reset_postdata();
