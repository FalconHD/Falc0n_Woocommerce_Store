<?php
/**
 * Order tracking form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/form-tracking.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 NM: Modified */

defined( 'ABSPATH' ) || exit;

global $post;

?>

<style type="text/css">
	.woocommerce-error { margin: 55px auto -9px; text-align: center; }
	@media all and (max-width: 550px) { .woocommerce-error { margin-bottom: -36px; } }
</style>

<div class="nm-order-track">
    <div class="nm-order-track-top">
        <h1><?php esc_html_e( 'Order Tracking', 'nm-framework' ); ?></h1>
        
		<p><?php esc_html_e( 'To track your order please enter your Order ID in the box below and press the "Track" button. This was given to you on your receipt and in the confirmation email you should have received.', 'woocommerce' ); ?></p>        
    </div>
    
    <div class="nm-order-track-form">
        <form action="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" method="post" class="woocommerce-form woocommerce-form-track-order track_order">
            <p class="form-row form-row-wide"><label for="orderid"><?php esc_html_e( 'Order ID', 'woocommerce' ); ?></label> <input class="input-text" type="text" name="orderid" id="orderid" value="<?php echo isset( $_REQUEST['orderid'] ) ? esc_attr( $_REQUEST['orderid'] ) : ''; ?>" placeholder="<?php esc_html_e( 'Found in your order confirmation email.', 'woocommerce' ); ?>" /></p>
            <p class="form-row form-row-wide"><label for="order_email"><?php esc_html_e( 'Billing email', 'woocommerce' ); ?></label> <input class="input-text" type="text" name="order_email" id="order_email" value="<?php echo isset( $_REQUEST['order_email'] ) ? esc_attr( $_REQUEST['order_email'] ) : ''; ?>" placeholder="<?php esc_html_e( 'Email you used during checkout.', 'woocommerce' ); ?>" /></p>
            
            <p class="form-actions"><button type="submit" class="button" name="track" value="<?php esc_attr_e( 'Track', 'woocommerce' ); ?>"><?php esc_html_e( 'Track', 'woocommerce' ); ?></button></p>
            <?php wp_nonce_field( 'woocommerce-order_tracking', 'woocommerce-order-tracking-nonce' ); ?>
        </form>
    </div>
</div>