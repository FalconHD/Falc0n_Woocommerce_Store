<?php 
	global $nm_theme_options, $nm_globals;
?>
                </div> <!-- .nm-page-wrap-inner -->
            </div> <!-- .nm-page-wrap -->
            
            <footer id="nm-footer" class="nm-footer">
                <?php
                    // Footer widgets
                    if ( is_active_sidebar( 'footer' ) ) {
                        get_template_part( 'template-parts/footer/footer', 'widgets' );
                    }
                ?>
                
                <?php
                    // Footer bar (or Elementor Pro footer location)
                    if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
						get_template_part( 'template-parts/footer/footer', 'bar' );
					}
                ?>
            </footer>
            
            <?php 
                // Mobile menu
                get_template_part( 'template-parts/navigation/navigation', 'mobile' );
            ?>
            
            <?php
                // Cart panel
                if ( $nm_globals['cart_panel'] ) {
                    get_template_part( 'template-parts/woocommerce/cart-panel' );
                }
            ?>
            
            <?php
                // Login panel
                if ( $nm_globals['login_popup'] && ! is_user_logged_in() && ! is_account_page() ) {
                    get_template_part( 'template-parts/woocommerce/login' );
                }
			?>

            <div id="nm-page-overlay"></div>
            
            <div id="nm-quickview" class="clearfix"></div>
            
            <?php wp_footer(); // WordPress footer hook ?>
        
        </div> <!-- .nm-page-overflow -->
	</body>
</html>
