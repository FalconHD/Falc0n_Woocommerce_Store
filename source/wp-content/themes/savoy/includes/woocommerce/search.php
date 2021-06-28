<?php
	
/*
 *	NM - Product Search
 */

global $nm_theme_options;


/* Search: Prevent single search result from redirecting to the product page */
add_filter( 'woocommerce_redirect_single_search_result', '__return_false' );


if ( $nm_theme_options['shop_search_by_titles'] ) {
    /*
     *	Search: Limit to product titles
     *
     *	https://wordpress.org/plugins/woocommerce-filter-search/
     */
    // Note: Using &$wp_query might be causing a PHP warning: function nm_woocommerce_search_by_title_only( $search, &$wp_query ) {
    function nm_woocommerce_search_by_title_only( $search, $wp_query ) {
        global $wpdb;

        // NM: Specify post types that should only be searched by title
        $not_allowed_post_types = apply_filters( 'wc_filter_search_not_allowed_array', array(
            'product', // WooCommerce product
        ) );

        if ( empty( $search ) || ! in_array( $wp_query->query_vars['post_type'], $not_allowed_post_types ) ) {
            return $search;
        }

        $q = $wp_query->query_vars;
        $n = ! empty( $q['exact'] ) ? '' : '%';

        $search =
        $searchand = '';

        foreach ( (array) $q['search_terms'] as $term ) {
            $term = esc_sql( $wpdb->esc_like( $term ) );
            $search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
            $searchand = ' AND ';
        }

        if ( ! empty( $search ) ) {
            $search = " AND ({$search}) ";
            if ( ! is_user_logged_in() ) {
                $search .= " AND ($wpdb->posts.post_password = '') ";
            }
        }

        return $search;
    }
    add_filter( 'posts_search', 'nm_woocommerce_search_by_title_only', 500, 2 );


    /*
     *	Search: Disable WooCommerce product excerpt search
     *	
     *	https://wordpress.org/plugins/woocommerce-filter-search/
     */
    function nm_woocommerce_disable_excerpt_search( $where = '' ) {
        global $wp_the_query;

        // If this is not a WC Query, do not modify the query
        if ( empty( $wp_the_query->query_vars['wc_query'] ) || empty( $wp_the_query->query_vars['s'] ) )
            return $where;

        $where = preg_replace(
            "/\s+OR\s+\(post_excerpt\s+LIKE\s*(\'\%[^\%]+\%\')\)/",
            "", $where );

        return $where;
    }
    add_filter( 'posts_where', 'nm_woocommerce_disable_excerpt_search', 15 );
}
