<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.0.0
 NM: Modified - Added $nm_price_class and "sale flash" label */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $nm_theme_options;

$nm_price_class = 'price'; // Default class

// Sale "flash"
if ( $product->is_on_sale() && $nm_theme_options['single_product_sale_flash'] == 'pct-ap' ) {
    $nm_show_sale_flash = true;
    $nm_price_class .= ' has-sale-flash';
} else {
    $nm_show_sale_flash = false;
}

?>
<p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', $nm_price_class ) ); ?>">
    <?php echo $product->get_price_html(); ?>
    
    <?php
        if ( $nm_show_sale_flash ) {
            $sale_percent = nm_product_get_sale_percent( $product );
            
            if ( $sale_percent > 0 ) {
                echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale"><span class="nm-onsale-before">-</span>' . $sale_percent . '<span class="nm-onsale-after">%</span></span>', $post, $product );
            }
        };
    ?>
</p>
