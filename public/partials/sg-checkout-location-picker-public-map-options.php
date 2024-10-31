<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://sevengits.com/
 * @since      1.0.0
 *
 * @package    Sg_Checkout_Location_Picker
 * @subpackage Sg_Checkout_Location_Picker/public/partials
 */
$is_enabled_billing = in_array(get_option('sg_enable_picker', 'enable'), array('enable', 'enable_billing'));
$is_enabled_shipping = in_array(get_option('sg_enable_picker', 'enable'), array('enable', 'enable_shipping'));
?>
<div class="sg-hidden-options sg-checkout-hidden-map-options">

    <input type="hidden" id="sg_billing_map_status" value="<?php echo $is_enabled_billing ? 'true' : 'false'; ?>">
    <input type="hidden" id="sg_shipping_map_status" value="<?php echo $is_enabled_shipping ? 'true' : 'false'; ?>">
    <input type="hidden" id="sg_user_location_autodetect" value="<?php echo (get_option('sg_eneble_autodetect_user_location') === 'yes') ? 'true' : 'false'; ?>">
    <input type="hidden" id="sg_zoom_level" value="<?php echo '13'; ?>">
</div>