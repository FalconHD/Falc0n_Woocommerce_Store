<?php
    global $nm_theme_options;
    
    // Content "slug"
    $content_slug = ( is_search() ) ? 'search' : $nm_theme_options['blog_layout'];
    $container_class = 'layout-' . $content_slug;
    
    // Sidebar
    $show_sidebar = ( $nm_theme_options['blog_sidebar'] !== 'none' && ! is_search() ) ? true : false;
    $container_class .= ( $show_sidebar ) ? ' has-sidebar sidebar-' . $nm_theme_options['blog_sidebar'] : ' no-sidebar';

    // Content columns class
    $column_class_content = ( $show_sidebar ) ? apply_filters( 'nm_blog_content_columns_class', 'col-md-9 col-sm-12 col-xs-12' ) : 'col-xs-12';
?>

<div class="nm-blog <?php echo esc_attr( $container_class ); ?>">
    <div class="nm-blog-row nm-row">
        <div class="nm-blog-content-col <?php echo esc_attr( $column_class_content ); ?>">
        <?php if ( have_posts() ) : ?>
            <?php get_template_part( 'template-parts/blog/content', $content_slug ); ?>

            <?php get_template_part( 'pagination' ); ?>
        <?php else : ?>
            <?php get_template_part( 'template-parts/blog/content', 'none' ); // If no content, include the "No posts found" template ?>
        <?php endif; ?>
        </div>
        
        <?php 
        if ( $show_sidebar ) :
        
        $column_class_sidebar = apply_filters( 'nm_blog_sidebar_columns_class', 'col-md-3 col-sm-12 col-xs-12' );
        ?>
        <div class="nm-blog-sidebar-col <?php echo esc_attr( $column_class_sidebar ); ?>">
            <?php get_sidebar(); ?>
        </div>
        <?php endif; ?>
    </div>
</div>