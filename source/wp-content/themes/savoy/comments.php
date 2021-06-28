<?php
/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div class="nm-comments-inner">
	<?php if ( have_comments() ) : ?>
    
    <h2 class="nm-comments-heading">
		<?php
			wp_kses(
				printf( 
					_nx( 'One reply to &ldquo;%2$s&rdquo;', '%1$s replies to &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'nm-framework' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>'
				),
			array( 'span' => array() ) );
        ?>
    </h2>
    
    <ol class="commentlist">
        <?php
            wp_list_comments( array(
                'callback' => 'nm_comments'
            ) );
        ?>
    </ol>
    
    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
    <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
        <h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'nm-framework' ); ?></h1>
        <div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'nm-framework' ) ); ?></div>
        <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'nm-framework' ) ); ?></div>
    </nav>
    <?php endif; // Check for comment navigation. ?>
    
    <?php if ( ! comments_open() ) : ?>
    <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'nm-framework' ); ?></p>
    <?php endif; ?>
    
    <?php endif; // have_comments() ?>
    
    <?php 
		comment_form( array( 
			'comment_notes_after' => ''
		) );
	?>
</div>
