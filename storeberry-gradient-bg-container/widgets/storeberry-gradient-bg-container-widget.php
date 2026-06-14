<?php
/**
 * Stable gradient wrapper widget (Elementor Template or manual content).
 * For drag-and-drop widgets inside, use a native Container with Storeberry Gradient enabled.
 *
 * @package Storeberry_Gradient_Bg_Container
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Blurred gradient background container widget.
 */
class Storeberry_Gradient_Bg_Container_Widget extends \Elementor\Widget_Base {

	/**
	 * Widget slug.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'storeberry_gradient_bg_container';
	}

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Storeberry Gradient Background Container', 'storeberry-gradient-bg-container' );
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-section';
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
		return array( 'gradient', 'background', 'container', 'section', 'storeberry', 'blur' );
	}

	/**
	 * Style dependencies.
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return array( 'storeberry-gradient-bg-container' );
	}

	/**
	 * Get published Elementor library templates.
	 *
	 * @return array
	 */
	private function get_elementor_templates() {
		$options = array( '' => esc_html__( '— Select Template —', 'storeberry-gradient-bg-container' ) );

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
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'storeberry-gradient-bg-container' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'usage_notice',
			array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'raw'             => '<p style="margin:0;"><strong>'
					. esc_html__( 'Recommended:', 'storeberry-gradient-bg-container' )
					. '</strong> '
					. esc_html__( 'Add a Container on the page → Style → Storeberry Gradient → Enable. Then drag widgets inside that Container. No extra wrapper needed.', 'storeberry-gradient-bg-container' )
					. '</p>',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			)
		);

		$this->add_control(
			'content_type',
			array(
				'label'   => esc_html__( 'Content Type', 'storeberry-gradient-bg-container' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'template',
				'options' => array(
					'template' => esc_html__( 'Elementor Template (recommended)', 'storeberry-gradient-bg-container' ),
					'manual'   => esc_html__( 'Manual (heading / text / image)', 'storeberry-gradient-bg-container' ),
				),
			)
		);

		$this->add_control(
			'content_notice',
			array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'raw'             => '<p style="margin:0;">'
					. esc_html__( 'Tip: Create a Template in Templates → Saved Templates, design your layout there, then select it here. No extra outer Container needed on the page.', 'storeberry-gradient-bg-container' )
					. '</p>',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition'       => array(
					'content_type' => 'template',
				),
			)
		);

		$this->add_control(
			'elementor_template',
			array(
				'label'     => esc_html__( 'Elementor Template', 'storeberry-gradient-bg-container' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => $this->get_elementor_templates(),
				'default'   => '',
				'condition' => array(
					'content_type' => 'template',
				),
			)
		);

		$this->add_control(
			'heading',
			array(
				'label'       => esc_html__( 'Heading', 'storeberry-gradient-bg-container' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
				'dynamic'     => array( 'active' => true ),
				'condition'   => array(
					'content_type' => 'manual',
				),
			)
		);

		$this->add_control(
			'description',
			array(
				'label'       => esc_html__( 'Description', 'storeberry-gradient-bg-container' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => '',
				'rows'        => 5,
				'label_block' => true,
				'dynamic'     => array( 'active' => true ),
				'condition'   => array(
					'content_type' => 'manual',
				),
			)
		);

		$this->add_control(
			'content_image',
			array(
				'label'     => esc_html__( 'Image', 'storeberry-gradient-bg-container' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'condition' => array(
					'content_type' => 'manual',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'content_image_size',
				'default'   => 'large',
				'condition' => array(
					'content_type' => 'manual',
				),
			)
		);

		$this->add_control(
			'custom_html',
			array(
				'label'       => esc_html__( 'Custom HTML', 'storeberry-gradient-bg-container' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => '',
				'rows'        => 6,
				'label_block' => true,
				'condition'   => array(
					'content_type' => 'manual',
				),
			)
		);

		$this->add_responsive_control(
			'content_alignment',
			array(
				'label'     => esc_html__( 'Content Alignment', 'storeberry-gradient-bg-container' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'storeberry-gradient-bg-container' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'storeberry-gradient-bg-container' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'storeberry-gradient-bg-container' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
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
				'label' => esc_html__( 'Wrapper Layout', 'storeberry-gradient-bg-container' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'wrapper_max_width',
			array(
				'label'      => esc_html__( 'Max Width', 'storeberry-gradient-bg-container' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'vw' ),
				'range'      => array(
					'px' => array( 'min' => 320, 'max' => 2560 ),
					'%'  => array( 'min' => 10, 'max' => 100 ),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 1440,
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-gradient-bg-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'wrapper_min_height',
			array(
				'label'      => esc_html__( 'Min Height', 'storeberry-gradient-bg-container' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'vh' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 1600 ),
					'vh' => array( 'min' => 0, 'max' => 100 ),
				),
				'default'        => array( 'unit' => 'px', 'size' => 720 ),
				'tablet_default' => array( 'unit' => 'px', 'size' => 640 ),
				'mobile_default' => array( 'unit' => 'px', 'size' => 0 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-gradient-bg-wrapper' => 'min-height: {{SIZE}}{{UNIT}};',
				),
				'description' => esc_html__( 'Set 0 on mobile for auto height based on content.', 'storeberry-gradient-bg-container' ),
			)
		);

		$this->add_responsive_control(
			'wrapper_padding',
			array(
				'label'      => esc_html__( 'Padding', 'storeberry-gradient-bg-container' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'      => '80',
					'right'    => '80',
					'bottom'   => '80',
					'left'     => '80',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'tablet_default' => array(
					'top'      => '64',
					'right'    => '40',
					'bottom'   => '64',
					'left'     => '40',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'top'      => '48',
					'right'    => '24',
					'bottom'   => '48',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-gradient-bg-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'wrapper_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'storeberry-gradient-bg-container' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 120 ),
				),
				'default'        => array( 'unit' => 'px', 'size' => 48 ),
				'tablet_default' => array( 'unit' => 'px', 'size' => 36 ),
				'mobile_default' => array( 'unit' => 'px', 'size' => 24 ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-gradient-bg-wrapper' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'overflow_hidden',
			array(
				'label'        => esc_html__( 'Overflow Hidden', 'storeberry-gradient-bg-container' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'storeberry-gradient-bg-container' ),
				'label_off'    => esc_html__( 'No', 'storeberry-gradient-bg-container' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_gradient',
			array(
				'label' => esc_html__( 'Gradient Background', 'storeberry-gradient-bg-container' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'gradient_color_1',
			array(
				'label'     => esc_html__( 'Color 1', 'storeberry-gradient-bg-container' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#EEE05F',
				'selectors' => array(
					'{{WRAPPER}} .sb-gradient-bg-wrapper' => '--sb-grad-color-1: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'gradient_color_2',
			array(
				'label'     => esc_html__( 'Color 2', 'storeberry-gradient-bg-container' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#766CD2',
				'selectors' => array(
					'{{WRAPPER}} .sb-gradient-bg-wrapper' => '--sb-grad-color-2: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'gradient_color_3',
			array(
				'label'     => esc_html__( 'Color 3', 'storeberry-gradient-bg-container' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FB636E',
				'selectors' => array(
					'{{WRAPPER}} .sb-gradient-bg-wrapper' => '--sb-grad-color-3: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'gradient_angle',
			array(
				'label'      => esc_html__( 'Gradient Angle', 'storeberry-gradient-bg-container' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 360 ),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 90,
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-gradient-bg-wrapper' => '--sb-grad-angle: {{SIZE}}deg;',
				),
			)
		);

		$this->add_control(
			'gradient_opacity',
			array(
				'label'      => esc_html__( 'Gradient Opacity (%)', 'storeberry-gradient-bg-container' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 100, 'step' => 1 ),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 20,
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-gradient-bg-wrapper' => '--sb-grad-opacity: calc({{SIZE}} / 100);',
				),
			)
		);

		$this->add_control(
			'gradient_blur',
			array(
				'label'      => esc_html__( 'Blur', 'storeberry-gradient-bg-container' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 200 ),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 80,
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-gradient-bg-wrapper' => '--sb-grad-blur: {{SIZE}}{{UNIT}}; --sb-grad-inset: {{SIZE}};',
				),
			)
		);

		$this->add_control(
			'gradient_scale',
			array(
				'label'      => esc_html__( 'Gradient Scale (%)', 'storeberry-gradient-bg-container' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 50, 'max' => 300, 'step' => 1 ),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 115,
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-gradient-bg-wrapper' => '--sb-grad-scale: calc({{SIZE}} / 100);',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			array(
				'label' => esc_html__( 'Inner Content Style', 'storeberry-gradient-bg-container' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'content_max_width',
			array(
				'label'      => esc_html__( 'Content Max Width', 'storeberry-gradient-bg-container' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 200, 'max' => 1600 ),
					'%'  => array( 'min' => 10, 'max' => 100 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-gradient-bg-content' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'content_gap',
			array(
				'label'      => esc_html__( 'Gap Between Elements', 'storeberry-gradient-bg-container' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 80 ),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 24,
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-gradient-bg-content' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'heading_color',
			array(
				'label'     => esc_html__( 'Heading Color', 'storeberry-gradient-bg-container' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .sb-gradient-bg-heading' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'content_type' => 'manual',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'heading_typography',
				'label'     => esc_html__( 'Heading Typography', 'storeberry-gradient-bg-container' ),
				'selector'  => '{{WRAPPER}} .sb-gradient-bg-heading',
				'condition' => array(
					'content_type' => 'manual',
				),
			)
		);

		$this->add_control(
			'description_color',
			array(
				'label'     => esc_html__( 'Description Color', 'storeberry-gradient-bg-container' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .sb-gradient-bg-desc' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'content_type' => 'manual',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'description_typography',
				'label'     => esc_html__( 'Description Typography', 'storeberry-gradient-bg-container' ),
				'selector'  => '{{WRAPPER}} .sb-gradient-bg-desc',
				'condition' => array(
					'content_type' => 'manual',
				),
			)
		);

		$this->add_responsive_control(
			'image_width',
			array(
				'label'      => esc_html__( 'Image Width', 'storeberry-gradient-bg-container' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 50, 'max' => 1600 ),
					'%'  => array( 'min' => 10, 'max' => 100 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-gradient-bg-image' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'content_type' => 'manual',
				),
			)
		);

		$this->add_responsive_control(
			'image_border_radius',
			array(
				'label'      => esc_html__( 'Image Border Radius', 'storeberry-gradient-bg-container' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 80 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-gradient-bg-image' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'content_type' => 'manual',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Get content alignment class.
	 *
	 * @param string $alignment Alignment value.
	 * @return string
	 */
	private function get_alignment_class( $alignment ) {
		$allowed = array(
			'left'   => 'sb-gradient-bg-content--align-left',
			'center' => 'sb-gradient-bg-content--align-center',
			'right'  => 'sb-gradient-bg-content--align-right',
		);

		return isset( $allowed[ $alignment ] ) ? $allowed[ $alignment ] : $allowed['left'];
	}

	/**
	 * Render template content.
	 *
	 * @param array $settings Widget settings.
	 */
	private function render_template_content( $settings ) {
		$template_id = ! empty( $settings['elementor_template'] ) ? absint( $settings['elementor_template'] ) : 0;

		if ( ! $template_id || 'publish' !== get_post_status( $template_id ) ) {
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				echo '<p class="sb-gradient-bg-desc">' . esc_html__( 'Select an Elementor Template in the Content tab.', 'storeberry-gradient-bg-container' ) . '</p>';
			}
			return;
		}

		echo '<div class="sb-gradient-bg-template">';
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor builder output.
		echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template_id );
		echo '</div>';
	}

	/**
	 * Render manual content.
	 *
	 * @param array $settings Widget settings.
	 */
	private function render_manual_content( $settings ) {
		$heading     = isset( $settings['heading'] ) ? $settings['heading'] : '';
		$description = isset( $settings['description'] ) ? $settings['description'] : '';
		$custom_html = isset( $settings['custom_html'] ) ? $settings['custom_html'] : '';
		$has_image   = ! empty( $settings['content_image']['url'] );

		if ( '' !== $heading ) {
			echo '<h2 class="sb-gradient-bg-heading">' . esc_html( $heading ) . '</h2>';
		}

		if ( '' !== $description ) {
			echo '<p class="sb-gradient-bg-desc">' . esc_html( $description ) . '</p>';
		}

		if ( $has_image ) {
			$image_html = \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'content_image_size', 'content_image' );
			if ( $image_html ) {
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor image HTML.
				echo str_replace( '<img ', '<img class="sb-gradient-bg-image" ', $image_html );
			} else {
				$image_url = esc_url( $settings['content_image']['url'] );
				$image_alt = ! empty( $settings['content_image']['id'] )
					? get_post_meta( absint( $settings['content_image']['id'] ), '_wp_attachment_image_alt', true )
					: '';
				printf(
					'<img class="sb-gradient-bg-image" src="%1$s" alt="%2$s" loading="lazy" />',
					$image_url,
					esc_attr( $image_alt )
				);
			}
		}

		if ( '' !== $custom_html ) {
			echo '<div class="sb-gradient-bg-custom">' . wp_kses_post( $custom_html ) . '</div>';
		}

		if ( '' === $heading && '' === $description && ! $has_image && '' === $custom_html && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			echo '<p class="sb-gradient-bg-desc">' . esc_html__( 'Add content from the Content tab, or switch to Elementor Template mode.', 'storeberry-gradient-bg-container' ) . '</p>';
		}
	}

	/**
	 * Render widget output.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$content_type = isset( $settings['content_type'] ) ? $settings['content_type'] : 'template';
		$alignment    = isset( $settings['content_alignment'] ) ? $settings['content_alignment'] : 'left';

		$wrapper_classes = array( 'sb-gradient-bg-wrapper' );
		if ( empty( $settings['overflow_hidden'] ) || 'yes' !== $settings['overflow_hidden'] ) {
			$wrapper_classes[] = 'sb-gradient-bg-wrapper--overflow-visible';
		}

		$content_classes = array(
			'sb-gradient-bg-content',
			$this->get_alignment_class( $alignment ),
		);
		?>
		<section class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>">
			<div class="sb-gradient-bg-layer" aria-hidden="true"></div>
			<div class="<?php echo esc_attr( implode( ' ', $content_classes ) ); ?>">
				<?php
				if ( 'template' === $content_type ) {
					$this->render_template_content( $settings );
				} else {
					$this->render_manual_content( $settings );
				}
				?>
			</div>
		</section>
		<?php
	}
}
