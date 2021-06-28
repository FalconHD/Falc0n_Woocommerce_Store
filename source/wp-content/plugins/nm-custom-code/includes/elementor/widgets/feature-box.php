<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Class: Widget - NM_Elementor_Feature  */
class NM_Elementor_Feature extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
        
        // Required styles
        if ( defined( 'NM_THEME_URI' ) ) {
            // Only include in editor (stylesheets are enqueued via Feature Box shortcode otherwise)
            if ( 
                \Elementor\Plugin::$instance->editor->is_edit_mode() ||
                \Elementor\Plugin::$instance->preview->is_preview_mode()
            ) {
                wp_register_style( 'pe-icons-filled', NM_THEME_URI . '/assets/css/font-icons/pe-icon-7-filled/css/pe-icon-7-filled.css' );
                wp_register_style( 'pe-icons-stroke', NM_THEME_URI . '/assets/css/font-icons/pe-icon-7-stroke/css/pe-icon-7-stroke.css' );
                
                // Enqueue here so stylesheets are included for the Elementor editor as well
                wp_enqueue_style( 'pe-icons-filled' );
                wp_enqueue_style( 'pe-icons-stroke' );
            }
        }
   }
    
	public function get_name() {
		return 'nm-feature';
	}
    
	public function get_title() {
		return __( 'Feature Box', 'nm-framework-admin' );
	}

	public function get_icon() {
		return 'eicon-icon-box';
	}

	public function get_categories() {
        return [ 'savoy-theme' ];
	}
    
    public function get_style_depends() {
		return [ 'pe-icons-filled', 'pe-icons-stroke' ];
	}
    
	protected function _register_controls() {
        
        $this->start_controls_section(
			'section_feature_settings',
			[
				'label' => __( 'Feature Box', 'nm-framework-admin' ),
			]
		);
        
        $this->start_controls_tabs(
			'tabs_feature'
		);
        
        $this->start_controls_tab(
			'tab_feature_text',
			[
				'label' => __( 'Text', 'nm-framework-admin' ),
			]
		);
        
        $this->add_control(
			'title',
			[
				'label' => __( 'Title', 'nm-framework-admin' ),
				'type'  => Controls_Manager::TEXT,
                'label_block'   => true,
                'default'       => __( 'Hello World', 'nm-framework-admin' ),
			]
		);
        $this->add_control(
			'subtitle',
			[
				'label'     => __( 'Sub-title', 'nm-framework-admin' ),
				'type'      => Controls_Manager::TEXT,
                'separator' => 'before',
                'label_block'   => true,
                'default'       => __( 'Subtitle', 'nm-framework-admin' ),
			]
		);
        $this->add_control(
			'content',
			[
				'label'     => __( 'Description', 'nm-framework-admin' ),
				'type'      => Controls_Manager::TEXTAREA,
                'separator' => 'before',
                'rows'      => 5,
                'default'       => __( 'Description text.', 'nm-framework-admin' ),
			]
		);
        $this->add_control(
			'link',
			[
				'label'         => __( 'Link', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
				'separator'     => 'before',
                'label_block'   => true,
                'default'       => '',
			]
		);
        $this->add_control(
			'link_title',
			[
				'label'         => __( 'Link Title', 'nm-framework-admin' ),
				'type'          => Controls_Manager::TEXT,
				'separator'     => 'before',
                'label_block'   => true,
                'default'       => '',
			]
		);
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
			'tab_feature_icon',
			[
				'label' => __( 'Icon', 'nm-framework-admin' ),
			]
		);
        
        $this->add_control(
			'icon_type',
			[
				'label'         => __( 'Icon Type', 'nm-framework-admin' ),
				'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'default'       => 'icon',
				'options'       => [
                    'icon'      => 'Icon',
                    'image_id'  => 'Image',
				],
			]
		);
        $this->add_control(
			'icon',
			[
				'label'         => __( 'Icon', 'nm-framework-admin' ),
                'type'          => 'nm-icons',
				'separator'     => 'before',
                'label_block'   => true,
                'options'       => [
                    'pe-7s-close' => [
                        'title' => 'Close',
                        'icon' => 'pe-7s-close',
                    ],
                    'pe-7s-close-circle' => [
                        'title' => 'Close Circle',
                        'icon' => 'pe-7s-close-circle',
                    ],
                    'pe-7s-angle-up' => [
                        'title' => 'Angle Up',
                        'icon' => 'pe-7s-angle-up',
                    ],
                    'pe-7s-angle-up-circle' => [
                        'title' => 'Angle Up Circle',
                        'icon' => 'pe-7s-angle-up-circle',
                    ],
                    'pe-7s-angle-right' => [
                        'title' => 'Angle Right',
                        'icon' => 'pe-7s-angle-right',
                    ],
                    'pe-7s-angle-right-circle' => [
                        'title' => 'Angle Right Circle',
                        'icon' => 'pe-7s-angle-right-circle',
                    ],
                    'pe-7s-angle-left' => [
                        'title' => 'Angle Left',
                        'icon' => 'pe-7s-angle-left',
                    ],
                    'pe-7s-angle-left-circle' => [
                        'title' => 'Angle Left Circle',
                        'icon' => 'pe-7s-angle-left-circle',
                    ],
                    'pe-7s-angle-down' => [
                        'title' => 'Angle Down',
                        'icon' => 'pe-7s-angle-down',
                    ],
                    'pe-7s-angle-down-circle' => [
                        'title' => 'Angle Down Circle',
                        'icon' => 'pe-7s-angle-down-circle',
                    ],
                    'pe-7s-wallet' => [
                        'title' => 'Wallet',
                        'icon' => 'pe-7s-wallet',
                    ],
                    'pe-7s-volume2' => [
                        'title' => 'Volume2',
                        'icon' => 'pe-7s-volume2',
                    ],
                    'pe-7s-volume1' => [
                        'title' => 'Volume1',
                        'icon' => 'pe-7s-volume1',
                    ],
                    'pe-7s-voicemail' => [
                        'title' => 'Close',
                        'icon' => 'pe-7s-voicemail',
                    ],
                    'pe-7s-video' => [
                        'title' => 'Video',
                        'icon' => 'pe-7s-video',
                    ],
                    'pe-7s-user' => [
                        'title' => 'User',
                        'icon' => 'pe-7s-user',
                    ],
                    'pe-7s-upload' => [
                        'title' => 'Upload',
                        'icon' => 'pe-7s-upload',
                    ],
                    'pe-7s-unlock' => [
                        'title' => 'Unlock',
                        'icon' => 'pe-7s-unlock',
                    ],
                    'pe-7s-umbrella' => [
                        'title' => 'Umbrella',
                        'icon' => 'pe-7s-umbrella',
                    ],
                    'pe-7s-trash' => [
                        'title' => 'Trash',
                        'icon' => 'pe-7s-trash',
                    ],
                    'pe-7s-tools' => [
                        'title' => 'Tools',
                        'icon' => 'pe-7s-tools',
                    ],
                    'pe-7s-timer' => [
                        'title' => 'Timer',
                        'icon' => 'pe-7s-timer',
                    ],
                    'pe-7s-ticket' => [
                        'title' => 'Ticket',
                        'icon' => 'pe-7s-ticket',
                    ],
                    'pe-7s-target' => [
                        'title' => 'Target',
                        'icon' => 'pe-7s-target',
                    ],
                    'pe-7s-sun' => [
                        'title' => 'Sun',
                        'icon' => 'pe-7s-sun',
                    ],
                    'pe-7s-study' => [
                        'title' => 'Study',
                        'icon' => 'pe-7s-study',
                    ],
                    'pe-7s-stopwatch' => [
                        'title' => 'Stopwatch',
                        'icon' => 'pe-7s-stopwatch',
                    ],
                    'pe-7s-star' => [
                        'title' => 'Star',
                        'icon' => 'pe-7s-star',
                    ],
                    'pe-7s-speaker' => [
                        'title' => 'Speaker',
                        'icon' => 'pe-7s-speaker',
                    ],
                    'pe-7s-signal' => [
                        'title' => 'Signal',
                        'icon' => 'pe-7s-signal',
                    ],
                    'pe-7s-shuffle' => [
                        'title' => 'Shuffle',
                        'icon' => 'pe-7s-shuffle',
                    ],
                    'pe-7s-shopbag' => [
                        'title' => 'Shopbag',
                        'icon' => 'pe-7s-shopbag',
                    ],
                    'pe-7s-share' => [
                        'title' => 'Share',
                        'icon' => 'pe-7s-share',
                    ],
                    'pe-7s-server' => [
                        'title' => 'Server',
                        'icon' => 'pe-7s-server',
                    ],
                    'pe-7s-search' => [
                        'title' => 'Search',
                        'icon' => 'pe-7s-search',
                    ],
                    'pe-7s-science' => [
                        'title' => 'Science',
                        'icon' => 'pe-7s-science',
                    ],
                    'pe-7s-ribbon' => [
                        'title' => 'Ribbon',
                        'icon' => 'pe-7s-ribbon',
                    ],
                    'pe-7s-repeat' => [
                        'title' => 'Repeat',
                        'icon' => 'pe-7s-repeat',
                    ],
                    'pe-7s-refresh' => [
                        'title' => 'Refresh',
                        'icon' => 'pe-7s-refresh',
                    ],
                    'pe-7s-refresh-cloud' => [
                        'title' => 'Refresh Cloud',
                        'icon' => 'pe-7s-refresh-cloud',
                    ],
                    'pe-7s-radio' => [
                        'title' => 'Radio',
                        'icon' => 'pe-7s-radio',
                    ],
                    'pe-7s-print' => [
                        'title' => 'Print',
                        'icon' => 'pe-7s-print',
                    ],
                    'pe-7s-prev' => [
                        'title' => 'Prev',
                        'icon' => 'pe-7s-prev',
                    ],
                    'pe-7s-power' => [
                        'title' => 'Power',
                        'icon' => 'pe-7s-power',
                    ],
                    'pe-7s-portfolio' => [
                        'title' => 'Portfolio',
                        'icon' => 'pe-7s-portfolio',
                    ],
                    'pe-7s-plus' => [
                        'title' => 'Plus',
                        'icon' => 'pe-7s-plus',
                    ],
                    'pe-7s-play' => [
                        'title' => 'Play',
                        'icon' => 'pe-7s-play',
                    ],
                    'pe-7s-plane' => [
                        'title' => 'Plane',
                        'icon' => 'pe-7s-plane',
                    ],
                    'pe-7s-photo-gallery' => [
                        'title' => 'Photo Gallery',
                        'icon' => 'pe-7s-photo-gallery',
                    ],
                    'pe-7s-phone' => [
                        'title' => 'Phone',
                        'icon' => 'pe-7s-phone',
                    ],
                    'pe-7s-pen' => [
                        'title' => 'Pen',
                        'icon' => 'pe-7s-pen',
                    ],
                    'pe-7s-paper-plane' => [
                        'title' => 'Paper Plane',
                        'icon' => 'pe-7s-paper-plane',
                    ],
                    'pe-7s-paint' => [
                        'title' => 'Paint',
                        'icon' => 'pe-7s-paint',
                    ],
                    'pe-7s-piggy' => [
                        'title' => 'Piggy',
                        'icon' => 'pe-7s-piggy',
                    ],
                    'pe-7s-notebook' => [
                        'title' => 'Notebook',
                        'icon' => 'pe-7s-notebook',
                    ],
                    'pe-7s-note' => [
                        'title' => 'Note',
                        'icon' => 'pe-7s-note',
                    ],
                    'pe-7s-next' => [
                        'title' => 'Next',
                        'icon' => 'pe-7s-next',
                    ],
                    'pe-7s-news-paper' => [
                        'title' => 'News Paper',
                        'icon' => 'pe-7s-news-paper',
                    ],
                    'pe-7s-musiclist' => [
                        'title' => 'Musiclist',
                        'icon' => 'pe-7s-musiclist',
                    ],
                    'pe-7s-music' => [
                        'title' => 'Music',
                        'icon' => 'pe-7s-music',
                    ],
                    'pe-7s-mouse' => [
                        'title' => 'Mouse',
                        'icon' => 'pe-7s-mouse',
                    ],
                    'pe-7s-more' => [
                        'title' => 'More',
                        'icon' => 'pe-7s-more',
                    ],
                    'pe-7s-moon' => [
                        'title' => 'Moon',
                        'icon' => 'pe-7s-moon',
                    ],
                    'pe-7s-monitor' => [
                        'title' => 'Monitor',
                        'icon' => 'pe-7s-monitor',
                    ],
                    'pe-7s-micro' => [
                        'title' => 'Micro',
                        'icon' => 'pe-7s-micro',
                    ],
                    'pe-7s-menu' => [
                        'title' => 'Menu',
                        'icon' => 'pe-7s-menu',
                    ],
                    'pe-7s-map' => [
                        'title' => 'Map',
                        'icon' => 'pe-7s-map',
                    ],
                    'pe-7s-map-marker' => [
                        'title' => 'Map Marker',
                        'icon' => 'pe-7s-map-marker',
                    ],
                    'pe-7s-mail' => [
                        'title' => 'Mail',
                        'icon' => 'pe-7s-mail',
                    ],
                    'pe-7s-mail-open' => [
                        'title' => 'Mail Open',
                        'icon' => 'pe-7s-mail-open',
                    ],
                    'pe-7s-mail-open-file' => [
                        'title' => 'Mail Open File',
                        'icon' => 'pe-7s-mail-open-file',
                    ],
                    'pe-7s-magnet' => [
                        'title' => 'Magnet',
                        'icon' => 'pe-7s-magnet',
                    ],
                    'pe-7s-loop' => [
                        'title' => 'Loop',
                        'icon' => 'pe-7s-loop',
                    ],
                    'pe-7s-look' => [
                        'title' => 'Look',
                        'icon' => 'pe-7s-look',
                    ],
                    'pe-7s-lock' => [
                        'title' => 'Lock',
                        'icon' => 'pe-7s-lock',
                    ],
                    'pe-7s-lintern' => [
                        'title' => 'Lintern',
                        'icon' => 'pe-7s-lintern',
                    ],
                    'pe-7s-link' => [
                        'title' => 'Link',
                        'icon' => 'pe-7s-link',
                    ],
                    'pe-7s-like' => [
                        'title' => 'Like',
                        'icon' => 'pe-7s-like',
                    ],
                    'pe-7s-light' => [
                        'title' => 'Light',
                        'icon' => 'pe-7s-light',
                    ],
                    'pe-7s-less' => [
                        'title' => 'Less',
                        'icon' => 'pe-7s-less',
                    ],
                    'pe-7s-keypad' => [
                        'title' => 'Keypad',
                        'icon' => 'pe-7s-keypad',
                    ],
                    'pe-7s-junk' => [
                        'title' => 'Junk',
                        'icon' => 'pe-7s-junk',
                    ],
                    'pe-7s-info' => [
                        'title' => 'Info',
                        'icon' => 'pe-7s-info',
                    ],
                    'pe-7s-home' => [
                        'title' => 'Home',
                        'icon' => 'pe-7s-home',
                    ],
                    'pe-7s-help2' => [
                        'title' => 'Help2',
                        'icon' => 'pe-7s-help2',
                    ],
                    'pe-7s-help1' => [
                        'title' => 'Help1',
                        'icon' => 'pe-7s-help1',
                    ],
                    'pe-7s-graph3' => [
                        'title' => 'Graph3',
                        'icon' => 'pe-7s-graph3',
                    ],
                    'pe-7s-graph2' => [
                        'title' => 'Graph2',
                        'icon' => 'pe-7s-graph2',
                    ],
                    'pe-7s-graph1' => [
                        'title' => 'Graph1',
                        'icon' => 'pe-7s-graph1',
                    ],
                    'pe-7s-graph' => [
                        'title' => 'Graph',
                        'icon' => 'pe-7s-graph',
                    ],
                    'pe-7s-global' => [
                        'title' => 'Global',
                        'icon' => 'pe-7s-global',
                    ],
                    'pe-7s-gleam' => [
                        'title' => 'Gleam',
                        'icon' => 'pe-7s-gleam',
                    ],
                    'pe-7s-glasses' => [
                        'title' => 'Glasses',
                        'icon' => 'pe-7s-glasses',
                    ],
                    'pe-7s-gift' => [
                        'title' => 'Gift',
                        'icon' => 'pe-7s-gift',
                    ],
                    'pe-7s-folder' => [
                        'title' => 'Folder',
                        'icon' => 'pe-7s-folder',
                    ],
                    'pe-7s-flag' => [
                        'title' => 'Flag',
                        'icon' => 'pe-7s-flag',
                    ],
                    'pe-7s-filter' => [
                        'title' => 'Filter',
                        'icon' => 'pe-7s-filter',
                    ],
                    'pe-7s-file' => [
                        'title' => 'File',
                        'icon' => 'pe-7s-file',
                    ],
                    'pe-7s-expand1' => [
                        'title' => 'Expand1',
                        'icon' => 'pe-7s-expand1',
                    ],
                    'pe-7s-exapnd2' => [
                        'title' => 'Exapnd2',
                        'icon' => 'pe-7s-exapnd2',
                    ],
                    'pe-7s-edit' => [
                        'title' => 'Edit',
                        'icon' => 'pe-7s-edit',
                    ],
                    'pe-7s-drop' => [
                        'title' => 'Drop',
                        'icon' => 'pe-7s-drop',
                    ],
                    'pe-7s-drawer' => [
                        'title' => 'Drawer',
                        'icon' => 'pe-7s-drawer',
                    ],
                    'pe-7s-download' => [
                        'title' => 'Download',
                        'icon' => 'pe-7s-download',
                    ],
                    'pe-7s-display2' => [
                        'title' => 'Display2',
                        'icon' => 'pe-7s-display2',
                    ],
                    'pe-7s-display1' => [
                        'title' => 'Display1',
                        'icon' => 'pe-7s-display1',
                    ],
                    'pe-7s-diskette' => [
                        'title' => 'Diskette',
                        'icon' => 'pe-7s-diskette',
                    ],
                    'pe-7s-date' => [
                        'title' => 'Date',
                        'icon' => 'pe-7s-date',
                    ],
                    'pe-7s-cup' => [
                        'title' => 'Cup',
                        'icon' => 'pe-7s-cup',
                    ],
                    'pe-7s-culture' => [
                        'title' => 'Culture',
                        'icon' => 'pe-7s-culture',
                    ],
                    'pe-7s-crop' => [
                        'title' => 'Crop',
                        'icon' => 'pe-7s-crop',
                    ],
                    'pe-7s-credit' => [
                        'title' => 'Credit',
                        'icon' => 'pe-7s-credit',
                    ],
                    'pe-7s-copy-file' => [
                        'title' => 'Copy File',
                        'icon' => 'pe-7s-copy-file',
                    ],
                    'pe-7s-config' => [
                        'title' => 'Config',
                        'icon' => 'pe-7s-config',
                    ],
                    'pe-7s-compass' => [
                        'title' => 'Compass',
                        'icon' => 'pe-7s-compass',
                    ],
                    'pe-7s-comment' => [
                        'title' => 'Comment',
                        'icon' => 'pe-7s-comment',
                    ],
                    'pe-7s-coffee' => [
                        'title' => 'Coffee',
                        'icon' => 'pe-7s-coffee',
                    ],
                    'pe-7s-cloud' => [
                        'title' => 'Cloud',
                        'icon' => 'pe-7s-cloud',
                    ],
                    'pe-7s-clock' => [
                        'title' => 'Clock',
                        'icon' => 'pe-7s-clock',
                    ],
                    'pe-7s-check' => [
                        'title' => 'Check',
                        'icon' => 'pe-7s-check',
                    ],
                    'pe-7s-chat' => [
                        'title' => 'Chat',
                        'icon' => 'pe-7s-chat',
                    ],
                    'pe-7s-cart' => [
                        'title' => 'Cart',
                        'icon' => 'pe-7s-cart',
                    ],
                    'pe-7s-camera' => [
                        'title' => 'Camera',
                        'icon' => 'pe-7s-camera',
                    ],
                    'pe-7s-call' => [
                        'title' => 'Call',
                        'icon' => 'pe-7s-call',
                    ],
                    'pe-7s-calculator' => [
                        'title' => 'Calculator',
                        'icon' => 'pe-7s-calculator',
                    ],
                    'pe-7s-browser' => [
                        'title' => 'Browser',
                        'icon' => 'pe-7s-browser',
                    ],
                    'pe-7s-box2' => [
                        'title' => 'Box2',
                        'icon' => 'pe-7s-box2',
                    ],
                    'pe-7s-box1' => [
                        'title' => 'Box1',
                        'icon' => 'pe-7s-box1',
                    ],
                    'pe-7s-bookmarks' => [
                        'title' => 'Bookmarks',
                        'icon' => 'pe-7s-bookmarks',
                    ],
                    'pe-7s-bicycle' => [
                        'title' => 'Bicycle',
                        'icon' => 'pe-7s-bicycle',
                    ],
                    'pe-7s-bell' => [
                        'title' => 'Bell',
                        'icon' => 'pe-7s-bell',
                    ],
                    'pe-7s-battery' => [
                        'title' => 'Battery',
                        'icon' => 'pe-7s-battery',
                    ],
                    'pe-7s-ball' => [
                        'title' => 'Ball',
                        'icon' => 'pe-7s-ball',
                    ],
                    'pe-7s-back' => [
                        'title' => 'Back',
                        'icon' => 'pe-7s-back',
                    ],
                    'pe-7s-attention' => [
                        'title' => 'Attention',
                        'icon' => 'pe-7s-attention',
                    ],
                    'pe-7s-anchor' => [
                        'title' => 'Anchor',
                        'icon' => 'pe-7s-anchor',
                    ],
                    'pe-7s-albums' => [
                        'title' => 'Albums',
                        'icon' => 'pe-7s-albums',
                    ],
                    'pe-7s-alarm' => [
                        'title' => 'Alarm',
                        'icon' => 'pe-7s-alarm',
                    ],
                    'pe-7s-airplay' => [
                        'title' => 'Airplay',
                        'icon' => 'pe-7s-airplay',
                    ],
                    'pe-7s-cloud-upload' => [
                        'title' => 'Cloud Upload',
                        'icon' => 'pe-7s-cloud-upload',
                    ],
                    'pe-7s-cloud-download' => [
                        'title' => 'Loud Download',
                        'icon' => 'pe-7s-cloud-download',
                    ],
                    'pe-7f-close' => [
                        'title' => 'Close',
                        'icon' => 'pe-7f-close',
                    ],
                    'pe-7f-angle-up' => [
                        'title' => 'Angle Up',
                        'icon' => 'pe-7f-angle-up',
                    ],
                    'pe-7f-angle-right' => [
                        'title' => 'Angle Right',
                        'icon' => 'pe-7f-angle-right',
                    ],
                    'pe-7f-angle-left' => [
                        'title' => 'Angle Left',
                        'icon' => 'pe-7f-angle-left',
                    ],
                    'pe-7f-angle-down' => [
                        'title' => 'Angle Down',
                        'icon' => 'pe-7f-angle-down',
                    ],
                    'pe-7f-wallet' => [
                        'title' => 'Wallet',
                        'icon' => 'pe-7f-wallet',
                    ],
                    'pe-7f-volume2' => [
                        'title' => 'Volume2',
                        'icon' => 'pe-7f-volume2',
                    ],
                    'pe-7f-volume1' => [
                        'title' => 'Volume1',
                        'icon' => 'pe-7f-volume1',
                    ],
                    'pe-7f-voicemail' => [
                        'title' => 'Close',
                        'icon' => 'pe-7f-voicemail',
                    ],
                    'pe-7f-video' => [
                        'title' => 'Video',
                        'icon' => 'pe-7f-video',
                    ],
                    'pe-7f-user' => [
                        'title' => 'User',
                        'icon' => 'pe-7f-user',
                    ],
                    'pe-7f-upload' => [
                        'title' => 'Upload',
                        'icon' => 'pe-7f-upload',
                    ],
                    'pe-7f-unlock' => [
                        'title' => 'Unlock',
                        'icon' => 'pe-7f-unlock',
                    ],
                    'pe-7f-umbrella' => [
                        'title' => 'Umbrella',
                        'icon' => 'pe-7f-umbrella',
                    ],
                    'pe-7f-trash' => [
                        'title' => 'Trash',
                        'icon' => 'pe-7f-trash',
                    ],
                    'pe-7f-tools' => [
                        'title' => 'Tools',
                        'icon' => 'pe-7f-tools',
                    ],
                    'pe-7f-timer' => [
                        'title' => 'Timer',
                        'icon' => 'pe-7f-timer',
                    ],
                    'pe-7f-ticket' => [
                        'title' => 'Ticket',
                        'icon' => 'pe-7f-ticket',
                    ],
                    'pe-7f-target' => [
                        'title' => 'Target',
                        'icon' => 'pe-7f-target',
                    ],
                    'pe-7f-sun' => [
                        'title' => 'Sun',
                        'icon' => 'pe-7f-sun',
                    ],
                    'pe-7f-study' => [
                        'title' => 'Study',
                        'icon' => 'pe-7f-study',
                    ],
                    'pe-7f-stopwatch' => [
                        'title' => 'Stopwatch',
                        'icon' => 'pe-7f-stopwatch',
                    ],
                    'pe-7f-star' => [
                        'title' => 'Star',
                        'icon' => 'pe-7f-star',
                    ],
                    'pe-7f-speaker' => [
                        'title' => 'Speaker',
                        'icon' => 'pe-7f-speaker',
                    ],
                    'pe-7f-signal' => [
                        'title' => 'Signal',
                        'icon' => 'pe-7f-signal',
                    ],
                    'pe-7f-shuffle' => [
                        'title' => 'Shuffle',
                        'icon' => 'pe-7f-shuffle',
                    ],
                    'pe-7f-shopbag' => [
                        'title' => 'Shopbag',
                        'icon' => 'pe-7f-shopbag',
                    ],
                    'pe-7f-share' => [
                        'title' => 'Share',
                        'icon' => 'pe-7f-share',
                    ],
                    'pe-7f-server' => [
                        'title' => 'Server',
                        'icon' => 'pe-7f-server',
                    ],
                    'pe-7f-search' => [
                        'title' => 'Search',
                        'icon' => 'pe-7f-search',
                    ],
                    'pe-7f-science' => [
                        'title' => 'Science',
                        'icon' => 'pe-7f-science',
                    ],
                    'pe-7f-ribbon' => [
                        'title' => 'Ribbon',
                        'icon' => 'pe-7f-ribbon',
                    ],
                    'pe-7f-repeat' => [
                        'title' => 'Repeat',
                        'icon' => 'pe-7f-repeat',
                    ],
                    'pe-7f-refresh' => [
                        'title' => 'Refresh',
                        'icon' => 'pe-7f-refresh',
                    ],
                    'pe-7f-refresh-cloud' => [
                        'title' => 'Refresh Cloud',
                        'icon' => 'pe-7f-refresh-cloud',
                    ],
                    'pe-7f-radio' => [
                        'title' => 'Radio',
                        'icon' => 'pe-7f-radio',
                    ],
                    'pe-7f-print' => [
                        'title' => 'Print',
                        'icon' => 'pe-7f-print',
                    ],
                    'pe-7f-prev' => [
                        'title' => 'Prev',
                        'icon' => 'pe-7f-prev',
                    ],
                    'pe-7f-power' => [
                        'title' => 'Power',
                        'icon' => 'pe-7f-power',
                    ],
                    'pe-7f-portfolio' => [
                        'title' => 'Portfolio',
                        'icon' => 'pe-7f-portfolio',
                    ],
                    'pe-7f-plus' => [
                        'title' => 'Plus',
                        'icon' => 'pe-7f-plus',
                    ],
                    'pe-7f-play' => [
                        'title' => 'Play',
                        'icon' => 'pe-7f-play',
                    ],
                    'pe-7f-plane' => [
                        'title' => 'Plane',
                        'icon' => 'pe-7f-plane',
                    ],
                    'pe-7f-photo-gallery' => [
                        'title' => 'Photo Gallery',
                        'icon' => 'pe-7f-photo-gallery',
                    ],
                    'pe-7f-phone' => [
                        'title' => 'Phone',
                        'icon' => 'pe-7f-phone',
                    ],
                    'pe-7f-pen' => [
                        'title' => 'Pen',
                        'icon' => 'pe-7f-pen',
                    ],
                    'pe-7f-paper-plane' => [
                        'title' => 'Paper Plane',
                        'icon' => 'pe-7f-paper-plane',
                    ],
                    'pe-7f-paint' => [
                        'title' => 'Paint',
                        'icon' => 'pe-7f-paint',
                    ],
                    'pe-7f-piggy' => [
                        'title' => 'Piggy',
                        'icon' => 'pe-7f-piggy',
                    ],
                    'pe-7f-notebook' => [
                        'title' => 'Notebook',
                        'icon' => 'pe-7f-notebook',
                    ],
                    'pe-7f-note' => [
                        'title' => 'Note',
                        'icon' => 'pe-7f-note',
                    ],
                    'pe-7f-next' => [
                        'title' => 'Next',
                        'icon' => 'pe-7f-next',
                    ],
                    'pe-7f-news-paper' => [
                        'title' => 'News Paper',
                        'icon' => 'pe-7f-news-paper',
                    ],
                    'pe-7f-musiclist' => [
                        'title' => 'Musiclist',
                        'icon' => 'pe-7f-musiclist',
                    ],
                    'pe-7f-music' => [
                        'title' => 'Music',
                        'icon' => 'pe-7f-music',
                    ],
                    'pe-7f-mouse' => [
                        'title' => 'Mouse',
                        'icon' => 'pe-7f-mouse',
                    ],
                    'pe-7f-more' => [
                        'title' => 'More',
                        'icon' => 'pe-7f-more',
                    ],
                    'pe-7f-moon' => [
                        'title' => 'Moon',
                        'icon' => 'pe-7f-moon',
                    ],
                    'pe-7f-monitor' => [
                        'title' => 'Monitor',
                        'icon' => 'pe-7f-monitor',
                    ],
                    'pe-7f-micro' => [
                        'title' => 'Micro',
                        'icon' => 'pe-7f-micro',
                    ],
                    'pe-7f-menu' => [
                        'title' => 'Menu',
                        'icon' => 'pe-7f-menu',
                    ],
                    'pe-7f-map' => [
                        'title' => 'Map',
                        'icon' => 'pe-7f-map',
                    ],
                    'pe-7f-map-marker' => [
                        'title' => 'Map Marker',
                        'icon' => 'pe-7f-map-marker',
                    ],
                    'pe-7f-mail' => [
                        'title' => 'Mail',
                        'icon' => 'pe-7f-mail',
                    ],
                    'pe-7f-mail-open' => [
                        'title' => 'Mail Open',
                        'icon' => 'pe-7f-mail-open',
                    ],
                    'pe-7f-mail-open-file' => [
                        'title' => 'Mail Open File',
                        'icon' => 'pe-7f-mail-open-file',
                    ],
                    'pe-7f-magnet' => [
                        'title' => 'Magnet',
                        'icon' => 'pe-7f-magnet',
                    ],
                    'pe-7f-loop' => [
                        'title' => 'Loop',
                        'icon' => 'pe-7f-loop',
                    ],
                    'pe-7f-look' => [
                        'title' => 'Look',
                        'icon' => 'pe-7f-look',
                    ],
                    'pe-7f-lock' => [
                        'title' => 'Lock',
                        'icon' => 'pe-7f-lock',
                    ],
                    'pe-7f-lintern' => [
                        'title' => 'Lintern',
                        'icon' => 'pe-7f-lintern',
                    ],
                    'pe-7f-link' => [
                        'title' => 'Link',
                        'icon' => 'pe-7f-link',
                    ],
                    'pe-7f-like' => [
                        'title' => 'Like',
                        'icon' => 'pe-7f-like',
                    ],
                    'pe-7f-light' => [
                        'title' => 'Light',
                        'icon' => 'pe-7f-light',
                    ],
                    'pe-7f-less' => [
                        'title' => 'Less',
                        'icon' => 'pe-7f-less',
                    ],
                    'pe-7f-keypad' => [
                        'title' => 'Keypad',
                        'icon' => 'pe-7f-keypad',
                    ],
                    'pe-7f-junk' => [
                        'title' => 'Junk',
                        'icon' => 'pe-7f-junk',
                    ],
                    'pe-7f-info' => [
                        'title' => 'Info',
                        'icon' => 'pe-7f-info',
                    ],
                    'pe-7f-home' => [
                        'title' => 'Home',
                        'icon' => 'pe-7f-home',
                    ],
                    'pe-7f-help2' => [
                        'title' => 'Help2',
                        'icon' => 'pe-7f-help2',
                    ],
                    'pe-7f-help1' => [
                        'title' => 'Help1',
                        'icon' => 'pe-7f-help1',
                    ],
                    'pe-7f-graph3' => [
                        'title' => 'Graph3',
                        'icon' => 'pe-7f-graph3',
                    ],
                    'pe-7f-graph2' => [
                        'title' => 'Graph2',
                        'icon' => 'pe-7f-graph2',
                    ],
                    'pe-7f-graph1' => [
                        'title' => 'Graph1',
                        'icon' => 'pe-7f-graph1',
                    ],
                    'pe-7f-graph' => [
                        'title' => 'Graph',
                        'icon' => 'pe-7f-graph',
                    ],
                    'pe-7f-global' => [
                        'title' => 'Global',
                        'icon' => 'pe-7f-global',
                    ],
                    'pe-7f-gleam' => [
                        'title' => 'Gleam',
                        'icon' => 'pe-7f-gleam',
                    ],
                    'pe-7f-glasses' => [
                        'title' => 'Glasses',
                        'icon' => 'pe-7f-glasses',
                    ],
                    'pe-7f-gift' => [
                        'title' => 'Gift',
                        'icon' => 'pe-7f-gift',
                    ],
                    'pe-7f-folder' => [
                        'title' => 'Folder',
                        'icon' => 'pe-7f-folder',
                    ],
                    'pe-7f-flag' => [
                        'title' => 'Flag',
                        'icon' => 'pe-7f-flag',
                    ],
                    'pe-7f-filter' => [
                        'title' => 'Filter',
                        'icon' => 'pe-7f-filter',
                    ],
                    'pe-7f-file' => [
                        'title' => 'File',
                        'icon' => 'pe-7f-file',
                    ],
                    'pe-7f-expand1' => [
                        'title' => 'Expand1',
                        'icon' => 'pe-7f-expand1',
                    ],
                    'pe-7f-edit' => [
                        'title' => 'Edit',
                        'icon' => 'pe-7f-edit',
                    ],
                    'pe-7f-drop' => [
                        'title' => 'Drop',
                        'icon' => 'pe-7f-drop',
                    ],
                    'pe-7f-drawer' => [
                        'title' => 'Drawer',
                        'icon' => 'pe-7f-drawer',
                    ],
                    'pe-7f-download' => [
                        'title' => 'Download',
                        'icon' => 'pe-7f-download',
                    ],
                    'pe-7f-display2' => [
                        'title' => 'Display2',
                        'icon' => 'pe-7f-display2',
                    ],
                    'pe-7f-display1' => [
                        'title' => 'Display1',
                        'icon' => 'pe-7f-display1',
                    ],
                    'pe-7f-diskette' => [
                        'title' => 'Diskette',
                        'icon' => 'pe-7f-diskette',
                    ],
                    'pe-7f-date' => [
                        'title' => 'Date',
                        'icon' => 'pe-7f-date',
                    ],
                    'pe-7f-cup' => [
                        'title' => 'Cup',
                        'icon' => 'pe-7f-cup',
                    ],
                    'pe-7f-culture' => [
                        'title' => 'Culture',
                        'icon' => 'pe-7f-culture',
                    ],
                    'pe-7f-crop' => [
                        'title' => 'Crop',
                        'icon' => 'pe-7f-crop',
                    ],
                    'pe-7f-credit' => [
                        'title' => 'Credit',
                        'icon' => 'pe-7f-credit',
                    ],
                    'pe-7f-copy-file' => [
                        'title' => 'Copy File',
                        'icon' => 'pe-7f-copy-file',
                    ],
                    'pe-7f-config' => [
                        'title' => 'Config',
                        'icon' => 'pe-7f-config',
                    ],
                    'pe-7f-compass' => [
                        'title' => 'Compass',
                        'icon' => 'pe-7f-compass',
                    ],
                    'pe-7f-comment' => [
                        'title' => 'Comment',
                        'icon' => 'pe-7f-comment',
                    ],
                    'pe-7f-coffee' => [
                        'title' => 'Coffee',
                        'icon' => 'pe-7f-coffee',
                    ],
                    'pe-7f-cloud' => [
                        'title' => 'Cloud',
                        'icon' => 'pe-7f-cloud',
                    ],
                    'pe-7f-clock' => [
                        'title' => 'Clock',
                        'icon' => 'pe-7f-clock',
                    ],
                    'pe-7f-check' => [
                        'title' => 'Check',
                        'icon' => 'pe-7f-check',
                    ],
                    'pe-7f-chat' => [
                        'title' => 'Chat',
                        'icon' => 'pe-7f-chat',
                    ],
                    'pe-7f-cart' => [
                        'title' => 'Cart',
                        'icon' => 'pe-7f-cart',
                    ],
                    'pe-7f-camera' => [
                        'title' => 'Camera',
                        'icon' => 'pe-7f-camera',
                    ],
                    'pe-7f-call' => [
                        'title' => 'Call',
                        'icon' => 'pe-7f-call',
                    ],
                    'pe-7f-calculator' => [
                        'title' => 'Calculator',
                        'icon' => 'pe-7f-calculator',
                    ],
                    'pe-7f-browser' => [
                        'title' => 'Browser',
                        'icon' => 'pe-7f-browser',
                    ],
                    'pe-7f-box1' => [
                        'title' => 'Box1',
                        'icon' => 'pe-7f-box1',
                    ],
                    'pe-7f-bookmarks' => [
                        'title' => 'Bookmarks',
                        'icon' => 'pe-7f-bookmarks',
                    ],
                    'pe-7f-bicycle' => [
                        'title' => 'Bicycle',
                        'icon' => 'pe-7f-bicycle',
                    ],
                    'pe-7f-bell' => [
                        'title' => 'Bell',
                        'icon' => 'pe-7f-bell',
                    ],
                    'pe-7f-battery' => [
                        'title' => 'Battery',
                        'icon' => 'pe-7f-battery',
                    ],
                    'pe-7f-ball' => [
                        'title' => 'Ball',
                        'icon' => 'pe-7f-ball',
                    ],
                    'pe-7f-back' => [
                        'title' => 'Back',
                        'icon' => 'pe-7f-back',
                    ],
                    'pe-7f-attention' => [
                        'title' => 'Attention',
                        'icon' => 'pe-7f-attention',
                    ],
                    'pe-7f-anchor' => [
                        'title' => 'Anchor',
                        'icon' => 'pe-7f-anchor',
                    ],
                    'pe-7f-albums' => [
                        'title' => 'Albums',
                        'icon' => 'pe-7f-albums',
                    ],
                    'pe-7f-alarm' => [
                        'title' => 'Alarm',
                        'icon' => 'pe-7f-alarm',
                    ],
                    'pe-7f-airplay' => [
                        'title' => 'Airplay',
                        'icon' => 'pe-7f-airplay',
                    ],
                    'pe-7f-cloud-upload' => [
                        'title' => 'Cloud Upload',
                        'icon' => 'pe-7f-cloud-upload',
                    ],
                    'pe-7f-cloud-download' => [
                        'title' => 'Loud Download',
                        'icon' => 'pe-7f-cloud-download',
                    ],
                ],
				'default'   => 'pe-7s-star',
                'condition' => [ 'icon_type' => 'icon' ],
			]
		);
        $this->add_control(
			'icon_style',
			[
				'label'     => __( 'Icon Style', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => 'simple',
				'options'   => [
                    'simple'	    => 'Simple',
                    'background'    => 'Background',
                    'border'	    => 'Border',
				],
                'condition' => [ 'icon_type' => 'icon' ],
			]
		);
        $this->add_control(
			'icon_background_color',
			[
				'label'     => __( 'Icon Background/Border Color', 'nm-framework-admin' ),
				'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'default'   => '',
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'      => 'icon_type',
                            'operator'  => '==',
                            'value'     => 'icon'
                        ],
                        [
                            'name'      => 'icon_style',
                            'operator'  => '!=',
                            'value'     => 'simple'
                        ]
                    ]
                ],
                'selectors'     => [
					'{{WRAPPER}} .nm-feature.icon-style-border .nm-feature-icon' => 'border-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .nm-feature.icon-style-background .nm-feature-icon' => 'background-color: {{VALUE}} !important;',
				],
			]
		);
        $this->add_control(
			'icon_color',
			[
				'label'     => __( 'Icon Color', 'nm-framework-admin' ),
				'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'default'   => '',
                'condition' => [ 'icon_type' => 'icon' ],
                'selectors'     => [
					'{{WRAPPER}} .nm-feature .nm-feature-icon i' => 'color: {{VALUE}} !important;',
				],
			]
		);
        $this->add_control(
			'image_id', 
			[
				'label'         => __( 'Image', 'nm-framework-admin' ),
				'type'          => Controls_Manager::MEDIA,
                'separator' => 'before',
                'condition' => [ 'icon_type' => 'image_id' ],
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
                    'default'	=> 'Default',
                    'rounded'   => 'Rounded',
				],
                'condition' => [ 'icon_type' => 'image_id' ],
			]
		);
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
			'tab_feature_layout',
			[
				'label' => __( 'Layout', 'nm-framework-admin' ),
			]
		);
        
        $this->add_control(
			'layout',
			[
				'label'     => __( 'Layout', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => 'default',
				'options'   => [
                    'default'	    => 'Default',
                    'centered'      => 'Centered',
                    'icon_right'    => 'Icon Right',
                    'icon_left'     => 'Icon Left',
				],
			]
		);
        $this->add_control(
            'top_offset',
            [
                'label'     => __( 'Top Offset', 'nm-framework-admin' ),
                'type'      => Controls_Manager::NUMBER,
                'separator' => 'before',
                'min'       => 1,
                'max'       => 1000,
                'step'      => 1,
                'default'   => '',
            ]
        );
        $this->add_control(
			'bottom_spacing',
			[
				'label'     => __( 'Bottom Spacing', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => 'none',
				'options'   => [
                    'none'	    => '(None)',
                    'small'     => 'Small',
                    'medium'    => 'Medium',
                    'large'     => 'Large',
				],
			]
		);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
		$this->end_controls_section();
        
    }

	protected function render() {
        $feature_box = $this->get_settings_for_display();
        
        $settings = array();
        
        // Image ID
        if ( isset( $feature_box['image_id'] ) ) {
            if ( isset( $feature_box['image_id']['id'] ) && ! empty( $feature_box['image_id']['id'] ) ) {
                $settings['image_id'] = $feature_box['image_id']['id'];
            }
        }
        unset( $feature_box['image_id'] );
        
        // Content
        $content = $feature_box['content'];
        unset( $feature_box['content'] );
        
        // Link
        if ( strlen( $feature_box['link'] ) > 0 ) {
            $link = 'url:' . urlencode( $feature_box['link'] ) . '|title:' . rawurlencode( $feature_box['link_title'] ) . '|'; // Encoded for "vc_build_link()" function
            $settings['link'] = $link;
        }
        unset( $feature_box['link'] );
        unset( $feature_box['link_title'] );
        
        // Settings
        foreach( $feature_box as $setting => $value ) {
            if ( substr( $setting, 0, 1 ) === '_' ) { break; } // Break loop if setting name starts with "_" (Elementor adds this to its own settings)
            if ( empty( $value ) && $value !== '0' ) { continue; } // Don't add empty settings, except "0" values
            
            $settings[$setting] = $value;
        }
        
        echo nm_shortcode_feature( $settings, $content );
    }

}