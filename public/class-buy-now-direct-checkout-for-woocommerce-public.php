<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/mrjz/
 * @since      1.0.0
 *
 * @package    Buy_Now_Direct_Checkout_For_Woocommerce
 * @subpackage Buy_Now_Direct_Checkout_For_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Buy_Now_Direct_Checkout_For_Woocommerce
 * @subpackage Buy_Now_Direct_Checkout_For_Woocommerce/public
 * @author     mrjz <zanzmera.jasmin@gmail.com>
 */
class Buy_Now_Direct_Checkout_For_Woocommerce_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Buy_Now_Direct_Checkout_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Buy_Now_Direct_Checkout_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/buy-now-direct-checkout-for-woocommerce-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Buy_Now_Direct_Checkout_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Buy_Now_Direct_Checkout_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/buy-now-direct-checkout-for-woocommerce-public.js', array('jquery'), $this->version, false);
		$buyNowJsVars = [
			'ajax_url' => admin_url('admin-ajax.php'),
			'buy_now_nonce' => wp_create_nonce('buy_now_nonce'),
			'checkout_url' => wc_get_checkout_url(),
		];
		wp_localize_script('buy-now-direct-checkout-for-woocommerce', 'buyNowJsVars', $buyNowJsVars);
	}
	public function buy_now_direct_checkout_woocommerce_add_buy_now_button()
	{
		global $product;
		if ($product->get_type() == 'grouped' || $product->get_type() == 'external') {
			return;
		}
		$bNowClasses = "button alt button-buy-now ";
		$bNowClasses .= get_option('bndcfw-buy-now-button-classes');
		if ($product->get_type() == 'variable') {
			$bNowClasses .= " disabled";
		}
		$btnText = __('Buy now', 'buy-now-direct-checkout-for-woocommerce');
		echo '<button type="button" class="' . esc_attr($bNowClasses) . '" ><span>' . esc_html($btnText) . '</span></button>';
	}
	public function buy_now_direct_checkout_woocommerce_get_buy_now_nonce()
	{

		if (!isset($_POST['buy_now_nonce'])) {
			wp_send_json_error(
				__(
					"Error : Security check failed!",
					"buy-now-direct-checkout-for-woocommerce"
				)
			);
		}
		$bndcfw_latestBuyNowNonce = wp_create_nonce('buy_now_nonce');
		wp_send_json_success([
			'buy_now_nonce'
			=> $bndcfw_latestBuyNowNonce
		]);
	}
	public function buy_now_direct_checkout_woocommerce_buy_now_click()
	{
		if (!isset($_POST['buy_now_nonce']) || !wp_verify_nonce($_POST['buy_now_nonce'], 'buy_now_nonce')) {
			wp_send_json_error(
				__(
					"Error : Security check failed!",
					"buy-now-direct-checkout-for-woocommerce"
				)
			);
		}
		if (!(isset($_REQUEST['product_id']) && $bndcfw_product_id = absint($_REQUEST['product_id']))) {
			wp_send_json_error(__(
				"Error : Product data not received",
				"buy-now-direct-checkout-for-woocommerce"
			));
		}
		$bndcfwProduct = wc_get_product($bndcfw_product_id);
		if ($bndcfwProduct->get_type() == 'variable' && !isset($_REQUEST['variation_id'])) {
			wp_send_json_error(__(
				"Error : Product variation data not received",
				"buy-now-direct-checkout-for-woocommerce"
			));
		}
		// Return if cart object is not initialized.
		if (!is_object(WC()->cart)) {
			wp_send_json_error(__(
				"Error: Cart object not defined",
				"buy-now-direct-checkout-for-woocommerce"
			));
		}
		//code for empty cart before buy now

		$bndcfw_emptyCart = get_option('bndcfw-buy-now-empty-cart');
		if ($bndcfw_emptyCart == 1) {
			WC()->cart->empty_cart();
		}

		$quantity = isset($_REQUEST['quantity']) ? absint($_REQUEST['quantity']) : 1;
		if (isset($_REQUEST['variation_id']) && $bndcfw_variation_id = absint($_REQUEST['variation_id'])) {
			//$cart_product_ids = array_merge(wp_list_pluck(WC()->cart->get_cart_contents(), 'variation_id'));
			//if(!in_array($variation_id,$cart_product_ids))
			//{
			WC()->cart->add_to_cart($bndcfw_product_id, $quantity, $bndcfw_variation_id);
			wp_send_json_success([
				'checkout_url' => wc_get_checkout_url()
			]);
			//}
		} else {
			//$cart_product_ids  = array_merge(wp_list_pluck(WC()->cart->get_cart_contents(), 'product_id'));
			//if(!in_array($product_id,$cart_product_ids))
			//{
			WC()->cart->add_to_cart($bndcfw_product_id, $quantity);
			wp_send_json_success([
				'checkout_url' => wc_get_checkout_url()
			]);
			//}
		}


		wp_die();
	}
}
