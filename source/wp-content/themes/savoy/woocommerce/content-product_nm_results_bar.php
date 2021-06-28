<?php
/**
 *	NM: Shop - Results bar/button
 */

defined( 'ABSPATH' ) || exit;

global $nm_theme_options;

$has_results = false;
$results_bar_class = '';
$results_bar_buttons = array();

// Filters
$show_active_filters = apply_filters( 'nm_shop_show_active_filters', false ); // Note: Active filter links are currently static
$active_filters = '';
if ( $show_active_filters ) {
    $active_filters = nm_get_active_filters();
    if ( $active_filters ) {
        $has_results = true;
        $results_bar_class = ' has-filters';
    }
} else {
    $filters_count = nm_get_active_filters_count();
    if ( $filters_count ) {
        $has_results = true;
        $results_bar_class = ' has-filters';
        $results_bar_buttons['filters'] = array(
            'id'    => 'nm-shop-filters-reset',
            'title' => sprintf( esc_html__( 'Filters active %s(%s)%s', 'nm-framework' ), '<span>', $filters_count, '</span>' )
        );
    }
}
// Search
if ( ! empty( $_REQUEST['s'] ) ) { // Is search query set and not empty?
    $has_results = true;
    $results_bar_class .= ' is-search';
    $results_bar_buttons['search_taxonomy'] = array(
        'id'    => 'nm-shop-search-taxonomy-reset',
        'title' => sprintf( esc_html__( 'Search results for %s&ldquo;%s&rdquo;%s', 'nm-framework' ), '<span>', esc_html( $_REQUEST['s'] ), '</span>' )
    );
}
// Taxonomy
else if ( is_product_taxonomy() ) {
    $has_results = true;
    $results_bar_buttons['search_taxonomy'] = array(
        'id' => 'nm-shop-search-taxonomy-reset'
    );
    $current_term = $GLOBALS['wp_query']->get_queried_object();
    
    if ( is_product_category() ) {
        $results_bar_class .= ' is-category';
        $results_bar_buttons['search_taxonomy']['title'] = sprintf( esc_html__( 'Showing %s&ldquo;%s&rdquo;%s', 'nm-framework' ), '<span>', esc_html( $current_term->name ), '</span>' );
    } else {
        $results_bar_class .= ' is-tag';
        $results_bar_buttons['search_taxonomy']['title'] = sprintf( esc_html__( 'Products tagged %s&ldquo;%s&rdquo;%s', 'nm-framework' ), '<span>', esc_html( $current_term->name ), '</span>' );
    }
}

if ( $has_results ) :
?>

<div class="nm-shop-results-bar <?php echo esc_attr( $results_bar_class ); ?>">
    <ul>
    <?php
        $shop_url_escaped = esc_url( get_permalink( wc_get_page_id( 'shop' ) ) );
        
        foreach ( $results_bar_buttons as $button ) {
            printf( '<li class="%2$s"><a href="%1$s" id="%2$s" data-shop-url="%3$s">%4$s</a></li>',
                '#',
                $button['id'],
                $shop_url_escaped,
                $button['title']
            );
        }
        echo $active_filters;
    ?>
    </ul>
</div>

<?php endif; ?>
