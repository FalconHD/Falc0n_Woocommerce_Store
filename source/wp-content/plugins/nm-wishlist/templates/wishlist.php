<?php
/**
 * NM - Wishlist template
 * @version 2.0.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $nm_theme_options, $nm_wishlist_ids, $nm_wishlist_loop;

$wishlist_empty_class = '';
?>
<?php if ( $nm_wishlist_loop && $nm_wishlist_loop->have_posts() ) : ?>

<div id="nm-wishlist">
    <?php if ( function_exists( 'wc_print_notices' ) ) { wc_print_notices(); } // Note: Don't remove (WooCommerce will output multiple messages otherwise) ?>
    
	<div class="nm-row">
        <div class="col-xs-12">
            <div class="nm-wishlist-top">
                <h1><?php esc_html_e( 'Wishlist', 'nm-wishlist' ); ?></h1>
            </div>
            
            <div class="nm-wishlist-products">
                <div id="nm-wishlist-table" class="products">
                    <?php 
                        while ( $nm_wishlist_loop->have_posts() ) : $nm_wishlist_loop->the_post(); 

                        global $product;
                    ?>
                    <ul data-product-id="<?php echo $product->get_id(); ?>">
                        <li class="thumbnail">
                            <a href="<?php the_permalink(); ?>"><?php echo $product->get_image( 'shop_catalog' ); ?></a>
                        </li>
                        <li class="title">
                            <h3 class="woocommerce-loop-product__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                            <?php
                                // Product variations
                                if ( $nm_theme_options['wishlist_show_variations'] && $product->get_type() == 'variable' ) {
                                    nm_product_variations_list( $product );
                                }
                            ?>
                        </li>
                        <li class="price">
                            <?php woocommerce_template_loop_price(); ?>
                        </li>
                        <li class="stock">
                            <?php
                                $stock_status = $product->get_stock_status();
                                
                                if ( $stock_status == 'instock' ) {
                                    echo '<span class="instock">' . esc_html__( 'In stock', 'woocommerce' ) . '</span>';
                                } else {
                                    echo '<span class="outofstock">' . esc_html__( 'Out of stock', 'woocommerce' ) . '</span>';
                                }
                            ?>
                        </li>
                        <li class="actions">
                            <div class="nm-product-buttons">
                                <?php woocommerce_template_loop_add_to_cart(); ?>
                            </div>
                        </li>
                        <li class="remove">
                            <a href="#" class="nm-wishlist-remove"><i class="nm-font nm-font-close2"></i></a>
                        </li>
                    </ul>
                    <?php endwhile; ?>
                </div>
            </div>
            
            <?php if ( $nm_theme_options['wishlist_share'] ) : ?>
            <div class="nm-wishlist-share">
                <?php
                    if ( strlen( $nm_theme_options['wishlist_page_id'] ) > 0 ) :
                        global $nm_wishlist_social_meta;
                        $share_twitter_summary  = esc_attr( str_replace( '%wishlist_url%', '', $nm_theme_options['wishlist_share_text'] ) );
                ?>
                <ul>
                    <li>
                        <span><?php esc_html_e( 'Share', 'woocommerce' ); ?></span>
                    </li>
                    <li>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $nm_wishlist_social_meta['url']; ?>" class="facebook" target="_blank" title="<?php esc_html_e( 'Share on Facebook', 'nm-wishlist' ); ?>">
                            <i class="nm-font nm-font-facebook"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/share?url=<?php echo $nm_wishlist_social_meta['url']; ?>&amp;text=<?php echo $share_twitter_summary; ?>" class="twitter" target="_blank" title="<?php esc_html_e( 'Share on Twitter', 'nm-wishlist' ); ?>">
                            <i class="nm-font nm-font-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a href="http://pinterest.com/pin/create/button/?url=<?php echo $nm_wishlist_social_meta['url']; ?>&amp;description=<?php echo $nm_wishlist_social_meta['description']; ?>&amp;media=<?php echo $nm_wishlist_social_meta['image']; ?>" class="pinterest" target="_blank" title="<?php esc_html_e( 'Pin on Pinterest', 'nm-wishlist' ); ?>" onclick="window.open(this.href);return false;">
                            <i class="nm-font nm-font-pinterest"></i>
                        </a>
                    </li>
                    <li>
                        <a href="mailto:?body=<?php echo $nm_wishlist_social_meta['url']; ?>" class="email" title="<?php esc_html_e( 'Share via Email', 'nm-wishlist' ); ?>">
                            <i class="nm-font nm-font-envelope"></i>
                        </a>
                    </li>
                </ul>
                <?php else: ?>
                <p class="nm-wishlist-share-notice">Social share: Please select the Wishlist page on "Theme Settings > Wishlist" in the WP admin.</p>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div id="nm-wishlist-overlay" class="nm-loader"></div>
    
</div>

<?php 
    else :

        $wishlist_empty_class = ' class="show"';
    
    endif;
?>

<div id="nm-wishlist-empty"<?php echo $wishlist_empty_class; ?>>
    <div class="nm-row">
        <div class="col-xs-12">
            <p class="icon"><i class="nm-font nm-font-close2"></i></p>
            <h1><?php esc_html_e( 'The wishlist is currently empty.', 'nm-wishlist' ); ?></h1>
            <p class="note"><?php printf( esc_html__( 'Click the %s icons to add products', 'nm-wishlist' ), apply_filters( 'nm_wishlist_button_icon', '<i class="nm-font nm-font-heart-o"></i>' ) ); ?></p> 
            <p><a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="button"><?php esc_html_e( 'Return to Shop', 'nm-wishlist' ); ?></a></p>
        </div>
    </div>
</div>