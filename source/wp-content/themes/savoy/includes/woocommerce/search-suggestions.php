<?php
/*
 *	NM - Product Search Suggestions (header)
 */

defined( 'ABSPATH' ) || exit;

class NM_Search_Suggestions {
    
    protected $transient_enabled;
    protected $transient_duration;
    protected $max_results;
    
    
    /*
	 * Constructor
	 */
	public function __construct() {
        global $nm_globals, $nm_theme_options;
        
        // Instant suggestions enabled?
        if ( $nm_theme_options['shop_search_suggestions_instant'] ) {
            // Action: WooCommerce AJAX endpoint - Suggestions product data
            add_action( 'wc_ajax_nm_suggestions_product_data', array( $this, 'instant_suggestions_get_product_data' ) );
            
            // Action: Product create/update and delete/trash
            /*add_action( 'woocommerce_update_product', array( $this, 'instant_suggestions_set_cache_flag' ) );
            add_action( 'woocommerce_delete_product', array( $this, 'instant_suggestions_set_cache_flag' ) );
            add_action( 'woocommerce_trash_product', array( $this, 'instant_suggestions_set_cache_flag' ) );*/
            // Note: Adding default WP hooks since the WooCommerce versions doesn't trigger on quick-edit and delete/trash for some reason
            add_action( 'save_post_product', array( $this, 'instant_suggestions_set_cache_flag' ) );
            add_action( 'wp_trash_post', array( $this, 'instant_suggestions_before_trash_product' ) );
            
            // WPML: Language switch - Product data must be refreshed on language change, but hooks doesn't seem to work...
            //add_action( 'wpml_language_has_switched', array( $this, 'instant_suggestions_set_cache_flag' ) );
            //add_action( 'wcml_user_switch_language', array( $this, 'instant_suggestions_set_cache_flag' ) ); // WooCommerce Multilingual plugin hook
        } else {
            // Transients
            //$this->transient_enabled = ( $nm_theme_options['shop_search_suggestions_cache'] ) ? true : false;
            //$this->transient_duration = intval( $nm_theme_options['shop_search_suggestions_cache_expiration'] ) * HOUR_IN_SECONDS; // Hours in seconds
            $this->transient_enabled = apply_filters( 'nm_search_suggestions_cache', false );
            $this->transient_duration = intval( apply_filters( 'nm_search_suggestions_cache_expiration', 12 ) ) * HOUR_IN_SECONDS; // Hours in seconds

            // Maximum results
            $this->max_results = $nm_globals['shop_search_suggestions_max_results'];
            
            // Action: WooCommerce AJAX endpoint - Search
            add_action( 'wc_ajax_nm_shop_search', array( $this, 'shop_search' ) );
        }
    }
    
    
	/*
	 * AJAX: Search for products
	 */
	public function shop_search() {
        $search_keyword = $_REQUEST['s'];
        
        $transient_name = 'nm_search_suggestions_' . $search_keyword;
        $suggestions = '';
        
        if ( ! $this->transient_enabled || false === ( $suggestions = get_transient( $transient_name ) ) ) {
            global $woocommerce;
            $ordering_args = $woocommerce->query->get_catalog_ordering_args( 'title', 'asc' );
            
            $args = apply_filters( 'nm_search_suggestions_query_args', array(
                's'                   => $search_keyword,
                'post_type'           => 'product',
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1,
                //'orderby'             => $ordering_args['orderby'],
                'orderby'             => 'relevance',
                'order'               => $ordering_args['order'],
                'posts_per_page'      => $this->max_results,
                'suppress_filters'    => false
            ) );
            
            // Hide out-of-stock products?
            if ( 'yes' == get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
                $args['meta_query'] = array(
                    array(
                        'key'       => '_stock_status',
                        'value'     => 'instock',
                        'compare'   => '=',
                    )
                );
            }
            
            /*if ( isset( $_REQUEST['product_cat'] ) ) {
                $args['tax_query'] = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'product_cat',
                        'field'    => 'slug',
                        'terms'    => $_REQUEST['product_cat']
                    )
                );
            }*/
            
            $product_visibility_term_ids = wc_get_product_visibility_term_ids();
            $args['tax_query'][] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'term_taxonomy_id',
                'terms'    => $product_visibility_term_ids['exclude-from-search'],
                'operator' => 'NOT IN',
            );
            
            $products = get_posts( $args );
            
            if ( ! empty( $products ) ) {
                $products_html = '';
                
                foreach ( $products as $post ) {
                    $product = wc_get_product( $post );
                    
                    $products_html .= '<li>' . apply_filters( 'nm_instant_suggestions_product_html', '<a href="' .  esc_url( $product->get_permalink() ) . '">' . $product->get_image() . '<h3>' . $product->get_title() . '</h3><span class="price">' . $product->get_price_html() . '</span></a>', $product ) . '</li>';
                }
                
                $suggestions = $products_html;
            } else {
                $suggestions = '';
            }
            
            //wp_reset_postdata();
            
            if ( $this->transient_enabled ) {
                set_transient( $transient_name, $suggestions, $this->transient_duration );
            }
        }
        
        echo $suggestions;

        exit;
	}
    
    
    /*
	 * AJAX: Instant suggestions - Get product data
	 */
	public function instant_suggestions_get_product_data() {
        $generate_cache = intval( apply_filters( 'nm_instant_suggestions_generate_cache', get_option( 'nm_instant_suggestions_generate_cache', 1 ) ) );
        
        if ( $generate_cache == 1 ) {
            
            $args = apply_filters( 'nm_instant_suggestions_query_args', array(
                'status'        => 'publish',
                'visibility'    => 'search',
                'limit'         => -1,
                //'orderby'       => 'modified',
                //'order'         => 'ASC',
            ) );
            
            // Hide out-of-stock products?
            if ( 'yes' == get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
                $args['stock_status'] = 'instock';
            }
            
            // Using the "WC_Product_Query()" funciton to ensure future compatibility: https://github.com/woocommerce/woocommerce/wiki/wc_get_products-and-WC_Product_Query
            $query = new WC_Product_Query( $args );
            
            $products = $query->get_products();
            
            $products_array = array();
            
            if ( ! empty( $products ) ) {
                $i = 0;
                $image_size = apply_filters( 'nm_instant_suggestions_image_size', 'woocommerce_thumbnail' );
                $search_sku = apply_filters( 'nm_instant_suggestions_search_sku', false );
                
                foreach( $products as $product ) {
                    $i++;
                    $id = $product->get_id();
                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), $image_size ); // Using "srcset" causes content "jump" when HTML is added
                    $product_html = '<a href="' .  esc_url( $product->get_permalink() ) . '"><img src="' . $image[0] . '" width="' . $image[1] . '" height="' . $image[2] . '"><h3>' . $product->get_title() . '</h3><span class="price">' . $product->get_price_html() . '</span></a>';

                    $products_array[$i] = array( // Note: Don't set product-ID as array key here or product order will change (JSON object automatically sorts its items by highest to lowest key value)
                        'title'         => $product->get_title(),
                        'product_html'  => '<li>' . apply_filters( 'nm_instant_suggestions_product_html', $product_html, $product ) . '</li>'
                    );

                    if ( $search_sku ) {
                        $products_array[$i]['sku'] = $product->get_sku();
                    }
                }
            }
            
            $products_json = json_encode( $products_array );

            // Update cache
            update_option( 'nm_instant_suggestions_product_data', $products_json, true );
            
            // Set cache flag
            update_option( 'nm_instant_suggestions_generate_cache', 0, true );
        } else {
            // Get from cache
            $products_json = get_option( 'nm_instant_suggestions_product_data', '{}' );
        }
        
        echo $products_json;

        exit;
	}
    
    
    /*
	 * Instant suggestions - Before trash product - Set cache flag
	 */
    public function instant_suggestions_before_trash_product( $post_id ) {
        $post_type = get_post_type( $post_id );
        if ( $post_type == 'product' ) {
            $this->instant_suggestions_set_cache_flag();
        }
    }
    
    
    /*
	 * Instant suggestions - Set cache flag
	 */
	public function instant_suggestions_set_cache_flag() {
        update_option( 'nm_instant_suggestions_generate_cache', 1, true );
    }

}

$nm_search_suggestions = new NM_Search_Suggestions();
