<?php nm_blog_get_ajax_content(); // AJAX: Get blog content only, then exit ?>
<?php get_header(); ?>

<div class="nm-blog-wrap">
    <div class="nm-blog-heading">
    	<div class="nm-row">	
        	<div class="col-xs-12">
                <h1>
                    <?php
                        if ( is_day() ) {
                            printf( esc_html__( 'Daily Archives: %s', 'nm-framework' ), '<strong>' . get_the_date() . '</strong>' );
						} elseif ( is_month() ) {
                            printf( esc_html__( 'Monthly Archives: %s', 'nm-framework' ), '<strong>' . get_the_date( 'F Y' ) . '</strong>' );
                        } elseif ( is_year() ) {
                            printf( esc_html__( 'Yearly Archives: %s', 'nm-framework' ), '<strong>' . get_the_date( 'Y' ) . '</strong>' );
                        } else {
                            esc_html_e( 'Archives', 'nm-framework' );
						}
                    ?>
                </h1>
            </div>
		</div>
    </div>
				
	<?php get_template_part( 'template-parts/blog/content' ); ?>
</div>

<?php get_footer(); ?>