<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Class: Widget - NM_Elementor_Instagram  */
class NM_Elementor_Instagram extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
   }
    
	public function get_name() {
		return 'nm-instagram';
	}
    
	public function get_title() {
		return __( 'Instagram Gallery', 'nm-framework-admin' );
	}

	public function get_icon() {
		return 'eicon-instagram-gallery';
	}

	public function get_categories() {
        return [ 'savoy-theme' ];
	}
    
	protected function _register_controls() {
        
        $this->start_controls_section(
			'section_instagram_settings',
			[
				'label' => __( 'Instagram Gallery', 'nm-framework-admin' ),
			]
		);
        
        $this->add_control(
			'username_hashtag',
			[
				'label'         => __( 'Instagram Username', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
                'description'   => __( 'Enter Instagram @username or #hashtag', 'nm-framework-admin' ),
			]
		);
        $this->add_control(
            'image_limit',
            [
                'label'     => __( 'Image Limit', 'nm-framework-admin' ),
                'type'      => Controls_Manager::NUMBER,
                'separator' => 'before',
                'description'   => __( 'Maximum 12 images (Instagram API limit)', 'nm-framework-admin' ),
                'min'       => 1,
                'max'       => 12,
                'step'      => 1,
                'default'   => '12',
            ]
        );
        $this->add_control(
			'images_per_row',
			[
				'label'     => __( 'Images per Row', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => '6',
				'options'   => [
                    '2' => '2',
                    '4' => '4',
                    '6' => '6',
                    '8' => '8',
				],
			]
		);
        $this->add_control(
			'image_aspect_ratio_class',
			[
				'label'     => __( 'Image Aspect Ratio', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => 'aspect-ratio-square',
				'options'   => [
                    'aspect-ratio-square'   => 'Square',
                    'aspect-ratio-original' => 'Original',
				],
			]
		);
        $this->add_control(
			'image_spacing_class',
			[
				'label'         => __( 'Image Spacing', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SWITCHER,
				'separator'     => 'before',
                'return_value'  => 'has-spacing',
                'default'       => '',
			]
		);
        $this->add_control(
			'transient_time',
			[
				'label'     => __( 'Refresh Interval', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => DAY_IN_SECONDS,
				'options'   => [
                    HOUR_IN_SECONDS         => '1 Hour',
                    6 * HOUR_IN_SECONDS     => '6 Hours',
                    12 * HOUR_IN_SECONDS    => '12 Hours',
                    DAY_IN_SECONDS          => '24 Hours',
				],
			]
		);
        $this->add_control(
			'instagram_user_link',
			[
				'label'         => __( 'User Link', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SWITCHER,
				'separator'     => 'before',
                'return_value'  => '1',
                'default'       => '',
			]
		);
        
		$this->end_controls_section();
        
    }

	protected function render() {
        $instagram = $this->get_settings_for_display();
        
        $settings = array();
        
        foreach( $instagram as $setting => $value ) {
            if ( substr( $setting, 0, 1 ) === '_' ) { break; } // Break loop if setting name starts with "_" (Elementor adds this to its own settings)
            if ( empty( $value ) && $value !== '0' ) { continue; } // Don't add empty settings, except "0" values
            
            $settings[$setting] = $value;
        }
        
        // Make sure function exists in case required plugin has been deactivated
        if ( function_exists( 'nm_shortcode_instagram' ) ) {
            echo nm_shortcode_instagram( $settings );
        } else {
            echo '<p class="nm-elementor-plugin-deactivated-notice">' . __( 'Instagram plugin deactivated', 'nm-framework-admin' ) . '</p>';
        }
    }

}