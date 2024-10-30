<?php

/**
 * Fired during plugin activation
 *
 * @link       https://profiles.wordpress.org/mrjz/
 * @since      1.0.0
 *
 * @package    Buy_Now_Direct_Checkout_For_Woocommerce
 * @subpackage Buy_Now_Direct_Checkout_For_Woocommerce/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Buy_Now_Direct_Checkout_For_Woocommerce
 * @subpackage Buy_Now_Direct_Checkout_For_Woocommerce/includes
 * @author     mrjz <zanzmera.jasmin@gmail.com>
 */
class Buy_Now_Direct_Checkout_For_Woocommerce_Activator
{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate()
	{
		update_option('bndcfw-buy-now-button-classes', '');
		update_option('bndcfw-buy-now-empty-cart', 0);
	}
}
