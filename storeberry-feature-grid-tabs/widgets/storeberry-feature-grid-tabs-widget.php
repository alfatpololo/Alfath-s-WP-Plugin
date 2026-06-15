<?php
/**
 * Storeberry Feature Grid Tabs – Elementor Widget.
 *
 * @package Storeberry_Feature_Grid_Tabs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Feature tabs with flexible card grids for Elementor Free.
 */
class Storeberry_Feature_Grid_Tabs_Widget extends \Elementor\Widget_Base {

	/**
	 * Widget slug.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'storeberry_feature_grid_tabs';
	}

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Storeberry Feature Grid Tabs', 'storeberry-feature-grid-tabs' );
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
		return array( 'tabs', 'features', 'grid', 'cards', 'storeberry' );
	}

	/**
	 * Style dependencies.
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return array( 'storeberry-feature-grid-tabs' );
	}

	/**
	 * Script dependencies.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array( 'storeberry-feature-grid-tabs' );
	}

	/**
	 * Card layout options.
	 *
	 * @return array
	 */
	private function get_card_layout_options() {
		return array(
			'wide-horizontal' => esc_html__( 'Wide Horizontal', 'storeberry-feature-grid-tabs' ),
			'half'            => esc_html__( 'Half', 'storeberry-feature-grid-tabs' ),
			'tall'            => esc_html__( 'Tall', 'storeberry-feature-grid-tabs' ),
			'image-bottom'    => esc_html__( 'Image Bottom', 'storeberry-feature-grid-tabs' ),
			'image-right'     => esc_html__( 'Image Right', 'storeberry-feature-grid-tabs' ),
			'image-overlap'   => esc_html__( 'Image Overlap', 'storeberry-feature-grid-tabs' ),
			'full-image'      => esc_html__( 'Full Image', 'storeberry-feature-grid-tabs' ),
		);
	}

	/**
	 * Tab index select options.
	 *
	 * @return array
	 */
	private function get_tab_index_options() {
		$options = array();
		for ( $i = 1; $i <= 10; $i++ ) {
			/* translators: %d: tab number */
			$options[ (string) $i ] = sprintf( esc_html__( 'Tab %d', 'storeberry-feature-grid-tabs' ), $i );
		}
		return $options;
	}

	/**
	 * Default tab icon.
	 *
	 * @param string $icon Icon class.
	 * @return array
	 */
	private function default_icon( $icon = 'fas fa-star' ) {
		return array(
			'value'   => $icon,
			'library' => 'fa-solid',
		);
	}

	/**
	 * Default tabs.
	 *
	 * @return array
	 */
	private function get_default_tabs() {
		return array(
			array(
				'tab_icon'              => $this->default_icon( 'fas fa-store' ),
				'tab_title'             => '品牌網店',
				'tab_subtitle'          => 'Online Store',
				'tab_active_bg'         => '#6254D9',
				'tab_inactive_bg'       => '#FFFFFF',
				'tab_active_text'       => '#FFFFFF',
				'tab_inactive_text'     => '#333333',
				'content_heading'       => '超越傳統網店，打造具備 AI 靈感的線上旗艦店',
				'tab_grid_columns'      => '2',
			),
			array(
				'tab_icon'              => $this->default_icon( 'fas fa-cash-register' ),
				'tab_title'             => '零售 POS',
				'tab_subtitle'          => 'Retail POS',
				'tab_active_bg'         => '#E6005C',
				'tab_inactive_bg'       => '#FFFFFF',
				'tab_active_text'       => '#FFFFFF',
				'tab_inactive_text'     => '#333333',
				'content_heading'       => '賦予店員更強大的銷售工具，讓每一吋空間都轉化為營收',
				'tab_grid_columns'      => '2',
			),
			array(
				'tab_icon'              => $this->default_icon( 'fas fa-share-alt' ),
				'tab_title'             => '社群電商',
				'tab_subtitle'          => 'Social Commerce',
				'tab_active_bg'         => '#F2E34D',
				'tab_inactive_bg'       => '#FFFFFF',
				'tab_active_text'       => '#333333',
				'tab_inactive_text'     => '#333333',
				'content_heading'       => '將流量瞬間變銷量，讓 Facebook 與 Instagram 成為您的自動提款機',
				'tab_grid_columns'      => '2',
			),
			array(
				'tab_icon'              => $this->default_icon( 'fab fa-whatsapp' ),
				'tab_title'             => 'WhatsApp 商務',
				'tab_subtitle'          => 'WhatsApp Commerce',
				'tab_active_bg'         => '#25B43B',
				'tab_inactive_bg'       => '#FFFFFF',
				'tab_active_text'       => '#FFFFFF',
				'tab_inactive_text'     => '#333333',
				'content_heading'       => '提升服務效率，全自動化處理從導購到通知的每一哩路',
				'tab_grid_columns'      => '2',
			),
			array(
				'tab_icon'              => $this->default_icon( 'fas fa-calendar-check' ),
				'tab_title'             => '智能預約',
				'tab_subtitle'          => 'Booking System',
				'tab_active_bg'         => '#0B73FF',
				'tab_inactive_bg'       => '#FFFFFF',
				'tab_active_text'       => '#FFFFFF',
				'tab_inactive_text'     => '#333333',
				'content_heading'       => '為服務型生意注入秩序，讓預約、排程與付款一氣呵成',
				'tab_grid_columns'      => '2',
			),
		);
	}

	/**
	 * Default cards — bento layouts matching Storeberry reference (5 cards per tab).
	 *
	 * @return array
	 */
	private function get_default_cards() {
		$img_bottom = array(
			'image_position'  => 'bottom',
			'image_fit'       => 'contain',
			'image_max_width' => array( 'size' => 100, 'unit' => '%' ),
		);

		$img_right = array(
			'image_position'  => 'right',
			'image_fit'       => 'contain',
			'image_max_width' => array( 'size' => 100, 'unit' => '%' ),
		);

		$pad_body_bottom = array(
			'card_padding'       => $this->get_default_card_padding( '0' ),
			'card_padding_scope' => 'auto',
		);

		$pad_body_right = array(
			'card_padding'       => $this->get_default_card_padding( '24' ),
			'card_padding_scope' => 'auto',
		);

		return array(
			/* ── Tab 1: Online Store — tall left + 2 right + mid left + full bottom ── */
			array_merge(
				array(
					'tab_index'        => '1',
					'card_title'       => 'Turn URLs into sales with Instant Store',
					'card_description' => '一鍵生成網店連結，讓每一個 URL 都成為銷售入口，快速建立具 AI 靈感的線上旗艦店。',
					'card_bg_color'    => '#FFFDF5',
					'card_text_color'  => '#333333',
					'card_layout'      => 'tall',
					'card_col_span'    => '1',
					'card_row_span'    => 'tall',
				),
				$img_bottom,
				$pad_body_bottom
			),
			array_merge(
				array(
					'tab_index'        => '1',
					'card_title'       => 'StorePay Instalment',
					'card_description' => '分期付款方案，降低顧客購買門檻，提升客單價與轉換率。',
					'card_bg_color'    => '#FFFDF5',
					'card_text_color'  => '#333333',
					'card_layout'      => 'half',
					'card_col_span'    => '1',
					'card_row_span'    => 'normal',
				),
				$img_bottom,
				$pad_body_bottom
			),
			array_merge(
				array(
					'tab_index'        => '1',
					'card_title'       => 'Social Commerce',
					'card_description' => '串連 Facebook、Instagram 與 WhatsApp，把社群流量直接導向網店。',
					'card_bg_color'    => '#6254D9',
					'card_text_color'  => '#FFFFFF',
					'card_layout'      => 'image-overlap',
					'card_col_span'    => '1',
					'card_row_span'    => 'normal',
					'image_position'   => 'overlap',
					'image_fit'        => 'contain',
					'image_max_width'  => array( 'size' => 100, 'unit' => '%' ),
				)
			),
			array_merge(
				array(
					'tab_index'        => '1',
					'card_title'       => 'AI product tags and descriptions',
					'card_description' => 'AI 自動生成商品標籤與描述，節省上架時間，提升 SEO 與轉換。',
					'card_bg_color'    => '#FFFDF5',
					'card_text_color'  => '#333333',
					'card_layout'      => 'image-bottom',
					'card_col_span'    => '1',
					'card_row_span'    => 'normal',
				),
				$img_bottom,
				$pad_body_bottom
			),
			array_merge(
				array(
					'tab_index'        => '1',
					'card_title'       => 'Sell everywhere',
					'card_description' => '全渠道銷售 — 網店、社群、WhatsApp 與門市庫存同步，一個後台管理所有通路。',
					'card_bg_color'    => '#FFFDF5',
					'card_text_color'  => '#333333',
					'card_layout'      => 'wide-horizontal',
					'card_col_span'    => '2',
					'card_row_span'    => 'normal',
				),
				$img_right,
				$pad_body_right
			),

			/* ── Tab 2: Retail POS — full top + 2×2 grid ── */
			array_merge(
				array(
					'tab_index'        => '2',
					'card_title'       => 'POS 全渠道銷售系統',
					'card_description' => '門市、網店、社群庫存即時同步，店員一個介面完成查詢、下單與收款。',
					'card_bg_color'    => '#FFFFFF',
					'card_text_color'  => '#333333',
					'card_layout'      => 'image-bottom',
					'card_col_span'    => '2',
					'card_row_span'    => 'normal',
				),
				$img_bottom,
				$pad_body_bottom
			),
			array_merge(
				array(
					'tab_index'        => '2',
					'card_title'       => '條碼掃描快速結帳',
					'card_description' => '支援條碼、會員卡與多種付款方式，加快結帳流程。',
					'card_bg_color'    => '#FFFFFF',
					'card_text_color'  => '#333333',
					'card_layout'      => 'image-bottom',
					'card_col_span'    => '1',
					'card_row_span'    => 'normal',
				),
				$img_bottom,
				$pad_body_bottom
			),
			array_merge(
				array(
					'tab_index'        => '2',
					'card_title'       => '離線銷售模式',
					'card_description' => '網路中斷時仍可銷售，恢復連線後自動同步。',
					'card_bg_color'    => '#FFFFFF',
					'card_text_color'  => '#333333',
					'card_layout'      => 'image-bottom',
					'card_col_span'    => '1',
					'card_row_span'    => 'normal',
				),
				$img_bottom,
				$pad_body_bottom
			),
			array_merge(
				array(
					'tab_index'        => '2',
					'card_title'       => '會員積分與優惠',
					'card_description' => '門市與網店會員資料互通，自動累積積分與發券。',
					'card_bg_color'    => '#FFFFFF',
					'card_text_color'  => '#333333',
					'card_layout'      => 'image-bottom',
					'card_col_span'    => '1',
					'card_row_span'    => 'normal',
				),
				$img_bottom,
				$pad_body_bottom
			),
			array_merge(
				array(
					'tab_index'        => '2',
					'card_title'       => '銷售報表與分析',
					'card_description' => '即時掌握門市與全渠道業績，協助老闆快速決策。',
					'card_bg_color'    => '#FFFFFF',
					'card_text_color'  => '#333333',
					'card_layout'      => 'image-bottom',
					'card_col_span'    => '1',
					'card_row_span'    => 'normal',
				),
				$img_bottom,
				$pad_body_bottom
			),

			/* ── Tab 3: Social Commerce — 3 left + tall right (DOM order for dense grid) ── */
			array_merge(
				array(
					'tab_index'        => '3',
					'card_title'       => 'Facebook & Instagram 直播帶貨',
					'card_description' => '直播期間一鍵生成購買連結，觀眾即時下單。',
					'card_bg_color'    => '#FFF9E6',
					'card_text_color'  => '#333333',
					'card_layout'      => 'image-bottom',
					'card_col_span'    => '1',
					'card_row_span'    => 'normal',
				),
				$img_bottom,
				$pad_body_bottom
			),
			array_merge(
				array(
					'tab_index'        => '3',
					'card_title'       => '社群貼文導購',
					'card_description' => '貼文、限時動態直接連結商品頁，縮短購買路徑。',
					'card_bg_color'    => '#FFF9E6',
					'card_text_color'  => '#333333',
					'card_layout'      => 'image-bottom',
					'card_col_span'    => '1',
					'card_row_span'    => 'normal',
				),
				$img_bottom,
				$pad_body_bottom
			),
			array_merge(
				array(
					'tab_index'        => '3',
					'card_title'       => '私訊自動回覆',
					'card_description' => '常見問題自動回覆，24 小時不間斷接單。',
					'card_bg_color'    => '#FFF9E6',
					'card_text_color'  => '#333333',
					'card_layout'      => 'image-bottom',
					'card_col_span'    => '1',
					'card_row_span'    => 'normal',
				),
				$img_bottom,
				$pad_body_bottom
			),
			array_merge(
				array(
					'tab_index'        => '3',
					'card_title'       => 'KOL 合作分潤',
					'card_description' => '追蹤 KOL 導流成效，自動計算分潤與結算。',
					'card_bg_color'    => '#FFF9E6',
					'card_text_color'  => '#333333',
					'card_layout'      => 'tall',
					'card_col_span'    => '1',
					'card_row_span'    => 'tall',
				),
				$img_bottom,
				$pad_body_bottom
			),
			array_merge(
				array(
					'tab_index'        => '3',
					'card_title'       => '流量轉換分析',
					'card_description' => '分析各社群渠道轉換率，優化投放策略。',
					'card_bg_color'    => '#FFF9E6',
					'card_text_color'  => '#333333',
					'card_layout'      => 'image-bottom',
					'card_col_span'    => '1',
					'card_row_span'    => 'normal',
				),
				$img_bottom,
				$pad_body_bottom
			),

			/* ── Tab 4: WhatsApp — 2×2 with tall top row ── */
			array_merge(
				array(
					'tab_index'        => '4',
					'card_title'       => 'WhatsApp 商品目錄',
					'card_description' => '將商品目錄推送到 WhatsApp，顧客即時瀏覽與下單。',
					'card_bg_color'    => '#FFFFFF',
					'card_text_color'  => '#333333',
					'card_layout'      => 'tall',
					'card_col_span'    => '1',
					'card_row_span'    => 'tall',
				),
				$img_bottom,
				$pad_body_bottom
			),
			array_merge(
				array(
					'tab_index'        => '4',
					'card_title'       => '智能客服對話',
					'card_description' => 'AI 輔助回覆常見查詢，提升回應速度。',
					'card_bg_color'    => '#FFFFFF',
					'card_text_color'  => '#333333',
					'card_layout'      => 'tall',
					'card_col_span'    => '1',
					'card_row_span'    => 'tall',
				),
				$img_bottom,
				$pad_body_bottom
			),
			array_merge(
				array(
					'tab_index'        => '4',
					'card_title'       => '訂單狀態通知',
					'card_description' => '自動發送出貨、到貨與付款提醒。',
					'card_bg_color'    => '#FFFFFF',
					'card_text_color'  => '#333333',
					'card_layout'      => 'image-bottom',
					'card_col_span'    => '1',
					'card_row_span'    => 'normal',
				),
				$img_bottom,
				$pad_body_bottom
			),
			array_merge(
				array(
					'tab_index'        => '4',
					'card_title'       => '廣播促銷訊息',
					'card_description' => '批量發送優惠訊息給訂閱顧客，提升回購率。',
					'card_bg_color'    => '#FFFFFF',
					'card_text_color'  => '#333333',
					'card_layout'      => 'image-bottom',
					'card_col_span'    => '1',
					'card_row_span'    => 'normal',
				),
				$img_bottom,
				$pad_body_bottom
			),

			/* ── Tab 5: Booking — full top + 2 col + full bottom ── */
			array_merge(
				array(
					'tab_index'        => '5',
					'card_title'       => '線上預約排程系統',
					'card_description' => '顧客自助選擇時段，系統自動避免衝突，支援多分店排程。',
					'card_bg_color'    => '#FFFFFF',
					'card_text_color'  => '#333333',
					'card_layout'      => 'image-bottom',
					'card_col_span'    => '2',
					'card_row_span'    => 'normal',
				),
				$img_bottom,
				$pad_body_bottom
			),
			array_merge(
				array(
					'tab_index'        => '5',
					'card_title'       => '訂金與線上付款',
					'card_description' => '預約時收取訂金，降低爽約率，支援多種付款方式。',
					'card_bg_color'    => '#FFFFFF',
					'card_text_color'  => '#333333',
					'card_layout'      => 'image-bottom',
					'card_col_span'    => '1',
					'card_row_span'    => 'normal',
				),
				$img_bottom,
				$pad_body_bottom
			),
			array_merge(
				array(
					'tab_index'        => '5',
					'card_title'       => '預約確認與提醒',
					'card_description' => '自動發送確認信、SMS 及 WhatsApp 提醒。',
					'card_bg_color'    => '#FFFFFF',
					'card_text_color'  => '#333333',
					'card_layout'      => 'image-bottom',
					'card_col_span'    => '1',
					'card_row_span'    => 'normal',
				),
				$img_bottom,
				$pad_body_bottom
			),
			array_merge(
				array(
					'tab_index'        => '5',
					'card_title'       => '服務人員排班管理',
					'card_description' => '按技師、房間或設備管理排班，一目了然。',
					'card_bg_color'    => '#FFFFFF',
					'card_text_color'  => '#333333',
					'card_layout'      => 'wide-horizontal',
					'card_col_span'    => '2',
					'card_row_span'    => 'normal',
				),
				$img_right,
				$pad_body_right
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
		$tab_repeater = new \Elementor\Repeater();

		$tab_repeater->add_control(
			'tab_icon',
			array(
				'label'   => esc_html__( 'Tab Icon', 'storeberry-feature-grid-tabs' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => $this->default_icon(),
			)
		);

		$tab_repeater->add_control(
			'tab_title',
			array(
				'label'       => esc_html__( 'Tab Title', 'storeberry-feature-grid-tabs' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
				'dynamic'     => array( 'active' => true ),
			)
		);

		$tab_repeater->add_control(
			'tab_subtitle',
			array(
				'label'       => esc_html__( 'Tab Subtitle', 'storeberry-feature-grid-tabs' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
				'dynamic'     => array( 'active' => true ),
			)
		);

		$tab_repeater->add_control(
			'tab_active_bg',
			array(
				'label'   => esc_html__( 'Active Background', 'storeberry-feature-grid-tabs' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#6254D9',
			)
		);

		$tab_repeater->add_control(
			'tab_inactive_bg',
			array(
				'label'   => esc_html__( 'Inactive Background', 'storeberry-feature-grid-tabs' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
			)
		);

		$tab_repeater->add_control(
			'tab_active_text',
			array(
				'label'   => esc_html__( 'Active Text Color', 'storeberry-feature-grid-tabs' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
			)
		);

		$tab_repeater->add_control(
			'tab_inactive_text',
			array(
				'label'   => esc_html__( 'Inactive Text Color', 'storeberry-feature-grid-tabs' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#333333',
			)
		);

		$tab_repeater->add_control(
			'tab_active_icon_color',
			array(
				'label'       => esc_html__( 'Active Icon Color', 'storeberry-feature-grid-tabs' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'description' => esc_html__( 'Leave empty to inherit active text color.', 'storeberry-feature-grid-tabs' ),
			)
		);

		$tab_repeater->add_control(
			'tab_inactive_icon_color',
			array(
				'label'       => esc_html__( 'Inactive Icon Color', 'storeberry-feature-grid-tabs' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'description' => esc_html__( 'Leave empty to inherit inactive text color.', 'storeberry-feature-grid-tabs' ),
			)
		);

		$tab_repeater->add_control(
			'content_heading',
			array(
				'label'       => esc_html__( 'Section Heading (Above Cards)', 'storeberry-feature-grid-tabs' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
				'description' => esc_html__( 'Displayed above the card grid, outside the colored content box — matching the Storeberry layout.', 'storeberry-feature-grid-tabs' ),
				'dynamic'     => array( 'active' => true ),
			)
		);

		$tab_repeater->add_control(
			'tab_grid_columns',
			array(
				'label'       => esc_html__( 'Grid Columns (This Tab)', 'storeberry-feature-grid-tabs' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 4,
				'step'        => 1,
				'default'     => 2,
				'description' => esc_html__( 'Each tab can use a different column count for its card grid.', 'storeberry-feature-grid-tabs' ),
			)
		);

		$tab_repeater->add_control(
			'content_bg_color',
			array(
				'label'       => esc_html__( 'Content Area Background (Optional)', 'storeberry-feature-grid-tabs' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'default'     => '',
				'description' => esc_html__( 'Leave empty for no wrapper background. Set colors on each feature card instead.', 'storeberry-feature-grid-tabs' ),
			)
		);

		$this->start_controls_section(
			'section_tabs',
			array(
				'label' => esc_html__( 'Tabs', 'storeberry-feature-grid-tabs' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'tabs',
			array(
				'label'       => esc_html__( 'Tab Items', 'storeberry-feature-grid-tabs' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $tab_repeater->get_controls(),
				'default'     => $this->get_default_tabs(),
				'title_field' => '{{{ tab_title }}}',
			)
		);

		$this->end_controls_section();

		$card_repeater = new \Elementor\Repeater();

		$card_repeater->add_control(
			'tab_index',
			array(
				'label'   => esc_html__( 'Assign to Tab', 'storeberry-feature-grid-tabs' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '1',
				'options' => $this->get_tab_index_options(),
			)
		);

		$card_repeater->add_control(
			'card_icon',
			array(
				'label'   => esc_html__( 'Card Icon (Optional)', 'storeberry-feature-grid-tabs' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => array(),
			)
		);

		$card_repeater->add_control(
			'card_title',
			array(
				'label'       => esc_html__( 'Card Title', 'storeberry-feature-grid-tabs' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
				'dynamic'     => array( 'active' => true ),
			)
		);

		$card_repeater->add_control(
			'card_description',
			array(
				'label'       => esc_html__( 'Card Description', 'storeberry-feature-grid-tabs' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => '',
				'rows'        => 3,
				'label_block' => true,
				'dynamic'     => array( 'active' => true ),
			)
		);

		$card_repeater->add_control(
			'card_image',
			array(
				'label' => esc_html__( 'Card Image', 'storeberry-feature-grid-tabs' ),
				'type'  => \Elementor\Controls_Manager::MEDIA,
			)
		);

		$card_repeater->add_control(
			'card_image_secondary',
			array(
				'label' => esc_html__( 'Secondary Image (Optional)', 'storeberry-feature-grid-tabs' ),
				'type'  => \Elementor\Controls_Manager::MEDIA,
			)
		);

		$card_repeater->add_control(
			'card_bg_color',
			array(
				'label'   => esc_html__( 'Card Background', 'storeberry-feature-grid-tabs' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
			)
		);

		$card_repeater->add_control(
			'card_text_color',
			array(
				'label'   => esc_html__( 'Card Text Color', 'storeberry-feature-grid-tabs' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#333333',
			)
		);

		$card_repeater->add_control(
			'card_icon_color',
			array(
				'label'       => esc_html__( 'Card Icon Color', 'storeberry-feature-grid-tabs' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'default'     => '',
				'description' => esc_html__( 'Leave empty to inherit card text color.', 'storeberry-feature-grid-tabs' ),
			)
		);

		$card_repeater->add_control(
			'card_hover_heading',
			array(
				'label'     => esc_html__( 'Hover State', 'storeberry-feature-grid-tabs' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$card_repeater->add_control(
			'card_hover_bg_color',
			array(
				'label' => esc_html__( 'Hover Background', 'storeberry-feature-grid-tabs' ),
				'type'  => \Elementor\Controls_Manager::COLOR,
			)
		);

		$card_repeater->add_control(
			'card_hover_text_color',
			array(
				'label' => esc_html__( 'Hover Text Color', 'storeberry-feature-grid-tabs' ),
				'type'  => \Elementor\Controls_Manager::COLOR,
			)
		);

		$card_repeater->add_control(
			'card_hover_icon_color',
			array(
				'label' => esc_html__( 'Hover Icon Color', 'storeberry-feature-grid-tabs' ),
				'type'  => \Elementor\Controls_Manager::COLOR,
			)
		);

		$card_repeater->add_control(
			'card_layout',
			array(
				'label'   => esc_html__( 'Card Layout', 'storeberry-feature-grid-tabs' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'half',
				'options' => $this->get_card_layout_options(),
			)
		);

		$card_repeater->add_control(
			'card_col_span',
			array(
				'label'   => esc_html__( 'Column Span (Desktop)', 'storeberry-feature-grid-tabs' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '1',
				'options' => array(
					'1' => esc_html__( '1 Column', 'storeberry-feature-grid-tabs' ),
					'2' => esc_html__( '2 Columns', 'storeberry-feature-grid-tabs' ),
				),
			)
		);

		$card_repeater->add_control(
			'card_row_span',
			array(
				'label'   => esc_html__( 'Row Span (Desktop)', 'storeberry-feature-grid-tabs' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => array(
					'normal' => esc_html__( 'Normal', 'storeberry-feature-grid-tabs' ),
					'tall'   => esc_html__( 'Tall', 'storeberry-feature-grid-tabs' ),
				),
			)
		);

		$card_repeater->add_control(
			'image_position',
			array(
				'label'   => esc_html__( 'Image Position', 'storeberry-feature-grid-tabs' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'right',
				'options' => array(
					'top'     => esc_html__( 'Top', 'storeberry-feature-grid-tabs' ),
					'right'   => esc_html__( 'Right', 'storeberry-feature-grid-tabs' ),
					'bottom'  => esc_html__( 'Bottom', 'storeberry-feature-grid-tabs' ),
					'center'  => esc_html__( 'Center', 'storeberry-feature-grid-tabs' ),
					'overlap' => esc_html__( 'Overlap', 'storeberry-feature-grid-tabs' ),
				),
			)
		);

		$card_repeater->add_control(
			'image_fit',
			array(
				'label'   => esc_html__( 'Image Fit', 'storeberry-feature-grid-tabs' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'contain',
				'options' => array(
					'contain' => esc_html__( 'Contain', 'storeberry-feature-grid-tabs' ),
					'cover'   => esc_html__( 'Cover', 'storeberry-feature-grid-tabs' ),
				),
			)
		);

		$card_repeater->add_responsive_control(
			'image_max_width',
			array(
				'label'      => esc_html__( 'Image Max Width', 'storeberry-feature-grid-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 40, 'max' => 800 ),
					'%'  => array( 'min' => 10, 'max' => 100 ),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 100,
				),
			)
		);

		$card_repeater->add_control(
			'card_padding',
			array(
				'label'      => esc_html__( 'Card Padding', 'storeberry-feature-grid-tabs' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'      => '24',
					'right'    => '24',
					'bottom'   => '24',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => true,
				),
			)
		);

		$card_repeater->add_control(
			'card_padding_scope',
			array(
				'label'       => esc_html__( 'Padding Scope', 'storeberry-feature-grid-tabs' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => 'auto',
				'options'     => array(
					'auto' => esc_html__( 'Auto — image bleeds to card edge', 'storeberry-feature-grid-tabs' ),
					'body' => esc_html__( 'Text area only', 'storeberry-feature-grid-tabs' ),
					'card' => esc_html__( 'Whole card', 'storeberry-feature-grid-tabs' ),
				),
				'description' => esc_html__( 'Auto: bottom/top/right images stick to card edge without outer padding.', 'storeberry-feature-grid-tabs' ),
			)
		);

		$card_repeater->add_control(
			'card_custom_class',
			array(
				'label'       => esc_html__( 'Custom CSS Class', 'storeberry-feature-grid-tabs' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
			)
		);

		$this->start_controls_section(
			'section_cards',
			array(
				'label' => esc_html__( 'Feature Cards', 'storeberry-feature-grid-tabs' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'cards_note',
			array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Assign each card to a tab. Use Column Span (2) + Row Span (Tall) + Card Layout to build different bento grids per tab — each tab can have a unique card arrangement.', 'storeberry-feature-grid-tabs' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			)
		);

		$this->add_control(
			'cards',
			array(
				'label'       => esc_html__( 'Cards', 'storeberry-feature-grid-tabs' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $card_repeater->get_controls(),
				'default'     => $this->get_default_cards(),
				'title_field' => 'Tab {{{ tab_index }}} — {{{ card_title }}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout',
			array(
				'label' => esc_html__( 'Layout Behavior', 'storeberry-feature-grid-tabs' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'default_active_tab',
			array(
				'label'   => esc_html__( 'Default Active Tab', 'storeberry-feature-grid-tabs' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 20,
				'step'    => 1,
				'default' => 1,
			)
		);

		$this->add_control(
			'desktop_grid_columns',
			array(
				'label'       => esc_html__( 'Default Grid Columns', 'storeberry-feature-grid-tabs' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 4,
				'step'        => 1,
				'default'     => 2,
				'description' => esc_html__( 'Fallback when a tab has no per-tab column setting.', 'storeberry-feature-grid-tabs' ),
			)
		);

		$this->add_control(
			'card_gap',
			array(
				'label'      => esc_html__( 'Card Gap', 'storeberry-feature-grid-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 80 ),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 24,
				),
			)
		);

		$this->add_control(
			'mobile_card_behavior',
			array(
				'label'   => esc_html__( 'Mobile Card Behavior', 'storeberry-feature-grid-tabs' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'stack',
				'options' => array(
					'stack' => esc_html__( 'Stack Cards (1 column)', 'storeberry-feature-grid-tabs' ),
					'two'   => esc_html__( 'Keep Two Columns', 'storeberry-feature-grid-tabs' ),
				),
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
				'label' => esc_html__( 'Section', 'storeberry-feature-grid-tabs' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'section_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'storeberry-feature-grid-tabs' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .sb-feature-tabs-section' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'section_max_width',
			array(
				'label'       => esc_html__( 'Tab + Content Max Width', 'storeberry-feature-grid-tabs' ),
				'description' => esc_html__( 'Shared max width for tab bar and card panel together.', 'storeberry-feature-grid-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'vw' ),
				'range'      => array(
					'px' => array( 'min' => 400, 'max' => 1600 ),
					'%'  => array( 'min' => 50, 'max' => 100 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-feature-tabs-block' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'block_alignment',
			array(
				'label'       => esc_html__( 'Tab + Content Block Alignment', 'storeberry-feature-grid-tabs' ),
				'type'        => \Elementor\Controls_Manager::CHOOSE,
				'options'     => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'storeberry-feature-grid-tabs' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'storeberry-feature-grid-tabs' ),
						'icon'  => 'eicon-text-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'storeberry-feature-grid-tabs' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'     => 'flex-start',
				'toggle'      => false,
				'description' => esc_html__( 'Aligns the tab bar and card content as one shared block.', 'storeberry-feature-grid-tabs' ),
				'selectors'   => array(
					'{{WRAPPER}} .sb-feature-tabs-inner' => 'align-items: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'section_padding',
			array(
				'label'      => esc_html__( 'Padding', 'storeberry-feature-grid-tabs' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .sb-feature-tabs-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'section_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'storeberry-feature-grid-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 80 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-feature-tabs-section' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_tabs',
			array(
				'label' => esc_html__( 'Tab Navigation', 'storeberry-feature-grid-tabs' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'tab_nav_alignment',
			array(
				'label'       => esc_html__( 'Tab Items Alignment', 'storeberry-feature-grid-tabs' ),
				'type'        => \Elementor\Controls_Manager::CHOOSE,
				'options'     => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'storeberry-feature-grid-tabs' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'storeberry-feature-grid-tabs' ),
						'icon'  => 'eicon-text-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'storeberry-feature-grid-tabs' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'     => 'flex-start',
				'toggle'      => false,
				'description' => esc_html__( 'Only applies when Equal Width Tabs is off.', 'storeberry-feature-grid-tabs' ),
				'selectors'   => array(
					'{{WRAPPER}} .sb-feature-tabs-nav' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'tab_inner_alignment',
			array(
				'label'     => esc_html__( 'Tab Content Alignment', 'storeberry-feature-grid-tabs' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'storeberry-feature-grid-tabs' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'storeberry-feature-grid-tabs' ),
						'icon'  => 'eicon-text-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'storeberry-feature-grid-tabs' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'flex-start',
				'toggle'    => false,
				'selectors' => array(
					'{{WRAPPER}} .sb-feature-tabs-tab' => 'align-items: {{VALUE}};',
					'{{WRAPPER}} .sb-feature-tabs-tab-text' => 'align-items: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_items_equal_width',
			array(
				'label'        => esc_html__( 'Equal Width Tabs', 'storeberry-feature-grid-tabs' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'storeberry-feature-grid-tabs' ),
				'label_off'    => esc_html__( 'No', 'storeberry-feature-grid-tabs' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'description'  => esc_html__( 'Spread tabs evenly to match the content panel width below (recommended).', 'storeberry-feature-grid-tabs' ),
				'prefix_class' => 'sb-feature-tabs-equal-width-',
			)
		);

		$this->add_control(
			'link_tab_content_width',
			array(
				'label'        => esc_html__( 'Link Tab & Content Width', 'storeberry-feature-grid-tabs' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'storeberry-feature-grid-tabs' ),
				'label_off'    => esc_html__( 'No', 'storeberry-feature-grid-tabs' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'description'  => esc_html__( 'Keeps tab bar and card panel the same width as one block.', 'storeberry-feature-grid-tabs' ),
				'prefix_class' => 'sb-feature-tabs-linked-',
			)
		);

		$this->add_responsive_control(
			'tab_gap',
			array(
				'label'      => esc_html__( 'Tab Gap', 'storeberry-feature-grid-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 40 ),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 12,
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-feature-tabs-nav' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'tab_item_width',
			array(
				'label'      => esc_html__( 'Tab Item Min Width', 'storeberry-feature-grid-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 80, 'max' => 320 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-feature-tabs-tab' => 'min-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'tab_padding',
			array(
				'label'      => esc_html__( 'Tab Padding', 'storeberry-feature-grid-tabs' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'top'    => '16',
					'right'  => '20',
					'bottom' => '16',
					'left'   => '20',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-feature-tabs-tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'tab_border_radius',
			array(
				'label'      => esc_html__( 'Tab Border Radius', 'storeberry-feature-grid-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 40 ),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 12,
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-feature-tabs-tab' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'tab_icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'storeberry-feature-grid-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 12, 'max' => 64 ),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 24,
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-feature-tabs-tab-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .sb-feature-tabs-tab-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'tab_title_typography',
				'label'    => esc_html__( 'Title Typography', 'storeberry-feature-grid-tabs' ),
				'selector' => '{{WRAPPER}} .sb-feature-tabs-tab-title',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'tab_subtitle_typography',
				'label'    => esc_html__( 'Subtitle Typography', 'storeberry-feature-grid-tabs' ),
				'selector' => '{{WRAPPER}} .sb-feature-tabs-tab-subtitle',
			)
		);

		$this->add_control(
			'tab_icon_colors_heading',
			array(
				'label'     => esc_html__( 'Icon Colors', 'storeberry-feature-grid-tabs' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'tab_icon_color_inactive',
			array(
				'label'     => esc_html__( 'Inactive Icon Color', 'storeberry-feature-grid-tabs' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .sb-feature-tabs-tab:not(.is-active) .sb-feature-tabs-tab-icon' => 'color: {{VALUE}}; --sb-ft-tab-icon-inactive: {{VALUE}};',
					'{{WRAPPER}} .sb-feature-tabs-tab:not(.is-active) .sb-feature-tabs-tab-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sb-feature-tabs-tab:not(.is-active) .sb-feature-tabs-tab-icon svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .sb-feature-tabs-tab:not(.is-active) .sb-feature-tabs-tab-icon svg path' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_icon_color_inactive_hover',
			array(
				'label'     => esc_html__( 'Inactive Hover Icon Color', 'storeberry-feature-grid-tabs' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .sb-feature-tabs-tab:not(.is-active):hover .sb-feature-tabs-tab-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sb-feature-tabs-tab:not(.is-active):hover .sb-feature-tabs-tab-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sb-feature-tabs-tab:not(.is-active):hover .sb-feature-tabs-tab-icon svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .sb-feature-tabs-tab:not(.is-active):hover .sb-feature-tabs-tab-icon svg path' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_icon_color_active',
			array(
				'label'     => esc_html__( 'Active Icon Color', 'storeberry-feature-grid-tabs' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .sb-feature-tabs-tab.is-active .sb-feature-tabs-tab-icon' => 'color: {{VALUE}}; --sb-ft-tab-icon-active: {{VALUE}};',
					'{{WRAPPER}} .sb-feature-tabs-tab.is-active .sb-feature-tabs-tab-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sb-feature-tabs-tab.is-active .sb-feature-tabs-tab-icon svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .sb-feature-tabs-tab.is-active .sb-feature-tabs-tab-icon svg path' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_icon_color_active_hover',
			array(
				'label'     => esc_html__( 'Active Hover Icon Color', 'storeberry-feature-grid-tabs' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .sb-feature-tabs-tab.is-active:hover .sb-feature-tabs-tab-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sb-feature-tabs-tab.is-active:hover .sb-feature-tabs-tab-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sb-feature-tabs-tab.is-active:hover .sb-feature-tabs-tab-icon svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .sb-feature-tabs-tab.is-active:hover .sb-feature-tabs-tab-icon svg path' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_inactive_bg_fallback',
			array(
				'label'     => esc_html__( 'Inactive Tab BG Fallback', 'storeberry-feature-grid-tabs' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => array(
					'{{WRAPPER}} .sb-feature-tabs-section' => '--sb-ft-inactive-bg-fallback: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_active_bg_fallback',
			array(
				'label'     => esc_html__( 'Active Tab BG Fallback', 'storeberry-feature-grid-tabs' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6254D9',
				'selectors' => array(
					'{{WRAPPER}} .sb-feature-tabs-section' => '--sb-ft-active-bg-fallback: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_heading',
			array(
				'label' => esc_html__( 'Content Heading', 'storeberry-feature-grid-tabs' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_color',
			array(
				'label'     => esc_html__( 'Color', 'storeberry-feature-grid-tabs' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .sb-feature-tabs-panel-heading' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .sb-feature-tabs-panel-heading',
			)
		);

		$this->add_responsive_control(
			'heading_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'storeberry-feature-grid-tabs' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'storeberry-feature-grid-tabs' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'storeberry-feature-grid-tabs' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'storeberry-feature-grid-tabs' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .sb-feature-tabs-panel-heading' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'heading_margin_bottom',
			array(
				'label'      => esc_html__( 'Margin Bottom', 'storeberry-feature-grid-tabs' ),
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
					'{{WRAPPER}} .sb-feature-tabs-panel-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_cards',
			array(
				'label' => esc_html__( 'Cards', 'storeberry-feature-grid-tabs' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'card_padding',
			array(
				'label'       => esc_html__( 'Fallback Card Padding', 'storeberry-feature-grid-tabs' ),
				'description' => esc_html__( 'Used only when a card has no per-card padding set in Feature Cards repeater.', 'storeberry-feature-grid-tabs' ),
				'type'        => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units'  => array( 'px', 'em' ),
				'default'     => array(
					'top'    => '24',
					'right'  => '24',
					'bottom' => '24',
					'left'   => '24',
					'unit'   => 'px',
				),
				'selectors'   => array(
					'{{WRAPPER}} .sb-feature-tabs-card:not([style*="padding"]):not(.sb-feature-tabs-card--body-pad)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'card_border_radius',
			array(
				'label'      => esc_html__( 'Card Border Radius', 'storeberry-feature-grid-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 40 ),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 16,
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-feature-tabs-card' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'card_title_typography',
				'label'    => esc_html__( 'Title Typography', 'storeberry-feature-grid-tabs' ),
				'selector' => '{{WRAPPER}} .sb-feature-tabs-card-title',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'card_desc_typography',
				'label'    => esc_html__( 'Description Typography', 'storeberry-feature-grid-tabs' ),
				'selector' => '{{WRAPPER}} .sb-feature-tabs-card-desc',
			)
		);

		$this->add_responsive_control(
			'card_image_border_radius',
			array(
				'label'      => esc_html__( 'Image Border Radius', 'storeberry-feature-grid-tabs' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 40 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .sb-feature-tabs-card-media img' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'card_overflow_hidden',
			array(
				'label'        => esc_html__( 'Overflow Hidden', 'storeberry-feature-grid-tabs' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'storeberry-feature-grid-tabs' ),
				'label_off'    => esc_html__( 'No', 'storeberry-feature-grid-tabs' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'selectors'    => array(
					'{{WRAPPER}} .sb-feature-tabs-card' => 'overflow: hidden;',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_responsive',
			array(
				'label' => esc_html__( 'Responsive', 'storeberry-feature-grid-tabs' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'tablet_grid_columns',
			array(
				'label'   => esc_html__( 'Tablet Grid Columns', 'storeberry-feature-grid-tabs' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 4,
				'step'    => 1,
				'default' => 2,
			)
		);

		$this->add_control(
			'mobile_grid_columns',
			array(
				'label'   => esc_html__( 'Mobile Grid Columns', 'storeberry-feature-grid-tabs' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 2,
				'step'    => 1,
				'default' => 1,
			)
		);

		$this->add_control(
			'mobile_tab_scroll',
			array(
				'label'        => esc_html__( 'Mobile Tab Horizontal Scroll', 'storeberry-feature-grid-tabs' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'storeberry-feature-grid-tabs' ),
				'label_off'    => esc_html__( 'No', 'storeberry-feature-grid-tabs' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Build inline style for a tab button.
	 *
	 * @param array $tab Tab settings.
	 * @return string
	 */
	private function get_tab_inline_style( $tab ) {
		$styles = array();

		if ( ! empty( $tab['tab_active_bg'] ) ) {
			$styles[] = '--sb-ft-tab-active-bg: ' . sanitize_hex_color( $tab['tab_active_bg'] ) . ';';
		}

		if ( ! empty( $tab['tab_inactive_bg'] ) ) {
			$styles[] = '--sb-ft-tab-inactive-bg: ' . sanitize_hex_color( $tab['tab_inactive_bg'] ) . ';';
		}

		if ( ! empty( $tab['tab_active_text'] ) ) {
			$styles[] = '--sb-ft-tab-active-color: ' . sanitize_hex_color( $tab['tab_active_text'] ) . ';';
		}

		if ( ! empty( $tab['tab_inactive_text'] ) ) {
			$styles[] = '--sb-ft-tab-inactive-color: ' . sanitize_hex_color( $tab['tab_inactive_text'] ) . ';';
		}

		if ( ! empty( $tab['tab_active_icon_color'] ) ) {
			$styles[] = '--sb-ft-tab-icon-active: ' . sanitize_hex_color( $tab['tab_active_icon_color'] ) . ';';
		}

		if ( ! empty( $tab['tab_inactive_icon_color'] ) ) {
			$styles[] = '--sb-ft-tab-icon-inactive: ' . sanitize_hex_color( $tab['tab_inactive_icon_color'] ) . ';';
		}

		return implode( ' ', $styles );
	}

	private function get_default_card_padding( $bottom = '24' ) {
		return array(
			'top'      => '24',
			'right'    => '24',
			'bottom'   => (string) $bottom,
			'left'     => '24',
			'unit'     => 'px',
			'isLinked' => false,
		);
	}

	/**
	 * Build CSS dimensions string.
	 *
	 * @param array  $dimensions Dimension values.
	 * @param string $property   CSS property name.
	 * @return string
	 */
	private function build_dimensions_css( $dimensions, $property = 'padding' ) {
		if ( empty( $dimensions ) || ! is_array( $dimensions ) ) {
			return '';
		}

		$unit   = ! empty( $dimensions['unit'] ) ? $dimensions['unit'] : 'px';
		$top    = isset( $dimensions['top'] ) && '' !== $dimensions['top'] ? $dimensions['top'] : '0';
		$right  = isset( $dimensions['right'] ) && '' !== $dimensions['right'] ? $dimensions['right'] : '0';
		$bottom = isset( $dimensions['bottom'] ) && '' !== $dimensions['bottom'] ? $dimensions['bottom'] : '0';
		$left   = isset( $dimensions['left'] ) && '' !== $dimensions['left'] ? $dimensions['left'] : '0';

		return sprintf(
			'%1$s:%2$s%6$s %3$s%6$s %4$s%6$s %5$s%6$s;',
			$property,
			$top,
			$right,
			$bottom,
			$left,
			$unit
		);
	}

	/**
	 * Whether card padding applies to text body only (image bleeds to edge).
	 *
	 * @param array $card Card settings.
	 * @return bool
	 */
	private function card_uses_body_padding( $card ) {
		$scope = isset( $card['card_padding_scope'] ) ? $card['card_padding_scope'] : 'auto';

		if ( 'body' === $scope ) {
			return true;
		}

		if ( 'card' === $scope ) {
			return false;
		}

		$pos    = isset( $card['image_position'] ) ? sanitize_key( $card['image_position'] ) : 'right';
		$layout = isset( $card['card_layout'] ) ? sanitize_key( $card['card_layout'] ) : 'half';

		if ( in_array( $pos, array( 'bottom', 'top', 'right' ), true ) ) {
			return true;
		}

		if ( in_array( $layout, array( 'image-bottom', 'image-right', 'wide-horizontal', 'full-image', 'tall', 'half', 'image-overlap' ), true ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Resolve per-card padding for card shell and text body.
	 *
	 * @param array $card             Card settings.
	 * @param array $fallback_padding Widget fallback padding.
	 * @return array
	 */
	private function get_card_padding_data( $card, $fallback_padding = null ) {
		$dimensions = array();

		if ( ! empty( $card['card_padding'] ) && is_array( $card['card_padding'] ) ) {
			$dimensions = $card['card_padding'];
		} elseif ( ! empty( $fallback_padding ) && is_array( $fallback_padding ) ) {
			$dimensions = $fallback_padding;
		} else {
			$dimensions = $this->get_default_card_padding();
		}

		$use_body    = $this->card_uses_body_padding( $card );
		$padding_css = $this->build_dimensions_css( $dimensions, 'padding' );

		return array(
			'use_body' => $use_body,
			'card'     => $use_body ? 'padding:0;' : $padding_css,
			'body'     => $use_body ? $padding_css : '',
		);
	}

	/**
	 * Get cards for a specific tab index (1-based).
	 *
	 * @param array $all_cards All cards.
	 * @param int   $tab_index Tab index (1-based).
	 * @return array
	 */
	private function get_cards_for_tab( $all_cards, $tab_index ) {
		$filtered = array();

		foreach ( $all_cards as $card ) {
			$card_tab = isset( $card['tab_index'] ) ? absint( $card['tab_index'] ) : 0;
			if ( $card_tab === $tab_index ) {
				$filtered[] = $card;
			}
		}

		return $filtered;
	}

	/**
	 * Sanitize color for inline CSS.
	 *
	 * @param string $color Color value.
	 * @return string
	 */
	private function sanitize_css_color( $color ) {
		if ( empty( $color ) ) {
			return '';
		}

		$hex = sanitize_hex_color( $color );
		if ( $hex ) {
			return $hex;
		}

		if ( preg_match( '/^rgba?\([^)]+\)$/i', trim( $color ) ) ) {
			return trim( $color );
		}

		return '';
	}

	/**
	 * Build card CSS classes.
	 *
	 * @param array $card Card settings.
	 * @return string
	 */
	private function get_card_classes( $card ) {
		$classes = array( 'sb-feature-tabs-card' );

		$layout = isset( $card['card_layout'] ) ? sanitize_key( $card['card_layout'] ) : 'half';
		$classes[] = 'sb-feature-tabs-card--layout-' . $layout;

		$col_span = isset( $card['card_col_span'] ) ? $card['card_col_span'] : '1';
		$classes[] = '2' === (string) $col_span ? 'sb-feature-tabs-card--span-2' : 'sb-feature-tabs-card--span-1';

		$row_span = isset( $card['card_row_span'] ) ? $card['card_row_span'] : 'normal';
		if ( 'tall' === $row_span ) {
			$classes[] = 'sb-feature-tabs-card--tall';
		}

		$image_pos = isset( $card['image_position'] ) ? sanitize_key( $card['image_position'] ) : 'right';
		$classes[] = 'sb-feature-tabs-card--img-' . $image_pos;

		if ( ! empty( $card['card_custom_class'] ) ) {
			$custom = preg_replace( '/[^a-zA-Z0-9_\- ]/', '', $card['card_custom_class'] );
			if ( $custom ) {
				$classes[] = $custom;
			}
		}

		if ( $this->card_uses_body_padding( $card ) ) {
			$classes[] = 'sb-feature-tabs-card--body-pad';
		}

		if (
			! empty( $card['card_hover_bg_color'] )
			|| ! empty( $card['card_hover_text_color'] )
			|| ! empty( $card['card_hover_icon_color'] )
		) {
			$classes[] = 'sb-feature-tabs-card--has-hover';
		}

		return implode( ' ', array_filter( $classes ) );
	}

	/**
	 * Build card inline style.
	 *
	 * @param array $card Card settings.
	 * @return string
	 */
	private function get_card_inline_style( $card ) {
		$styles = array();

		$bg = ! empty( $card['card_bg_color'] ) ? $this->sanitize_css_color( $card['card_bg_color'] ) : '';
		if ( $bg ) {
			$styles[] = '--sb-ft-card-bg:' . $bg . ';';
			$styles[] = 'background-color:var(--sb-ft-card-bg);';
		}

		$text = ! empty( $card['card_text_color'] ) ? $this->sanitize_css_color( $card['card_text_color'] ) : '';
		if ( $text ) {
			$styles[] = '--sb-ft-card-color:' . $text . ';';
			$styles[] = 'color:var(--sb-ft-card-color);';
		}

		$icon = ! empty( $card['card_icon_color'] ) ? $this->sanitize_css_color( $card['card_icon_color'] ) : '';
		if ( $icon ) {
			$styles[] = '--sb-ft-card-icon-color:' . $icon . ';';
		}

		$hover_bg = ! empty( $card['card_hover_bg_color'] ) ? $this->sanitize_css_color( $card['card_hover_bg_color'] ) : '';
		if ( $hover_bg ) {
			$styles[] = '--sb-ft-card-hover-bg:' . $hover_bg . ';';
		}

		$hover_text = ! empty( $card['card_hover_text_color'] ) ? $this->sanitize_css_color( $card['card_hover_text_color'] ) : '';
		if ( $hover_text ) {
			$styles[] = '--sb-ft-card-hover-color:' . $hover_text . ';';
		}

		$hover_icon = ! empty( $card['card_hover_icon_color'] ) ? $this->sanitize_css_color( $card['card_hover_icon_color'] ) : '';
		if ( $hover_icon ) {
			$styles[] = '--sb-ft-card-hover-icon-color:' . $hover_icon . ';';
		}

		$max_w = isset( $card['image_max_width'] ) ? $card['image_max_width'] : array();
		if ( ! empty( $max_w['size'] ) && ! empty( $max_w['unit'] ) ) {
			$styles[] = '--sb-ft-card-img-max-w: ' . floatval( $max_w['size'] ) . esc_attr( $max_w['unit'] ) . ';';
		}

		$fit = isset( $card['image_fit'] ) ? sanitize_key( $card['image_fit'] ) : 'contain';
		$styles[] = '--sb-ft-card-img-fit: ' . ( 'cover' === $fit ? 'cover' : 'contain' ) . ';';

		return implode( ' ', $styles );
	}

	/**
	 * Render card image.
	 *
	 * @param array  $media Media control value.
	 * @param string $alt   Alt text.
	 * @param string $class Extra class.
	 */
	private function render_card_image( $media, $alt, $class = '' ) {
		if ( empty( $media['id'] ) && empty( $media['url'] ) ) {
			return;
		}

		$img_class = 'sb-feature-tabs-card-img' . ( $class ? ' ' . esc_attr( $class ) : '' );

		if ( ! empty( $media['id'] ) ) {
			$image_html = wp_get_attachment_image(
				absint( $media['id'] ),
				'large',
				false,
				array(
					'class'   => $img_class,
					'alt'     => $alt,
					'loading' => 'lazy',
				)
			);

			if ( $image_html ) {
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $image_html;
				return;
			}
		}

		if ( ! empty( $media['url'] ) ) {
			printf(
				'<img class="%1$s" src="%2$s" alt="%3$s" loading="lazy" />',
				esc_attr( $img_class ),
				esc_url( $media['url'] ),
				esc_attr( $alt )
			);
		}
	}

	/**
	 * Render a single card.
	 *
	 * @param array $card             Card settings.
	 * @param array $fallback_padding Widget fallback padding.
	 */
	private function render_card( $card, $fallback_padding = null ) {
		$title        = isset( $card['card_title'] ) ? $card['card_title'] : '';
		$desc         = isset( $card['card_description'] ) ? $card['card_description'] : '';
		$alt          = $title ? $title : esc_html__( 'Feature image', 'storeberry-feature-grid-tabs' );
		$padding_data = $this->get_card_padding_data( $card, $fallback_padding );
		$card_style   = trim( $this->get_card_inline_style( $card ) . ' ' . $padding_data['card'] );
		$body_style   = $padding_data['body'];
		?>
		<article class="<?php echo esc_attr( $this->get_card_classes( $card ) ); ?>" style="<?php echo esc_attr( $card_style ); ?>">
			<div class="sb-feature-tabs-card-body"<?php echo $body_style ? ' style="' . esc_attr( $body_style ) . '"' : ''; ?>>
				<?php if ( ! empty( $card['card_icon']['value'] ) ) : ?>
					<span class="sb-feature-tabs-card-icon" aria-hidden="true">
						<?php
						\Elementor\Icons_Manager::render_icon(
							$card['card_icon'],
							array( 'aria-hidden' => 'true' )
						);
						?>
					</span>
				<?php endif; ?>

				<?php if ( $title ) : ?>
					<h3 class="sb-feature-tabs-card-title"><?php echo esc_html( $title ); ?></h3>
				<?php endif; ?>

				<?php if ( $desc ) : ?>
					<p class="sb-feature-tabs-card-desc"><?php echo esc_html( $desc ); ?></p>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $card['card_image']['url'] ) || ! empty( $card['card_image']['id'] ) ) : ?>
				<div class="sb-feature-tabs-card-media sb-feature-tabs-card-media--primary">
					<?php $this->render_card_image( $card['card_image'], $alt ); ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $card['card_image_secondary']['url'] ) || ! empty( $card['card_image_secondary']['id'] ) ) : ?>
				<div class="sb-feature-tabs-card-media sb-feature-tabs-card-media--secondary">
					<?php $this->render_card_image( $card['card_image_secondary'], $alt, 'sb-feature-tabs-card-img-secondary' ); ?>
				</div>
			<?php endif; ?>
		</article>
		<?php
	}

	/**
	 * Render widget output.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$tabs     = ! empty( $settings['tabs'] ) && is_array( $settings['tabs'] ) ? $settings['tabs'] : array();
		$cards    = ! empty( $settings['cards'] ) && is_array( $settings['cards'] ) ? $settings['cards'] : array();

		if ( empty( $tabs ) ) {
			return;
		}

		$default_tab   = ! empty( $settings['default_active_tab'] ) ? absint( $settings['default_active_tab'] ) : 1;
		$default_index = max( 0, $default_tab - 1 );

		if ( $default_index >= count( $tabs ) ) {
			$default_index = 0;
		}

		$desktop_cols = ! empty( $settings['desktop_grid_columns'] ) ? absint( $settings['desktop_grid_columns'] ) : 2;
		$tablet_cols  = ! empty( $settings['tablet_grid_columns'] ) ? absint( $settings['tablet_grid_columns'] ) : 2;
		$mobile_cols  = ! empty( $settings['mobile_grid_columns'] ) ? absint( $settings['mobile_grid_columns'] ) : 1;

		if ( isset( $settings['mobile_card_behavior'] ) && 'two' === $settings['mobile_card_behavior'] ) {
			$mobile_cols = 2;
		}

		$card_gap = 24;
		if ( ! empty( $settings['card_gap']['size'] ) ) {
			$card_gap = absint( $settings['card_gap']['size'] );
		}

		$mobile_scroll = ( ! isset( $settings['mobile_tab_scroll'] ) || 'yes' === $settings['mobile_tab_scroll'] ) ? 'yes' : 'no';

		$instance_id = 'sb-ft-' . esc_attr( $this->get_id() );
		$element_id  = esc_attr( $this->get_id() );

		$section_style = sprintf(
			'--sb-ft-grid-cols:%1$d;--sb-ft-grid-cols-tablet:%2$d;--sb-ft-grid-cols-mobile:%3$d;--sb-ft-card-gap:%4$dpx;--sb-ft-tab-count:%5$d;',
			max( 1, $desktop_cols ),
			max( 1, $tablet_cols ),
			max( 1, $mobile_cols ),
			$card_gap,
			count( $tabs )
		);
		?>
		<div
			class="sb-feature-tabs-section<?php echo 'yes' === $mobile_scroll ? ' sb-feature-tabs-section--mobile-scroll' : ''; ?>"
			data-default-tab="<?php echo esc_attr( (string) $default_index ); ?>"
			style="<?php echo esc_attr( $section_style ); ?>"
		>
			<div class="sb-feature-tabs-inner">
				<div class="sb-feature-tabs-block">
				<div class="sb-feature-tabs-nav" role="tablist" aria-label="<?php echo esc_attr__( 'Feature tabs', 'storeberry-feature-grid-tabs' ); ?>">
					<?php foreach ( $tabs as $index => $tab ) : ?>
						<?php
						$is_active   = (int) $index === (int) $default_index;
						$tab_id      = $instance_id . '-tab-' . (int) $index;
						$panel_id    = $instance_id . '-panel-' . (int) $index;
						$tab_style   = $this->get_tab_inline_style( $tab );
						$tab_classes = 'sb-feature-tabs-tab' . ( $is_active ? ' is-active' : '' );
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
							<?php if ( ! empty( $tab['tab_icon']['value'] ) ) : ?>
								<span class="sb-feature-tabs-tab-icon" aria-hidden="true">
									<?php
									\Elementor\Icons_Manager::render_icon(
										$tab['tab_icon'],
										array( 'aria-hidden' => 'true' )
									);
									?>
								</span>
							<?php endif; ?>

							<span class="sb-feature-tabs-tab-text">
								<?php if ( ! empty( $tab['tab_title'] ) ) : ?>
									<span class="sb-feature-tabs-tab-title"><?php echo esc_html( $tab['tab_title'] ); ?></span>
								<?php endif; ?>

								<?php if ( ! empty( $tab['tab_subtitle'] ) ) : ?>
									<span class="sb-feature-tabs-tab-subtitle"><?php echo esc_html( $tab['tab_subtitle'] ); ?></span>
								<?php endif; ?>
							</span>
						</div>
					<?php endforeach; ?>
				</div>

				<div class="sb-feature-tabs-panels">
					<?php foreach ( $tabs as $index => $tab ) : ?>
						<?php
						$is_active    = (int) $index === (int) $default_index;
						$tab_id       = $instance_id . '-tab-' . (int) $index;
						$panel_id     = $instance_id . '-panel-' . (int) $index;
						$tab_cards    = $this->get_cards_for_tab( $cards, $index + 1 );
						$tab_cols     = ! empty( $tab['tab_grid_columns'] ) ? absint( $tab['tab_grid_columns'] ) : $desktop_cols;
						$tab_cols     = max( 1, min( 4, $tab_cols ) );
						$grid_style   = sprintf( '--sb-ft-grid-cols:%d;', $tab_cols );
						$area_bg      = ! empty( $tab['content_bg_color'] ) ? sanitize_hex_color( $tab['content_bg_color'] ) : '';
						if ( $area_bg ) {
							$grid_style .= ' background-color:' . $area_bg . ';';
						}
						?>
						<div
							class="sb-feature-tabs-panel-wrap<?php echo $is_active ? ' is-active' : ''; ?>"
							role="tabpanel"
							id="<?php echo esc_attr( $panel_id ); ?>"
							aria-labelledby="<?php echo esc_attr( $tab_id ); ?>"
							<?php echo $is_active ? '' : 'hidden'; ?>
						>
							<?php if ( ! empty( $tab['content_heading'] ) ) : ?>
								<h2 class="sb-feature-tabs-panel-heading"><?php echo esc_html( $tab['content_heading'] ); ?></h2>
							<?php endif; ?>

							<?php if ( ! empty( $tab_cards ) ) : ?>
								<div class="sb-feature-tabs-cards-grid" style="<?php echo esc_attr( $grid_style ); ?>">
									<?php foreach ( $tab_cards as $card ) : ?>
										<?php
										$fallback_pad = ! empty( $settings['card_padding'] ) ? $settings['card_padding'] : null;
										$this->render_card( $card, $fallback_pad );
										?>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
				</div>
			</div>
		</div>
		<?php
	}
}
