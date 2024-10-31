<?php

/**
 * Fired during plugin activation
 *
 * @link       https://sevengits.com/
 * @since      1.0.0
 *
 * @package    Sg_Checkout_Location_Picker
 * @subpackage Sg_Checkout_Location_Picker/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Sg_Checkout_Location_Picker
 * @subpackage Sg_Checkout_Location_Picker/includes
 * @author     Sevengits <sevengits@gmail.com>
 */
class Sg_Checkout_Location_Picker_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		// set a transient sg_location_plugin_actived_time
		set_transient( "sg_location_plugin_actived_time", date('Y-m-d'), 3* DAY_IN_SECONDS );

	}

}
