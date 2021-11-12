<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link  https://makewebbetter.com/
 * @since 1.0.0
 *
 * @package    woo-refund-and-exchange-lite
 * @subpackage woo-refund-and-exchange-lite/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    woo-refund-and-exchange-lite
 * @subpackage woo-refund-and-exchange-lite/admin
 */
class Woo_Refund_And_Exchange_Lite_Admin {


	/**
	 * The ID of this plugin.
	 *
	 * @since 1.0.0
	 * @var   string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since 1.0.0
	 * @var   string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since 1.0.0
	 * @param string $hook The plugin page slug.
	 */
	public function wrael_admin_enqueue_styles( $hook ) {
		$screen = get_current_screen();
		// multistep form css.
		if ( ! mwb_rma_standard_check_multistep() && mwb_rma_pro_active() ) {
			$style_url        = WOO_REFUND_AND_EXCHANGE_LITE_DIR_URL . 'build/style-index.css';
			wp_enqueue_style(
				'mwb-admin-react-styles',
				$style_url,
				array(),
				time(),
				false
			);
			return;
		}
		if ( isset( $screen->id ) && 'makewebbetter_page_woo_refund_and_exchange_lite_menu' === $screen->id ) {

			wp_enqueue_style( 'mwb-wrael-select2-css', WOO_REFUND_AND_EXCHANGE_LITE_DIR_URL . 'package/lib/select-2/woo-refund-and-exchange-lite-select2.css', array(), time(), 'all' );

			wp_enqueue_style( 'mwb-wrael-meterial-css', WOO_REFUND_AND_EXCHANGE_LITE_DIR_URL . 'package/lib/material-design/material-components-web.min.css', array(), time(), 'all' );
			wp_enqueue_style( 'mwb-wrael-meterial-css2', WOO_REFUND_AND_EXCHANGE_LITE_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.css', array(), time(), 'all' );
			wp_enqueue_style( 'mwb-wrael-meterial-lite', WOO_REFUND_AND_EXCHANGE_LITE_DIR_URL . 'package/lib/material-design/material-lite.min.css', array(), time(), 'all' );

			wp_enqueue_style( 'mwb-wrael-meterial-icons-css', WOO_REFUND_AND_EXCHANGE_LITE_DIR_URL . 'package/lib/material-design/icon.css', array(), time(), 'all' );

			wp_enqueue_style( 'mwb-admin-min-css', WOO_REFUND_AND_EXCHANGE_LITE_DIR_URL . 'admin/css/mwb-admin.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'mwb-datatable-css', WOO_REFUND_AND_EXCHANGE_LITE_DIR_URL . 'package/lib/datatables/media/css/jquery.dataTables.min.css', array(), $this->version, 'all' );
		}
		if ( isset( $screen->id ) && 'shop_order' === $screen->id ) {
			wp_enqueue_style( $this->plugin_name, WOO_REFUND_AND_EXCHANGE_LITE_DIR_URL . 'admin/css/mwb-order-edit-page-lite.min.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since 1.0.0
	 * @param string $hook The plugin page slug.
	 */
	public function wrael_admin_enqueue_scripts( $hook ) {
		$screen     = get_current_screen();
		$pro_active = mwb_rma_pro_active();
		if ( isset( $screen->id ) && 'makewebbetter_page_woo_refund_and_exchange_lite_menu' === $screen->id ) {
			if ( ! mwb_rma_standard_check_multistep() && mwb_rma_pro_active() ) {
				// js for the multistep from.
				$script_path       = '../../build/index.js';
				$script_asset_path = WOO_REFUND_AND_EXCHANGE_LITE_DIR_PATH . 'build/index.asset.php';
				$script_asset      = file_exists( $script_asset_path )
					? require $script_asset_path
					: array(
						'dependencies' => array(
							'wp-hooks',
							'wp-element',
							'wp-i18n',
							'wc-components',
						),
						'version'      => filemtime( $script_path ),
					);
				$script_url = WOO_REFUND_AND_EXCHANGE_LITE_DIR_URL . 'build/index.js';
				wp_register_script(
					'react-app-block',
					$script_url,
					$script_asset['dependencies'],
					$script_asset['version'],
					true
				);
				wp_enqueue_script( 'react-app-block' );
				wp_localize_script(
					'react-app-block',
					'frontend_ajax_object',
					array(
						'ajaxurl'            => admin_url( 'admin-ajax.php' ),
						'mwb_standard_nonce' => wp_create_nonce( 'ajax-nonce' ),
						'redirect_url'       => admin_url( 'admin.php?page=woo_refund_and_exchange_lite_menu' ),
					)
				);
				return;
			}
		}
		if ( isset( $screen->id ) && 'makewebbetter_page_woo_refund_and_exchange_lite_menu' === $screen->id || 'shop_order' === $screen->id ) {
			wp_enqueue_script( 'mwb-wrael-select2', WOO_REFUND_AND_EXCHANGE_LITE_DIR_URL . 'package/lib/select-2/woo-refund-and-exchange-lite-select2.js', array( 'jquery' ), time(), false );
			wp_enqueue_script( 'mwb-wrael-metarial-js', WOO_REFUND_AND_EXCHANGE_LITE_DIR_URL . 'package/lib/material-design/material-components-web.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-wrael-metarial-js2', WOO_REFUND_AND_EXCHANGE_LITE_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-wrael-metarial-lite', WOO_REFUND_AND_EXCHANGE_LITE_DIR_URL . 'package/lib/material-design/material-lite.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-wrael-datatable', WOO_REFUND_AND_EXCHANGE_LITE_DIR_URL . 'package/lib/datatables.net/js/jquery.dataTables.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-wrael-datatable-btn', WOO_REFUND_AND_EXCHANGE_LITE_DIR_URL . 'package/lib/datatables.net/buttons/dataTables.buttons.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-wrael-datatable-btn-2', WOO_REFUND_AND_EXCHANGE_LITE_DIR_URL . 'package/lib/datatables.net/buttons/buttons.html5.min.js', array(), time(), false );
			wp_register_script( $this->plugin_name . 'admin-js', WOO_REFUND_AND_EXCHANGE_LITE_DIR_URL . 'admin/js/mwb-admin.min.js', array( 'jquery', 'mwb-wrael-select2', 'mwb-wrael-metarial-js', 'mwb-wrael-metarial-js2', 'mwb-wrael-metarial-lite' ), $this->version, false );
			wp_localize_script(
				$this->plugin_name . 'admin-js',
				'wrael_admin_param',
				array(
					'ajaxurl'                    => admin_url( 'admin-ajax.php' ),
					'reloadurl'                  => admin_url( 'admin.php?page=woo_refund_and_exchange_lite_menu' ),
					'wrael_gen_tab_enable'       => get_option( 'wrael_radio_switch_demo' ),
					'mwb_rma_nonce'              => wp_create_nonce( 'mwb_rma_ajax_seurity' ),
					'wrael_admin_param_location' => ( admin_url( 'admin.php' ) . '?page=woo_refund_and_exchange_lite_menu&wrael_tab=woo-refund-and-exchange-lite-general' ),
					'check_pro_active'           => esc_html( $pro_active ),
				)
			);
			wp_enqueue_script( $this->plugin_name . 'admin-js' );
		}
	}

	/**
	 * Adding settings menu for Woo Refund And Exchange Lite.
	 *
	 * @since 1.0.0
	 */
	public function wrael_options_page() {
		global $submenu;
		if ( empty( $GLOBALS['admin_page_hooks']['mwb-plugins'] ) ) {
			add_menu_page( esc_html__( 'MakeWebBetter', 'woo-refund-and-exchange-lite' ), esc_html__( 'MakeWebBetter', 'woo-refund-and-exchange-lite' ), 'manage_options', 'mwb-plugins', array( $this, 'mwb_plugins_listing_page' ), WOO_REFUND_AND_EXCHANGE_LITE_DIR_URL . 'admin/image/MWB_Grey-01.svg', 15 );
			$wrael_menus =
			// Add Menu.
			apply_filters( 'mwb_add_plugins_menus_array', array() );
			if ( is_array( $wrael_menus ) && ! empty( $wrael_menus ) ) {
				foreach ( $wrael_menus as $wrael_key => $wrael_value ) {
					add_submenu_page( 'mwb-plugins', $wrael_value['name'], $wrael_value['name'], 'manage_options', $wrael_value['menu_link'], array( $wrael_value['instance'], $wrael_value['function'] ) );
				}
			}
		}
	}

	/**
	 * Removing default submenu of parent menu in backend dashboard
	 *
	 * @since 1.0.0
	 */
	public function mwb_rma_remove_default_submenu() {
		global $submenu;
		if ( is_array( $submenu ) && array_key_exists( 'mwb-plugins', $submenu ) ) {
			if ( isset( $submenu['mwb-plugins'][0] ) ) {
				unset( $submenu['mwb-plugins'][0] );
			}
		}
	}


	/**
	 * Woo Refund And Exchange Lite wrael_admin_submenu_page.
	 *
	 * @since 1.0.0
	 * @param array $menus Marketplace menus.
	 */
	public function wrael_admin_submenu_page( $menus = array() ) {
		$menus[] = array(
			'name'      => esc_html__( 'Return Refund and Exchange for WooCommerce', 'woo-refund-and-exchange-lite' ),
			'slug'      => 'woo_refund_and_exchange_lite_menu',
			'menu_link' => 'woo_refund_and_exchange_lite_menu',
			'instance'  => $this,
			'function'  => 'wrael_options_menu_html',
		);
		return $menus;
	}

	/**
	 * Woo Refund And Exchange Lite mwb_plugins_listing_page.
	 *
	 * @since 1.0.0
	 */
	public function mwb_plugins_listing_page() {
		$active_marketplaces =
		// Add Menu.
		apply_filters( 'mwb_add_plugins_menus_array', array() );
		if ( is_array( $active_marketplaces ) && ! empty( $active_marketplaces ) ) {
			include WOO_REFUND_AND_EXCHANGE_LITE_DIR_PATH . 'admin/partials/welcome.php';
		}
	}

	/**
	 * Woo Refund And Exchange Lite admin menu page.
	 *
	 * @since 1.0.0
	 */
	public function wrael_options_menu_html() {
		include_once WOO_REFUND_AND_EXCHANGE_LITE_DIR_PATH . 'admin/partials/woo-refund-and-exchange-lite-admin-dashboard.php';
	}

	/**
	 * Mwb_developer_admin_hooks_listing.
	 */
	public function mwb_developer_admin_hooks_listing() {
		$admin_hooks = array();
		$val         = $this->mwb_developer_hooks_function( WOO_REFUND_AND_EXCHANGE_LITE_DIR_PATH . 'admin/' );
		if ( ! empty( $val['hooks'] ) ) {
			$admin_hooks[] = $val['hooks'];
			unset( $val['hooks'] );
		}
		$data = array();
		foreach ( $val['files'] as $v ) {
			if ( 'css' !== $v && 'js' !== $v && 'images' !== $v ) {
				$helo = $this->mwb_developer_hooks_function( WOO_REFUND_AND_EXCHANGE_LITE_DIR_PATH . 'admin/' . $v . '/' );
				if ( ! empty( $helo['hooks'] ) ) {
					$admin_hooks[] = $helo['hooks'];
					unset( $helo['hooks'] );
				}
				if ( ! empty( $helo ) ) {
					$data[] = $helo;
				}
			}
		}
		return $admin_hooks;
	}

	/**
	 * Mwb_developer_public_hooks_listing.
	 */
	public function mwb_developer_public_hooks_listing() {
		$public_hooks = array();
		$val          = $this->mwb_developer_hooks_function( WOO_REFUND_AND_EXCHANGE_LITE_DIR_PATH . 'public/' );

		if ( ! empty( $val['hooks'] ) ) {
			$public_hooks[] = $val['hooks'];
			unset( $val['hooks'] );
		}
		$data = array();
		foreach ( $val['files'] as $v ) {
			if ( 'css' !== $v && 'js' !== $v && 'images' !== $v ) {
				$helo = $this->mwb_developer_hooks_function( WOO_REFUND_AND_EXCHANGE_LITE_DIR_PATH . 'public/' . $v . '/' );
				if ( ! empty( $helo['hooks'] ) ) {
					$public_hooks[] = $helo['hooks'];
					unset( $helo['hooks'] );
				}
				if ( ! empty( $helo ) ) {
					$data[] = $helo;
				}
			}
		}
		return $public_hooks;
	}
	/**
	 * Mwb_developer_hooks_function
	 *
	 * @param string $path .
	 */
	public function mwb_developer_hooks_function( $path ) {
		$all_hooks = array();
		$scan      = scandir( $path );
		$response  = array();
		foreach ( $scan as $file ) {
			if ( strpos( $file, '.php' ) ) {
				$myfile = file( $path . $file );
				foreach ( $myfile as $key => $lines ) {
					if ( preg_match( '/do_action/i', $lines ) && ! strpos( $lines, 'str_replace' ) && ! strpos( $lines, 'preg_match' ) ) {
						$all_hooks[ $key ]['action_hook'] = $lines;
						$all_hooks[ $key ]['desc']        = $myfile[ $key - 1 ];
					}
					if ( preg_match( '/apply_filters/i', $lines ) && ! strpos( $lines, 'str_replace' ) && ! strpos( $lines, 'preg_match' ) ) {
						$all_hooks[ $key ]['filter_hook'] = $lines;
						$all_hooks[ $key ]['desc']        = $myfile[ $key - 1 ];
					}
				}
			} elseif ( strpos( $file, '.' ) == '' && strpos( $file, '.' ) !== 0 ) {
				$response['files'][] = $file;
			}
		}
		if ( ! empty( $all_hooks ) ) {
			$response['hooks'] = $all_hooks;
		}
		return $response;
	}

	/**
	 * Woo Refund And Exchange Lite admin menu page.
	 *
	 * @since 1.0.0
	 * @param array $wrael_settings_general Settings fields.
	 */
	public function wrael_admin_general_settings_page( $wrael_settings_general ) {
		$wrael_settings_general = array(
			array(
				'title'   => esc_html__( 'Enable Refund', 'woo-refund-and-exchange-lite' ),
				'type'    => 'radio-switch',
				'id'      => 'mwb_rma_refund_enable',
				'value'   => get_option( 'mwb_rma_refund_enable' ),
				'class'   => 'wrael-radio-switch-class',
				'options' => array(
					'yes' => esc_html__( 'YES', 'woo-refund-and-exchange-lite' ),
					'no'  => esc_html__( 'NO', 'woo-refund-and-exchange-lite' ),
				),
			),
			array(
				'title'   => esc_html__( 'Enable Order Messages', 'woo-refund-and-exchange-lite' ),
				'type'    => 'radio-switch',
				'id'      => 'mwb_rma_general_om',
				'value'   => get_option( 'mwb_rma_general_om' ),
				'class'   => 'wrael-radio-switch-class',
				'options' => array(
					'yes' => esc_html__( 'YES', 'woo-refund-and-exchange-lite' ),
					'no'  => esc_html__( 'NO', 'woo-refund-and-exchange-lite' ),
				),
			),
		);
		$wrael_settings_general =
		// To extend the general setting.
		apply_filters( 'mwb_rma_general_setting_extend', $wrael_settings_general );
		$wrael_settings_general[] = array(
			'title'   => esc_html__( 'Enable Tracking', 'woo-refund-and-exchange-lite' ),
			'type'    => 'radio-switch',
			'id'      => 'wrael_enable_tracking',
			'value'   => get_option( 'wrael_enable_tracking' ),
			'class'   => 'wrael-radio-switch-class',
			'options' => array(
				'yes' => esc_html__( 'YES', 'woo-refund-and-exchange-lite' ),
				'no'  => esc_html__( 'NO', 'woo-refund-and-exchange-lite' ),
			),
		);
		$wrael_settings_general[] = array(
			'title'   => esc_html__( 'Enable to Show Bank Details Field For Manual Refund', 'woo-refund-and-exchange-lite' ),
			'type'    => 'radio-switch',
			'id'      => 'mwb_rma_refund_manually_de',
			'value'   => get_option( 'mwb_rma_refund_manually_de' ),
			'class'   => 'wrael-radio-switch-class',
			'options' => array(
				'yes' => esc_html__( 'YES', 'woo-refund-and-exchange-lite' ),
				'no'  => esc_html__( 'NO', 'woo-refund-and-exchange-lite' ),
			),
		);
		$wrael_settings_general[] = array(
			'type'        => 'button',
			'id'          => 'mwb_rma_save_general_setting',
			'button_text' => esc_html__( 'Save Setting', 'woo-refund-and-exchange-lite' ),
			'class'       => 'wrael-button-class',
		);
		return $wrael_settings_general;
	}

	/**
	 * Woo Refund And Exchange Lite save tab settings.
	 *
	 * @since 1.0.0
	 */
	public function wrael_admin_save_tab_settings() {
		global $wrael_mwb_rma_obj;
		if ( ( isset( $_POST['mwb_rma_save_general_setting'] ) || isset( $_POST['mwb_rma_save_refund_setting'] ) || isset( $_POST['mwb_rma_save_text_setting'] ) || isset( $_POST['mwb_rma_save_api_setting'] ) )
			&& ( ! empty( $_POST['mwb_tabs_nonce'] )
			&& wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mwb_tabs_nonce'] ) ), 'admin_save_data' ) )
		) {
			$mwb_rma_gen_flag = false;
			if ( isset( $_POST['mwb_rma_save_general_setting'] ) ) {
				$wrael_genaral_settings =
				// The general tab settings.
				apply_filters( 'wrael_general_settings_array', array() );
			} elseif ( isset( $_POST['mwb_rma_save_refund_setting'] ) ) {
				$wrael_genaral_settings =
				// The refund tab settings.
				apply_filters( 'mwb_rma_refund_settings_array', array() );
			} elseif ( isset( $_POST['mwb_rma_save_text_setting'] ) ) {
				$wrael_genaral_settings =
				// The Order Message tab settings.
				apply_filters( 'mwb_rma_order_message_settings_array', array() );
			} elseif ( isset( $_POST['mwb_rma_save_api_setting'] ) ) {
				$wrael_genaral_settings =
				// The Order Message tab settings.
				apply_filters( 'mwb_rma_api_settings_array', array() );
			}
			$wrael_button_index = array_search( 'submit', array_column( $wrael_genaral_settings, 'type' ), true );
			if ( isset( $wrael_button_index ) && ( null == $wrael_button_index || '' == $wrael_button_index ) ) {
				$wrael_button_index = array_search( 'button', array_column( $wrael_genaral_settings, 'type' ), true );
			}
			if ( isset( $wrael_button_index ) && '' !== $wrael_button_index ) {
				unset( $wrael_genaral_settings[ $wrael_button_index ] );
				if ( is_array( $wrael_genaral_settings ) && ! empty( $wrael_genaral_settings ) ) {
					foreach ( $wrael_genaral_settings as $wrael_genaral_setting ) {
						if ( isset( $wrael_genaral_setting['id'] ) && '' !== $wrael_genaral_setting['id'] ) {
							if ( isset( $_POST[ $wrael_genaral_setting['id'] ] ) ) {
								$setting = wp_unslash( $_POST[ $wrael_genaral_setting['id'] ] );
								if ( 'textarea' === $wrael_genaral_setting['type'] || 'text' === $wrael_genaral_setting['type'] ) {
									$setting = trim( preg_replace( '/\s\s+/', ' ', $setting ) );
								}
								if ( 'mwb_rma_refund_rules_editor' === $wrael_genaral_setting['id'] ) {
									update_option( 'mwb_rma_refund_rules_editor', wp_kses_post( wp_unslash( $setting ) ) );
								} else {
									update_option( $wrael_genaral_setting['id'], is_array( $setting ) ? $this->mwb_sanitize_array( $setting ) : stripslashes( sanitize_text_field( wp_unslash( $setting ) ) ) );
								}
							} else {
								update_option( $wrael_genaral_setting['id'], '' );
							}
						} else {
							$mwb_rma_gen_flag = true;
						}
					}
				}
				if ( $mwb_rma_gen_flag ) {
					$mwb_rma_error_text = esc_html__( 'Id of some field is missing', 'woo-refund-and-exchange-lite' );
					$wrael_mwb_rma_obj->mwb_rma_plug_admin_notice( $mwb_rma_error_text, 'error' );
				} else {
					$mwb_rma_error_text = esc_html__( 'Settings saved !', 'woo-refund-and-exchange-lite' );
					$wrael_mwb_rma_obj->mwb_rma_plug_admin_notice( $mwb_rma_error_text, 'success' );
				}
			}
		}
	}

	/**
	 * Sanitation for an array
	 *
	 * @param array $mwb_input_array .
	 *
	 * @return array
	 */
	public function mwb_sanitize_array( $mwb_input_array ) {
		foreach ( $mwb_input_array as $key => $value ) {
			$key   = sanitize_text_field( wp_unslash( $key ) );
			$value = map_deep( wp_unslash( $value ), 'sanitize_text_field' );
		}
		return $mwb_input_array;
	}

	/**
	 * Register Refund section setting.
	 *
	 * @param array $mwb_rma_settings_refund .
	 */
	public function mwb_rma_refund_settings_page( $mwb_rma_settings_refund ) {
		$button_view = array(
			'order-page' => esc_html__( 'Order Page', 'woo-refund-and-exchange-lite' ),
			'My account' => esc_html__( 'Order View Page', 'woo-refund-and-exchange-lite' ),
			'Checkout'   => esc_html__( 'Thank You Page', 'woo-refund-and-exchange-lite' ),
		);
		$pages       = get_pages();
		$get_pages   = array( '' => esc_html__( 'Default', 'woo-refund-and-exchange-lite' ) );
		foreach ( $pages as $page ) {
			$get_pages[ $page->ID ] = $page->post_title;
		}
		$mwb_rma_settings_refund = array(
			array(
				'title'       => esc_html__( 'Select Pages To Hide Refund Button', 'woo-refund-and-exchange-lite' ),
				'type'        => 'multiselect',
				'description' => '',
				'id'          => 'mwb_rma_refund_button_pages',
				'value'       => get_option( 'mwb_rma_refund_button_pages' ),
				'class'       => 'wrael-multiselect-class mwb-defaut-multiselect',
				'placeholder' => '',
				'options'     => $button_view,
			),
			array(
				'title'   => esc_html__( 'Enable to show Manage Stock Button', 'woo-refund-and-exchange-lite' ),
				'type'    => 'radio-switch',
				'id'      => 'mwb_rma_refund_manage_stock',
				'value'   => get_option( 'mwb_rma_refund_manage_stock' ),
				'class'   => 'wrael-radio-switch-class',
				'options' => array(
					'yes' => esc_html__( 'YES', 'woo-refund-and-exchange-lite' ),
					'no'  => esc_html__( 'NO', 'woo-refund-and-exchange-lite' ),
				),
			),
			array(
				'title'   => esc_html__( 'Enable Attachment', 'woo-refund-and-exchange-lite' ),
				'type'    => 'radio-switch',
				'id'      => 'mwb_rma_refund_attachment',
				'value'   => get_option( 'mwb_rma_refund_attachment' ),
				'class'   => 'wrael-radio-switch-class',
				'options' => array(
					'yes' => esc_html__( 'YES', 'woo-refund-and-exchange-lite' ),
					'no'  => esc_html__( 'NO', 'woo-refund-and-exchange-lite' ),
				),
			),
			array(
				'title'       => esc_html__( 'Attachement Limit', 'woo-refund-and-exchange-lite' ),
				'type'        => 'number',
				'description' => esc_html__( 'By default, It will take 5. If not given any.', 'woo-refund-and-exchange-lite' ),
				'id'          => 'mwb_rma_attachment_limit',
				'value'       => get_option( 'mwb_rma_attachment_limit' ),
				'class'       => 'wrael-number-class',
				'min'         => '0',
				'max'         => '15',
				'placeholder' => 'Enter the attachment limit',
			),
		);
		$mwb_rma_settings_refund =
		// To extend the refund setting.
		apply_filters( 'mwb_rma_refund_setting_extend', $mwb_rma_settings_refund );
		$mwb_rma_settings_refund[] = array(
			'type' => 'breaker',
			'id'   => 'Appearance',
			'name' => 'Appearance',
		);
		$mwb_rma_settings_refund[] = array(
			'title'       => esc_html__( 'Refund Button Text', 'woo-refund-and-exchange-lite' ),
			'type'        => 'text',
			'id'          => 'mwb_rma_refund_button_text',
			'value'       => get_option( 'mwb_rma_refund_button_text' ),
			'class'       => 'wrael-text-class',
			'placeholder' => esc_html__( 'Write the Refund Button Text', 'woo-refund-and-exchange-lite' ),
		);
		$mwb_rma_settings_refund[] = array(
			'title'   => esc_html__( 'Enable Refund Reason Description', 'woo-refund-and-exchange-lite' ),
			'type'    => 'radio-switch',
			'id'      => 'mwb_rma_refund_description',
			'value'   => get_option( 'mwb_rma_refund_description' ),
			'class'   => 'wrael-radio-switch-class',
			'options' => array(
				'yes' => esc_html__( 'YES', 'woo-refund-and-exchange-lite' ),
				'no'  => esc_html__( 'NO', 'woo-refund-and-exchange-lite' ),
			),
		);
		$mwb_rma_settings_refund[] = array(
			'title'       => esc_html__( 'Predefined Refund Reason', 'woo-refund-and-exchange-lite' ),
			'type'        => 'textarea',
			'id'          => 'mwb_rma_refund_reasons',
			'value'       => get_option( 'mwb_rma_refund_reasons' ),
			'class'       => 'wrael-textarea-class',
			'rows'        => '2',
			'cols'        => '80',
			'placeholder' => esc_html__( 'Write Multiple Refund Reason Separated by Comma', 'woo-refund-and-exchange-lite' ),
		);
		$mwb_rma_settings_refund[] = array(
			'title'   => esc_html__( 'Enable Refund Rules', 'woo-refund-and-exchange-lite' ),
			'type'    => 'radio-switch',
			'id'      => 'mwb_rma_refund_rules',
			'value'   => get_option( 'mwb_rma_refund_rules' ),
			'class'   => 'wrael-radio-switch-class',
			'options' => array(
				'yes' => esc_html__( 'YES', 'woo-refund-and-exchange-lite' ),
				'no'  => esc_html__( 'NO', 'woo-refund-and-exchange-lite' ),
			),
		);
		$mwb_rma_settings_refund[] = array(
			'title'       => esc_html__( 'Refund Rules Editor', 'woo-refund-and-exchange-lite' ),
			'type'        => 'textarea',
			'id'          => 'mwb_rma_refund_rules_editor',
			'value'       => get_option( 'mwb_rma_refund_rules_editor' ),
			'class'       => 'wrael-textarea-class',
			'rows'        => '5',
			'cols'        => '80',
			'placeholder' => esc_html__( 'Write the Refund Rules( HTML + CSS )', 'woo-refund-and-exchange-lite' ),
		);
		if ( function_exists( 'vc_lean_map' ) ) {
			$mwb_rma_settings_refund[] = array(
				'title'       => esc_html__( 'Select The Page To Redirect', 'woo-refund-and-exchange-lite' ),
				'type'        => 'select',
				'id'          => 'mwb_rma_refund_page',
				'description' => '',
				'value'       => get_option( 'mwb_rma_refund_page' ),
				'class'       => 'wrael-textarea-class',
				'options'     => $get_pages,
			);
		}
		$mwb_rma_settings_refund =
		// To extend Refund Apperance setting.
		apply_filters( 'mwb_rma_refund_appearance_setting_extend', $mwb_rma_settings_refund );
		$mwb_rma_settings_refund[] = array(
			'type'        => 'button',
			'id'          => 'mwb_rma_save_refund_setting',
			'button_text' => esc_html__( 'Save Setting', 'woo-refund-and-exchange-lite' ),
			'class'       => 'wrael-button-class',
		);
		return $mwb_rma_settings_refund;
	}

	/**
	 * To add order message tab setting.
	 *
	 * @param array $mwb_rma_settings_order_message .
	 */
	public function mwb_rma_order_message_settings_page( $mwb_rma_settings_order_message ) {
		$pages = get_pages();
		$get_pages = array( '' => esc_html__( 'Default', 'woo-refund-and-exchange-lite' ) );
		foreach ( $pages as $page ) {
			$get_pages[ $page->ID ] = $page->post_title;
		}
		$mwb_rma_settings_order_message = array(
			array(
				'title'   => esc_html__( 'Enable Attachment', 'woo-refund-and-exchange-lite' ),
				'type'    => 'radio-switch',
				'id'      => 'mwb_rma_general_enable_om_attachment',
				'value'   => get_option( 'mwb_rma_general_enable_om_attachment' ),
				'class'   => 'wrael-radio-switch-class',
				'options' => array(
					'yes' => esc_html__( 'YES', 'woo-refund-and-exchange-lite' ),
					'no'  => esc_html__( 'NO', 'woo-refund-and-exchange-lite' ),
				),
			),
		);
		$mwb_rma_settings_order_message =
		// To Extend Order Message Setting.
		apply_filters( 'mwb_rma_order_message_setting_extend', $mwb_rma_settings_order_message );
		$mwb_rma_settings_order_message[] = array(
			'type' => 'breaker',
			'id'   => 'Appearance',
			'name' => 'Appearance',
		);
		$mwb_rma_settings_order_message[] = array(
			'title'       => esc_html__( 'Order Message Button Text', 'woo-refund-and-exchange-lite' ),
			'type'        => 'text',
			'id'          => 'mwb_rma_order_message_button_text',
			'value'       => get_option( 'mwb_rma_order_message_button_text' ),
			'class'       => 'wrael-text-class',
			'placeholder' => esc_html__( 'Enter Order Message Button Text', 'woo-refund-and-exchange-lite' ),
		);
		if ( function_exists( 'vc_lean_map' ) ) {
			$mwb_rma_settings_order_message[] = array(
				'title'       => esc_html__( 'Select the Page to Redirect', 'woo-refund-and-exchange-lite' ),
				'type'        => 'select',
				'id'          => 'mwb_rma_order_msg_page',
				'value'       => get_option( 'mwb_rma_order_msg_page' ),
				'class'       => 'wrael-textarea-class',
				'options'     => $get_pages,
			);
		}
		$mwb_rma_settings_order_message =
		// To Extend Order Message Appearance Setting.
		apply_filters( 'mwb_rma_order_message_appearance_setting_extend', $mwb_rma_settings_order_message );
		$mwb_rma_settings_order_message[] = array(
			'type'        => 'button',
			'id'          => 'mwb_rma_save_text_setting',
			'button_text' => esc_html__( 'Save Setting', 'woo-refund-and-exchange-lite' ),
			'class'       => 'wrael-button-class',
		);
		return $mwb_rma_settings_order_message;
	}
	/**
	 * To add api tab setting .
	 *
	 * @param array $mwb_rma_settings_api .
	 */
	public function mwb_rma_api_settings_page( $mwb_rma_settings_api ) {
		$mwb_rma_settings_api = array(
			array(
				'title'   => esc_html__( 'Enable API', 'woo-refund-and-exchange-lite' ),
				'type'    => 'radio-switch',
				'id'      => 'mwb_rma_enable_api',
				'value'   => get_option( 'mwb_rma_enable_api' ),
				'class'   => 'wrael-radio-switch-class',
				'options' => array(
					'yes' => esc_html__( 'YES', 'woo-refund-and-exchange-lite' ),
					'no'  => esc_html__( 'NO', 'woo-refund-and-exchange-lite' ),
				),
			),
			array(
				'title'       => esc_html__( 'Secret Key', 'woo-refund-and-exchange-lite' ),
				'type'        => 'text',
				'id'          => 'mwb_rma_secret_key',
				'attr'        => 'readonly',
				'value'       => get_option( 'mwb_rma_secret_key' ),
				'class'       => 'wrael-text-class',
				'placeholder' => esc_html__( 'Please Generate the Secret Key', 'woo-refund-and-exchange-lite' ),
			),
			array(
				'type'        => 'button',
				'id'          => 'mwb_rma_generate_key_setting',
				'button_text' => esc_html__( 'Generate Key', 'woo-refund-and-exchange-lite' ),
				'class'       => 'wrael-button-class',
			),
			array(
				'type'        => 'button',
				'id'          => 'mwb_rma_save_api_setting',
				'button_text' => esc_html__( 'Save Setting', 'woo-refund-and-exchange-lite' ),
				'class'       => 'wrael-button-class',
			),
		);
		return $mwb_rma_settings_api;
	}

	/**
	 * This function is metabox template for order msg history.
	 *
	 * @name ced_rnx_order_msg_history.
	 */
	public function mwb_rma_order_msg_history() {
		global $post, $thepostid, $theorder;
		include_once WOO_REFUND_AND_EXCHANGE_LITE_DIR_PATH . 'admin/partials/woo-refund-and-exchange-lite-order-message-meta.php';
	}

	/**
	 * This function is metabox template for order msg history.
	 */
	public function mwb_rma_order_return() {
		global $post, $thepostid, $theorder;
		include_once WOO_REFUND_AND_EXCHANGE_LITE_DIR_PATH . 'admin/partials/woo-refund-and-exchange-lite-return-meta.php';
	}

	/**
	 * Function to add metabox on the order edit page
	 *
	 * @return void
	 */
	public function mwb_wrma_add_metaboxes() {
		$mwb_rma_return_enable = get_option( 'mwb_rma_refund_enable', 'no' );
		if ( isset( $mwb_rma_return_enable ) && 'on' === $mwb_rma_return_enable ) {
			add_meta_box(
				'mwb_rma_order_refund',
				esc_html__( 'Refund Requested Products', 'woo-refund-and-exchange-lite' ),
				array( $this, 'mwb_rma_order_return' ),
				'shop_order'
			);
		}
		add_meta_box(
			'mwb_rma_order_msg_history',
			esc_html__( 'Order Message History', 'woo-refund-and-exchange-lite' ),
			array( $this, 'mwb_rma_order_msg_history' ),
			'shop_order'
		);
	}

	/**
	 * Accept return request approve.
	 */
	public function mwb_rma_return_req_approve() {
		$check_ajax = check_ajax_referer( 'mwb_rma_ajax_seurity', 'security_check' );
		if ( $check_ajax ) {
			if ( current_user_can( 'mwb-rma-refund-approve' ) ) {
				$orderid  = isset( $_POST['orderid'] ) ? sanitize_text_field( wp_unslash( $_POST['orderid'] ) ) : '';
				$products = get_post_meta( $orderid, 'mwb_rma_return_product', true );
				$response = mwb_rma_return_req_approve_callback( $orderid, $products );
				echo wp_json_encode( $response );

			}
		}
		wp_die();
	}

	/**
	 * Cancel return request cancel.
	 */
	public function mwb_rma_return_req_cancel() {
		$check_ajax = check_ajax_referer( 'mwb_rma_ajax_seurity', 'security_check' );
		if ( $check_ajax ) {
			if ( current_user_can( 'mwb-rma-refund-cancel' ) ) {
				$orderid  = isset( $_POST['orderid'] ) ? sanitize_text_field( wp_unslash( $_POST['orderid'] ) ) : '';
				$products = get_post_meta( $orderid, 'mwb_rma_return_product', true );
				$response = mwb_rma_return_req_cancel_callback( $orderid, $products );
				echo wp_json_encode( $response );

			}
		}
		wp_die();
	}

	/**
	 * Update left amount because amount is refunded.
	 *
	 * @param int   $order_get_id order id.
	 * @param array $args refund data .
	 */
	public function mwb_rma_action_woocommerce_order_refunded( $order_get_id, $args ) {
		if ( isset( $args['amount'] ) && ! empty( $args['amount'] ) ) {
			update_post_meta( $args['order_id'], 'mwb_rma_left_amount_done', 'yes' );
		}
	}


	/**
	 * Restock the refund items
	 */
	public function mwb_rma_manage_stock() {
		$check_ajax = check_ajax_referer( 'mwb_rma_ajax_seurity', 'security_check' );
		if ( $check_ajax ) {
			if ( current_user_can( 'mwb-rma-refund-manage-stock' ) ) {
				$order_id = isset( $_POST['order_id'] ) ? sanitize_text_field( wp_unslash( $_POST['order_id'] ) ) : 0;
				if ( $order_id > 0 ) {
					$mwb_rma_type = isset( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : '';
					if ( '' !== $mwb_rma_type && 'mwb_rma_return' === $mwb_rma_type ) {
						// Check already restock the items.
						$manage_stock = get_option( 'mwb_rma_manage_stock_for_return' );
						if ( 'yes' !== $manage_stock ) {
							$mwb_rma_return_data = get_post_meta( $order_id, 'mwb_rma_return_product', true );
							if ( is_array( $mwb_rma_return_data ) && ! empty( $mwb_rma_return_data ) ) {
								foreach ( $mwb_rma_return_data as $date => $requested_data ) {
									$mwb_rma_returned_products = $requested_data['products'];
									if ( is_array( $mwb_rma_returned_products ) && ! empty( $mwb_rma_returned_products ) ) {
										foreach ( $mwb_rma_returned_products as $key => $product_data ) {
											if ( $product_data['variation_id'] > 0 ) {
												$product = wc_get_product( $product_data['variation_id'] );
											} else {
												$product = wc_get_product( $product_data['product_id'] );
											}

											if ( $product->managing_stock() ) {
												$avaliable_qty = $product_data['qty'];
												if ( $product_data['variation_id'] > 0 ) {
													$total_stock = $product->get_stock_quantity();
													$total_stock = $total_stock + $avaliable_qty;
													$product->set_stock_quantity( $total_stock );
												} else {
													$total_stock = $product->get_stock_quantity();
													$total_stock = $total_stock + $avaliable_qty;
													$product->set_stock_quantity( $total_stock );
												}
												$product->save();
												update_post_meta( $order_id, 'mwb_rma_manage_stock_for_return', 'no' );
												$response['result'] = 'success';
												$response['msg']    = esc_html__( 'Product Stock is updated Successfully.', 'woo-refund-and-exchange-lite' );
												/* translators: %s: search term */
												wc_get_order( $order_id )->add_order_note( sprintf( esc_html__( '%s Product Stock is updated Successfully.', 'woo-refund-and-exchange-lite' ), $product->get_name() ), false, true );
											} else {
												$response['result'] = false;
												$response['msg']    = esc_html__( 'Product Stock is not updated as manage stock setting of product is disable.', 'woo-refund-and-exchange-lite' );
												/* translators: %s: search term */
												wc_get_order( $order_id )->add_order_note( sprintf( esc_html__( '%s Product Stock is not updated as manage stock setting of product is disable.', 'woo-refund-and-exchange-lite' ), $product->get_name() ), false, true );
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		echo wp_json_encode( $response );
		wp_die();
	}

	/**
	 * Save policies setting.
	 */
	public function mwb_rma_save_policies_setting() {
		global $wrael_mwb_rma_obj;
		if ( isset( $_POST['save_policies_setting'] ) && isset( $_POST['get_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['get_nonce'] ) ), 'create_form_nonce' ) ) {
			unset( $_POST['save_policies_setting'] );
			unset( $_POST['get_nonce'] );
			$value = map_deep( wp_unslash( $_POST ), 'sanitize_text_field' );
			if ( isset( $value['mwb_rma_setting'] ) ) {
				foreach ( $value['mwb_rma_setting'] as $setting_index => $setting_value ) {
					if ( 'mwb_rma_maximum_days' === $setting_value['row_policy'] && empty( $setting_value['row_value'] ) ) {
						unset( $value['mwb_rma_setting'][ $setting_index ] );
					}
					if ( 'mwb_rma_order_status' === $setting_value['row_policy'] && empty( $setting_value['row_statuses'] ) ) {
						unset( $value['mwb_rma_setting'][ $setting_index ] );
					}
				}
				update_option( 'policies_setting_option', $value );
			}
			// Policies Setting Saving.
			do_action( 'mwb_rma_policies_setting', $value );
			$mwb_rma_error_text = esc_html__( 'Settings saved !', 'woo-refund-and-exchange-lite' );
			$wrael_mwb_rma_obj->mwb_rma_plug_admin_notice( $mwb_rma_error_text, 'success2' );
		}
	}

	/**
	 * Generate the secret key
	 */
	public function mwb_rma_api_secret_key() {
		$check_ajax = check_ajax_referer( 'mwb_rma_ajax_seurity', 'security_check' );
		if ( $check_ajax ) {
			$value = 'mwb_' . wc_rand_hash();
			update_option( 'mwb_rma_secret_key', $value );
			return 'success';
		}
	}
}
