<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.6.0
 NM: Modified */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing'  => __( 'Billing address', 'woocommerce' ),
			'shipping' => __( 'Shipping address', 'woocommerce' ),
		),
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => __( 'Billing address', 'woocommerce' ),
		),
		$customer_id
	);
}

$nm_shipping_address_enabled = ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) ? true : false;
$nm_column_class = ( $nm_shipping_address_enabled ) ? 'col-sm-6 col-xs-12' : 'col-xs-12';
?>

<p class="woocommerce-Message woocommerce-Message--info woocommerce-info">
	<?php echo apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following addresses will be used on the checkout page by default.', 'woocommerce' ) ); ?>
</p>

<?php if ( $nm_shipping_address_enabled ) : ?>
    <div class="u-columns woocommerce-Addresses col2-set addresses"><div class="nm-row">
<?php endif; ?>

<?php foreach ( $get_addresses as $name => $address_title ) : ?>
    <?php
		$address = wc_get_account_formatted_address( $name );
	?>

	<div class="woocommerce-Address <?php echo esc_attr( $nm_column_class ); ?>">
		<header class="woocommerce-Address-title title">
			<h3><?php echo $address_title; ?></h3>
		</header>
		<address>
            <?php
                echo $address ? wp_kses_post( $address ) : esc_html_e( 'You have not set up this type of address yet.', 'woocommerce' );
            ?>
        </address>
        <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="edit"><?php echo $address ? esc_html__( 'Edit', 'woocommerce' ) : esc_html__( 'Add', 'woocommerce' ); ?></a>
	</div>

<?php endforeach; ?>

<?php if ( $nm_shipping_address_enabled ) : ?>
    </div></div>
<?php endif; ?>
