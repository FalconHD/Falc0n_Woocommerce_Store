<div id="nm-widget-panel" class="nm-widget-panel">
    <div class="nm-widget-panel-inner">
        <div class="nm-widget-panel-header">
            <div class="nm-widget-panel-header-inner">
                <a href="#" id="nm-widget-panel-close">
                    <span class="nm-cart-panel-title"><?php esc_html_e( 'Cart', 'woocommerce' ); ?></span>
                    <span class="nm-widget-panel-close-title"><?php esc_html_e( 'Close', 'woocommerce' ); ?></span>
                </a>
            </div>
        </div>

        <div class="widget_shopping_cart_content">
            <?php woocommerce_mini_cart(); ?>
        </div>
    </div>
</div>