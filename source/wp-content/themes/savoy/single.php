<?php
	global $nm_theme_options, $post;
    
    // Sidebar
    $post_class = 'nm-post-sidebar-' . $nm_theme_options['single_post_sidebar'];
	$show_sidebar = ( $nm_theme_options['single_post_sidebar'] != 'none' ) ? true : false;
    $post_column_class = ( $show_sidebar ) ? 'col col-md-8 col-sm-12 col-xs-12' : 'nm-post-col';
    
    // Featured image
    $has_featured_image = ( $nm_theme_options['single_post_display_featured_image'] && has_post_thumbnail() ) ? true : false;
    $post_class .= ( $has_featured_image ) ? ' has-featured-image' : '';

    // Comments
    $show_comments = ( comments_open() || get_comments_number() ) ? true : false;
    $post_class .= ( $show_comments ) ? ' has-post-comments' : ' no-post-comments';
?>

<?php get_header(); ?>

<div class="nm-post <?php echo esc_attr( $post_class ); ?>">
    
<?php if ( have_posts() ) : ?>

	<?php while ( have_posts() ) : the_post(); ?>    	
	
	<div class="nm-post-body">
        <div class="nm-row">
            <div class="nm-post-content-col <?php echo esc_attr( $post_column_class ); ?>">
                <header class="nm-post-header entry-header">
                    <?php if ( $has_featured_image ) : ?>
                    <div class="nm-post-featured-image <?php echo esc_attr( $nm_theme_options['single_post_featured_image_aspect_ratio'] ); ?>">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <?php endif; ?>

                    <h1><?php the_title(); ?></h1>

                    <div class="nm-single-post-meta-top">
                        <span><em><?php esc_html_e( 'By', 'nm-framework' ); ?> <?php the_author_posts_link(); ?> </em><time><?php esc_html_e( 'on', 'nm-framework' ); ?> <?php the_date(); ?></time></span>
                    </div>
                </header>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="nm-post-content entry-content clear">
                        <?php the_content(); ?>
                        
                        <?php
                            wp_link_pages( array(
                                'before' 		=> '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'nm-framework' ) . '</span>',
                                'after' 		=> '</div>',
                                'link_before'	=> '<span>',
                                'link_after'	=> '</span>'
                            ) );
                        ?>
                    </div>
                </article>
                
                <?php
                    $categories_list = get_the_category_list( '<span>,</span> ' );
                    $tag_list = get_the_tag_list( '<div class="nm-single-post-tags widget_tag_cloud">', '', '</div>' );
                    $meta_class = ( $categories_list || $tag_list ) ? 'has-meta' : 'no-meta';
                ?>
                <div class="nm-single-post-meta-wrap <?php echo esc_attr( $meta_class ); ?>">
                    <div class="nm-single-post-meta">
                    <?php
                        if ( $tag_list ) {
                            echo $tag_list;
                        }
                    
                        if ( $categories_list ) {
                            echo '<div class="nm-single-post-categories">' . esc_html__( 'Posted in ', 'nm-framework' ) . $categories_list . '.</div>';
                        }
                    ?>
                    </div>

                    <?php do_action( 'nm_after_post' ); ?>
                </div>
            </div>

            <?php if ( $show_sidebar ) : ?>
            <div class="nm-post-sidebar-col col-md-4 col-sm-12 col-xs-12">
                <?php get_sidebar(); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
	
    <div class="nm-post-pagination">
        <div class="nm-row">
            <div class="col-xs-12">
                <div class="nm-post-pagination-inner">
                    <div class="nm-post-prev">
                        <?php next_post_link( '%link', '<span class="short-title">' . esc_html__( 'Previous', 'nm-framework' ) . '</span><span class="long-title">%title</span>', false ); ?>
                    </div>

                    <div class="nm-post-next">
                        <?php previous_post_link( '%link', '<span class="short-title">' . esc_html__( 'Next', 'nm-framework' ) . '</span><span class="long-title">%title</span>', false ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
	<?php endwhile; ?>
		   
<?php else : ?>

	<div class="col col-xs-8 centered">
		<?php get_template_part( 'content', 'none' ); ?>
	</div>
	
<?php endif; ?>

<?php if ( $show_comments ) : ?>
	<div id="comments" class="nm-comments">
		<div class="nm-row">
			<div class="<?php echo esc_attr( $post_column_class ); ?>">
				<?php comments_template(); ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php 
if ( $nm_theme_options['single_post_related'] ) :
    $term_ids = wp_get_post_categories( $post->ID );
    
    if ( $term_ids ) :
    
    $args = apply_filters( 'nm_related_posts_args', array(
        'ignore_sticky_posts'   => 1,
        'no_found_rows'         => 1,
        'posts_per_page'        => intval( $nm_theme_options['single_post_related_per_page'] ),
        'orderby'               => 'rand',
        'category__in'          => $term_ids,
        'post__not_in'          => array( $post->ID )
    ) );

    $related_posts = new WP_Query( $args );
    
    if ( $related_posts->have_posts() ) :
    
    // Columns
    $columns_large = $nm_theme_options['single_post_related_columns'];
    $columns_medium = ( intval( $columns_large ) < 4 ) ? $columns_large : '4';
    $columns_small = ( intval( $columns_large ) > 1 ) ? '2' : '1';
	$columns_class = apply_filters( 'nm_related_posts_columns_class', 'small-block-grid-' . $columns_small . ' medium-block-grid-' . $columns_medium . ' large-block-grid-' . $nm_theme_options['single_post_related_columns'] );
    ?>
    <div class="nm-related-posts">
        <div class="nm-row">
            <div class="col-xs-12">
                <h2><?php _e( 'Related Posts', 'nm-framework' ); ?></h2>
                
                <ul class="<?php echo esc_attr( $columns_class ); ?>">
                <?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
                    <li>
                        <a href="<?php esc_url( the_permalink() ); ?>" class="nm-related-posts-image">
                            <?php the_post_thumbnail(); ?>
                            <div class="nm-image-overlay"></div>
                        </a>

                        <div class="nm-related-posts-content">
                            <div class="nm-post-meta"><?php the_time( get_option( 'date_format' ) ); ?></div>
                            <h3><a href="<?php esc_url( the_permalink() ); ?>" class="dark"><?php the_title(); ?></a></h3>
                            <div class="nm-related-posts-excerpt"><?php esc_html( the_excerpt() ); ?></div>
                        </div>
                    </li>
                <?php endwhile; ?>
                </ul>
            </div>
        </div>
    </div>
<?php 
    endif;
    
    endif;
    
    wp_reset_postdata();
endif;
?>
    
</div>

<?php get_footer(); ?>
