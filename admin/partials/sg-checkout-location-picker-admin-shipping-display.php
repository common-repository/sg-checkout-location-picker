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

$shipping_latitude = get_post_meta($order->get_id(), 'shipping_lat', true);
$shipping_longitude = get_post_meta($order->get_id(), 'shipping_long', true);
$maplink_api = esc_url("www.google.com/maps/search/?api=1&query=", "https");
if ($shipping_latitude == '') {
	return;
}
?>
<div class="address">

	<p><strong><?php esc_html_e('Latitude', 'sg-checkout-location-picker'); ?> :</strong> <?php echo esc_html__($shipping_latitude); ?></p>
	<p><strong><?php esc_html_e('Longitude', 'sg-checkout-location-picker'); ?> :</strong> <?php echo esc_html__($shipping_longitude); ?></p>
	<p>
		<a href="<?php echo $maplink_api . $shipping_latitude . ', ' . $shipping_longitude; ?>" target="_blank" class="link">
			<?php esc_html_e('View in map', 'sg-checkout-location-picker'); ?>
		</a>
	</p>

</div>
<div class="edit_address">
	<?php

	woocommerce_wp_text_input(array(
		'id' => 'shipping_lat',
		'label' => 'latitude:',
		'value' => $shipping_latitude,
		'wrapper_class' => 'form-field-small'
	));
	woocommerce_wp_text_input(array(
		'id' => 'shipping_long',
		'label' => 'Longitude:',
		'value' => $shipping_longitude,
		'wrapper_class' => 'form-field-small'
	));
	?></div>