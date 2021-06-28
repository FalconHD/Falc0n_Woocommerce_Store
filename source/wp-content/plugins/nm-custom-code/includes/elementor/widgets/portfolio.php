<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Class: Widget - NM_Elementor_Portfolio  */
class NM_Elementor_Portfolio extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
        
        // Required scripts
        if ( defined( 'NM_PORTFOLIO_URI' ) ) {
            // Only include in editor (scripts are enqueued via Portfolio shortcode and template otherwise)
            if ( 
                \Elementor\Plugin::$instance->editor->is_edit_mode() ||
                \Elementor\Plugin::$instance->preview->is_preview_mode()
            ) {
                wp_register_script( 'nm-portfolio', NM_PORTFOLIO_URI . 'assets/js/nm-portfolio.min.js', array( 'jquery' ), NM_PORTFOLIO_VERSION );
                wp_register_script( 'packery', NM_PORTFOLIO_URI . 'assets/js/packery.pkgd.min.js', array(), '1.3.2', true );
            }
        }
   }
    
	public function get_name() {
		return 'nm-portfolio';
	}
    
	public function get_title() {
		return __( 'Portfolio', 'nm-framework-admin' );
	}

	public function get_icon() {
		return 'eicon-gallery-masonry';
	}

	public function get_categories() {
        return [ 'savoy-theme' ];
	}
    
    public function get_script_depends() {
        return [ 'nm-elementor-widgets', 'nm-portfolio', 'packery' ];
	}
    
	protected function _register_controls() {
        
        $this->start_controls_section(
			'section_portfolio_settings',
			[
				'label' => __( 'Portfolio', 'nm-framework-admin' ),
			]
		);
        
        $this->add_control(
			'categories',
			[
				'label'         => __( 'Categories', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SWITCHER,
				'separator'     => 'before',
                'return_value'  => '1',
                'default'       => '',
			]
		);
        $this->add_control(
			'categories_alignment',
			[
				'label'     => __( 'Categories: Alignment', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => 'left',
				'options'   => [
                    'left'	    => 'Left',
                    'center'    => 'Center',
                    'right'	    => 'Right',
				],
                'condition' => [ 'categories' => '1' ],
			]
		);
        $this->add_control(
			'categories_js',
			[
				'label'         => __( 'Categories: Animated Sorting', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SWITCHER,
				'separator'     => 'before',
                'return_value'  => '1',
                'default'       => '',
                'condition'     => [ 'categories' => '1' ],
			]
		);
        $this->add_control(
			'layout',
			[
				'label'     => __( 'Layout', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => 'standard',
				'options'   => [
                    'standard'  => 'Standard',
                    'overlay'    => 'Overlay',
				],
			]
		);
        $this->add_control(
			'packery',
			[
				'label'         => __( 'Masonry Grid', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SWITCHER,
				'separator'     => 'before',
                'return_value'  => '1',
                'default'       => '',
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
			'columns',
			[
				'label'     => __( 'Items per Row', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => '2',
				'options'   => [
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
				],
			]
		);
        $this->add_control(
			'category',
			[
				'label'         => __( 'Category (optional)', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
                'separator'     => 'before',
                'description'   => __( 'Enter slug-name for portfolio category to display.', 'nm-framework-admin' ),
			]
		);
        $this->add_control(
			'item_ids',
			[
				'label'         => __( 'Item IDs (optional)', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
                'separator'     => 'before',
                'description'   => __( 'Enter comma separated IDs of portfolio items to display.', 'nm-framework-admin' ),
			]
		);
        $this->add_control(
			'order_by',
			[
				'label'     => __( 'Order By', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => 'date',
				'options'   => [
                    'date'  => 'Date',
                    'title' => 'Title',
                    'rand'  => 'Random',
				],
			]
		);
        $this->add_control(
			'order',
			[
				'label'     => __( 'Order', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => 'desc',
				'options'   => [
                    'desc'  => 'Descending',
                    'asc'   => 'Ascending',
				],
			]
		);
        
		$this->end_controls_section();
        
    }

	protected function render() {
        $portfolio = $this->get_settings_for_display();
        
        $settings = array();
        
        // IDs: Using "id/ids" as widget-control ID cause error in Elementor editor (widgets can't be deleted): https://github.com/elementor/elementor/issues/5933
        if ( isset( $portfolio['item_ids'] ) && ! empty( $portfolio['item_ids'] ) ) {
            $settings['ids'] = $portfolio['item_ids'];
        }
        unset( $portfolio['item_ids'] );
        
        foreach( $portfolio as $setting => $value ) {
            if ( substr( $setting, 0, 1 ) === '_' ) { break; } // Break loop if setting name starts with "_" (Elementor adds this to its own settings)
            if ( empty( $value ) && $value !== '0' ) { continue; } // Don't add empty settings, except "0" values
            
            $settings[$setting] = $value;
        }
        
        // Make sure function exists in case required plugin has been deactivated
        if ( function_exists( 'nm_shortcode_portfolio' ) ) {
            echo nm_shortcode_portfolio( $settings );
        } else {
            echo '<p class="nm-elementor-plugin-deactivated-notice">' . __( 'Portfolio plugin deactivated', 'nm-framework-admin' ) . '</p>';
        }
    }

}