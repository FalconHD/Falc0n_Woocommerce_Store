<?php
	global $nm_theme_options;
    
    // Column classes
    $column_left_size = intval( $nm_theme_options['top_bar_left_column_size'] );
	$column_right_size = 12 - $column_left_size;
    
?>
<div id="nm-top-bar" class="nm-top-bar">
    <div class="nm-row">
        <div class="nm-top-bar-left col-xs-<?php echo esc_attr( $column_left_size ); ?>">
            <?php
                // Social icons (left column)
                if ( $nm_theme_options['top_bar_social_icons'] == 'l_c' ) {
                    echo nm_get_social_profiles( 'nm-top-bar-social' ); // Args: $wrapper_class 
                }
            ?>

            <div class="nm-top-bar-text">
                <?php echo wp_kses_post( do_shortcode( $nm_theme_options['top_bar_text'] ) ); ?>
            </div>
        </div>

        <div class="nm-top-bar-right col-xs-<?php echo esc_attr( $column_right_size ); ?>">
            <?php
                // Social icons (right column)
                if ( $nm_theme_options['top_bar_social_icons'] == 'r_c' ) {
                    echo nm_get_social_profiles( 'nm-top-bar-social' ); // Args: $wrapper_class 
                }
            ?>

            <?php
                // Top-bar menu
                wp_nav_menu( array(
                    'theme_location'	=> 'top-bar-menu',
                    'container'       	=> false,
                    'menu_id'			=> 'nm-top-menu',
                    'fallback_cb'     	=> false,
                    'items_wrap'      	=> '<ul id="%1$s" class="nm-menu">%3$s</ul>'
                ) );
            ?>
        </div>
    </div>                
</div>