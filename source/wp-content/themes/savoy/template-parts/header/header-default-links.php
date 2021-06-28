<?php
global $nm_globals, $nm_theme_options;

$default_links = array();

// Search
if ( $nm_globals['shop_search_header'] ) {
    $default_links['search'] = '<li class="nm-menu-search menu-item-default"><a href="#" id="nm-menu-search-btn"><i class="nm-font nm-font-search"></i></a></li>';
}

// Wishlist
if ( $nm_globals['wishlist_enabled'] && $nm_theme_options['menu_wishlist'] ) {
    $wishlist_link_escaped = ( function_exists( 'nm_wishlist_get_header_link' ) ) ? nm_wishlist_get_header_link() : '';
    $default_links['wishlist'] = '<li class="nm-menu-wishlist menu-item-default">' . $wishlist_link_escaped . '</li>';
}

// Login/My Account
if ( nm_woocommerce_activated() && $nm_theme_options['menu_login'] ) {
    $default_links['my_account'] = '<li class="nm-menu-account menu-item-default">' . nm_get_myaccount_link( true ) . '</li>'; // Args: $is_header
}

// Cart
if ( $nm_globals['cart_link'] ) {
    $cart_menu_class = ( $nm_theme_options['menu_cart_icon'] ) ? 'has-icon' : 'no-icon';
    $cart_url = ( $nm_globals['cart_panel'] ) ? '#' : wc_get_cart_url();
    
    $default_links['cart'] = sprintf(
        '<li class="nm-menu-cart menu-item-default %s"><a href="%s" id="nm-menu-cart-btn">%s %s</a></li>',
        esc_attr( $cart_menu_class ),
        esc_url( $cart_url ),
        nm_get_cart_title(),
        nm_get_cart_contents_count()
    );
}

$default_links = apply_filters( 'nm_header_default_links', $default_links );

foreach( $default_links as $default_link ) {
    echo $default_link;
}
