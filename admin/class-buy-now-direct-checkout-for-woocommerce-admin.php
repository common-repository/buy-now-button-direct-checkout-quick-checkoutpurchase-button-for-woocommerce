<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/mrjz/
 * @since      1.0.0
 *
 * @package    Buy_Now_Direct_Checkout_For_Woocommerce
 * @subpackage Buy_Now_Direct_Checkout_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Buy_Now_Direct_Checkout_For_Woocommerce
 * @subpackage Buy_Now_Direct_Checkout_For_Woocommerce/admin
 * @author     mrjz <zanzmera.jasmin@gmail.com>
 */
class Buy_Now_Direct_Checkout_For_Woocommerce_Admin
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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/buy-now-direct-checkout-for-woocommerce-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/buy-now-direct-checkout-for-woocommerce-admin.js', array('jquery'), $this->version, false);
	}
	public function buy_now_direct_checkout_for_woocommerce_admin_menu()
	{
		//add_menu_page('Buy Now Settings', 'Buy Now', 'manage_options', $this->plugin_name, 'Buy_Now_Woocommerce_Store_Admin::buy_now_woocommerce_store_admin_page');
		add_submenu_page(
			'woocommerce',
			__('Buy now button settings', 'buy-now-direct-checkout-for-woocommerce'),
			__('Buy Now Button', 'buy-now-direct-checkout-for-woocommerce'),
			'manage_options',
			$this->plugin_name,
			array($this, 'buy_now_direct_checkout_for_woocommerce_admin_page')
		);
		add_action('admin_init', array($this, 'register_buy_now_direct_checkout_for_woocommerce_settings'));
	}
	public function register_buy_now_direct_checkout_for_woocommerce_settings()
	{
		register_setting('buy-now-direct-checkout-for-woocommerce-settings', 'bndcfw-buy-now-button-classes');
		register_setting('buy-now-direct-checkout-for-woocommerce-settings', 'bndcfw-buy-now-empty-cart');
	}
	public function buy_now_direct_checkout_for_woocommerce_admin_page()
	{
?><h1><?php echo __('Buy Now, Direct Checkout For WooCommerce Settings.', 'buy-now-direct-checkout-for-woocommerce'); ?></h1>
		<form method="post" action="options.php">
			<?php settings_fields('buy-now-direct-checkout-for-woocommerce-settings'); ?>
			<?php do_settings_sections('buy-now-direct-checkout-for-woocommerce-settings'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php echo __('Buy now button CSS class:', 'buy-now-direct-checkout-for-woocommerce'); ?></th>
					<td><input type="text" name="bndcfw-buy-now-button-classes" value="<?php echo get_option('bndcfw-buy-now-button-classes'); ?>" /></td>

					<td><?php echo __('Specify CSS class to be applied on Buy now button. (You can specify multiple CSS classes separated by space)', 'buy-now-direct-checkout-for-woocommerce'); ?></td>

				</tr>
				<tr valign="top">
					<th scope="row"><?php echo __('Remove other product from cart', 'buy-now-direct-checkout-for-woocommerce'); ?></th>
					<td><input type="checkbox" name="bndcfw-buy-now-empty-cart" value="1" <?php checked('1', get_option('bndcfw-buy-now-empty-cart')); ?> /></td>
					<td><?php echo __('When checked, previously added product(s) into the cart will be removed and only product(s) added by Buy now button remain in the cart.', 'buy-now-direct-checkout-for-woocommerce'); ?></td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
<?php
	}
}
