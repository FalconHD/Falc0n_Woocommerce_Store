<?php global $nm_theme_options; $meta_viewport = apply_filters( 'nm_head_meta_viewport', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no' ); ?>
<!DOCTYPE html>

<html <?php language_attributes(); ?> class="<?php echo esc_attr( 'footer-sticky-' . $nm_theme_options['footer_sticky'] ); ?>">
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="<?php echo esc_attr( $meta_viewport ); ?>">
        
        <link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        
		<?php wp_head(); ?>
    </head>
    
	<body <?php body_class(); ?>>
        <?php if ( $nm_theme_options['page_load_transition'] ) : ?>
        <div id="nm-page-load-overlay" class="nm-page-load-overlay"></div>
        <?php endif; ?>
        
        <div class="nm-page-overflow">
            <div class="nm-page-wrap">
                <?php
                    // Top bar
                    if ( $nm_theme_options['top_bar'] ) {
                        get_template_part( 'template-parts/header/header', 'top-bar' );
                    }
                ?>
                            
                <div class="nm-page-wrap-inner">
                    <?php
                        // Header (or Elementor Pro header location)
						if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
							get_template_part( 'template-parts/header/header', 'content' );
						}
                    ?>
