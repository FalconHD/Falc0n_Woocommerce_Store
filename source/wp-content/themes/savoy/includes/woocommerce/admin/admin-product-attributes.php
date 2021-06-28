<?php
/*
 *	WooCommerce admin: Product attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class NM_Product_Attributes {
    
    protected $pa_types = array();
    
    
    /*
	 * Constructor
	 */
	public function __construct() {
        global $nm_globals;
        
        $this->pa_types = $nm_globals['pa_variation_controls'];
        
		add_action( 'admin_enqueue_scripts', array( $this, 'pa_assets' ) );
        add_action( 'admin_init', array( $this, 'pa_hooks' ) );
	}
    
    
    /*
     * Assets
     */
    public function pa_assets( $hook ) {
        if ( 'edit-tags.php' != $hook && 'term.php' != $hook ) {
            return;
        }
        
        // Color picker
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'nm-wp-color-picker', NM_URI . '/assets/js/nm-wp-attributes-color-picker-init.js', array( 'jquery' ), false );
        
        // Media library/uploader used for "Image" type
        wp_enqueue_media();
    }
    
    
	/*
	 * Actions and filters
	 */
	public function pa_hooks() {
		$attribute_taxonomies = wc_get_attribute_taxonomies();
		if ( ! empty( $attribute_taxonomies ) ) {
            foreach ( $attribute_taxonomies as $taxonomy ) {
                add_action( 'pa_' . $taxonomy->attribute_name . '_add_form_fields', array( $this, 'pa_term_add_form_fields' ) );
                add_action( 'pa_' . $taxonomy->attribute_name . '_edit_form_fields', array( $this, 'pa_term_edit_form_fields' ), 1, 2 );
            }
            add_action( 'created_term', array( $this, 'pa_term_save' ), 10, 2 );
            add_action( 'edit_term', array( $this, 'pa_term_save' ), 10, 2 );
        }
        
        add_filter( 'product_attributes_type_selector', array( $this, 'pa_add_types' ) );
	}
    
    
    /*
	 * Product attribute: Add/edit form - Add custom attribute types to existing "Type" option/select
     *
     * Note: The "Type" option only shows when multiple types/options are available
	 */
	public function pa_add_types( $pa_types ) {
        // Is this the product-attribute add/edit form?
        // - Custom attribute-types disables the default term (colors, sizes) selector when editing a product - see line 38 of the "../woocommerce/includes/admin/meta-boxes/views/html-product-attribute.php" file
        if ( isset( $_GET['page'] ) && $_GET['page'] == 'product_attributes' ) {
		  $pa_types = array_merge( $pa_types, $this->pa_types );
        }
		return $pa_types;
	}
    
    
    /*
     * Product attribute - Term: Add form - Include custom fields
     */
    public function pa_term_add_form_fields( $taxonomy ) {
        $attr = nm_woocommerce_get_taxonomy_attribute( $taxonomy );
        $type = $attr->attribute_type;
        
        // Field: Color
        if ( $type == 'color' ) :
            ?>
            <div class="form-field term-nm_pa_color-wrap">
                <label for="nm_pa_color"><?php esc_html_e( 'Color', 'nm-framework-admin' ); ?></label>
                <input type="text" id="nm_pa_color" name="nm_pa_color" class="nm_pa_color-picker" value="" size="40">
            </div>
            <?php
        
        // Field: Image - Code based on "add_category_fields()" function in "../plugins/woocommerce/includes/admin/admin-product-attributes.php" file
        elseif ( $type == 'image' ) :
            ?>
            <div class="form-field term-nm_pa_image-wrap">
                <label><?php esc_html_e( 'Image', 'woocommerce' ); ?></label>
                <div id="nm_pa_image_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px" height="60px" /></div>
                <div style="line-height: 60px;">
                    <input type="hidden" id="nm_pa_image_thumbnail_id" name="nm_pa_image_thumbnail_id" />
                    <button type="button" class="nm-upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'woocommerce' ); ?></button>
                    <button type="button" class="nm-remove_image_button button"><?php esc_html_e( 'Remove image', 'woocommerce' ); ?></button>
                </div>
                <script type="text/javascript">
                    // Only show the "remove image" button when needed
                    if (! jQuery('#nm_pa_image_thumbnail_id').val()) { jQuery('.nm-remove_image_button').hide(); }

                    // Uploading files
                    var file_frame;
                    jQuery(document).on('click', '.nm-upload_image_button', function(event) {
                        event.preventDefault();
                        // If the media frame already exists, reopen it.
                        if (file_frame) { file_frame.open(); return; }
                        // Create the media frame.
                        file_frame = wp.media.frames.downloadable_file = wp.media({
                            title: '<?php esc_html_e( 'Choose an image', 'woocommerce' ); ?>',
                            button: { text: '<?php esc_html_e( 'Use image', 'woocommerce' ); ?>' },
                            multiple: false
                        });
                        // When an image is selected, run a callback.
                        file_frame.on('select', function() {
                            var attachment = file_frame.state().get('selection').first().toJSON();
                            var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;
                            jQuery('#nm_pa_image_thumbnail_id').val(attachment.id);
                            jQuery('#nm_pa_image_thumbnail').find('img').attr('src', attachment_thumbnail.url);
                            jQuery('.nm-remove_image_button').show();
                        });
                        // Finally, open the modal.
                        file_frame.open();
                    });

                    jQuery(document).on('click', '.nm-remove_image_button', function() {
                        jQuery('#nm_pa_image_thumbnail').find('img').attr('src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>');
                        jQuery('#nm_pa_image_thumbnail_id').val('');
                        jQuery('.nm-remove_image_button').hide();
                        return false;
                    });
                    // NM: Clear thumbnail after adding Term via AJAX
                    jQuery(document).ajaxComplete(function(event, request, options) {
                        if (request && 4 === request.readyState && 200 === request.status && options.data && 0 <= options.data.indexOf('action=add-tag')) {
                            var res = wpAjax.parseAjaxResponse(request.responseXML, 'ajax-response');
                            if (! res || res.errors) { return; }
                            // Clear Thumbnail fields on submit
                            jQuery('#nm_pa_image_thumbnail').find('img').attr('src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>');
                            jQuery('#nm_pa_image_thumbnail_id').val('');
                            jQuery('.nm-remove_image_button').hide();
                            // Clear Display type field on submit
                            //jQuery('#display_type').val('');
                            return;
                        }
                    });
                </script>
                <div class="clear"></div>
            </div>
            <?php
        endif;
    }
    
    
    /*
     * Product attribute - Term: Edit form - Include custom field
     */
    public function pa_term_edit_form_fields( $term, $taxonomy ) {
        $attr = nm_woocommerce_get_taxonomy_attribute( $taxonomy );
        
        // Field: Color
        if ( $attr->attribute_type == 'color' ) :
            $id = $term->term_id;
            $color = '';

            if ( $id ) {
                $saved_colors = get_option( 'nm_pa_colors' );
                $color = ( isset( $saved_colors[$id] ) ) ? $saved_colors[$id] : '';
            }
            ?>
            <tr class="form-field term-nm_pa_color-wrap">
                <th scope="row">
                    <label for="nm_pa_color"><?php esc_html_e( 'Color', 'nm-framework-admin' ); ?></label>
                </th>
                <td>
                    <input type="text" id="nm_pa_color" name="nm_pa_color" class="nm_pa_color-picker" value="<?php echo esc_attr( $color ); ?>" size="40">
                </td>
            </tr>
            <?php
        
        // Field: Image - Code based on "edit_category_fields()" function in "../plugins/woocommerce/includes/admin/admin-product-attributes.php" file
        elseif ( $attr->attribute_type == 'image' ) :
            $thumbnail_id = absint( get_term_meta( $term->term_id, 'nm_pa_image_thumbnail_id', true ) );

            if ( $thumbnail_id ) {
                $image = wp_get_attachment_thumb_url( $thumbnail_id );
            } else {
                $image = wc_placeholder_img_src();
            }
            ?>
            <tr class="form-field term-nm_pa_image-wrap">
                <th scope="row" valign="top"><label><?php esc_html_e( 'Image', 'woocommerce' ); ?></label></th>
                <td>
                    <div id="nm_pa_image_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" /></div>
                    <div style="line-height: 60px;">
                        <input type="hidden" id="nm_pa_image_thumbnail_id" name="nm_pa_image_thumbnail_id" value="<?php echo esc_attr( $thumbnail_id ); ?>" />
                        <button type="button" class="nm-upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'woocommerce' ); ?></button>
                        <button type="button" class="nm-remove_image_button button"><?php esc_html_e( 'Remove image', 'woocommerce' ); ?></button>
                    </div>
                    <script type="text/javascript">
                        // Only show the "remove image" button when needed
                        if ('0' === jQuery('#nm_pa_image_thumbnail_id').val()) { jQuery('.nm-remove_image_button').hide(); }
                        
                        // Uploading files
                        var file_frame;
                        jQuery(document).on('click', '.nm-upload_image_button', function(event) {
                            event.preventDefault();
                            // If the media frame already exists, reopen it.
                            if (file_frame) { file_frame.open(); return; }
                            // Create the media frame.
                            file_frame = wp.media.frames.downloadable_file = wp.media({
                                title: '<?php esc_html_e( 'Choose an image', 'woocommerce' ); ?>',
                                button: { text: '<?php esc_html_e( 'Use image', 'woocommerce' ); ?>' },
                                multiple: false
                            });
                            // When an image is selected, run a callback.
                            file_frame.on('select', function() {
                                var attachment = file_frame.state().get( 'selection' ).first().toJSON();
                                var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;
                                jQuery('#nm_pa_image_thumbnail_id').val(attachment.id);
                                jQuery('#nm_pa_image_thumbnail').find('img').attr('src', attachment_thumbnail.url);
                                jQuery('.nm-remove_image_button').show();
                            });
                            file_frame.open(); // Finally, open the modal.
                        });
                        
                        jQuery(document).on('click', '.nm-remove_image_button', function() {
                            jQuery('#nm_pa_image_thumbnail').find('img').attr('src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>');
                            jQuery('#nm_pa_image_thumbnail_id').val('');
                            jQuery('.nm-remove_image_button').hide();
                            return false;
                        });
				    </script>
                    <div class="clear"></div>
			     </td>
            </tr>
            <?php
        endif;
    }


    /*
     * Product attribute - Term: Save custom fields
     */
    public function pa_term_save( $term_id ) {
        // Field: Color
        if ( isset( $_POST['nm_pa_color'] ) ) {
            $color = sanitize_text_field( $_POST['nm_pa_color'] );
            $saved_colors = get_option( 'nm_pa_colors' );

            // Quick edit: Don't overwrite with empty value when saving via quick edit
            if ( isset( $_REQUEST['_inline_edit'] ) ) {
                return;
            }

            // Is there a color value?
            if ( $color && strlen( $color ) > 0 ) {
                $saved_colors[$term_id] = $color;
            } else if ( isset( $saved_colors[$term_id] ) ) {
                // Delete from array if color is empty
                unset( $saved_colors[$term_id] );
            }

            update_option( 'nm_pa_colors', $saved_colors );
        }
        
        // Field: Image
        if ( isset( $_POST['nm_pa_image_thumbnail_id'] ) ) {
			update_term_meta( $term_id, 'nm_pa_image_thumbnail_id', absint( $_POST['nm_pa_image_thumbnail_id'] ) );
		}
    }

}

$NM_Product_Attributes = new NM_Product_Attributes();
