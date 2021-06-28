<?php

/*
 * WooCommerce - Template functions
=============================================================== */

global $nm_theme_options, $nm_globals;



/*
 * Show WooCommerce notices
 */
function nm_print_shop_notices() {
    echo '<div id="nm-shop-notices-wrap">';
      wc_print_notices();
    echo '</div>';
}



/*
 * My-account/Login: Get link
 */
function nm_get_myaccount_link( $allow_icon = true, $is_mobile_menu = false ) {
    global $nm_theme_options;

    $myaccount_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
    
    $link_id = ( $is_mobile_menu ) ? 'nm-mobile-menu-account-btn' : 'nm-menu-account-btn';
    
    // Link title/icon
    if ( $allow_icon && $nm_theme_options['menu_login_icon'] ) {
        $link_title = apply_filters( 'nm_myaccount_icon', $nm_theme_options['menu_login_icon_html'], 'nm-font nm-font-user' );
    } else {
        $link_title = ( is_user_logged_in() ) ? esc_html__( 'My account', 'woocommerce' ) : esc_html__( 'Login', 'woocommerce' );
    }
    
    return '<a href="' . esc_url( $myaccount_url ) . '" id="' . esc_attr( $link_id ) . '">' . apply_filters( 'nm_myaccount_title', $link_title ) . '</a>';
}



/*
 * Cart: Get title/icon
 */
function nm_get_cart_title( $allow_icon = true ) {
    global $nm_theme_options;

    if ( $allow_icon && $nm_theme_options['menu_cart_icon'] ) {
        $cart_title = apply_filters( 'nm_cart_icon', $nm_theme_options['menu_cart_icon_html'], 'nm-font nm-font-shopping-cart' );
    } else {
        $cart_title = '<span class="nm-menu-cart-title">' . esc_html__( 'Cart', 'woocommerce' ) . '</span>';
    }

    return $cart_title;
}



/*
 * Category menu
 */
if ( ! function_exists( 'nm_category_menu' ) ) {
    function nm_category_menu() {
        global $wp_query, $nm_theme_options;

        $current_cat_id = ( is_tax( 'product_cat' ) ) ? $wp_query->queried_object->term_id : '';
        $is_category = ( strlen( $current_cat_id ) > 0 ) ? true : false;
        $hide_empty = ( $nm_theme_options['shop_categories_hide_empty'] ) ? true : false;

        // Should top-level categories be displayed?
        if ( $nm_theme_options['shop_categories_top_level'] == '0' && $is_category ) {
            nm_sub_category_menu_output( $current_cat_id, $hide_empty );
        } else {
            nm_category_menu_output( $is_category, $current_cat_id, $hide_empty );
        }
    }
}



/*
 * Category menu: Output
 */
if ( ! function_exists( 'nm_category_menu_output' ) ) {
    function nm_category_menu_output( $is_category, $current_cat_id, $hide_empty, $wrapper_id = 'nm-shop-categories' ) {
        global $wp_query, $nm_theme_options;

        $page_id = wc_get_page_id( 'shop' );
        $page_url = get_permalink( $page_id );
        $hide_sub = true;
        $current_top_cat_id = null;
        $all_categories_class = '';

        // Is this a category page?																
        if ( $is_category ) {
            $hide_sub = false;

            // Get current category's top-parent id
            $current_cat_parents = get_ancestors( $current_cat_id, 'product_cat' );
            if ( ! empty( $current_cat_parents ) ) {
                $current_top_cat_id = end( $current_cat_parents ); // Get last item from array
            }

            // Get current category's direct children
            $current_cat_direct_children = get_terms( 'product_cat',
                array(
                    'fields'       	=> 'ids',
                    'parent'       	=> $current_cat_id,
                    'hierarchical'	=> true,
                    'hide_empty'   	=> $hide_empty
                )
            );
            $category_has_children = ( empty( $current_cat_direct_children ) ) ? false : true;
        } else {
            // No current category, set "All" as current (if not product tag archive or search)
            if ( ! is_product_tag() && ! isset( $_REQUEST['s'] ) ) {
                $all_categories_class = ' class="current-cat"';
            }
        }
        
        $output_categories = '';
        
        // "All" link
        if ( $nm_theme_options['shop_categories_all_link'] ) {
            $all_thumbnail_id = ( is_array( $nm_theme_options['shop_categories_all_link_thumbnail'] ) && isset( $nm_theme_options['shop_categories_all_link_thumbnail']['id'] ) ) ? $nm_theme_options['shop_categories_all_link_thumbnail']['id'] : null;
            $all_thumbnail = nm_category_menu_get_thumbnail( $all_thumbnail_id );
            
            $output_categories .= '<li' . $all_categories_class . '><a href="' . esc_url ( $page_url ) . '">' . $all_thumbnail . esc_html__( 'All', 'nm-framework' ) . '</a></li>';
        }

        // Categories order
        $orderby = 'slug';
        $order = 'ASC';
        if ( isset( $nm_theme_options['shop_categories_orderby'] ) ) {
            $orderby = $nm_theme_options['shop_categories_orderby'];
            $order = $nm_theme_options['shop_categories_order'];
        }
        
        $args = array(
            'taxonomy'		=> 'product_cat',
            'type'			=> 'post',
            'orderby'		=> $orderby, // Note: 'name' sorts by product category "menu/sort order"
            'order'			=> strtoupper( $order ),
            'hide_empty'	=> $hide_empty,
            //'hierarchical'	=> 0
            'hierarchical'	=> true // If false/0, categories that have an empty parent category will -not- be included (even if the category has products assigned)
        );
        // Note: The "force_menu_order_sort" parameter added in WooCommerce 3.6 must be set to make "orderby" work (the "name" option doesn't work otherwise)
        // - See the "../woocommerce/includes/wc-term-functions.php" file
        $args['force_menu_order_sort'] = ( $orderby == 'name' ) ? true : false;
        $args = apply_filters( 'nm_shop_category_menu_args', $args );
        
        $categories = get_categories( $args );
        
        $output_sub_categories = '';
        $output_current_sub_category = '';
        
        // Sub-categories:
        if ( ! $hide_sub ) { // Should sub-categories be included?
            foreach( $categories as $key => $category ) {
                // Is this a sub-category?
                if ( $category->parent != '0' ) {
                    if ( 
                        $category->parent == $current_cat_id || // Include current sub-category's children
                        ! $category_has_children && $category->parent == $wp_query->queried_object->parent // Include categories with the same parent (if current sub-category doesn't have children)
                    ) {
                        $output_sub_categories .= nm_category_menu_create_list( $category, $current_cat_id );
                    } else if ( 
                        $category->term_id == $current_cat_id // Include current sub-category (save in a separate variable so it can be appended to the start of the category list)
                    ) {
                        $output_current_sub_category = nm_category_menu_create_list( $category, $current_cat_id );
                    }
                    
                    // Remove sub-category from array to avoid looping it below
                    unset( $categories[$key] );
                }
            }
            
            $output_sub_categories = $output_current_sub_category . $output_sub_categories;
        }
        
        // Parent categories:
        foreach( $categories as $category ) {
            // Is this a parent category?
            if ( $category->parent == 0 ) {
                $output_categories .= nm_category_menu_create_list( $category, $current_cat_id, $current_top_cat_id, $output_sub_categories );
            }
        }
        
        if ( strlen( $output_sub_categories ) > 0 ) {
            $output_sub_categories = '<ul class="nm-shop-sub-categories">' . $output_sub_categories . '</ul>';
        }
        
        printf( '<ul id="%1$s" class="%1$s">%2$s</ul>%3$s',
            $wrapper_id,
            $output_categories,
            $output_sub_categories
        );
    }
}



/*
 * Category menu: Output sub-categories
 */
if ( ! function_exists( 'nm_sub_category_menu_output' ) ) {
    function nm_sub_category_menu_output( $current_cat_id, $hide_empty, $wrapper_id = 'nm-shop-categories' ) {
        global $wp_query, $nm_theme_options;

        $output_sub_categories = '';

        // Categories order
        $orderby = 'slug';
        $order = 'asc';
        if ( isset( $nm_theme_options['shop_categories_orderby'] ) ) {
            $orderby = $nm_theme_options['shop_categories_orderby'];
            $order = $nm_theme_options['shop_categories_order'];
        }

        $args = array(
            'type'			=> 'post',
            'parent'       	=> $current_cat_id,
            'orderby'		=> $orderby, // Note: 'name' sorts by product category "menu/sort order"
            'order'			=> $order,
            'hide_empty'	=> $hide_empty,
            'hierarchical'	=> 1,
            'taxonomy'		=> 'product_cat'
        );
        // Note: The "force_menu_order_sort" parameter added in WooCommerce 3.6 must be set to make "orderby" work (the "name" option doesn't work otherwise)
        // - See the "../woocommerce/includes/wc-term-functions.php" file
        $args['force_menu_order_sort'] = ( $orderby == 'name' ) ? true : false;
        $args = apply_filters( 'nm_shop_sub_category_menu_args', $args ); // Since v2.5.6
        
        $sub_categories = get_categories( $args );
        
        $has_sub_categories = ( empty( $sub_categories ) ) ? false : true;

        // Is there any sub-categories available
        if ( $has_sub_categories ) {
            $current_cat_name = apply_filters( 'nm_shop_parent_category_title', $wp_query->queried_object->name );

            foreach( $sub_categories as $sub_category ) {
                $output_sub_categories .= nm_category_menu_create_list( $sub_category, $current_cat_id );
            }
        } else {
            $current_cat_name = $wp_query->queried_object->name;
        }

        // "Back" link
        $output_back_link = '';
        if ( $nm_theme_options['shop_categories_back_link'] ) {
            $parent_cat_id = $wp_query->queried_object->parent;

            if ( $parent_cat_id ) {
                // Back to parent-category link
                $parent_cat_url = get_term_link( (int) $parent_cat_id, 'product_cat' );
                $output_back_link = nm_sub_category_menu_back_link( $parent_cat_url );
            } else if ( $nm_theme_options['shop_categories_back_link'] == '1st' ) {
                // 1st sub-level - Back to top-level (main shop page) link
                $shop_page_id = wc_get_page_id( 'shop' );
                $shop_url = get_permalink( $shop_page_id );
                $output_back_link = nm_sub_category_menu_back_link( $shop_url, ' 1st-level' );
            }
        }

        // Current category link
        $current_cat_url = get_term_link( (int) $current_cat_id, 'product_cat' );
        $current_cat_thumbnail_id = absint( get_term_meta( $current_cat_id, 'nm_cat_menu_thumbnail_id', true ) );
        $current_cat_thumbnail = nm_category_menu_get_thumbnail( $current_cat_thumbnail_id );
        $output_current_cat = '<li class="current-cat-sub current-cat"><a href="' . esc_url( $current_cat_url ) . '">' . $current_cat_thumbnail . esc_html( $current_cat_name ) . '</a></li>';
        
        $output = '';
        $output .= $output_back_link . $output_current_cat . $output_sub_categories;
        
        printf( '<ul id="%1$s" class="%1$s">%2$s</ul>',
            $wrapper_id,
            $output
        );
    }
}



/*
 * Category menu: Create single category list HTML 
 */
if ( ! function_exists( 'nm_category_menu_create_list' ) ) {
    function nm_category_menu_create_list( $category, $current_cat_id, $current_top_cat_id = null, $output_sub_categories_nested = '' ) {
        $menu_divider = apply_filters( 'nm_shop_categories_divider', '<span class="nm-shop-categories-divider">&frasl;</span>' );
        
        $include_nested_categories = false;
        
        $output = '<li class="cat-item-' . $category->term_id;

        // Is this the current category?
        if ( $current_cat_id == $category->term_id ) {
            $include_nested_categories = true;
            
            $output .= ' current-cat';
        }
        // Is this the current top parent-category?
        else if ( $current_top_cat_id && $current_top_cat_id == $category->term_id ) {
            $include_nested_categories = true;
            
            $output .= ' current-parent-cat';
        }
        
        // Thumbnail
        $thumbnail_id = absint( get_term_meta( $category->term_id, 'nm_cat_menu_thumbnail_id', true ) );
        $thumbnail = nm_category_menu_get_thumbnail( $thumbnail_id );
        
        $output .=  '">' . $menu_divider . '<a href="' . esc_url( get_term_link( (int) $category->term_id, 'product_cat' ) ) . '">' . $thumbnail . esc_attr( $category->name ) . '</a>';
        
        // Include nested sub-categories
        if ( $include_nested_categories && strlen( $output_sub_categories_nested ) > 0 ) {
            $output .= '<ul class="nm-shop-sub-categories-nested">' . $output_sub_categories_nested . '</ul>';
        }
        
        $output .=  '</li>';
        
        return $output;
    }
}



/*
 * Category menu: Get thumbnail
 */
if ( ! function_exists( 'nm_category_menu_get_thumbnail' ) ) {
    function nm_category_menu_get_thumbnail( $thumbnail_id ) {
        $include_thumbnail = apply_filters( 'nm_category_menu_include_thumbnail', true );
        
        if ( $include_thumbnail && $thumbnail_id ) {
            $thumbnail_url = wp_get_attachment_thumb_url( $thumbnail_id );
            $thumbnail = apply_filters( 'nm_cat_menu_thumbnail', sprintf( '<img src="%s" width="46" height="46" />', $thumbnail_url ), $thumbnail_url, $thumbnail_id );
        } else {
            $thumbnail = '';
        }
        
        return $thumbnail;
    }
}



/*
 * Category menu: Get "Back" link
 */
if ( ! function_exists( 'nm_sub_category_menu_back_link' ) ) {
    function nm_sub_category_menu_back_link( $url, $class = '' ) {
        $menu_divider = apply_filters( 'nm_shop_categories_divider', '<span class="nm-shop-categories-divider">&frasl;</span>' );
        
        return '<li class="nm-category-back-button' . esc_attr( $class ) . '"><a href="' . esc_url( $url ) . '"><i class="nm-font nm-font-arrow-left"></i> ' . esc_html__( 'Back', 'nm-framework' ) . '</a>' . $menu_divider . '</li>';
    }
}



/*
 * Shop: Get page content ID
 */
if ( ! function_exists( 'nm_shop_get_page_content_id' ) ) {
    function nm_shop_get_page_content_id() {
        global $nm_theme_options, $nm_globals;
        
        // Get page content ID
        if ( isset( $nm_theme_options['shop_page_id'] ) && strlen( $nm_theme_options['shop_page_id'] ) > 0 ) {
            $page_id = intval( $nm_theme_options['shop_page_id'] );
        } else {
            // Use default WooCommerce shop page if no page is selected in theme settings
            $page_id = $nm_globals['shop_page_id'];
        }
        
        $page_id = apply_filters( 'wpml_object_id', $page_id ); // WPML: The "wpml_object_id" filter is used to get the translated page (if created)
        
        return $page_id;
    }
}



/*
 * Shop: Get page content
 */
if ( ! function_exists( 'nm_shop_get_page_content' ) ) {
    function nm_shop_get_page_content() {
        $page_id = nm_shop_get_page_content_id();
        
        // Elementor: Get page content (if exists)
        if ( class_exists( '\\Elementor\\Plugin' ) ) {
            $elementor = \Elementor\Plugin::instance();

            if ( $elementor->db->is_built_with_elementor( $page_id ) ) {
                // Include Elementor stylesheets in head (some stylesheets included in footer otherwise)
                // - Source: https://gist.github.com/nicomollet/fc8a69b447f21cf8f4245f77d5a33d63
                $elementor->frontend->enqueue_styles();
                if ( class_exists( '\ElementorPro\Plugin' ) ) {
                    $elementor_pro = \ElementorPro\Plugin::instance();
                    $elementor_pro->enqueue_styles();
                }
                /*if ( class_exists( '\Elementor\Post_CSS_File' ) ) {
                    $elementor_page_id = 3167; // Elementor page ID serving as a template (for a header or footer)
                    $css_file = new \Elementor\Post_CSS_File( $elementor_page_id );
                    $css_file->enqueue();
                }*/
                
                $elementor_content = $elementor->frontend->get_builder_content( $page_id );

                return $elementor_content;
            }
        }

        $shop_page = get_post( $page_id, 'page' );
        if ( $shop_page ) {
            $page_content = apply_filters( 'the_content', $shop_page->post_content );

            return '<div class="entry-content">' . $page_content . '</div>';
        }

        return null;
    }
}



/*
 * Shop: Display default description
 *
 * Code from "woocommerce_taxonomy_archive_description()" function
 */
if ( ! function_exists( 'nm_shop_description' ) ) {
    function nm_shop_description( $description = '' ) {
        global $nm_theme_options;
        
        if ( strlen( $nm_theme_options['shop_default_description'] ) > 0 && ! isset( $_REQUEST['s'] ) ) { // Don't display on search
            $description = wc_format_content( $nm_theme_options['shop_default_description'] );
            
            if ( $description ) {
                echo '<div class="nm-shop-default-description term-description">' . $description . '</div>';
            }
        }
    }
}



/*
 * Shop: Get product thumbnail/image
 * 
 * Note: Modified version of the "woocommerce_get_product_thumbnail()" function in "../wp-content/plugins/woocommerce/includes/wc-template-functions.php"
 */
if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {
    function woocommerce_get_product_thumbnail( $size = 'woocommerce_thumbnail', $deprecated1 = 0, $deprecated2 = 0 ) {
        global $product, $nm_theme_options, $nm_globals;
        
        $image_size = apply_filters( 'single_product_archive_thumbnail_size', $size );

        if ( $nm_theme_options['product_image_lazy_loading'] ) {
            $image_id = get_post_thumbnail_id();
            
            if ( $image_id ) {
                $output = nm_product_get_thumbnail( $image_id, $image_size, '', $nm_globals['product_placeholder_image'] );
            } else {
                $output = wc_placeholder_img();
            }
        } else {
            $output = $product ? $product->get_image( $image_size ) : '';
        }
        
        // "Hover" image
        $hover_image = ( $nm_theme_options['product_hover_image_global'] ) ? true : get_post_meta( $product->get_id(), 'nm_product_image_swap', true );
        if ( $hover_image ) {
            $product_gallery_ids = $product->get_gallery_image_ids();
            $hover_image_id = ( $product_gallery_ids ) ? apply_filters( 'nm_product_hover_image_id', reset( $product_gallery_ids ), $product_gallery_ids ) : null; // Get first array element

            if ( $hover_image_id ) {
                $output .= nm_product_get_thumbnail( $hover_image_id, $image_size, 'nm-shop-hover-image', NM_THEME_URI . '/assets/img/transparent.gif' );
            }
        }

        return $output;
    }
}



/*
 * Shop (product loop): Get thumbnail/image
 */
function nm_product_get_thumbnail( $image_id, $image_size, $image_class, $image_placeholder_url ) {
    $product_thumbnail = '';
    $props = nm_product_get_thumbnail_props( $image_id, $image_size );

    if ( strlen( $props['src'] ) > 0 ) { // Make sure the image isn't deleted
        $product_thumbnail = sprintf( '<img src="%s" data-src="%s" data-srcset="%s" alt="%s" sizes="%s" width="%s" height="%s" class="attachment-woocommerce_thumbnail size-%s wp-post-image %s lazyload" />',
            esc_url( $image_placeholder_url ),
            $props['src'],
            $props['srcset'],
            $props['alt'],
            $props['sizes'],
            esc_attr( $props['src_w'] ),
            esc_attr( $props['src_h'] ),
            $image_size,
            $image_class
        );
    }

    return $product_thumbnail;
}



/*
 * Shop (product loop): Get thumbnail/image properties
 *
 * Note: Modified version of the "wc_get_product_attachment_props()" function in "../wp-content/plugins/woocommerce/includes/wc-product-functions.php"
 */
function nm_product_get_thumbnail_props( $attachment_id = null, $thumbnail_size = 'woocommerce_thumbnail' ) {
    $props = array(
        'title'   => '',
        'alt'     => '',
        'src'     => '',
        'srcset'  => false,
        'sizes'   => false,
    );
    if ( $attachment = get_post( $attachment_id ) ) {
        $props['title']   = trim( strip_tags( $attachment->post_title ) );
        $props['alt']     = trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );

        $src             = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
        $props['src']    = $src[0];
        $props['src_w']  = $src[1];
        $props['src_h']  = $src[2];
        $props['srcset'] = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $attachment_id, $thumbnail_size ) : false;
        $props['sizes']  = function_exists( 'wp_get_attachment_image_sizes' ) ? wp_get_attachment_image_sizes( $attachment_id, $thumbnail_size ) : false;
    }
    return $props;
}



/*
 * Shop (product loop): Show the product title
 */
if ( ! function_exists( 'nm_template_loop_product_title' ) ) {
    function nm_template_loop_product_title() {
        echo '<h3 class="woocommerce-loop-product__title"><a href="' . esc_url( get_permalink() ) . '" class="nm-shop-loop-title-link woocommerce-LoopProduct-link">' . get_the_title() . '</a></h3>';
    }
}



/*
 * Product: Summary - Opening tags
 */
if ( ! function_exists( 'nm_single_product_summary_open' ) ) {
    function nm_single_product_summary_open() {
        echo '<div class="nm-product-summary-inner-col nm-product-summary-inner-col-1">';
    }
}



/*
 * Product: Summary - Divider tags
 */
if ( ! function_exists( 'nm_single_product_summary_divider' ) ) {
    function nm_single_product_summary_divider() {
        echo '</div><div class="nm-product-summary-inner-col nm-product-summary-inner-col-2">';
    }
}



/*
 * Product: Summary - Closing tag
 */
if ( ! function_exists( 'nm_single_product_summary_close' ) ) {
    function nm_single_product_summary_close() {
        echo '</div>';
    }
}



/*
 * Product variations: Output list
 */
function nm_product_variations_list( $product ) {
    // Note: Code from "woocommerce_variable_add_to_cart()" function
    //$get_variations         = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );
    //$available_variations   = $get_variations ? $product->get_available_variations() : false;
    $available_variations   = $product->get_available_variations();
    $attributes             = $product->get_variation_attributes();

    // Note: Code from "../savoy/woocommerce/single-product/add-to-cart/variable.php" template
    if ( ! empty( $available_variations ) ) :
    ?>
    <ul class="nm-variations-list">
        <?php
            foreach ( $attributes as $attribute_name => $options ) :
            
            // Note: Code from "wc_dropdown_variation_attribute_options()" function in "../plugins/woocommerce/includes/wc-template-functions.php" template
            if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute_name ) ) {
                $attributes = $product->get_variation_attributes();
                $options    = $attributes[$attribute_name];
            }
        ?>
            <li>
                <div class="label"><?php echo wc_attribute_label( $attribute_name ); ?>:</div>
                <div class="values">
                    <?php
                        if ( ! empty( $options ) ) {
                            if ( taxonomy_exists( $attribute_name ) ) {
                                $terms = wc_get_product_terms( $product->get_id(), $attribute_name, array( 'fields' => 'all' ) );

                                foreach ( $terms as $term ) {
                                    if ( in_array( $term->slug, $options ) ) {
                                        echo '<span>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</span>';
                                    }
                                }
                            } else {
								foreach ( $options as $option ) {
									echo '<span>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</span>';
								}
							}
                        }
                    ?>
                </div>
            </li>
        <?php endforeach;?>
    </ul>
    <?php
    endif;
}
