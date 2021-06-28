<?php
/**
 * Single Product Sale Flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/sale-flash.php.
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
<?php if ( $product->is_on_sale() ) : ?>

	<?php
        // Percentage or text "sale flash"
		if ( $nm_theme_options['single_product_sale_flash'] == 'pct' ) {
			$sale_percent = nm_product_get_sale_percent( $product );
			
			if ( $sale_percent > 0 ) {
				echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale"><span class="nm-onsale-before">-</span>' . $sale_percent . '<span class="nm-onsale-after">%</span></span>', $post, $product );
			}
        } else if ( $nm_theme_options['single_product_sale_flash'] == 'txt' ) {
            echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product );
        }
    ?>

<?php endif;

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
