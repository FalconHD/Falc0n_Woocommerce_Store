<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Class: Widget - NM_Elementor_Testimonial  */
class NM_Elementor_Testimonial extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
   }
    
	public function get_name() {
		return 'nm-testimonial';
	}
    
	public function get_title() {
		return __( 'Testimonial', 'nm-framework-admin' );
	}

	public function get_icon() {
		return 'eicon-testimonial';
	}

	public function get_categories() {
        return [ 'savoy-theme' ];
	}
    
	protected function _register_controls() {
        
        $this->start_controls_section(
			'section_testimonial_settings',
			[
				'label' => __( 'Testimonial', 'nm-framework-admin' ),
			]
		);
        
        $this->add_control(
			'image_id', 
			[
				'label'     => __( 'Author Image', 'nm-framework-admin' ),
				'type'      => Controls_Manager::MEDIA,
			]
		);
        $this->add_control(
			'signature',
			[
				'label'     => __( 'Signature', 'nm-framework-admin' ),
				'type'      => Controls_Manager::TEXT,
                'separator' => 'before',
                'label_block'   => true,
                'default'   => 'John Doe',
			]
		);
        $this->add_control(
			'company',
			[
				'label'     => __( 'Company', 'nm-framework-admin' ),
				'type'      => Controls_Manager::TEXT,
                'separator' => 'before',
                'label_block'   => true,
			]
		);
        $this->add_control(
			'content',
			[
				'label'     => __( 'Description', 'nm-framework-admin' ),
				'type'      => Controls_Manager::TEXTAREA,
                'separator' => 'before',
                'rows'      => 5,
                'default'   => __( 'Description text.', 'nm-framework-admin' ),
			]
		);
        
		$this->end_controls_section();
        
    }

	protected function render() {
        $testimonial = $this->get_settings_for_display();
        
        $settings = array();
        
        // Image ID
        if ( isset( $testimonial['image_id'] ) ) {
            if ( isset( $testimonial['image_id']['id'] ) && ! empty( $testimonial['image_id']['id'] ) ) {
                $settings['image_id'] = $testimonial['image_id']['id'];
            }
        }
        unset( $testimonial['image_id'] );
        
        // Content
        $content = $testimonial['content'];
        unset( $testimonial['content'] );
        
        foreach( $testimonial as $setting => $value ) {
            if ( substr( $setting, 0, 1 ) === '_' ) { break; } // Break loop if setting name starts with "_" (Elementor adds this to its own settings)
            if ( empty( $value ) && $value !== '0' ) { continue; } // Don't add empty settings, except "0" values
            
            $settings[$setting] = $value;
        }
        
        echo nm_shortcode_nm_testimonial( $settings, $content );
    }

}