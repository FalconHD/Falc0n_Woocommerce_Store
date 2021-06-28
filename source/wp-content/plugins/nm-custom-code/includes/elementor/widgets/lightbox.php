<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Class: Widget - NM_Elementor_Lightbox  */
class NM_Elementor_Lightbox extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
   }
    
	public function get_name() {
		return 'nm-lightbox';
	}
    
	public function get_title() {
		return __( 'Lightbox', 'nm-framework-admin' );
	}

	public function get_icon() {
		return 'eicon-lightbox';
	}

	public function get_categories() {
        return [ 'savoy-theme' ];
	}
    
	protected function _register_controls() {
        
        $this->start_controls_section(
			'section_lightbox_settings',
			[
				'label' => __( 'Lightbox', 'nm-framework-admin' ),
			]
		);
        
        $this->add_control(
			'link_type',
			[
				'label'     => __( 'Link Type', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'default'   => 'link',
				'options'   => [
                    'link'	=> 'Link',
                    'btn'   => 'Button',
                    'image' => 'Image',
				],
			]
		);
        // Condition: link_type - link, btn
        $this->add_control(
			'title',
			[
				'label'     => __( 'Title', 'nm-framework-admin' ),
				'type'      => Controls_Manager::TEXT,
                'separator' => 'before',
                'label_block'   => true,
                'condition' => [ 'link_type' => [ 'link', 'btn' ] ],
			]
		);
        // /Condition
        // Condition: link_type - btn
        $this->add_control(
			'button_style',
			[
				'label'     => __( 'Button Style', 'nm-framework-admin' ),
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
                'condition' => [ 'link_type' => 'btn' ],
			]
		);
        $this->add_control(
			'button_align',
			[
				'label'     => __( 'Button Align', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => 'center',
				'options'   => [
                    'left'      => 'Left',
                    'center'    => 'Center',
                    'right'     => 'Right',
				],
                'condition' => [ 'link_type' => 'btn' ],
			]
		);
        $this->add_control(
			'button_size',
			[
				'label'     => __( 'Button Size', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => 'lg',
				'options'   => [
                    'lg'    => 'Large',
                    'md'    => 'Medium',
                    'sm'    => 'Small',
                    'xs'    => 'Extra Small',
				],
                'condition' => [ 'link_type' => 'btn' ],
			]
		);
        $this->add_control(
			'button_color',
			[
				'label'     => __( 'Button Color', 'nm-framework-admin' ),
				'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'default'   => '',
                'selectors'     => [
					'{{WRAPPER}} .nm_btn_border .nm_btn_bg' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .nm_btn_border_rounded .nm_btn_bg' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .nm_btn_filled .nm_btn_bg' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .nm_btn_filled_rounded .nm_btn_bg' => 'background-color: {{VALUE}} !important;',
				],
                'condition' => [ 'link_type' => 'btn' ],
			]
		);
        // /Condition
        // Condition: link_type - image
        $this->add_control(
			'link_image_id', 
			[
				'label'     => __( 'Link Image', 'nm-framework-admin' ),
				'type'      => Controls_Manager::MEDIA,
				'separator' => 'before',
                'condition' => [ 'link_type' => 'image' ],
			]
		);
        // /Condition
        $this->add_control(
			'content_type',
			[
				'label'     => __( 'Lightbox Type', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => 'image',
				'options'   => [
                    'image'     => 'Image',
                    'iframe'    => 'Video',
                    //'inline'    => 'HTML',
				],
			]
		);
        // Condition: content_type - image
        $this->add_control(
			'content_image_id', 
			[
				'label'     => __( 'Lightbox Image', 'nm-framework-admin' ),
				'type'      => Controls_Manager::MEDIA,
				'separator' => 'before',
                'condition' => [ 'content_type' => 'image' ],
			]
		);
        $this->add_control(
			'content_image_caption',
			[
				'label'         => __( 'Lightbox Image Caption', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SWITCHER,
				'separator'     => 'before',
                'return_value'  => '1',
                'default'       => '',
                'condition' => [ 'content_type' => 'image' ],
			]
		);
        // /Condition
        // Condition: content_type - iframe, inline
        /*$this->add_control(
			'content_url',
			[
				'label'     => __( 'Lightbox Source', 'nm-framework-admin' ),
				'type'      => Controls_Manager::TEXT,
                'separator' => 'before',
                'label_block'   => true,
                'description'   => '
                    Insert a Video URL or CSS selector for HTML content:
					<br /><br />
					<strong>YouTube video:</strong> http://www.youtube.com/watch?v=XXXXXXXXXXX
					<br />
					<strong>CSS selector:</strong> #contact-form
                ',
                'condition' => [ 'content_type' => [ 'iframe', 'inline' ] ],
			]
		);*/
        $this->add_control(
			'content_url',
			[
				'label'         => __( 'Lightbox Video', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
                'separator'     => 'before',
                'label_block'   => true,
                'description'   => 'Enter a YouTube or Vimeo video page URL - i.e. http://www.youtube.com/watch?v=XXXXXXXXXXX',
                'condition'     => [ 'content_type' => 'iframe' ],
			]
		);
        // /Condition
        
		$this->end_controls_section();
        
    }

	protected function render() {
        $lightbox = $this->get_settings_for_display();
        
        $settings = array();
        
        // Image ID: Link
        if ( isset( $lightbox['link_image_id'] ) ) {
            if ( isset( $lightbox['link_image_id']['id'] ) && ! empty( $lightbox['link_image_id']['id'] ) ) {
                $settings['link_image_id'] = $lightbox['link_image_id']['id'];
            }
        }
        unset( $lightbox['link_image_id'] );
        
        // Image ID: Content
        if ( isset( $lightbox['content_image_id'] ) ) {
            if ( isset( $lightbox['content_image_id']['id'] ) && ! empty( $lightbox['content_image_id']['id'] ) ) {
                $settings['content_image_id'] = $lightbox['content_image_id']['id'];
            }
        }
        unset( $lightbox['content_image_id'] );
        
        foreach( $lightbox as $setting => $value ) {
            if ( substr( $setting, 0, 1 ) === '_' ) { break; } // Break loop if setting name starts with "_" (Elementor adds this to its own settings)
            if ( empty( $value ) && $value !== '0' ) { continue; } // Don't add empty settings, except "0" values
            
            $settings[$setting] = $value;
        }
        
        echo nm_shortcode_nm_lightbox( $settings );
    }

}