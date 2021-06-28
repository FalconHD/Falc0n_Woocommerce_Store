<?php
/**
 *	NM: Shop (AJAX) - Products template
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( have_posts() ) {
    /**
     * Hook: woocommerce_before_shop_loop.
     *
     * @hooked wc_print_notices - 10
     * @hooked woocommerce_result_count - 20
     * @hooked woocommerce_catalog_ordering - 30
     */
    //Needed for "wc_get_loop_prop()" function in conditional below: do_action( 'woocommerce_before_shop_loop' );
    
	echo '<ul class="nm-products">';
    
    //if ( wc_get_loop_prop( 'total' ) ) {
        while ( have_posts() ) { 
            the_post();
            wc_get_template_part( 'content', 'product' );
        }
    //}

	echo '</ul>';
			
	?>
	<div class="nm-infload-link"><?php next_posts_link( '&nbsp;' ); ?></div>
	<?php
}
