<?php
//namespace ElementorWidgets\Includes\ElementorWidgets;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Controls_Manager;

/* Class: Widget - NM_Elementor_Banner_Slider  */
class NM_Elementor_Banner_Slider extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
        
        // Required styles and scripts
        if ( defined( 'NM_THEME_URI' ) ) {
            // Only include in editor (styles/scripts enqueued via Banner Slider shortcode otherwise)
            if ( 
                \Elementor\Plugin::$instance->editor->is_edit_mode() ||
                \Elementor\Plugin::$instance->preview->is_preview_mode()
            ) {
                wp_register_style( 'nm-animate', NM_THEME_URI . '/assets/css/third-party/animate.min.css', array(), '1.0', 'all' );
                
                wp_register_script( 'flickity', NM_THEME_URI . '/assets/js/plugins/flickity.pkgd.min.js', array( 'elementor-frontend' ), '2.2.1', true );
            }
        }
    }
    
	public function get_name() {
		return 'nm-banner-slider';
	}

	public function get_title() {
		return __( 'Banner Slider', 'nm-framework-admin' );
	}

	public function get_icon() {
		return 'eicon-post-slider';
	}

	public function get_categories() {
        return [ 'savoy-theme' ];
	}
    
    public function get_style_depends() {
		return [ 'nm-animate' ];
	}
    
    public function get_script_depends() {
		return [ 'nm-elementor-widgets', 'flickity' ];
	}
    
	protected function _register_controls() {
        
        $this->start_controls_section(
			'section_banners',
			[
				'label' => esc_html__( 'Banners', 'nm-framework-admin' ),
			]
		);
        
		$repeater = new Repeater();
        
        $repeater->start_controls_tabs(
			'tabs_banners'
		);
        
        $repeater->start_controls_tab(
			'tab_banner_text',
			[
				'label' => __( 'Text', 'nm-framework-admin' ),
			]
		);
        
        $repeater->add_control(
			'title',
			[
				'label'         => __( 'Title', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
                'default'       => __( 'Banner Title' , 'nm-framework-admin' ),
			]
		);
        $repeater->add_control(
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
        $repeater->add_control(
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
        $repeater->add_control(
			'subtitle',
			[
				'label'         => esc_html__( 'Subtitle', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
				'separator'     => 'before',
                'default'       => '',
			]
		);
        $repeater->add_control(
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
        $repeater->add_control(
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
        $repeater->add_control(
			'link',
			[
				'label'         => __( 'Link', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
				'label_block'   => true,
				'separator'     => 'before',
                'default'       => '',
			]
		);
        $repeater->add_control(
			'link_title',
			[
				'label'         => __( 'Link: Title', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
				'separator'     => 'before',
                'default'       => '',
			]
		);
        $repeater->add_control(
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
        $repeater->add_control(
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
        
        $repeater->end_controls_tab();
        
        $repeater->start_controls_tab(
			'tab_banner_layout',
			[
				'label' => __( 'Text Layout', 'nm-framework-admin' ),
			]
		);
        
        $repeater->add_control(
			'layout',
			[
				'label'         => __( 'Column (inner)', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'full',
				'options'       => [
                    'full'                 => 'Full width',
					'boxed'                => 'Boxed',
					'boxed-full-parent'    => 'Boxed (inside full width container)',
				],
			]
		);
        $repeater->add_control(
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
        $repeater->add_control(
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
        $repeater->add_control(
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
        $repeater->add_control(
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
        $repeater->add_control(
			'text_width', 
			[
				'label'         => __( 'Width', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
				'separator'     => 'before',
                //'description'   => __( 'Enter a maximum width for the text (numbers only).', 'nm-framework-admin' ),
				'default'       => '',
			]
		);
        $repeater->add_control(
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
        $repeater->add_control(
			'text_padding', 
			[
				'label'         => __( 'Padding', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
				'separator'     => 'before',
                //'description'   => __( 'Text padding (numbers only).', 'nm-framework-admin' ),
				'default'       => '',
			]
		);
        $repeater->add_control(
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
        $repeater->add_control(
			'text_animation',
			[
				'label'         => __( 'Animation', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => '',
				'options'       => [
                    ''		        => '(none)',
					'fadeIn'		=> 'fadeIn',
					'fadeInDown'	=> 'fadeInDown',
					'fadeInLeft'	=> 'fadeInLeft',
					'fadeInRight'	=> 'fadeInRight',
					'fadeInUp'		=> 'fadeInUp',
				],
			]
		);
        
        $repeater->end_controls_tab();
        
        $repeater->start_controls_tab(
			'tab_banner_image',
			[
				'label' => __( 'Image', 'nm-framework-admin' ),
			]
		);
        
        $repeater->add_control(
			'image_id', 
			[
				'label'         => __( 'Image', 'nm-framework-admin' ),
				'type'          => Controls_Manager::MEDIA,
			]
		);
        $repeater->add_control(
			'alt_image_id', 
			[
				'label'         => __( 'Image: Mobile', 'nm-framework-admin' ),
				'type'          => Controls_Manager::MEDIA,
				'separator'     => 'before',
                //'description'   => __( 'Display alternative image on Tablet & Mobile sized screens.', 'nm-framework-admin' ),
			]
		);
        $repeater->add_control(
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
        $repeater->add_control(
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
        $repeater->add_control(
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
        $repeater->add_control(
			'background_color',
			[
				'label'         => __( 'Background Color', 'nm-framework-admin' ),
				'type'          => Controls_Manager::COLOR,
                'separator'     => 'before',
                'default'       => '',
			]
		);
        
        $repeater->end_controls_tab();
        
        $repeater->end_controls_tabs();
        
		$this->add_control(
			'banners',
			[
				'label' => esc_html__( 'Banners', 'nm-framework-admin' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title'   => esc_html__( 'Banner #1', 'nm-framework-admin' ),
					],
					[
						'title'   => esc_html__( 'Banner #2', 'nm-framework-admin' ),
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);
        
		$this->end_controls_section();
        
        $this->start_controls_section(
			'section_banner_slider_settings',
			[
				'label' => esc_html__( 'Banner Slider Settings', 'nm-framework-admin' ),
			]
		);
        
        $this->add_control(
			'slider_plugin',
			[
				'label'         => __( 'Slider Plugin', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'default'       => 'slick',
				'options'       => [
                    'slick'    => 'Slick Slider',
					'flickity' => 'Flickity',
				],
			]
		);
		$this->add_control(
			'adaptive_height',
			[
				'label'     => __( 'Adaptive Height', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SWITCHER,
				//'description'	=> __( 'Enable adaptive height for each slide.', 'nm-framework-admin' ),
				'separator' => 'before',
                'return_value' => '1',
                'default'   => '',
			]
		);
        $this->add_control(
			'arrows',
			[
				'label'     => __( 'Arrows', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'before',
                'return_value' => '1',
                'default'   => '1',
			]
		);
        $this->add_control(
			'pagination',
			[
				'label'     => __( 'Pagination', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'before',
                'return_value' => '1',
                'default'   => '1',
			]
		);
        $this->add_control(
			'pagination_alignment',
			[
				'label'         => __( 'Pagination: Alignment', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'       => 'left',
				'options'       => [
                    'left'     => 'Left',
					'center'   => 'Center',
                    'right'    => 'Right',
				],
                'condition' => [ 'pagination' => '1' ],
			]
		);
        $this->add_control(
			'pagination_position_mobile',
			[
				'label'         => __( 'Pagination: Mobile Position', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'       => 'outside',
				'options'       => [
                    'inside'  => 'Inside slider',
                    'outside' => 'Outside slider',
				],
                'condition' => [ 'pagination' => '1' ],
			]
		);
        $this->add_control(
			'pagination_color',
			[
				'label'         => __( 'Pagination: Color', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'       => 'gray',
				'options'       => [
                    'light'	=> 'Light',
					'gray'	=> 'Gray',
					'dark' 	=> 'Dark',
				],
			]
		);
        $this->add_control(
			'infinite',
			[
				'label'     => __( 'Infinite Loop', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'before',
                'return_value' => '1',
                'default'   => '',
			]
		);
        $this->add_control(
			'animation',
			[
				'label'         => __( 'Animation Type', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'       => 'slide',
				'options'       => [
                    'fade'  => 'Fade',
					'slide' => 'Slide',
				],
                'condition' => [ 'slider_plugin' => 'slick' ],
			]
		);
        $this->add_control(
			'speed', 
			[
				'label'         => __( 'Animation Speed', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
				'description'   => __( 'Animation speed in milliseconds (1 second = 1000 milliseconds).', 'nm-framework-admin' ),
				'separator' => 'before',
                'default'       => '',
                'condition' => [ 'slider_plugin' => 'slick' ],
			]
		);
        $this->add_control(
			'autoplay', 
			[
				'label'         => __( 'Autoplay', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
				'description'   => __( 'Autoplay interval in milliseconds (1 second = 1000 milliseconds).', 'nm-framework-admin' ),
				'separator' => 'before',
                'default'       => '',
			]
		);
        /*$repeater->add_control(
			'background_color',
			[
				'label'         => __( 'Background Color', 'nm-framework-admin' ),
				'type'          => Controls_Manager::COLOR,
                'default'       => '',
				//'selectors'     => [
					//'{{WRAPPER}} .nm-banner-slider' => 'background-color: {{VALUE}};',
				//],
			]
		);*/
        $this->add_control(
			'banner_text_parallax',
			[
				'label'     => __( 'Banner Text: Parallax', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SWITCHER,
				//'description'	__( 'Horizontal "parallax" effect for the banner text.', 'nm-framework-admin' ),
				'separator' => 'before',
                'return_value' => '1',
                'default'   => '',
                'condition' => [ 'slider_plugin' => 'flickity' ],
			]
		);
        
		$this->end_controls_section();
        
    }

	protected function render() {
        $settings = $this->get_settings_for_display();
        
        
        /* Create Banner shortcode(s) */
        $banner_shortcodes = '';
        foreach( $settings['banners'] as $banner ) {
            $shortcode_settings = '';
            
            // Remove "_id" field added by Elementor
            if ( isset( $banner['_id'] ) ) { unset( $banner['_id'] ); }
            
            // Link
            if ( $banner['link_source'] == 'custom' ) {
                $custom_link = 'url:' . urlencode( $banner['link'] ) . '|title:' . rawurlencode( $banner['link_title'] ) . '|'; // Encoded for "vc_build_link()" function
                $shortcode_settings .= ' custom_link="' . $custom_link . '"';
            } else {
                $shortcode_settings .= ' shop_link_title="' . $banner['link_title'] . '" shop_link="' . $banner['link'] . '"';
            }
            unset( $banner['link'] );
            unset( $banner['link_title'] );
            
            foreach( $banner as $setting => $value ) {
                if ( empty( $value ) && $value !== '0' ) { continue; } // Don't add empty settings, except "0" values
                
                // Image IDs
                if ( $setting == 'image_id' || $setting == 'alt_image_id' ) {
                    if ( isset( $value['id'] ) && ! empty( $value['id'] ) ) {
                        $value = $value['id'];
                    } else {
                        continue;
                    }
                }
                
                $shortcode_settings .= ' ' . $setting . '="' . $value . '"';
            }
            $banner_shortcodes .= '[nm_banner' . $shortcode_settings . ']';
        }
        // Remove Banners to avoid adding them to Banner Slider settings
        unset( $settings['banners'] );
        
        
        /* Create Banner Slider settings array */
        //$last_setting_name = 'banner_text_parallax';
        $banner_slider_settings = array();
        foreach( $settings as $setting => $value ) {
            //Less reliable: if ( $setting == $last_setting_name ) { break; } // Brak loop at last -custom- setting
            if ( substr( $setting, 0, 1 ) === '_' ) { break; } // Break loop if setting name starts with "_" (Elementor adds this to its own settings)
            if ( empty( $value ) && $value !== '0' ) { continue; } // Don't add empty settings, except "0" values
            
            $banner_slider_settings[$setting] = $value;
        }
        
        
        echo nm_shortcode_banner_slider( $banner_slider_settings, $banner_shortcodes );
    }

	//protected function _content_template() {}

}