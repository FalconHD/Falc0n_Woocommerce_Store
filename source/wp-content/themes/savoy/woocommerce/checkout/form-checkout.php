<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 NM: Modified */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $nm_theme_options, $nm_globals;

$nm_validation_notices_class = ( $nm_theme_options['checkout_inline_notices'] ) ? ' nm-validation-inline-notices' : '';
?>

<?php 
wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout clear" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
    
    <ul class="nm-checkout-login-coupon">
        <?php if ( isset( $nm_globals['checkout_login_message'] ) ) : ?>
        <li><?php wc_print_notice( $nm_globals['checkout_login_message'], 'notice' ); ?></li>
        <?php 
            endif;

            if ( isset( $nm_globals['checkout_coupon_message'] ) ) :
        ?>
        <li><?php wc_print_notice( $nm_globals['checkout_coupon_message'], 'notice' ); ?></li>
        <?php endif; ?>
    </ul>
    
	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>
    
		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
        
		<div class="col2-set<?php echo esc_attr( $nm_validation_notices_class ); ?>" id="customer_details">
            <div class="col-1">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>
            
			<div class="col-2">
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>
		</div>
        
		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>
    
    <h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
        
	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
            
	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>
    
	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>
    
<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>