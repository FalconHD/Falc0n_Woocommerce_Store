<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Class: Widget - NM_Elementor_Post_Slider  */
class NM_Elementor_Post_Slider extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
   }
    
	public function get_name() {
		return 'nm-post-slider';
	}
    
	public function get_title() {
		return __( 'Post Slider', 'nm-framework-admin' );
	}

	public function get_icon() {
		return 'eicon-posts-carousel';
	}

	public function get_categories() {
        return [ 'savoy-theme' ];
	}
    
    public function get_script_depends() {
		return [ 'nm-elementor-widgets' ];
	}
    
	protected function _register_controls() {
        
        $this->start_controls_section(
			'section_post_slider_settings',
			[
				'label' => __( 'Post Slider', 'nm-framework-admin' ),
			]
		);
        
        $this->add_control(
            'num_posts',
            [
                'label'     => __( 'Number of Posts', 'nm-framework-admin' ),
                'type'      => Controls_Manager::NUMBER,
                'min'       => 1,
                'max'       => 1000,
                'step'      => 1,
                'default'   => '8',
            ]
        );
        if ( function_exists( 'nm_get_post_categories' ) ) {
            $post_categories = array_flip( nm_get_post_categories() );
            
            $this->add_control(
                'category',
                [
                    'label'         => __( 'Category', 'nm-framework-admin' ),
                    'type'          => Controls_Manager::SELECT,
                    'options'       => $post_categories,
                    'default'   => '',
                ]
            );
        }
        $this->add_control(
			'columns',
			[
				'label'         => __( 'Columns', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => '4',
				'options'       => [
                    '2'	=> '2',
                    '3'	=> '3',
                    '4'	=> '4',
                    '5'	=> '5',
				],
			]
		);
        $this->add_control(
			'image_type',
			[
				'label'         => __( 'Image: Type', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'fluid',
				'options'       => [
                    'fluid'         => __( 'Fluid', 'nm-framework-admin' ),
                    'background'    => __( 'Background (CSS)', 'nm-framework-admin' ),
				],
			]
		);
        $this->add_control(
			'bg_image_height',
			[
				'label'         => __( 'Image: Height', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
                'separator'     => 'before',
                'condition'     => [ 'image_type' => 'background' ],
			]
		);
        $this->add_control(
			'post_excerpt',
			[
				'label'         => __( 'Post Excerpt', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SWITCHER,
				'separator'     => 'before',
                'return_value'  => '1',
                'default'       => '',
			]
		);
        $this->add_control(
			'arrows',
			[
				'label'         => __( 'Navigation Arrows', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SWITCHER,
				'separator'     => 'before',
                'return_value'  => '1',
                'default'       => '',
			]
		);
        $this->add_control(
            'autoplay',
            [
                'label'         => __( 'Autoplay', 'nm-framework-admin' ),
                'type'          => Controls_Manager::NUMBER,
                'separator'     => 'before',
                'description'   => __( 'Autoplay interval in milliseconds (1 second = 1000 milliseconds).', 'nm-framework-admin' ),
                'min'           => 1,
                'max'           => 100000,
                'step'          => 1,
                'default'       => '',
            ]
        );
        $this->add_control(
			'infinite',
			[
				'label'         => __( 'Infinite Loop', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SWITCHER,
				'separator'     => 'before',
                'return_value'  => '1',
                'default'       => '',
			]
		);
        
		$this->end_controls_section();
        
    }

	protected function render() {
        $post_slider = $this->get_settings_for_display();
        
        $settings = array();
        
        foreach( $post_slider as $setting => $value ) {
            if ( substr( $setting, 0, 1 ) === '_' ) { break; } // Break loop if setting name starts with "_" (Elementor adds this to its own settings)
            if ( empty( $value ) && $value !== '0' ) { continue; } // Don't add empty settings, except "0" values
            
            $settings[$setting] = $value;
        }
        
        echo nm_shortcode_post_slider( $settings );
    }

}