<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Class: Widget - NM_Elementor_Posts  */
class NM_Elementor_Posts extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
   }
    
	public function get_name() {
		return 'nm-posts';
	}
    
	public function get_title() {
		return __( 'Posts', 'nm-framework-admin' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
        return [ 'savoy-theme' ];
	}
    
	protected function _register_controls() {
        
        $this->start_controls_section(
			'section_posts_settings',
			[
				'label' => __( 'Posts', 'nm-framework-admin' ),
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
                'default'   => '4',
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
				],
			]
		);
        $this->add_control(
			'orderby',
			[
				'label'         => __( 'Order By', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'none',
				'options'       => [
                    'none'	        => 'None',
                    'ID'	        => 'ID',
                    'author'	    => 'Author',
                    'title'	        => 'Title',
                    'name'	        => 'Name',
                    'date'	        => 'Date',
                    'rand'	        => 'Random',
                    'comment_count' => 'Commen Count',
                    'menu_order'	=> 'Menu Order',
                    'post__in'	     => 'IDs Option',
				],
			]
		);
        $this->add_control(
			'order',
			[
				'label'         => __( 'Order', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'asc',
				'options'       => [
                    'desc'	        => 'Descending',
                    'asc'	        => 'Ascending',
				],
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
			'post_ids',
			[
				'label'         => __( 'IDs', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
                'separator'     => 'before',
                'description'   => __( 'Filter posts by entering a comma separated list of IDs.', 'nm-framework-admin' ),
			]
		);
        $this->add_control(
			'image_type',
			[
				'label'         => __( 'Image Type', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'standard',
				'options'       => [
                    'standard'	    => 'Standard image',
                    'background'    => 'CSS background image',
				],
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
        
		$this->end_controls_section();
        
    }

	protected function render() {
        $posts = $this->get_settings_for_display();
        
        $settings = array();
        
        // IDs: Using "id/ids" as widget-control ID cause error in Elementor editor (widgets can't be deleted): https://github.com/elementor/elementor/issues/5933
        if ( isset( $posts['post_ids'] ) && ! empty( $posts['post_ids'] ) ) {
            $settings['ids'] = $posts['post_ids'];
        }
        unset( $posts['post_ids'] );
        
        foreach( $posts as $setting => $value ) {
            if ( substr( $setting, 0, 1 ) === '_' ) { break; } // Break loop if setting name starts with "_" (Elementor adds this to its own settings)
            if ( empty( $value ) && $value !== '0' ) { continue; } // Don't add empty settings, except "0" values
            
            $settings[$setting] = $value;
        }
        
        echo nm_shortcode_posts( $settings );
    }

}