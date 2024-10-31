<?php
$billing_latitude = get_post_meta($post->ID, 'billing_lat', true);
$billing_longitude = get_post_meta($post->ID, 'billing_long', true);
$shipping_latitude = get_post_meta($post->ID, 'shipping_lat', true);
$shipping_longitude = get_post_meta($post->ID, 'shipping_long', true);
?>
<section class="sg-main-container <?php echo wp_is_mobile() ? 'mobile-container' : 'web-container sg-flex-container'; ?>">
    <div class="billing-details-container">
        <div class="billing-map-inner">
            <h4 class="section-title title"><?php _e( 'Billing Location', 'sg-checkout-location-picker' ); ?></h4>
            <div class="map" id="billing_map"></div>
            <div class="latlong-container sg-flex-container">
                <div class="lat">
                    <label for="billing-lat">
                    <?php _e( 'Latitude', 'sg-checkout-location-picker' ); ?>:
                    </label>
                    <input type="text" name="billing_lat" id="billing_lat" value="<?php echo $billing_latitude; ?>">
                </div>
                <div class="long">
                    <label for="billing-long">
                    <?php _e( 'Longitude', 'sg-checkout-location-picker' ); ?>:
                    </label>
                    <input type="text" name="billing_long" id="billing_long" value="<?php echo $billing_longitude; ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="shipping-details-container">
        <div class="shipping-map-inner">
            <h4 class="section-title title"><?php _e( 'Shipping Location', 'sg-checkout-location-picker' ); ?></h4>
            <div class="map" id="shipping_map"></div>
            <div class="latlong-container sg-flex-container">
                <div class="lat">
                    <label for="shipping-lat">
                    <?php _e( 'Latitude', 'sg-checkout-location-picker' ); ?>:
                    </label>
                    <input type="text" name="shipping_lat" id="shipping_lat" value="<?php echo $shipping_latitude; ?>">
                </div>
                <div class="long">
                    <label for="shipping-lat">
                    <?php _e( 'Longitude', 'sg-checkout-location-picker' ); ?>:
                    </label>
                    <input type="text" name="shipping_long" id="shipping_long" value="<?php echo $shipping_longitude; ?>">
                </div>
            </div>

        </div>
    </div>
</section>
<style>
    .sg-flex-container {
        display: flex;
    }

    .sg-flex-container .map {
        height: 250px;
        margin-bottom: 20px;
    }

    .sg-main-container>div {
        border: 1px solid #0000003d;
        margin: auto;
        border-radius: 2px;
        padding: 10px;
    }

    .sg-main-container>div .section-title {
        margin-top: 0px;
    }

    .sg-main-container>div .latlong-container label {
        min-width: 100px;
        display: inline-block;
    }

    .sg-main-container>div .latlong-container input {
        width: 95%;
    }

    .sg-main-container.web-container>div {
        width: calc(50% - 28px);
    }

    .sg-main-container.mobile-container>div {
        width: 100%;
    }

    .sg-main-container.web-container>div:nth-child(odd) {
        margin-left: 0px;
    }

    .sg-main-container.web-container>div:nth-child(even) {
        margin-right: 0px;
    }
</style>

<script>
    function sgMaps() {
        var billing_latlng = {
            lat: parseFloat(document.getElementById('billing_lat').value),
            lng: parseFloat(document.getElementById('billing_long').value)
        };
        var shipping_latlng = {
            lat: parseFloat(document.getElementById('shipping_lat').value),
            lng: parseFloat(document.getElementById('shipping_long').value)
        };
        var billing_map = document.getElementById('billing_map');
        var shipping_map = document.getElementById('shipping_map');
        // console.log(billing_latlng);

        sgMapInitialise(billing_latlng, billing_map);
        sgMapInitialise(shipping_latlng, shipping_map);
    }

    function sgMapInitialise(latlng, map) {
        var zoomController = true;
        var mapZoomPosition = 'RIGHT_BOTTOM';
        var zoomLevel = 13;
        var zoomStyle = 'SMALL';
        var mapTypeControl = false;
        var mapPanControl = true;
        // var mapPanPosition = 'top-center';
        var markerIcon = '';
        var draggable = false;
        var icon = {
            url: markerIcon, // url
            scaledSize: new google.maps.Size(50, 50), // scaled size
        };
        var marker;
        var position = latlng;
        var map = new google.maps.Map(map, {
            streetViewControl: false,
            gestureHandling: 'cooperative',
            zoomControl: zoomController,
            zoomControlOptions: {
                position: google.maps.ControlPosition[mapZoomPosition],
                style: google.maps.ZoomControlStyle[zoomStyle]
            },
            zoom: zoomLevel,
            mapTypeControl: mapTypeControl,
            panControl: mapPanControl,
            fullscreenControl: true,
            center: position,

        });

        marker = new google.maps.Marker({
            map: map,
            draggable: draggable,
            animation: google.maps.Animation.DROP,
            position: position,
            icon: (markerIcon !== '') ? icon : ''
        });
    }
    sgMaps();
</script>