<?php
	global $nm_theme_options;
    
    // Copyright text
	$copyright_text = ( isset( $nm_theme_options['footer_bar_text'] ) && strlen( $nm_theme_options['footer_bar_text'] ) > 0 ) ? $nm_theme_options['footer_bar_text'] : '';
	if ( $nm_theme_options['footer_bar_text_cr_year'] ) {
		$copyright_text = sprintf( '&copy; %s %s', date( 'Y' ), $copyright_text );
	}
	
	// Right/bottom column content
    $display_social_icons = ( strpos( $nm_theme_options['footer_bar_content'], 'social' ) !== false ) ? true : false;
    $display_copyright_text = ( strpos( $nm_theme_options['footer_bar_content'], 'copyright' ) !== false ) ? true : false;
    $display_custom_content = ( $nm_theme_options['footer_bar_content'] == 'custom' ) ? true : false;
?>
<div class="nm-footer-bar layout-<?php echo esc_attr( $nm_theme_options['footer_bar_layout'] ); ?>">
    <div class="nm-footer-bar-inner">
        <div class="nm-row">
            <div class="nm-footer-bar-left col-md-8 col-xs-12">
                <?php 
                    if ( isset( $nm_theme_options['footer_bar_logo'] ) && strlen( $nm_theme_options['footer_bar_logo']['url'] ) > 0 ) :
                
                    $logo_src = ( is_ssl() ) ? str_replace( 'http://', 'https://', $nm_theme_options['footer_bar_logo']['url'] ) : $nm_theme_options['footer_bar_logo']['url'];
                    $logo_alt_attr_escaped = ( strlen( $nm_theme_options['footer_bar_logo']['title'] ) > 0 ) ? 'alt="' . esc_attr( $nm_theme_options['footer_bar_logo']['title'] ) . '"' : '';
                ?>
                <div class="nm-footer-bar-logo">
                    <img src="<?php echo esc_url( $logo_src ); ?>"<?php echo $logo_alt_attr_escaped; ?> />
                </div>
                <?php endif; ?>

                <ul id="nm-footer-bar-menu" class="menu">
                    <?php
                        // Footer menu
                        wp_nav_menu( array(
                            'theme_location'    => 'footer-menu',
                            'container'       	=> false,
                            'fallback_cb'     	=> false,
                            'items_wrap'      	=> '%3$s'
                        ) );
                    ?>
                    <?php if ( ! $display_copyright_text ) : ?>
                    <li class="nm-menu-item-copyright menu-item"><span><?php echo wp_kses_post( $copyright_text ); ?></span></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="nm-footer-bar-right col-md-4 col-xs-12">
                <?php if ( $display_social_icons ) : ?>
                    <?php echo nm_get_social_profiles( 'nm-footer-bar-social' ); // Args: $wrapper_class ?>
                <?php endif; ?>
                <?php if ( $display_copyright_text ) : ?>
                <div class="nm-footer-bar-copyright"><?php echo wp_kses_post( $copyright_text ); ?></div>
                <?php endif; ?>
                <?php if ( $display_custom_content ) : ?>
                <div class="nm-footer-bar-custom"><?php echo wp_kses_post( do_shortcode( $nm_theme_options['footer_bar_custom_content'] ) ); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>