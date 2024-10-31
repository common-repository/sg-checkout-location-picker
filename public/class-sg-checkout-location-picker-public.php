<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://sevengits.com/
 * @since      1.0.0
 *
 * @package    Sg_Checkout_Location_Picker
 * @subpackage Sg_Checkout_Location_Picker/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Sg_Checkout_Location_Picker
 * @subpackage Sg_Checkout_Location_Picker/public
 * @author     Sevengits <sevengits@gmail.com>
 */
class Sg_Checkout_Location_Picker_Public
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
		 * defined in Sg_Checkout_Location_Picker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sg_Checkout_Location_Picker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/sg-checkout-location-picker-public.css', array(), $this->version, 'all');
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
		 * defined in Sg_Checkout_Location_Picker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sg_Checkout_Location_Picker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if (is_checkout() && !is_wc_endpoint_url('order-received')) {
			wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/sg-checkout-location-picker-public.min.js', array('jquery'), $this->version, true);

			if (get_option('sg_enable_picker') !== 'disable') {

				$api_key = get_option('sg_google_api');

				wp_enqueue_script($this->plugin_name . "-googlemap", 'https://maps.googleapis.com/maps/api/js?key=' . "$api_key&loading=async&libraries=marker", array('jquery'), $this->version, false);
			}
		}
	}
	/**
	 * Showing map in billing section
	 *
	 * @since    1.0.0
	 */

	public function showBillingMap()
	{
		$is_enabled_billing = in_array(get_option('sg_enable_picker', 'enable'), array('enable', 'enable_billing'));

		if ($is_enabled_billing) {

			require_once plugin_dir_path(dirname(__FILE__)) . '/public/partials/sg-checkout-location-picker-public-billing-display.php';
		}
	}

	/**
	 * common options for map in additional notes before section
	 *
	 * @since    1.0.2
	 */

	public function sgMapsOptions()
	{
		$is_enabled_billing = in_array(get_option('sg_enable_picker', 'enable'), array('enable', 'enable_billing'));
		$is_enabled_shipping = in_array(get_option('sg_enable_picker', 'enable'), array('enable', 'enable_shipping'));

		if ($is_enabled_billing  || $is_enabled_shipping) {
			require_once plugin_dir_path(dirname(__FILE__)) . '/public/partials/sg-checkout-location-picker-public-map-options.php';
		}
	}

	/**
	 * showing map in shipping section
	 *
	 * @since    1.0.0
	 */

	public function showshippingMap()
	{
		$is_enabled_shipping = in_array(get_option('sg_enable_picker', 'enable'), array('enable', 'enable_shipping'));


		if ($is_enabled_shipping) {

			require_once plugin_dir_path(dirname(__FILE__)) . '/public/partials/sg-checkout-location-picker-public-shipping-display.php';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . '/public/partials/sg-checkout-location-picker-public-map-options.php';
	}

	public function sgclp_detect_location_btn($args)
	{
		if (!empty(get_option('sgclp_detect_button_label', ''))) {
?>
			<button onclick="sgclp_detect_marker(event, '<?php echo $args['section']; ?>')" class="detect-my-location"><?php echo get_option('sgclp_detect_button_label', 'detect current location'); ?></button>
			<span class="detect-my-location-description"><?php printf(__('Click the "Detect Current Location" button then move the red marker to your desired shipping address.', 'sg-checkout-location-picker')); ?> </span>
<?php
		}
	}
}
