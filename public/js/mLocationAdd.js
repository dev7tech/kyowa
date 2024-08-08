var ManageLocation = function() {
    var location = function() {
        var myLatLng = {
            lat: 51.509865,
            lng: -0.118092
        };

        var mapOptions = {
            center: myLatLng,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.terrain,
            mapTypeControl: false,
            fullscreenControl: false,
            streetViewControl: false,
            styles: [
                {
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#f5f5f5"
                        }
                    ]
                }, {
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                }, {
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#616161"
                        }
                    ]
                }, {
                    "elementType": "labels.text.stroke",
                    "stylers": [
                        {
                            "color": "#f5f5f5"
                        }
                    ]
                }, {
                    "featureType": "administrative.land_parcel",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#bdbdbd"
                        }
                    ]
                }, {
                    "featureType": "poi",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#eeeeee"
                        }
                    ]
                }, {
                    "featureType": "poi",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#757575"
                        }
                    ]
                }, {
                    "featureType": "poi.park",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#e5e5e5"
                        }
                    ]
                }, {
                    "featureType": "poi.park",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#9e9e9e"
                        }
                    ]
                }, {
                    "featureType": "road",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        }
                    ]
                }, {
                    "featureType": "road.arterial",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#757575"
                        }
                    ]
                }, {
                    "featureType": "road.highway",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#dadada"
                        }
                    ]
                }, {
                    "featureType": "road.highway",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#616161"
                        }
                    ]
                }, {
                    "featureType": "road.local",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#9e9e9e"
                        }
                    ]
                }, {
                    "featureType": "transit.line",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#e5e5e5"
                        }
                    ]
                }, {
                    "featureType": "transit.station",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#eeeeee"
                        }
                    ]
                }, {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#c9c9c9"
                        }
                    ]
                }, {
                    "featureType": "water",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#9e9e9e"
                        }
                    ]
                }
            ]
        };

        map = new google.maps.Map(document.getElementById('map'), mapOptions);
        var geocoder = new google.maps.Geocoder();

        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
            searchBox.setBounds(map.getBounds());
        });

        marker = new google.maps.Marker({map: map, position: myLatLng});

        google.maps.event.addListener(map, "click", function(e) {

            //lat and lng is available in e object
            var latLng = e.latLng;
            geocoder.geocode({
                'latLng': latLng
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        // alert(results[0].formatted_address);
                        input.value = (results[0].formatted_address);
                    }
                }
            });

            $('#pac-input-latitude').val(latLng.lat());
            $('#pac-input-longitude').val(latLng.lng());

            marker.setMap(null);
            marker = '';

            // Create a marker for each place.
            marker = new google.maps.Marker({map: map, position: latLng});
        });

        var markers = [];
        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }

                var latitude = place.geometry.location.lat();
                var longitude = place.geometry.location.lng();

                $('#pac-input-latitude').val(latitude);
                $('#pac-input-longitude').val(longitude);

                marker.setMap(null);
                marker = '';

                // Create a marker for each place.
                marker = new google.maps.Marker({map: map, title: place.name, position: place.geometry.location});

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });

        var locationAddForm = $('#wandergo-location-form');

        locationAddForm.validate({
            rules: {
                location_name: {
                    required: true
                },
                location_address: {
                    required: true
                },
                location_latitude: {
                    required: true
                },
                location_longitude: {
                    required: true
                }
            }
        });

        locationAddForm.on('submit', function(e) {
            e.preventDefault();

            if (!locationAddForm.valid()) {
                console.log("failed");
                return false;
            }

            console.log("passed");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            var url = locationAddForm.attr('action');

            var formData = new FormData(locationAddForm[0]);

            var submit_btn = locationAddForm.find('.form-submit-btn');

            submit_btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    submit_btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                    //
                    window.history.pushState(null, null, response.edit_url);
                    window.location.reload();
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        });

        function formatRepo(repo) {
            if (repo.loading) return repo.text;

            var markup = "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>"+repo.location+", "+repo.airport_symbol+"</div></div></div>";

            return markup;
        }

        function formatRepoSelection(repo) {
            var locatio_airport;
            if (repo.id != "") {
                locatio_airport = repo.airport_name+" - "+repo.airport_symbol;
            } else {
                locatio_airport = repo.text;
            }
            return locatio_airport;
        }

        var csr_token = $('meta[name="csrf-token"]').attr('content')

        $('#location_airport').select2({
            placeholder: "Select Airport",
            ajax: {
                type: "POST",
                url: '/admin/locations/getAirportData',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        _token: csr_token,
                        airport_string: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function(data, page) {
                    return {results: data};
                },
                cache: true
            },
            escapeMarkup: function(markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection,
        });
    };

    return {
        // public functions
        init: function() {
            location();
        }
    };
}();

jQuery(document).ready(function() {
    ManageLocation.init();
});
