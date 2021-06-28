<?php
	
	// Shortcode: nm_portfolio
	function nm_shortcode_portfolio( $atts, $content = NULL ) {
		global $post, $wp_query, $nm_portfolio_options;
		
		nm_add_page_include( 'portfolio' );
		
        // Assets
		wp_enqueue_script( 'nm-portfolio', NM_PORTFOLIO_URI . 'assets/js/nm-portfolio.min.js', array( 'jquery' ), NM_PORTFOLIO_VERSION );
        
        $atts = shortcode_atts( array(
			'categories'		     => '0',
			'categories_alignment'   => 'left',
			'categories_js'          => '0',
            'layout'			     => 'standard',
            'packery'			     => '0',
            'items'				     => '',
			'columns'			     => '2',
			'category'			     => '',
			'ids'				     => '',
			'order_by'			     => 'date',
			'order'				     => 'desc'
		), $atts );
        
        // Portfolio options
        $nm_portfolio_options = array(
            'page_layout'           => 'full',
            'categories'            => $atts['categories'],
            'categories_alignment'  => $atts['categories_alignment'],
            'categories_js'         => $atts['categories_js'],
            'layout'                => $atts['layout'],
            'packery'               => $atts['packery'],
            'columns'               => $atts['columns']
        );
		
		$category_slug = str_replace( '_', '-', $atts['category'] );
		$posts_per_page = ( strlen( $atts['items'] ) > 0 ) ? intval( $atts['items'] ) : -1;
		
		// Post type query args
		$args = array(
			'post_type' 			=> 'portfolio',
			'post__in'				=> '',
			'post_status' 			=> 'publish',
			'portfolio-category'	=> $category_slug,
			'posts_per_page'		=> $posts_per_page,
			'ignore_sticky_posts'	=> 1,
			/*'tax_query' => array(
				array(
					'taxonomy'	=> 'portfolio-category',
					'field' 	=> 'id',
					'terms' 	=> array( $exclude_categories ),
					'operator'	=> 'NOT IN'
				)
			),*/
			'orderby'				=> $atts['order_by'],
			'order'					=> $atts['order']
		);
		
		// If Post IDs
		if ( $atts['ids'] ) {
			$posts_in = array_map( 'intval', explode( ',', $atts['ids'] ) );
			$args['post__in'] = $posts_in;
		}
		
		// Post type query
		$portfolio = new WP_Query( $args );
		
        ob_start();
        
        echo '<div class="nm-portfolio-wrap">';
        
        if ( $portfolio->have_posts() ) {
            include( nm_portfolio_include_dir( 'content-portfolio-before.php' ) );

            while ( $portfolio->have_posts() ) : $portfolio->the_post();
                include( nm_portfolio_include_dir( 'content-portfolio.php' ) );
            endwhile;

            include( nm_portfolio_include_dir( 'content-portfolio-after.php' ) );
        } else {
            include( nm_portfolio_include_dir( 'content-portfolio-empty.php' ) );
        }
        
        echo '</div>';
		
        $portfolio_output = ob_get_clean();
        return $portfolio_output;
        
		wp_reset_postdata();
	}
	
	add_shortcode( 'nm_portfolio', 'nm_shortcode_portfolio' );
	