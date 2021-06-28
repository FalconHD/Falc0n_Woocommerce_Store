<?php
/*
	Template Name: Full Width
*/

// Only adding the "entry-content" post class on non-woocommerce pages to avoid CSS conflicts
$post_class = ( nm_is_woocommerce_page() ) ? '' : 'entry-content';

get_header(); ?>
    
    <div class="nm-page-full">
                                    
        <?php while ( have_posts() ) : the_post(); ?>
                
            <div id="post-<?php the_ID(); ?>" <?php post_class( esc_attr( $post_class ) ); ?>>
                <?php the_content(); ?>
            </div>
    
        <?php endwhile; ?>
            
    </div>

<?php get_footer(); ?>