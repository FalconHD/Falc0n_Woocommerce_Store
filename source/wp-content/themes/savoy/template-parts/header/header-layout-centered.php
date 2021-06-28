<?php
	// Ubermenu
	if ( function_exists( 'ubermenu' ) ) {
		$ubermenu = true;
		$ubermenu_wrap_open = '<div class="nm-ubermenu-wrap clear">';
		$ubermenu_wrap_close = '</div>';
	} else {
		$ubermenu = false;
		$ubermenu_wrap_open = $ubermenu_wrap_close = '';
	}
?>
<div class="nm-row">
    <?php echo $ubermenu_wrap_open; ?>
    
    <?php
        // Include header logo
        get_template_part( 'template-parts/header/header', 'logo' );
    ?>

    <div class="nm-main-menu-wrap col-xs-6">
        <nav class="nm-main-menu">
            <ul id="nm-main-menu-ul" class="nm-menu">
                <li class="nm-menu-offscreen menu-item-default">
                    <?php if ( nm_woocommerce_activated() ) { echo nm_get_cart_contents_count(); } ?>
                    <a href="#" id="nm-mobile-menu-button" class="clicked"><div class="nm-menu-icon"><span class="line-1"></span><span class="line-2"></span><span class="line-3"></span></div></a>
                </li>
                <?php
                    if ( ! $ubermenu ) {
                        wp_nav_menu( array(
                            'theme_location'	=> 'main-menu',
                            'container'       	=> false,
                            'fallback_cb'     	=> false,
                            'walker'            => new NM_Sublevel_Walker,
                            'items_wrap'      	=> '%3$s'
                        ) );
                    }
                ?>
            </ul>
        </nav>

        <?php if ( $ubermenu ) { ubermenu( 'main', array( 'theme_location' => 'main-menu' ) ); } ?>
    </div>

    <div class="nm-right-menu-wrap col-xs-6">
        <nav class="nm-right-menu">
            <ul id="nm-right-menu-ul" class="nm-menu">
                <?php
                    wp_nav_menu( array(
                        'theme_location'	=> 'right-menu',
                        'container'       	=> false,
                        'fallback_cb'     	=> false,
                        'walker'            => new NM_Sublevel_Walker,
                        'items_wrap'      	=> '%3$s'
                    ) );
                    
                    // Include default links (Login, Cart etc.)
                    get_template_part( 'template-parts/header/header', 'default-links' );
                ?>
            </ul>
        </nav>
    </div>

    <?php echo $ubermenu_wrap_close; ?>
</div>