<?php
/**
 * Single Product Share
 *
 * Sharing plugins can hook into here or you can add your own code directly.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/share.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 NM: Modified */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $nm_theme_options, $nm_globals, $post;

if ( $nm_theme_options['product_share_buttons'] ) {
    $wrapper_class = ' has-share-buttons';
    
    $permalink_escaped = esc_url( get_permalink() );
    $product_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), false, '' );

    $share_links_escaped = apply_filters( 'nm_product_share_links', array(
        '<a href="//www.facebook.com/sharer.php?u=' . $permalink_escaped . '" target="_blank" title="' . esc_attr__( 'Share on Facebook', 'nm-framework' ) . '"><i class="nm-font nm-font-facebook"></i></a>',
        '<a href="//twitter.com/share?url=' . $permalink_escaped . '" target="_blank" title="' . esc_attr__( 'Share on Twitter', 'nm-framework' ) . '"><i class="nm-font nm-font-twitter"></i></a>',
        '<a href="//pinterest.com/pin/create/button/?url=' . $permalink_escaped . '&amp;media=' . esc_url( $product_image[0] ) . '&amp;description=' . urlencode( get_the_title() ) . '" target="_blank" title="' . esc_attr__( 'Pin on Pinterest', 'nm-framework' ) . '"><i class="nm-font nm-font-pinterest"></i></a>'
    ) );
} else {
    $wrapper_class = '';
}
?>

<div class="nm-product-share-wrap<?php echo esc_attr( $wrapper_class ); ?>">
	<?php if ( $nm_globals['wishlist_enabled'] ) : ?>
    <div class="nm-product-wishlist-button-wrap">
		<?php nm_wishlist_button(); ?>
    </div>
    <?php endif; ?>
    
    <?php if ( $nm_theme_options['product_share_buttons'] ) : ?>
    <div class="nm-product-share">
        <?php
            foreach ( $share_links_escaped as $link_escaped ) {
                echo $link_escaped;
            }
        ?>
    </div>
    <?php endif; ?>
</div>

<?php do_action( 'woocommerce_share' ); // Sharing plugins can hook into here

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
