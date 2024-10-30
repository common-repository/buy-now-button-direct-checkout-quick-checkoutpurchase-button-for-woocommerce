<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://profiles.wordpress.org/mrjz/
 * @since             1.0.0
 * @package           Buy_Now_Direct_Checkout_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:			Buy Now Button, Direct Checkout, Quick Checkout / Purchase Button For WooCommerce
 * Description:       	This plugin will add a "Buy Now" button below the "Add to cart" button that add product to cart and quickly redirects the customer directly to the checkout page for a quick purchase using custom ajax call. This plugin is designed to help boost your business conversion rate by reducing the number of steps required to complete a purchase. With the "Buy Now" button, customers can be taken directly to the checkout page, skipping the traditional cart page redirect of WooCommerce.
 * Version:           	1.0.0
 * Author:            	mrjz
 * Author URI:        	https://profiles.wordpress.org/mrjz/
 * License:           	GPL-2.0+
 * License URI:       	http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       	buy-now-direct-checkout-for-woocommerce
 * Domain Path:       	/languages
 * Requires at least: 	5.8
 * Requires PHP:	  	7.2
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('BUY_NOW_DIRECT_CHECKOUT_FOR_WOOCOMMERCE_VERSION', '1.0.0');

function buy_now_direct_checkout_for_woocommerce_check_woocommerce_install_and_active()
{
	if (!defined('WC_VERSION')) {
		// no woocommerce :(
		echo '<div class="notice notice-error is-dismissible"><p>Sorry, but "Buy Now, Direct Checkout For WooCommerce" plugin is deactivated as it requires WooCommerce in order to work. Please ensure that WooCommerce is installed and activated.</p></div>';
		deactivate_plugins('/' . plugin_basename(__FILE__));
	}
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-buy-now-direct-checkout-for-woocommerce-activator.php
 */
function activate_buy_now_direct_checkout_for_woocommerce()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-buy-now-direct-checkout-for-woocommerce-activator.php';
	Buy_Now_Direct_Checkout_For_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-buy-now-direct-checkout-for-woocommerce-deactivator.php
 */
function deactivate_buy_now_direct_checkout_for_woocommerce()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-buy-now-direct-checkout-for-woocommerce-deactivator.php';
	Buy_Now_Direct_Checkout_For_Woocommerce_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_buy_now_direct_checkout_for_woocommerce');
register_deactivation_hook(__FILE__, 'deactivate_buy_now_direct_checkout_for_woocommerce');

add_action('admin_notices', 'buy_now_direct_checkout_for_woocommerce_check_woocommerce_install_and_active');
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-buy-now-direct-checkout-for-woocommerce.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_buy_now_direct_checkout_for_woocommerce()
{

	$plugin = new Buy_Now_Direct_Checkout_For_Woocommerce();
	$plugin->run();
}
run_buy_now_direct_checkout_for_woocommerce();
