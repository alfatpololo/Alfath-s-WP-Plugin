<?php
/**
 * Storeberry Highlight Heading – Elementor Widget.
 *
 * @package Storeberry_Highlight_Heading
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Highlighted heading widget for Elementor.
 */
class Storeberry_Highlight_Heading_Widget extends \Elementor\Widget_Base {

	/**
	 * Widget slug.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'storeberry_highlight_heading';
	}

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Storeberry Highlight Heading', 'storeberry-highlight-heading' );
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-heading';
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
		return array( 'heading', 'title', 'highlight', 'storeberry', 'text' );
	}

	/**
	 * Style dependencies.
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return array( 'storeberry-highlight-heading' );
	}

	/**
	 * Allowed HTML tags.
	 *
	 * @return array
	 */
	private function get_html_tag_options() {
		return array(
			'h1'  => 'H1',
			'h2'  => 'H2',
			'h3'  => 'H3',
			'h4'  => 'H4',
			'h5'  => 'H5',
			'h6'  => 'H6',
			'div' => 'div',
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
			'section_heading_content',
			array(
				'label' => esc_html__( 'Heading Content', 'storeberry-highlight-heading' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'line_one',
			array(
				'label'       => esc_html__( 'First Line', 'storeberry-highlight-heading' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( '您的品牌生意', 'storeberry-highlight-heading' ),
				'label_block' => true,
				'dynamic'     => array( 'active' => true ),
			)
		);

		$this->add_control(
			'line_two_prefix',
			array(
				'label'       => esc_html__( 'Second Line Prefix', 'storeberry-highlight-heading' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( '值得', 'storeberry-highlight-heading' ),
				'label_block' => true,
				'dynamic'     => array( 'active' => true ),
			)
		);

		$this->add_control(
			'highlight_text',
			array(
				'label'       => esc_html__( 'Highlight Text', 'storeberry-highlight-heading' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( '更專業', 'storeberry-highlight-heading' ),
				'label_block' => true,
				'dynamic'     => array( 'active' => true ),
			)
		);

		$this->add_control(
			'line_two_suffix',
			array(
				'label'       => esc_html__( 'Second Line Suffix', 'storeberry-highlight-heading' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( '的配置', 'storeberry-highlight-heading' ),
				'label_block' => true,
				'dynamic'     => array( 'active' => true ),
			)
		);

		$this->add_control(
			'html_tag',
			array(
				'label'   => esc_html__( 'HTML Tag', 'storeberry-highlight-heading' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => $this->get_html_tag_options(),
			)
		);

		$this->add_responsive_control(
			'alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'storeberry-highlight-heading' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'storeberry-highlight-heading' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'storeberry-highlight-heading' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'storeberry-highlight-heading' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'selectors' => array(
					'{{WRAPPER}} .sb-highlight-heading' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'enable_line_break',
			array(
				'label'        => esc_html__( 'Enable Line Break', 'storeberry-highlight-heading' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'storeberry-highlight-heading' ),
				'label_off'    => esc_html__( 'No', 'storeberry-highlight-heading' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Style tab controls.
	 */
	private function register_style_controls() {
		$this->start_controls_section(
			'section_style_normal',
			array(
				'label' => esc_html__( 'Normal Text Style', 'storeberry-highlight-heading' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'normal_color',
			array(
				'label'     => esc_html__( 'Text Color', 'storeberry-highlight-heading' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => array(
					'{{WRAPPER}} .sb-highlight-heading' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sb-highlight-heading-normal' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'normal_typography',
				'selector'       => '{{WRAPPER}} .sb-highlight-heading, {{WRAPPER}} .sb-highlight-heading-normal',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array(
						'default' => array(
							'unit' => 'px',
							'size' => 40,
						),
					),
					'font_weight' => array(
						'default' => '800',
					),
					'line_height' => array(
						'default' => array(
							'unit' => 'em',
							'size' => 1.15,
						),
					),
				),
			)
		);

		$this->add_responsive_control(
			'normal_font_size',
			array(
				'label'      => esc_html__( 'Font Size', 'storeberry-highlight-heading' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'vw' ),
				'range'      => array(
					'px' => array( 'min' => 12, 'max' => 120 ),
				),
				'default'        => array( 'unit' => 'px', 'size' => 40 ),
				'tablet_default' => array( 'unit' => 'px', 'size' => 32 ),
				'mobile_default' => array( 'unit' => 'px', 'size' => 26 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-highlight-heading' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'normal_font_weight',
			array(
				'label'     => esc_html__( 'Font Weight', 'storeberry-highlight-heading' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '800',
				'options'   => array(
					'100' => '100',
					'200' => '200',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'selectors' => array(
					'{{WRAPPER}} .sb-highlight-heading' => 'font-weight: {{VALUE}};',
					'{{WRAPPER}} .sb-highlight-heading-normal' => 'font-weight: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'normal_line_height',
			array(
				'label'      => esc_html__( 'Line Height', 'storeberry-highlight-heading' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => 10, 'max' => 120 ),
					'em' => array( 'min' => 0.5, 'max' => 3, 'step' => 0.05 ),
				),
				'default'    => array( 'unit' => 'em', 'size' => 1.15 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-highlight-heading' => 'line-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'normal_letter_spacing',
			array(
				'label'      => esc_html__( 'Letter Spacing', 'storeberry-highlight-heading' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => -5, 'max' => 20 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-highlight-heading' => 'letter-spacing: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_highlight',
			array(
				'label' => esc_html__( 'Highlight Text Style', 'storeberry-highlight-heading' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'highlight_color',
			array(
				'label'     => esc_html__( 'Highlight Color', 'storeberry-highlight-heading' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#E6005C',
				'selectors' => array(
					'{{WRAPPER}} .sb-highlight-heading-highlight' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'highlight_typography',
				'selector' => '{{WRAPPER}} .sb-highlight-heading-highlight',
			)
		);

		$this->add_control(
			'highlight_font_weight',
			array(
				'label'     => esc_html__( 'Highlight Font Weight', 'storeberry-highlight-heading' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''    => esc_html__( 'Default', 'storeberry-highlight-heading' ),
					'100' => '100',
					'200' => '200',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'selectors' => array(
					'{{WRAPPER}} .sb-highlight-heading-highlight' => 'font-weight: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'highlight_text_decoration',
			array(
				'label'     => esc_html__( 'Text Decoration', 'storeberry-highlight-heading' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'none',
				'options'   => array(
					'none'         => esc_html__( 'None', 'storeberry-highlight-heading' ),
					'underline'    => esc_html__( 'Underline', 'storeberry-highlight-heading' ),
					'overline'     => esc_html__( 'Overline', 'storeberry-highlight-heading' ),
					'line-through' => esc_html__( 'Line Through', 'storeberry-highlight-heading' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .sb-highlight-heading-highlight' => 'text-decoration: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'highlight_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'storeberry-highlight-heading' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .sb-highlight-heading-highlight' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'highlight_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'storeberry-highlight-heading' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 50 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-highlight-heading-highlight' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'highlight_padding',
			array(
				'label'      => esc_html__( 'Padding', 'storeberry-highlight-heading' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-highlight-heading-highlight' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_layout',
			array(
				'label' => esc_html__( 'Layout Style', 'storeberry-highlight-heading' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'lines_gap',
			array(
				'label'      => esc_html__( 'Gap Between Lines', 'storeberry-highlight-heading' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 80 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 4 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-highlight-heading--stacked' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'margin_bottom',
			array(
				'label'      => esc_html__( 'Margin Bottom', 'storeberry-highlight-heading' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 120 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-highlight-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'max_width',
			array(
				'label'      => esc_html__( 'Max Width', 'storeberry-highlight-heading' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 100, 'max' => 1600 ),
					'%'  => array( 'min' => 10, 'max' => 100 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-highlight-heading' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Sanitize HTML tag.
	 *
	 * @param string $tag Raw tag.
	 * @return string
	 */
	private function sanitize_html_tag( $tag ) {
		$allowed = array_keys( $this->get_html_tag_options() );
		$tag     = strtolower( sanitize_key( $tag ) );

		return in_array( $tag, $allowed, true ) ? $tag : 'h2';
	}

	/**
	 * Render widget output.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$line_one        = isset( $settings['line_one'] ) ? $settings['line_one'] : '';
		$line_two_prefix = isset( $settings['line_two_prefix'] ) ? $settings['line_two_prefix'] : '';
		$highlight_text  = isset( $settings['highlight_text'] ) ? $settings['highlight_text'] : '';
		$line_two_suffix = isset( $settings['line_two_suffix'] ) ? $settings['line_two_suffix'] : '';
		$html_tag        = $this->sanitize_html_tag( isset( $settings['html_tag'] ) ? $settings['html_tag'] : 'h2' );
		$line_break      = ( isset( $settings['enable_line_break'] ) && 'yes' === $settings['enable_line_break'] );

		if ( '' === $line_one && '' === $line_two_prefix && '' === $highlight_text && '' === $line_two_suffix ) {
			return;
		}

		$classes = array( 'sb-highlight-heading' );
		$classes[] = $line_break ? 'sb-highlight-heading--stacked' : 'sb-highlight-heading--inline';

		$this->add_render_attribute( 'heading', 'class', $classes );
		?>
		<<?php echo esc_html( $html_tag ); ?> <?php $this->print_render_attribute_string( 'heading' ); ?>>
			<?php if ( '' !== $line_one ) : ?>
				<span class="sb-highlight-heading-line sb-highlight-heading-line-1"><?php echo esc_html( $line_one ); ?></span>
			<?php endif; ?>

			<?php if ( '' !== $line_two_prefix || '' !== $highlight_text || '' !== $line_two_suffix ) : ?>
				<span class="sb-highlight-heading-line sb-highlight-heading-line-2">
					<?php if ( '' !== $line_two_prefix ) : ?>
						<span class="sb-highlight-heading-normal"><?php echo esc_html( $line_two_prefix ); ?></span>
					<?php endif; ?>

					<?php if ( '' !== $highlight_text ) : ?>
						<span class="sb-highlight-heading-highlight"><?php echo esc_html( $highlight_text ); ?></span>
					<?php endif; ?>

					<?php if ( '' !== $line_two_suffix ) : ?>
						<span class="sb-highlight-heading-normal"><?php echo esc_html( $line_two_suffix ); ?></span>
					<?php endif; ?>
				</span>
			<?php endif; ?>
		</<?php echo esc_html( $html_tag ); ?>>
		<?php
	}
}
