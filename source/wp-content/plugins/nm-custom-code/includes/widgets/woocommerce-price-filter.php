<?php
/**
 *	NM Widget: Price Filter List
 *
 *	Note: This is a modified version of the "WooCommerce Price Filer" widget - All custom code is placed within "//NM" comments
 */

defined( 'ABSPATH' ) || exit;

class NM_WC_Widget_Price_Filter extends WC_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'nm_widget nm_widget_price_filter woocommerce';
		$this->widget_description = esc_html__( 'Display a list of prices to filter products in your store.', 'woocommerce' );
        $this->widget_id          = apply_filters( 'nm_widget_price_filter_id', 'nm_woocommerce_price_filter' ); // Filter added to be able to work around duplicated widgets caused by "WPML String Translation" plugin
		$this->widget_name        = esc_html__( 'Filter Products by Price (list)', 'woocommerce' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => esc_html__( 'Filter by price', 'woocommerce' ),
				'label' => esc_html__( 'Title', 'woocommerce' )
			),
			'price_range_size' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 50,
				'label' => esc_html__( 'Price range size', 'nm-framework-admin' )
			),
			'max_price_ranges' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 10,
				'label' => esc_html__( 'Max price ranges', 'nm-framework-admin' )
			),
			'hide_empty_ranges' => array(
				'type'  => 'checkbox',
				'std'   => 1,
				'label' => esc_html__( 'Hide empty price ranges', 'nm-framework-admin' )
			)
		);
		
		parent::__construct();
	}

	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
        global $wp;

		extract( $args );

		if ( ! is_shop() && ! is_product_taxonomy() ) {
			return;
		}

		if ( ! wc()->query->get_main_query()->post_count ) {
			return;
		}

		$min_price = isset( $_GET['min_price'] ) ? wc_clean( wp_unslash( $_GET['min_price'] ) ) : '';
		$max_price = isset( $_GET['max_price'] ) ? wc_clean( wp_unslash( $_GET['max_price'] ) ) : '';
		
		// NM
		//wp_enqueue_script( 'wc-price-slider' );
		// /NM

		$title  = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

		// Remember current filters/search
		// NM
		//$fields = '';
		// /NM
		
		// NM (copied from line 168)
		if ( get_option( 'permalink_structure' ) == '' ) {
            $link = remove_query_arg( array( 'page', 'paged', 'product-page' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
		} else {
			$link = preg_replace( '%\/page/[0-9]+%', '', home_url( $wp->request ) );
		}
		// /NM
		
		if ( get_search_query() ) {
			// NM
			//$fields .= '<input type="hidden" name="s" value="' . get_search_query() . '" />';
			$link = add_query_arg( 's', get_search_query(), $link );
			// /NM
		}

		if ( ! empty( $_GET['post_type'] ) ) {
			// NM
			//$fields .= '<input type="hidden" name="post_type" value="' . esc_attr( $_GET['post_type'] ) . '" />';
			$link = add_query_arg( 'post_type', esc_attr( $_GET['post_type'] ), $link );
			// /NM
		}

		if ( ! empty ( $_GET['product_cat'] ) ) {
			// NM
			//$fields .= '<input type="hidden" name="product_cat" value="' . esc_attr( $_GET['product_cat'] ) . '" />';
			$link = add_query_arg( 'product_cat', esc_attr( $_GET['product_cat'] ), $link );
			// /NM
		}

		if ( ! empty( $_GET['product_tag'] ) ) {
			// NM
			//$fields .= '<input type="hidden" name="product_tag" value="' . esc_attr( $_GET['product_tag'] ) . '" />';
			$link = add_query_arg( 'product_tag', esc_attr( $_GET['product_tag'] ), $link );
			// /NM
		}

		if ( ! empty( $_GET['orderby'] ) ) {
			// NM
			//$fields .= '<input type="hidden" name="orderby" value="' . esc_attr( $_GET['orderby'] ) . '" />';
			$link = add_query_arg( 'orderby', esc_attr( $_GET['orderby'] ), $link );
			// /NM
		}
        
        if ( ! empty( $_GET['min_rating'] ) ) {
			// NM
            //$fields .= '<input type="hidden" name="min_rating" value="' . esc_attr( $_GET['min_rating'] ) . '" />';
            $link = add_query_arg( 'min_rating', esc_attr( $_GET['min_rating'] ), $link );
            // /NM
		}

		//if ( $_chosen_attributes ) {
        if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) {
			foreach ( $_chosen_attributes as $attribute => $data ) {
				$taxonomy_filter = 'filter_' . str_replace( 'pa_', '', $attribute );
	
				// NM
				//$fields .= '<input type="hidden" name="' . esc_attr( $taxonomy_filter ) . '" value="' . esc_attr( implode( ',', $data['terms'] ) ) . '" />';
				$link = add_query_arg( esc_attr( $taxonomy_filter ), esc_attr( implode( ',', $data['terms'] ) ), $link );
				// /NM
				
				if ( 'or' == $data['query_type'] ) {
					// NM
					//$fields .= '<input type="hidden" name="' . esc_attr( str_replace( 'pa_', 'query_type_', $attribute ) ) . '" value="or" />';
					$link = add_query_arg( esc_attr( str_replace( 'pa_', 'query_type_', $attribute ) ), 'or', $link );
					// /NM
				}
			}
		}
		
        // Find min and max price in current result set
		$prices = $this->get_filtered_price();
		$min    = floor( $prices->min_price );
		$max    = ceil( $prices->max_price );
        
		if ( $min == $max ) {
			return;
		}

		echo $before_widget . $before_title . $title . $after_title;
		
		// NM
		/*if ( get_option( 'permalink_structure' ) == '' ) {
            $form_action = remove_query_arg( array( 'page', 'paged', 'product-page' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
		} else {
			$form_action = preg_replace( '%\/page/[0-9]+%', '', home_url( $wp->request ) );
		}*/
		// /NM
        
		// NM
		/*echo '<form method="get" action="' . esc_attr( $form_action ) . '">
			<div class="price_slider_wrapper">
				<div class="price_slider" style="display:none;"></div>
				<div class="price_slider_amount">
					<input type="text" id="min_price" name="min_price" value="' . esc_attr( $min_price ) . '" data-min="'.esc_attr( apply_filters( 'woocommerce_price_filter_widget_min_amount', $min ) ).'" placeholder="'.esc_html__('Min price', 'woocommerce' ).'" />
					<input type="text" id="max_price" name="max_price" value="' . esc_attr( $max_price ) . '" data-max="'.esc_attr( apply_filters( 'woocommerce_price_filter_widget_max_amount', $max ) ).'" placeholder="'.esc_html__( 'Max price', 'woocommerce' ).'" />
					<button type="submit" class="button">'.esc_html__( 'Filter', 'woocommerce' ).'</button>
					<div class="price_label" style="display:none;">
						'.esc_html__( 'Price:', 'woocommerce' ).' <span class="from"></span> &mdash; <span class="to"></span>
					</div>
					' . $fields . '
					<div class="clear"></div>
				</div>
			</div>
		</form>';*/
        
        // Apply WooCommerce filters on min and max prices (required for updating currency-switcher prices)
		$min = apply_filters( 'woocommerce_price_filter_widget_min_amount', $min );
        $max_unfiltered = $max;
        $max = apply_filters( 'woocommerce_price_filter_widget_max_amount', $max );
        
		$count = 0;
        // If the filtered max-price (see above) is different from the original price (currency-switcher used) - apply "woocommerce_price_filter_widget_max_amount" filter to adapt price-range to the different prices
		if ( $max_unfiltered != $max ) {
            $range_size = round( apply_filters( 'woocommerce_price_filter_widget_max_amount', intval( $instance['price_range_size'] ) ), 0 );
            $range_size = apply_filters( 'nm_price_filter_range_size', $range_size ); // Requested: Make range-size filterable (can be useful when prices vary)
        } else {
          $range_size = intval( $instance['price_range_size'] );
        }
        $max_ranges = ( intval( $instance['max_price_ranges'] ) - 1 );
		
        // Price descimals
        $show_price_decimals = apply_filters( 'nm_price_filter_price_decimals', false );
        $wc_price_args = ( $show_price_decimals ) ? array() : array( 'decimals' => 0 );
        
		$output = '<ul class="nm-price-filter">';
		        
		if ( strlen( $min_price ) > 0 ) {
			$output .= '<li><a href="' . esc_url( $link ) . '">' . esc_html__( 'All', 'nm-framework' ) . '</a></li>';
		} else {
            $output .= '<li class="current">' . esc_html__( 'All', 'nm-framework' ) . '</li>';
		}
		
		for ( $range_min = 0; $range_min < ( $max + $range_size ); $range_min += $range_size ) {
			$range_max = $range_min + $range_size;
			
			// Hide empty price ranges?
			if ( intval( $instance['hide_empty_ranges'] ) ) {
				// Are there products in this price range?
				if ( $min > $range_max || ( $max + $range_size ) < $range_max ) {
					continue;
				}
			}
			
			$count++;
			
			$min_price_output = wc_price( $range_min, $wc_price_args );
			
			if ( $count == $max_ranges ) {
				$price_output = $min_price_output . '+';
				
				if ( $range_min != $min_price ) {
					$url = apply_filters( 'nm_price_filter_url', add_query_arg( array( 'min_price' => $range_min, 'max_price' => $max ), $link ) );
                    $output .= '<li><a href="' . esc_url( $url ) . '">' . $price_output . '</a></li>';
				} else {
					$output .= '<li class="current">' . $price_output . '</li>';
				}
				
				break; // Max price ranges limit reached, break loop
			} else {
				$price_output = $min_price_output . ' - ' . wc_price( $range_min + $range_size, $wc_price_args );
				
				if ( $range_min != $min_price || $range_max != $max_price ) {
					$url = apply_filters( 'nm_price_filter_url', add_query_arg( array( 'min_price' => $range_min, 'max_price' => $range_max ), $link ) );
                    $output .= '<li><a href="' . esc_url( $url ) . '">' . $price_output . '</a></li>';
				} else {
					$output .= '<li class="current">' . $price_output . '</li>';
				}
			}
		}
		
		echo $output . '</ul>';
		// /NM

		echo $after_widget;
    }
     
    /**
	 * Get filtered min price for current products.
	 *
	 * @return int
	 */
	protected function get_filtered_price() {
		global $wpdb;

		$args       = WC()->query->get_main_query()->query_vars;
		$tax_query  = isset( $args['tax_query'] ) ? $args['tax_query'] : array();
		$meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();

		if ( ! is_post_type_archive( 'product' ) && ! empty( $args['taxonomy'] ) && ! empty( $args['term'] ) ) {
			$tax_query[] = WC()->query->get_main_tax_query();
		}

		foreach ( $meta_query + $tax_query as $key => $query ) {
			if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
				unset( $meta_query[ $key ] );
			}
		}

		$meta_query = new WP_Meta_Query( $meta_query );
		$tax_query  = new WP_Tax_Query( $tax_query );
		$search     = WC_Query::get_main_search_query_sql();

		$meta_query_sql   = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
		$tax_query_sql    = $tax_query->get_sql( $wpdb->posts, 'ID' );
		$search_query_sql = $search ? ' AND ' . $search : '';

		$sql = "
			SELECT min( min_price ) as min_price, MAX( max_price ) as max_price
			FROM {$wpdb->wc_product_meta_lookup}
			WHERE product_id IN (
				SELECT ID FROM {$wpdb->posts}
				" . $tax_query_sql['join'] . $meta_query_sql['join'] . "
				WHERE {$wpdb->posts}.post_type IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_post_type', array( 'product' ) ) ) ) . "')
				AND {$wpdb->posts}.post_status = 'publish'
				" . $tax_query_sql['where'] . $meta_query_sql['where'] . $search_query_sql . '
			)';

		$sql = apply_filters( 'woocommerce_price_filter_sql', $sql, $meta_query_sql, $tax_query_sql );

		return $wpdb->get_row( $sql ); // WPCS: unprepared SQL ok.
	}
}
