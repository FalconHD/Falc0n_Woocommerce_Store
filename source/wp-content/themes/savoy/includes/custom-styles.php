<?php
/*
 *  Save custom styles
 */
if ( ! function_exists( 'nm_custom_styles_generate' ) ) :

function nm_custom_styles_generate( $action_value_placeholder = null, $save_styles = true ) {
	global $nm_theme_options;
	
    
	/* 
     *  Fonts
     */
    // Font
    if ( $nm_theme_options['main_font_source'] === '2' && isset( $nm_theme_options['main_font_adobefonts_project_id'] ) ) {
        $body_font_css = 'body{font-family:' . $nm_theme_options['main_adobefonts_font'] . ',sans-serif;}'; // Adobe Fonts font
    } else if ( $nm_theme_options['main_font_source'] === '3' ) {
        $body_font_css = $nm_theme_options['main_font_custom_css']; // Custom CSS
    } else {
        $body_font_css = 'body{font-family:' . $nm_theme_options['main_font']['font-family'] . ',sans-serif;}'; // Standard + Google Webfonts font
    }
    
    // Font - Header
    $header_font_enabled = ( $nm_theme_options['header_font_source'] !== '0' ) ? true : false;
    if ( $header_font_enabled ) {
        if ( $nm_theme_options['header_font_source'] == '2' && isset( $nm_theme_options['header_font_adobefonts_project_id'] ) ) {
            $header_font = $nm_theme_options['header_adobefonts_font']; // Adobe Fonts font
        } else {
            $header_font = $nm_theme_options['header_font']['font-family']; // Standard + Google Webfonts font
        }
    }
    
    // Font - Headings
    $headings_font_enabled = ( $nm_theme_options['secondary_font_source'] !== '0' ) ? true : false;
    if ( $headings_font_enabled ) {
        if ( $nm_theme_options['secondary_font_source'] == '2' && isset( $nm_theme_options['secondary_font_adobefonts_project_id'] ) ) {
            $headings_font = $nm_theme_options['secondary_adobefonts_font']; // Adobe Fonts font
        } else {
            $headings_font = $nm_theme_options['secondary_font']['font-family']; // Standard + Google Webfonts font
        }
    }
    
    
	/*
     *  Header height
     */
	$header_spacing_desktop = intval( $nm_theme_options['header_spacing_top'] ) + intval( $nm_theme_options['header_spacing_bottom'] );
    $header_spacing_alt = intval( $nm_theme_options['header_spacing_top_alt'] ) + intval( $nm_theme_options['header_spacing_bottom_alt'] );
    
    $logo_height_desktop = intval( $nm_theme_options['logo_height'] );
    $logo_height_tablet = intval( $nm_theme_options['logo_height_tablet'] );
    $logo_height_mobile = intval( $nm_theme_options['logo_height_mobile'] );
    
    $menu_height_desktop = intval( $nm_theme_options['menu_height'] );
    $menu_height_tablet = intval( $nm_theme_options['menu_height_tablet'] );
    $menu_height_mobile = intval( $nm_theme_options['menu_height_mobile'] );
    
    // Desktop
    if ( strpos( $nm_theme_options['header_layout'], 'stacked' ) !== false ) { // Is a "stacked" header layout enabled?
        $header_height_desktop = $menu_height_desktop;
        $stacked_logo_height_desktop = ( $logo_height_desktop > $menu_height_desktop ) ? $logo_height_desktop : $menu_height_desktop;
        $header_total_height_desktop = $header_spacing_desktop + $stacked_logo_height_desktop + intval( $nm_theme_options['logo_spacing_bottom'] ) + $header_height_desktop;
    } else {
        $header_height_desktop = ( $logo_height_desktop > $menu_height_desktop ) ? $logo_height_desktop : $menu_height_desktop;
        $header_total_height_desktop = $header_spacing_desktop + $header_height_desktop;
    }
    // Tablet
    $header_height_tablet = ( $logo_height_tablet > $menu_height_tablet ) ? $logo_height_tablet : $menu_height_tablet;
    $header_total_height_tablet = $header_spacing_alt + $header_height_tablet;
    // Mobile
    $header_height_mobile = ( $logo_height_mobile > $menu_height_mobile ) ? $logo_height_mobile : $menu_height_mobile;
    $header_total_height_mobile = $header_spacing_alt + $header_height_mobile;
    
	
	/* 
	 *	NOTE: Keep CSS formatting unchanged (single whitespaces will not be minified, only new-lines and tab-indents)
	 */
	ob_start();
?>
<style>
/* Typography
--------------------------------------------------------------- */
<?php
echo $body_font_css;

if ( $headings_font_enabled ) :
?>
h1,
h2,
h3,
h4,
h5,
h6,
.nm-alt-font
{
	font-family:<?php echo esc_attr( $headings_font ); ?>,sans-serif;
}
<?php endif; ?>

/* Typography: Header Menu
--------------------------------------------------------------- */
/* style.css */
.nm-menu li a
{
    <?php if ( $header_font_enabled ) : ?>
	font-family:<?php echo esc_attr( $header_font ); ?>,sans-serif;
    <?php endif; ?>
	font-size:<?php echo intval( $nm_theme_options['font_size_header_menu'] ); ?>px;
    font-weight:<?php echo esc_attr( $nm_theme_options['font_weight_header_menu'] ); ?>;
    <?php if ( ! empty( $nm_theme_options['letter_spacing_header_menu'] ) ) : ?>
    letter-spacing:<?php echo intval( $nm_theme_options['letter_spacing_header_menu'] ); ?>px;
    <?php endif; ?>
}

/* Typography: Mobile Menu
--------------------------------------------------------------- */
/* style.css */
#nm-mobile-menu .menu > li > a
{
    <?php if ( $header_font_enabled ) : ?>
	font-family:<?php echo esc_attr( $header_font ); ?>,sans-serif;
    <?php endif; ?>
    /*font-size:<?php echo intval( $nm_theme_options['font_size_mobile_menu'] ); ?>px;*/
    font-weight:<?php echo esc_attr( $nm_theme_options['font_weight_mobile_menu'] ); ?>;
    <?php if ( ! empty( $nm_theme_options['letter_spacing_mobile_menu'] ) ) : ?>
    letter-spacing:<?php echo intval( $nm_theme_options['letter_spacing_mobile_menu'] ); ?>px;
    <?php endif; ?>
}
#nm-mobile-menu-main-ul.menu > li > a
{
    font-size:<?php echo intval( $nm_theme_options['font_size_mobile_menu'] ); ?>px;
}
#nm-mobile-menu-secondary-ul.menu li a
{
    font-size:<?php echo intval( $nm_theme_options['font_size_mobile_menu_secondary'] ); ?>px;
}

/* Typography: Body Text - Large
--------------------------------------------------------------- */
/* nm-js_composer.css */
.vc_tta.vc_tta-accordion .vc_tta-panel-title > a,
.vc_tta.vc_general .vc_tta-tab > a,
/* elements.css */
.nm-team-member-content h2,
.nm-post-slider-content h3,
.vc_pie_chart .wpb_pie_chart_heading,
.wpb_content_element .wpb_tour_tabs_wrapper .wpb_tabs_nav a,
.wpb_content_element .wpb_accordion_header a,
/* shop.css */
.woocommerce-order-details .order_details tfoot tr:last-child th,
.woocommerce-order-details .order_details tfoot tr:last-child td,
#order_review .shop_table tfoot .order-total,
#order_review .shop_table tfoot .order-total,
.cart-collaterals .shop_table tr.order-total,
.shop_table.cart .nm-product-details a,
#nm-shop-sidebar-popup #nm-shop-search input,
.nm-shop-categories li a,
.nm-shop-filter-menu li a,
.woocommerce-message,
.woocommerce-info,
.woocommerce-error,
/* style.css */
blockquote,
.commentlist .comment .comment-text .meta strong,
.nm-related-posts-content h3,
.nm-blog-no-results h1,
.nm-term-description,
.nm-blog-categories-list li a,
.nm-blog-categories-toggle li a,
.nm-blog-heading h1,
#nm-mobile-menu-top-ul .nm-mobile-menu-item-search input
{
	font-size:<?php echo intval( $nm_theme_options['font_size_large'] ); ?>px;
}
@media all and (max-width:768px)
{
    /* elements.css */
	.vc_toggle_title h3
    {
		font-size:<?php echo intval( $nm_theme_options['font_size_large'] ); ?>px;
	}
}
@media all and (max-width:400px)
{
    /* shop.css */
    #nm-shop-search input
    {
        font-size:<?php echo intval( $nm_theme_options['font_size_large'] ); ?>px;
    }
}

/* Typography: Body Text - Medium
--------------------------------------------------------------- */
/* elements.css */
.add_to_cart_inline .add_to_cart_button,
.add_to_cart_inline .amount,
.nm-product-category-text > a,
.nm-testimonial-description,
.nm-feature h3,
.nm_btn,
.vc_toggle_content,
.nm-message-box,
.wpb_text_column,
/* shop.css */
#nm-wishlist-table ul li.title .woocommerce-loop-product__title,
.nm-order-track-top p,
.customer_details h3,
.woocommerce-order-details .order_details tbody,
.woocommerce-MyAccount-content .shop_table tr th,
.woocommerce-MyAccount-navigation ul li a,
.nm-MyAccount-user-info .nm-username,
.nm-MyAccount-dashboard,
.nm-myaccount-lost-reset-password h2,
.nm-login-form-divider span,
.woocommerce-thankyou-order-details li strong,
.woocommerce-order-received h3,
#order_review .shop_table tbody .product-name,
.woocommerce-checkout .nm-coupon-popup-wrap .nm-shop-notice,
.nm-checkout-login-coupon .nm-shop-notice,
.shop_table.cart .nm-product-quantity-pricing .product-subtotal,
.shop_table.cart .product-quantity,
.shop_attributes tr th,
.shop_attributes tr td,
#tab-description,
.woocommerce-tabs .tabs li a,
.woocommerce-product-details__short-description,
.nm-shop-no-products h3,
.nm-infload-controls a,
#nm-shop-browse-wrap .term-description,
.list_nosep .nm-shop-categories .nm-shop-sub-categories li a,
.nm-shop-taxonomy-text .term-description,
.nm-shop-loop-details h3,
.woocommerce-loop-category__title,
/* style.css */
div.wpcf7-response-output,
.wpcf7 .wpcf7-form-control,
.widget_search button,
.widget_product_search #searchsubmit,
#wp-calendar caption,
.widget .nm-widget-title,
.post .entry-content,
.comment-form p label,
.no-comments,
.commentlist .pingback p,
.commentlist .trackback p,
.commentlist .comment .comment-text .description,
.nm-search-results .nm-post-content,
.post-password-form > p:first-child,
.nm-post-pagination a .long-title,
.nm-blog-list .nm-post-content,
.nm-blog-grid .nm-post-content,
.nm-blog-classic .nm-post-content,
.nm-blog-pagination a,
.nm-blog-categories-list.columns li a,
.page-numbers li a,
.page-numbers li span,
#nm-widget-panel .total,
#nm-widget-panel .nm-cart-panel-item-price .amount,
#nm-widget-panel .quantity .qty,
#nm-widget-panel .nm-cart-panel-quantity-pricing > span.quantity,
#nm-widget-panel .product-quantity,
.nm-cart-panel-product-title,
#nm-widget-panel .product_list_widget .empty,
#nm-cart-panel-loader h5,
.nm-widget-panel-header,
.button,
input[type=submit]
{
	font-size:<?php echo intval( $nm_theme_options['font_size_medium'] ); ?>px;
}
@media all and (max-width:991px)
{
    /* shop.css */
    #nm-shop-sidebar .widget .nm-widget-title,
	.nm-shop-categories li a
    {
		font-size:<?php echo intval( $nm_theme_options['font_size_medium'] ); ?>px;
	}
}
@media all and (max-width:768px)
{
    /* nm-js_composer.css */
    .vc_tta.vc_tta-accordion .vc_tta-panel-title > a,
    .vc_tta.vc_tta-tabs.vc_tta-tabs-position-left .vc_tta-tab > a,
    .vc_tta.vc_tta-tabs.vc_tta-tabs-position-top .vc_tta-tab > a,
    /* elements.css */
    .wpb_content_element .wpb_tour_tabs_wrapper .wpb_tabs_nav a,
	.wpb_content_element .wpb_accordion_header a,
    /* style.css */
	.nm-term-description
    {
		font-size:<?php echo intval( $nm_theme_options['font_size_medium'] ); ?>px;
	}
}
@media all and (max-width:550px)
{
    /* shop.css */
    .shop_table.cart .nm-product-details a,
    .nm-shop-notice,
    /* style.css */
    .nm-related-posts-content h3
    {
        font-size:<?php echo intval( $nm_theme_options['font_size_medium'] ); ?>px;
    }
}
@media all and (max-width:400px)
{
    /* elements.css */
    .nm-product-category-text .nm-product-category-heading,
    .nm-team-member-content h2,
    /* shop.css */
    #nm-wishlist-empty h1,
    .cart-empty,
    .nm-shop-filter-menu li a,
    /* style.css */
	.nm-blog-categories-list li a
    {
		font-size:<?php echo intval( $nm_theme_options['font_size_medium'] ); ?>px;
	}
}

/* Typography: Body Text - Small
--------------------------------------------------------------- */
/* elements.css */
.vc_progress_bar .vc_single_bar .vc_label,
/* shop.css */
.woocommerce-tabs .tabs li a span,
.product .summary .price del .amount,
#nm-shop-sidebar-popup-reset-button,
#nm-shop-sidebar-popup .nm-shop-sidebar .widget:last-child .nm-widget-title,
#nm-shop-sidebar-popup .nm-shop-sidebar .widget .nm-widget-title,
.nm-shop-filter-menu li a i,
.woocommerce-loop-category__title .count,
/* style.css */
span.wpcf7-not-valid-tip,
.widget_rss ul li .rss-date,
.wp-caption-text,
.comment-respond h3 #cancel-comment-reply-link,
.nm-blog-categories-toggle li .count,
.nm-menu-wishlist-count,
.nm-menu li.nm-menu-offscreen .nm-menu-cart-count,
.nm-menu-cart .count,
.nm-menu .sub-menu li a,
body
{
	font-size:<?php echo intval( $nm_theme_options['font_size_small'] ); ?>px;
}
@media all and (max-width:768px)
{
    /* style.css */
	.wpcf7 .wpcf7-form-control
    {
		font-size:<?php echo intval( $nm_theme_options['font_size_small'] ); ?>px;
	}
}
@media all and (max-width:400px)
{
    /* style.css */
    .nm-blog-grid .nm-post-content,
    .header-mobile-default .nm-menu-cart.no-icon .count
    {
        font-size:<?php echo intval( $nm_theme_options['font_size_small'] ); ?>px;
    }
}

/* Typography: Body Text - Extra Small
--------------------------------------------------------------- */
/* shop.css */
#nm-wishlist-table .nm-variations-list,
.nm-MyAccount-user-info .nm-logout-button.border,
#order_review .place-order noscript,
#payment .payment_methods li .payment_box,
#order_review .shop_table tfoot .woocommerce-remove-coupon,
.cart-collaterals .shop_table tr.cart-discount td a,
#nm-shop-sidebar-popup #nm-shop-search-notice,
.wc-item-meta,
.variation,
.woocommerce-password-hint,
.woocommerce-password-strength,
.nm-validation-inline-notices .form-row.woocommerce-invalid-required-field:after
{
    font-size:<?php echo intval( $nm_theme_options['font_size_xsmall'] ); ?>px;
}

/* Typography: Body - Style
--------------------------------------------------------------- */
body
{
    font-weight:<?php echo esc_attr( $nm_theme_options['font_weight_body'] ); ?>;
    <?php if ( ! empty( $nm_theme_options['letter_spacing_body'] ) ) : ?>
    letter-spacing:<?php echo intval( $nm_theme_options['letter_spacing_body'] ); ?>px;
    <?php endif; ?>
}

/* Typography: Headings - Style
--------------------------------------------------------------- */
h1, .h1-size
{
    font-weight:<?php echo esc_attr( $nm_theme_options['font_weight_h1'] ); ?>;
    <?php if ( ! empty( $nm_theme_options['letter_spacing_h1'] ) ) : ?>
    letter-spacing:<?php echo intval( $nm_theme_options['letter_spacing_h1'] ); ?>px;
    <?php endif; ?>
}
h2, .h2-size
{
    font-weight:<?php echo esc_attr( $nm_theme_options['font_weight_h2'] ); ?>;
    <?php if ( ! empty( $nm_theme_options['letter_spacing_h2'] ) ) : ?>
    letter-spacing:<?php echo intval( $nm_theme_options['letter_spacing_h2'] ); ?>px;
    <?php endif; ?>
}
h3, .h3-size
{
    font-weight:<?php echo esc_attr( $nm_theme_options['font_weight_h3'] ); ?>;
    <?php if ( ! empty( $nm_theme_options['letter_spacing_h3'] ) ) : ?>
    letter-spacing:<?php echo intval( $nm_theme_options['letter_spacing_h3'] ); ?>px;
    <?php endif; ?>
}
h4, .h4-size,
h5, .h5-size,
h6, .h6-size
{
    font-weight:<?php echo esc_attr( $nm_theme_options['font_weight_h456'] ); ?>;
    <?php if ( ! empty( $nm_theme_options['letter_spacing_h456'] ) ) : ?>
    letter-spacing:<?php echo intval( $nm_theme_options['letter_spacing_h456'] ); ?>px;
    <?php endif; ?>
}
    
/* Typography: Color
--------------------------------------------------------------- */
/* style.css */
body
{
	color:<?php echo esc_attr( $nm_theme_options['main_font_color'] ); ?>;
}
/* nm-portfolio.css */
.nm-portfolio-single-back a span {
    background:<?php echo esc_attr( $nm_theme_options['main_font_color'] ); ?>;
}

/* magnific-popup.css */
.mfp-close,
/* elements.css */
.wpb_content_element .wpb_tour_tabs_wrapper .wpb_tabs_nav li.ui-tabs-active a,
.vc_pie_chart .vc_pie_chart_value,
.vc_progress_bar .vc_single_bar .vc_label .vc_label_units,
.nm-testimonial-description,
/* shop.css */
.form-row label,
.woocommerce-form__label,
#nm-shop-search-close:hover,
.products .price .amount,
.nm-shop-loop-actions > a,
.nm-shop-loop-actions > a:active,
.nm-shop-loop-actions > a:focus,
.nm-infload-controls a,
.woocommerce-breadcrumb a, .woocommerce-breadcrumb span,
.variations,
.woocommerce-grouped-product-list-item__label a,
.woocommerce-grouped-product-list-item__price ins .amount,
.woocommerce-grouped-product-list-item__price > .amount,
.nm-quantity-wrap .quantity .nm-qty-minus,
.nm-quantity-wrap .quantity .nm-qty-plus,
.product .summary .single_variation_wrap .nm-quantity-wrap label:not(.nm-qty-label-abbrev),
.woocommerce-tabs .tabs li.active a,
.shop_attributes th,
.product_meta,
.shop_table.cart .nm-product-details a,
.shop_table.cart .product-quantity,
.shop_table.cart .nm-product-quantity-pricing .product-subtotal,
.shop_table.cart .product-remove a,
.cart-collaterals,
.nm-cart-empty,
#order_review .shop_table,
#payment .payment_methods li label,
.woocommerce-thankyou-order-details li strong,
.wc-bacs-bank-details li strong,
.nm-MyAccount-user-info .nm-username strong,
.woocommerce-MyAccount-navigation ul li a:hover,
.woocommerce-MyAccount-navigation ul li.is-active a,
.woocommerce-table--order-details,
#nm-wishlist-empty .note i,
/* style.css */
a.dark,
a:hover,
.nm-blog-heading h1 strong,
.nm-post-header .nm-post-meta a,
.nm-post-pagination a,
.commentlist > li .comment-text .meta strong,
.commentlist > li .comment-text .meta strong a,
.comment-form p label,
.entry-content strong,
blockquote,
blockquote p,
.widget_search button,
.widget_product_search #searchsubmit,
.widget_recent_comments ul li .comment-author-link,
.widget_recent_comments ul li:before
{
    color:<?php echo esc_attr( $nm_theme_options['font_strong_color'] ); ?>;
}
/* shop.css */
@media all and (max-width: 991px)
{
    .nm-shop-menu .nm-shop-filter-menu li a:hover,
    .nm-shop-menu .nm-shop-filter-menu li.active a,
    #nm-shop-sidebar .widget.show .nm-widget-title,
	#nm-shop-sidebar .widget .nm-widget-title:hover
    {
        color:<?php echo esc_attr( $nm_theme_options['font_strong_color'] ); ?>;
    }
}
/* nm-portfolio.css */
.nm-portfolio-single-back a:hover span
{
    background:<?php echo esc_attr( $nm_theme_options['font_strong_color'] ); ?>;
}

/* elements.css */
.wpb_content_element .wpb_tour_tabs_wrapper .wpb_tabs_nav a,
.wpb_content_element .wpb_accordion_header a,
/* shop.css */
#nm-shop-search-close,
.woocommerce-breadcrumb,
.nm-single-product-menu a,
.star-rating:before,
.woocommerce-tabs .tabs li a,
.product_meta span.sku,
.product_meta a,
.nm-product-wishlist-button-wrap a,
.nm-product-share a,
.nm-wishlist-share ul li a:not(:hover),
/* style.css */
.nm-post-meta,
.nm-post-share a,
.nm-post-pagination a .short-title,
.commentlist > li .comment-text .meta time
{
    color:<?php echo esc_attr( $nm_theme_options['font_subtle_color'] ); ?>;
}

/* elements.css */
.vc_toggle_title i,
/* shop.css */
#nm-wishlist-empty p.icon i,
/* style.css */
h1
{
	color:<?php echo esc_attr( $nm_theme_options['heading_1_color'] ); ?>;
}
h2
{
	color:<?php echo esc_attr( $nm_theme_options['heading_2_color'] ); ?>;
}
h3
{
	color:<?php echo esc_attr( $nm_theme_options['heading_3_color'] ); ?>;
}
h4, h5, h6
{
	color:<?php echo esc_attr( $nm_theme_options['heading_456_color'] ); ?>;
}

/* Highlight color: Font
--------------------------------------------------------------- */
a,
a.dark:hover,
a.gray:hover,
a.invert-color:hover,
.nm-highlight-text,
.nm-highlight-text h1,
.nm-highlight-text h2,
.nm-highlight-text h3,
.nm-highlight-text h4,
.nm-highlight-text h5,
.nm-highlight-text h6,
.nm-highlight-text p,
.nm-menu-wishlist-count,
.nm-menu-cart a .count,
.nm-menu li.nm-menu-offscreen .nm-menu-cart-count,
.page-numbers li span.current,
.page-numbers li a:hover,
.nm-blog .sticky .nm-post-thumbnail:before,
.nm-blog .category-sticky .nm-post-thumbnail:before,
.nm-blog-categories-list li a:hover,
.nm-blog-categories ul li.current-cat a,
.widget ul li.active,
.widget ul li a:hover,
.widget ul li a:focus,
.widget ul li a.active,
#wp-calendar tbody td a,
/* elements.css */
.nm-banner-link.type-txt:hover,
.nm-banner.text-color-light .nm-banner-link.type-txt:hover,
.nm-portfolio-categories li.current a,
.add_to_cart_inline ins,
.nm-product-categories.layout-separated .product-category:hover .nm-product-category-text > a,
/* shop.css */
.woocommerce-breadcrumb a:hover,
.products .price ins .amount,
.products .price ins,
.no-touch .nm-shop-loop-actions > a:hover,
.nm-shop-menu ul li a:hover,
.nm-shop-menu ul li.current-cat > a,
.nm-shop-menu ul li.active a,
.nm-shop-heading span,
.nm-single-product-menu a:hover,
.woocommerce-product-gallery__trigger:hover,
.woocommerce-product-gallery .flex-direction-nav a:hover,
.product-summary .price .amount,
.product-summary .price ins,
.product .summary .price .amount,
.nm-product-wishlist-button-wrap a.added:active,
.nm-product-wishlist-button-wrap a.added:focus,
.nm-product-wishlist-button-wrap a.added:hover,
.nm-product-wishlist-button-wrap a.added,
.woocommerce-tabs .tabs li a span,
#review_form .comment-form-rating .stars:hover a,
#review_form .comment-form-rating .stars.has-active a,
.product_meta a:hover,
.star-rating span:before,
.nm-order-view .commentlist li .comment-text .meta,
.nm_widget_price_filter ul li.current,
.post-type-archive-product .widget_product_categories .product-categories > li:first-child > a,
.widget_product_categories ul li.current-cat > a,
.widget_layered_nav ul li.chosen a,
.widget_layered_nav_filters ul li.chosen a,
.product_list_widget li ins .amount,
.woocommerce.widget_rating_filter .wc-layered-nav-rating.chosen > a,
.nm-wishlist-button.added:active,
.nm-wishlist-button.added:focus,
.nm-wishlist-button.added:hover,
.nm-wishlist-button.added,
/* slick-theme.css */
.slick-prev:not(.slick-disabled):hover,
.slick-next:not(.slick-disabled):hover,
/* Flickity - style.css */
.flickity-button:hover,
/* photoswipe-skin.css */
.pswp__button:hover,
/* nm-portfolio.css */
.nm-portfolio-categories li a:hover
{
	color:<?php echo esc_attr( $nm_theme_options['highlight_color'] ); ?>;
}

/* Highlight color: Border
--------------------------------------------------------------- */
.nm-blog-categories ul li.current-cat a,
/* elements.css */
.nm-portfolio-categories li.current a,
/* shop.css */
.woocommerce-product-gallery.pagination-enabled .flex-control-thumbs li img.flex-active,
.widget_layered_nav ul li.chosen a,
.widget_layered_nav_filters ul li.chosen a,
/* slick-theme.css */
.slick-dots li.slick-active button,
/* Flickity - style.css */
.flickity-page-dots .dot.is-selected
{
	border-color:<?php echo esc_attr( $nm_theme_options['highlight_color'] ); ?>;
}

/* Highlight color: Background
--------------------------------------------------------------- */
.blockUI.blockOverlay:after,
.nm-loader:after,
.nm-image-overlay:before,
.nm-image-overlay:after,
.gallery-icon:before,
.gallery-icon:after,
.widget_tag_cloud a:hover,
.widget_product_tag_cloud a:hover
{
	background:<?php echo esc_attr( $nm_theme_options['highlight_color'] ); ?>;
}
@media all and (max-width:400px)
{	
    /* shop.css */
    .woocommerce-product-gallery.pagination-enabled .flex-control-thumbs li img.flex-active,
    /* slick-theme.css */
	.slick-dots li.slick-active button,
    /* Flickity - style.css */
    .flickity-page-dots .dot.is-selected
	{
		background:<?php echo esc_attr( $nm_theme_options['highlight_color'] ); ?>;
	}
}

/* Borders & Dividers
--------------------------------------------------------------- */
/* style.css */
.header-border-1 .nm-header,
.nm-blog-list .nm-post-divider,
#nm-blog-pagination.infinite-load,
.nm-post-pagination,
.no-post-comments .nm-related-posts,
.nm-footer-widgets.has-border,
/* shop.css */
#nm-shop-browse-wrap.nm-shop-description-borders .term-description,
.nm-shop-sidebar-default #nm-shop-sidebar .widget,
.nm-infload-controls a,
.woocommerce-tabs,
.upsells,
.related,
.shop_table.cart tr td,
#order_review .shop_table tbody tr th,
#order_review .shop_table tbody tr td,
#payment .payment_methods,
#payment .payment_methods li,
.woocommerce-MyAccount-orders tr td,
.woocommerce-MyAccount-orders tr:last-child td,
.woocommerce-table--order-details tbody tr td,
.woocommerce-table--order-details tbody tr:first-child td,
.woocommerce-table--order-details tfoot tr:last-child td,
.woocommerce-table--order-details tfoot tr:last-child th,
#nm-wishlist-table > ul > li,
#nm-wishlist-table > ul:first-child > li,
/* elements.css */
.wpb_accordion .wpb_accordion_section,
/* nm-portfolio.css */
.nm-portfolio-single-footer
{
    border-color:<?php echo esc_attr( $nm_theme_options['borders_color'] ); ?>;
}
/* style.css */
.nm-blog-classic .nm-post-divider,
.nm-search-results .nm-post-divider
{
    background:<?php echo esc_attr( $nm_theme_options['borders_color'] ); ?>;
}

/* style.css */
.nm-blog-categories-list li span,
/* shop.css */
.nm-shop-menu ul li > span,
/* nm-portfolio.css */
.nm-portfolio-categories li span
{
    color: <?php echo esc_attr( $nm_theme_options['dividers_color'] ); ?>;
}
/* style.css */
.nm-post-meta:before,
/* elements.css */
.nm-testimonial-author span:before
{
    background:<?php echo esc_attr( $nm_theme_options['dividers_color'] ); ?>;
}

/* Button
--------------------------------------------------------------- */
.button,
input[type=submit],
.widget_tag_cloud a, .widget_product_tag_cloud a,
/* elements.css */
.add_to_cart_inline .add_to_cart_button,
/* shop.css */
#nm-shop-sidebar-popup-button,
#order_review .shop_table tbody .product-name .product-quantity
{
	color:<?php echo esc_attr( $nm_theme_options['button_font_color'] ); ?>;
	background-color:<?php echo esc_attr( $nm_theme_options['button_background_color'] ); ?>;
}

.button:hover,
input[type=submit]:hover
{
	color:<?php echo esc_attr( $nm_theme_options['button_font_color'] ); ?>;
}

/* Button - Border
--------------------------------------------------------------- */
#nm-blog-pagination a,
.button.border
{
	border-color:<?php echo esc_attr( $nm_theme_options['button_border_color'] ); ?>;
}
#nm-blog-pagination a,
#nm-blog-pagination a:hover,
.button.border,
.button.border:hover
{
	color:<?php echo esc_attr( $nm_theme_options['button_border_font_color'] ); ?>;
}
#nm-blog-pagination a:not([disabled]):hover,
.button.border:not([disabled]):hover
{
	color:<?php echo esc_attr( $nm_theme_options['button_border_font_color'] ); ?>;
    border-color:<?php echo esc_attr( $nm_theme_options['button_border_hover_color'] ); ?>;
}

    
/* Quantity
--------------------------------------------------------------- */
/* shop.css */
.product-summary .quantity .nm-qty-minus,
.product-summary .quantity .nm-qty-plus
{
	color:<?php echo esc_attr( $nm_theme_options['button_background_color'] ); ?>;
}

<?php if ( $nm_theme_options['full_width_layout'] ) : ?>
/* Grid - Full width
--------------------------------------------------------------- */
.nm-row
{
	max-width:none;
}
.woocommerce-cart .nm-page-wrap-inner > .nm-row,
.woocommerce-checkout .nm-page-wrap-inner > .nm-row
{
	max-width:1280px;
}
@media (min-width: 1400px)
{
	.nm-row
	{
		padding-right:2.5%;
		padding-left:2.5%;
	}
}
<?php endif; ?>

/* Background
--------------------------------------------------------------- */
.nm-page-wrap
{
	<?php if ( strlen( $nm_theme_options['main_background_image']['url'] ) > 0 ) : ?>
	background-image:url("<?php echo esc_url( $nm_theme_options['main_background_image']['url'] ); ?>");
	<?php if ( $nm_theme_options['main_background_image_type'] == 'fixed' ) : ?>
	background-attachment:fixed;
	background-size:cover;
	<?php else : ?>
	background-repeat:repeat;
	background-position:0 0;
	<?php endif; endif; ?>
	background-color:<?php echo esc_attr( $nm_theme_options['main_background_color'] ); ?>;
}
.nm-divider .nm-divider-title,
.nm-header-search
{
    background:<?php echo esc_attr( $nm_theme_options['main_background_color'] ); ?>;
}
.woocommerce-cart .blockOverlay,
.woocommerce-checkout .blockOverlay {
    background-color:<?php echo esc_attr( $nm_theme_options['main_background_color'] ); ?> !important;
}
    
/* Top bar
--------------------------------------------------------------- */
.nm-top-bar
{
	background:<?php echo esc_attr( $nm_theme_options['top_bar_background_color'] ); ?>;
}
.nm-top-bar .nm-top-bar-text,
.nm-top-bar .nm-top-bar-text a,
.nm-top-bar .nm-menu > li > a,
.nm-top-bar .nm-menu > li > a:hover,
.nm-top-bar-social li i
{
	color:<?php echo esc_attr( $nm_theme_options['top_bar_font_color'] ); ?>;
}

/* Header
--------------------------------------------------------------- */
.nm-header-placeholder
{
	height:<?php echo $header_total_height_desktop; ?>px;
}
.nm-header
{
	line-height:<?php echo $header_height_desktop; ?>px;
	padding-top:<?php echo intval( $nm_theme_options['header_spacing_top'] ); ?>px;
	padding-bottom:<?php echo intval( $nm_theme_options['header_spacing_bottom'] ); ?>px;
	background:<?php echo esc_attr( $nm_theme_options['header_background_color'] ); ?>;
}
.home .nm-header
{
	background:<?php echo esc_attr( $nm_theme_options['header_home_background_color'] ); ?>;
}
.mobile-menu-open .nm-header
{
	background:<?php echo esc_attr( $nm_theme_options['header_slide_menu_open_background_color'] ); ?> !important;
}
.header-on-scroll .nm-header,
.home.header-transparency.header-on-scroll .nm-header
{
	background:<?php echo esc_attr( $nm_theme_options['header_float_background_color'] ); ?>;
}
.header-on-scroll .nm-header:not(.static-on-scroll)
{
    padding-top:<?php echo intval( $nm_theme_options['header_spacing_top_alt'] ); ?>px;
	padding-bottom:<?php echo intval( $nm_theme_options['header_spacing_bottom_alt'] ); ?>px;
}
.nm-header.stacked .nm-header-logo,
.nm-header.stacked-centered .nm-header-logo
{
    padding-bottom:<?php echo intval( $nm_theme_options['logo_spacing_bottom'] ); ?>px;
}
.nm-header-logo svg,
.nm-header-logo img
{
	height:<?php echo $logo_height_desktop; ?>px;
}
@media all and (max-width:991px)
{
    .nm-header-placeholder
    {
        height:<?php echo $header_total_height_tablet; ?>px;
    }
    .nm-header
    {
        line-height:<?php echo $header_height_tablet; ?>px;
        padding-top:<?php echo intval( $nm_theme_options['header_spacing_top_alt'] ); ?>px;
        padding-bottom:<?php echo intval( $nm_theme_options['header_spacing_bottom_alt'] ); ?>px;
	}
    .nm-header.stacked .nm-header-logo,
    .nm-header.stacked-centered .nm-header-logo
    {
        padding-bottom:0px;
    }
    .nm-header-logo svg,
    .nm-header-logo img
	{
		height:<?php echo $logo_height_tablet; ?>px;
	}
}
@media all and (max-width:400px)
{
    .nm-header-placeholder
    {
        height:<?php echo $header_total_height_mobile; ?>px;
    }
    .nm-header
    {
        line-height:<?php echo $header_height_mobile; ?>px;
	}
    .nm-header-logo svg,
	.nm-header-logo img
	{
		height:<?php echo $logo_height_mobile; ?>px;
	}
}

/* Menus
--------------------------------------------------------------- */
.nm-menu li a
{
	color:<?php echo esc_attr( $nm_theme_options['header_navigation_color'] ); ?>;
}
.nm-menu li a:hover
{
	color:<?php echo esc_attr( $nm_theme_options['header_navigation_highlight_color'] ); ?>;
}

/* Menu: Header transparency */
.header-transparency-light:not(.header-on-scroll):not(.mobile-menu-open) #nm-main-menu-ul > li > a,
.header-transparency-light:not(.header-on-scroll):not(.mobile-menu-open) #nm-right-menu-ul > li > a
{
	color:<?php echo esc_attr( $nm_theme_options['header_transparency_light_navigation_color'] ); ?>;
}
.header-transparency-dark:not(.header-on-scroll):not(.mobile-menu-open) #nm-main-menu-ul > li > a,
.header-transparency-dark:not(.header-on-scroll):not(.mobile-menu-open) #nm-right-menu-ul > li > a
{
	color:<?php echo esc_attr( $nm_theme_options['header_transparency_dark_navigation_color'] ); ?>;
}
.header-transparency-light:not(.header-on-scroll):not(.mobile-menu-open) #nm-main-menu-ul > li > a:hover,
.header-transparency-light:not(.header-on-scroll):not(.mobile-menu-open) #nm-right-menu-ul > li > a:hover
{
	color:<?php echo esc_attr( $nm_theme_options['header_transparency_light_navigation_highlight_color'] ); ?>;
}
.header-transparency-dark:not(.header-on-scroll):not(.mobile-menu-open) #nm-main-menu-ul > li > a:hover,
.header-transparency-dark:not(.header-on-scroll):not(.mobile-menu-open) #nm-right-menu-ul > li > a:hover
{
	color:<?php echo esc_attr( $nm_theme_options['header_transparency_dark_navigation_highlight_color'] ); ?>;
}
.no-touch .header-transparency-light:not(.header-on-scroll):not(.mobile-menu-open) .nm-header:hover
{
    background-color:<?php echo esc_attr( $nm_theme_options['header_transparency_light_hover_background_color'] ); ?>;
}
.no-touch .header-transparency-dark:not(.header-on-scroll):not(.mobile-menu-open) .nm-header:hover
{
    background-color:<?php echo esc_attr( $nm_theme_options['header_transparency_dark_hover_background_color'] ); ?>;
}

/* Menu: Dropdown */
.nm-menu .sub-menu
{
	background:<?php echo esc_attr( $nm_theme_options['dropdown_menu_background_color'] ); ?>;
}
.nm-menu .sub-menu li a
{
	color:<?php echo esc_attr( $nm_theme_options['dropdown_menu_font_color'] ); ?>;
}
.nm-menu .megamenu > .sub-menu > ul > li:not(.nm-menu-item-has-image) > a,
.nm-menu .sub-menu li a .label,
.nm-menu .sub-menu li a:hover
{
	color:<?php echo esc_attr( $nm_theme_options['dropdown_menu_font_highlight_color'] ); ?>;
}

/* Menus: Megamenu - Full width */
.nm-menu .megamenu.full > .sub-menu
{
    padding-top:<?php echo intval( $nm_theme_options['megamenu_full_top_spacing'] ); ?>px;
    padding-bottom:<?php echo intval( $nm_theme_options['megamenu_full_bottom_spacing'] ); ?>px;
    background:<?php echo esc_attr( $nm_theme_options['dropdown_menu_full_background_color'] ); ?>;
}
.nm-menu .megamenu.full > .sub-menu > ul
{
    max-width:<?php echo intval( $nm_theme_options['megamenu_full_max_width'] ); ?>px;
}
.nm-menu .megamenu.full .sub-menu li a
{
	color:<?php echo esc_attr( $nm_theme_options['dropdown_menu_full_font_color'] ); ?>;
}
.nm-menu .megamenu.full > .sub-menu > ul > li:not(.nm-menu-item-has-image) > a,
.nm-menu .megamenu.full .sub-menu li a:hover
{
	color:<?php echo esc_attr( $nm_theme_options['dropdown_menu_full_font_highlight_color'] ); ?>;
}

/* Menus: Megamenu - Thumbnails */
.nm-menu .megamenu > .sub-menu > ul > li.nm-menu-item-has-image
{
    border-right-color:<?php echo esc_attr( $nm_theme_options['dropdown_menu_thumbnails_border_color'] ); ?>;
}

/* Menu icon */
.nm-menu-icon span
{
    background:<?php echo esc_attr( $nm_theme_options['header_navigation_color'] ); ?>;
}
/* Menu icon: Header transparency */
.header-transparency-light:not(.header-on-scroll):not(.mobile-menu-open) .nm-menu-icon span
{
	background:<?php echo esc_attr( $nm_theme_options['header_transparency_light_navigation_color'] ); ?>;
}
.header-transparency-dark:not(.header-on-scroll):not(.mobile-menu-open) .nm-menu-icon span
{
	background:<?php echo esc_attr( $nm_theme_options['header_transparency_dark_navigation_color'] ); ?>;
}

/* Mobile menu
--------------------------------------------------------------- */
#nm-mobile-menu
{   
    background:<?php echo esc_attr( $nm_theme_options['slide_menu_background_color'] ); ?>;
}
#nm-mobile-menu .menu li
{
    border-bottom-color:<?php echo esc_attr( $nm_theme_options['slide_menu_border_color'] ); ?>;
}
#nm-mobile-menu .menu a,
#nm-mobile-menu .menu li .nm-menu-toggle,
#nm-mobile-menu-top-ul .nm-mobile-menu-item-search input,
#nm-mobile-menu-top-ul .nm-mobile-menu-item-search span,
.nm-mobile-menu-social-ul li a
{
    color:<?php echo esc_attr( $nm_theme_options['slide_menu_font_color'] ); ?>;
}
.no-touch #nm-mobile-menu .menu a:hover,
#nm-mobile-menu .menu li.active > a,
#nm-mobile-menu .menu > li.active > .nm-menu-toggle:before,
#nm-mobile-menu .menu a .label,
.nm-mobile-menu-social-ul li a:hover
{
    color:<?php echo esc_attr( $nm_theme_options['slide_menu_font_highlight_color'] ); ?>;
}
#nm-mobile-menu .sub-menu
{
    border-top-color:<?php echo esc_attr( $nm_theme_options['slide_menu_border_color'] ); ?>;
}

/* Footer widgets
--------------------------------------------------------------- */
.nm-footer-widgets
{
    padding-top:<?php echo intval( $nm_theme_options['footer_widgets_spacing_top'] ); ?>px;
    padding-bottom:<?php echo intval( $nm_theme_options['footer_widgets_spacing_bottom'] ); ?>px;
	background-color:<?php echo esc_attr( $nm_theme_options['footer_widgets_background_color'] ); ?>;
}
.nm-footer-widgets,
.nm-footer-widgets .widget ul li a,
.nm-footer-widgets a
{
	color:<?php echo esc_attr( $nm_theme_options['footer_widgets_font_color'] ); ?>;
}
.nm-footer-widgets .widget .nm-widget-title
{
	color:<?php echo esc_attr( $nm_theme_options['footer_widgets_title_font_color'] ); ?>;
}
.nm-footer-widgets .widget ul li a:hover,
.nm-footer-widgets a:hover
{
	color:<?php echo esc_attr( $nm_theme_options['footer_widgets_highlight_font_color'] ); ?>;
}
.nm-footer-widgets .widget_tag_cloud a:hover,
.nm-footer-widgets .widget_product_tag_cloud a:hover
{
	background:<?php echo esc_attr( $nm_theme_options['footer_widgets_highlight_font_color'] ); ?>;
}
@media all and (max-width:991px)
{
    .nm-footer-widgets
    {
        padding-top:<?php echo intval( $nm_theme_options['footer_widgets_spacing_top_alt'] ); ?>px;
        padding-bottom:<?php echo intval( $nm_theme_options['footer_widgets_spacing_bottom_alt'] ); ?>px;
    }
}

/* Footer bar
--------------------------------------------------------------- */
.nm-footer-bar
{
	color:<?php echo esc_attr( $nm_theme_options['footer_bar_font_color'] ); ?>;
}
.nm-footer-bar-inner
{
	padding-top:<?php echo intval( $nm_theme_options['footer_bar_spacing_top'] ); ?>px;
    padding-bottom:<?php echo intval( $nm_theme_options['footer_bar_spacing_bottom'] ); ?>px;
	background-color:<?php echo esc_attr( $nm_theme_options['footer_bar_background_color'] ); ?>;
}
.nm-footer-bar a
{
	color:<?php echo esc_attr( $nm_theme_options['footer_bar_font_color'] ); ?>;
}
.nm-footer-bar a:hover,
.nm-footer-bar-social li i
{
	color:<?php echo esc_attr( $nm_theme_options['footer_bar_highlight_font_color'] ); ?>;
}
.nm-footer-bar .menu > li
{
	border-bottom-color:<?php echo esc_attr( $nm_theme_options['footer_bar_menu_border_color'] ); ?>;
}
@media all and (max-width:991px)
{
    .nm-footer-bar-inner
    {
        padding-top:<?php echo intval( $nm_theme_options['footer_bar_spacing_top_alt'] ); ?>px;
        padding-bottom:<?php echo intval( $nm_theme_options['footer_bar_spacing_bottom_alt'] ); ?>px;
    }
}

/* Blog: Single post
--------------------------------------------------------------- */
.nm-comments
{
	background:<?php echo esc_attr( $nm_theme_options['single_post_comments_background_color'] ); ?>;
}
.nm-comments .commentlist > li,
.nm-comments .commentlist .pingback,
.nm-comments .commentlist .trackback
{
	border-color:<?php echo esc_attr( $nm_theme_options['single_post_comments_dividers_color'] ); ?>;
}
    
/* Shop
--------------------------------------------------------------- */
#nm-shop-products-overlay,
#nm-shop
{
	background-color:<?php echo esc_attr( $nm_theme_options['shop_background_color'] ); ?>;
}
/* Shop - Taxonomy header */
#nm-shop-taxonomy-header.has-image
{
    height:<?php echo intval( $nm_theme_options['shop_taxonomy_header_image_height'] ); ?>px;
}
.nm-shop-taxonomy-text-col
{
    max-width:<?php echo ( strlen( $nm_theme_options['shop_taxonomy_header_text_max_width'] ) > 0 ) ? intval( $nm_theme_options['shop_taxonomy_header_text_max_width'] ) . 'px' : 'none'; ?>;
}
.nm-shop-taxonomy-text h1
{
    color:<?php echo esc_attr( $nm_theme_options['shop_taxonomy_header_heading_color'] ); ?>;
}
.nm-shop-taxonomy-text .term-description
{
    color:<?php echo esc_attr( $nm_theme_options['shop_taxonomy_header_description_color'] ); ?>;
}
@media all and (max-width:991px)
{
    #nm-shop-taxonomy-header.has-image
    {
        height:<?php echo intval( $nm_theme_options['shop_taxonomy_header_image_height_tablet'] ); ?>px;
    }
}
@media all and (max-width:768px)
{
    #nm-shop-taxonomy-header.has-image
    {
        height:<?php echo intval( $nm_theme_options['shop_taxonomy_header_image_height_mobile'] ); ?>px;
    }
}   
/* Shop - Filters: Scrollbar */
.nm-shop-widget-scroll
{
	height:<?php echo intval( $nm_theme_options['shop_filters_height'] ); ?>px;
}
/* Shop - "Sale" flash */
.onsale
{
	color:<?php echo esc_attr( $nm_theme_options['sale_flash_font_color'] ); ?>;
	background:<?php echo esc_attr( $nm_theme_options['sale_flash_background_color'] ); ?>;
}
/* Shop - "Out of stock" flash */
.products li.outofstock .nm-shop-loop-thumbnail > a:after
{
    color:<?php echo esc_attr( $nm_theme_options['outofstock_flash_font_color'] ); ?>;
    background:<?php echo esc_attr( $nm_theme_options['outofstock_flash_background_color'] ); ?>;
}
/* Shop - Products: Thumbnail background color */
.nm-shop-loop-thumbnail
{
	background:<?php echo esc_attr( $nm_theme_options['shop_thumbnail_background_color'] ); ?>;
}

/* Single product
--------------------------------------------------------------- */
.has-bg-color .nm-single-product-bg
{
	background:<?php echo esc_attr( $nm_theme_options['single_product_background_color'] ); ?>;
}
.nm-featured-video-icon
{
	color:<?php echo esc_attr( $nm_theme_options['featured_video_icon_color'] ); ?>;
	background:<?php echo esc_attr( $nm_theme_options['featured_video_background_color'] ); ?>;
}
@media all and (max-width:1080px)
{
    .woocommerce-product-gallery__wrapper
	{
		max-width:<?php echo intval( $nm_theme_options['product_image_max_size'] ); ?>px;
	}
    .has-bg-color .woocommerce-product-gallery {
        background:<?php echo esc_attr( $nm_theme_options['single_product_background_color'] ); ?>;
    }
}
@media all and (max-width:1080px)
{
    .woocommerce-product-gallery.pagination-enabled .flex-control-thumbs
    {
        background-color:<?php echo esc_attr( $nm_theme_options['main_background_color'] ); ?>;
    }
}
/* Single product - Summary: Variation controls - Color */
.nm-variation-control.nm-variation-control-color li i
{
    width:<?php echo intval( $nm_theme_options['product_swatches_color_radius'] ); ?>px;
    height:<?php echo intval( $nm_theme_options['product_swatches_color_radius'] ); ?>px;
}
/* Single product - Summary: Variation controls - Image */
.nm-variation-control.nm-variation-control-image li .nm-pa-image-thumbnail-wrap
{
    width:<?php echo intval( $nm_theme_options['product_swatches_image_radius'] ); ?>px;
    height:<?php echo intval( $nm_theme_options['product_swatches_image_radius'] ); ?>px;
}

<?php if ( $nm_theme_options['page_not_found_show_products'] ) : ?>
/* Page not found
--------------------------------------------------------------- */
.error404 .nm-page-wrap
{
    background-color:<?php echo esc_attr( $nm_theme_options['single_product_background_color'] ); ?>;
}
.nm-page-not-found
{
    background-color:<?php echo esc_attr( $nm_theme_options['main_background_color'] ); ?>;
}
<?php endif; ?>

/* Custom CSS
--------------------------------------------------------------- */
<?php

if ( ! class_exists( 'NM_Custom_Code' ) && isset( $nm_theme_options['custom_css'] ) ) {
    echo $nm_theme_options['custom_css'];
}
do_action( 'nm_custom_styles' ); // Custom styles output via plugin
?>
</style>
<?php
	$styles = ob_get_clean();
	
	// Remove comments
    $styles = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $styles );
	
	// Remove new-lines, tab-indents and spaces (excluding single spaces)
	$styles = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '   ', '    ' ), '', $styles );
	
    // Remove "<style>" tags
    $styles = strip_tags( $styles );
    
    if ( $save_styles ) {
        // Save styles to WP settings db
        update_option( 'nm_theme_custom_styles', $styles, true );
    } else {
        return $styles;
    }
}

endif;

// Redux: Options saved - https://docs.reduxframework.com/core/advanced/actions-hooks/
add_action( 'redux/options/nm_theme_options/saved', 'nm_custom_styles_generate', 10, 2 );
// WP Customizer: Options saved - Added "100" priority to make sure the settings are saved by Redux first
add_action( 'customize_save_after', 'nm_custom_styles_generate', 100, 2 );



/*
 *  Make sure custom theme styles are saved
 */
function nm_custom_styles_install() {
	if ( ! get_option( 'nm_theme_custom_styles' ) && get_option( 'nm_theme_options' ) ) {
		nm_custom_styles_generate();
	}
}
// Redux: When registering the options - https://docs.reduxframework.com/core/advanced/actions-hooks/
add_action( 'redux/options/nm_theme_options/register', 'nm_custom_styles_install' );



/*
 *  WP Upgrader: Save custom styles after updating theme - Note: Untested with Envato Market plugin
 */
function nm_custom_styles_generate_after_theme_update( $upgrader_object, $options ) {
    if ( $options['action'] == 'update' && $options['type'] == 'theme' ) {
        foreach( $options['themes'] as $theme_slug ) {
            if ( $theme_slug == 'savoy' ) {
                nm_custom_styles_generate();
            }
        }
    }
}
add_action( 'upgrader_process_complete', 'nm_custom_styles_generate_after_theme_update', 10, 2 );



/*
 *  v2.4.4 update: Make sure styles are regenerated to prevent menu issues
 */
/*if ( is_admin() ) {
    $v244_styles_updated = get_option( 'nm_theme_v244_styles_updated', false );
    if ( ! $v244_styles_updated ) {
        update_option( 'nm_theme_v244_styles_updated', '1' );
        nm_custom_styles_generate();
    }
}*/



/*
 *  Print custom styles
 */
$include_custom_styles = apply_filters( 'nm_include_custom_styles', true );
if ( $include_custom_styles ) {
    function nm_custom_styles() {
        // Get custom styles
        $styles = ( is_customize_preview() ) ? nm_custom_styles_generate( null, false ) : get_option( 'nm_theme_custom_styles' );

        /* Translation styles - Including these here so they work with language-switchers */
        $translation_styles = '.products li.outofstock .nm-shop-loop-thumbnail > a:after{content:"' . esc_html__( 'Out of stock', 'woocommerce' ) . '";}'; // Shop - "Out of stock" flash
        $translation_styles .= '.nm-validation-inline-notices .form-row.woocommerce-invalid-required-field:after{content:"' . esc_html__( 'Required field.', 'nm-framework' ) . '";}'; // Checkout - Form validation text

        echo '<style type="text/css" class="nm-custom-styles">' . $styles . '</style>' . "\n";
        echo '<style type="text/css" class="nm-translation-styles">' . $translation_styles . '</style>' . "\n";
    }
    $custom_styles_action_priority = apply_filters( 'nm_custom_styles_action_priority', 100 );
    add_action( 'wp_head', 'nm_custom_styles', $custom_styles_action_priority );
}
