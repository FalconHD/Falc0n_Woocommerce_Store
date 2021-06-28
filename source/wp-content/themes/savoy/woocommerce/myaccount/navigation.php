<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 NM: Modified */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $current_user, $nm_theme_options;

do_action( 'woocommerce_before_account_navigation' );
?>

<nav class="woocommerce-MyAccount-navigation">
    <div class="nm-MyAccount-user">
        <?php if ( $nm_theme_options['myaccount_profile_image'] ) : ?>
        <div class="nm-MyAccount-user-image">
            <?php echo get_avatar( $current_user->user_email, '60' ); ?>
        </div>
        <?php endif; ?>
        
        <div class="nm-MyAccount-user-info">
            <span class="nm-username">
                <?php
                    printf(
                        __( 'Hello %1$s (not %1$s? <a href="%2$s">Log out</a>)', 'woocommerce' ),
                        '<strong>' . esc_html( $current_user->display_name ) . '</strong><span class="hide">',
                        esc_url( wc_logout_url() )
                    );
                    echo '</span></span>';
                ?>
            </span>
            
            <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'customer-logout' ) ); ?>" class="nm-logout-button button border"><?php esc_html_e( 'Logout', 'woocommerce' ); ?></a>
        </div>
    </div>
    
	<ul>
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
