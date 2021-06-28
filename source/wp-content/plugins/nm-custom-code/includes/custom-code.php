<?php

/*
 *	NM: Custom code
 */

class NM_Custom_Code {
	
    /* Init */
	function init() {
        // Include custom styles
        add_action( 'nm_custom_styles', array( $this, 'include_custom_styles' ) );

        // Include custom scripts
        $custom_js_action_priority = apply_filters( 'nm_custom_js_action_priority', 100 );
        add_action( 'wp_enqueue_scripts', array( $this, 'include_custom_scripts' ), $custom_js_action_priority );
    }
    
    
    /* Include custom styles */
    function include_custom_styles() {
        global $nm_theme_options;
        
        if ( $nm_theme_options && isset( $nm_theme_options['custom_css'] ) ) {
            echo $nm_theme_options['custom_css'];
        }
    }
    
    
    /* Include custom scripts */
    function include_custom_scripts() {
        global $nm_theme_options;

        // Custom JavaScript
        if ( $nm_theme_options && isset( $nm_theme_options['custom_js'] ) && ! empty( $nm_theme_options['custom_js'] ) ) {
            $custom_js_deps = apply_filters( 'nm_custom_js_deps', array( 'nm-core' ) );
            // Add with "dummy" handle: https://wordpress.stackexchange.com/a/311279/2807
            wp_register_script( 'nm-custom-js', '', $custom_js_deps, '', true );
            wp_enqueue_script( 'nm-custom-js' );
            wp_add_inline_script( 'nm-custom-js', $nm_theme_options['custom_js'] );
        }
    }
    
    
    /* 
     * Add settings section
     *
     * Note: method called from "../functions.php"
     */
    public static function add_settings_section() {
        if ( class_exists( 'Redux' ) ) {
            $opt_name = 'nm_theme_options';

            Redux::setSection( $opt_name, array(
                'title'		=> __( 'Custom Code', 'nm-framework-admin' ),
                'icon'		=> 'el-icon-lines',
                'fields'	=> array(
                    array(
                        'id'		=> 'custom_css',
                        'type'		=> 'ace_editor',
                        'title'		=> __( 'CSS', 'nm-framework-admin' ),
                        'subtitle'	=> __( "Add custom CSS to the head/top of the site.", 'nm-framework-admin' ),
                        'mode'		=> 'css',
                        'theme'		=> 'chrome',
                        'default'	=> ''
                    ),
                    array(
                        'id'		=> 'custom_js',
                        'type'		=> 'ace_editor',
                        'title'		=> __( 'JavaScript', 'nm-framework-admin' ),
                        'subtitle'	=> __( "Add custom JavaScript to the footer/bottom of the site.", 'nm-framework-admin' ),
                        'mode'		=> 'javascript',
                        'theme'		=> 'chrome',
                        'default'	=> ''
                    )
                )
            ) );
        }
    }
	
}

$NM_Custom_Code = new NM_Custom_Code();
$NM_Custom_Code->init();
