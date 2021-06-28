<?php
	global $nm_theme_options;
    
    // Image size slug
    $image_size = apply_filters( 'nm_blog_image_size', '' );
?>
<div id="nm-blog-list" class="nm-blog-list">
    <?php while ( have_posts() ) : the_post(); // Start the Loop ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="nm-row">
            <div class="nm-divider-col col-xs-12">
               <div class="nm-post-divider">&nbsp;</div>
            </div>
            
            <div class="nm-title-col col-xs-4">
                <h2 class="nm-post-title"><a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a></h2>
            </div>

            <div class="nm-content-col col-xs-8">
                <?php if ( has_post_thumbnail() ) : ?>
                <div class="nm-post-thumbnail">   
                    <a href="<?php esc_url( the_permalink() ); ?>"><?php the_post_thumbnail( $image_size ); ?></a>
                </div>
                <?php endif; ?>

                <div class="nm-row">
                    <div class="col-lg-4 col-xs-12">
                        <div class="nm-post-meta">
                            <span><?php the_time( get_option( 'date_format' ) ); ?></span>
                        </div>
                    </div>

                    <div class="col-lg-8 col-xs-12">
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
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>