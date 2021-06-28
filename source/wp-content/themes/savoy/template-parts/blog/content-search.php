<div id="nm-blog-list" class="nm-search-results">
    <?php while ( have_posts() ) : the_post(); // Start the Loop ?>
    <div id="post-<?php esc_attr( the_ID() ); ?>" <?php post_class(); ?>>
        <div class="nm-row">
            <div class="nm-divider-col col-xs-12">
               <div class="nm-post-divider">&nbsp;</div>
            </div>
            
            <div class="nm-title-col col-xs-4">
                <h1 class="nm-post-title"><a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a></h1>
                <div class="nm-post-meta">
                    <span><?php the_time( get_option( 'date_format' ) ); ?></span>
                </div>
            </div>

            <div class="nm-content-col col-xs-8">
                <div class="nm-post-content">
                    <?php the_excerpt(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>