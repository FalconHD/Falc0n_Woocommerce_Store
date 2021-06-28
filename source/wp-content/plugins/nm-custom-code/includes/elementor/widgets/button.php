<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Class: Widget - NM_Elementor_Button  */
class NM_Elementor_Button extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
   }
    
	public function get_name() {
		return 'nm-button';
	}
    
	public function get_title() {
		return __( 'Button', 'nm-framework-admin' );
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_categories() {
        return [ 'savoy-theme' ];
	}
    
	protected function _register_controls() {
        
        $this->start_controls_section(
			'section_button_settings',
			[
				'label' => __( 'Button', 'nm-framework-admin' ),
			]
		);
        
        $this->add_control(
			'title',
			[
				'label' => __( 'Title', 'nm-framework-admin' ),
				'type'  => Controls_Manager::TEXT,
			]
		);
        $this->add_control(
			'link',
			[
				'label'     => __( 'URL (Link)', 'nm-framework-admin' ),
				'type'      => Controls_Manager::TEXT,
                'separator' => 'before',
			]
		);
        $this->add_control(
			'style',
			[
				'label'     => __( 'Style', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => 'filled',
				'options'   => [
                    'filled'	        => 'Filled',
                    'filled_rounded'    => 'Filled Rounded',
                    'border'	        => 'Border',
                    'border_rounded'	=> 'Border Rounded',
                    'link'	            => 'Link',
				],
			]
		);
        $this->add_control(
			'color',
			[
				'label'     => __( 'Color', 'nm-framework-admin' ),
				'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'default'   => '',
                'selectors'     => [
					'{{WRAPPER}} .nm_btn_border .nm_btn_bg' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .nm_btn_border_rounded .nm_btn_bg' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .nm_btn_filled .nm_btn_bg' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .nm_btn_filled_rounded .nm_btn_bg' => 'background-color: {{VALUE}} !important;',
				],
			]
		);
        $this->add_control(
			'size',
			[
				'label'     => __( 'Size', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => 'lg',
				'options'   => [
                    'lg'    => 'Large',
                    'md'    => 'Medium',
                    'sm'    => 'Small',
                    'xs'    => 'Extra Small',
				],
			]
		);
        $this->add_control(
			'align',
			[
				'label'     => __( 'Align', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => 'left',
				'options'   => [
                    'left'      => 'Left',
                    'center'    => 'Center',
                    'right'     => 'Right',
				],
			]
		);
        
		$this->end_controls_section();
        
    }

	protected function render() {
        $button = $this->get_settings_for_display();
        
        $settings = array();
        
        // Link
        if ( strlen( $button['link'] ) > 0 ) {
            $link = 'url:' . urlencode( $button['link'] ) . '|title:|'; // Encoded for "vc_build_link()" function
            $settings['link'] = $link;
        }
        unset( $button['link'] );
        
        foreach( $button as $setting => $value ) {
            if ( substr( $setting, 0, 1 ) === '_' ) { break; } // Break loop if setting name starts with "_" (Elementor adds this to its own settings)
            if ( empty( $value ) && $value !== '0' ) { continue; } // Don't add empty settings, except "0" values
            
            $settings[$setting] = $value;
        }
        
        echo nm_shortcode_button( $settings );
    }

}