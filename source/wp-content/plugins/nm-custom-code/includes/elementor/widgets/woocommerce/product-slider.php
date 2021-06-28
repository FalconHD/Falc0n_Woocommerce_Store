<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Class: Widget - NM_Elementor_Product_Slider  */
class NM_Elementor_Product_Slider extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
   }
    
	public function get_name() {
		return 'nm-product-slider';
	}
    
	public function get_title() {
		return __( 'Product Slider', 'nm-framework-admin' );
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
			'section_product_slider_settings',
			[
				'label' => __( 'Product Slider', 'nm-framework-admin' ),
			]
		);
        
        $this->start_controls_tabs(
			'tabs_product_slider'
		);
        
        $this->start_controls_tab(
			'tab_product_slider',
			[
				'label' => __( 'Products', 'nm-framework-admin' ),
			]
		);
        
        $this->add_control(
			'filter',
			[
				'label'         => __( 'Filter', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'default'       => '0',
				'options'       => [
                    '0'             => __( 'All', 'nm-framework-admin' ),
                    'category'      => __( 'Product Category', 'nm-framework-admin' ),
                    'tag'           => __( 'Product Tag', 'nm-framework-admin' ),
                    'attribute'     => __( 'Product Attribute', 'nm-framework-admin' ),
                    'product_ids'   => __( 'Custom', 'nm-framework-admin' ),
				],
			]
		);
        $this->add_control(
			'category',
			[
				'label'         => __( 'Category Slug', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
                'separator'     => 'before',
                'label_block'   => true,
                'description'   => __( 'Comma-separated list of product Category slugs.', 'nm-framework-admin' ),
                'condition'     => [ 'filter' => 'category' ],
			]
		);
        $this->add_control(
			'tag',
			[
				'label'         => __( 'Tag Slug', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
                'separator'     => 'before',
                'label_block'   => true,
                'description'   => __( 'Comma-separated list of product Tag slugs.', 'nm-framework-admin' ),
                'condition'     => [ 'filter' => 'tag' ],
			]
		);
        $this->add_control(
			'attribute',
			[
				'label'         => __( 'Attribute Slug', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
                'separator'     => 'before',
                'label_block'   => true,
                'description'   => __( 'Enter product Attribute slug.', 'nm-framework-admin' ),
                'condition'     => [ 'filter' => 'attribute' ],
			]
		);
        $this->add_control(
			'product_ids',
			[
				'label'         => __( 'IDs', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
                'separator'     => 'before',
                'label_block'   => true,
                'description'   => __( 'Comma-separated list of Product IDs.', 'nm-framework-admin' ),
                'condition'     => [ 'filter' => 'product_ids' ],
			]
		);
        $this->add_control(
			'type',
			[
				'label'         => __( 'Type', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => '0',
				'options'       => [
					'0'             => __( 'All', 'nm-framework-admin' ),
                    'on_sale'       => __( 'On Sale', 'nm-framework-admin' ),
				    'best_selling'  => __( 'Best Selling', 'nm-framework-admin' ),
					'top_rated'     => __( 'Top Rated', 'nm-framework-admin' ),
				],
			]
		);
        $this->add_control(
            'limit',
            [
                'label'     => __( 'Limit', 'nm-framework-admin' ),
                'type'      => Controls_Manager::NUMBER,
                'separator' => 'before',
                'min'       => 2,
                'max'       => 1000,
                'step'      => 1,
                'default'   => '8',
            ]
        );
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
                    '6'	=> '6',
				],
			]
		);
        // Slider setting
        $this->add_control(
			'columns_mobile',
			[
				'label'         => __( 'Columns - Mobile', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => '1',
				'options'       => [
                    '1'	=> '1',
                    '2'	=> '2',
                    '3'	=> '3',
				],
			]
		);
        $this->add_control(
			'orderby',
			[
				'label'         => __( 'Order by', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'date',
				'options'       => [
                    'date'             => __( 'Date', 'nm-framework-admin' ),
                    'title'            => __( 'Title', 'nm-framework-admin' ),
					'id'               => __( 'ID', 'nm-framework-admin' ),
                    'menu_order'       => __( 'Menu order', 'nm-framework-admin' ),
                    'popularity'       => __( 'Popularity', 'nm-framework-admin' ),
					'rand'             => __( 'Random', 'nm-framework-admin' ),
                    'rating'           => __( 'Rating', 'nm-framework-admin' ),
				],
			]
		);
        $this->add_control(
			'order',
			[
				'label'         => __( 'Order', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'DESC',
				'options'       => [
                    'DESC'  => __( 'Descending', 'nm-framework-admin' ),
					'ASC'   => __( 'Ascending', 'nm-framework-admin' ),
				],
			]
		);
        $this->add_control(
			'visibility',
			[
				'label'         => __( 'Visibility', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'visible',
				'options'       => [
                    'visible'       => __( 'Visible', 'nm-framework-admin' ),
					'catalog'       => __( 'Catalog', 'nm-framework-admin' ),
                    'search'        => __( 'Search', 'nm-framework-admin' ),
                    'hidden'        => __( 'Hidden', 'nm-framework-admin' ),
					'featured'      => __( 'Featured', 'nm-framework-admin' ),
				],
			]
		);
        $this->end_controls_tab();
        
        // Slider settings
        $this->start_controls_tab(
			'tab_product_slider_slider',
			[
				'label' => __( 'Slider', 'nm-framework-admin' ),
			]
		);
        
        $this->add_control(
			'arrows',
			[
				'label'         => __( 'Navigation Arrows', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SWITCHER,
				'separator'     => 'before',
                'return_value'  => '1',
                'default'       => '1',
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
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
		$this->end_controls_section();
        
    }

	protected function render() {
        $products = $this->get_settings_for_display();
        
        $settings = array();
        
        // Filter (category, tag, attribute, ids)
        if ( ! empty( $products['filter'] ) ) {
            if ( isset( $products[$products['filter']] ) && ! empty( $products[$products['filter']] ) ) {
                $param_name = ( $products['filter'] == 'product_ids' ) ? 'ids' : $products['filter']; // Convert "product_ids" since "ids" can't be used (can cause JS error)
                
                $settings[$param_name] = $products[$products['filter']];
            }
        }
        unset( $products['filter'] );
        unset( $products['category'] );
        unset( $products['tag'] );
        unset( $products['attribute'] );
        unset( $products['product_ids'] );
        
        // Type (on sale, best selling, top rated)
        if ( ! empty( $products['type'] ) ) {
            $settings[$products['type']] = true;
        }
        unset( $products['type'] );
        
        foreach( $products as $setting => $value ) {
            if ( substr( $setting, 0, 1 ) === '_' ) { break; } // Break loop if setting name starts with "_" (Elementor adds this to its own settings)
            if ( empty( $value ) ) { continue; } // Don't add empty settings
            
            $settings[$setting] = $value;
        }
        
        // Slider: Page include
        if ( function_exists( 'nm_add_page_include' ) ) {
            nm_add_page_include( 'product-slider' );
        }
        
        // Slider settings
        $columns_escaped = intval( $settings['columns'] );
        $slider_settings = array( 'slides-to-show' => $columns_escaped, 'slides-to-scroll' => $columns_escaped, 'slides-to-show-mobile' => intval( $settings['columns_mobile'] ) );
        if ( isset( $settings['arrows'] ) ) { $slider_settings['arrows'] = 'true'; }
        if ( isset( $settings['autoplay'] ) ) { $slider_settings['autoplay'] = 'true'; $slider_settings['autoplay-speed'] = intval( $settings['autoplay'] ); }
        if ( isset( $settings['infinite'] ) ) { $slider_settings['infinite'] = 'true'; }
        $slider_settings = apply_filters( 'nm_product_slider_settings', $slider_settings ); // Make it possible to change settings via filter-hook
        
        // Slider settings: Create data attributes string
        $slider_settings_data = '';
        foreach( $slider_settings as $setting => $value ) {
            $slider_settings_data .= ' data-' . $setting . '="' . $value . '"';
        }
        
        if ( class_exists( 'WC_Shortcodes' ) ) {
            echo '<div class="nm-product-slider col-' . $columns_escaped . '"' . $slider_settings_data . '>' . WC_Shortcodes::products( $settings ) . '</div>';
        }
    }

}