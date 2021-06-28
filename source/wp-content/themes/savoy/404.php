<?php get_header(); ?>

<div class="nm-page-not-found">
    <div class="nm-row">
        <div class="col-xs-12">
            <div class="nm-page-not-found-icon">
                <i class="nm-font nm-font-close2"></i>
            </div>
            <h2><?php esc_html_e( 'Page not found.', 'nm-framework' ); ?></h2>
            <p><?php esc_html_e( 'It looks like nothing was found at this location. Click the link below to return home.', 'nm-framework' ); ?></p>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button"><i class="nm-font nm-font-arrow-left"></i> <?php esc_html_e( 'Home', 'nm-framework' ); ?></a>
        </div>
    </div>
</div>

<?php 
    global $nm_theme_options;
    if ( $nm_theme_options['page_not_found_show_products'] ) :
?>
<div class="nm-page-not-found-products">
    <div class="nm-row">
        <div class="col-xs-12">
            <h2 class="nm-page-not-found-products-heading"><?php esc_html_e( 'Featured products', 'woocommerce' ); ?></h2>
            
            <?php
                global $woocommerce_loop;
                $woocommerce_loop['columns_medium'] = '4';
            
                $shortcode = apply_filters( 'nm_page_not_found_shortcode', '[featured_products per_page="4" columns="4"]' );
                echo do_shortcode( $shortcode );
            ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php get_footer(); ?>