<?php

/*
 *	NM: Add widgets
 */

function nm_custom_widgets() {
    // WooCommerce: Custom widgets
    // NOTE: The custom WooCommerce -filter- widgets will not work without the widget-id fix (see "nm_add_woocommerce_widget_ids()" below)
    if ( class_exists( 'WC_Widget' ) ) {
        global $nm_theme_options;
        
        // Product sorting
        include_once( NM_CE_INC_DIR . '/widgets/woocommerce-product-sorting.php' );
        register_widget( 'NM_WC_Widget_Product_Sorting' );

        // Price filter list
        include_once( NM_CE_INC_DIR . '/widgets/woocommerce-price-filter.php' );
        register_widget( 'NM_WC_Widget_Price_Filter' );
    }
}
add_action( 'widgets_init', 'nm_custom_widgets' ); // Register widget sidebars

/* 
 *	Add relevant WooCommerce widget-id's to "sidebars_widgets" option so the custom product filters will work
 *
 * 	Note: WooCommerce use "is_active_widget()" to check for active widgets in: "../includes/class-wc-query.php"
 */
function nm_ce_add_woocommerce_widget_ids( $sidebars_widgets, $old_sidebars_widgets = array() ) {
    $shop_sidebar_id = 'widgets-shop';
    $shop_widgets = ( isset( $sidebars_widgets[$shop_sidebar_id] ) ) ? $sidebars_widgets[$shop_sidebar_id] : null;

    if ( is_array( $shop_widgets ) ) {
        foreach ( $shop_widgets as $widget ) {
            $widget_id = _get_widget_id_base( $widget );

            if ( $widget_id === 'nm_woocommerce_price_filter' ) {
                $sidebars_widgets[$shop_sidebar_id][] = 'woocommerce_price_filter-12345';
            } else if ( $widget_id === 'nm_woocommerce_color_filter' ) {
                $sidebars_widgets[$shop_sidebar_id][] = 'woocommerce_layered_nav-12345';
            }
        }
    }

    return $sidebars_widgets;
}
add_action( 'pre_update_option_sidebars_widgets', 'nm_ce_add_woocommerce_widget_ids' );
