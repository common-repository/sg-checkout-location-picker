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
    <?php if ($is_enabled_billing) {
        $sg_map_billing_title = get_option('sg_map_title_for_billing');
        do_action("sgitsclp_before_billing_title");
    ?>
        <p><label for="map-title" class="sg-map-title msp-title-text"><?php echo _e(($sg_map_billing_title !== '') ? $sg_map_billing_title : 'Set your billing location in map', 'sg-checkout-location-picker'); ?></label></p>
    <?php
        do_action("sgitsclp_after_billing_title");
    }
    do_action("sgitsclp_before_billing_map_container", array('section' => 'billing'));
    ?>
    <div class="sg-container">
        <?php do_action("sgitsclp_before_billing_map", array('section' => 'billing')); ?>
        <div style="width: 100%; height: 350px;" id="sg_billing_map"></div>
        <?php do_action("sgitsclp_after_billing_map", array('section' => 'billing')); ?>

        <p style="margin: 20px 0px;width: 100%; overflow: hidden; height: <?php echo (get_option('sg_hide_picker_fields') === 'yes') ? '0px' : 'auto'; ?>" for="latlong">
            <label for="">
                <span>
                    <?php esc_html_e('Latitude', 'sg-checkout-location-picker'); ?>:
                </span>

                <input type="text" name="billing_lat" id="sg_billing_lat" value="<?php echo '0.0000'; ?>">
            </label>
            <label for="">
                <span>
                    <?php esc_html_e('Longitude', 'sg-checkout-location-picker'); ?>:
                </span>

                <input type="text" name="billing_long" id="sg_billing_long" value="<?php echo '0.0000'; ?>">
            </label>
        </p>

    </div>
    <?php do_action("sgitsclp_after_billing_map_container", array('section' => 'billing')); ?>
</div>