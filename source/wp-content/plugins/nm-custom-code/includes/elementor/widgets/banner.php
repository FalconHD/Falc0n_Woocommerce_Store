<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Class: Widget - NM_Elementor_Banner  */
class NM_Elementor_Banner extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
   }
    
	public function get_name() {
		return 'nm-banner';
	}

	public function get_title() {
		return __( 'Banner', 'nm-framework-admin' );
	}

	public function get_icon() {
		return 'eicon-call-to-action';
	}

	public function get_categories() {
        return [ 'savoy-theme' ];
	}
    
	protected function _register_controls() {
        
        $this->start_controls_section(
			'section_banner_settings',
			[
				'label' => esc_html__( 'Banner', 'nm-framework-admin' ),
			]
		);
        
        $this->start_controls_tabs(
			'tabs_banner'
		);
        
        $this->start_controls_tab(
			'tab_banner_text',
			[
				'label' => __( 'Text', 'nm-framework-admin' ),
			]
		);
        
        $this->add_control(
			'title',
			[
				'label'         => esc_html__( 'Title', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
				'default'       => esc_html__( 'Banner Title' , 'nm-framework-admin' ),
				'label_block'   => true,
			]
		);
        $this->add_control(
			'title_size',
			[
				'label'         => __( 'Title: Size', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'medium',
				'options'       => [
                    'small'         => 'Small',
					'medium'	    => 'Medium',
					'large'		    => 'Large',
                    'xlarge Extra'  => 'Extra Large',
				],
			]
		);
        $this->add_control(
			'title_tag',
			[
				'label'         => __( 'Title: Tag', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'h1',
				'options'       => [
                    'h1'   => 'h1',
					'h2'   => 'h2',
					'h3'   => 'h3',
                    'h4'   => 'h4',
                    'h5'   => 'h5',
                    'h6'   => 'h6',
				],
			]
		);
        $this->add_control(
			'subtitle',
			[
				'label'         => esc_html__( 'Subtitle', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
				'separator'     => 'before',
                'default'       => '',
				'label_block'   => true,
			]
		);
        $this->add_control(
			'subtitle_position',
			[
				'label'         => __( 'Subtitle: Position', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'below',
				'options'       => [
                    'above' => 'Above Title',
					'below' => 'Below Title',
				],
			]
		);
        $this->add_control(
			'subtitle_tag',
			[
				'label'         => __( 'Subtitle: Tag', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'h2',
				'options'       => [
                    'h1'   => 'h1',
					'h2'   => 'h2',
					'h3'   => 'h3',
                    'h4'   => 'h4',
                    'h5'   => 'h5',
                    'h6'   => 'h6',
                    'p'    => 'p',
                    'div'  => 'div',
				],
			]
		);
        $this->add_control(
			'link',
			[
				'label'         => __( 'Link', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
				'separator'     => 'before',
                'default'       => '',
                'label_block'   => true,
			]
		);
        $this->add_control(
			'link_title',
			[
				'label'         => __( 'Link: Title', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
				'separator'     => 'before',
                'default'       => '',
                'label_block'   => true,
			]
		);
        $this->add_control(
			'link_type',
			[
				'label'         => __( 'Link: Layout', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'banner_link',
				'options'       => [
                    'banner_link'   => 'Banner Link',
					'text_link'		=> 'Text Link',
                    'link_btn'      => 'Button',
				],
			]
		);
        $this->add_control(
			'link_source',
			[
				'label'         => __( 'Link: Type', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'custom',
				'options'       => [
                    'custom'    => 'Standard',
					'shop'      => 'AJAX Shop Link',
				],
			]
		);
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
			'tab_banner_layout',
			[
				'label' => __( 'Text Layout', 'nm-framework-admin' ),
			]
		);
        
        $this->add_control(
			'layout',
			[
				'label'         => __( 'Column (inner)', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'default'       => 'full',
				'options'       => [
                    'full'                 => 'Full width',
					'boxed'                => 'Boxed',
					'boxed-full-parent'    => 'Boxed (inside full width container)',
				],
			]
		);
        $this->add_control(
			'text_color_scheme',
			[
				'label'         => __( 'Color Scheme', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'dark',
				'options'       => [
                    'dark'	=> 'Dark',
					'light' => 'Light',
				],
			]
		);
        $this->add_control(
			'text_position',
			[
				'label'         => __( 'Position', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'h_center-v_center',
				'options'       => [
                    'h_center-v_center' => 'Center',
					'h_left-v_top'		=> 'Top Left',
					'h_center-v_top'	=> 'Top Center',
					'h_right-v_top'		=> 'Top Right',
					'h_left-v_center'	=> 'Center Left',
					'h_right-v_center'	=> 'Center Right',
					'h_left-v_bottom'	=> 'Bottom Left',
					'h_center-v_bottom'	=> 'Bottom Center',
					'h_right-v_bottom'	=> 'Bottom Right',
				],
			]
		);
        $this->add_control(
			'text_position_mobile',
			[
				'label'         => __( 'Position - Mobile', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
				'separator'     => 'before',
                //'description'   => __( 'Select text position on tablet & mobile sized screens.', 'nm-framework-admin' ),
                'default'       => '',
				'options'       => [
                    ''     => 'Inside Banner',
					'alt'  => 'Outside Banner',
				],
			]
		);
        $this->add_control(
			'text_alignment',
			[
				'label'         => __( 'Alignment', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'align_left',
				'options'       => [
                    'align_left'   => 'Left',
					'align_center' => 'Center',
					'align_right'  => 'Right',
				],
			]
		);
        $this->add_control(
			'text_width', 
			[
				'label'         => __( 'Width', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
				'separator'     => 'before',
                //'description'   => __( 'Enter a maximum width for the text (numbers only).', 'nm-framework-admin' ),
				'default'       => '',
			]
		);
        $this->add_control(
			'text_width_units',
			[
				'label'         => __( 'Width - Units', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => '%',
				'options'       => [
                    '%'  => 'Percent (%)',
                    'px' => 'Pixels (px)',
				],
			]
		);
        $this->add_control(
			'text_padding', 
			[
				'label'         => __( 'Padding', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
				'separator'     => 'before',
                //'description'   => __( 'Text padding (numbers only).', 'nm-framework-admin' ),
				'default'       => '',
			]
		);
        $this->add_control(
			'text_padding_units',
			[
				'label'         => __( 'Padding - Units', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => '%',
				'options'       => [
                    '%'  => 'Percent (%)',
                    'px' => 'Pixels (px)',
				],
			]
		);
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
			'tab_banner_image',
			[
				'label' => __( 'Image', 'nm-framework-admin' ),
			]
		);
        
        $this->add_control(
			'image_id', 
			[
				'label'         => __( 'Image', 'nm-framework-admin' ),
				'type'          => Controls_Manager::MEDIA,
			]
		);
        $this->add_control(
			'alt_image_id', 
			[
				'label'         => __( 'Image: Mobile', 'nm-framework-admin' ),
				'type'          => Controls_Manager::MEDIA,
				'separator'     => 'before',
                //'description'   => __( 'Display alternative image on Tablet & Mobile sized screens.', 'nm-framework-admin' ),
			]
		);
        $this->add_control(
			'image_type',
			[
				'label'         => __( 'Type', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'fluid',
				'options'       => [
                    'fluid' => 'Standard Image',
					'css'   => 'CSS Background Image',
				],
			]
		);
        $this->add_control(
			'image_viewport_height', 
			[
				'label'         => __( 'Viewport Height', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
				'separator'     => 'before',
                //'description'   => __( 'Image viewport height (1 = 1% of the available browser height - enter numbers only).', 'nm-framework-admin' ),
				'default'       => '',
                'condition' => [ 'image_type' => 'css' ],
			]
		);
        $this->add_control(
			'height', 
			[
				'label'         => __( 'Minimum Height', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
				'separator'     => 'before',
                //'description'   => __( 'Image minimum height (value is in pixels - enter numbers only).', 'nm-framework-admin' ),
				'default'       => '',
                'condition' => [ 'image_type' => 'css' ],
			]
		);
        $this->add_control(
			'image_loading',
			[
				'label'         => __( 'Loading', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'eager',
				'options'       => [
                    'eager' => 'Standard',
					'lazy'  => 'Lazy',
				],
                'condition' => [ 'image_type' => 'fluid' ],
			]
		);
        $this->add_control(
			'background_color',
			[
				'label'         => __( 'Background Color', 'nm-framework-admin' ),
				'type'          => Controls_Manager::COLOR,
                'separator'     => 'before',
                'default'       => '',
				'selectors'     => [
					'{{WRAPPER}} .nm-banner' => 'background-color: {{VALUE}};',
				],
			]
		);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
		$this->end_controls_section();
        
    }

	protected function render() {
        $banner = $this->get_settings_for_display();
        
        $banner_settings = array();

        // Link
        if ( $banner['link_source'] == 'custom' ) {
            $custom_link = 'url:' . urlencode( $banner['link'] ) . '|title:' . rawurlencode( $banner['link_title'] ) . '|'; // Encoded for "vc_build_link()" function
            $banner_settings['custom_link'] = $custom_link;
        } else {
            $banner_settings['shop_link_title'] = $banner['link_title'];
            $banner_settings['shop_link'] = $banner['link'];
        }
        unset( $banner['link'] );
        unset( $banner['link_title'] );
        
        foreach( $banner as $setting => $value ) {
            if ( substr( $setting, 0, 1 ) === '_' ) { break; } // Break loop if setting name starts with "_" (Elementor adds this to its own settings)
            if ( empty( $value ) && $value !== '0' ) { continue; } // Don't add empty settings, except "0" values
            
            // Image IDs
            if ( $setting == 'image_id' || $setting == 'alt_image_id' ) {
                if ( isset( $value['id'] ) && ! empty( $value['id'] ) ) {
                    $value = $value['id'];
                } else {
                    continue;
                }
            }
            
            $banner_settings[$setting] = $value;
        }
        
        echo nm_shortcode_banner( $banner_settings );
    }

}