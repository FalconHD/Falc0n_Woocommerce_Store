<?php
/**
 *	NM: Quick view product content
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $nm_theme_options;

/* Product summary: Opening tags */
function nm_qv_product_summary_open() {
	echo '<div class="nm-qv-summary-top">';
}

/* Product summary: Divider tags */
function nm_qv_product_summary_divider() {
	global $nm_theme_options;
	echo '</div><div class="nm-qv-summary-content ' . esc_attr( $nm_theme_options['product_quickview_summary_layout'] ) . '">';
}

/* Product summary: Closing tags */
function nm_qv_product_summary_close() {
	echo '</div>';
}

/* Product summary: Actions */
function nm_qv_product_summary_actions() {
	global $product, $nm_theme_options;
    $product_id = $product->get_id();
    $details_button_class = ( $nm_theme_options['product_quickview_atc'] ) ? ' border' : '';
    // Details button
    echo '<a href="' . esc_url( get_permalink( $product_id ) ) . '" class="nm-qv-details-button button' . esc_attr( $details_button_class ) . '">' . esc_html__( 'Details', 'nm-framework' ) . '</a>';
}

// Action: woocommerce_single_product_summary
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
if ( ! $nm_theme_options['product_quickview_atc'] ) {
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
}
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'nm_qv_product_summary_open', 1 );
add_action( 'woocommerce_single_product_summary', 'nm_qv_product_summary_divider', 15 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 21 );
if ( $nm_theme_options['product_quickview_details_button'] ) {
    add_action( 'woocommerce_single_product_summary', 'nm_qv_product_summary_actions', 30 );
}
add_action( 'woocommerce_single_product_summary', 'nm_qv_product_summary_close', 100 );

// Main wrapper class
$class = 'product' . ' product-' . $product->get_type();

?>

<div id="product-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
	<div class="nm-qv-product-image">
		<?php wc_get_template( 'quickview/product-image.php' ); ?>
	</div>
    
    <div class="nm-qv-summary">
        <div id="nm-qv-product-summary" class="summary">
        	<?php
				/**
				 * woocommerce_single_product_summary hook
				 *
				 * @hooked nm_qv_product_summary_open - 1
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked nm_qv_product_summary_divider - 15
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_rating - 21
                 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked nm_qv_product_summary_actions - 30
				 * @hooked woocommerce_template_single_sharing - 50
				 * @hooked nm_qv_product_summary_close - 100
				 */
				do_action( 'woocommerce_single_product_summary' );
			?>
        </div>
    </div>
</div>
