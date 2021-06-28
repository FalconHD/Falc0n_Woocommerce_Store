<?php
	global $nm_theme_options;
    
    $content_column_class = ( $nm_theme_options['blog_sidebar'] != 'none' ) ? 'col-xs-12' : 'col col-lg-8 col-md-12 centered';

    // Image size slug
    $image_size = apply_filters( 'nm_blog_image_size', '' );
?>
<div id="nm-blog-list" class="nm-blog-classic">
    <?php while ( have_posts() ) : the_post(); // Start the Loop ?>
    <div id="post-<?php esc_attr( the_ID() ); ?>" <?php post_class(); ?>>
        <div class="nm-post-divider">&nbsp;</div>
        
        <div class="nm-blog-header nm-row">
            <div class="<?php echo esc_attr( $content_column_class ); ?>">
                <h2 class="nm-post-title"><a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a></h2>

                <div class="nm-post-meta">
                    <span><?php the_time( get_option( 'date_format' ) ); ?></span>
                </div>
            </div>
        </div>

        <?php if ( has_post_thumbnail() ) : ?>
        <div class="nm-post-thumbnail">   
            <a href="<?php esc_url( the_permalink() ); ?>"><?php the_post_thumbnail( $image_size ); ?></a>
        </div>
        <?php endif; ?>

        <div class="nm-post-content nm-row">
            <div class="<?php echo esc_attr( $content_column_class ); ?>">
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
                <div class="nm-post-content-comments-link">
                    <a href="<?php esc_url( the_permalink() ); ?>#comments">
                        <i class="nm-font nm-font-messenger"></i>
                        <span><?php comments_number( esc_html__( 'Leave a comment', 'nm-framework' ), esc_html__( '1 comment', 'nm-framework' ), esc_html__( '% comments', 'nm-framework' ) ); ?></span>
                    </a>
                </div>
            <?php else : ?>
                <div class="nm-post-excerpt">
                    <?php the_excerpt(); ?>
                </div>
            <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>