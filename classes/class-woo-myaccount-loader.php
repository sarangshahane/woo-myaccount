<?php
/**
 * Woo My Account Loader.
 *
 * @package Woo_Myaccount_Loader
 */

if ( ! class_exists( 'Woo_Myaccount_Loader' ) ) {

	/**
	 * Class Woo_Myaccount_Loader.
	 */
	final class Woo_Myaccount_Loader {

		/**
		 * Member Variable
		 *
		 * @var instance
		 */
		private static $instance = null;

		/**
		 * Member Variable
		 *
		 * @var utils
		 */
		public $utils = null;

		/**
		 * Member Variable
		 *
		 * @var logger
		 */
		public $logger = null;

		/**
		 * Member Variable
		 *
		 * @var session
		 */
		public $session = null;


		/**
		 * Member Variable
		 *
		 * @var options
		 */
		public $options = null;

		/**
		 * Member Variable
		 *
		 * @var meta
		 */
		public $meta = null;

		/**
		 * Member Variable
		 *
		 * @var flow
		 */
		public $flow = null;

		/**
		 * Member Variable
		 *
		 * @var assets_vars
		 */
		public $assets_vars = null;

		/**
		 *  Member Variable
		 *
		 *  @var assets_vars
		 */

		public $is_woo_active = true;

		/**
		 *  Initiator
		 */
		public static function get_instance() {

			if ( is_null( self::$instance ) ) {

				self::$instance = new self();

				/**
				 * My Account loaded.
				 *
				 * Fires when My Account was fully loaded and instantiated.
				 *
				 * @since 1.0.0
				 */
				do_action( 'woo_myaccount_loaded' );
			}

			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {

			$this->define_constants();

			// Activation hook.
			register_activation_hook( MY_ACCOUNT_FILE, array( $this, 'activation_reset' ) );

			// deActivation hook.
			register_deactivation_hook( MY_ACCOUNT_FILE, array( $this, 'deactivation_reset' ) );

			add_action( 'plugins_loaded', array( $this, 'load_plugin' ), 99 );
			add_action( 'plugins_loaded', array( $this, 'load_cf_textdomain' ) );
		}

		/**
		 * Defines all constants
		 *
		 * @since 1.0.0
		 */
		public function define_constants() {

			define( 'MY_ACCOUNT_BASE', plugin_basename( MY_ACCOUNT_FILE ) );
			define( 'MY_ACCOUNT_DIR', plugin_dir_path( MY_ACCOUNT_FILE ) );
			define( 'MY_ACCOUNT_URL', plugins_url( '/', MY_ACCOUNT_FILE ) );
			define( 'MY_ACCOUNT_VER', '0.0.1' );
			define( 'MY_ACCOUNT_SLUG', 'woo-myaccount' );
			define( 'MY_ACCOUNT_SETTINGS', 'wpp_myaccount_settings' );

			define( 'MY_ACCOUNT_POST_TYPE', 'woo_myaccount' );

			define( 'MY_ACCOUNT_TAXONOMY', 'woo_myaccount_tex' );
			
		}

		/**
		 * Loads plugin files.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		function load_plugin() {

			$this->load_helper_files_components();
			$this->load_core_files();
			
			add_action( 'wp_loaded', array( $this, 'initialize' ) );

			/**
			 * Woo Myaccount Init.
			 *
			 * Fires when Woo Myaccount is instantiated.
			 *
			 * @since 1.0.0
			 */
			do_action( 'woo_myaccount_init' );
		}

		/**
		 * Load Helper Files and Components.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		function load_helper_files_components() {

			$this->is_woo_active = function_exists( 'WC' );

			/* Public Utils */
			include_once MY_ACCOUNT_DIR . 'classes/class-woo-myaccount-utils.php';

			/* Public Global namespace functions */
			include_once MY_ACCOUNT_DIR . 'classes/class-woo-myaccount-functions.php';

			/* Admin Helper */
			include_once MY_ACCOUNT_DIR . 'classes/class-woo-myaccount-helper.php';

			/* Meta Default Values */
			include_once MY_ACCOUNT_DIR . 'classes/class-woo-myaccount-default-meta.php';

			$this->utils   = Woo_Myaccount_Utils::get_instance();
			$this->options = Woo_Myaccount_Default_Meta::get_instance();
		}

		/**
		 * Init hooked function.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		function initialize() {
			$this->assets_vars = $this->utils->get_woo_myaccount_assets_path();
		}

		/**
		 * Load Core Files.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		function load_core_files() {

			/* Admin Settings */
			include_once MY_ACCOUNT_DIR . 'classes/class-woo-myaccount-admin.php';

		}

		
		/**
		 * Load Woo My Account Text Domain.
		 * This will load the translation textdomain depending on the file priorities.
		 *      1. Global Languages /wp-content/languages/woo-myaccount/ folder
		 *      2. Local dorectory /wp-content/plugins/woo-myaccount/languages/ folder
		 *
		 * @since 1.0.3
		 * @return void
		 */
		public function load_cf_textdomain() {

			// Default languages directory for CartFlows Pro.
			$lang_dir = MY_ACCOUNT_DIR . 'languages/';

			/**
			 * Filters the languages directory path to use for CartFlows Pro.
			 *
			 * @param string $lang_dir The languages directory path.
			 */
			$lang_dir = apply_filters( 'woo_myaccount_languages_directory', $lang_dir );

			// Traditional WordPress plugin locale filter.
			global $wp_version;

			$get_locale = get_locale();

			if ( $wp_version >= 4.7 ) {
				$get_locale = get_user_locale();
			}

			/**
			 * Language Locale for CartFlows Pro
			 *
			 * @var $get_locale The locale to use.
			 * Uses get_user_locale()` in WordPress 4.7 or greater,
			 * otherwise uses `get_locale()`.
			 */
			$locale = apply_filters( 'plugin_locale', $get_locale, 'woo-myaccount' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'woo-myaccount', $locale );

			// Setup paths to current locale file.
			$mofile_local  = $lang_dir . $mofile;
			$mofile_global = WP_LANG_DIR . '/plugins/' . $mofile;

			if ( file_exists( $mofile_global ) ) {
				// Look in global /wp-content/languages/woo-myaccount/ folder.
				load_textdomain( 'woo-myaccount', $mofile_global );
			} elseif ( file_exists( $mofile_local ) ) {
				// Look in local /wp-content/plugins/woo-myaccount/languages/ folder.
				load_textdomain( 'woo-myaccount', $mofile_local );
			} else {
				// Load the default language files.
				load_plugin_textdomain( 'woo-myaccount', false, $lang_dir );
			}
		}

		/**
		 * Fires admin notice when Elementor is not installed and activated.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function fails_to_load() {

			$screen = get_current_screen();

			if ( ! wma()->utils->check_is_woo_required_page() ) {
				return;
			}

			$skip_notice = false;

			wp_localize_script( 'wma-global-admin', 'woo_myaccount', array( 'show_update_post' => $skip_notice ) );

			$class = 'notice notice-warning';
			/* translators: %s: html tags */
			$message = sprintf( __( 'This %1$sCustom My Account for Woocommerce%2$s page requires %1$sWooCommerce%2$s plugin installed & activated.', 'cartflows' ), '<strong>', '</strong>' );

			$plugin = 'woocommerce/woocommerce.php';

			if ( _is_woo_installed() ) {
				if ( ! current_user_can( 'activate_plugins' ) ) {
					return;
				}

				$action_url   = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
				$button_label = __( 'Activate WooCommerce', 'woo-myaccount' );

			} else {
				if ( ! current_user_can( 'install_plugins' ) ) {
					return;
				}

				$action_url   = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ), 'install-plugin_woocommerce' );
				$button_label = __( 'Install WooCommerce', 'woo-myaccount' );
			}

			$button = '<p><a href="' . $action_url . '" class="button-primary">' . $button_label . '</a></p><p></p>';

			printf( '<div class="%1$s"><p>%2$s</p>%3$s</div>', esc_attr( $class ), $message, $button );
		}

		/**
		 * Activation Reset
		 */
		function activation_reset() {

			if ( ! defined( 'WOO_MYACCOUNT_LOG_DIR' ) ) {

				$upload_dir = wp_upload_dir( null, false );

				define( 'WOO_MYACCOUNT_LOG_DIR', $upload_dir['basedir'] . '/woo-myaccount-logs/' );
			}

			include_once MY_ACCOUNT_DIR . 'classes/class-woo-myaccount-helper.php';
			flush_rewrite_rules();
		}

		/**
		 * Deactivation Reset
		 */
		function deactivation_reset() {
		}

	}

	/**
	 *  Prepare if class 'Woo_Myaccount_Loader' exist.
	 *  Kicking this off by calling 'get_instance()' method
	 */
	Woo_Myaccount_Loader::get_instance();
}

/**
 * Get global class.
 *
 * @return object
 */
function wma() {
	return Woo_Myaccount_Loader::get_instance();
}

if ( ! function_exists( '_is_woo_installed' ) ) {

	/**
	 * Is woocommerce plugin installed.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	function _is_woo_installed() {

		$path    = 'woocommerce/woocommerce.php';
		$plugins = get_plugins();

		return isset( $plugins[ $path ] );
	}
}
