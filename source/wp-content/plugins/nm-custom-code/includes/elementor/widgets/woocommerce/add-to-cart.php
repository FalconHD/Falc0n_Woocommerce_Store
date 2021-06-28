<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Class: Widget - NM_Elementor_Add_To_Cart  */
class NM_Elementor_Add_To_Cart extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
   }
    
	public function get_name() {
		return 'nm-add-to-cart';
	}
    
	public function get_title() {
		return __( 'Add to Cart', 'nm-framework-admin' );
	}

	public function get_icon() {
		return 'eicon-product-add-to-cart';
	}

	public function get_categories() {
        return [ 'savoy-theme' ];
	}
    
	protected function _register_controls() {
        
        $this->start_controls_section(
			'section_add_to_cart_settings',
			[
				'label' => __( 'Add to Cart', 'nm-framework-admin' ),
			]
		);
        
        $this->add_control(
			'product_id',
			[
				'label'     => __( 'Product ID', 'nm-framework-admin' ),
				'type'      => Controls_Manager::TEXT,
                'separator' => 'before',
			]
		);
        $this->add_control(
			'show_price',
			[
				'label'         => __( 'Show Price', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SWITCHER,
				'separator'     => 'before',
                'return_value'  => '1',
                'default'       => '',
			]
		);
        $this->add_control(
            'quantity',
            [
                'label'         => __( 'Quantity', 'nm-framework-admin' ),
                'type'          => Controls_Manager::NUMBER,
                'separator'     => 'before',
                'min'           => 1,
                'max'           => 100000,
                'step'          => 1,
                'default'       => '1',
            ]
        );
        
		$this->end_controls_section();
        
    }

	protected function render() {
        $add_to_cart = $this->get_settings_for_display();
        
        $settings = array();
        
        // IDs: Using "id/ids" as widget-control ID cause error in Elementor editor (widgets can't be deleted): https://github.com/elementor/elementor/issues/5933
        if ( ! empty( $add_to_cart['product_id'] ) ) {
            $settings['id'] = $add_to_cart['product_id'];
        }
        unset( $add_to_cart['product_id'] );
        
        // Price
        $settings['show_price'] = ( ! empty( $add_to_cart['show_price'] ) ) ? true : false;
        unset( $add_to_cart['show_price'] );
        
        foreach( $add_to_cart as $setting => $value ) {
            if ( substr( $setting, 0, 1 ) === '_' ) { break; } // Break loop if setting name starts with "_" (Elementor adds this to its own settings)
            if ( empty( $value ) && $value !== '0' ) { continue; } // Don't add empty settings, except "0" values
            
            $settings[$setting] = $value;
        }
        
        // Style (return empty string to remove default styles)
        $settings['style'] = '';
        
        if ( class_exists( 'WC_Shortcodes' ) ) {
            echo WC_Shortcodes::product_add_to_cart( $settings );
        }
    }

}