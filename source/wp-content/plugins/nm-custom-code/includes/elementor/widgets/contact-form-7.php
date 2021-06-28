<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Class: Widget - NM_Elementor_CF7  */
class NM_Elementor_CF7 extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
   }
    
	public function get_name() {
		return 'nm-cf7';
	}
    
	public function get_title() {
		return __( 'Contact Form 7', 'nm-framework-admin' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_categories() {
        return [ 'savoy-theme' ];
	}
    
	protected function _register_controls() {
        
        $this->start_controls_section(
			'section_cf7_settings',
			[
				'label' => __( 'Contact Form 7', 'nm-framework-admin' ),
			]
		);
        
        // Get Contact Form 7 forms
        $cf7_forms = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );
		$forms = array();
		if ( $cf7_forms ) {
			foreach ( $cf7_forms as $form ) {
				$forms[$form->ID] = $form->post_title;
            }
            
            // Set default form
            $form_first     = reset( $forms );
            $form_default   = key( $forms );
		} else {
			$forms['0'] = __( 'No contact forms found', 'nm-framework-admin' );
            $form_default = '0';
		}
        
        $this->add_control(
			'form_id',
			[
				'label'         => __( 'Form', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'description'   => __( 'Select a previously created contact-form from the list.', 'nm-framework-admin' ),
                'default'       => $form_default,
				'options'       => $forms,
			]
		);
        
		$this->end_controls_section();
        
    }

	protected function render() {
        $cf7 = $this->get_settings_for_display();
        
        if ( isset( $cf7['form_id'] ) && ! empty( $cf7['form_id'] ) ) {
            // NOTE: Using "id" as the widget control-id causes JS error in Elementor editor: https://github.com/elementor/elementor/issues/5933
            $settings = array( 'id' => $cf7['form_id'] );
        
            echo nm_shortcode_contact_form_7( $settings );
        }
    }

}