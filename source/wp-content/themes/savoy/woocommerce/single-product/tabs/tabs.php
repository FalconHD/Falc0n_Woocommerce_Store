<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 NM: Modified */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $nm_theme_options, $product;

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

/* Description */
$nm_product_description_layout_meta = get_post_meta( $product->get_id(), 'nm_product_description_full', true );
if ( $nm_theme_options['product_description_layout'] == 'full' || ! empty( $nm_product_description_layout_meta ) ) {
    $description_layout_full = true;
    $description_layout_class = ' description-full';
} else {
    $description_layout_full = false;
    $description_layout_class = '';
}

if ( ! empty( $product_tabs ) ) : ?>
		
    <?php 
    /*
     * Accordion
     */
    if ( $nm_theme_options['product_tabs_layout'] == 'summary' ) :
    ?>

    <div id="nm-product-accordion">
        <?php
        foreach ( $product_tabs as $key => $product_tab ) :
            $panel_class = ( $key == 'description' ) ? ' entry-content' : '';
        ?>
        <div class="nm-product-accordion-panel nm-product-accordion-panel-<?php echo esc_attr( $key ); ?>">
            <a href="#panel-<?php echo esc_attr( $key ); ?>" class="nm-product-accordion-heading">
                <?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
            </a>

            <div class="nm-product-accordion-content">
                <div class="nm-product-accordion-content-inner<?php echo esc_attr( $panel_class ); ?>">
                <?php
                if ( isset( $product_tab['callback'] ) ) { 
                    call_user_func( $product_tab['callback'], $key, $product_tab );
                }
                ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php 
    /*
     * Tabs
     */
    else :
    ?>

    <div class="woocommerce-tabs wc-tabs-wrapper<?php echo esc_attr( $description_layout_class ); ?>">
        <div class="nm-product-tabs-col">
            <div class="nm-row">
                <div class="col-xs-12">
                    <ul class="tabs wc-tabs" role="tablist">
                        <?php foreach ( $product_tabs as $key => $product_tab ) : ?>
                            <li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
                                <a href="#tab-<?php echo esc_attr( $key ); ?>">
                                    <?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <?php
            foreach ( $product_tabs as $key => $product_tab ) :

                if ( $key == 'description' ) {
                    $tab_panel_class = $description_layout_class . ' entry-content';
                    $tab_is_description = true;
                } else {
                    $tab_panel_class = '';
                    $tab_is_description = false;
                }
            ?>
                <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel wc-tab" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
                    <?php
                        if ( $tab_is_description && $description_layout_full ) :
                            call_user_func( $product_tab['callback'], $key, $product_tab );
                        else :
                    ?>
                    <div class="nm-row">
                        <div class="col-xs-12">
                            <div class="nm-tabs-panel-inner<?php echo esc_attr( $tab_panel_class ); ?>">
                                <?php
                                if ( isset( $product_tab['callback'] ) ) { 
                                    call_user_func( $product_tab['callback'], $key, $product_tab );
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php endif; ?>

<?php endif; ?>
