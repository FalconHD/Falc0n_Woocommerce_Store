<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

/* Class: Widget - NM_Elementor_Tabs  */
class NM_Elementor_Tabs extends \Elementor\Widget_Base {
    
	public function get_name() {
		return 'nm-tabs';
	}
	
	public function get_title() {
		return __( 'Tabs', 'elementor' );
	}
    
	public function get_icon() {
		return 'eicon-tabs';
	}
    
    public function get_categories() {
        return [ 'savoy-theme' ];
	}
    
    public function get_script_depends() {
		return [ 'nm-elementor-widgets' ];
	}
    
	protected function _register_controls() {
		$this->start_controls_section(
			'section_tabs',
			[
				'label' => __( 'Tabs', 'elementor' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'tab_title',
			[
				'label' => __( 'Title & Description', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Tab Title', 'elementor' ),
				'placeholder' => __( 'Tab Title', 'elementor' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'tab_content',
			[
				'label' => __( 'Content', 'elementor' ),
				'default' => __( 'Tab Content', 'elementor' ),
				'placeholder' => __( 'Tab Content', 'elementor' ),
				'type' => Controls_Manager::WYSIWYG,
				'show_label' => false,
				'dynamic' => [
					'active' => false,
				],
			]
		);
		$this->add_control(
			'tabs',
			[
				'label' => __( 'Tabs Items', 'elementor' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_title' => __( 'Tab #1', 'elementor' ),
						'tab_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'elementor' ),
					],
					[
						'tab_title' => __( 'Tab #2', 'elementor' ),
						'tab_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'elementor' ),
					],
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);
		$this->add_control(
			'type',
			[
				'label'     => __( 'Type', 'elementor' ),
				'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
				'default'   => 'horizontal',
				'options'   => [
					'horizontal'   => __( 'Horizontal', 'elementor' ),
					'vertical'     => __( 'Vertical', 'elementor' ),
				],
				'prefix_class'  => 'nm-elementor-tabs-',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_tabs_style',
			[
				'label' => __( 'Tabs', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'alignment',
			[
				'label'     => __( 'Alignment', 'nm-framework-admin' ),
				'type'      => Controls_Manager::SELECT,
                'default'   => 'center',
				'options'   => [
                    'left'     => 'Left',
					'center'   => 'Center',
					'right'	   => 'Right',
				],
                'prefix_class'  => 'nm-elementor-tabs-align-',
                'condition' => [ 'type' => 'horizontal' ],
			]
		);
		$this->add_control(
			'navigation_width',
			[
				'label'     => __( 'Navigation Width', 'elementor' ),
				'type'      => Controls_Manager::SLIDER,
                'default'   => [
					'unit' => '%',
				],
				'range' => [
					'%' => [
						'min' => 10,
						'max' => 50,
					],
				],
				'selectors' => [ '{{WRAPPER}} .nm-elementor-tabs-wrapper' => 'width: {{SIZE}}{{UNIT}}' ],
				'condition' => [ 'type' => 'vertical' ],
			]
		);

		$this->add_control(
			'heading_title',
			[
				'label' => __( 'Title', 'elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'tab_color',
			[
				'label' => __( 'Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nm-elementor-tab, {{WRAPPER}} .nm-elementor-tab a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'tab_active_color',
			[
				'label' => __( 'Active Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nm-elementor-tab.nm-elementor-active a' => 'color: {{VALUE}};',
				],
			]
		);
        $this->add_control(
			'tab_active_border_color',
			[
				'label' => __( 'Active Border Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nm-elementor-tab.nm-elementor-active a' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tab_typography',
				'selector' => '{{WRAPPER}} .nm-elementor-tab a',
			]
		);

		$this->add_control(
			'heading_content',
			[
				'label' => __( 'Content', 'elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'content_color',
			[
				'label' => __( 'Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nm-elementor-tab-content' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .nm-elementor-tab-content',
			]
		);

		$this->end_controls_section();
	}
    
	protected function render() {
		if ( function_exists( 'nm_add_page_include' ) ) {
            nm_add_page_include( 'elementor-tabs' );
        }
        
        $tabs = $this->get_settings_for_display( 'tabs' );
        
		$id_int = substr( $this->get_id_int(), 0, 3 );
		?>
		<div class="nm-elementor-tabs" role="tablist">
			<div class="nm-elementor-tabs-wrapper">
				<?php
				foreach ( $tabs as $index => $item ) :
					$tab_count = $index + 1;
					$tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );
                    $tab_active_class = ( $tab_count == 1 ) ? 'nm-elementor-active' : '';

					$this->add_render_attribute( $tab_title_setting_key, [
						'id'              => 'nm-elementor-tab-' . $id_int . $tab_count,
						'class'           => [ 'nm-elementor-tab', $tab_active_class ],
						'data-tab'        => $tab_count,
						'role'            => 'tab',
						'aria-controls'   => 'nm-elementor-tab-content-' . $id_int . $tab_count,
					] );
					?>
					<div <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?>><a href=""><?php echo $item['tab_title']; ?></a></div>
				<?php endforeach; ?>
			</div>
			<div class="nm-elementor-tabs-content-wrapper">
				<?php
				foreach ( $tabs as $index => $item ) :
					$tab_count = $index + 1;
					$tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', $index );
                    $tab_content_active_class = ( $tab_count == 1 ) ? 'nm-elementor-active' : '';

					$this->add_render_attribute( $tab_content_setting_key, [
						'id'              => 'nm-elementor-tab-content-' . $id_int . $tab_count,
						'class'           => [ 'nm-elementor-tab-content', $tab_content_active_class ],
						'data-tab'        => $tab_count,
						'role'            => 'tabpanel',
						'aria-labelledby' => 'nm-elementor-tab-' . $id_int . $tab_count,
					] );
                    
					//$this->add_inline_editing_attributes( $tab_content_setting_key, 'advanced' );
				    ?>
					<div <?php echo $this->get_render_attribute_string( $tab_content_setting_key ); ?>><?php echo $this->parse_text_editor( $item['tab_content'] ); ?></div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Render tabs widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	/*protected function content_template() {
		?>
		<div class="nm-elementor-tabs" role="tablist">
			<#
			if ( settings.tabs ) {
				var tabindex = view.getIDInt().toString().substr( 0, 3 );
				#>
				<div class="nm-elementor-tabs-wrapper">
					<#
					_.each( settings.tabs, function( item, index ) {
						var tabCount = index + 1;
						#>
						<div id="nm-elementor-tab-{{ tabindex + tabCount }}" class="nm-elementor-tab" data-tab="{{ tabCount }}" role="tab" aria-controls="nm-elementor-tab-content-{{ tabindex + tabCount }}"><a href="">{{{ item.tab_title }}}</a></div>
					<# } ); #>
				</div>
				<div class="nm-elementor-tabs-content-wrapper">
					<#
					_.each( settings.tabs, function( item, index ) {
						var tabCount = index + 1,
							tabContentKey = view.getRepeaterSettingKey( 'tab_content', 'tabs',index );

						view.addRenderAttribute( tabContentKey, {
							'id': 'nm-elementor-tab-content-' + tabindex + tabCount,
							'class': [ 'nm-elementor-tab-content', 'nm-elementor-repeater-item-' + item._id ],
							'data-tab': tabCount,
							'role' : 'tabpanel',
							'aria-labelledby' : 'nm-elementor-tab-' + tabindex + tabCount
						} );

						//view.addInlineEditingAttributes( tabContentKey, 'advanced' );
						#>
						<div {{{ view.getRenderAttributeString( tabContentKey ) }}}>{{{ item.tab_content }}}</div>
					<# } ); #>
				</div>
			<# } #>
		</div>
		<?php
	}*/
}
