<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.1.0
 NM: Modified */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// NM: Disabling reg-form on Checkout to prevent conflict with password-strength meter 
$show_reg_form = ( ! is_checkout() && 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) ? true : false;

// Is this a popup form? - "$is_popup" is passed to "wc_get_template()" in footer.php
if ( isset( $is_popup ) ) {
	// Redirect popup form to "my account" page
	$popup_redirect_url = esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) );
	$popup_redirect_input = sprintf( '<input type="hidden" class="nm-login-popup-redirect-input" name="redirect" value="%s" />', $popup_redirect_url );
	$popup_form_action_escaped = sprintf( ' action="%s"', $popup_redirect_url );
} else {
	$popup_redirect_input = $popup_form_action_escaped = '';
}

?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<div id="customer_login" class="nm-myaccount-login">
    <div class="nm-myaccount-login-inner">
		
        <div id="nm-login-wrap" class="inline slide-up fade-in">
            <h2><?php esc_html_e( 'Log in', 'woocommerce' ); ?></h2>
    
            <form<?php echo $popup_form_action_escaped; ?> method="post" class="login">
    			
                <?php echo $popup_redirect_input; ?>
                
                <?php do_action( 'woocommerce_login_form_start' ); ?>
    
                <p class="form-row form-row-wide">
                    <label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?> <span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( $_POST['username'] ) : ''; ?>" />
                </p>
                <p class="form-row form-row-wide">
                    <label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                    <input class="input-text" type="password" name="password" id="password" />
                </p>
    
                <?php do_action( 'woocommerce_login_form' ); ?>
                
                <p class="form-row form-group">
                    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme inline">
                        <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
                    </label>
                    
                    <span class="woocommerce-LostPassword lost_password">
                        <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
                    </span>
                </p>
                
                <p class="form-actions">
                    <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>                 
                    <button type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
                    
                    <?php if ( $show_reg_form ) : ?>
                    <div class="nm-login-form-divider"><span><?php esc_html_e( 'Or', 'nm-framework' ); ?></span></div>
                    
                    <a href="#" id="nm-show-register-button" class="button border"><?php esc_html_e( 'Create an account', 'nm-framework' );//esc_html_e( 'Register', 'woocommerce' ); ?></a>
                    <?php endif; ?>
                </p>
                
                <?php do_action( 'woocommerce_login_form_end' ); ?>
    
            </form>
        </div>

        <?php if ( $show_reg_form ) : ?>

        <div id="nm-register-wrap">
            <h2><?php esc_html_e( 'Register', 'woocommerce' ); ?></h2>
    
            <form<?php echo $popup_form_action_escaped; ?> method="post" class="register">
    			
                <?php echo $popup_redirect_input; ?>
                
                <?php do_action( 'woocommerce_register_form_start' ); ?>
    
                <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
    
                    <p class="form-row form-row-wide">
                        <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( $_POST['username'] ) : ''; ?>" />
                    </p>
                
                <?php endif; ?>
    
                <p class="form-row form-row-wide">
                    <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
                    <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( $_POST['email'] ) : ''; ?>" />
                </p>
    
                <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
    
                    <p class="form-row form-row-wide">
                        <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                        <input type="password" class="input-text" name="password" id="reg_password" />
                    </p>
                
                <?php else : ?>
                
				    <p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>
                
                <?php endif; ?>
                
                <?php do_action( 'woocommerce_register_form' ); ?>
                
                <p class="form-actions">
                    <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                    <button type="submit" class="woocommerce-Button button" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
                    
                    <?php if ( $show_reg_form ) : ?>
                    <div class="nm-login-form-divider"><span><?php esc_html_e( 'Or', 'nm-framework' ); ?></span></div>
                    
                    <a href="#" id="nm-show-login-button" class="button border"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></a>
                    <?php endif; ?>
                </p>
                
                <?php do_action( 'woocommerce_register_form_end' ); ?>
    
            </form>
        </div>
    
        <?php endif; ?>

        <?php do_action( 'woocommerce_after_customer_login_form' ); ?>
    
    </div>
</div>
