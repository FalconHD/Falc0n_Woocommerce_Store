<?php

/*
 * WooCommerce
=============================================================== */

global $nm_theme_options, $nm_globals;



/*
 *  Disable default WooCommerce styles
 */
add_filter( 'woocommerce_enqueue_styles', '__return_false' );



/*
 *	My Account - Login (AJAX): Get nonce fields
 */
function nm_ajax_login_get_nonces() {
    $nonces = array(
        'login'     => wp_create_nonce( 'woocommerce-login' ),
        'register'  => wp_create_nonce( 'woocommerce-register' )
    );
    echo json_encode( $nonces );
    exit;
}
//add_action( 'wp_ajax_nm_ajax_login_get_nonces' , 'nm_ajax_login_get_nonces' );
//add_action( 'wp_ajax_nopriv_nm_ajax_login_get_nonces', 'nm_ajax_login_get_nonces' );
// Register WooCommerce Ajax endpoint (available since 2.4)
add_action( 'wc_ajax_nm_ajax_login_get_nonces', 'nm_ajax_login_get_nonces' );



/*
 *	Set default image-size options
 */
if ( ! function_exists( 'nm_woocommerce_set_image_dimensions' ) ) {
    function nm_woocommerce_set_image_dimensions() {
        if ( ! get_option( 'nm_shop_image_sizes_set' ) ) {
            global $woocommerce;

            if ( version_compare( $woocommerce->version, 3.3, '>=' ) ) {
                // WooCommerce 3.3 and above: Set WP Customizer image-size options - Code from "wc_update_330_image_options()" function in "../woocommerce/includes/wc-update-functions.php" file
                update_option( 'woocommerce_thumbnail_image_width', 350 );
                update_option( 'woocommerce_thumbnail_cropping', 'uncropped' );
                update_option( 'woocommerce_single_image_width', 680 );
            } else {
                // WooCommerce 3.2 and below: Set image-size options
                $catalog = array(
                    'width' 	=> '350',
                    'height'	=> '',
                    'crop'		=> ''
                );
                $single = array(
                    //'width' 	=> '595',
                    'width' 	=> '680',
                    'height'	=> '',
                    'crop'		=> ''
                );
                $thumbnail = array(
                    'width' 	=> '',
                    'height'	=> '127',
                    'crop'		=> ''
                );
                update_option( 'shop_catalog_image_size', $catalog );
                update_option( 'shop_single_image_size', $single );
                update_option( 'shop_thumbnail_image_size', $thumbnail );
            }

            // Set "image sizes set" option
            add_option( 'nm_shop_image_sizes_set', '1' );
        }
    }
}
add_action( 'after_switch_theme', 'nm_woocommerce_set_image_dimensions', 1 ); // Theme activation hook
add_action( 'admin_init', 'nm_woocommerce_set_image_dimensions', 1000 ); // Additional hook for when WooCommerce is activated after the theme



/*
 *	WP Customizer: Remove default WooCommerce options
 */
function nm_woocommerce_remove_customize_options( $wp_customize ) {
    $wp_customize->remove_control( 'woocommerce_catalog_columns' );
    $wp_customize->remove_control( 'woocommerce_catalog_rows' );
    //$wp_customize->remove_panel( '...' );
    //$wp_customize->remove_section( '...' );
}
add_action( 'customize_register', 'nm_woocommerce_remove_customize_options' );



/*
 *  Shop: Products per page
 */
function nm_woocommerce_products_per_page( $cols ) {
    global $nm_theme_options;
    
    $products_per_page = ( strlen( $nm_theme_options['products_per_page'] ) > 0 ) ? intval( $nm_theme_options['products_per_page'] ) : 12;
    return $products_per_page;
}
add_filter( 'loop_shop_per_page', 'nm_woocommerce_products_per_page', 20 );



/*
 *  Shop: Product placeholder image
 */
$product_placeholder_image = ( isset( $nm_theme_options['product_placeholder_image'] ) && isset( $nm_theme_options['product_placeholder_image']['url'] ) && strlen( $nm_theme_options['product_placeholder_image']['url'] ) > 0 ) ? $nm_theme_options['product_placeholder_image']['url'] : NM_THEME_URI . '/assets/img/placeholder.png';
$nm_globals['product_placeholder_image'] = apply_filters( 'nm_shop_placeholder_img_src', $product_placeholder_image );



/*
 *	Add-to-cart (AJAX) redirect: Include custom template
 */
function nm_ajax_add_to_cart_redirect_template() {
    if ( isset( $_REQUEST['nm-ajax-add-to-cart'] ) ) {
        wc_get_template( 'ajax/add-to-cart-fragments.php' );
        exit;
    }
}
add_action( 'wp', 'nm_ajax_add_to_cart_redirect_template', 1000 );



/*
 *	Add-to-cart (static) redirect: Add body class so the Cart panel will show
 */
if ( get_option( 'woocommerce_cart_redirect_after_add' ) != 'yes' ) { // Only show cart panel if redirect is disabled
    function nm_add_to_cart_class() {
        // Add a class to the <body> tag so it can be checked with JS
        global $nm_body_class;
        $nm_body_class[] = apply_filters( 'nm_static_atc_class', 'nm-added-to-cart' );
    }
    add_action( 'woocommerce_add_to_cart', 'nm_add_to_cart_class' );
}



/*
 *	Get cart contents count
 */
function nm_get_cart_contents_count() {
    $cart_count = apply_filters( 'nm_cart_count', WC()->cart->cart_contents_count );
    $count_class = ( $cart_count > 0 ) ? '' : ' nm-count-zero';

    return '<span class="nm-menu-cart-count count' . $count_class . '">' . $cart_count . '</span>';
}



/*
 *  Shop: Get active filters
 */
function nm_get_active_filters() {
    ob_start();
    the_widget( 'WC_Widget_Layered_Nav_Filters', array( 'title' => '' ), array( 'before_widget' => '', 'after_widget' => '' ) ); // Get individual "active" filters
    $active_filters = ob_get_clean();
    
    if ( strlen( $active_filters ) > 0 ) {
        $active_filters = preg_replace( array( '#^<ul[^>]*>#', '#</ul>$#' ), '', $active_filters ); // Remove <ul> wrapping tag
    } else {
       $active_filters = null; 
    }
    
    return $active_filters;
}



/*
 *  Shop: Get active filters count
 */
function nm_get_active_filters_count() {
    $count = 0;

    // WooCommerce source: "../plugins/woocommerce/includes/widgets/class-wc-widget-layered-nav-filters.php" (line 50)
    $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
    $count += isset( $_GET['min_price'] ) ? 1 : 0;
    $count += isset( $_GET['rating_filter'] ) ? 1 : 0;
    // /WooCommerce source

    // Count active terms/filters
    foreach ( $_chosen_attributes as $attributes ) {
        $count += count( $attributes['terms'] );
    }

    return $count;
}



/*
 *  Shop: Widget - Product Categories - Include "All" link
 */
function nm_woocommerce_product_categories_widget_args( $args ) {
    $args['show_option_all'] = esc_html__( 'All', 'woocommerce' );
    return $args;
}
add_filter( 'woocommerce_product_categories_widget_args', 'nm_woocommerce_product_categories_widget_args' );



/*
 *  Shop: Product categories - Modify category count
 */
function nm_shop_category_count( $string, $category ) {
    return '<mark class="count">' . sprintf( esc_html__( '%s products', 'nm-framework' ), $category->count ) . '</mark>';
}
add_filter( 'woocommerce_subcategory_count_html', 'nm_shop_category_count', 10, 2 );



/*
 *  Shop: Deregister "select2" for product-widgets when AJAX is enabled
 */
function nm_woocommerce_deregister_select_scripts() {
    global $nm_theme_options;

    if ( is_woocommerce() && $nm_theme_options['shop_filters_enable_ajax'] !== '0' ) {
        wp_deregister_script( 'select2' );
        wp_deregister_script( 'selectWoo' );
    }
}
$deregister_select_scripts = apply_filters( 'nm_woocommerce_deregister_select_scripts', true );
if ( $deregister_select_scripts ) {
    add_action( 'wp_enqueue_scripts', 'nm_woocommerce_deregister_select_scripts', 100 );
}



/*
 *	Single product: Set gallery options
 */
function nm_single_product_params( $params ) {
    // FlexSlider options
    if ( isset( $params['flexslider'] ) ) {
        $params['flexslider']['animation']      = 'fade';
        $params['flexslider']['smoothHeight']   = false;
        $params['flexslider']['directionNav']   = true;
        $params['flexslider']['animationSpeed'] = 300;
    }

    // PhotoSwipe options
    if ( isset( $params['photoswipe_options'] ) ) {
        $params['photoswipe_options']['showHideOpacity']        = true;
        $params['photoswipe_options']['bgOpacity']              = 1; // Note: Setting this below "1" makes slide transition slow in Chrome (using "rgba" background instead)
        $params['photoswipe_options']['loop']                   = false;
        $params['photoswipe_options']['closeOnVerticalDrag']    = false;
        $params['photoswipe_options']['barsSize']               = array( 'top' => 0, 'bottom' => 0 );
        $params['photoswipe_options']['shareEl']                = true;
        $params['photoswipe_options']['tapToClose']             = true;
        $params['photoswipe_options']['tapToToggleControls']    = false;
        $params['photoswipe_options']['shareButtons']           = array(
            array( 'id' => 'facebook', 'label' => esc_html__( 'Share on Facebook', 'nm-framework' ), 'url' => 'https://www.facebook.com/sharer/sharer.php?u={{url}}' ),
            array( 'id' => 'twitter', 'label' => esc_html__( 'Tweet', 'nm-framework' ), 'url' => 'https://twitter.com/intent/tweet?text={{text}}&url={{url}}' ),
            array( 'id' => 'pinterest', 'label' => esc_html__( 'Pin it', 'nm-framework' ), 'url' => 'http://www.pinterest.com/pin/create/button/?url={{url}}&media={{image_url}}&description={{text}}' ),
            array( 'id' => 'download', 'label' => esc_html__( 'Download image', 'nm-framework' ), 'url' => '{{raw_image_url}}', 'download' => true )
        );
    }

    return $params;
}
add_filter( 'woocommerce_get_script_data', 'nm_single_product_params' );



/*
 *	Single product: Get sale percentage
 */
function nm_product_get_sale_percent( $product ) {
    if ( $product->get_type() === 'variable' ) {
        // Get product variation prices (regular and sale)
        $product_variation_prices = $product->get_variation_prices();

        $highest_sale_percent = 0;

        foreach( $product_variation_prices['regular_price'] as $key => $regular_price ) {
            // Get sale price for current variation
            $sale_price = $product_variation_prices['sale_price'][$key];

            // Is product variation on sale?
            if ( $sale_price < $regular_price ) {
                $sale_percent = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );

                // Is current sale percent highest?
                if ( $sale_percent > $highest_sale_percent ) {
                    $highest_sale_percent = $sale_percent;
                }
            }
        }

        // Return the highest product variation sale percent
        return $highest_sale_percent;
    } else {
        $regular_price = $product->get_regular_price();
        $sale_percent = 0;

        // Make sure the percentage value can be calculated
        if ( intval( $regular_price ) > 0 ) {
            $sale_percent = round( ( ( $regular_price - $product->get_sale_price() ) / $regular_price ) * 100 );
        }

        return $sale_percent;
    }
}



/*
 *  Single product: Variation select - Change default "Choose an option" option name
 */
if ( $nm_theme_options['product_select_hide_labels'] ) {
    function nm_dropdown_variation_change_option_name( $args ) {
        $args['show_option_none'] = wc_attribute_label( $args['attribute'] );

        return $args;
    }
    add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'nm_dropdown_variation_change_option_name' );
}



/*
 *	Single product: Variations - Add "disabled" attribute for out-of-stock variation <option> elements
 */
function nm_single_product_variations_disable_out_of_stock( $active, $variation ) {
    if ( ! $variation->is_in_stock() ) {
        return false;
    }
    return $active;
}
$variations_disable_out_of_stock = apply_filters( 'nm_variation_controls_set_stock_status', false );
if ( $variations_disable_out_of_stock ) {
    add_filter( 'woocommerce_variation_is_active', 'nm_single_product_variations_disable_out_of_stock', 10, 2 );
}



/*
 *	Single product: Tabs - Change "Reviews" tab title
 */
function nm_woocommerce_reviews_tab_title( $title ) {
    $title = strtr( $title, array( 
        '(' => '<span>',
        ')' => '</span>' 
    ) );

    return $title;
}
add_filter( 'woocommerce_product_reviews_tab_title', 'nm_woocommerce_reviews_tab_title' );



/*
 * Single product: Up-sells and Related-products per page
 */
function nm_upsell_related_products_args( $args ) {
    global $nm_theme_options;

    $args['posts_per_page'] = $nm_theme_options['product_upsell_related_per_page'];
    $args['columns'] = $nm_theme_options['product_upsell_related_columns'];
    //$args['orderby'] = 'rand'; // Note: Use to change product order
    return $args;
}
add_filter( 'woocommerce_upsell_display_args', 'nm_upsell_related_products_args' );
add_filter( 'woocommerce_output_related_products_args', 'nm_upsell_related_products_args' );



/*
 *	Cart: Get refreshed header fragment
 */
if ( ! function_exists( 'nm_header_add_to_cart_fragment' ) ) {
    function nm_header_add_to_cart_fragment( $fragments ) {
        $cart_count = nm_get_cart_contents_count();
        $fragments['.nm-menu-cart-count'] = $cart_count;

        return $fragments;
    }
}
add_filter( 'woocommerce_add_to_cart_fragments', 'nm_header_add_to_cart_fragment' ); // Ensure cart contents update when products are added to the cart via Ajax



/*
 *	Cart: Get refreshed fragments
 */
function nm_get_cart_fragments( $return_array = array() ) {
    // Get cart count
    $cart_count = nm_header_add_to_cart_fragment( array() );

    // Get cart panel
    ob_start();
    woocommerce_mini_cart();
    $cart_panel = ob_get_clean();

    return apply_filters( 'woocommerce_add_to_cart_fragments', array(
        '.nm-menu-cart-count' 				=> reset( $cart_count ),
        'div.widget_shopping_cart_content'	=> '<div class="widget_shopping_cart_content">' . $cart_panel . '</div>'
    ) );
}



/*
 *	Cart: Get refreshed hash
 */
function nm_get_cart_hash() {
    return apply_filters( 'woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() );
}



/*
 *	Cart: Cross-sells per page
 */
add_filter( 'woocommerce_cross_sells_total', function() { 
    global $nm_theme_options; return $nm_theme_options['product_upsell_related_per_page'];
} );



/*
 * Cart panel: Quantity - Prevent redirect after updating cart/quantity (not required, but makes the AJAX request faster)
 */
function nm_cart_panel_update_quantity( $cart_updated ) {
    if ( isset( $_REQUEST['nm_cart_panel_update'] ) && $cart_updated ) {
        
        // Updating cart totals since this is prevented when returning "false" below (not sure if this is necessary) - see the "update_cart_action()" function in ../woocommerce/includes/class-wc-form-handler.php"
        WC()->cart->calculate_totals();
        
        return false;
    }
    
    // Make sure to return the default value if the above statement doesn't apply
	return $cart_updated;
}
add_action( 'woocommerce_update_cart_action_cart_updated', 'nm_cart_panel_update_quantity' );



/*
 *  Checkout: Default templates
 */
if ( defined( 'NM_SHOP_DEFAULT_CHECKOUT' ) ) {
    /*
     *	Disable custom template path
     */
    function nm_woocommerce_disable_template_path() {
        // Returning an invalid template-path will ensure the default WooCommerce templates are used
        return 'nm-woocommerce-disable/';
    }

    /*
     *	Checkout: Disable custom checkout templates
     */
    function nm_woocommerce_disable_custom_checkout_templates() {
        if ( is_checkout() ) {
            add_filter( 'woocommerce_template_path', 'nm_woocommerce_disable_template_path' );
        }
    }
    add_action( 'wp', 'nm_woocommerce_disable_custom_checkout_templates' );
}



/*
 *  Checkout: Required field notices
 */
if ( $nm_theme_options['checkout_inline_notices'] ) {
    $nm_globals['checkout_required_notices_count'] = 0;

    function nm_checkout_required_field_notice( $notice ) {
        global $nm_globals;

        $nm_globals['checkout_required_notices_count']++;

        // Display a single generic notice instead of one for each field
        if ( $nm_globals['checkout_required_notices_count'] > 1 ) {
            return '';  
        } else {
            return esc_html__( 'Please fill in the required fields', 'nm-framework' );
        }
    }
    add_filter( 'woocommerce_checkout_required_field_notice', 'nm_checkout_required_field_notice' );
}



/*
 *  Checkout: Replace PayPal icon
 */
function nm_replace_paypal_icon() {
    return NM_THEME_URI . '/assets/img/paypal-icon.png';
}
add_filter( 'woocommerce_paypal_icon', 'nm_replace_paypal_icon' );
