<?php
	global $nm_theme_options, $nm_page_includes;
	
    // Masonry grid
    if ( $nm_theme_options['blog_grid_masonry'] ) {
        nm_add_page_include( 'blog-masonry');
    }

	// Grid column classes
	$columns_large = $nm_theme_options['blog_grid_columns'];
	$columns_medium = ( intval( $columns_large ) > 3 ) ? '3' : '2';
	$columns_class = apply_filters( 'nm_blog_grid_columns_class', 'xsmall-block-grid-1 small-block-grid-1 medium-block-grid-' . $columns_medium . ' large-block-grid-' . $columns_large );

    // Image size slug
    $image_size = apply_filters( 'nm_blog_image_size', '' );
?>
<div class="nm-blog-grid">
    <ul id="nm-blog-list" class="<?php echo esc_attr( $columns_class ); ?>">
        <?php while ( have_posts() ) : the_post(); // Start the Loop ?>
        <li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php if ( has_post_thumbnail() ) : ?>
            <div class="nm-post-thumbnail">
                <a href="<?php esc_url( the_permalink() ); ?>">
                    <?php the_post_thumbnail( $image_size ); ?>
                    <div class="nm-image-overlay"></div>
                </a>
            </div>
            <?php endif; ?>

            <div class="nm-post-meta">
                <span><?php the_time( get_option( 'date_format' ) ); ?></span>
            </div>

            <h2 class="nm-post-title"><a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a></h2>

            <div class="nm-post-content">
                <?php if ( $nm_theme_options['blog_show_full_posts'] === '1' ) : ?>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                    <?php
                        wp_link_pages( array(
                            'before' 		=> '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'nm-framework' ) . '</span>',
                            'after' 		=> '</div>',
                            'link_before'	=> '<span>',
                            'link_after'	=> '</span>'
                        ) );
                    ?>
                <?php else : ?>
                    <div class="nm-post-excerpt">
                        <?php the_excerpt(); ?>
                        <a href="<?php esc_url( the_permalink() ); ?>" class="nm-post-read-more">
                            <span><?php esc_html_e( 'More', 'nm-framework' ); ?></span><i class="nm-font nm-font-angle-thin-right"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </li>
        <?php endwhile; ?>
    </ul>
</div>