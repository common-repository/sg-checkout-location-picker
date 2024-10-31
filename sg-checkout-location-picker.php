<?php

/**
 * Plugin Name:          Sg Checkout Location Picker for WooCommerce
 * Plugin URI:           https://sevengits.com/plugin/sg-checkout-location-picker-pro/
 * Description:          Sg Checkout Location Picker for WooCommerce  help customers to pin point their geo location on map in woocommerce checkout page.
 * Version:              1.0.23
 * Author:               Sevengits
 * Author URI:           https://sevengits.com/plugin/sg-checkout-location-picker-pro/
 * WC requires at least: 3.7
 * WC tested up to: 	 8.7
 * Requires Plugins: woocommerce
 * License:             GPL-2.0+
 * License URI:         http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       	sg-checkout-location-picker
 * Domain Path:      	/languages
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
if (!function_exists('get_plugin_data')) {
	require_once(ABSPATH . 'wp-admin/includes/plugin.php');
}
if (!defined('SG_CHECKOUT_LOCATION_PICKER_VERSION')) {
	define('SG_CHECKOUT_LOCATION_PICKER_VERSION', get_plugin_data(__FILE__)['Version']);
}
// Used for referring to the plugin file or basename
if (!defined('SGITSCLP_BASE')) {
	define('SGITSCLP_BASE', plugin_basename(__FILE__));
}

if (!class_exists('\SGCLP\Reviews\Notice')) {
	require_once plugin_dir_path(__FILE__) . 'includes/packages/plugin-review/notice.php';
}

/**
 * Function for ensure hpos compatible
 */
add_action('before_woocommerce_init', 'woom_hpos_check');
function woom_hpos_check()
{
	if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
	}
}

function sgclp_disabled_plugin_depencies_unavailable()
{
	/**
	 * checking dependency plugins are active
	 */
	$depended_plugins = array(
		array(
			'plugins' => array(
				'WooCommerce' => 'woocommerce/woocommerce.php'
			), 'links' => array(
				'free' => 'https://wordpress.org/plugins/woocommerce/'
			)
		)

	);
	$message = __('The following plugins are required for <b>' . get_plugin_data(__FILE__)['Name'] . '</b> plugin to work. Please ensure that they are activated: ', 'sg-checkout-location-picker');
	$is_disabled = false;
	foreach ($depended_plugins as $key => $dependency) {
		$dep_plugin_name = array_keys($dependency['plugins']);
		$dep_plugin = array_values($dependency['plugins']);
		if (count($dep_plugin) > 1) {
			if (!in_array($dep_plugin[0], apply_filters('active_plugins', get_option('active_plugins'))) && !in_array($dep_plugin[1], apply_filters('active_plugins', get_option('active_plugins')))) {
				$class = 'notice notice-error is-dismissible';
				$is_disabled = true;
				if (isset($dependency['links'])) {
					if (array_key_exists('free', $dependency['links'])) {
						$message .= '<br/> <a href="' . $dependency['links']['free'] . '" target="_blank" ><b>' . $dep_plugin_name[0] . '</b></a>';
					}
					if (array_key_exists('pro', $dependency['links'])) {

						$message .= ' Or <a href="' . $dependency['links']['pro'] . '" target="_blank" ><b>' . $dep_plugin_name[1] . '</b></a>';
					}
				} else {
					$message .= "<br/> <b> $dep_plugin_name[0] </b> Or <b> $dep_plugin_name[1] . </b>";
				}
			}
		} else {
			if (!in_array($dep_plugin[0], apply_filters('active_plugins', get_option('active_plugins')))) {
				$class = 'notice notice-error is-dismissible';
				$is_disabled = true;
				if (isset($dependency['links'])) {
					$message .= '<br/> <a href="' . $dependency['links']['free'] . '" target="_blank" ><b>' . $dep_plugin_name[0] . '</b></a>';
				} else {
					$message .= "<br/><b>$dep_plugin_name[0]</b>";
				}
			}
		}
	}
	if ($is_disabled) {
		if (!defined('clp_DISABLED')) {
			define('clp_DISABLED', true);
		}
		printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
	}

	/**
	 * review notice for administrator
	 */
	if (class_exists('\SGCLP\Reviews\Notice')) {
		// delete_site_option('sgclp_reviews_time'); // FOR testing purpose only. this helps to show message always
		$message = sprintf(__("Hello! Seems like you have been using %s for a while – that’s awesome! Could you please do us a BIG favor and give it a 5-star rating on WordPress? This would boost our motivation and help us spread the word.", 'sg-checkout-location-picker'), "<b>" . get_plugin_data(__FILE__)['Name'] . "</b>");
		$actions = array(
			'review'  => __('Ok, you deserve it', 'sg-checkout-location-picker'),
			'later'   => __('Nope, maybe later I', 'sg-checkout-location-picker'),
			'dismiss' => __('already did', 'sg-checkout-location-picker'),
		);
		$notice = \SGCLP\Reviews\Notice::get(
			'sg-checkout-location-picker',
			get_plugin_data(__FILE__)['Name'],
			array(
				'days'          => 7,
				'message'       => $message,
				'action_labels' => $actions,
				'prefix' => "sgclp"
			)
		);

		// Render notice.
		$notice->render();
	}
}
add_action('admin_notices', 'sgclp_disabled_plugin_depencies_unavailable');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sg-checkout-location-picker-activator.php
 */
function activate_sg_checkout_location_picker()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-sg-checkout-location-picker-activator.php';
	Sg_Checkout_Location_Picker_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sg-checkout-location-picker-deactivator.php
 */
function deactivate_sg_checkout_location_picker()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-sg-checkout-location-picker-deactivator.php';
	Sg_Checkout_Location_Picker_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_sg_checkout_location_picker');
register_deactivation_hook(__FILE__, 'deactivate_sg_checkout_location_picker');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-sg-checkout-location-picker.php';

require plugin_dir_path(__FILE__) . 'plugin-deactivation-survey/deactivate-feedback-form.php';

add_filter('sgits_deactivate_feedback_form_plugins', 'sgitsclp_deactivate_feedback');
function sgitsclp_deactivate_feedback($plugins)
{
	$plugins[] = (object)array(
		'slug'		=> 'sg-checkout-location-picker',
		'version'	=> SG_CHECKOUT_LOCATION_PICKER_VERSION
	);
	return $plugins;
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sg_checkout_location_picker()
{
	$pluginList = get_option('active_plugins');
	$plugin = 'woocommerce/woocommerce.php';
	if (in_array($plugin, $pluginList)) {
		$plugin = new Sg_Checkout_Location_Picker();
		$plugin->run();
	}
}
run_sg_checkout_location_picker();
