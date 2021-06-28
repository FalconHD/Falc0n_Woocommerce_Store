<?php
/*
 * NM - Admin meta
 */


/*
 *  Admin meta: Verify save action
 */
function nm_verify_save_action( $post_id, $meta_box_nonce_name ) {
    // NM: WP code - https://codex.wordpress.org/Function_Reference/add_meta_box

    /* We need to verify this came from our screen and with proper authorization, because the save_post action can be triggered at other times. */

    // Check if our nonce is set.
    if ( ! isset( $_POST[$meta_box_nonce_name] ) ) {
        return false;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST[$meta_box_nonce_name], 'nm-framework' ) ) {
        return false;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return false;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return false;
        }
    } else {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return false;
        }
    }

    /* OK, it's safe for us to save the data now. */
    return true;

    // /NM: WP code
}



/*
 *  Page: Register meta boxes
 */
function nm_page_meta_box_register() {
    // Meta box: Header transparency
    add_meta_box(
        'nm-page-header-transparency',
        esc_html__( 'Header Transparency', 'nm-framework-admin' ),
        'nm_meta_box_page_header_transparency',
        'page',
        'side',
        'low'
    );
}
add_action( 'add_meta_boxes', 'nm_page_meta_box_register', 100 ); // Note: Using "100" (priority) to place the meta box after the last WP meta box



/*
 *  Meta box: Page - Header transparency
 */
function nm_meta_box_page_header_transparency( $post ) {
    wp_nonce_field( 'nm-framework', 'nm_nonce_post_meta_box' ); // Nonce field for validating when saving

    $header_transparency = get_post_meta( $post->ID, 'nm_page_header_transparency', true );
    
    // Hide setting on home and shop page (correct page-ID not available on front-end)
    $hide_setting = ( $post->ID == get_option( 'page_on_front' ) || $post->ID == get_option( 'woocommerce_shop_page_id' ) ) ? true : false;
    
    if ( $hide_setting ) {
        echo '
            <div>
                <label for="nm_page_header_transparency">
                    <p>' . esc_html__( 'Set on "Theme Settings > Header"', 'nm-framework-admin' ) . '</p>
                </label>
            </div>';
    } else {
        echo '
            <div>
                <label for="nm_page_header_transparency">
                    <select id="nm_page_header_transparency" name="nm_page_header_transparency" rows="6">
                        <option value="">' . esc_html__( 'Disabled', 'nm-framework-admin' ) . '</option>
                        <option value="light" ' . selected( $header_transparency, 'light', false ) . '>' . esc_html__( 'Light', 'nm-framework-admin' ) . '</option>
                        <option value="dark" ' . selected( $header_transparency, 'dark', false ) . '>' . esc_html__( 'Dark', 'nm-framework-admin' ) . '</option>
                    </select>
                    <p class="howto">' . esc_html__( 'Select header-transparency for this page', 'nm-framework-admin' ) . '</p>
                </label>
            </div>';
    }
}



/*
 *  Save post: Save meta box data
 */
function nm_page_meta_box_save( $post_id ) {
    // Verify this came from our meta boxes with proper authorization (save_post action can be triggered at other times)
    if ( nm_verify_save_action( $post_id, 'nm_nonce_post_meta_box' ) ) {
        
        // Page - Header transparency: Update/delete post meta
        if ( isset( $_POST['nm_page_header_transparency'] ) && strlen( $_POST['nm_page_header_transparency'] ) > 0 ) {
            update_post_meta( $post_id, 'nm_page_header_transparency', $_POST['nm_page_header_transparency'] );
        } else {
            delete_post_meta( $post_id, 'nm_page_header_transparency' );
        }
        
    }
}
add_action( 'save_post', 'nm_page_meta_box_save' );