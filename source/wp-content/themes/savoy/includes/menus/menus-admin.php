<?php
    /*
     * Admin menus: Add custom fields action
     */
    function nm_edit_nav_menu_walker( $walker_class, $menu_id ) {
        $wp_menu_locations = get_nav_menu_locations(); // Get available menu location with assigned menu IDs
        
        // Create array with availbale menu locations
        // - Note: Used instead of "$available_menu_locations = array_flip( get_nav_menu_locations() );" since it can cause WPML error
        $available_menu_locations = array();
        foreach ( $wp_menu_locations as $location => $id ) {
            if ( is_numeric( $id ) ) {
                $available_menu_locations[$id] = $location;
            }
        }
        
        $exclude_from = array(
            'top-bar-menu'  => 1,
            'footer-menu'   => 1
        );
        
        $current_menu_location = isset( $available_menu_locations[$menu_id] ) ? $available_menu_locations[$menu_id] : null;
        
        // Only add custom fields when:
        if (
            ! $current_menu_location || // - No location assigned
            $current_menu_location && ! isset( $exclude_from[$current_menu_location] ) // - Non excluded location assigned
        ) {
            add_action( 'wp_nav_menu_item_custom_fields', 'nm_wp_nav_menu_item_custom_fields', 10, 5 );
        }
        
        return $walker_class;
    }
    add_filter( 'wp_edit_nav_menu_walker', 'nm_edit_nav_menu_walker', 99, 2 );
    
    
    /*
     * Admin menus: Add custom fields
     */
    function nm_wp_nav_menu_item_custom_fields( $item_id, $item, $depth, $args, $id ) {
        /* Field: Thumbnail */
        $item_image_id = get_post_meta( $item_id, '_nm_menu_item_thumbnail', true );
        
        if ( $item_image_id ) {
            $class_wrapper = ' has-thumbnail';
            $class_add_link = ' hidden';
            $class_remove_link = '';
            
            $item_image_src = wp_get_attachment_image_src( $item_image_id, 'full' );
            $item_thumbnail_html = '<img class="nm-menu-item-set-thumbnail" src="' . esc_url( $item_image_src[0] ) . '" />';
        } else {
            $class_wrapper = '';
            $class_add_link = '';
            $class_remove_link = ' hidden';
            
            $item_thumbnail_html = '<img class="nm-menu-item-set-thumbnail hidden" src="" />';
        }
        
        $field_image_id_escaped = '
            <p class="nm-field-thumbnail description description-wide' . $class_wrapper . '" data-item-id="' . $item_id . '">
                <label for="nm-edit-menu-item-thumbnail-' . $item_id . '">' .
                    esc_html__( 'Thumbnail', 'nm-framework-admin' ) . '<br>' .
                    $item_thumbnail_html . '
                </label>
                <span class="hide-if-no-js">
                    <a href="#" class="nm-menu-item-set-thumbnail' . $class_add_link . '">' . esc_html__( 'Set thumbnail', 'nm-framework-admin' ) . '</a>
                    <a href="#" class="nm-menu-item-remove-thumbnail' . $class_remove_link . '">' . esc_html__( 'Remove thumbnail', 'nm-framework-admin' ) . '</a>
                </span>
             </p>';
        
        echo $field_image_id_escaped;
    }
    
    
    /*
     * Admin menus: Save custom fields
     */
    function nm_update_nav_menu_item( $menu_id, $menu_item_db_id, $args ) {
        /* Field: Thumbnail */
        if ( isset( $_REQUEST['nm-menu-item-thumbnail'] ) && is_array( $_REQUEST['nm-menu-item-thumbnail'] ) ) {
            // Make sure $_REQUEST value is for the current menu-item (input tags included individually with JS when adding/removing image to avoid "max_input_vars" PHP error on menu-page save)
            if ( isset( $_REQUEST['nm-menu-item-thumbnail'][$menu_item_db_id] ) ) {
                $item_image_id = $_REQUEST['nm-menu-item-thumbnail'][$menu_item_db_id];

                if ( strlen( $item_image_id ) > 0 ) {
                    update_post_meta( $menu_item_db_id, '_nm_menu_item_thumbnail', intval( $item_image_id ) );
                } else {
                    delete_post_meta( $menu_item_db_id, '_nm_menu_item_thumbnail' );    
                }
            }
        }
    }
    add_action( 'wp_update_nav_menu_item', 'nm_update_nav_menu_item', 10, 3 );
