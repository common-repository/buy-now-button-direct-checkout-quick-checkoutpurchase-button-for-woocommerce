<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://profiles.wordpress.org/mrjz/
 * @since      1.0.0
 *
 * @package    Buy_Now_Direct_Checkout_For_Woocommerce
 * @subpackage Buy_Now_Direct_Checkout_For_Woocommerce/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Buy_Now_Direct_Checkout_For_Woocommerce
 * @subpackage Buy_Now_Direct_Checkout_For_Woocommerce/includes
 * @author     mrjz <zanzmera.jasmin@gmail.com>
 */
class Buy_Now_Direct_Checkout_For_Woocommerce_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'buy-now-direct-checkout-for-woocommerce',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
