<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Class: Widget - NM_Elementor_Team  */
class NM_Elementor_Team extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
   }
    
	public function get_name() {
		return 'nm-team';
	}
    
	public function get_title() {
		return __( 'Team', 'nm-framework-admin' );
	}

	public function get_icon() {
		return 'eicon-person';
	}

	public function get_categories() {
        return [ 'savoy-theme' ];
	}
    
	protected function _register_controls() {
        
        $this->start_controls_section(
			'section_team_settings',
			[
				'label' => __( 'Team', 'nm-framework-admin' ),
			]
		);
        
        $this->add_control(
			'columns',
			[
				'label'     => __( 'Columns', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'default'   => '2',
				'options'   => [
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
				],
			]
		);
        $this->add_control(
            'items',
            [
                'label'     => __( 'Maximum Items', 'nm-framework-admin' ),
                'type'      => Controls_Manager::NUMBER,
                'separator' => 'before',
                'min'       => 1,
                'max'       => 1000,
                'step'      => 1,
                'default'   => '',
            ]
        );
        $this->add_control(
			'image_style',
			[
				'label'     => __( 'Image Style', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => 'default',
				'options'   => [
                    'default' => 'Default',
                    'rounded' => 'Rounded',
				],
			]
		);
        $this->add_control(
			'order_by',
			[
				'label'     => __( 'Order By', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => 'name',
				'options'   => [
                    'none'          => 'None',
                    'ID'            => 'ID',
                    'name'          => 'Name',
                    'date'          => 'Date',
                    'menu_order'    => 'Menu Order',
                    'rand'          => 'Random',
				],
			]
		);
        $this->add_control(
			'order',
			[
				'label'     => __( 'Order', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => 'asc',
				'options'   => [
                    'desc'  => 'Descending',
                    'asc'   => 'Ascending',
				],
			]
		);
        $this->add_control(
			'member_ids',
			[
				'label'         => __( 'Item IDs', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
                'separator'     => 'before',
                'description'   => __( 'Filter members by entering a comma separated list of member/post IDs.', 'nm-framework-admin' ),
			]
		);
        
		$this->end_controls_section();
        
    }

	protected function render() {
        $team = $this->get_settings_for_display();
        
        $settings = array();
        
        // IDs: Using "id/ids" as widget-control ID cause error in Elementor editor (widgets can't be deleted): https://github.com/elementor/elementor/issues/5933
        if ( isset( $team['member_ids'] ) && ! empty( $team['member_ids'] ) ) {
            $settings['ids'] = $team['member_ids'];
        }
        unset( $team['member_ids'] );
        
        foreach( $team as $setting => $value ) {
            if ( substr( $setting, 0, 1 ) === '_' ) { break; } // Break loop if setting name starts with "_" (Elementor adds this to its own settings)
            if ( empty( $value ) && $value !== '0' ) { continue; } // Don't add empty settings, except "0" values
            
            $settings[$setting] = $value;
        }
        
        // Make sure function exists in case required plugin has been deactivated
        if ( function_exists( 'nm_shortcode_team' ) ) {
            echo nm_shortcode_team( $settings );
        } else {
            echo '<p class="nm-elementor-plugin-deactivated-notice">' . __( 'Team Members plugin deactivated', 'nm-framework-admin' ) . '</p>';
        }
    }

}