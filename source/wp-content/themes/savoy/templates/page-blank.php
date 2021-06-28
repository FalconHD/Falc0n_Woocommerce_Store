<?php
/*
	Template Name: Blank
*/

$post_class = ( nm_is_woocommerce_page() ) ? '' : 'entry-content'; // Only adding the "entry-content" post class on non-woocommerce pages to avoid CSS conflicts
?>
<!DOCTYPE html>

<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        
        <link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        
		<?php wp_head(); ?>
    </head>
    
	<body <?php body_class(); ?>>
        <div class="nm-page-overflow">
            <div class="nm-page-wrap">
                <div class="nm-page-wrap-inner">
                    <div class="nm-page-blank">
                        <?php while ( have_posts() ) : the_post(); ?>
                        <div id="post-<?php the_ID(); ?>" <?php post_class( esc_attr( $post_class ) ); ?>>
                            <?php the_content(); ?>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>        
        
        <?php wp_footer(); // WordPress footer hook ?>
    </body>
</html>