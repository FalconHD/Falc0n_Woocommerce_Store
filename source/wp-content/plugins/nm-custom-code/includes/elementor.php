<?php

/*
 *	NM: Elementor Class
 */
class NM_Elementor {
    
    /*
     * Init
     */
    function init() {
        // Actions
        add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
        add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'register_editor_assets' ) );
        add_action( 'elementor/controls/controls_registered', array( $this, 'register_widget_controls' ) );
        add_action( 'elementor/elements/categories_registered', array( $this, 'add_widget_category' ) );
        add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
        
        // Pro: Register template locations
        add_action( 'elementor/theme/register_locations', array( $this, 'pro_register_locations' ) );
        
        /* WooCommerce: Elementor editor - Register WooCommerce frontend hooks before Editor init
         *
         * Code from the following files in the Elementor Pro plugin:
         * "../elementor-pro/elementor-pro.php" ("plugins_loaded" hook on line 60)
         * "../elementor-pro/plugin.php" (includes modules manager on line 11)
         * "../elementor-pro/core/modules-manager.php" (includes WooCommerce module line 62)
         * "../elementor-pro/modules//woocommerce/module.php" (register WooCommerce frontend hooks line 335)
         */
        add_action( 'plugins_loaded', function() {
            if ( class_exists( 'woocommerce' ) ) {
                if ( ! empty( $_REQUEST['action'] ) && 'elementor' === $_REQUEST['action'] && is_admin() ) {
                    add_action( 'init', function() {
                        wc()->frontend_includes();
                    }, 5 ); // Priority = 5, in order to allow plugins to remove/add their WooCommerce hooks on init
                }
            }
        } );
        
        // WooCommerce: Change related theme settings
        //Alt: add_action( 'init', function() {
        add_action( 'admin_init', function() {
            //Alt: if ( is_admin() ) {
            $this->woocommerce_change_theme_settings();
            //}
        } );
    }
    
    
    /*
     * Register editor assets
     */
    function register_editor_assets() {
        wp_enqueue_style( 'nm-elementor-controls', NM_CE_INC_URI . '/elementor/assets/nm-elementor-controls.css', '1.0' );
        wp_enqueue_script( 'nm-elementor-controls', NM_CE_INC_URI . '/elementor/assets/nm-elementor-controls.js', array(), '1.0' );
    }
    
    
    /*
     * Register assets
     */
    function register_assets() {
        if ( 
            \Elementor\Plugin::$instance->editor->is_edit_mode() ||
            \Elementor\Plugin::$instance->preview->is_preview_mode()
        ) {
            wp_register_script( 'nm-elementor-widgets', NM_CE_INC_URI . '/elementor/assets/nm-elementor-widgets.js', array( 'elementor-frontend' ), '1.0', true );
        }
    }
    
    
    /*
     * Register widget controls
     */
    function register_widget_controls() {
        // Include controls
        include( NM_CE_INC_DIR . '/elementor/controls/icons.php' );

        // Register controls
        \Elementor\Plugin::$instance->controls_manager->register_control( 'nm-icons', new Control_NM_Icons() );
    }
    
    
    /*
     * Add widget category
     */
    function add_widget_category( $elements_manager ) {
        $elements_manager->add_category(
            'savoy-theme',
            [
                'title'  => __( 'Savoy Theme', 'nm-framework-admin' ),
                'icon'   => 'fa fa-plug',
            ]
        );
    }
    
    
    /*
     * Register widgets
     */
    function register_widgets() {
        $widget_manager = \Elementor\Plugin::instance()->widgets_manager;
        
        // Widgets
        $widgets = array(
            'banner'            => 'Banner',
            'banner-slider'     => 'Banner_Slider',
            'button'            => 'Button',
            'feature-box'       => 'Feature',
            'lightbox'          => 'Lightbox',
            'posts'             => 'Posts',
            'post-slider'       => 'Post_Slider',
            'social-profiles'   => 'Social_Profiles',
            'tabs'              => 'Tabs',
            'testimonial'       => 'Testimonial',
        );
        foreach ( $widgets as $filename => $class ) {
            include( NM_CE_INC_DIR . '/elementor/widgets/' . $filename . '.php' );
            $class_name = '\NM_Elementor_' . $class;
            $widget_manager->register_widget_type( new $class_name() );
        }
        
        // WooCommerce widgets
        if ( function_exists( 'nm_woocommerce_activated' ) && nm_woocommerce_activated() ) {
            $woocommerce_widgets = array(
                'add-to-cart'               => 'Add_To_Cart',
                'product-categories'        => 'Product_Categories',
                'products'                  => 'Products',
                'product-reviews'           => 'Product_Reviews',
                'product-reviews-slider'    => 'Product_Reviews_Slider',
                'product-slider'            => 'Product_Slider',
            );
            foreach ( $woocommerce_widgets as $filename => $class ) {
                include( NM_CE_INC_DIR . '/elementor/widgets/woocommerce/' . $filename . '.php' );
                $class_name = '\NM_Elementor_' . $class;
                $widget_manager->register_widget_type( new $class_name() );
            }
        }
        
        // Plugin widgets
        $plugin_widgets = array(
            'contact-form-7'    => array( 'plugin_class' => 'WPCF7', 'widget_class' => 'CF7' ),
            'instagram'         => array( 'plugin_class' => 'NM_Instagram', 'widget_class' => 'Instagram' ),
            'portfolio'         => array( 'plugin_class' => 'NM_Portfolio', 'widget_class' => 'Portfolio' ),
            'team'              => array( 'plugin_class' => 'NM_Post_Types', 'widget_class' => 'Team' ),
        );
        foreach ( $plugin_widgets as $filename => $widget ) {
            // Make sure plugin is activated
            if ( class_exists( $widget['plugin_class'] ) ) {
                include( NM_CE_INC_DIR . '/elementor/widgets/' . $filename . '.php' );
                $class_name = '\NM_Elementor_' . $widget['widget_class'];
                $widget_manager->register_widget_type( new $class_name() );
            }
        }
    }
    
    
    /*
     * Elementor Pro: Register template locations
     */
    function pro_register_locations( $elementor_theme_manager ) {
        $elementor_theme_manager->register_location( 'header' );
        $elementor_theme_manager->register_location( 'footer' );
    }
    
    
    /*
     * WooCommerce: Change theme settings that doesn't work in editor
     */
    public function woocommerce_change_theme_settings() {
        global $nm_theme_options;
        
        if ( $nm_theme_options ) {
            $nm_theme_options['product_image_lazy_loading'] = 0; // Image lazy loading doresn't work in Elementor editor
        }
    }

}

$NM_Elementor = new NM_Elementor();
$NM_Elementor->init();
