<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://sevengits.com/
 * @since      1.0.0
 *
 * @package    Sg_Checkout_Location_Picker
 * @subpackage Sg_Checkout_Location_Picker/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<br class="clear" />

<?php
/*
			 * get all the meta data values we need
			 */

$billing_latitude = get_post_meta($order->get_id(), 'billing_lat', true);
$billing_longitude = get_post_meta($order->get_id(), 'billing_long', true);
$maplink_api = "https://www.google.com/maps/search/?api=1&query=";
if ($billing_latitude == '') {
	return;
}
?>
<div class="address">

	<p><strong><?php _e('Latitude', 'sg-checkout-location-picker'); ?> :</strong> <?php echo $billing_latitude; ?></p>
	<p><strong><?php _e('Longitude', 'sg-checkout-location-picker'); ?> :</strong> <?php echo $billing_longitude; ?></p>
	<p><a href="<?php echo $maplink_api . $billing_latitude . ', ' . $billing_longitude;  ?>" target="_blanc" class="link"><?php _e('View in map', 'sg-checkout-location-picker'); ?></a></p>
</div>
<div class="edit_address">
	<?php

	woocommerce_wp_text_input(array(
		'id' => 'billing_lat',
		'label' => 'latitude:',
		'value' => $billing_latitude,
		'wrapper_class' => 'form-field-small'
	));
	woocommerce_wp_text_input(array(
		'id' => 'billing_long',
		'label' => 'Longitude:',
		'value' => $billing_longitude,
		'wrapper_class' => 'form-field-small'
	));



	?></div>