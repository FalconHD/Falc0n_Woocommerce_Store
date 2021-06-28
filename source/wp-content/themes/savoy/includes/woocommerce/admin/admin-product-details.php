<?php
/*
 *	WooCommerce admin: Product details
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/*
 * Product details: Register meta boxes
 */
function nm_product_details_meta_box_register() {
    global $nm_theme_options;
    
    // Meta box: Product layout
    add_meta_box(
        'nm-product-layout',
        esc_html__( 'Product Layout', 'nm-framework-admin' ),
        'nm_meta_box_product_layout',
        'product',
        'side'
    );
    
    // Meta box: Product image swap
    if ( ! $nm_theme_options['product_hover_image_global'] ) {
        add_meta_box(
            'nm-product-meta-image-swap',
            esc_html__( 'Product Image Swap', 'nm-framework-admin' ),
            'nm_meta_box_product_image_swap',
            'product',
            'side',
            'low'
        );
    }

    // Meta box: Featured video
    add_meta_box(
        'nm-product-meta-featured-video',
        esc_html__( 'Featured Video', 'nm-framework-admin' ),
        'nm_meta_box_featured_video',
        'product',
        'side',
        'low'
    );


    // Meta box: Product description layout
    add_meta_box(
        'nm-product-description-layout',
        esc_html__( 'Product Description Layout', 'nm-framework-admin' ),
        'nm_meta_box_product_description_layout',
        'product',
        'side',
        'low'
    );
}
add_action( 'add_meta_boxes', 'nm_product_details_meta_box_register', 100 ); // Note: Using "100" (priority) to place the meta box after the last WooCommerce meta box


/*
 * Meta box: Product layout
 */
function nm_meta_box_product_layout( $post ) {
    // Nonce field for validation in "nm_product_details_meta_box_save()"
    wp_nonce_field( 'nm-framework', 'nm_nonce_product_details_meta_box' );

    // Get post meta
    $product_layout = get_post_meta( $post->ID, 'nm_product_layout', true );
    
    $selected_value = ( $product_layout !== '' ) ? $product_layout : '';
    
    echo '
        <div>
            <label for="nm_product_layout">
                <select id="nm_product_layout" name="nm_product_layout" rows="6">
                    <option value="">Default</option>
                    <option value="default-thumbs-h" ' . selected( $selected_value, 'default-thumbs-h', false ) . '>Horizontal Thumbnails</option>
                    <option value="default" ' . selected( $selected_value, 'default', false ) . '>Vertical Thumbnails</option>
                    <option value="scrolling scrolling-single" ' . selected( $selected_value, 'scrolling scrolling-single', false ) . '>Scrolling</option>
                    <option value="scrolling scrolling-grid" ' . selected( $selected_value, 'scrolling scrolling-grid', false ) . '>Scrolling Grid</option>
                    <option value="scrolling scrolling-variable-grid" ' . selected( $selected_value, 'scrolling scrolling-variable-grid', false ) . '>Scrolling Variable Grid</option>
                    <option value="scrolling scrolling-variable-grid-2" ' . selected( $selected_value, 'scrolling scrolling-variable-grid-2', false ) . '>Scrolling Variable Grid 2</option>
                    <option value="expanded" ' . selected( $selected_value, 'expanded', false ) . '>Expanded</option>
                </select>
                <p class="howto">' . esc_html__( 'Select product layout', 'nm-framework-admin' ) . '</p>
            </label>
        </div>';
}


/*
 * Meta box: Product image swap
 */
function nm_meta_box_product_image_swap( $post ) {
    // Nonce field for validation in "nm_product_details_meta_box_save()"
    wp_nonce_field( 'nm-framework', 'nm_nonce_product_details_meta_box' );

    // Get post meta
    $image_swap = get_post_meta( $post->ID, 'nm_product_image_swap', true );

    // Is post meta saved?
    $input_checked_attr = ( $image_swap ) ? ' checked="checked"' : '';

    echo '
        <div>
            <label for="nm_product_image_swap">
                <input type="checkbox" id="nm_product_image_swap" name="nm_product_image_swap" value="1"' . $input_checked_attr . '>' . 
                esc_html__( 'Swap to first gallery image on hover', 'nm-framework-admin' ) . '
            </label>
        </div>';
}


/*
 * Meta box: Featured video
 */
function nm_meta_box_featured_video( $post ) {
    // Nonce field for validation in "nm_product_details_meta_box_save()"
    wp_nonce_field( 'nm-framework', 'nm_nonce_product_details_meta_box' );

    // Get post meta
    $featured_video_url = get_post_meta( $post->ID, 'nm_featured_product_video', true );

    $value = ( $featured_video_url ) ? $featured_video_url : '';

    echo '
        <div>
            <label for="nm_product_image_swap">
                <input type="text" id="nm_featured_product_video_input" name="nm_featured_product_video" value="' . esc_url( $value ) . '">
                <p class="howto">' . esc_html__( 'Enter a YouTube or Vimeo URL', 'nm-framework-admin' ) . '</p>
            </label>
        </div>';
}


/*
 * Meta box: Product description layout
 */
function nm_meta_box_product_description_layout( $post ) {
    // Nonce field for validation in "nm_product_details_meta_box_save()"
    wp_nonce_field( 'nm-framework', 'nm_nonce_product_details_meta_box' );

    // Get post meta
    $product_description_layout = get_post_meta( $post->ID, 'nm_product_description_full', true );

    $selected_value = ( $product_description_layout ) ? $product_description_layout : 'boxed';

    echo '
        <div>
            <label for="nm_product_description_layout">
                <select id="nm_product_description_layout" name="nm_product_description_layout" rows="6">
                    <option value="boxed" ' . selected( $selected_value, 'boxed', false ) . '>Boxed</option>
                    <option value="full" ' . selected( $selected_value, 'full', false ) . '>Full width</option>
                </select>
                <p class="howto">' . esc_html__( 'Select layout for the product description', 'nm-framework-admin' ) . '</p>
            </label>
        </div>';
}


/*
 * Product details: Saved meta box data
 */
function nm_product_details_meta_box_save( $post_id ) {
    // Verify this came from our meta boxes with proper authorization (save_post action can be triggered at other times)
    if ( nm_verify_save_action( $post_id, 'nm_nonce_product_details_meta_box' ) ) {
        
        // Product layout: Update/delete meta
        if ( isset( $_POST['nm_product_layout'] ) && $_POST['nm_product_layout'] !== '' ) {
            update_post_meta( $post_id, 'nm_product_layout', $_POST['nm_product_layout'] );
        } else {
            delete_post_meta( $post_id, 'nm_product_layout' );
        }
        
        // Product image swap: Update/delete meta
        if ( isset( $_POST['nm_product_image_swap'] ) ) {
            // Make sure value is an integer
            $image_swap_setting = absint( $_POST['nm_product_image_swap'] );

            update_post_meta( $post_id, 'nm_product_image_swap', $image_swap_setting );
        } else {
            delete_post_meta( $post_id, 'nm_product_image_swap' );
        }

        // Featured video: Update/delete meta
        if ( ! empty( $_POST['nm_featured_product_video'] ) ) {
            update_post_meta( $post_id, 'nm_featured_product_video', $_POST['nm_featured_product_video'] );
        } else {
            delete_post_meta( $post_id, 'nm_featured_product_video' );
        }


        // Product description layout: Update/delete meta
        if ( isset( $_POST['nm_product_description_layout'] ) && $_POST['nm_product_description_layout'] == 'full' ) {
            update_post_meta( $post_id, 'nm_product_description_full', $_POST['nm_product_description_layout'] );
        } else {
            delete_post_meta( $post_id, 'nm_product_description_full' );
        }

    }
}
add_action( 'save_post', 'nm_product_details_meta_box_save' );
