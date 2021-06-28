<?php
/**
 *	NM: Shop - Taxonomy banner/header
 */

defined( 'ABSPATH' ) || exit;

global $nm_theme_options;

// Product taxonomy image
$header_image_id    = apply_filters( 'nm_taxonomy_header_image_id', get_term_meta( get_queried_object_id(), 'thumbnail_id', true ) );
$header_image_url   = wp_get_attachment_url( $header_image_id );
$header_image_class = $header_image_style_attr_escaped = '';
if ( $header_image_url ) {
    $header_image_class = ' has-image';
    $header_image_style_attr_escaped = ' style="background-image: url(' . esc_url( $header_image_url ) . ');"';
}

$header_text_column_class = apply_filters( 'nm_category_header_column_class', 'col-xs-12 col-' . $nm_theme_options['shop_taxonomy_header_text_alignment'] );
?>
<div id="nm-shop-taxonomy-header" class="nm-shop-taxonomy-header<?php echo esc_attr( $header_image_class ); ?>">
    <div class="nm-shop-taxonomy-header-inner"<?php echo $header_image_style_attr_escaped; ?>>
        <div class="nm-shop-taxonomy-text align-<?php echo esc_attr( $nm_theme_options['shop_taxonomy_header_text_alignment'] ); ?>">
            <div class="nm-row">
                <div class="nm-shop-taxonomy-text-col <?php echo esc_attr( $header_text_column_class ); ?>">
                    <h1><?php woocommerce_page_title(); ?></h1>
                    <?php
                        /**
                         * woocommerce_archive_description hook
                         *
                         * @hooked woocommerce_taxonomy_archive_description - 10
                         * @hooked woocommerce_product_archive_description - 10
                         */
                        do_action( 'woocommerce_archive_description' );
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>