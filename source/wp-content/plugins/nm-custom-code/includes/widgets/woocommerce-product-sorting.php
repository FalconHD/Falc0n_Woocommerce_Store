<?php
/**
 *	NM Widget: Product Sorting List
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class NM_WC_Widget_Product_Sorting extends WC_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    	= 'nm_widget nm_widget_product_sorting woocommerce';
		$this->widget_description	= esc_html__( 'Display a product sorting list.', 'nm-framework' );
		$this->widget_id          	= 'nm_woocommerce_widget_product_sorting';
		$this->widget_name        	= esc_html__( 'Product Sorting', 'nm-framework' );
		$this->settings           	= array(
			'title'  => array(
				'type'  => 'text',
				'std'   => esc_html__( 'Sort By', 'nm-framework' ),
				'label'	=> esc_html__( 'Title', 'nm-framework' )
			)
		);
		
		parent::__construct();
	}

	/**
	 * Widget function
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	public function widget( $args, $instance ) {
		global $wp_query;
		
		extract( $args );
		
        if ( $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base ) ) {
            $title = $before_title . $title . $after_title;
        }
        
		$output = '';
		
		if ( 1 != $wp_query->found_posts || woocommerce_products_will_display() ) {
			$output .= '<ul id="nm-product-sorting" class="nm-product-sorting">';
			
			$orderby = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
			$orderby == ( $orderby ===  'title' ) ? 'menu_order' : $orderby; // Fixed: 'title' is default before WooCommerce settings are saved
			
			$catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
				'menu_order'	=> esc_html__( 'Default', 'nm-framework' ),
				'popularity' 	=> esc_html__( 'Popularity', 'nm-framework' ),
				'rating'     	=> esc_html__( 'Average rating', 'nm-framework' ),
				'date'       	=> esc_html__( 'Newness', 'nm-framework' ),
				'price'      	=> esc_html__( 'Price: Low to High', 'nm-framework' ),
				'price-desc'	=> esc_html__( 'Price: High to Low', 'nm-framework' )
			) );
	
			if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) {
				unset( $catalog_orderby_options['rating'] );
			}
			
			
			/* Build entire current page URL (including query strings) */
			global $wp;
            $link = home_url( $wp->request ); // Base page URL
					
			// Unset query strings used for Ajax shop filters
			unset( $_GET['shop_load'] );
			unset( $_GET['_'] );
			
			$qs_count = count( $_GET );
			
			// Any query strings to add?
			if ( $qs_count > 0 ) {
				/*$i = 0;
				$link .= '?';*/
				
				// Build query string
				foreach ( $_GET as $key => $value ) {
					/*$i++;
					$link .= $key . '=' . $value;
					if ( $i != $qs_count ) {
						$link .= '&';
					}*/
                    $link = add_query_arg( $key, $value, $link );
				}
			}
			
			
            foreach ( $catalog_orderby_options as $id => $name ) {
				if ( $orderby == $id ) {
					$output .= '<li class="active">' . esc_attr( $name ) . '</li>';
				} else {
					// Add 'orderby' URL query string
					$link = add_query_arg( 'orderby', $id, $link );
					$output .= '<li><a href="' . esc_url( $link ) . '">' . esc_attr( $name ) . '</a></li>';
				}
            }
			       
        	$output .= '</ul>';
		}
		
		echo $before_widget . $title . $output . $after_widget;
	}
	
}
