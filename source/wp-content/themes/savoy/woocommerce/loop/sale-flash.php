<?php
/**
 * Product loop sale flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 NM: Modified */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $nm_theme_options;

?>
<?php if ( $nm_theme_options['product_sale_flash'] && $product->is_on_sale() ) : ?>

	<?php
		// Output percentage or text "sale flash"
		if ( $nm_theme_options['product_sale_flash'] !== 'txt' ) {
			$sale_percent = nm_product_get_sale_percent( $product );
			
			if ( $sale_percent > 0 ) {
				echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale"><span class="nm-onsale-before">-</span>' . $sale_percent . '<span class="nm-onsale-after">%</span></span>', $post, $product );
			}
		} else {
			$sale_text = esc_html__( 'Sale!', 'woocommerce' );
			
			echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . $sale_text . '</span>', $post, $product );
		}
	?>

<?php endif;

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
