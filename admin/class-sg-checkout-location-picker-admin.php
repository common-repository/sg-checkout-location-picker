<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link  https://sevengits.com/
 * @since 1.0.0
 *
 * @package    Sg_Checkout_Location_Picker
 * @subpackage Sg_Checkout_Location_Picker/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sg_Checkout_Location_Picker
 * @subpackage Sg_Checkout_Location_Picker/admin
 * @author     Sevengits <sevengits@gmail.com>
 */
class Sg_Checkout_Location_Picker_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since 1.0.0
     * @param string $plugin_name The name of this plugin.
     * @param string $version     The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin-facing side of the site.
     *
     * @since    1.0.10
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

        wp_enqueue_style($this->plugin_name . '-admin', plugin_dir_url(__FILE__) . 'css/sg-checkout-location-picker-admin.css', array(), $this->version, 'all');

        if (!wp_style_is('sgits-admin-settings-sidebar-css', 'enqueued'))
            wp_enqueue_style('sgits-admin-settings-sidebar', plugin_dir_url(__FILE__) . 'css/settings-sidebar.css', array(), $this->version, 'all');

        if (!wp_style_is('sgits-admin-common-css', 'enqueued'))
            wp_enqueue_style('sgits-admin-common', plugin_dir_url(__FILE__) . 'css/common.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin-facing side of the site.
     *
     * @since    1.0.10
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

        wp_enqueue_script($this->plugin_name . '-admin', plugin_dir_url(__FILE__) . 'js/sg-checkout-location-picker-admin.js', array('jquery'), $this->version, true);
    }

    /**
     * @since 1.0.0 
     */
    public function sg_get_settings($settings, $current_section)
    {

        $custom_settings = array();
        $general_settings = apply_filters('sgclp_general_settings', array());

        if ('sg_woo_tab' == $current_section) {
            $helpfull_settings = array(array(
                'name'    => __('Helpfull Links', 'sg-checkout-location-picker'),
                'type'    => 'sgitsSettingsSidebar',
                'desc'    => __('Helpfull Links for settings page', 'sg-checkout-location-picker'),
                'desc_tip' => true,
                'id'      => 'promo-helpfull-links',
                'options' => array(
                    array(
                        'name' => __("Documentation", 'sg-checkout-location-picker'),
                        'classList' => "dashicons dashicons-media-default sg-icon",
                        'target' => "_blank",
                        'link' => "https://sevengits.com/docs/sg-woocommerce-checkout-location-picker-pro/?utm_source=wp&utm_medium=promo-sidebar&utm_campaign=settings_page"
                    ),
                    array(
                        'name' => __("Free Support", 'sg-checkout-location-picker'),
                        'classList' => "dashicons dashicons-groups sg-icon",
                        'target' => "_blank",
                        'link' => "https://wordpress.org/support/plugin/sg-checkout-location-picker/",
                    ),
                    array(
                        'name' => __("Request Customization", 'sg-checkout-location-picker'),
                        'classList' => "dashicons dashicons-sos sg-icon",
                        'target' => "_blank",
                        'link' => "https://sevengits.com/contact/?utm_source=wp&utm_medium=promo-sidebar&utm_campaign=settings_page"
                    ),
                    array(
                        'name' => __("Get Premium", 'sg-checkout-location-picker'),
                        'classList' => "dashicons dashicons-awards sg-icon",
                        'target' => "_blank",
                        'link' => "https://sevengits.com/plugin/sg-woocommerce-checkout-location-picker/?utm_source=wp&utm_medium=promo-sidebar&utm_campaign=settings_page"
                    ),
                )
            ));
            $settings_section_end = array(array(
                'type' => 'sectionend',
                'name' => 'end_section',
                'id' => 'ppw_woo'
            ));
            return array_merge($helpfull_settings, $general_settings, $settings_section_end);
        } else {

            return $settings;
        }
    }

    function sgclp_general_settings_content($settings)
    {
        $is_enabled_billing = in_array(get_option('sg_enable_picker', 'enable'), array('enable', 'enable_billing'));
        $is_enabled_shipping = in_array(get_option('sg_enable_picker', 'enable'), array('enable', 'enable_shipping'));
        $location_picker_default_state = 'enable';
        if (get_option('sg_enable_picker_billing', '') !== '' && get_option('sg_enable_picker_shipping', '') !== '') {
            $location_picker_default_state = (get_option('sg_enable_picker_billing') === 'yes') ? 'enable_billing' : 'disable';
            if ($location_picker_default_state === 'disable') {
                $location_picker_default_state = (get_option('sg_enable_picker_shipping') === 'yes') ? 'enable_shipping' : 'disable';
            } else {
                $location_picker_default_state = (get_option('sg_enable_picker_shipping') === 'yes') ? 'enable' : 'disable';
            }
            delete_option('sg_enable_picker_billing');
            delete_option('sg_enable_picker_shipping');
        }
        $new_settings = array(
            array(
                'id'   => "sg_tab_main",
                'type' => "title",
                'name' => __('Sg Woocommerce Checkout Location Picker', 'sg-checkout-location-picker'),
                'desc' => __('Add Sg Woocommerce checkout location picker Settings below', 'sg-checkout-location-picker')
            ),
            array(
                'id'    => "sg_enable_picker",
                'type'  => "select",
                'name'  => __('Enable Location Picker', 'sg-checkout-location-picker'),
                'options'   => array(
                    'disable'   => __('Disable', 'sg-checkout-location-picker'),
                    'enable_billing'    => __('Enable for billing', 'sg-checkout-location-picker'),
                    'enable_shipping'   => __('Enable for shipping', 'sg-checkout-location-picker'),
                    'enable'    => __('Enable for billing & Shipping', 'sg-checkout-location-picker'),
                ),
                'default'   => $location_picker_default_state
            ),

            array(
                'id'    => "sg_google_api",
                'type'  => "text",
                'name'  => __('Google API', 'sg-checkout-location-picker'),

            ),
            array(
                'id'    => "sg_map_title_for_billing",
                'type'  => "text",
                'name'  => __('Label for billing map area', 'sg-checkout-location-picker'),
                'desc'  => __('This title displays the billing map section. Leave it blank to hide', 'sg-checkout-location-picker'),
                'desc_tip'  => true,
            ),

            array(
                'id'    => "sg_map_title_for_shipping",
                'type'  => "text",
                'name'  => __('Label for shipping map', 'sg-checkout-location-picker'),
                'desc'  => __('This title displays the shipping map section. Leave it blank to hide', 'sg-checkout-location-picker'),
                'desc_tip'  => true,
            ),

            array(
                'id'    => "sg_enable_maplink_admin_email",
                'type'  => "checkbox",
                'name'  => __('Location data on admin email', 'sg-checkout-location-picker'),
                'desc'  => __('Send user submitted longitude/latitude data on new admin order email', 'sg-checkout-location-picker'),

            ),
            array(
                'id'    => "sg_hide_picker_fields",
                'type'  => "checkbox",
                'name'  => __('Show map only', 'sg-checkout-location-picker'),
                'desc'  => __('Hide latitude/longitude text field from checkout page.', 'sg-checkout-location-picker'),
                'desc_tip'  => false
            ),

            array(
                'id'    => "sg_eneble_autodetect_user_location",
                'type' => "checkbox",
                'name' => __('Detect user location on loading', 'sg-checkout-location-picker')
            ),

            array(
                'id'    => "sgclp_detect_button_label",
                'type' => "text",
                'name' => __('Show detect current location button', 'sg-checkout-location-picker'),
                'default' => __('detect current location', 'sg-checkout-location-picker'),
                'desc'    => __('If field is empty, But will be hidden. Default value is "detect current location"'),
                'desc_tip'    => true,

            )
        );
        return array_merge($settings, $new_settings);
    }




    /**
     * @since 1.0.0 
     */
    public function sg_add_settings_tab($settings_tab)
    {

        $settings_tab['sg_woo_tab'] = __('SG Location Picker Settings', 'sg-checkout-location-picker');
        return $settings_tab;
    }
    /**
     * @since 1.0.0 
     */
    public function sg_editable_order_meta_billing($order)
    {
        include_once plugin_dir_path(dirname(__FILE__)) . '/admin/partials/sg-checkout-location-picker-admin-billing-display.php';
    }
    /**
     * @since 1.0.0 
     */
    public function sg_editable_order_meta_shipping($order)
    {

        include_once plugin_dir_path(dirname(__FILE__)) . '/admin/partials/sg-checkout-location-picker-admin-shipping-display.php';
    }
    /**
     * @since 1.0.0 
     */

    function woocommerce_checkout_update_user_meta_latlong($order_id, $posted)
    {

        if (!empty($_POST['billing_lat'])) {

            update_post_meta($order_id, 'billing_lat', wc_clean(substr($_POST['billing_lat'], 0, 8)));
        }
        if (!empty($_POST['billing_long'])) {
            update_post_meta($order_id, 'billing_long', wc_clean(substr($_POST['billing_long'], 0, 8)));
        }
        if (!empty($_POST['shipping_lat'])) {
            update_post_meta($order_id, 'shipping_lat', wc_clean(substr($_POST['shipping_lat'], 0, 8)));
        }
        if (!empty($_POST['shipping_long'])) {
            update_post_meta($order_id, 'shipping_long', wc_clean(substr($_POST['shipping_long'], 0, 8)));
        }
    }

    /**
     * @since 1.0.2 For collecting reviews after 3 days 
     */

    function review_admin_notice()
    {
        global $pagenow;
        $now = time(); // or your date as well
        $activated_date = strtotime(get_transient("sg_location_plugin_actived_time"));
        $datediff = round(($now - $activated_date) / (60 * 60 * 24));

        if ($pagenow == 'index.php') {
            $user = wp_get_current_user();
            if (in_array('administrator', (array) $user->roles)) {
                if ($datediff > 2 && $activated_date !== '') {
                    echo '<div class="notice notice-info is-dismissible">
								<p>Hi ' . $user->display_name . ',</p><p>Thank you for using <b>SG Checkout Location Picker</b> plugin. If you found it helpful, please share your feedback here.
								<a href="https://wordpress.org/support/plugin/sg-checkout-location-picker/reviews/?rate=5#new-post" target="_blank">write a review</a>  </p>
								<p>Want any cool features on the coming update? Feel free to write to us.<a href = "mailto: support@sevengits.com">support@sevengits.com</a></p>
								<p>Thank you</p>
								<p>Team <a href="https://sevengits.com/?utm_source=admin-notice&utm_medium=free-plugins-link&utm_campaign=Free-plugin" target="_blank">Sevengits</a></p>
								</div>';
                    delete_transient('sg_location_plugin_actived_time');
                }
            }
        }
    }

    function sg_order_location_link($order, $sent_to_admin, $plain_text, $email)
    {
        $maplink_enabled =  get_option('sg_enable_maplink_admin_email');
        $is_enabled_billing = in_array(get_option('sg_enable_picker', 'enable'), array('enable', 'enable_billing'));
        $is_enabled_shipping = in_array(get_option('sg_enable_picker', 'enable'), array('enable', 'enable_shipping'));
        if ($maplink_enabled !== 'yes') {
            return;
        }
        if ($email->id == 'new_order') :
            if ($is_enabled_billing || $is_enabled_shipping) {
                $billing_lat = get_post_meta($order->get_id(), 'billing_lat', true);
                $billing_long = get_post_meta($order->get_id(), 'billing_long', true);
                $shipping_lat = get_post_meta($order->get_id(), 'shipping_lat', true);
                $shipping_long = get_post_meta($order->get_id(), 'shipping_long', true);

                $maplink_api = "https://www.google.com/maps/search/?api=1&query=";


?>
                <div class="link-container sg-locationlinks-container">
                    <?php
                    if ($is_enabled_billing) {
                        if ($billing_lat !== '' && $billing_long !== '') {

                    ?>
                            <p><a href="<?php echo $maplink_api . $billing_lat . ', ' . $billing_long; ?>" target="_blank" class="link"><?php _e('Billing location in map', 'sg-checkout-location-picker'); ?></a></p>
                        <?php
                        }
                    }
                    if ($is_enabled_shipping) {
                        if ($shipping_lat !== '' && $shipping_long !== '') {
                        ?>
                            <p><a href="<?php echo $maplink_api . $shipping_lat . ', ' . $shipping_long; ?>" target="_blank" class="link"><?php _e('Shipping location in map', 'sg-checkout-location-picker'); ?></a></p>
                    <?php
                        }
                    }
                    ?>
                </div>
        <?php
            }
        endif;
    }


    /**
     * @since 1.0.12 
     * 
     * For merge array with exists array
     * 
     * $position = "start | end" 
     */
    public function sgitsclp_merge_links($old_list, $new_list, $position = "end")
    {
        $settings = array();
        foreach ($new_list as $name => $item) {
            $target = (array_key_exists("target", $item)) ? $item['target'] : '';
            $classList = (array_key_exists("classList", $item)) ? $item['classList'] : '';
            $settings[$name] = sprintf('<a href="%s" target="' . $target . '" class="' . $classList . '">%s</a>', esc_url($item['link'], $this->plugin_name), esc_html__($item['name'], $this->plugin_name));
        }
        if ($position !== "start") {
            // push into $links array at the end
            return array_merge($old_list, $settings);
        } else {
            return array_merge($settings, $old_list);
        }
    }

    /**
     * @since 1.0.0 
     */

    public function sgitsclp_links_below_title_begin($links)
    {
        // if plugin is installed $links listed below the plugin title in plugins page. add custom links at the begin of list
        if (!defined('clp_DISABLED')) {
            $link_list = array(
                'settings' => array(
                    "name" => 'Settings',
                    "classList" => "",
                    "link" => admin_url('admin.php?page=wc-settings&tab=advanced&section=sg_woo_tab')
                )
            );
            $links = $this->sgitsclp_merge_links($links, $link_list, "start");
        }
        return $links;
    }



    /**
     * @since 1.0.0 
     */

    public function sgitsclp_links_below_title_end($links)
    {
        // if plugin is installed $links listed below the plugin title in plugins page. add custom links at the end of list
        $link_list = array(
            'buy-pro' => array(
                "name" => 'Buy Premium',
                "classList" => "pro-purchase get-pro-link",
                "target" => '_blank',
                "link" => 'https://sevengits.com/plugin/sg-woocommerce-checkout-location-picker/?utm_source=Wordpress&utm_medium=plugins-link&utm_campaign=Free-plugin'
            )
        );
        return $this->sgitsclp_merge_links($links, $link_list, "end");
    }

    /**
     * add more links like docs,support and premium version link in plugin page.
     *
     * @since 1.0.10
     */
    function sgitsclp_plugin_description_below_end($links, $file)
    {
        if (strpos($file, 'sg-checkout-location-picker.php') !== false) {
            $new_links = array(
                'pro' => array(
                    "name" => 'Buy Premium',
                    "classList" => "pro-purchase get-pro-link",
                    "target" => '_blank',
                    "link" => 'https://sevengits.com/plugin/sg-woocommerce-checkout-location-picker/?utm_source=dashboard&utm_medium=plugins-link&utm_campaign=Free-plugin'
                ),
                'docs' => array(
                    "name" => 'Docs',
                    "target" => '_blank',
                    "link" => 'https://sevengits.com/docs/sg-woocommerce-checkout-location-picker?utm_source=dashboard&utm_medium=plugins-link&utm_campaign=Free-plugin'
                ),
                'support' => array(
                    "name" => 'Free Support',
                    "target" => '_blank',
                    "link" => 'https://wordpress.org/support/plugin/sg-checkout-location-picker/'
                ),

            );
            $links = $this->sgitsclp_merge_links($links, $new_links, "end");
        }

        return $links;
    }

    // sidebar in plugin settings page
    function sgitsclp_add_admin_settings_sidebar($links)
    {
        ?>
        <div id="sg-settings-sidebar">
            <div id="<?php echo $links['id']; ?>">
                <h4><?php echo $links['name']; ?></h4>
                <ul>
                    <?php
                    foreach ($links['options'] as $key => $item) {
                        if (is_array($item)) :
                            $target = (array_key_exists("target", $item)) ? $item['target'] : '';
                    ?>
                            <li><span class="<?php echo $item['classList']; ?>"></span><a href="<?php echo $item['link']; ?>" target="<?php echo $target; ?>"><?php echo $item['name']; ?></a></li>
                    <?php
                        endif;
                    }
                    ?>
                </ul>
            </div>
        </div>
<?php
    }
}
