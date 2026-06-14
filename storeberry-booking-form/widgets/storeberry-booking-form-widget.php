<?php
/**
 * Storeberry Booking Form – Elementor Widget.
 *
 * @package Storeberry_Booking_Form
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Booking form widget for Elementor.
 */
class Storeberry_Booking_Form_Widget extends \Elementor\Widget_Base {

	/**
	 * Widget slug.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'storeberry_booking_form';
	}

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Storeberry Booking Form', 'storeberry-booking-form' );
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-form-horizontal';
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
		return array( 'form', 'booking', 'contact', 'storeberry', 'email' );
	}

	/**
	 * Style dependencies.
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return array( 'storeberry-booking-form' );
	}

	/**
	 * Script dependencies.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array( 'storeberry-booking-form' );
	}

	/**
	 * Default country codes.
	 *
	 * @return array
	 */
	private function get_default_country_codes() {
		return array(
			array( 'code' => '+852' ),
			array( 'code' => '+62' ),
			array( 'code' => '+65' ),
			array( 'code' => '+60' ),
			array( 'code' => '+1' ),
			array( 'code' => '+44' ),
		);
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
			'section_form_fields',
			array(
				'label' => esc_html__( 'Form Fields', 'storeberry-booking-form' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'name_placeholder',
			array(
				'label'       => esc_html__( 'Name Placeholder', 'storeberry-booking-form' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( '名字', 'storeberry-booking-form' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'email_placeholder',
			array(
				'label'       => esc_html__( 'Email Placeholder', 'storeberry-booking-form' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( '電郵', 'storeberry-booking-form' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'phone_placeholder',
			array(
				'label'       => esc_html__( 'Phone Placeholder', 'storeberry-booking-form' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( '電話號碼', 'storeberry-booking-form' ),
				'label_block' => true,
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'code',
			array(
				'label'       => esc_html__( 'Country Code', 'storeberry-booking-form' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '+852',
				'label_block' => true,
			)
		);

		$this->add_control(
			'country_codes',
			array(
				'label'       => esc_html__( 'Country Codes', 'storeberry-booking-form' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => $this->get_default_country_codes(),
				'title_field' => '{{{ code }}}',
			)
		);

		$this->add_control(
			'default_country_code',
			array(
				'label'       => esc_html__( 'Default Country Code', 'storeberry-booking-form' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '+852',
				'label_block' => true,
			)
		);

		$this->add_control(
			'submit_text',
			array(
				'label'       => esc_html__( 'Submit Button Text', 'storeberry-booking-form' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( '預約專人示範', 'storeberry-booking-form' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'submit_loading_text',
			array(
				'label'       => esc_html__( 'Submit Loading Text', 'storeberry-booking-form' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Sending...', 'storeberry-booking-form' ),
				'label_block' => true,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_email_settings',
			array(
				'label' => esc_html__( 'Email Settings', 'storeberry-booking-form' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'recipient_email',
			array(
				'label'       => esc_html__( 'Recipient Email', 'storeberry-booking-form' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => get_option( 'admin_email' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'email_subject',
			array(
				'label'       => esc_html__( 'Email Subject', 'storeberry-booking-form' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'New Storeberry Booking Form Submission', 'storeberry-booking-form' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'success_message',
			array(
				'label'       => esc_html__( 'Success Message', 'storeberry-booking-form' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Thank you. Your submission has been sent.', 'storeberry-booking-form' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'error_message',
			array(
				'label'       => esc_html__( 'Error Message', 'storeberry-booking-form' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Something went wrong. Please try again.', 'storeberry-booking-form' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'required_message',
			array(
				'label'       => esc_html__( 'Required Field Message', 'storeberry-booking-form' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Please fill in all required fields.', 'storeberry-booking-form' ),
				'label_block' => true,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_form_behavior',
			array(
				'label' => esc_html__( 'Form Behavior', 'storeberry-booking-form' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'name_required',
			array(
				'label'        => esc_html__( 'Name Required', 'storeberry-booking-form' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'storeberry-booking-form' ),
				'label_off'    => esc_html__( 'No', 'storeberry-booking-form' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'email_required',
			array(
				'label'        => esc_html__( 'Email Required', 'storeberry-booking-form' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'storeberry-booking-form' ),
				'label_off'    => esc_html__( 'No', 'storeberry-booking-form' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'phone_required',
			array(
				'label'        => esc_html__( 'Phone Required', 'storeberry-booking-form' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'storeberry-booking-form' ),
				'label_off'    => esc_html__( 'No', 'storeberry-booking-form' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'button_full_width_mobile',
			array(
				'label'        => esc_html__( 'Button Full Width on Mobile', 'storeberry-booking-form' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'storeberry-booking-form' ),
				'label_off'    => esc_html__( 'No', 'storeberry-booking-form' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Style tab controls.
	 */
	private function register_style_controls() {
		$this->start_controls_section(
			'section_style_layout',
			array(
				'label' => esc_html__( 'Form Layout', 'storeberry-booking-form' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'form_max_width',
			array(
				'label'      => esc_html__( 'Form Max Width', 'storeberry-booking-form' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 200, 'max' => 1200 ),
					'%'  => array( 'min' => 10, 'max' => 100 ),
				),
				'default'    => array( 'unit' => '%', 'size' => 100 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-booking-form-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'field_gap',
			array(
				'label'      => esc_html__( 'Field Gap', 'storeberry-booking-form' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 60 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 18 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-booking-form' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'phone_row_gap',
			array(
				'label'      => esc_html__( 'Phone Row Gap', 'storeberry-booking-form' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 40 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 14 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-booking-form-wrap' => '--sb-booking-phone-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'country_code_width',
			array(
				'label'      => esc_html__( 'Country Code Width', 'storeberry-booking-form' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 80, 'max' => 200 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 130 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-booking-form-wrap' => '--sb-booking-country-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'form_alignment',
			array(
				'label'     => esc_html__( 'Form Alignment', 'storeberry-booking-form' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'storeberry-booking-form' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'storeberry-booking-form' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'storeberry-booking-form' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'selectors_dictionary' => array(
					'left'   => 'margin-right: auto; margin-left: 0;',
					'center' => 'margin-left: auto; margin-right: auto;',
					'right'  => 'margin-left: auto; margin-right: 0;',
				),
				'selectors' => array(
					'{{WRAPPER}} .sb-booking-form-wrap' => '{{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_input',
			array(
				'label' => esc_html__( 'Input Style', 'storeberry-booking-form' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'input_height',
			array(
				'label'      => esc_html__( 'Input Height', 'storeberry-booking-form' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 36, 'max' => 80 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 56 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-booking-form__input, {{WRAPPER}} .sb-booking-form__select' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'input_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'storeberry-booking-form' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => array(
					'{{WRAPPER}} .sb-booking-form__input, {{WRAPPER}} .sb-booking-form__select' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'input_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'storeberry-booking-form' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111111',
				'selectors' => array(
					'{{WRAPPER}} .sb-booking-form__input, {{WRAPPER}} .sb-booking-form__select' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'input_placeholder_color',
			array(
				'label'     => esc_html__( 'Placeholder Color', 'storeberry-booking-form' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#888888',
				'selectors' => array(
					'{{WRAPPER}} .sb-booking-form__input::placeholder' => 'color: {{VALUE}}; opacity: 1;',
				),
			)
		);

		$this->add_control(
			'input_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'storeberry-booking-form' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#B8B8B8',
				'selectors' => array(
					'{{WRAPPER}} .sb-booking-form__input, {{WRAPPER}} .sb-booking-form__select' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'input_border_width',
			array(
				'label'      => esc_html__( 'Border Width', 'storeberry-booking-form' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 6 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 1 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-booking-form__input, {{WRAPPER}} .sb-booking-form__select' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;',
				),
			)
		);

		$this->add_responsive_control(
			'input_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'storeberry-booking-form' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 40 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 4 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-booking-form__input, {{WRAPPER}} .sb-booking-form__select' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'input_padding',
			array(
				'label'      => esc_html__( 'Padding', 'storeberry-booking-form' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'top'      => '0',
					'right'    => '20',
					'bottom'   => '0',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-booking-form__input, {{WRAPPER}} .sb-booking-form__select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'input_typography',
				'selector'       => '{{WRAPPER}} .sb-booking-form__input, {{WRAPPER}} .sb-booking-form__select',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array(
						'default' => array(
							'unit' => 'px',
							'size' => 18,
						),
					),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			array(
				'label' => esc_html__( 'Button Style', 'storeberry-booking-form' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'button_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'storeberry-booking-form' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#E6005C',
				'selectors' => array(
					'{{WRAPPER}} .sb-booking-form__submit' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_bg_hover_color',
			array(
				'label'     => esc_html__( 'Hover Background Color', 'storeberry-booking-form' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#D10053',
				'selectors' => array(
					'{{WRAPPER}} .sb-booking-form__submit:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .sb-booking-form__submit:focus-visible' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'storeberry-booking-form' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => array(
					'{{WRAPPER}} .sb-booking-form__submit' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_height',
			array(
				'label'      => esc_html__( 'Button Height', 'storeberry-booking-form' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 40, 'max' => 100 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 66 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-booking-form__submit' => 'height: {{SIZE}}{{UNIT}}; min-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_min_width',
			array(
				'label'      => esc_html__( 'Button Min Width', 'storeberry-booking-form' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 120, 'max' => 480 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 240 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-booking-form__submit' => 'min-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'storeberry-booking-form' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'top'      => '0',
					'right'    => '42',
					'bottom'   => '0',
					'left'     => '42',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-booking-form__submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'storeberry-booking-form' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 999 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 999 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-booking-form__submit' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .sb-booking-form__submit',
			)
		);

		$this->add_control(
			'button_box_shadow',
			array(
				'label'        => esc_html__( 'Button Box Shadow', 'storeberry-booking-form' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'storeberry-booking-form' ),
				'label_off'    => esc_html__( 'No', 'storeberry-booking-form' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_responsive_control(
			'button_margin_top',
			array(
				'label'      => esc_html__( 'Button Margin Top', 'storeberry-booking-form' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 80 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-booking-form__submit' => 'margin-top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_message',
			array(
				'label' => esc_html__( 'Message Style', 'storeberry-booking-form' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'success_color',
			array(
				'label'     => esc_html__( 'Success Color', 'storeberry-booking-form' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#059669',
				'selectors' => array(
					'{{WRAPPER}} .sb-booking-form__message.is-success' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'error_color',
			array(
				'label'     => esc_html__( 'Error Color', 'storeberry-booking-form' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#DC2626',
				'selectors' => array(
					'{{WRAPPER}} .sb-booking-form__message.is-error' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'message_typography',
				'selector' => '{{WRAPPER}} .sb-booking-form__message',
			)
		);

		$this->add_responsive_control(
			'message_margin_top',
			array(
				'label'      => esc_html__( 'Message Margin Top', 'storeberry-booking-form' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 60 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 12 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-booking-form__message' => 'margin-top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Sanitize country code for output.
	 *
	 * @param string $code Raw code.
	 * @return string
	 */
	private function sanitize_country_code( $code ) {
		$code = trim( (string) $code );
		if ( preg_match( '/^\+[0-9]{1,4}$/', $code ) ) {
			return $code;
		}
		return '';
	}

	/**
	 * Get sanitized country codes from settings.
	 *
	 * @param array $settings Widget settings.
	 * @return array
	 */
	private function get_country_codes( $settings ) {
		$codes = array();

		if ( ! empty( $settings['country_codes'] ) && is_array( $settings['country_codes'] ) ) {
			foreach ( $settings['country_codes'] as $item ) {
				if ( empty( $item['code'] ) ) {
					continue;
				}
				$code = $this->sanitize_country_code( $item['code'] );
				if ( '' !== $code ) {
					$codes[] = $code;
				}
			}
		}

		if ( empty( $codes ) ) {
			$codes = array( '+852', '+62', '+65', '+60', '+1', '+44' );
		}

		return array_values( array_unique( $codes ) );
	}

	/**
	 * Render widget output.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$country_codes = $this->get_country_codes( $settings );
		$default_code  = $this->sanitize_country_code( isset( $settings['default_country_code'] ) ? $settings['default_country_code'] : '+852' );

		if ( '' === $default_code || ! in_array( $default_code, $country_codes, true ) ) {
			$default_code = $country_codes[0];
		}

		$form_classes = array( 'sb-booking-form' );
		if ( ! empty( $settings['button_full_width_mobile'] ) && 'yes' === $settings['button_full_width_mobile'] ) {
			$form_classes[] = 'sb-booking-form--btn-full-mobile';
		}
		if ( ! empty( $settings['button_box_shadow'] ) && 'yes' === $settings['button_box_shadow'] ) {
			$form_classes[] = 'sb-booking-form--btn-shadow';
		}

		$recipient = ! empty( $settings['recipient_email'] ) ? sanitize_email( $settings['recipient_email'] ) : get_option( 'admin_email' );
		if ( ! is_email( $recipient ) ) {
			$recipient = get_option( 'admin_email' );
		}
		?>
		<div
			class="sb-booking-form-wrap"
			data-recipient="<?php echo esc_attr( $recipient ); ?>"
			data-subject="<?php echo esc_attr( ! empty( $settings['email_subject'] ) ? $settings['email_subject'] : '' ); ?>"
			data-success-message="<?php echo esc_attr( ! empty( $settings['success_message'] ) ? $settings['success_message'] : '' ); ?>"
			data-error-message="<?php echo esc_attr( ! empty( $settings['error_message'] ) ? $settings['error_message'] : '' ); ?>"
			data-required-message="<?php echo esc_attr( ! empty( $settings['required_message'] ) ? $settings['required_message'] : '' ); ?>"
			data-name-required="<?php echo ( ! empty( $settings['name_required'] ) && 'yes' === $settings['name_required'] ) ? '1' : '0'; ?>"
			data-email-required="<?php echo ( ! empty( $settings['email_required'] ) && 'yes' === $settings['email_required'] ) ? '1' : '0'; ?>"
			data-phone-required="<?php echo ( ! empty( $settings['phone_required'] ) && 'yes' === $settings['phone_required'] ) ? '1' : '0'; ?>"
		>
			<form class="<?php echo esc_attr( implode( ' ', $form_classes ) ); ?>" method="post" novalidate>
				<div class="sb-booking-form__field">
					<input
						type="text"
						class="sb-booking-form__input"
						name="name"
						placeholder="<?php echo esc_attr( ! empty( $settings['name_placeholder'] ) ? $settings['name_placeholder'] : '' ); ?>"
						<?php echo ( ! empty( $settings['name_required'] ) && 'yes' === $settings['name_required'] ) ? 'required aria-required="true"' : ''; ?>
						autocomplete="name"
					/>
				</div>

				<div class="sb-booking-form__field">
					<input
						type="email"
						class="sb-booking-form__input"
						name="email"
						placeholder="<?php echo esc_attr( ! empty( $settings['email_placeholder'] ) ? $settings['email_placeholder'] : '' ); ?>"
						<?php echo ( ! empty( $settings['email_required'] ) && 'yes' === $settings['email_required'] ) ? 'required aria-required="true"' : ''; ?>
						autocomplete="email"
					/>
				</div>

				<div class="sb-booking-form__phone-row">
					<div class="sb-booking-form__country-field">
						<select class="sb-booking-form__select" name="country_code" aria-label="<?php echo esc_attr__( 'Country code', 'storeberry-booking-form' ); ?>">
							<?php foreach ( $country_codes as $code ) : ?>
								<option value="<?php echo esc_attr( $code ); ?>" <?php selected( $default_code, $code ); ?>>
									<?php echo esc_html( $code ); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="sb-booking-form__phone-field">
						<input
							type="tel"
							class="sb-booking-form__input"
							name="phone"
							placeholder="<?php echo esc_attr( ! empty( $settings['phone_placeholder'] ) ? $settings['phone_placeholder'] : '' ); ?>"
							<?php echo ( ! empty( $settings['phone_required'] ) && 'yes' === $settings['phone_required'] ) ? 'required aria-required="true"' : ''; ?>
							autocomplete="tel-national"
							inputmode="tel"
						/>
					</div>
				</div>

				<button
					type="submit"
					class="sb-booking-form__submit"
					data-loading-text="<?php echo esc_attr( ! empty( $settings['submit_loading_text'] ) ? $settings['submit_loading_text'] : esc_html__( 'Sending...', 'storeberry-booking-form' ) ); ?>"
				>
					<?php echo esc_html( ! empty( $settings['submit_text'] ) ? $settings['submit_text'] : esc_html__( 'Submit', 'storeberry-booking-form' ) ); ?>
				</button>

				<div class="sb-booking-form__message" aria-live="polite"></div>
			</form>
		</div>
		<?php
	}
}
