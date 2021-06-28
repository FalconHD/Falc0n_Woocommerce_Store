<?php
/**
 *	NM: Shop - Filters header
 */

defined( 'ABSPATH' ) || exit;

global $nm_theme_options, $nm_globals;

$header_class = '';
$filters_or_search_enabled = false;

// Categories
if ( $nm_theme_options['shop_categories'] ) {
    nm_add_page_include( 'shop_categories' );
	
    $show_categories = true;
    $header_class .= ' has-categories';
} else {
	$show_categories = false;
	$header_class .= ' no-categories';
}

// Filters
if ( $nm_theme_options['shop_filters'] == 'header' ) {
    nm_add_page_include( 'shop_filters' );
    
	$show_filters = true;
    $filters_or_search_enabled = true;
    $header_class .= ' has-filters';
} else {
	$show_filters = false;
	$header_class .= ' no-filters';
}

// Sidebar
if ( $nm_theme_options['shop_filters'] == 'default' ) {
    $show_sidebar = true;
    $header_class .= ' has-sidebar';
} else {
    $show_sidebar = false;
    $header_class .= ' no-sidebar';
}

// Search
if ( $nm_globals['shop_search'] ) {
	$filters_or_search_enabled = true;
    $header_class .= ' has-search';
} else {
    $header_class .= ' no-search';
}

// Header class
if ( $nm_globals['shop_filters_popup'] || ! $filters_or_search_enabled ) {
    $header_class .= ' centered'; // Add "centered" class to center category-menu when filters and search is disabled
}

// Menu class
$menu_class = $nm_theme_options['shop_categories_layout'] . ' ' . $nm_theme_options['shop_categories_thumbnails_layout'];
?>
    <div class="nm-shop-header<?php echo esc_attr( $header_class ); ?>">
        <div class="nm-shop-menu <?php echo esc_attr( $menu_class ); ?>">
            <div class="nm-row">
                <div class="col-xs-12">
                    <div id="nm-shop-filter-menu-wrap">
                        <ul id="nm-shop-filter-menu" class="nm-shop-filter-menu">
                            <?php if ( $show_categories ) : ?>
                            <li class="nm-shop-categories-btn-wrap" data-panel="cat">
                                <a href="#categories" class="invert-color"><?php esc_html_e( 'Categories', 'woocommerce' ); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if ( $show_filters ) : ?>
                            <li class="nm-shop-filter-btn-wrap" data-panel="filter">
                                <a href="#filter" class="invert-color"><?php esc_html_e( 'Filter', 'woocommerce' ); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if ( $show_sidebar ) : ?>
                            <li class="nm-shop-sidebar-btn-wrap" data-panel="sidebar">
                                <a href="#filter" class="invert-color"><span><?php esc_html_e( 'Filter', 'woocommerce' ); ?></span> <i class="nm-font nm-font-menu"></i></a>
                            </li>
                            <?php endif; ?>
                            <?php 
                                if ( $nm_globals['shop_search'] ) :

                                $menu_divider_escaped = apply_filters( 'nm_shop_categories_divider', '<span>&frasl;</span>' );
                            ?>
                            <li class="nm-shop-search-btn-wrap" data-panel="search">
                                <?php echo $menu_divider_escaped; ?>
                                <a href="#search" id="nm-shop-search-btn" class="invert-color"><span><?php esc_html_e( 'Search', 'woocommerce' ); ?></span> <i class="nm-font nm-font-search flip"></i></a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <?php if ( $show_categories ) : ?>
                    <div id="nm-shop-categories-wrap">
                        <?php nm_category_menu(); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <?php if ( $show_filters ) : ?>
        <div id="nm-shop-sidebar" class="nm-shop-sidebar nm-shop-sidebar-header" data-sidebar-layout="header">
            <div class="nm-shop-sidebar-inner">
                <div class="nm-row">
                    <div class="col-xs-12">
                        <ul id="nm-shop-widgets-ul" class="small-block-grid-<?php echo esc_attr( $nm_theme_options['shop_filters_columns'] ); ?>">
                            <?php
                                if ( is_active_sidebar( 'widgets-shop' ) ) {
                                    dynamic_sidebar( 'widgets-shop' );
								}
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div id="nm-shop-sidebar-layout-indicator"></div> <!-- Don't remove (used for testing sidebar/filters layout in JavaScript) -->
        </div>
        <?php endif; ?>
        
        <?php 
			// Search-form
			if ( $nm_globals['shop_search'] ) {
				wc_get_template( 'product-searchform_nm.php' );
			}
		?>
    </div>
