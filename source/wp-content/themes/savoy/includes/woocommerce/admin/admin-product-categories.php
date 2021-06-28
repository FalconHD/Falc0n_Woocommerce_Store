<?php
/*
 *	WooCommerce admin: Product categories
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class NM_Product_Categories {
    
    /*
	 * Constructor
	 */
	public function __construct() {
        add_action( 'product_cat_add_form_fields', array( $this, 'add_fields' ), 10, 2 );
        add_action( 'product_cat_edit_form_fields', array( $this, 'edit_fields' ), 10, 2 );
        add_action( 'create_product_cat', array( $this, 'save_fields' ), 10, 2 );
        add_action( 'edited_product_cat', array( $this, 'save_fields' ), 10, 2 );
    }

    
    /*
     * Product category - Add: Add fields
     */
    function add_fields() {
        /* Field: Categories Grid Title */
        ?>
        <div class="form-field nm-term-title-wrap">
            <label for="nm_categories_description"><?php esc_html_e( 'Categories Grid Title', 'nm-framework' ); ?></label>
            <input type="text" id="nm-categories-description" name="nm_categories_description" value="" size="40">
            <p><?php esc_html_e( 'Enter a custom title to display in the "Product Categories" element.','nm-framework' ); ?></p>
        </div>
        <?php
        
        /* Field: Menu Thumbnail - Code from "add_category_fields()" function in ../woocommerce/includes/admin/class-wc-admin-taxonomies.php" file */
        ?>
        <div class="form-field nm-cat-menu-thumbnail-wrap">
			<label><?php esc_html_e( 'Menu Thumbnail', 'nm-framework' ); ?></label>
			<div id="nm_cat_menu_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px" height="60px" /></div>
			<div style="line-height: 60px;">
				<input type="hidden" id="nm_cat_menu_thumbnail_id" name="nm_cat_menu_thumbnail_id" />
				<button type="button" class="nm-upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'woocommerce' ); ?></button>
				<button type="button" class="nm-remove_image_button button"><?php esc_html_e( 'Remove image', 'woocommerce' ); ?></button>
			</div>
			<script type="text/javascript">
				// Only show the "remove image" button when needed
				if (!jQuery('#nm_cat_menu_thumbnail_id').val()) { jQuery('.remove_image_button').hide(); }

				// Uploading files
				var file_frame;
				jQuery(document).on('click', '.nm-upload_image_button', function(event) {
					event.preventDefault();
					// If the media frame already exists, reopen it.
					if (file_frame) {
						file_frame.open();
						return;
					}

					// Create the media frame.
					file_frame = wp.media.frames.downloadable_file = wp.media({
						title: '<?php esc_html_e( 'Choose an image', 'woocommerce' ); ?>',
						button: {
							text: '<?php esc_html_e( 'Use image', 'woocommerce' ); ?>'
						},
						multiple: false
					});

					// When an image is selected, run a callback.
					file_frame.on('select', function() {
						var attachment = file_frame.state().get( 'selection' ).first().toJSON();
						var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

						jQuery('#nm_cat_menu_thumbnail_id').val(attachment.id);
						jQuery('#nm_cat_menu_thumbnail').find('img').attr('src', attachment_thumbnail.url);
						jQuery('.nm-remove_image_button').show();
					});

					// Finally, open the modal.
					file_frame.open();
				});

				jQuery(document).on('click', '.nm-remove_image_button', function() {
					jQuery('#nm_cat_menu_thumbnail').find('img').attr('src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>');
					jQuery('#nm_cat_menu_thumbnail_id').val('');
					jQuery('.nm-remove_image_button').hide();
					return false;
				});

				jQuery(document).ajaxComplete(function(event, request, options) {
					if (request && 4 === request.readyState && 200 === request.status && options.data && 0 <= options.data.indexOf('action=add-tag')) {
						var res = wpAjax.parseAjaxResponse(request.responseXML, 'ajax-response');
						if (! res || res.errors) { return; }
						// Clear Thumbnail fields on submit
						jQuery('#nm_cat_menu_thumbnail').find('img').attr('src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>');
						jQuery('#nm_cat_menu_thumbnail_id').val('');
						jQuery('.nm-remove_image_button').hide();
						// Clear Display type field on submit
						jQuery('#display_type').val('');
						return;
					}
				});
			</script>
			<div class="clear"></div>
		</div>
        <?php
    }


    /*
     * Product category - Edit: Add fields
     */
    function edit_fields( $term ) {
        /* Field: Categories Grid Title */
        $saved_data = get_option( 'nm_taxonomy_product_cat_' . $term->term_id . '_description' ); // Get custom field's saved data ?> 
        <tr class="form-field nm-term-title-wrap">
            <th scope="row"><label for="nm_categories_description"><?php esc_html_e( 'Categories Grid Title', 'nm-framework' ); ?></label></th>
            <td>
                <input type="text" id="nm-categories-description" name="nm_categories_description" value="<?php echo ( $saved_data ) ? esc_attr( $saved_data ) : '' ;?>" size="40" aria-required="true">
                <p class="description"><?php esc_html_e( 'Enter a custom title to display in the "Product Categories" element.','nm-framework' ); ?></p>
            </td>
        </tr>
        <?php
        
        /* Field: Menu Thumbnail - Code from "edit_category_fields()" function in ../woocommerce/includes/admin/class-wc-admin-taxonomies.php" file */
        $thumbnail_id = absint( get_term_meta( $term->term_id, 'nm_cat_menu_thumbnail_id', true ) );
        $image = ( $thumbnail_id ) ? wp_get_attachment_thumb_url( $thumbnail_id ) : wc_placeholder_img_src();
        ?>
        <tr class="form-field nm-cat-menu-thumbnail-wrap">
			<th scope="row" valign="top"><label><?php esc_html_e( 'Menu Thumbnail', 'nm-framework' ); ?></label></th>
			<td>
				<div id="nm_cat_menu_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" /></div>
				<div style="line-height: 60px;">
					<input type="hidden" id="nm_cat_menu_thumbnail_id" name="nm_cat_menu_thumbnail_id" value="<?php echo esc_attr( $thumbnail_id ); ?>" />
					<button type="button" class="nm-upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'woocommerce' ); ?></button>
					<button type="button" class="nm-remove_image_button button"><?php esc_html_e( 'Remove image', 'woocommerce' ); ?></button>
				</div>
				<script type="text/javascript">
					// Only show the "remove image" button when needed
					if ('0' === jQuery('#nm_cat_menu_thumbnail_id').val()) { jQuery('.nm-remove_image_button').hide(); }

					// Uploading files
					var file_frame;

					jQuery(document).on('click', '.nm-upload_image_button', function(event) {
						event.preventDefault();

						// If the media frame already exists, reopen it.
						if (file_frame) {
							file_frame.open();
							return;
						}

						// Create the media frame.
						file_frame = wp.media.frames.downloadable_file = wp.media({
							title: '<?php esc_html_e( 'Choose an image', 'woocommerce' ); ?>',
							button: {
								text: '<?php esc_html_e( 'Use image', 'woocommerce' ); ?>'
							},
							multiple: false
						});

						// When an image is selected, run a callback.
						file_frame.on('select', function() {
							var attachment = file_frame.state().get('selection').first().toJSON();
							var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

							jQuery('#nm_cat_menu_thumbnail_id').val(attachment.id);
							jQuery('#nm_cat_menu_thumbnail').find('img').attr('src', attachment_thumbnail.url);
							jQuery('.nm-remove_image_button').show();
						});

						// Finally, open the modal.
						file_frame.open();
					});

					jQuery(document).on('click', '.nm-remove_image_button', function() {
						jQuery('#nm_cat_menu_thumbnail').find('img').attr('src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
						jQuery('#nm_cat_menu_thumbnail_id').val('');
						jQuery('.nm-remove_image_button').hide();
						return false;
					});
				</script>
				<div class="clear"></div>
			</td>
		</tr>
        <?php
    }


    /*
     * Product category - Save: Save fields
     */
    function save_fields( $term_id ) {
        /* Field: Categories Grid Title */
        if ( isset( $_POST['nm_categories_description'] ) ) {           
            $data = stripslashes_deep( esc_html( $_POST['nm_categories_description'] ) ); // Escape data before saving
            update_option( 'nm_taxonomy_product_cat_' . $term_id . '_description', $data ); // Save custom field data
        }
        
        /* Field: Menu Thumbnail */
        if ( isset( $_POST['nm_cat_menu_thumbnail_id'] ) ) {
            update_term_meta( $term_id, 'nm_cat_menu_thumbnail_id', absint( $_POST['nm_cat_menu_thumbnail_id'] ) );
            // Note: Not deleting term meta here since WooCommerce is using the same entry to store other category data (like "Thumbnail")
		}
    }

}

$NM_Product_Categories = new NM_Product_Categories();