<?php
    /*
        Template Name: Sidebar
    */

    // Only adding the "entry-content" post class on non-woocommerce pages to avoid CSS conflicts
    $post_class = ( nm_is_woocommerce_page() ) ? '' : 'entry-content';
?>
<?php get_header(); ?>

<div class="nm-page-sidebar">
    <div class="nm-row">
        <div class="col-sidebar col-md-3 col-sm-12 col-xs-12">
            <aside class="nm-sidebar sidebar" role="complementary">
                <?php dynamic_sidebar( 'page' ); ?>
            </aside>
        </div>
        
        <div class="col-content col-md-9 col-sm-12 col-xs-12">
            <?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class( esc_attr( $post_class ) ); ?>>
                <?php the_content(); ?>
            </div>
            <?php 
                endwhile;
                else :
            ?>
            <div>
                <h2><?php esc_html_e( 'Sorry, nothing to display.', 'nm-framework' ); ?></h2>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>