<?php
/*
 * Shortcode: nm_product_reviews
 */
function nm_shortcode_product_reviews( $atts, $content = NULL ) {
    extract( shortcode_atts( array(
        'product_id'    => '',
        'number'        => '8',
        'layout'        => 'default',
        'columns'       => '4',
        'orderby'       => 'comment_date_gmt',
        'order'         => 'DESC',
        'thumbnail'     => '',
        'title'         => '1',
        'total'         => '',
        'slider'        => '',
        'arrows'        => '',
        'autoplay'      => '',
        'infinite'      => '',
    ), $atts ) );
    
    // Get reviews
    if ( $product_id ) {
        $args = array(
            'post_id' => $product_id,
        );
    } else {
        $args = array(
            'post_type' => 'product',
            'number'    => $number,
            'orderby'   => $orderby,
            'order'     => $order,
            'parent'    => 0, // Don't include replies
        );
    }
    $args = apply_filters( 'nm_product_reviews_comment_args', $args );
    $reviews = get_comments( $args );
    
    if ( ! $reviews ) { return '<div>' . esc_html__( 'No reviews found.', 'nm-framework' ) . '</div>'; }
    
    $reviews_total = count( $reviews );
    $rating_total = 0;
    $output = '';
    
    foreach ( $reviews as $review ) {
        $rating = intval( get_comment_meta( $review->comment_ID, 'rating', true ) );
        
        if ( ! $rating ) {
            $reviews_total = $reviews_total - 1; // Remove reviews without rating from total
            continue;
        }
        
        $rating_total = $rating_total + $rating;
        $output_thumbnail = $output_author = $output_review = '';
        $classes = 'nm-product-review nm-product-' . esc_attr( $review->comment_post_ID ) . '-review';
        
        // Thumbnail
        if ( $thumbnail ) {
            $thumbnail = wp_get_attachment_image( get_post_thumbnail_id( $review->comment_post_ID ), 'woocommerce_thumbnail' );
            $thumbnail = apply_filters( 'nm_product_reviews_thumbnail', $thumbnail );
            
            $product_url = get_permalink( $review->comment_post_ID );
            $product_title = get_the_title( $review->comment_post_ID );
            
            $classes .= ' has-thumbnail';
            
            $output_thumbnail .= '<div class="nm-product-review-thumbnail"><a href="' . esc_url( $product_url ) . '" title="' . esc_attr( $product_title ) . '">' . $thumbnail . '</a></div>';
        }
        
        // Author
        $avatar_size = apply_filters( 'nm_product_reviews_avatar_size', '60' );
        $avatar = apply_filters( 'nm_product_reviews_avatar', get_avatar( $review, $avatar_size ), $review->comment_author );
        $verified = apply_filters( 'nm_product_reviews_verified', wc_review_is_from_verified_owner( $review->comment_ID ), $review->comment_ID );
        $verified_icon = ( $verified ) ? '<i class="nm-font nm-font-check" title="' . esc_attr__( 'verified owner', 'woocommerce' ) . '"></i>' : '';
        $date_format = apply_filters( 'nm_product_reviews_date_format', '' );
        $output_author = sprintf( '<div class="nm-product-review-author">%s<span>%s%s</span><em>%s</em></div>',
            $avatar,
            get_comment_author( $review ),
            $verified_icon,
            get_comment_date( $date_format, $review->comment_ID )
        );
        
        // Rating
        $output_rating = '<div class="nm-product-review-star-rating">' . wc_get_rating_html( $rating ) . '</div>';
        
        // Title
        $output_title = '';
        if ( $title ) {
            $product_url = ( $thumbnail ) ? $product_url : get_permalink( $review->comment_post_ID );
            $product_title = ( $thumbnail ) ? $product_title : get_the_title( $review->comment_post_ID );
            
            if ( $layout == 'centered' ) {
                $output_title = '<a href="' . esc_url( $product_url ) . '" class="nm-product-review-title dark">' . $product_title . ' <i class="nm-font nm-font-angle-thin-right"></i></a>';
            } else {
                $output_title = '<h4 class="nm-product-review-title"><a href="' . esc_url( $product_url ) . '">' . $product_title . '</a></h4>';
            }
        }
        
        // Description
        $output_review .= '<div class="nm-product-review-description">' . $review->comment_content . '</div>';
        
        // Output
        $output_order = ( $layout == 'centered' ) ? $output_author . $output_rating . $output_review . $output_title : $output_rating . $output_title . $output_review . $output_author;
        $output .= sprintf( '<li class="%s">%s<div class="nm-product-review-inner">%s</div></li>',
            $classes,
            $output_thumbnail,
            $output_order
        );
    }
    
    // Rating total
    $output_total = '';
    if ( $total && $rating_total > 0 ) {
        $total_average = $rating_total / $reviews_total;
        $total_average = number_format( $total_average, 2, '.', '' );
        
        $output_total = sprintf( '<div class="nm-product-reviews-total"><strong>%s</strong>%s <em>%s</em></div>',
            $total_average,
            '<div class="nm-product-review-star-rating">' . wc_get_rating_html( $total_average ) . '</div>',
            $reviews_total . ' ' . esc_html__( 'Reviews', 'woocommerce' )
        );
    }
    
    // Columns class
    $columns_large = intval( $columns );
    $columns_medium = ( $columns_large > 4 ) ? $columns_large - 1 : 2;
    $columns_class = apply_filters( 'nm_product_reviews_columns_class', 'xsmall-block-grid-1 small-block-grid-1 medium-block-grid-' . $columns_medium . ' large-block-grid-' . $columns_large );
    
    // Slider settings
    $slider_class = $slider_settings_data = '';
    if ( $slider ) {
        if ( function_exists( 'nm_add_page_include' ) ) {
            nm_add_page_include( 'product-reviews-slider' );
        }
        
        $slider_class = ' nm-product-reviews-slider';
        
        $slider_settings = array( 'slides-to-show' => $columns_large, 'slides-to-scroll' => $columns_large );
        if ( $arrows !== '' ) { $slider_settings['arrows'] = 'true'; }
        if ( strlen( $autoplay ) > 0 ) { $slider_settings['autoplay'] = 'true'; $slider_settings['autoplay-speed'] = intval( $autoplay ); }
        if ( strlen( $infinite ) > 0 ) { $slider_settings['infinite'] = 'true'; }
        $slider_settings = apply_filters( 'nm_product_reviews_slider_settings', $slider_settings ); // Make it possible to change settings via filter-hook
        
        foreach( $slider_settings as $setting => $value ) {
            $slider_settings_data .= ' data-' . $setting . '="' . $value . '"';
        }
    }
    
    $output = '<div class="nm-product-reviews' . $slider_class . ' layout-' . $layout . '"' . $slider_settings_data . '>' . $output_total . '<ul class="nm-product-reviews-ul ' . esc_attr( $columns_class ) . '">' . $output . '</ul></div>';
    
    return $output;
}

add_shortcode( 'nm_product_reviews', 'nm_shortcode_product_reviews' );
