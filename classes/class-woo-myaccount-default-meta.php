<?php
/**
 * Woo_Myaccount_Loader default options.
 *
 * @package Woo_Myaccount_Loader
 */

/**
 * Initialization
 *
 * @since 1.0.0
 */
class Woo_Myaccount_Default_Meta {



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
	public function __construct() {
	}

	
}

/**
 *  Kicking this off by calling 'get_instance()' method
 */
Woo_Myaccount_Default_Meta::get_instance();
