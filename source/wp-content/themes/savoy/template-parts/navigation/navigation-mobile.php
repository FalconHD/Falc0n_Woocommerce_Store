<?php 
    global $nm_theme_options, $nm_globals;
?>
<div id="nm-mobile-menu" class="nm-mobile-menu">
    <div class="nm-mobile-menu-scroll">
        <div class="nm-mobile-menu-content">
            <div class="nm-row">
                <?php if ( $nm_globals['shop_search_header'] ) : ?>
                <div class="nm-mobile-menu-top col-xs-12">
                    <ul id="nm-mobile-menu-top-ul" class="menu">
                        <li class="nm-mobile-menu-item-search menu-item">
                            <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                                <input type="text" id="nm-mobile-menu-shop-search-input" class="nm-mobile-menu-search" autocomplete="off" value="" name="s" placeholder="<?php esc_attr_e( 'Search products', 'woocommerce' ); ?>" />
                                <span class="nm-font nm-font-search"></span>
                                <input type="hidden" name="post_type" value="product" />
                            </form>
                        </li>
                    </ul>
                </div>
                <?php endif; ?>
                
                <div class="nm-mobile-menu-main col-xs-12">
                    <ul id="nm-mobile-menu-main-ul" class="menu">
                        <?php
                        if ( has_nav_menu( 'mobile-menu' ) ) {
                            // Mobile menu
                            wp_nav_menu( array(
                                'theme_location'	=> 'mobile-menu',
                                'container'       	=> false,
                                'fallback_cb'     	=> false,
                                'after' 	 		=> '<span class="nm-menu-toggle"></span>',
                                'items_wrap'      	=> '%3$s'
                            ) );
                        } else {
                            // Main menu
                            wp_nav_menu( array(
                                'theme_location'	=> 'main-menu',
                                'container'       	=> false,
                                'fallback_cb'     	=> false,
                                'after' 	 		=> '<span class="nm-menu-toggle"></span>',
                                'items_wrap'      	=> '%3$s'
                            ) );

                            // Right menu                        
                            wp_nav_menu( array(
                                'theme_location'	=> 'right-menu',
                                'container'       	=> false,
                                'fallback_cb'     	=> false,
                                'after' 	 		=> '<span class="nm-menu-toggle"></span>',
                                'items_wrap'      	=> '%3$s'
                            ) );
                        }
                        ?>
                    </ul>
                </div>
                
                <?php if ( $nm_theme_options['menu_mobile_secondary_menu'] ) : ?>
                <div class="nm-mobile-menu-secondary col-xs-12">
                    <ul id="nm-mobile-menu-secondary-ul" class="menu">
                        <?php
                        $menu_links = array();
                        
                        // Cart
                        if ( $nm_globals['cart_link'] ) {
                            $menu_links['cart'] = sprintf( '<li class="nm-mobile-menu-item-cart menu-item"><a href="%s" id="nm-mobile-menu-cart-btn">%s %s</a></li>',
                                esc_url( wc_get_cart_url() ),
                                nm_get_cart_title( false ), // Args: $allow_icon
                                nm_get_cart_contents_count()
                            );
                        }
                        
                        // Login/My Account
                        if ( nm_woocommerce_activated() && $nm_theme_options['menu_login'] ) {
                            $menu_links['my_account'] = '<li class="nm-menu-item-login menu-item">' . nm_get_myaccount_link( false, true ) . '</li>'; // Args: $allow_icon, $is_mobile_menu
                        }
                        
                        // Wishlist
                        if ( $nm_globals['wishlist_enabled'] && $nm_theme_options['menu_wishlist'] ) {
                            $wishlist_link_escaped = ( function_exists( 'nm_wishlist_get_header_link' ) ) ? nm_wishlist_get_header_link( false ) : ''; // Args: $allow_icon
                            $menu_links['wishlist'] = '<li class="nm-menu-item-wishlist menu-item">' . $wishlist_link_escaped . '</li>';
                        }
                        
                        // Top bar menu
                        $include_top_bar_menu = apply_filters( 'nm_mobile_menu_secondary_top_bar', false );
                        if ( $include_top_bar_menu && $nm_theme_options['top_bar'] ) {
                            $menu_links['top_bar'] = wp_nav_menu( array(
                                'theme_location'	=> 'top-bar-menu',
                                'container'       	=> false,
                                'fallback_cb'     	=> false,
                                'after' 	 		=> '<span class="nm-menu-toggle"></span>',
                                'echo'              => false,
                                'items_wrap'      	=> '%3$s'
                            ) );
                        }
                        
                        $menu_links = apply_filters( 'nm_mobile_menu_secondary_links', $menu_links );
                        foreach( $menu_links as $menu_link ) {
                            echo $menu_link;
                        }
                        ?>
                    </ul>
                </div>
                <?php endif; ?>
                
                <?php if ( $nm_theme_options['menu_mobile_social_icons'] ) : ?>
                <div class="nm-mobile-menu-social col-xs-12">
                    <?php echo nm_get_social_profiles( 'nm-mobile-menu-social-ul' ); // Args: $wrapper_class ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>