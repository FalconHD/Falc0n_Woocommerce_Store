<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Class: Widget - NM_Elementor_Product_Categories  */
class NM_Elementor_Product_Categories extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
        
        // Required scripts
        if ( defined( 'NM_THEME_URI' ) ) {
            // Only include in editor (script is enqueued via Banner Slider shortcode otherwise)
            if ( 
                \Elementor\Plugin::$instance->editor->is_edit_mode() ||
                \Elementor\Plugin::$instance->preview->is_preview_mode()
            ) {
                wp_register_script( 'nm-masonry', NM_THEME_URI . '/assets/js/plugins/masonry.pkgd.min.js', array(), '4.2.2', true ); // Note: Using "nm-" prefix so the included WP version isn't used (it doesn't support the "horizontalOrder" option)
            }
        }
   }
    
	public function get_name() {
		return 'nm-product-categories';
	}

	public function get_title() {
		return __( 'Product Categories', 'nm-framework-admin' );
	}

	public function get_icon() {
		return 'eicon-products';
	}

	public function get_categories() {
        return [ 'savoy-theme' ];
	}
    
    public function get_script_depends() {
		return [ 'nm-elementor-widgets', 'nm-masonry' ];
	}
    
	protected function _register_controls() {
        
        $this->start_controls_section(
			'section_product_categories_settings',
			[
				'label' => __( 'Product Categories', 'nm-framework-admin' ),
			]
		);
        
        $this->add_control(
            'number',
            [
                'label'     => __( 'Categories to Display', 'nm-framework-admin' ),
                'type'      => Controls_Manager::NUMBER,
                'min'       => 1,
                'max'       => 100,
                'step'      => 1,
                'default'   => '',
            ]
        );
        $this->add_control(
			'columns',
			[
				'label'         => __( 'Columns', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => '2',
				'options'       => [
                    '1'	=> '1',
                    '2'	=> '2',
                    '3'	=> '3',
                    '4'	=> '4',
                    '5'	=> '5',
                    '6'	=> '6',
				],
			]
		);
        $this->add_control(
			'orderby',
			[
				'label'         => __( 'Order By', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'name',
				'options'       => [
                    'none'			=> 'None',
                    'id'			=> 'ID',
                    'name'			=> 'Name',
                    'count'         => 'Product Count',
                    'menu_order'    => 'Menu Order',
                    'include'       => '"IDs" Setting',
				],
			]
		);
        $this->add_control(
			'order',
			[
				'label'         => __( 'Order', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'ASC',
				'options'       => [
                    'DESC'  => 'Descending',
                    'ASC'   => 'Ascending',
				],
			]
		);
        $this->add_control(
			'hide_empty',
			[
				'label'     => __( 'Hide Empty Categories', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'before',
                'return_value' => '1',
                'default'   => '',
			]
		);
        $this->add_control(
			'parent',
			[
				'label'     => __( 'Parent Categories Only', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'before',
                'return_value' => '0',
                'default'   => '',
			]
		);
        $this->add_control(
			'category_ids',
			[
				'label'         => __( 'IDs', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
                'separator'     => 'before',
                'description'   => __( 'Filter categories by entering a comma separated list of IDs.', 'nm-framework-admin' ),
				//'default'       => '',
                'label_block'   => true,
			]
		);
        $this->add_control(
			'layout',
			[
				'label'         => __( 'Title Layout', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'default',
				'options'       => [
                    'default'   => 'Default',
                    'separated' => 'Separated',
				],
			]
		);
        $this->add_control(
			'title_tag',
			[
				'label'         => __( 'Title Tag', 'nm-framework-admin' ),
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
			'packery',
			[
				'label'         => __( 'Masonry Grid', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SWITCHER,
				'separator'     => 'before',
                'return_value'  => '1',
                'default'       => '',
			]
		);
        
		$this->end_controls_section();
        
    }

	protected function render() {
        $product_categories = $this->get_settings_for_display();
        
        $settings = array();
        
        // IDs: Using "id/ids" as widget-control ID cause error in Elementor editor (widgets can't be deleted): https://github.com/elementor/elementor/issues/5933
        if ( isset( $product_categories['category_ids'] ) && ! empty( $product_categories['category_ids'] ) ) {
            $settings['ids'] = $product_categories['category_ids'];
        }
        unset( $product_categories['category_ids'] );
        
        foreach( $product_categories as $setting => $value ) {
            if ( substr( $setting, 0, 1 ) === '_' ) { break; } // Break loop if setting name starts with "_" (Elementor adds this to its own settings)
            if ( empty( $value ) && $value !== '0' ) { continue; } // Don't add empty settings, except "0" values
            
            $settings[$setting] = $value;
        }
        
        echo nm_shortcode_product_categories( $settings );
    }

}