<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Class: Widget - NM_Elementor_Product_Reviews  */
class NM_Elementor_Product_Reviews extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
   }
    
	public function get_name() {
		return 'nm-product-reviews';
	}
    
	public function get_title() {
		return __( 'Product Reviews', 'nm-framework-admin' );
	}

	public function get_icon() {
		return 'eicon-review';
	}

	public function get_categories() {
        return [ 'savoy-theme' ];
	}
    
	protected function _register_controls() {
        
        $this->start_controls_section(
			'section_product_reviews_settings',
			[
				'label' => __( 'Product Reviews', 'nm-framework-admin' ),
			]
		);
        
        $this->add_control(
			'product_id',
			[
				'label'         => __( 'Product ID (optional)', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
                'description'   => __( 'Enter an ID to display reviews from a single product.', 'nm-framework-admin' ),
				//'default'       => '',
                'label_block'   => true,
			]
		);
        $this->add_control(
            'number',
            [
                'label'     => __( 'Limit', 'nm-framework-admin' ),
                'type'      => Controls_Manager::NUMBER,
                'separator' => 'before',
                'min'       => 1,
                'max'       => 1000,
                'step'      => 1,
                'default'   => '8',
            ]
        );
        $this->add_control(
			'layout',
			[
				'label'         => __( 'Layout', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'default',
				'options'       => [
					'default'   => 'Default',
                    'centered'  => 'Centered'
				],
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
				'label'         => __( 'Order by', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'comment_date_gmt',
				'options'       => [
                    'comment_author'    => 'Review Author',
                    'comment_date'      => 'Review Date',
                    'comment_date_gmt'  => 'Review Date GMT',
                    'comment_ID'        => 'Review ID',
                    'comment_post_ID'   => 'Product ID',
                    'user_id'           => 'User ID',
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
			'thumbnail',
			[
				'label'         => __( 'Product Thumbnail', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SWITCHER,
				'separator'     => 'before',
                'return_value'  => '1',
                'default'       => '',
			]
		);
        $this->add_control(
			'title',
			[
				'label'         => __( 'Hide Product Title/Link', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SWITCHER,
				'separator'     => 'before',
                'return_value'  => '0',
                'default'       => '1',
			]
		);
        $this->add_control(
			'total',
			[
				'label'         => __( 'Total Reviews Score', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SWITCHER,
				'separator'     => 'before',
                'return_value'  => '1',
                'default'       => '',
			]
		);
        
		$this->end_controls_section();
        
    }

	protected function render() {
        $reviews = $this->get_settings_for_display();
        
        $settings = array();
        
        foreach( $reviews as $setting => $value ) {
            if ( substr( $setting, 0, 1 ) === '_' ) { break; } // Break loop if setting name starts with "_" (Elementor adds this to its own settings)
            if ( empty( $value ) && $value !== '0' ) { continue; } // Don't add empty settings, except "0" values
            
            $settings[$setting] = $value;
        }
        
        echo nm_shortcode_product_reviews( $settings );
    }

}