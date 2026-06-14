<?php
/**
 * Inject Storeberry gradient controls into native Elementor Container.
 *
 * @package Storeberry_Gradient_Bg_Container
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add Storeberry gradient section to Container element.
 *
 * @param \Elementor\Controls_Stack $element Container element instance.
 */
function storeberry_gbc_add_container_gradient_controls( $element ) {
	$element->start_controls_section(
		'section_storeberry_gradient',
		array(
			'label' => esc_html__( 'Storeberry Gradient', 'storeberry-gradient-bg-container' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		)
	);

	$element->add_control(
		'sb_enable_gradient',
		array(
			'label'        => esc_html__( 'Enable Storeberry Gradient', 'storeberry-gradient-bg-container' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'storeberry-gradient-bg-container' ),
			'label_off'    => esc_html__( 'No', 'storeberry-gradient-bg-container' ),
			'return_value' => 'yes',
			'default'      => '',
			'prefix_class' => 'sb-gradient-enabled-',
		)
	);

	$element->add_control(
		'sb_gradient_note',
		array(
			'type'            => \Elementor\Controls_Manager::RAW_HTML,
			'raw'             => '<p style="margin:0;">'
				. esc_html__( 'Use a Container as your top-level section. Enable this gradient, then add widgets inside the same Container.', 'storeberry-gradient-bg-container' )
				. '</p>',
			'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			'condition'       => array(
				'sb_enable_gradient' => 'yes',
			),
		)
	);

	$element->add_control(
		'sb_gradient_color_1',
		array(
			'label'     => esc_html__( 'Color 1', 'storeberry-gradient-bg-container' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#EEE05F',
			'selectors' => array(
				'{{WRAPPER}}' => '--sb-grad-color-1: {{VALUE}};',
			),
			'condition' => array(
				'sb_enable_gradient' => 'yes',
			),
		)
	);

	$element->add_control(
		'sb_gradient_color_2',
		array(
			'label'     => esc_html__( 'Color 2', 'storeberry-gradient-bg-container' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#766CD2',
			'selectors' => array(
				'{{WRAPPER}}' => '--sb-grad-color-2: {{VALUE}};',
			),
			'condition' => array(
				'sb_enable_gradient' => 'yes',
			),
		)
	);

	$element->add_control(
		'sb_gradient_color_3',
		array(
			'label'     => esc_html__( 'Color 3', 'storeberry-gradient-bg-container' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FB636E',
			'selectors' => array(
				'{{WRAPPER}}' => '--sb-grad-color-3: {{VALUE}};',
			),
			'condition' => array(
				'sb_enable_gradient' => 'yes',
			),
		)
	);

	$element->add_control(
		'sb_gradient_angle',
		array(
			'label'      => esc_html__( 'Gradient Angle', 'storeberry-gradient-bg-container' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array( 'px' ),
			'range'      => array(
				'px' => array( 'min' => 0, 'max' => 360 ),
			),
			'default'    => array( 'unit' => 'px', 'size' => 90 ),
			'selectors'  => array(
				'{{WRAPPER}}' => '--sb-grad-angle: {{SIZE}}deg;',
			),
			'condition'  => array(
				'sb_enable_gradient' => 'yes',
			),
		)
	);

	$element->add_control(
		'sb_gradient_opacity',
		array(
			'label'      => esc_html__( 'Gradient Opacity (%)', 'storeberry-gradient-bg-container' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array( 'px' ),
			'range'      => array(
				'px' => array( 'min' => 0, 'max' => 100, 'step' => 1 ),
			),
			'default'    => array( 'unit' => 'px', 'size' => 20 ),
			'selectors'  => array(
				'{{WRAPPER}}' => '--sb-grad-opacity: calc({{SIZE}} / 100);',
			),
			'condition'  => array(
				'sb_enable_gradient' => 'yes',
			),
		)
	);

	$element->add_control(
		'sb_gradient_blur',
		array(
			'label'      => esc_html__( 'Blur', 'storeberry-gradient-bg-container' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array( 'px' ),
			'range'      => array(
				'px' => array( 'min' => 0, 'max' => 200 ),
			),
			'default'    => array( 'unit' => 'px', 'size' => 80 ),
			'selectors'  => array(
				'{{WRAPPER}}' => '--sb-grad-blur: {{SIZE}}{{UNIT}}; --sb-grad-inset: {{SIZE}};',
			),
			'condition'  => array(
				'sb_enable_gradient' => 'yes',
			),
		)
	);

	$element->add_control(
		'sb_gradient_scale',
		array(
			'label'      => esc_html__( 'Gradient Scale (%)', 'storeberry-gradient-bg-container' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array( 'px' ),
			'range'      => array(
				'px' => array( 'min' => 50, 'max' => 300, 'step' => 1 ),
			),
			'default'    => array( 'unit' => 'px', 'size' => 115 ),
			'selectors'  => array(
				'{{WRAPPER}}' => '--sb-grad-scale: calc({{SIZE}} / 100);',
			),
			'condition'  => array(
				'sb_enable_gradient' => 'yes',
			),
		)
	);

	$element->end_controls_section();
}

add_action(
	'elementor/element/container/section_background/after_section_end',
	'storeberry_gbc_add_container_gradient_controls',
	10,
	1
);
