<?php
/**
 * Storeberry Feature Cards – Elementor Widget.
 *
 * @package Storeberry_Feature_Cards
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Stacked feature cards widget for Elementor.
 */
class Storeberry_Feature_Cards_Widget extends \Elementor\Widget_Base {

	/**
	 * Widget slug.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'storeberry_feature_cards';
	}

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Storeberry Feature Cards', 'storeberry-feature-cards' );
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-check-circle';
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
		return array( 'cards', 'features', 'benefits', 'services', 'storeberry', 'list' );
	}

	/**
	 * Style dependencies.
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return array( 'storeberry-feature-cards' );
	}

	/**
	 * Default icon for repeater items.
	 *
	 * @return array
	 */
	private function get_default_icon() {
		return array(
			'value'   => 'fas fa-check',
			'library' => 'fa-solid',
		);
	}

	/**
	 * Default repeater cards.
	 *
	 * @return array
	 */
	private function get_default_cards() {
		return array(
			array(
				'card_icon'            => $this->get_default_icon(),
				'card_title'           => esc_html__( '業務成長', 'storeberry-feature-cards' ),
				'card_description'     => esc_html__( '引入自動化銷售與 AI 工具，協助中小企突破人手瓶頸，加速業績增長。', 'storeberry-feature-cards' ),
				'card_bg_color'        => '#FFFFFF',
				'icon_bg_color'        => '#E6005C',
				'icon_color'           => '#FFFFFF',
			),
			array(
				'card_icon'            => $this->get_default_icon(),
				'card_title'           => esc_html__( 'OMO 整合', 'storeberry-feature-cards' ),
				'card_description'     => esc_html__( '打通網店與門市庫存，統一會員數據，協助單一通路品牌升級為全渠道營運。', 'storeberry-feature-cards' ),
				'card_bg_color'        => '#DCEBFF',
				'icon_bg_color'        => '#007BFF',
				'icon_color'           => '#FFFFFF',
			),
			array(
				'card_icon'            => $this->get_default_icon(),
				'card_title'           => esc_html__( '轉台評估', 'storeberry-feature-cards' ),
				'card_description'     => esc_html__( '協助評估數據遷移（Migration）方案，確保業務無縫銜接。', 'storeberry-feature-cards' ),
				'card_bg_color'        => '#FFFFFF',
				'icon_bg_color'        => '#E6005C',
				'icon_color'           => '#FFFFFF',
			),
			array(
				'card_icon'            => $this->get_default_icon(),
				'card_title'           => esc_html__( '硬體對接', 'storeberry-feature-cards' ),
				'card_description'     => esc_html__( '針對您的實體店環境，提供最合適的 POS 與周邊硬體建議。', 'storeberry-feature-cards' ),
				'card_bg_color'        => '#DCEBFF',
				'icon_bg_color'        => '#007BFF',
				'icon_color'           => '#FFFFFF',
			),
			array(
				'card_icon'            => $this->get_default_icon(),
				'card_title'           => esc_html__( '企業方案', 'storeberry-feature-cards' ),
				'card_description'     => esc_html__( '針對連鎖店或特殊營運流程，提供 API 對接與客製化諮詢。', 'storeberry-feature-cards' ),
				'card_bg_color'        => '#FFFFFF',
				'icon_bg_color'        => '#E6005C',
				'icon_color'           => '#FFFFFF',
			),
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
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'card_icon',
			array(
				'label'   => esc_html__( 'Icon', 'storeberry-feature-cards' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => $this->get_default_icon(),
			)
		);

		$repeater->add_control(
			'card_title',
			array(
				'label'       => esc_html__( 'Title', 'storeberry-feature-cards' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
				'dynamic'     => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'card_description',
			array(
				'label'       => esc_html__( 'Description', 'storeberry-feature-cards' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => '',
				'rows'        => 4,
				'label_block' => true,
				'dynamic'     => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'card_bg_color',
			array(
				'label'   => esc_html__( 'Card Background', 'storeberry-feature-cards' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
			)
		);

		$repeater->add_control(
			'icon_bg_color',
			array(
				'label'   => esc_html__( 'Icon Background', 'storeberry-feature-cards' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#E6005C',
			)
		);

		$repeater->add_control(
			'icon_color',
			array(
				'label'   => esc_html__( 'Icon Color', 'storeberry-feature-cards' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
			)
		);

		$this->start_controls_section(
			'section_cards',
			array(
				'label' => esc_html__( 'Cards', 'storeberry-feature-cards' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'cards',
			array(
				'label'       => esc_html__( 'Feature Cards', 'storeberry-feature-cards' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => $this->get_default_cards(),
				'title_field' => '{{{ card_title || "' . esc_html__( 'Card', 'storeberry-feature-cards' ) . '" }}}',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Style tab controls.
	 */
	private function register_style_controls() {
		$this->start_controls_section(
			'section_style_wrapper',
			array(
				'label' => esc_html__( 'Wrapper Style', 'storeberry-feature-cards' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'cards_gap',
			array(
				'label'      => esc_html__( 'Gap Between Cards', 'storeberry-feature-cards' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 80 ),
				),
				'default'        => array( 'unit' => 'px', 'size' => 24 ),
				'mobile_default' => array( 'unit' => 'px', 'size' => 16 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-feature-cards__inner' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'wrapper_max_width',
			array(
				'label'      => esc_html__( 'Max Width', 'storeberry-feature-cards' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 200, 'max' => 1600 ),
					'%'  => array( 'min' => 10, 'max' => 100 ),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 720,
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-feature-cards__inner' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'wrapper_alignment',
			array(
				'label'                => esc_html__( 'Alignment', 'storeberry-feature-cards' ),
				'type'                 => \Elementor\Controls_Manager::CHOOSE,
				'options'              => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'storeberry-feature-cards' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'storeberry-feature-cards' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'storeberry-feature-cards' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'              => 'left',
				'selectors_dictionary' => array(
					'left'   => 'margin-right: auto; margin-left: 0;',
					'center' => 'margin-left: auto; margin-right: auto;',
					'right'  => 'margin-left: auto; margin-right: 0;',
				),
				'selectors'            => array(
					'{{WRAPPER}} .sb-feature-cards__inner' => '{{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_card',
			array(
				'label' => esc_html__( 'Card Style', 'storeberry-feature-cards' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'card_padding',
			array(
				'label'      => esc_html__( 'Padding', 'storeberry-feature-cards' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'      => '28',
					'right'    => '32',
					'bottom'   => '28',
					'left'     => '32',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'top'      => '20',
					'right'    => '20',
					'bottom'   => '20',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-feature-cards__card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'card_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'storeberry-feature-cards' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 80 ),
				),
				'default'        => array( 'unit' => 'px', 'size' => 16 ),
				'mobile_default' => array( 'unit' => 'px', 'size' => 12 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-feature-cards__card' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .sb-feature-cards__card',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .sb-feature-cards__card',
			)
		);

		$this->add_responsive_control(
			'title_desc_spacing',
			array(
				'label'      => esc_html__( 'Title to Description Spacing', 'storeberry-feature-cards' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 40 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 8 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-feature-cards__desc' => 'margin-top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon',
			array(
				'label' => esc_html__( 'Icon Style', 'storeberry-feature-cards' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'storeberry-feature-cards' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 8, 'max' => 48 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 16 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-feature-cards' => '--sb-fc-icon-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_box_size',
			array(
				'label'      => esc_html__( 'Icon Box Size', 'storeberry-feature-cards' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 16, 'max' => 80 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 28 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-feature-cards' => '--sb-fc-icon-box-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_gap',
			array(
				'label'      => esc_html__( 'Icon Gap', 'storeberry-feature-cards' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 60 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 16 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-feature-cards' => '--sb-fc-icon-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_vertical_align',
			array(
				'label'                => esc_html__( 'Icon Vertical Alignment', 'storeberry-feature-cards' ),
				'type'                 => \Elementor\Controls_Manager::SELECT,
				'default'              => 'flex-start',
				'options'              => array(
					'flex-start' => esc_html__( 'Top', 'storeberry-feature-cards' ),
					'center'     => esc_html__( 'Center', 'storeberry-feature-cards' ),
					'flex-end'   => esc_html__( 'Bottom', 'storeberry-feature-cards' ),
				),
				'selectors_dictionary' => array(
					'flex-start' => 'flex-start',
					'center'     => 'center',
					'flex-end'   => 'flex-end',
				),
				'selectors'            => array(
					'{{WRAPPER}} .sb-feature-cards' => '--sb-fc-icon-valign: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			array(
				'label' => esc_html__( 'Title Style', 'storeberry-feature-cards' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'storeberry-feature-cards' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => array(
					'{{WRAPPER}} .sb-feature-cards__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'title_typography',
				'selector'       => '{{WRAPPER}} .sb-feature-cards__title',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array(
						'default' => array(
							'unit' => 'px',
							'size' => 18,
						),
					),
					'font_weight' => array(
						'default' => '700',
					),
				),
			)
		);

		$this->add_responsive_control(
			'title_spacing_bottom',
			array(
				'label'      => esc_html__( 'Spacing Bottom', 'storeberry-feature-cards' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 40 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-feature-cards__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_description',
			array(
				'label' => esc_html__( 'Description Style', 'storeberry-feature-cards' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'description_color',
			array(
				'label'     => esc_html__( 'Color', 'storeberry-feature-cards' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => array(
					'{{WRAPPER}} .sb-feature-cards__desc' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'description_typography',
				'selector'       => '{{WRAPPER}} .sb-feature-cards__desc',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array(
						'default' => array(
							'unit' => 'px',
							'size' => 15,
						),
					),
					'line_height' => array(
						'default' => array(
							'unit' => 'em',
							'size' => 1.8,
						),
					),
				),
			)
		);

		$this->add_responsive_control(
			'description_indent',
			array(
				'label'      => esc_html__( 'Description Extra Indent', 'storeberry-feature-cards' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 80 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 0 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-feature-cards' => '--sb-fc-desc-indent: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Build inline style for a single card.
	 *
	 * @param array $card Card settings.
	 * @return string
	 */
	private function get_card_inline_style( $card ) {
		$styles = array();

		if ( ! empty( $card['card_bg_color'] ) ) {
			$color = sanitize_hex_color( $card['card_bg_color'] );
			if ( $color ) {
				$styles[] = 'background-color: ' . $color . ';';
			}
		}

		return implode( ' ', $styles );
	}

	/**
	 * Build inline style for icon wrap.
	 *
	 * @param array $card Card settings.
	 * @return string
	 */
	private function get_icon_inline_style( $card ) {
		$styles = array();

		if ( ! empty( $card['icon_bg_color'] ) ) {
			$bg = sanitize_hex_color( $card['icon_bg_color'] );
			if ( $bg ) {
				$styles[] = 'background-color: ' . $bg . ';';
			}
		}

		if ( ! empty( $card['icon_color'] ) ) {
			$color = sanitize_hex_color( $card['icon_color'] );
			if ( $color ) {
				$styles[] = 'color: ' . $color . ';';
			}
		}

		return implode( ' ', $styles );
	}

	/**
	 * Render widget output.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$cards    = ! empty( $settings['cards'] ) && is_array( $settings['cards'] ) ? $settings['cards'] : array();

		if ( empty( $cards ) ) {
			return;
		}
		?>
		<div class="sb-feature-cards">
			<div class="sb-feature-cards__inner">
				<?php foreach ( $cards as $index => $card ) : ?>
					<?php
					$card_style = $this->get_card_inline_style( $card );
					$icon_style = $this->get_icon_inline_style( $card );
					?>
					<article class="sb-feature-cards__card"<?php echo $card_style ? ' style="' . esc_attr( $card_style ) . '"' : ''; ?>>
						<div class="sb-feature-cards__card-header">
							<?php if ( ! empty( $card['card_icon']['value'] ) ) : ?>
								<div class="sb-feature-cards__icon-wrap"<?php echo $icon_style ? ' style="' . esc_attr( $icon_style ) . '"' : ''; ?>>
									<?php
									\Elementor\Icons_Manager::render_icon(
										$card['card_icon'],
										array( 'aria-hidden' => 'true' )
									);
									?>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $card['card_title'] ) ) : ?>
								<h3 class="sb-feature-cards__title"><?php echo esc_html( $card['card_title'] ); ?></h3>
							<?php endif; ?>
						</div>

						<?php if ( ! empty( $card['card_description'] ) ) : ?>
							<p class="sb-feature-cards__desc"><?php echo esc_html( $card['card_description'] ); ?></p>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}
