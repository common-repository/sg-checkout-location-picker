
let map = [];
let marker = [];
let has_map = [];
let address_types = [];

let sg_location_fields = ['company', 'address', 'city', 'state', 'postcode'];
let billing_lat_element = document.getElementById('sg_billing_lat');
let billing_long_element = document.getElementById('sg_billing_long');
let shipping_lat_element = document.getElementById('sg_shipping_lat');
let shipping_long_element = document.getElementById('sg_shipping_long');
let addresses = [];
let has_billing_map = (document.getElementById('sg_billing_map_status').value === 'true') ? true : false;
let has_shipping_map = (document.getElementById('sg_shipping_map_status').value === 'true') ? true : false;


jQuery(document).ready(function () {
    if (document.body.contains(billing_lat_element) && document.body.contains(billing_long_element)) {
        address_types.push("billing");
    }
    if (document.body.contains(shipping_lat_element) && document.body.contains(shipping_long_element)) {
        address_types.push("shipping");

    }

    getOrderAddresses();
    // initialize mapsin checkout page
    sgInitMap();
});

function getSgMapOptions() {
    let option_list = {};
    let position;
    position = {};
    if (has_billing_map && document.body.contains(billing_lat_element) && document.body.contains(billing_long_element)) {
        position = {
            ...position,
            billing_lat: (billing_lat_element.value !== '') ? parseFloat(billing_lat_element.value) : 0,
            billing_lng: (billing_long_element.value !== '') ? parseFloat(billing_long_element.value) : 0
        };
    }
    if (has_shipping_map && document.body.contains(shipping_lat_element) && document.body.contains(shipping_long_element)) {
        position = {
            ...position,
            shipping_lat: (shipping_lat_element.value !== '') ? parseFloat(shipping_lat_element.value) : 0,
            shipping_lng: (shipping_long_element.value !== '') ? parseFloat(shipping_long_element.value) : 0
        };
    }
    option_list.position = position;
    option_list.zoomlevel = (document.getElementById('sg_zoom_level').value === '') ? 13 : parseInt(document.getElementById('sg_zoom_level').value);
    return option_list;
}

function updateMarkerPosition(map, marker, position, type) {
    marker.setPosition(new google.maps.LatLng(position.lat, position.lng));
    map.panTo(new google.maps.LatLng(position.lat, position.lng));
    updateInputLatLng(position, type);
};

function updateInputLatLng(position, type) {
    if (document.body.contains(billing_lat_element) && document.body.contains(billing_long_element) || document.body.contains(shipping_lat_element) && document.body.contains(shipping_long_element)) {
        if (type === 'billing' && document.body.contains(billing_lat_element) && document.body.contains(billing_long_element)) {
            billing_lat_element.value = position.lat.toFixed(5);
            billing_long_element.value = position.lng.toFixed(5);
            if (shipping_lat_element !== null && shipping_long_element !== null) {
                shipping_lat_element.value = position.lat.toFixed(5);
                shipping_long_element.value = position.lng.toFixed(5);
            }
        } else if (type === 'shipping' && document.body.contains(shipping_lat_element) && document.body.contains(shipping_long_element)) {
            shipping_lat_element.value = position.lat.toFixed(5);
            shipping_long_element.value = position.lng.toFixed(5);
        } else {

            if (has_billing_map && document.body.contains(billing_lat_element) && document.body.contains(billing_long_element)) {
                billing_lat_element.value = position.lat.toFixed(5);
                billing_long_element.value = position.lng.toFixed(5);
            }
            if (has_shipping_map && document.body.contains(shipping_lat_element) && document.body.contains(shipping_long_element)) {
                shipping_lat_element.value = position.lat.toFixed(5);
                shipping_long_element.value = position.lng.toFixed(5);
            }
        }

    }
}

function getOrderAddresses() {
    var fields = jQuery("#customer_details").find('select, textarea, input[type="text"]');
    addresses = [
        [],
        []
    ];
    let sg_billing_field_list = [
        [],
        []
    ];

    address_types.forEach((type, typeId) => {
        sg_location_fields.forEach(base => {
            for (let field of fields) {
                if (field.id.includes(base) && field.id.includes(type)) {
                    sg_billing_field_list[typeId].push(field);
                }
            }
        });

        for (let field of fields) {
            if (field.id.includes('country') && field.id.includes(type)) {
                sg_billing_field_list[typeId].push(field);
            }
        }

        let address = getNewAddressArray(sg_billing_field_list[typeId]);
        addresses[typeId] = {
            length: address.length - 2,
            address: address.toString(),
            fields: sg_billing_field_list[typeId]
        };
    });
    return addresses;
}



function getNewAddressArray(fields) {
    let address_arr = [];
    for (let field of fields) {
        if (field.tagName.toLowerCase() === 'select') {
            address_arr.push(field.options[field.selectedIndex].text);
        } else {
            address_arr.push(field.value);
        }
    }
    address_arr = address_arr.filter(a => a !== '');
    return address_arr;
}

function updateAddress(addressList, map, marker, type) {
    const geocoder = new google.maps.Geocoder();
    let address = addressList;

    geocoder.geocode({ address: address }, (results, status) => {
        if (status === "OK") {
            map.setCenter(results[0].geometry.location);
            marker.setPosition(results[0].geometry.location);
            updateInputLatLng({ lat: results[0].geometry.location.lat(), lng: results[0].geometry.location.lng() }, type);
        } else {
            console.log(status);
        }
    });
}

function sgInitMap() {
    let map_options, marker_options;
    let options = getSgMapOptions();
    let has_autolocate = (document.getElementById('sg_user_location_autodetect').value === 'true') ? true : false;
    let position;
    position = [];
    if (has_billing_map) {
        position.push({
            lat: options.position.billing_lat,
            lng: options.position.billing_lng
        });
    }
    if (has_shipping_map) {
        position.push({
            lat: options.position.shipping_lat,
            lng: options.position.shipping_lng
        });
    }
    map_options = {
        zoom: options.zoomlevel,
        mapTypeControlOptions: {
            mapTypeIds: ['roadmap', 'satellite']
        },
    };

    marker_options = {
        draggable: true
    };
    if (has_billing_map) {
        has_map.push(has_billing_map);
    }
    if (has_shipping_map) {
        has_map.push(has_shipping_map);

    }
    for (const key in address_types) {
        if (has_map[key]) {
            map[key] = new google.maps.Map(document.getElementById('sg_' + address_types[key] + '_map'), { ...map_options, center: position[key] });
            marker[key] = new google.maps.Marker({ ...marker_options, map: map[key], position: position[key] });

            marker[key].addListener('dragend', function () {
                updateInputLatLng({ lat: marker[key].getPosition().lat(), lng: marker[key].getPosition().lng() }, address_types[key]);
            });
            let address = addresses[key];
            if (address.length > 0) {
                updateAddress(address.address, map[key], marker[key], address_types[key]);
            }
            for (const field of address.fields) {
                if (field.id.includes('country') || field.id.includes('state')) {

                } else {
                    field.onchange = function () {
                        let address_string = getNewAddressArray(address.fields);
                        updateAddress(address_string.toString(), map[key], marker[key], address_types[key]);

                    };

                }
            }
        }
    }
    if (has_autolocate) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((event) => {
                let position = {};
                position = {
                    lat: event.coords.latitude,
                    lng: event.coords.longitude
                };
                for (const key in address_types) {
                    if (has_map[key]) {
                        updateMarkerPosition(map[key], marker[key], position, address_types[key]);
                        updateInputLatLng(position, address_types[key]);
                    }

                }
            }, (error) => {
                console.log(error.message);
            });

        }
    }
}

function sgclp_detect_marker(event, section) {
    event.preventDefault();
    navigator.geolocation.getCurrentPosition((evt) => {
        let position = {};
        position = {
            lat: evt.coords.latitude,
            lng: evt.coords.longitude
        };
        for (const key in address_types) {
            if (has_map[key] && address_types[key] === section) {
                updateMarkerPosition(map[key], marker[key], position, address_types[key]);
                updateInputLatLng(position, address_types[key]);
            }

        }
    }, (error) => {
        console.log(error.message);
    });
}