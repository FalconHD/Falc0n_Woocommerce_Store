<?php
	
	// Shortcode: nm_posts
	function nm_shortcode_posts( $atts, $content = NULL ) {
        extract( shortcode_atts( array(
			'num_posts'		 => '4',
            'columns'		 => '4',
			'orderby'        => 'none',
            'order'          => 'asc',
            'category'		 => '',
            'ids'            => '',
            'image_type'     => 'standard',
			'post_excerpt'   => '0'
		), $atts ) );
		
        $ids = array_filter( array_map( 'trim', explode( ',', $ids ) ) );
        
        // Posts per page
        $num_posts = intval( $num_posts );
        $num_posts = ( $num_posts === 0 ) ? -1 : $num_posts;
        
        // Posts query
		$args = array(
			'post_status'    => 'publish',
			'post_type'      => 'post',
			'category_name'  => $category,
            'post__in'       => $ids,
			'posts_per_page' => $num_posts,
            'orderby'        => $orderby,
            'order'          => $order
		);
		$posts = new WP_Query( $args );
		
        // Grid column classes
		$columns_large = intval( $columns );
        $columns_medium = ( $columns_large > 3 ) ? '3' : '2';        
		$columns_class = apply_filters( 'nm_blog_grid_columns_class', 'xsmall-block-grid-1 small-block-grid-1 medium-block-grid-' . $columns_medium . ' large-block-grid-' . $columns_large );
        
        // Image size slug
        $image_size = apply_filters( 'nm_blog_image_size', '' );
        
		ob_start();
		
		if ( $posts->have_posts() ) :
		?>
        <div class="nm-posts nm-blog-grid">
            <ul class="<?php echo esc_attr( $columns_class ); ?>">
            <?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
                <li <?php post_class(); ?>>
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="nm-post-thumbnail">
                        <a href="<?php esc_url( the_permalink() ); ?>">
                            <?php
                            if ( $image_type === 'standard' ) {
                                the_post_thumbnail( $image_size );
                            } else {
                                $image_id = get_post_thumbnail_id();
                                $image = wp_get_attachment_image_src( $image_id, 'full' );
                                echo '<div class="nm-post-image" style="background-image:url(' . $image[0] . ');"></div>';
                            }
                            ?>
                            <div class="nm-image-overlay"></div>
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <div class="nm-post-meta">
                        <span><?php the_time( get_option( 'date_format' ) ); ?></span>
                    </div>
                    
                    <h2 class="nm-post-title"><a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a></h2>
                    
                    <?php if ( $post_excerpt ) : ?>
                    <div class="nm-post-content">
                        <div class="nm-post-excerpt">
                            <?php the_excerpt(); ?>
                            <a href="<?php esc_url( the_permalink() ); ?>" class="nm-post-read-more">
                                <span><?php esc_html_e( 'More', 'nm-framework' ); ?></span><i class="nm-font nm-font-angle-thin-right"></i>
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                </li>
            <?php endwhile; ?>
            </ul>
        </div>
        <?php
		endif;
		
		wp_reset_query();
		
		$output = ob_get_clean();
		
		return $output;
	}
	
	add_shortcode( 'nm_posts', 'nm_shortcode_posts' );
	