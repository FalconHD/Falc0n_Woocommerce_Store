<?php
    /*
     * Menus: Include custom menu "walker" class
     */
    include( NM_DIR . '/menus/class-walker-nav-menu.php' );
    
    
    /*
     * Menus: Add custom menu-item markup
     */
    function nm_nav_menu_objects( $menu_items, $args ) {
        $include_on = array(
            'main-menu'     => 1,
            'right-menu'    => 1,
            'mobile-menu'   => 1
        );
        
        // Only add markup to the menus listed in $include_on above
        if ( isset( $include_on[$args->theme_location] ) ) {
            foreach( $menu_items as $item ) {
                // Is this a sub-level (dropdown) menu link?
                if ( $item->menu_item_parent !== 0 ) {
                    // Markup: Thumbnail
                    $item_image_id = get_post_meta( $item->db_id, '_nm_menu_item_thumbnail', true );
                    if ( $item_image_id ) {
                        $item_image_size = apply_filters( 'nm_menu_thumbnail_size', 'full' );
                        $item_image_src = wp_get_attachment_image_src( $item_image_id, $item_image_size );
                        $item_image_alt = get_post_meta( $item_image_id, '_wp_attachment_image_alt', true );
                        
                        $item->classes[] = 'nm-menu-item-has-image';
                        $item->title = '<img src="' . esc_url( $item_image_src[0] ) . '" alt="' . esc_attr( $item_image_alt ) . '" width="' . $item_image_src[1] . '" height="' . $item_image_src[2] . '" class="nm-menu-item-image" /><span class="nm-menu-item-image-title">' . $item->title . '</span>';    
                    }
                }
            }
        }
        
        return $menu_items;
    }
    add_filter( 'wp_nav_menu_objects', 'nm_nav_menu_objects', 10, 2 );
