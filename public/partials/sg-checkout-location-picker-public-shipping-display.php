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
?>

<div class="sg-checkout-location-picker-wrapper">
    <?php

    if ($is_enabled_shipping) {
        $sg_map_shipping_title = get_option('sg_map_title_for_shipping');
        do_action("sgitsclp_before_shipping_title");
    ?>
        <p><label for="map-title" class="sg-map-title msp-title-text"><?php echo _e(($sg_map_shipping_title !== '') ? $sg_map_shipping_title : 'Set your shipping location in map', 'sg-checkout-location-picker'); ?></label></p>
    <?php
        do_action("sgitsclp_after_shipping_title");
    }
    do_action("sgitsclp_before_shipping_map_container", array('section' => 'shipping'));
    ?>
    <div class="sg-container">
        <?php do_action("sgitsclp_before_shipping_map", array('section' => 'shipping')); ?>
        <div style="width: 100%; height: 350px;" id="sg_shipping_map"></div>
        <?php do_action("sgitsclp_after_shipping_map", array('section' => 'shipping')); ?>
        <p style="margin: 20px 0px;width: 100%; overflow: hidden; height: <?php echo (get_option('sg_hide_picker_fields') === 'yes') ? '0px' : 'auto' ?>" for="latlong">
            <label for="shipping_lat">
                <?php echo __("Latitude:", "sg-checkout-location-picker"); ?>
                <input type="text" name="shipping_lat" id="sg_shipping_lat" value="<?php echo '0.0000'; ?>">
            </label>
            <label for="shipping_long">
                <?php echo __("Longitude:", "sg-checkout-location-picker"); ?>
                <input type="text" name="shipping_long" id="sg_shipping_long" value="<?php echo '0.0000'; ?>">
            </label>
        </p>
    </div>
    <?php do_action("sgitsclp_after_shipping_map_container", array('section' => 'shipping')); ?>
</div>