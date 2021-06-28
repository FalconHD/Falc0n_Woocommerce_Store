<?php nm_blog_get_ajax_content(); // AJAX: Get blog content only, then exit ?>
<?php get_header(); ?>

<div class="nm-blog-wrap">
    <div class="nm-blog-heading">
    	<div class="nm-row">
        	<div class="col-xs-12">
                <h1><?php wp_kses( printf( esc_html__( 'Author Archives: %s', 'nm-framework' ), '<strong>' . get_the_author() . '</strong>' ), array( 'strong' => array() ) ); ?></h1>
            </div>
    	</div>
    </div>
	
	<?php get_template_part( 'template-parts/blog/content' ); ?>
</div>

<?php get_footer(); ?>