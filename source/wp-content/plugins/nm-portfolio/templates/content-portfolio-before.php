<?php
global $nm_portfolio_options;

// Packery
if ( $nm_portfolio_options['packery'] ) {
    // Enqueue "Packery" script
    wp_enqueue_script( 'packery', NM_PORTFOLIO_URI . 'assets/js/packery.pkgd.min.js', array(), '1.3.2', true );
    
    $wrapper_class = ' packery-enabled';
    $loader_class = ' nm-loader';
} else {
    $wrapper_class = $loader_class = '';
}

// Categories menu
if ( $nm_portfolio_options['categories'] ) {
    $args = array(
        'type'			=> 'post',
        'orderby'		=> 'name',
        'order'			=> 'ASC',
        'hide_empty'	=> 0,
        'hierarchical'	=> 1,
        'taxonomy'		=> 'portfolio-category'
    );
    $categories = get_categories( $args );
    $categories_menu = '';
    $categories_menu_class = ' align-' . esc_attr( $nm_portfolio_options['categories_alignment'] );
    
    // Is this a portfolio category?
    if ( is_tax() ) {
        global $wp_query;
        
        $current_category_id = $wp_query->queried_object->term_id;
        $first_category_class_attr = '';
    } else {
        $current_category_id = null;
        $categories_menu_class .= ( $nm_portfolio_options['categories_js'] ) ? ' js-sorting' : '';
        $first_category_class_attr = ' class="current"';
    }
        
    foreach ( $categories as $category ) {
        $current_category_class_attr = ( $current_category_id && $current_category_id == $category->term_id ) ? ' class="current"' : '';
        
        $categories_menu .= '<li' . $current_category_class_attr . '><span>&frasl;</span><a href="' . esc_url( get_term_link( (int) $category->term_id, 'portfolio-category' ) ) . '" data-filter="' . esc_attr( $category->slug ) . '">' . esc_html( $category->name ) . '</a></li>';
    }
    
    $categories_menu = '<ul class="nm-portfolio-categories' . $categories_menu_class . '"><li' . $first_category_class_attr . '><a href="' . esc_url( get_post_type_archive_link( 'portfolio' ) ) . '">' . __( 'All', 'nm-portfolio' ) . '</a></li>' . $categories_menu . '</ul>';
} else {
    $wrapper_class .= ' no-categories';
    $categories_menu = '';
}
?>

<?php do_action( 'nm_portfolio_before' ); ?>

<div class="nm-portfolio layout-<?php echo esc_attr( $nm_portfolio_options['layout'] ) . $wrapper_class; ?>">
    <?php echo $categories_menu; ?>

    <ul class="nm-portfolio-grid small-block-grid-1 medium-block-grid-2 large-block-grid-<?php echo intval( $nm_portfolio_options['columns'] ) . $loader_class; ?>">