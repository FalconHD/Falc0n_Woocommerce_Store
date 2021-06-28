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
<div class="nm-header-row nm-row">
    <div class="nm-header-col col-xs-12">
        <?php echo $ubermenu_wrap_open; ?>
        
        <?php
            // Include header logo
            get_template_part( 'template-parts/header/header', 'logo' );
        ?>

        <?php if ( $ubermenu ) : ?>
            <?php ubermenu( 'main', array( 'theme_location' => 'main-menu' ) ); ?>
        <?php else : ?>               
        <nav class="nm-main-menu">
            <ul id="nm-main-menu-ul" class="nm-menu">
                <?php
                    wp_nav_menu( array(
                        'theme_location'	=> 'main-menu',
                        'container'       	=> false,
                        'fallback_cb'     	=> false,
                        'walker'            => new NM_Sublevel_Walker,
                        'items_wrap'      	=> '%3$s'
                    ) );
                ?>
            </ul>
        </nav>
        <?php endif; ?>

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
                <li class="nm-menu-offscreen menu-item-default">
                    <?php if ( nm_woocommerce_activated() ) { echo nm_get_cart_contents_count(); } ?>
                    <a href="#" id="nm-mobile-menu-button" class="clicked"><div class="nm-menu-icon"><span class="line-1"></span><span class="line-2"></span><span class="line-3"></span></div></a>
                </li>
            </ul>
        </nav>

        <?php echo $ubermenu_wrap_close; ?>
    </div>
</div>