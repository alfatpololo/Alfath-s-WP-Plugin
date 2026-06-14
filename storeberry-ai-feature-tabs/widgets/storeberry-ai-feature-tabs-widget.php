<?php
/**
 * Storeberry AI Feature Tabs – Elementor Widget.
 *
 * @package Storeberry_AI_Feature_Tabs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Elementor widget for Storeberry-style AI feature tabs.
 */
class Storeberry_AI_Feature_Tabs_Widget extends \Elementor\Widget_Base {

	/**
	 * Widget slug.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'storeberry_ai_feature_tabs';
	}

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Storeberry AI Feature Tabs', 'storeberry-ai-feature-tabs' );
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-tabs';
	}

	/**
	 * Widget categories.
	 *
	 * @return array
	 */
	public function get_categories() {
		return array( 'storeberry' );
	}

	/**
	 * Widget keywords.
	 *
	 * @return array
	 */
	public function get_keywords() {
		return array( 'tabs', 'features', 'ai', 'storeberry', 'accordion' );
	}

	/**
	 * Style dependencies.
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return array( 'storeberry-ai-feature-tabs' );
	}

	/**
	 * Script dependencies.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array( 'storeberry-ai-feature-tabs' );
	}

	/**
	 * Get published Elementor library templates.
	 *
	 * @return array
	 */
	private function get_elementor_templates() {
		$options = array( '' => esc_html__( '— Select Template —', 'storeberry-ai-feature-tabs' ) );

		$templates = get_posts(
			array(
				'post_type'      => 'elementor_library',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'orderby'        => 'title',
				'order'          => 'ASC',
			)
		);

		if ( ! empty( $templates ) ) {
			foreach ( $templates as $template ) {
				$options[ (string) $template->ID ] = $template->post_title;
			}
		}

		return $options;
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls() {
		$this->register_content_controls();
		$this->register_style_controls();
	}

	/**
	 * Content tab controls.
	 */
	private function register_content_controls() {
		$this->start_controls_section(
			'section_header',
			array(
				'label' => esc_html__( 'Section Header', 'storeberry-ai-feature-tabs' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'heading',
			array(
				'label'       => esc_html__( 'Heading', 'storeberry-ai-feature-tabs' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Enter heading', 'storeberry-ai-feature-tabs' ),
				'label_block' => true,
				'dynamic'     => array( 'active' => true ),
			)
		);

		$this->add_control(
			'subtitle',
			array(
				'label'       => esc_html__( 'Subtitle', 'storeberry-ai-feature-tabs' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => '',
				'placeholder' => esc_html__( 'Enter subtitle', 'storeberry-ai-feature-tabs' ),
				'rows'        => 3,
				'label_block' => true,
				'dynamic'     => array( 'active' => true ),
			)
		);

		$this->end_controls_section();

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'tab_number',
			array(
				'label'       => esc_html__( 'Number Label', 'storeberry-ai-feature-tabs' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '1.',
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'tab_title',
			array(
				'label'       => esc_html__( 'Tab Title', 'storeberry-ai-feature-tabs' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Tab title', 'storeberry-ai-feature-tabs' ),
				'label_block' => true,
				'dynamic'     => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'tab_description',
			array(
				'label'       => esc_html__( 'Tab Nav Description', 'storeberry-ai-feature-tabs' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => '',
				'placeholder' => esc_html__( 'Short description shown inside the tab card', 'storeberry-ai-feature-tabs' ),
				'rows'        => 4,
				'label_block' => true,
				'dynamic'     => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'content_type',
			array(
				'label'   => esc_html__( 'Content Type', 'storeberry-ai-feature-tabs' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'image',
				'options' => array(
					'image'    => esc_html__( 'Image', 'storeberry-ai-feature-tabs' ),
					'template' => esc_html__( 'Elementor Template', 'storeberry-ai-feature-tabs' ),
					'wysiwyg'  => esc_html__( 'WYSIWYG Content', 'storeberry-ai-feature-tabs' ),
				),
			)
		);

		$repeater->add_control(
			'content_image',
			array(
				'label'     => esc_html__( 'Right Image', 'storeberry-ai-feature-tabs' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'condition' => array( 'content_type' => 'image' ),
			)
		);

		$repeater->add_control(
			'elementor_template',
			array(
				'label'     => esc_html__( 'Elementor Template', 'storeberry-ai-feature-tabs' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => $this->get_elementor_templates(),
				'default'   => '',
				'condition' => array( 'content_type' => 'template' ),
			)
		);

		$repeater->add_control(
			'content_wysiwyg',
			array(
				'label'     => esc_html__( 'WYSIWYG Content', 'storeberry-ai-feature-tabs' ),
				'type'      => \Elementor\Controls_Manager::WYSIWYG,
				'default'   => '',
				'condition' => array( 'content_type' => 'wysiwyg' ),
			)
		);

		$repeater->add_control(
			'active_bg_color',
			array(
				'label' => esc_html__( 'Active Background Color', 'storeberry-ai-feature-tabs' ),
				'type'  => \Elementor\Controls_Manager::COLOR,
			)
		);

		$repeater->add_control(
			'active_text_color',
			array(
				'label' => esc_html__( 'Active Text Color', 'storeberry-ai-feature-tabs' ),
				'type'  => \Elementor\Controls_Manager::COLOR,
			)
		);

		$repeater->add_control(
			'inactive_text_color',
			array(
				'label' => esc_html__( 'Inactive Text Color', 'storeberry-ai-feature-tabs' ),
				'type'  => \Elementor\Controls_Manager::COLOR,
			)
		);

		$this->start_controls_section(
			'section_tabs',
			array(
				'label' => esc_html__( 'Tabs', 'storeberry-ai-feature-tabs' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'tabs',
			array(
				'label'       => esc_html__( 'Tab Items', 'storeberry-ai-feature-tabs' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'tab_number'   => '1.',
						'content_type' => 'image',
					),
				),
				'title_field' => '{{{ tab_number }}} {{{ tab_title }}}',
			)
		);

		$this->add_control(
			'default_active_tab',
			array(
				'label'       => esc_html__( 'Default Active Tab', 'storeberry-ai-feature-tabs' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'default'     => 1,
				'min'         => 1,
				'description' => esc_html__( 'Enter the tab number (1 = first tab).', 'storeberry-ai-feature-tabs' ),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Style tab controls.
	 */
	private function register_style_controls() {
		$this->start_controls_section(
			'section_style_section',
			array(
				'label' => esc_html__( 'Section Style', 'storeberry-ai-feature-tabs' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'section_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'storeberry-ai-feature-tabs' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .saft-section' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'section_padding',
			array(
				'label'      => esc_html__( 'Padding', 'storeberry-ai-feature-tabs' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'      => '80',
					'right'    => '90',
					'bottom'   => '80',
					'left'     => '90',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'top'      => '48',
					'right'    => '32',
					'bottom'   => '48',
					'left'     => '32',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'top'      => '32',
					'right'    => '20',
					'bottom'   => '32',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .saft-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'section_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'storeberry-ai-feature-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 100 ),
					'%'  => array( 'min' => 0, 'max' => 50 ),
				),
				'default'        => array( 'unit' => 'px', 'size' => 36 ),
				'tablet_default' => array( 'unit' => 'px', 'size' => 28 ),
				'mobile_default' => array( 'unit' => 'px', 'size' => 20 ),
				'selectors'  => array(
					'{{WRAPPER}} .saft-section' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'section_max_width',
			array(
				'label'      => esc_html__( 'Max Width', 'storeberry-ai-feature-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 320, 'max' => 2560 ),
					'%'  => array( 'min' => 10, 'max' => 100 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .saft-inner' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_header',
			array(
				'label' => esc_html__( 'Header Style', 'storeberry-ai-feature-tabs' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_color',
			array(
				'label'     => esc_html__( 'Heading Color', 'storeberry-ai-feature-tabs' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .saft-heading' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Heading Typography', 'storeberry-ai-feature-tabs' ),
				'selector' => '{{WRAPPER}} .saft-heading',
			)
		);

		$this->add_control(
			'subtitle_color',
			array(
				'label'     => esc_html__( 'Subtitle Color', 'storeberry-ai-feature-tabs' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .saft-subtitle' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'subtitle_typography',
				'label'    => esc_html__( 'Subtitle Typography', 'storeberry-ai-feature-tabs' ),
				'selector' => '{{WRAPPER}} .saft-subtitle',
			)
		);

		$this->add_responsive_control(
			'header_spacing',
			array(
				'label'      => esc_html__( 'Header Spacing', 'storeberry-ai-feature-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 120 ),
				),
				'default'        => array( 'unit' => 'px', 'size' => 48 ),
				'tablet_default' => array( 'unit' => 'px', 'size' => 32 ),
				'mobile_default' => array( 'unit' => 'px', 'size' => 24 ),
				'selectors'  => array(
					'{{WRAPPER}} .saft-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_layout',
			array(
				'label' => esc_html__( 'Layout Style', 'storeberry-ai-feature-tabs' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'layout_direction',
			array(
				'label'          => esc_html__( 'Layout', 'storeberry-ai-feature-tabs' ),
				'type'           => \Elementor\Controls_Manager::SELECT,
				'default'        => 'side',
				'tablet_default' => 'stack',
				'mobile_default' => 'stack',
				'options'        => array(
					'side'  => esc_html__( 'Side by Side', 'storeberry-ai-feature-tabs' ),
					'stack' => esc_html__( 'Stacked', 'storeberry-ai-feature-tabs' ),
				),
				'prefix_class'   => 'saft-layout-%s',
			)
		);

		$this->add_responsive_control(
			'nav_width',
			array(
				'label'      => esc_html__( 'Left Nav Width', 'storeberry-ai-feature-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px', 'fr' ),
				'range'      => array(
					'%'  => array( 'min' => 10, 'max' => 80 ),
					'px' => array( 'min' => 120, 'max' => 900 ),
					'fr' => array( 'min' => 1, 'max' => 10, 'step' => 0.1 ),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 42,
				),
				'condition'  => array(
					'layout_direction' => 'side',
				),
				'selectors'  => array(
					'{{WRAPPER}} .saft-section' => '--saft-nav-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'content_max_width',
			array(
				'label'      => esc_html__( 'Content Max Width', 'storeberry-ai-feature-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'range'      => array(
					'%'  => array( 'min' => 10, 'max' => 100 ),
					'px' => array( 'min' => 120, 'max' => 1600 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .saft-panels' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'content_alignment_self',
			array(
				'label'                => esc_html__( 'Content Horizontal Align', 'storeberry-ai-feature-tabs' ),
				'type'                 => \Elementor\Controls_Manager::SELECT,
				'default'              => 'stretch',
				'options'              => array(
					'stretch' => esc_html__( 'Stretch', 'storeberry-ai-feature-tabs' ),
					'start'   => esc_html__( 'Start', 'storeberry-ai-feature-tabs' ),
					'center'  => esc_html__( 'Center', 'storeberry-ai-feature-tabs' ),
					'end'     => esc_html__( 'End', 'storeberry-ai-feature-tabs' ),
				),
				'selectors_dictionary' => array(
					'stretch' => 'stretch',
					'start'   => 'start',
					'center'  => 'center',
					'end'     => 'end',
				),
				'selectors'            => array(
					'{{WRAPPER}} .saft-panels' => 'justify-self: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'column_gap',
			array(
				'label'      => esc_html__( 'Column Gap', 'storeberry-ai-feature-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 120 ),
				),
				'default'        => array( 'unit' => 'px', 'size' => 32 ),
				'tablet_default' => array( 'unit' => 'px', 'size' => 0 ),
				'mobile_default' => array( 'unit' => 'px', 'size' => 0 ),
				'selectors'  => array(
					'{{WRAPPER}} .saft-layout' => 'column-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'row_gap',
			array(
				'label'      => esc_html__( 'Row Gap (Stacked)', 'storeberry-ai-feature-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 120 ),
				),
				'default'        => array( 'unit' => 'px', 'size' => 0 ),
				'tablet_default' => array( 'unit' => 'px', 'size' => 24 ),
				'mobile_default' => array( 'unit' => 'px', 'size' => 16 ),
				'selectors'  => array(
					'{{WRAPPER}} .saft-layout' => 'row-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_tab_nav',
			array(
				'label' => esc_html__( 'Tab Nav Style', 'storeberry-ai-feature-tabs' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'tab_gap',
			array(
				'label'      => esc_html__( 'Tab Gap', 'storeberry-ai-feature-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 80 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .saft-nav' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'tab_padding',
			array(
				'label'      => esc_html__( 'Tab Padding', 'storeberry-ai-feature-tabs' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'top'      => '24',
					'right'    => '28',
					'bottom'   => '24',
					'left'     => '28',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'top'      => '16',
					'right'    => '18',
					'bottom'   => '16',
					'left'     => '18',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .saft-tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'active_tab_bg_fallback',
			array(
				'label'     => esc_html__( 'Active Tab Background', 'storeberry-ai-feature-tabs' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .saft-section' => '--saft-active-bg-fallback: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'active_tab_text_fallback',
			array(
				'label'     => esc_html__( 'Active Tab Text Color', 'storeberry-ai-feature-tabs' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .saft-section' => '--saft-active-color-fallback: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'inactive_tab_bg_fallback',
			array(
				'label'     => esc_html__( 'Inactive Tab Background', 'storeberry-ai-feature-tabs' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .saft-section' => '--saft-inactive-bg-fallback: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'inactive_tab_text_fallback',
			array(
				'label'     => esc_html__( 'Inactive Tab Text Color', 'storeberry-ai-feature-tabs' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .saft-section' => '--saft-inactive-color-fallback: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'tab_border_radius',
			array(
				'label'      => esc_html__( 'Tab Border Radius', 'storeberry-ai-feature-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 80 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .saft-tab' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'tab_number_spacing',
			array(
				'label'      => esc_html__( 'Number Spacing', 'storeberry-ai-feature-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 40 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .saft-tab-number' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'tab_number_typography',
				'label'    => esc_html__( 'Number Typography', 'storeberry-ai-feature-tabs' ),
				'selector' => '{{WRAPPER}} .saft-tab-number',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'tab_title_typography',
				'label'    => esc_html__( 'Title Typography', 'storeberry-ai-feature-tabs' ),
				'selector' => '{{WRAPPER}} .saft-tab-title',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'tab_desc_typography',
				'label'    => esc_html__( 'Description Typography', 'storeberry-ai-feature-tabs' ),
				'selector' => '{{WRAPPER}} .saft-tab-desc',
			)
		);

		$this->add_responsive_control(
			'tab_desc_spacing',
			array(
				'label'      => esc_html__( 'Description Spacing', 'storeberry-ai-feature-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 40 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .saft-tab-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			array(
				'label' => esc_html__( 'Content Style', 'storeberry-ai-feature-tabs' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'content_border_radius',
			array(
				'label'      => esc_html__( 'Content Border Radius', 'storeberry-ai-feature-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 80 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .saft-panel' => 'border-radius: {{SIZE}}{{UNIT}}; overflow: hidden;',
					'{{WRAPPER}} .saft-content-image' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'content_image_width',
			array(
				'label'      => esc_html__( 'Content Image Width', 'storeberry-ai-feature-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'range'      => array(
					'%'  => array( 'min' => 10, 'max' => 100 ),
					'px' => array( 'min' => 80, 'max' => 1600 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .saft-content-image' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'content_image_max_height',
			array(
				'label'      => esc_html__( 'Content Image Max Height', 'storeberry-ai-feature-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'vh' ),
				'range'      => array(
					'px' => array( 'min' => 80, 'max' => 1200 ),
					'vh' => array( 'min' => 10, 'max' => 100 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .saft-content-image' => 'max-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'content_padding',
			array(
				'label'      => esc_html__( 'Content Padding', 'storeberry-ai-feature-tabs' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .saft-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'content_alignment',
			array(
				'label'     => esc_html__( 'Content Alignment', 'storeberry-ai-feature-tabs' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'storeberry-ai-feature-tabs' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'storeberry-ai-feature-tabs' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'storeberry-ai-feature-tabs' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .saft-panel' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Build inline CSS variables for a tab button.
	 *
	 * @param array $tab Tab settings.
	 * @return string
	 */
	private function get_tab_inline_style( $tab ) {
		$styles = array();

		if ( ! empty( $tab['active_bg_color'] ) ) {
			$styles[] = '--saft-tab-active-bg: ' . sanitize_hex_color( $tab['active_bg_color'] ) . ';';
		}

		if ( ! empty( $tab['active_text_color'] ) ) {
			$styles[] = '--saft-tab-active-color: ' . sanitize_hex_color( $tab['active_text_color'] ) . ';';
		}

		if ( ! empty( $tab['inactive_text_color'] ) ) {
			$styles[] = '--saft-tab-inactive-color: ' . sanitize_hex_color( $tab['inactive_text_color'] ) . ';';
		}

		return implode( ' ', $styles );
	}

	/**
	 * Render tab panel content by content type.
	 *
	 * @param array $tab Tab settings.
	 */
	private function render_tab_content( $tab ) {
		$content_type = isset( $tab['content_type'] ) ? $tab['content_type'] : 'image';

		if ( 'template' === $content_type ) {
			$template_id = ! empty( $tab['elementor_template'] ) ? absint( $tab['elementor_template'] ) : 0;

			if ( $template_id && 'publish' === get_post_status( $template_id ) ) {
				echo '<div class="saft-content-template">';
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor builder output.
				echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template_id );
				echo '</div>';
			}

			return;
		}

		if ( 'wysiwyg' === $content_type ) {
			if ( ! empty( $tab['content_wysiwyg'] ) ) {
				echo '<div class="saft-content-wysiwyg">';
				echo wp_kses_post( $tab['content_wysiwyg'] );
				echo '</div>';
			}

			return;
		}

		$image_url = '';
		$image_alt = '';

		if ( ! empty( $tab['content_image']['url'] ) ) {
			$image_url = $tab['content_image']['url'];
		}

		if ( ! empty( $tab['content_image']['id'] ) ) {
			$image_alt = get_post_meta( absint( $tab['content_image']['id'] ), '_wp_attachment_image_alt', true );
		}

		if ( empty( $image_alt ) && ! empty( $tab['tab_title'] ) ) {
			$image_alt = $tab['tab_title'];
		}

		if ( ! empty( $image_url ) ) {
			printf(
				'<img class="saft-content-image" src="%1$s" alt="%2$s" loading="lazy" />',
				esc_url( $image_url ),
				esc_attr( $image_alt )
			);
		}
	}

	/**
	 * Render widget output.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$tabs     = ! empty( $settings['tabs'] ) && is_array( $settings['tabs'] ) ? $settings['tabs'] : array();

		if ( empty( $tabs ) ) {
			return;
		}

		$widget_id     = $this->get_id();
		$default_tab   = ! empty( $settings['default_active_tab'] ) ? absint( $settings['default_active_tab'] ) : 1;
		$default_index = max( 0, $default_tab - 1 );

		if ( $default_index >= count( $tabs ) ) {
			$default_index = 0;
		}

		$instance_id  = 'saft-' . esc_attr( $widget_id );
		$element_id   = esc_attr( $this->get_id() );
		$responsive_css = sprintf(
			'@media (max-width:1024px){.elementor-element-%1$s .saft-section .saft-layout{grid-template-columns:minmax(0,1fr)!important;row-gap:24px!important;column-gap:0!important}.elementor-element-%1$s .saft-section .saft-nav,.elementor-element-%1$s .saft-section .saft-panels{width:100%%!important;max-width:100%%!important;justify-self:stretch!important;grid-column:1/-1!important}}@media (max-width:767px){.elementor-element-%1$s .saft-section .saft-layout{row-gap:16px!important}}',
			$element_id
		);
		?>
		<style id="saft-responsive-<?php echo $element_id; ?>"><?php echo $responsive_css; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></style>
		<div class="saft-section" data-default-tab="<?php echo esc_attr( (string) $default_index ); ?>">
			<div class="saft-inner">
				<?php if ( ! empty( $settings['heading'] ) || ! empty( $settings['subtitle'] ) ) : ?>
					<div class="saft-header">
						<?php if ( ! empty( $settings['heading'] ) ) : ?>
							<h2 class="saft-heading"><?php echo esc_html( $settings['heading'] ); ?></h2>
						<?php endif; ?>

						<?php if ( ! empty( $settings['subtitle'] ) ) : ?>
							<p class="saft-subtitle"><?php echo esc_html( $settings['subtitle'] ); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<div class="saft-layout">
					<div class="saft-nav" role="tablist" aria-label="<?php echo esc_attr__( 'Feature tabs', 'storeberry-ai-feature-tabs' ); ?>">
						<?php foreach ( $tabs as $index => $tab ) : ?>
							<?php
							$is_active   = (int) $index === (int) $default_index;
							$tab_id      = $instance_id . '-tab-' . (int) $index;
							$panel_id    = $instance_id . '-panel-' . (int) $index;
							$tab_style   = $this->get_tab_inline_style( $tab );
							$tab_classes = 'saft-tab' . ( $is_active ? ' is-active' : '' );
							?>
							<div
								id="<?php echo esc_attr( $tab_id ); ?>"
								class="<?php echo esc_attr( $tab_classes ); ?>"
								role="tab"
								aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
								aria-controls="<?php echo esc_attr( $panel_id ); ?>"
								tabindex="<?php echo $is_active ? '0' : '-1'; ?>"
								data-tab-index="<?php echo esc_attr( (string) $index ); ?>"
								<?php echo $tab_style ? 'style="' . esc_attr( $tab_style ) . '"' : ''; ?>
							>
								<?php if ( ! empty( $tab['tab_number'] ) ) : ?>
									<span class="saft-tab-number"><?php echo esc_html( $tab['tab_number'] ); ?></span>
								<?php endif; ?>

								<?php if ( ! empty( $tab['tab_title'] ) ) : ?>
									<span class="saft-tab-title"><?php echo esc_html( $tab['tab_title'] ); ?></span>
								<?php endif; ?>

								<?php if ( ! empty( $tab['tab_description'] ) ) : ?>
									<span class="saft-tab-desc"><?php echo esc_html( $tab['tab_description'] ); ?></span>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>

					<div class="saft-panels">
						<?php foreach ( $tabs as $index => $tab ) : ?>
							<?php
							$is_active   = (int) $index === (int) $default_index;
							$tab_id      = $instance_id . '-tab-' . (int) $index;
							$panel_id    = $instance_id . '-panel-' . (int) $index;
							$panel_class = 'saft-panel' . ( $is_active ? ' is-active' : '' );
							?>
							<div
								id="<?php echo esc_attr( $panel_id ); ?>"
								class="<?php echo esc_attr( $panel_class ); ?>"
								role="tabpanel"
								aria-labelledby="<?php echo esc_attr( $tab_id ); ?>"
								<?php echo $is_active ? '' : 'hidden'; ?>
							>
								<?php $this->render_tab_content( $tab ); ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
