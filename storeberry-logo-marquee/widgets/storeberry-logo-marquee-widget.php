<?php
/**
 * Storeberry Logo Marquee – Elementor Widget.
 *
 * @package Storeberry_Logo_Marquee
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Storeberry_Logo_Marquee_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'storeberry_logo_marquee';
	}

	public function get_title() {
		return esc_html__( 'Storeberry Logo Marquee', 'storeberry-logo-marquee' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_categories() {
		return array( 'storeberry' );
	}

	public function get_keywords() {
		return array( 'logo', 'marquee', 'brand', 'scroll', 'storeberry' );
	}

	// Register style dependency for Elementor
	public function get_style_depends() {
		return array( 'storeberry-logo-marquee' );
	}

	protected function register_controls() {

		/* ── CONTENT: Logo List ─────────────────────────────────────── */
		$this->start_controls_section( 'section_logos', array(
			'label' => esc_html__( 'Logo List', 'storeberry-logo-marquee' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		) );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'logo_image', array(
			'label' => esc_html__( 'Logo Image', 'storeberry-logo-marquee' ),
			'type'  => \Elementor\Controls_Manager::MEDIA,
		) );

		$repeater->add_control( 'logo_alt', array(
			'label'       => esc_html__( 'Alt Text', 'storeberry-logo-marquee' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => '',
			'label_block' => true,
		) );

		$repeater->add_control( 'logo_link', array(
			'label'         => esc_html__( 'Link URL (optional)', 'storeberry-logo-marquee' ),
			'type'          => \Elementor\Controls_Manager::URL,
			'placeholder'   => 'https://example.com',
			'show_external' => false,
			'default'       => array( 'url' => '' ),
		) );

		$this->add_control( 'logos', array(
			'label'       => esc_html__( 'Logos', 'storeberry-logo-marquee' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => array(),
			'title_field' => '{{{ logo_alt || "Logo" }}}',
		) );

		$this->end_controls_section();

		/* ── CONTENT: Layout ────────────────────────────────────────── */
		$this->start_controls_section( 'section_layout', array(
			'label' => esc_html__( 'Layout', 'storeberry-logo-marquee' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		) );

		$this->add_control( 'direction', array(
			'label'   => esc_html__( 'Direction', 'storeberry-logo-marquee' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'left',
			'options' => array(
				'left'  => esc_html__( 'Left', 'storeberry-logo-marquee' ),
				'right' => esc_html__( 'Right', 'storeberry-logo-marquee' ),
			),
		) );

		$this->add_control( 'pause_on_hover', array(
			'label'        => esc_html__( 'Pause on Hover', 'storeberry-logo-marquee' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'storeberry-logo-marquee' ),
			'label_off'    => esc_html__( 'No', 'storeberry-logo-marquee' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		) );

		$this->add_control( 'open_in_new_tab', array(
			'label'        => esc_html__( 'Open Links in New Tab', 'storeberry-logo-marquee' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'storeberry-logo-marquee' ),
			'label_off'    => esc_html__( 'No', 'storeberry-logo-marquee' ),
			'return_value' => 'yes',
			'default'      => 'no',
		) );

		$this->end_controls_section();

		/* ── STYLE: Container ───────────────────────────────────────── */
		$this->start_controls_section( 'section_style_container', array(
			'label' => esc_html__( 'Container Style', 'storeberry-logo-marquee' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		) );

		$this->add_control( 'bg_color', array(
			'label'     => esc_html__( 'Background Color', 'storeberry-logo-marquee' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#F7F7F7',
			'selectors' => array( '{{WRAPPER}} .slm-section' => 'background-color: {{VALUE}};' ),
		) );

		$this->add_responsive_control( 'container_padding', array(
			'label'      => esc_html__( 'Padding', 'storeberry-logo-marquee' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', 'em', '%' ),
			'default'    => array( 'top' => '40', 'right' => '0', 'bottom' => '40', 'left' => '0', 'unit' => 'px' ),
			'selectors'  => array( '{{WRAPPER}} .slm-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
		) );

		$this->add_responsive_control( 'container_border_radius', array(
			'label'      => esc_html__( 'Border Radius', 'storeberry-logo-marquee' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', '%' ),
			'selectors'  => array( '{{WRAPPER}} .slm-section' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
		) );

		$this->add_responsive_control( 'container_max_width', array(
			'label'      => esc_html__( 'Max Width', 'storeberry-logo-marquee' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array( 'px', '%' ),
			'range'      => array( 'px' => array( 'min' => 320, 'max' => 2560 ), '%' => array( 'min' => 10, 'max' => 100 ) ),
			'selectors'  => array( '{{WRAPPER}} .slm-section' => 'max-width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;' ),
		) );

		$this->end_controls_section();

		/* ── STYLE: Logo ────────────────────────────────────────────── */
		$this->start_controls_section( 'section_style_logo', array(
			'label' => esc_html__( 'Logo Style', 'storeberry-logo-marquee' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		) );

		$this->add_responsive_control( 'logo_width', array(
			'label'          => esc_html__( 'Logo Width', 'storeberry-logo-marquee' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => array( 'px', '%' ),
			'range'          => array( 'px' => array( 'min' => 20, 'max' => 400 ) ),
			'default'        => array( 'unit' => 'px', 'size' => 120 ),
			'tablet_default' => array( 'unit' => 'px', 'size' => 90 ),
			'mobile_default' => array( 'unit' => 'px', 'size' => 72 ),
			'selectors'      => array( '{{WRAPPER}} .slm-logo-img' => 'width: {{SIZE}}{{UNIT}};' ),
		) );

		$this->add_responsive_control( 'logo_height', array(
			'label'      => esc_html__( 'Logo Height', 'storeberry-logo-marquee' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array( 'px' ),
			'range'      => array( 'px' => array( 'min' => 10, 'max' => 300 ) ),
			'selectors'  => array( '{{WRAPPER}} .slm-logo-img' => 'height: {{SIZE}}{{UNIT}};' ),
		) );

		$this->add_responsive_control( 'logo_gap', array(
			'label'          => esc_html__( 'Gap Between Logos', 'storeberry-logo-marquee' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => array( 'px' ),
			'range'          => array( 'px' => array( 'min' => 0, 'max' => 200 ) ),
			'default'        => array( 'unit' => 'px', 'size' => 64 ),
			'tablet_default' => array( 'unit' => 'px', 'size' => 40 ),
			'mobile_default' => array( 'unit' => 'px', 'size' => 28 ),
			/* Gap is applied to track and content to keep spaces even */
			'selectors'      => array( '{{WRAPPER}} .slm-track, {{WRAPPER}} .slm-content' => 'gap: {{SIZE}}{{UNIT}};' ),
		) );

		$this->add_control( 'logo_opacity', array(
			'label'     => esc_html__( 'Opacity', 'storeberry-logo-marquee' ),
			'type'      => \Elementor\Controls_Manager::SLIDER,
			'range'     => array( 'px' => array( 'min' => 0, 'max' => 1, 'step' => 0.05 ) ),
			'default'   => array( 'size' => 1 ),
			'selectors' => array( '{{WRAPPER}} .slm-logo-img' => 'opacity: {{SIZE}};' ),
		) );

		$this->add_control( 'logo_grayscale', array(
			'label'        => esc_html__( 'Grayscale', 'storeberry-logo-marquee' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'storeberry-logo-marquee' ),
			'label_off'    => esc_html__( 'No', 'storeberry-logo-marquee' ),
			'return_value' => 'yes',
			'default'      => '',
			'selectors'    => array( '{{WRAPPER}} .slm-logo-img' => 'filter: grayscale(100%);' ),
		) );

		$this->end_controls_section();

		/* ── STYLE: Animation ───────────────────────────────────────── */
		$this->start_controls_section( 'section_style_animation', array(
			'label' => esc_html__( 'Animation Style', 'storeberry-logo-marquee' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		) );

		$this->add_control( 'animation_speed', array(
			'label'     => esc_html__( 'Speed (seconds)', 'storeberry-logo-marquee' ),
			'type'      => \Elementor\Controls_Manager::SLIDER,
			'range'     => array( 'px' => array( 'min' => 2, 'max' => 120, 'step' => 1 ) ),
			'default'   => array( 'size' => 28 ),
			'selectors' => array( '{{WRAPPER}} .slm-track' => 'animation-duration: {{SIZE}}s;' ),
		) );

		$this->end_controls_section();
	}

	/* ── RENDER ─────────────────────────────────────────────────────── */
	protected function render() {
		$settings = $this->get_settings_for_display();

		/* Filter to only items with a real image URL */
		$logos = array();
		if ( ! empty( $settings['logos'] ) ) {
			foreach ( $settings['logos'] as $item ) {
				if ( ! empty( $item['logo_image']['url'] ) ) {
					$logos[] = $item;
				}
			}
		}

		if ( empty( $logos ) ) {
			return;
		}

		$dir         = ( 'right' === ( $settings['direction'] ?? 'left' ) ) ? 'right' : 'left';
		$pause       = ! empty( $settings['pause_on_hover'] ) && 'yes' === $settings['pause_on_hover'];
		$new_tab     = ! empty( $settings['open_in_new_tab'] ) && 'yes' === $settings['open_in_new_tab'];

		$count  = count( $logos );
		$copies = max( 4, (int) ceil( 15 / $count ) );

		$track_class = 'slm-track slm-dir-' . esc_attr( $dir );
		if ( $pause ) {
			$track_class .= ' slm-pause';
		}
		
		// Ensure the animation keyframes exist no matter what.
		?>
		<style>
		@keyframes slm-marquee-left {
			0% { transform: translate3d(0, 0, 0); }
			100% { transform: translate3d(-50%, 0, 0); }
		}
		@keyframes slm-marquee-right {
			0% { transform: translate3d(-50%, 0, 0); }
			100% { transform: translate3d(0, 0, 0); }
		}
		</style>
		<div class="slm-section">
			<div class="slm-viewport">
				<div class="<?php echo esc_attr( $track_class ); ?>">
					<!-- First Set -->
					<div class="slm-content">
						<?php for ( $c = 0; $c < $copies; $c++ ) : ?>
							<?php foreach ( $logos as $logo ) :
								$src      = esc_url( $logo['logo_image']['url'] );
								$alt      = esc_attr( sanitize_text_field( $logo['logo_alt'] ?? '' ) );
								$href     = ! empty( $logo['logo_link']['url'] ) ? esc_url( $logo['logo_link']['url'] ) : '';
								$target   = $new_tab ? ' target="_blank" rel="noopener noreferrer"' : '';
							?>
							<div class="slm-item">
								<?php if ( $href ) : ?>
									<a href="<?php echo $href; ?>"<?php echo $target; ?>>
										<img class="slm-logo-img" src="<?php echo $src; ?>" alt="<?php echo $alt; ?>" />
									</a>
								<?php else : ?>
									<img class="slm-logo-img" src="<?php echo $src; ?>" alt="<?php echo $alt; ?>" />
								<?php endif; ?>
							</div>
							<?php endforeach; ?>
						<?php endfor; ?>
					</div>
					<!-- Identical Second Set for seamless loop -->
					<div class="slm-content" aria-hidden="true">
						<?php for ( $c = 0; $c < $copies; $c++ ) : ?>
							<?php foreach ( $logos as $logo ) :
								$src      = esc_url( $logo['logo_image']['url'] );
								$alt      = esc_attr( sanitize_text_field( $logo['logo_alt'] ?? '' ) );
								$href     = ! empty( $logo['logo_link']['url'] ) ? esc_url( $logo['logo_link']['url'] ) : '';
								$target   = $new_tab ? ' target="_blank" rel="noopener noreferrer"' : '';
							?>
							<div class="slm-item">
								<?php if ( $href ) : ?>
									<a href="<?php echo $href; ?>"<?php echo $target; ?>>
										<img class="slm-logo-img" src="<?php echo $src; ?>" alt="<?php echo $alt; ?>" />
									</a>
								<?php else : ?>
									<img class="slm-logo-img" src="<?php echo $src; ?>" alt="<?php echo $alt; ?>" />
								<?php endif; ?>
							</div>
							<?php endforeach; ?>
						<?php endfor; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/* ── EDITOR LIVE PREVIEW ─────────────────────────────────────────── */
	protected function content_template() {
		?>
		<#
		var logos = [];
		_.each( settings.logos || [], function( item ) {
			if ( item.logo_image && item.logo_image.url ) logos.push( item );
		} );
		if ( ! logos.length ) return;

		var dir    = ( settings.direction === 'right' ) ? 'right' : 'left';
		var pause  = settings.pause_on_hover === 'yes';
		var newTab = settings.open_in_new_tab === 'yes';
		var count  = logos.length;
		var copies = Math.max( 4, Math.ceil( 15 / count ) );

		var trackClass = 'slm-track slm-dir-' + dir + ( pause ? ' slm-pause' : '' );
		#>
		<style>
		@keyframes slm-marquee-left {
			0% { transform: translate3d(0, 0, 0); }
			100% { transform: translate3d(-50%, 0, 0); }
		}
		@keyframes slm-marquee-right {
			0% { transform: translate3d(-50%, 0, 0); }
			100% { transform: translate3d(0, 0, 0); }
		}
		</style>
		<div class="slm-section">
			<div class="slm-viewport">
				<div class="{{ trackClass }}">
					<div class="slm-content">
						<# for ( var c = 0; c < copies; c++ ) {
							_.each( logos, function( logo ) {
								var src    = logo.logo_image.url;
								var alt    = logo.logo_alt || '';
								var href   = ( logo.logo_link && logo.logo_link.url ) ? logo.logo_link.url : '';
								var target = newTab ? ' target="_blank" rel="noopener noreferrer"' : '';
						#>
						<div class="slm-item">
							<# if ( href ) { #>
								<a href="{{ href }}"{{{ target }}}><img class="slm-logo-img" src="{{ src }}" alt="{{ alt }}" /></a>
							<# } else { #>
								<img class="slm-logo-img" src="{{ src }}" alt="{{ alt }}" />
							<# } #>
						</div>
						<# } ); } #>
					</div>
					<div class="slm-content" aria-hidden="true">
						<# for ( var c = 0; c < copies; c++ ) {
							_.each( logos, function( logo ) {
								var src    = logo.logo_image.url;
								var alt    = logo.logo_alt || '';
								var href   = ( logo.logo_link && logo.logo_link.url ) ? logo.logo_link.url : '';
								var target = newTab ? ' target="_blank" rel="noopener noreferrer"' : '';
						#>
						<div class="slm-item">
							<# if ( href ) { #>
								<a href="{{ href }}"{{{ target }}}><img class="slm-logo-img" src="{{ src }}" alt="{{ alt }}" /></a>
							<# } else { #>
								<img class="slm-logo-img" src="{{ src }}" alt="{{ alt }}" />
							<# } #>
						</div>
						<# } ); } #>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
