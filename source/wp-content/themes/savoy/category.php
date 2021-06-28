<?php nm_blog_get_ajax_content(); // AJAX: Get blog content only, then exit ?>
<?php
    global $nm_theme_options;

    $show_categories = ( $nm_theme_options['blog_categories'] ) ? true : false;
    $categories_class = ( $show_categories ) ? '' : ' nm-blog-categories-disabled';
?>
<?php get_header(); ?>

<div class="nm-blog-wrap<?php echo esc_attr( $categories_class ); ?>">
    <?php if ( $show_categories ) : ?>
    <div class="nm-blog-categories">
        <div class="nm-row">
            <div class="col-xs-12">
                <?php echo nm_blog_category_menu(); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <?php
		// Category description
		$category_description = category_description();
		if ( ! empty( $category_description ) ) :
	?>
    <div class="nm-term-description nm-category-description">
        <div class="nm-row">
            <div class="col-xs-12">
                <?php echo $category_description; ?>
            </div>
        </div>
    </div>
	<?php endif; ?>
    
    <?php get_template_part( 'template-parts/blog/content' ); ?>
</div>

<?php get_footer(); ?>