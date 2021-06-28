<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Class: Widget - NM_Elementor_Social_Profiles  */
class NM_Elementor_Social_Profiles extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
   }
    
	public function get_name() {
		return 'nm-social-profiles';
	}
    
	public function get_title() {
		return __( 'Social Profiles', 'nm-framework-admin' );
	}

	public function get_icon() {
		return 'eicon-social-icons';
	}

	public function get_categories() {
        return [ 'savoy-theme' ];
	}
    
	protected function _register_controls() {
        
        $this->start_controls_section(
			'section_social_profiles_settings',
			[
				'label' => __( 'Social Profiles', 'nm-framework-admin' ),
			]
		);
        
        $this->start_controls_tabs(
			'tabs_social_profiles'
		);
        
        $this->start_controls_tab(
			'tab_social_profiles',
			[
				'label' => __( 'Profiles', 'nm-framework-admin' ),
			]
		);
        
        if ( function_exists( 'nm_get_social_profiles' ) ) {
            global $nm_theme_options;
            
            $social_profiles_meta = nm_get_social_profiles( '', true ); // Args: $wrapper_class, $return_meta
            
            // Loop theme settings to get custom order
            foreach( $nm_theme_options['social_profiles'] as $slug => $theme_setting_url ) {
                $this->add_control(
                    $slug,
                    [
                        'label'         => $social_profiles_meta[$slug]['title'],
                        'type'          => Controls_Manager::TEXT,
                        'label_block'   => true,
                    ]
                );
            }
        }
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
			'tab_social_profiles_layout',
			[
				'label' => __( 'Layout', 'nm-framework-admin' ),
			]
		);
        
        $this->add_control(
			'icon_size',
			[
				'label'     => __( 'Icon Size', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => 'medium',
				'options'   => [
                    'small'	    => 'Small',
                    'medium'    => 'Medium',
                    'large'     => 'Large',
				],
			]
		);
        $this->add_control(
			'alignment',
			[
				'label'     => __( 'Icon Alignment', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => 'center',
				'options'   => [
                    'center'    => 'Center',
                    'left'      => 'Left',
                    'right'     => 'Right',
				],
			]
		);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
		$this->end_controls_section();
        
    }

	protected function render() {
        $social_profiles = $this->get_settings_for_display();
        
        if ( function_exists( 'nm_get_social_profiles' ) ) {
            global $nm_theme_options;
            
            $social_profiles_meta = nm_get_social_profiles( '', true ); // Args: $wrapper_class, $return_meta
            $rel_attribute = apply_filters( 'nm_social_profiles_nofollow_attr', 'rel="nofollow"' );
            $output = '';
            
            // Loop theme settings to get custom order
            foreach( $nm_theme_options['social_profiles'] as $slug => $theme_setting_url ) {
                if ( isset( $social_profiles[$slug] ) && ! empty( $social_profiles[$slug] ) ) {
                    $url = $social_profiles[$slug];
                    
                    if ( $slug == 'email' ) {
                        $url = 'mailto:' . $url;
                    }
                    
                    $output .= '<li><a href="' . esc_url( $url ) . '" target="_blank" title="' . esc_attr( $social_profiles_meta[$slug]['title'] ) . '" class="dark" ' . $rel_attribute . '><i class="nm-font nm-font-' . esc_attr( $social_profiles_meta[$slug]['icon'] ) . '"></i></a></li>';
                }
            }
            
            echo '<ul class="nm-social-profiles icon-size-' . esc_attr( $social_profiles['icon_size'] ) . ' align-' . esc_attr( $social_profiles['alignment'] ) . '">' . $output . '</ul>';
        }
    }

}