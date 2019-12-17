<?php
/**
 * Woo_Myaccount_Loader Admin.
 *
 * @package Woo_Myaccount_Loader
 */

/**
 * Class Woo_Myaccount_Admin.
 */
class Woo_Myaccount_Admin {

	/**
	 * Calls on initialization
	 *
	 * @since 1.0.0
	 */
	public static function init() {

		self::initialise_plugin();
		self::init_hooks();
	}

	/**
	 * Init Hooks.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function init_hooks() {

		if ( ! is_admin() ) {
			return;
		}

		include_once MY_ACCOUNT_DIR . 'classes/class-woo-myaccount-admin-fields.php';

		/*
		Add CARTFLOWS menu option to admin.
		add_action( 'network_admin_menu', __CLASS__ . '::menu' );
		*/
		add_action( 'admin_menu', __CLASS__ . '::menu' );

		add_action( 'cartflows_render_admin_content', __CLASS__ . '::render_content' );

		add_action( 'admin_init', __CLASS__ . '::settings_admin_scripts' );

		/* Global Addmin Script */
		// add_action( 'admin_enqueue_scripts', __CLASS__ . '::global_admin_scripts', 20 );

		// add_action( 'admin_footer', __CLASS__ . '::global_admin_data', 9555 );

		/* Add lite version class to body */
		// add_action( 'admin_body_class', __CLASS__ . '::add_admin_body_class' );

		add_filter( 'plugin_action_links_' . MY_ACCOUNT_BASE, __CLASS__ . '::add_action_links' );
		add_filter( 'plugin_row_meta', __CLASS__ . '::add_custom_action_link', 10, 2 );

	}


	/**
	 *  Initialize after Cartflows pro get loaded.
	 */
	public static function settings_admin_scripts() {
		// Enqueue admin scripts.
		if ( isset( $_REQUEST['page'] ) && MY_ACCOUNT_SLUG == $_REQUEST['page'] ) {
			add_action( 'admin_enqueue_scripts', __CLASS__ . '::styles_scripts' );

			// self::save_settings();
		}
	}

	/**
	 * Enqueues the needed CSS/JS for the builder's admin settings page.
	 *
	 * @since 1.0.0
	 */
	public static function styles_scripts() {

		// Styles.
		wp_enqueue_style( 'cartflows-admin-settings', MY_ACCOUNT_URL . 'admin/assets/css/admin-menu-settings.css', array(), MY_ACCOUNT_VER );
		wp_style_add_data( 'cartflows-admin-settings', 'rtl', 'replace' );

		// Script.
		wp_enqueue_script( 'cartflows-admin-settings', MY_ACCOUNT_URL . 'admin/assets/js/admin-menu-settings.js', array( 'jquery', 'wp-util', 'updates' ), MY_ACCOUNT_VER );

		do_action( 'cartflows_admin_settings_after_enqueue_scripts' );
	}


	/**
	 * Show action on plugin page.
	 *
	 * @param  array $links links.
	 * @return array
	 */
	public static function add_action_links( $links ) {
		$mylinks = array(
			// '<a href="' . admin_url( 'admin.php?page=' . MY_ACCOUNT_SETTINGS ) . '">Settings</a>',
			'<a target="_blank" href="' . esc_url( '#' ) . '">Docs</a>',
		);

		return array_merge( $links, $mylinks );
	}


 	/**
	 * Show action links on plugin page in the description column.
	 *
	 * @param  array $links links.
	 * @param  string $file link.
	 * @return array
	 */
	public static function add_custom_action_link( $links, $file ) {  
		
	    if ( plugin_basename( MY_ACCOUNT_FILE ) == $file ) {

	        $row_meta = array(
	          'support'    => '<a href="' . esc_url( 'https://wordpress.org/plugins/' ) . '" target="_blank" aria-label="' . esc_attr__( 'Need support for Customize My Account area plugin', 'woo-myaccount' ) . '">' . esc_html__( 'Support', 'woo-myaccount' ) . '</a>'
	        );
	 
	        return array_merge( $links, $row_meta );
	    }
	    return (array) $links;
	}

	/**
	 * Initialises the Plugin Name.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function initialise_plugin() {

		$name       = 'Customize WooCommerce My Account';
		$short_name = 'Woo My Account';

		define( 'CMY_ACCOUNT_PLUGIN_NAME', $name );
		define( 'CMY_ACCOUNT_PLUGIN_SHORT_NAME', $short_name );
	}

	/**
	 * Renders the admin settings menu.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function menu() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		add_menu_page(
			'Woo My Account',
			'Woo My Account',
			'manage_options',
			MY_ACCOUNT_SLUG,
			__CLASS__ . '::render',
			'data:image/png;base64,' . base64_encode( file_get_contents( MY_ACCOUNT_DIR . 'assets/images/' ) ),
			39.7
		);

	}

	

	/**
	 * Renders the admin settings.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function render() {
		$action = ( isset( $_GET['action'] ) ) ? sanitize_text_field( $_GET['action'] ) : '';
		$action = ( ! empty( $action ) && '' != $action ) ? $action : 'main-page';
		$action = str_replace( '_', '-', $action );

		// Enable header icon filter below.
		$header_wrapper_class = apply_filters( 'cartflows_header_wrapper_class', array( $action ) );

		include_once MY_ACCOUNT_DIR . 'includes/admin/cartflows-admin.php';
	}

	/**
	 * Renders the admin settings content.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function render_content() {

		$action = ( isset( $_GET['action'] ) ) ? sanitize_text_field( $_GET['action'] ) : '';
		$action = ( ! empty( $action ) && '' != $action ) ? $action : 'general';
		$action = str_replace( '_', '-', $action );
		$action = 'general';

		$header_wrapper_class = apply_filters( 'cartflows_header_wrapper_class', array( $action ) );

		include_once MY_ACCOUNT_DIR . 'includes/admin/cartflows-general.php';
	}

	

}

Woo_Myaccount_Admin::init();
