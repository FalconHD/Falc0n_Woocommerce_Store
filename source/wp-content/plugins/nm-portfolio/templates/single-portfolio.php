<?php get_header(); ?>

<div class="nm-portfolio-single">

	<?php while ( have_posts() ) : the_post(); ?>
	
    <article id="post-<?php the_ID(); ?>" class="entry-content clear">
        <?php the_content(); ?>
    </article>
    
    <div class="nm-portfolio-single-footer">
        <div class="nm-row">
            <div class="nm-portfolio-single-prev col-md-4 col-xs-6">
                <?php next_post_link( '%link', '<span class="title">&larr; %title</span><span class="alt-title">' . esc_html__( 'Previous', 'nm-portfolio' ) . '</span>', false ); ?>
            </div>
            <div class="nm-portfolio-single-back col-xs-4">
                <a href="<?php echo esc_url( get_post_type_archive_link( 'portfolio' ) ); ?>" title="<?php esc_html_e( 'Show All', 'nm-portfolio' ); ?>">
                    <?php echo apply_filters( 'nm_portfolio_show_all_icon', '<span>&nbsp;</span><span>&nbsp;</span><span>&nbsp;</span><span>&nbsp;</span>' ); ?>
                </a>
            </div>
            <div class="nm-portfolio-single-next col-md-4 col-xs-6">
                <?php previous_post_link( '%link', '<span class="alt-title">' . esc_html__( 'Next', 'nm-portfolio' ) . '</span><span class="title">%title &rarr;</span>', false ); ?>
            </div>
        </div>
    </div>
	
	<?php endwhile; ?>
    
</div>

<?php get_footer(); ?>
