<?php nm_blog_get_ajax_content(); // AJAX: Get blog content only, then exit ?>
<?php
    global $nm_theme_options;
    
    $show_categories = ( $nm_theme_options['blog_categories'] ) ? true : false;
    $categories_class = ( $show_categories ) ? '' : ' nm-blog-categories-disabled';

    $blog_page = nm_blog_get_static_content();
?>
<?php get_header(); ?>

<div class="nm-blog-wrap<?php echo esc_attr( $categories_class ); ?>">
    <?php if ( $blog_page ) : ?>
    <div class="nm-page-full">
        <div class="entry-content">
            <?php echo do_shortcode( $blog_page->post_content ); ?>
        </div>
    </div>
	<?php endif; ?>
    
    <?php if ( $show_categories ) : ?>
    <div class="nm-blog-categories">
        <div class="nm-row">
            <div class="col-xs-12">
                <?php echo nm_blog_category_menu(); ?>
            </div>
        </div>
    </div>
	<?php endif; ?>
    
    <?php get_template_part( 'template-parts/blog/content' ); ?>
</div>

<?php get_footer(); ?>