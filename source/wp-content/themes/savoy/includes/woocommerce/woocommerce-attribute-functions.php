<?php

/* 
 * WooCommerce - Attribute functions
=============================================================== */

global $nm_theme_options, $nm_globals;



/*
 * Product attribute: Get properties
 *
 * Note: Code from "get_tax_attribute()" function in the "../variation-swatches-for-woocommerce.php" file of the "Variation Swatches for WooCommerce" plugin
 */
function nm_woocommerce_get_taxonomy_attribute( $taxonomy ) {
    global $wpdb, $nm_globals;

    // Returned cached data if available
    if ( isset( $nm_globals['pa_cache'][$taxonomy] ) ) {
        return $nm_globals['pa_cache'][$taxonomy];
    }

    $attr = substr( $taxonomy, 3 );
    $attr = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name = '$attr'" );

    // Save data to avoid multiple database calls
    $nm_globals['pa_cache'][$taxonomy] = $attr;

    return $attr;
}



/*
 *  Widget: Filter Products by Attribute - Include custom elements
 */
if ( $nm_theme_options['shop_filters_custom_controls'] ) {
    function nm_woocommerce_layered_nav_count( $term_html, $term, $link, $count ) {
        global $nm_globals;

        // Get attribute type
        $attr = nm_woocommerce_get_taxonomy_attribute( $term->taxonomy );
        $attr_type = ( $attr ) ? $attr->attribute_type : '';
        
        $custom_html = null;
        
        
        // Type: Color
        if ( 'color' == $attr_type/*The "color" type may not be used for the attribute named "color": || 'pa_' . $nm_globals['pa_color_slug'] == $term->taxonomy*/ ) {
            // Save data in global variable to avoid getting the "nm_pa_colors" option multiple times
            if ( ! isset( $nm_globals['pa_colors'] ) ) {
                $nm_globals['pa_colors'] = get_option( 'nm_pa_colors' );
            }

            $id = $term->term_id;

            $color = ( isset( $nm_globals['pa_colors'][$id] ) ) ? $nm_globals['pa_colors'][$id] : '#c0c0c0';
            $custom_html = '<i style="background:' . esc_attr( $color ) . ';" class="nm-pa-color nm-pa-color-' . esc_attr( strtolower( $term->slug ) ) . '"></i>';
        }
        // Type: Image
        else if ( 'image' == $attr_type ) {
            $image_id = absint( get_term_meta( $term->term_id, 'nm_pa_image_thumbnail_id', true ) );
            
            if ( $image_id ) {
                $image_url = wp_get_attachment_url( $image_id );
                $custom_html = '<div class="nm-pa-image-thumbnail-wrap"><img src="' . esc_url( $image_url ) . '" class="nm-pa-image-thumbnail"></div>';
            }
        }
        
        
        if ( $custom_html ) {
            // Code from "layered_nav_list()" function in "../plugins/woocommerce/includes/widgets/class-wc-widget-layered-nav.php" file
            if ( $count > 0 ) {
                $term_html = '<a rel="nofollow" href="' . $link . '">' . $custom_html . esc_html( $term->name ) . '</a>';
            } else {
                $term_html = '<span>' . $custom_html . esc_html( $term->name ) . '</span>';
            }
        }
        
        return $term_html;
    }
    add_filter( 'woocommerce_layered_nav_term_html', 'nm_woocommerce_layered_nav_count', 1, 4 );
}



/*
 *  Product page: Variation controls - Code from "wc_dropdown_variation_attribute_options()" function in "../woocommerce/includes/wc-template-functions.php"
 */
if ( $nm_theme_options['product_custom_controls'] ) {
    function nm_variation_attribute_options( $html, $args ) {
        global $nm_globals;
        
        $attr = nm_woocommerce_get_taxonomy_attribute( $args['attribute'] );
        $variation_type = ( $attr ) ? $attr->attribute_type : null;

        // Is this a custom variation-control attribute?
        if ( ! $variation_type || ! array_key_exists( $variation_type, $nm_globals['pa_variation_controls'] ) ) {
            return $html;
        }

        $options      = $args['options'];
        $product      = $args['product'];
        $attribute    = $args['attribute'];
        $name         = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );

        if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
            $attributes = $product->get_variation_attributes();
            $options    = $attributes[ $attribute ];
        }

        // Hide default select-box
        $html = '<div class="nm-select-hidden">' . $html . '</div>';

        $html .= '<ul class="nm-variation-control nm-variation-control-'. esc_attr( $variation_type ) .'">';

        if ( ! empty( $options ) ) {
            $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

            switch ( $variation_type ) {
                // Control type: Color swatch
                case 'color' :

                    // Save data in global variable to avoid getting the "nm_pa_colors" option multiple times
                    if ( ! isset( $nm_globals['pa_colors'] ) ) {
                        $nm_globals['pa_colors'] = get_option( 'nm_pa_colors' );
                    }

                    foreach ( $terms as $term ) {
                        if ( in_array( $term->slug, $options, true ) ) {
                            $selected_class = ( $args['selected'] === $term->slug ) ? ' selected' : '';
                            $color = ( isset( $nm_globals['pa_colors'][$term->term_id] ) ) ? $nm_globals['pa_colors'][$term->term_id] : '#ccc';

                            $html .= '<li class="nm-variation-option' . $selected_class . '" data-value="' . esc_attr( $term->slug ) . '">';
                            $html .= '<i style="background:' . esc_attr( $color ) . ';" class="nm-pa-color nm-pa-color-' . esc_attr( strtolower( $term->slug ) ) . '"></i>';
                            $html .= '<span>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</span>';
                            $html .= '</li>';
                        }
                    }
                    
                    break;
                // Control type: Image swatch
                case 'image' :
                    
                    foreach ( $terms as $term ) {
                        if ( in_array( $term->slug, $options, true ) ) {
                            $selected_class = ( $args['selected'] === $term->slug ) ? ' selected' : '';
                            $image_id = absint( get_term_meta( $term->term_id, 'nm_pa_image_thumbnail_id', true ) );
                            $image_url = ( $image_id ) ? wp_get_attachment_url( $image_id ) : '';
                            
                            $html .= '<li class="nm-variation-option'. $selected_class . '" data-value="' . esc_attr( $term->slug ) . '">';
                            $html .= '<div class="nm-pa-image-thumbnail-wrap"><img src="' . esc_url( $image_url ) . '" class="nm-pa-image-thumbnail"></div>';
                            $html .= '<span>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</span>';
                            $html .= '</li>';
                        }
                    }
                    
                    break;
                // Control type: Label
                default :

                    foreach ( $terms as $term ) {
                        if ( in_array( $term->slug, $options, true ) ) {
                            $selected_class = ( $args['selected'] === $term->slug ) ? ' selected' : '';

                            $html .= '<li class="nm-variation-option'. $selected_class . '" data-value="' . esc_attr( $term->slug ) . '">';
                            $html .= '<span>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</span>';
                            $html .= '</li>';
                        }
                    }
            }
        }

        $html .= '</ul>';

        return $html;
    }
    add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'nm_variation_attribute_options', 10, 2 );
}



/*
 *  Product variations: Get variation image src
 */
/*function nm_woocommerce_get_variation_image_src( $available_variations, $attribute_name ) {
    foreach( $available_variations as $variation ) {
        if ( isset( $variation['attributes']['attribute_' . $attribute_name] ) ) {
            return $variation['image']['thumb_src'];
        }
    }
    
    return null;
}*/



/*
 *  Shop loop: Get custom attribute elements
 *
 *  Note: Based on "nm_product_variations_list()" in "../savoy/includes/woocommerce/woocommerce-template-functions.php" and "nm_variation_attribute_options()" above
 */
function nm_template_loop_attributes( $product = null ) {
    global $nm_theme_options, $nm_globals;
    
    if ( ! $product ) {
        global $product;
    }
    
    if ( ! $product->is_type( 'variable' ) ) {
        return;
    }

    $product_id = $product->get_id();
    $enabled_globaly = $nm_theme_options['product_display_attributes'];
    $enabled_globaly_attribute_types = apply_filters( 'nm_product_display_attribute_types', array( 'color' => '1', 'image' => '1' ) ); // Excluding "size" by default
    $enabled_attributes = get_post_meta( $product_id, 'nm_attribute_catalog_visibility', true );
    
    if ( $enabled_globaly || $enabled_attributes ) {
        $available_variations   = $product->get_available_variations();
        $attributes             = $product->get_variation_attributes();
        $html                   = '';

        if ( ! empty( $available_variations ) ) {
            $product_url = get_permalink( $product_id );

            $html .= '<div class="nm-shop-loop-attributes">';

            foreach ( $attributes as $attribute_name => $options ) {
                $attr = nm_woocommerce_get_taxonomy_attribute( $attribute_name );
                $attr_type = ( $attr ) ? $attr->attribute_type : null;

                if ( ! $attr_type ) {
                    continue;
                }
                
                // Only display custom attributes
                $is_custom_attribute = ( $enabled_globaly ) ? isset( $enabled_globaly_attribute_types[$attr_type] ) : isset( $enabled_attributes[$attribute_name] );

                /*if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute_name ) ) {
                    $attributes = $product->get_variation_attributes();
                    $options    = $attributes[$attribute_name];
                }*/
                
                if ( $is_custom_attribute && ! empty( $options ) ) {
                    $terms = wc_get_product_terms( $product_id, $attribute_name, array( 'fields' => 'all' ) );
                    //$variation_image_src = nm_woocommerce_get_variation_image_src( $available_variations, $attribute_name );

                    switch ( $attr_type ) {
                        // Type: Color swatch
                        case 'color' :

                            // Save data in global variable to avoid getting the "nm_pa_colors" option multiple times
                            if ( ! isset( $nm_globals['pa_colors'] ) ) {
                                $nm_globals['pa_colors'] = get_option( 'nm_pa_colors' );
                            }

                            $html .= '<div class="nm-shop-loop-attribute nm-shop-loop-attribute-color">';

                            foreach ( $terms as $term ) {
                                if ( in_array( $term->slug, $options, true ) ) {
                                    $url = $product_url . '?attribute_' . $attribute_name . '=' . $term->slug;
                                    $color = ( isset( $nm_globals['pa_colors'][$term->term_id] ) ) ? $nm_globals['pa_colors'][$term->term_id] : '#ccc';                                     

                                    //$html .= '<a href="' . esc_url( $url ) . '" data-variation-image-src="' . esc_url( $variation_image_src )  . '">';
                                    $html .= '<a href="' . esc_url( $url ) . '">';
                                    $html .= '<i style="background:' . esc_attr( $color ) . ';" class="nm-pa-color nm-pa-color-' . esc_attr( strtolower( $term->slug ) ) . '"></i>';                   
                                    $html .= '</a>';
                                }
                            }

                            break;
                        // Type: Image swatch
                        case 'image' :

                            $html .= '<div class="nm-shop-loop-attribute nm-shop-loop-attribute-image">';

                            foreach ( $terms as $term ) {
                                if ( in_array( $term->slug, $options, true ) ) {
                                    $url = $product_url . '?attribute_' . $attribute_name . '=' . $term->slug;
                                    $image_id = absint( get_term_meta( $term->term_id, 'nm_pa_image_thumbnail_id', true ) );
                                    $image_url = ( $image_id ) ? wp_get_attachment_url( $image_id ) : '';

                                    //$html .= '<a href="' . esc_url( $url ) . '" data-variation-image-src="' . esc_url( $variation_image_src )  . '">';
                                    $html .= '<a href="' . esc_url( $url ) . '">';
                                    $html .= '<div class="nm-pa-image-thumbnail-wrap"><img src="' . esc_url( $image_url ) . '" class="nm-pa-image-thumbnail"></div>';   
                                    $html .= '</a>';
                                }
                            }

                            break;
                        // Type: Label
                        default :

                            $html .= '<div class="nm-shop-loop-attribute nm-shop-loop-attribute-label">';

                            foreach ( $terms as $term ) {
                                if ( in_array( $term->slug, $options, true ) ) {
                                    $url = $product_url . '?attribute_' . $attribute_name . '=' . $term->slug;

                                    //$html .= '<a href="' . esc_url( $url ) . '" data-variation-image-src="' . esc_url( $variation_image_src )  . '">';
                                    $html .= '<a href="' . esc_url( $url ) . '">';
                                    $html .= '<span>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</span>';
                                    $html .= '</a>';
                                }
                            }
                    }

                    $html .= '</div>';
                }
            }

            $html .= '</div>';
            
            return $html;
        }
    }
    
    return null;
}

/*$template_include_action = apply_filters( 'nm_template_loop_attributes_above_thumbnail', 'woocommerce_before_shop_loop_item' );
add_action( $template_include_action, 'nm_template_loop_attributes', 5 );*/
