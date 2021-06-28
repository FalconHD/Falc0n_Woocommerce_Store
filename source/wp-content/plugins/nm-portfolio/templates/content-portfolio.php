<?php
    global $nm_portfolio_options;

    // Image overlay
    $image_overlay = ( $nm_portfolio_options['layout'] != 'overlay' ) ? '<div class="nm-image-overlay"></div>' : '';

    // Get post meta
    $portfolio_meta = get_post_meta( get_the_ID(), 'nm_portfolio_post_type_meta', true );

    // Image
    $image_id = get_post_thumbnail_id();
    if ( $image_id ) {
        $image_size = apply_filters( 'nm_portfolio_image_size', 'full' );
        $image_src = wp_get_attachment_image_src( $image_id, $image_size );
        $image = ( $image_src ) ? '<img src="' . esc_url( $image_src[0] ) . '" />' : '';
    } else {
        $image = '<span class="nm-img-placeholder"></span>';
    }

    // Text color class (used for overlay layout)
    $text_color_class = ( isset( $portfolio_meta['overlay_text_color'] ) ) ? ' text-color-' . $portfolio_meta['overlay_text_color'] : '';

    // Item categories
    $item_categories = get_the_terms( get_the_ID(), 'portfolio-category' );
    $item_categories_class = '';
    $item_categories_output = '';

    if ( ! empty( $item_categories ) ) {
        foreach( $item_categories as $item_category ) {
            $item_categories_class .= $item_category->slug . ' ';
            $item_categories_output .= $item_category->name . '<span>, </span>';
        }

        $item_categories_class = ' class="' . esc_attr( $item_categories_class ) . '"';
    }
?>

<li<?php echo $item_categories_class; ?>>
    <a href="<?php esc_url( the_permalink() ); ?>">
        <div class="nm-portfolio-item-image">
            <?php echo $image . $image_overlay; ?>
        </div>

        <div class="nm-portfolio-item-details<?php echo esc_attr( $text_color_class ); ?>">
            <?php the_title( '<h2>', '</h2>' ); ?>
            <p><?php echo $item_categories_output; ?></p>
        </div>
    </a>
</li>
