<?php
/**
 * Utils.
 *
 * @package Woo_Myaccount_Loader
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Woo_Myaccount_Utils.
 */
class Woo_Myaccount_Utils {

	/**
	 * Member Variable
	 *
	 * @var instance
	 */
	private static $instance;

	/**
	 *  Initiator
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 *  Constructor
	 */
	function __construct() {
	}

	/**
	 *  Get current post type
	 *
	 * @param string $post_type post type.
	 * @return string
	 */
	function current_post_type( $post_type = '' ) {

		if ( '' === $post_type ) {
			$post_type = get_post_type();
		}

		return $post_type;
	}

	
	/**
	 * Define constant for cache
	 *
	 * @return void
	 */
	function do_not_cache() {

		wcf_maybe_define_constant( 'DONOTCACHEPAGE', true );
		wcf_maybe_define_constant( 'DONOTCACHEOBJECT', true );
		wcf_maybe_define_constant( 'DONOTCACHEDB', true );

		nocache_headers();
	}

	/**
	 * Get assets urls
	 *
	 * @return array
	 * @since 1.1.6
	 */
	function get_woo_myaccount_assets_path() {

		$rtl = '';

		if ( is_rtl() ) {
			$rtl = '-rtl';
		}

		$file_prefix = '';
		$dir_name    = '';

		$is_min = apply_filters( 'woo_myaccount_load_min_assets', false );

		if ( $is_min ) {
			$file_prefix = '.min';
			$dir_name    = 'min-';
		}

		$js_gen_path  = MY_ACCOUNT_URL . 'assets/' . $dir_name . 'js/';
		$css_gen_path = MY_ACCOUNT_URL . 'assets/' . $dir_name . 'css/';

		return array(
			'css'         => $css_gen_path,
			'js'          => $js_gen_path,
			'file_prefix' => $file_prefix,
			'rtl'         => $rtl,
		);
	}

	/**
	 * Get assets css url
	 *
	 * @param string $file file name.
	 * @return string
	 * @since 1.1.6
	 */
	function get_css_url( $file ) {

		$assets_vars = wcf()->assets_vars;

		$url = $assets_vars['css'] . $file . $assets_vars['rtl'] . $assets_vars['file_prefix'] . '.css';

		return $url;
	}

	/**
	 * Get assets js url
	 *
	 * @param string $file file name.
	 * @return string
	 * @since 1.1.6
	 */
	function get_js_url( $file ) {

		$assets_vars = wcf()->assets_vars;

		$url = $assets_vars['js'] . $file . $assets_vars['file_prefix'] . '.js';

		return $url;
	}
}
