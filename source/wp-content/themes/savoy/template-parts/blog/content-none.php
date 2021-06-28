<div id="post-0" class="nm-blog-no-results">
    <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

    <h1><?php printf( esc_html__( 'Ready to publish your first post? %sGet started here%s.', 'nm-framework' ), '<a href="' . admin_url( 'post-new.php' ) . '">', '</a>' ); ?></h1>

    <?php elseif ( is_search() ) : ?>

    <h1><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'nm-framework' ); ?></h1>

    <?php else : ?>

    <h1><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'nm-framework' ); ?></h1>

    <?php endif; ?>
</div>