var formComplete = false;
var PropertyAdd = function() {
    var property = function() {
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
        // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

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

            $('#property_lat').val(latLng.lat());
            $('#property_lng').val(latLng.lng());

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

                $('#property_lat').val(latitude);
                $('#property_lng').val(longitude);

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

        $('.list-group-item-action').on('click', function(e) {
            e.preventDefault();
            var $this = $(this);
            var targetTap = $this.data('target_tab');
            var currentTap = getCurrentTab();
            if (targetTap != currentTap) {
                if (Number(targetTap) < Number(currentTap)) {
                    goToTap(targetTap);
                } else {
                    var currentPassed = localStorage.getItem('isPassStep_'+currentTap);
                    if (currentPassed === "true") {
                        goToTap(targetTap);
                    }
                }
            }
        });

        $('input[name=property_type]').on('change', function() {
            var $this = $(this);
            if ($this.val() === "other") {
                $('input[name=property_type_other]').css({'display': 'block'});
            } else {
                $('input[name=property_type_other]').css({'display': 'none'});
            }
        });

        $('input[name=property_food_inculde_meal]').on('switchChange.bootstrapSwitch', function(event, state) {
            var $this = $(this);
            if (state) {
                $('.property_three_food_container').css({'display': 'block'});
            } else {
                $('.property_three_food_container').css({'display': 'none'});
            }
        });

        $('input.property_activities').on('change', function(e) {
            if ($(this).val() === "Other") {
                if ($(this).is(':checked')) {
                    $('input[name=property_activities_other]').css({'display': 'block'});
                } else {
                    $('input[name=property_activities_other]').css({'display': 'none'});
                }
            }
        });

        var basicDetailForm = $('#property-basic-detail-form');

        var basicDetailFormValid = basicDetailForm.validate({
            ignore: ":hidden",
            rules: {
                property_name: {
                    required: true
                },
                property_currency: {
                    required: true
                },
                property_type: {
                    required: true
                },
                property_room_amount: {
                    required: true
                }
            },
            messages: {},
            errorPlacement: function(error, element) {},
            invalidHandler: function(e, r) {
                swal({title: "", text: "Please add correct data.", type: "error", confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"})
            }
        });

        basicDetailForm.find('.form-submit-btn').on('click', function(e) {
            e.preventDefault();
            if (!basicDetailFormValid.form()) {
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            var url = basicDetailForm.attr('action');

            var formData = new FormData(basicDetailForm[0]);
            var submit_btn = basicDetailForm.find('.form-submit-btn');
            submit_btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    submit_btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                    if (response.result === "success") {
                        localStorage.setItem('currentPropertyId', response.property.id);
                        localStorage.setItem("isPassStep_1", "true");
                        checkStepPass();
                        goToTap(2);
                    }

                    // window.history.pushState(null, null, response.redirect_url);
                    // window.location.reload();
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        });

        var roomAddForm = $('#property-room-add-form');

        var newRoom = roomAddForm.validate({
            ignore: ":hidden",
            rules: {
                property_room_type: {
                    required: true
                },
                room_price: {
                    required: true,
                    number: true
                },
                room_workspace_amount: {
                    required: true
                },
                room_description: {
                    maxlength: 100,
                }
            },
            messages: {},
            errorPlacement: function(error, element) {}
        });

        roomAddForm.on('submit', function(e) {
            e.preventDefault();

            if (!newRoom.form()) {
                swal({title: "", text: "Please add correct data.", type: "error", confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"})
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            var PropertyId = localStorage.getItem('currentPropertyId');
            if (PropertyId === "null") {
                localStorage.setItem("isPassStep_1", "false");
                goToTap(1);
                return false;
            }

            roomAddForm.find('input[name=property_id]').val(PropertyId);

            var url = roomAddForm.attr('action');

            var formData = new FormData(roomAddForm[0]);
            var submit_btn = roomAddForm.find('.form-submit-btn');
            submit_btn.addClass('m-loader m-loader--right m-loader--accent').attr('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    submit_btn.removeClass('m-loader m-loader--right m-loader--accent').attr('disabled', false);
                    if (response.result === "success") {
                        var typeofroom = "Single";

                        if (response.room.room_type == 2) {
                            typeofroom = "Double";
                        } else if (response.room.room_type == 3) {
                            typeofroom = "Shared";
                        } else if (response.room.room_type == 4) {
                            typeofroom = "Apartment";
                        }

                        var isensuit = "No";

                        if (response.room.ensuit == 1) {
                            var isensuit = "Yes";
                        }

                        var roomtableData = '\
                                          <tr id="room_view_'+response.room.id+'">\
                                          <td>' + typeofroom + '</td>\
                                          <td>' + response.room.room_price_night + '('+response.room.room_currency+')</td>\
                                          <td>' + isensuit + '</td>\
                                          <td>\
                                          <a href="javascript:;" data-room_id="' + response.room.id + '" class="property-room-delete_btn m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete ">\
                                          <i class="la la-trash"></i>\
                                          </a>\
                                          </tr>\
                                          ';
                        var roomImageTabelTr = '\
                                            <tr id="room_image_view_'+response.room.id+'">\
                                            <td>' + typeofroom + '</td>\
                                            <td>' + response.room.room_price_night + '('+response.room.room_currency+')</td>\
                                            <td>' + response.room.room_price_week + '('+response.room.room_currency+')</td>\
                                            <td>' + response.room.room_price_month + '('+response.room.room_currency+')</td>\
                                            <td>' + isensuit + '</td>\
                                            <td>\
                                            <a href="javascript:;" data-room_id="' + response.room.id + '" class="property_room_image_add_btn" title="Add Images ">\
                                            Add Images\
                                            </a>\
                                            </tr>\
                                            ';
                        var roomTableContainer = $('#property_room_container>table>tbody');
                        var roomImageTableContainer = $('#room_container_for_images>table>tbody');
                        roomTableContainer.append(roomtableData);
                        roomImageTableContainer.append(roomImageTabelTr);
                        $('#property-room-add-modal').modal('hide');
                        checkSecondStepPass();
                    }
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $('#property_room_description_container > textarea').on('keyup', function(e) {
            var $this = $(this);

            console.log("asdfasdf");

            var current_length = $this.val().length;

            $('#room_description_max_text_container>p>span.current_text').html(current_length);

            if(current_length > 150) {
                $('#room_description_max_text_container p').addClass('error');
            } else {
                $('#room_description_max_text_container p').removeClass('error');
            }
        })

        $('#second-step-save-btn').on('click', function(e) {
            e.preventDefault();
            checkSecondStepPass();
            var isCurrentPassed = localStorage.getItem('isPassStep_2');
            if (isCurrentPassed === "true") {
                goToTap(3);
            } else {
                swal({title: "", text: "Please add Rooms.", type: "error", confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"})
            }
        });

        var locationSetForm = $('#property_location_set_form');

        var locationSetFormValid = locationSetForm.validate({
            ignore: ":hidden",
            rules: {
                property_lat: {
                    required: true
                },
                property_lng: {
                    required: true
                },
                property_address: {
                    required: true
                }
            },
            errorPlacement: function(error, element) {},
            invalidHandler: function(e, r) {
                swal({title: "", text: "Please Select Correct Location.", type: "error", confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"})
            }
        });

        locationSetForm.find('.form-submit-btn').on('click', function(e) {
            e.preventDefault();

            if (!locationSetFormValid.form()) {
                return false;
            }

            var PropertyId = localStorage.getItem('currentPropertyId');
            if (PropertyId === "null") {
                localStorage.setItem("isPassStep_1", "false");
                goToTap(1);
                return false;
            }

            locationSetForm.find('input[name=property_id]').val(PropertyId);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            var url = locationSetForm.attr('action');

            var formData = new FormData(locationSetForm[0]);
            var submit_btn = locationSetForm.find('.form-submit-btn');
            submit_btn.addClass('m-loader m-loader--right m-loader--accent').attr('disabled', true);
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    submit_btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                    if (response.result === "success") {
                        localStorage.setItem("isPassStep_3", "true");
                        checkStepPass();
                        goToTap(4);
                    } else {
                        swal({title: "Error", text: response.msg, type: "error", confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"});
                    }
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        });

        var extraSetForm = $('#property_extra_set_form');

        var extraSetFormValid = extraSetForm.validate({
            ignore: ":hidden",
            rules: {
                room_wifi_speed: {
                    required: true
                }
            },
            errorPlacement: function(error, element) {},
            invalidHandler: function(e, r) {
                swal({title: "", text: "Please Add Wifi Speed", type: "error", confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"})
            }
        });

        extraSetForm.find('.form-submit-btn').on('click', function(e) {
            e.preventDefault();

            if (!extraSetFormValid.form()) {
                return false;
            }

            var PropertyId = localStorage.getItem('currentPropertyId');
            if (PropertyId === "null") {
                localStorage.setItem("isPassStep_1", "false");
                goToTap(1);
                return false;
            }

            extraSetForm.find('input[name=property_id]').val(PropertyId);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            var url = extraSetForm.attr('action');

            var formData = new FormData(extraSetForm[0]);
            var submit_btn = extraSetForm.find('.form-submit-btn');
            submit_btn.addClass('m-loader m-loader--right m-loader--accent').attr('disabled', true);
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    submit_btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                    if (response.result === "success") {
                        localStorage.setItem("isPassStep_4", "true");
                        checkStepPass();
                        goToTap(5);
                    } else {
                        swal({title: "Error", text: response.msg, type: "error", confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"});
                    }
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $('#slim-image-select-form').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            var url = form.attr('action');

            var formData = new FormData(form[0]);
            var submit_btn = form.find('.form-submit-btn');
            submit_btn.addClass('m-loader m-loader--right m-loader--accent').attr('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    submit_btn.removeClass('m-loader m-loader--right m-loader--accent').attr('disabled', false);
                    if (response.result === "success") {
                        var imageSelectedForm = '\
                                              <div class="form-group m-form__group row blog-content">\
                                              <div class="col-lg-12 col-xl-6" style="position: relative;">\
                                              <a class="property-network-speed-img-remove-btn" ><i class="la la-remove" ></i></a>\
                                              <input type="hidden" name="property_wifi_speed_image" value="' + response.image_id + '">\
                                              <img src="' + response.img_url + '" style="width: 100%;" alt="">\
                                              </div>\
                                              </div>\
                                              ';
                        $('.room-network-speed-img-container').html(imageSelectedForm);
                        slimDestroy();
                        slimInit();
                        $('#slim-image-select-modal').modal('hide');
                    }
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $(document).on('click', '.property-room-delete_btn', function(e) {
            e.preventDefault();
            var $this = $(this);
            var roomId = $this.data('room_id');
            $.ajax({
                url: '/admin/properties/room/delete/' + roomId,
                type: 'get',
                success: function(response) {
                    if (response.result == "success") {
                        $('#room_view_'+roomId).remove();
                        $('#room_image_view_'+roomId).remove();
                        checkSecondStepPass();
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        })

        $('#property-workspace-add-include-btn').on('click', function(e) {
            $('#property_workspace_include_add_box').css({'display': 'block'});
        });

        $('#property_workspace_include_add_box>.workspace_include_cancel_btn').on('click', function(e) {
            $('#property_workspace_include_add_box>input').val("");
            $('#property_workspace_include_add_box').css({'display': 'none'});
        });

        $('#property_workspace_include_add_box>.workspace_include_save_btn').on('click', function(e) {
            var inputedVal = $('#property_workspace_include_add_box>input').val();
            if (inputedVal == "") {
                swal({
                    title: "",
                    text: "Please write your include.",
                    type: "error",
                    confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"
                });
                return false;
            }
            var addHtml = '\
                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">\
                        <input type="checkbox" name="property_workspace_include[]" checked value="'+inputedVal+'">' + inputedVal + '\
                        <span></span>\
                        </label>\
                        ';
            var checkListContainer = $('form#property_workspace_form .m-checkbox-list');
            checkListContainer.append(addHtml);
            $('#property_workspace_include_add_box>input').val("");
            $('#property_workspace_include_add_box').css({'display': 'none'});
        });

        var workspaceForm = $('#property_workspace_form');

        var workspaceFormValid = workspaceForm.validate({
            ignore: ":hidden",
            rules: {
                room_workspace_amount: {
                    required: true
                }
            },
            errorPlacement: function(error, element) {},
            invalidHandler: function(e, r) {
                swal({title: "", text: "Please Select Correct.", type: "error", confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"})
            }
        });

        workspaceForm.find('.form-submit-btn').on('click', function(e) {
            e.preventDefault();

            if (!workspaceFormValid.form()) {
                return false;
            }

            var PropertyId = localStorage.getItem('currentPropertyId');
            if (PropertyId === "null") {
                localStorage.setItem("isPassStep_1", "false");
                goToTap(1);
                return false;
            }

            workspaceForm.find('input[name=property_id]').val(PropertyId);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            var url = workspaceForm.attr('action');

            var formData = new FormData(workspaceForm[0]);
            var submit_btn = workspaceForm.find('.form-submit-btn');
            submit_btn.addClass('m-loader m-loader--right m-loader--accent').attr('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    submit_btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                    if (response.result === "success") {
                        localStorage.setItem("isPassStep_5", "true");
                        checkStepPass();
                        goToTap(6);
                    } else {
                        swal({title: "Error", text: response.msg, type: "error", confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"});
                    }
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        })

        var descriptionForm = $('#property_description_form');

        descriptionForm.find('button.property_description_normall_txt').on('click', function(e) {
            var count = descriptionForm.find("div.description-content").length;
            var textInputBox = '\
                <div class="form-group m-form__group row description-content">\
                <div class="col-lg-8" style="position: relative;">\
                <a class="description-content-remove-btn" ><i class="la la-remove" ></i></a>\
                <textarea class="form-control m-input m-input--air property-description-text-input normall" name="property_description_text" data-order="'+count+'" data-text_type="0" rows="4" required></textarea>\
                </div>\
                </div>\
                ';
            var descriptionContainer = descriptionForm.find('.property_description_container');
            descriptionContainer.append(textInputBox);
            // initPlugin();
        });

        descriptionForm.find('button.property_description_bold_txt').on('click', function(e) {
            var count = descriptionForm.find("div.description-content").length;
            var textInputBox = '\
                <div class="form-group m-form__group row description-content">\
                <div class="col-lg-8" style="position: relative;">\
                <a class="description-content-remove-btn" ><i class="la la-remove" ></i></a>\
                <textarea class="form-control m-input m-input--air property-description-text-input bold" name="property_description_text" data-order="'+count+'" data-text_type="1" rows="4" required></textarea>\
                </div>\
                </div>\
                ';
            var descriptionContainer = descriptionForm.find('.property_description_container');
            descriptionContainer.append(textInputBox);
            // initPlugin();
        });

        descriptionForm.find('button.property_description_italic_txt').on('click', function(e) {
            var count = descriptionForm.find("div.description-content").length;
            var textInputBox = '\
                <div class="form-group m-form__group row description-content">\
                <div class="col-lg-8" style="position: relative;">\
                <a class="description-content-remove-btn" ><i class="la la-remove" ></i></a>\
                <textarea class="form-control m-input m-input--air property-description-text-input italic" name="property_description_text" data-order="'+count+'" data-text_type="2" rows="4" required></textarea>\
                </div>\
                </div>\
                ';
            var descriptionContainer = descriptionForm.find('.property_description_container');
            descriptionContainer.append(textInputBox);
            // initPlugin();
        });

        $(document).on('click', '#property_description_form a.description-content-remove-btn', function(){
            var $this = $(this);
            $this.parents('.form-group.description-content').remove();
        });

        descriptionForm.find('.form-submit-btn').on('click', function(e) {
            var count = descriptionForm.find("div.description-content").length;
            if (count === 0) {
                swal({
                    title: "",
                    text: "Please add description.",
                    type: "error",
                    confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"
                });
                return false;
            }

            var isValid = true;

            descriptionForm.find('textarea[name=property_description_text]').each(function(){
                var $this = $(this);
                if($this.val() == "") {
                    isValid = false;
                }
            });

            if (!isValid) {
                swal({
                    title: "",
                    text: "Please write description.",
                    type: "error",
                    confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"
                });
                return false;
            }

            var requestArray = new Array();

            descriptionForm.find('textarea[name=property_description_text]').each(function(){
                var $this = $(this);
                var descriptionValue = $this.val();
                var descriptionPosition = $this.data('order');
                var descriptionType = $this.data('text_type');

                var textContent = {"position": descriptionPosition, "type": descriptionType, "value": descriptionValue};

                requestArray.push(textContent);
            });

            var PropertyId = localStorage.getItem('currentPropertyId');
            if (PropertyId === "null") {
                localStorage.setItem("isPassStep_1", "false");
                goToTap(1);
                return false;
            }

            if (requestArray.length > 0) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                    }
                });

                var url = descriptionForm.attr( 'action' );
                var submit_btn = descriptionForm.find('.form-submit-btn');
                submit_btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

                var finalDescription = {
                    'property_id': PropertyId,
                    'description': requestArray
                };

                $.post(
                    url,
                    {'contents': finalDescription},
                    function(response, status){
                        submit_btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                        if (response.result === "success") {
                            localStorage.setItem("isPassStep_6", "true");
                            checkStepPass();
                            goToTap(7);
                        }
                    }
                );
            }
        });

        var houseRuleForm = $('#property_house_rule_form');

        houseRuleForm.find('#property-house-rule-add-btn').on('click', function(){
            houseRuleForm.find('#property_house_rule_add_box').css({'display': 'block'});
        });

        houseRuleForm.find('.house_rule_cancel_btn').on('click', function() {
            houseRuleForm.find('#property_house_rule_add_box>input').val("");
            houseRuleForm.find('#property_house_rule_add_box').css({'display': 'none'});
        });

        houseRuleForm.find('.house_rule_save_btn').on('click', function() {
            var inputedVal = $('#property_house_rule_add_box>input').val();
            if (inputedVal == "") {
                swal({
                    title: "",
                    text: "Please write your rule.",
                    type: "error",
                    confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"
                });
                return false;
            }
            var addHtml = '\
                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">\
                        <input type="checkbox" name="property_house_rules[]" checked value="'+inputedVal+'">' + inputedVal + '\
                        <span></span>\
                        </label>\
                        ';
            var checkListContainer = houseRuleForm.find('.m-checkbox-list');
            checkListContainer.append(addHtml);
            houseRuleForm.find('#property_house_rule_add_box>input').val("");
            houseRuleForm.find('#property_house_rule_add_box').css({'display': 'none'});
        });

        houseRuleForm.find('.form-submit-btn').on('click', function(e) {
            e.preventDefault();

            var PropertyId = localStorage.getItem('currentPropertyId');
            if (PropertyId === "null") {
                localStorage.setItem("isPassStep_1", "false");
                goToTap(1);
                return false;
            }

            houseRuleForm.find('input[name=property_id]').val(PropertyId);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            var url = houseRuleForm.attr('action');

            var formData = new FormData(houseRuleForm[0]);
            var submit_btn = houseRuleForm.find('.form-submit-btn');
            submit_btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    submit_btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                    if (response.result === "success") {
                        localStorage.setItem("isPassStep_7", "true");
                        checkStepPass();
                        goToTap(8);
                    } else {
                        swal({title: "Error", text: response.msg, type: "error", confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"});
                    }
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        })

        var bookingRuleForm = $('#property_booking_rule_form');

        var bookingRuleFormValid = bookingRuleForm.validate({
            ignore: ":hidden",
            rules: {
                property_booking_rule_check_in_time: {
                    required: true
                },
                property_booking_rule_check_out_time: {
                    required: true
                },
                cancelation_policy: {
                    required: true
                }
            },
            errorPlacement: function(error, element) {},
            invalidHandler: function(e, r) {
                swal({title: "", text: "Please Select Correct.", type: "error", confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"})
            }
        })

        bookingRuleForm.find('input[name=property_booking_rule_is_min_age]').on('change', function(e) {
            var $this = $(this);
            if ($this.is(':checked')) {
                bookingRuleForm.find('input[name=property_booking_rule_min_age]').css({'display': 'block'});
            } else {
                bookingRuleForm.find('input[name=property_booking_rule_min_age]').css({'display': 'none'});
            }
        });

        bookingRuleForm.on('submit', function(e) {
            e.preventDefault();

            var PropertyId = localStorage.getItem('currentPropertyId');
            if (PropertyId === "null") {
                localStorage.setItem("isPassStep_1", "false");
                goToTap(1);
                return false;
            }

            bookingRuleForm.find('input[name=property_id]').val(PropertyId);

            if (!bookingRuleFormValid.form()) {
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            var url = bookingRuleForm.attr('action');

            var formData = new FormData(bookingRuleForm[0]);
            var submit_btn = bookingRuleForm.find('.form-submit-btn');
            submit_btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    submit_btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                    if (response.result === "success") {
                        localStorage.setItem("isPassStep_8", "true");
                        checkStepPass();
                        goToTap(9);
                    } else {
                        swal({title: "Error", text: response.msg, type: "error", confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"});
                    }
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        });

        var mainPhotoSlimForm = $('#property_main_slim-image-select-form');

        $('#property_main_photo_add_btn').on('click', function(e) {
            e.preventDefault();
            var PropertyId = localStorage.getItem('currentPropertyId');
            if (PropertyId === "null") {
                localStorage.setItem("isPassStep_1", "false");
                goToTap(1);
                return false;
            }

            mainPhotoSlimForm.find('input[name=property_id]').val(PropertyId);

            $('#property_main_slim-image-select-modal').modal('show');
        });

        mainPhotoSlimForm.on('submit', function(e) {
            e.preventDefault();
            var form = $(this);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            var url = form.attr('action');

            var formData = new FormData(form[0]);
            var submit_btn = form.find('.form-submit-btn');
            submit_btn.addClass('m-loader m-loader--right m-loader--accent').attr('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    submit_btn.removeClass('m-loader m-loader--right m-loader--accent').attr('disabled', false);
                    if (response.result === "success") {
                        var imageSelectedForm = '\
                                                <div class="single-img-container">\
                                                <label class="m-radio m-radio--solid m-radio--accent" style="position: absolute; bottom: 20px; right: 0;">\
                                                <input type="radio" name="property_main_header_photo" value="'+response.image_id+'" checked>\
                                                <span></span>\
                                                </label>\
                                                <a href="javascript:;" data-property_id="'+response.property_id+'" data-image_id="'+response.image_id+'" class="property_main_image_delete_btn" title="Delete"><i class="la la-trash"></i></a>\
                                                <img src="'+response.image_url+'" alt="">\
                                                </div>\
                                                ';
                        $('#property_main_photo_container').append(imageSelectedForm);

                        localStorage.setItem("isPassStep_9", "true");
                        checkStepPass();

                        slimDestroy();
                        slimInit();
                        $('#property_main_slim-image-select-modal').modal('hide');
                    }
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $('#property_main_photo_form').find('.form-submit-btn').on('click', function(e) {
            var imageCount = 0;

            $('#property_main_photo_container img').each(function(e) {
                imageCount ++;
            });

            if (imageCount === 0) {
                swal({
                    title: "",
                    text: "Please add Main photos.",
                    type: "error",
                    confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"
                });

                return false;
            }

            var form = $('#property_main_photo_form');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            var PropertyId = localStorage.getItem('currentPropertyId');
            if (PropertyId === "null") {
                localStorage.setItem("isPassStep_1", "false");
                goToTap(1);
                return false;
            }

            form.find('input[name=property_id]').val(PropertyId);

            var url = form.attr('action');

            var formData = new FormData(form[0]);
            var submit_btn = form.find('.form-submit-btn');
            submit_btn.addClass('m-loader m-loader--right m-loader--accent').attr('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    submit_btn.removeClass('m-loader m-loader--right m-loader--accent').attr('disabled', false);
                    if (response.result === "success") {
                        localStorage.setItem("isPassStep_9", "true");
                        checkStepPass();
                        goToTap(10);
                    }
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $(document).on('click', '.property_main_image_delete_btn', function(e) {
            e.preventDefault();
            var $this = $(this);
            var propertyId = $this.data('property_id');
            var imageId = $this.data('image_id');
            $.ajax({
                url: '/admin/properties/image/delete/'+propertyId+'/'+imageId,
                type: 'get',
                success: function(response) {
                    console.log(response);
                    if (response.result == "success") {
                        $this.parent().remove();
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        })

        $('#property_room_image_container_close_btn').on('click', function(e) {
            $('.property_room_image_add_conatiner_top>.main_image_container').removeClass('opened');
            setTimeout(function() {
                var loadingHtml = '\
                                <div class="loading_container">\
                                <img src="/assets/images/loading.gif" style="width: 128px;height: 128px;" alt="">\
                                </div>\
                                ';
                $('#room_main_detail_container').html(loadingHtml);
                $('.property_room_image_add_conatiner_top').fadeOut();
            }, 350)
        });

        $(document).on('click', '.property_room_image_add_btn', function(e) {
            e.preventDefault();
            $('.property_room_image_add_conatiner_top').fadeIn(function(){
                $('.property_room_image_add_conatiner_top>.main_image_container').addClass('opened');
            });

            var $this = $(this);
            var roomId = $this.data('room_id');
            $('#property_room_image_select_form>input[name=room_id]').val(roomId);
            $.ajax({
                url: '/admin/properties/room/getDetail/'+roomId,
                type: 'get',
                success: function(response) {
                    if (response.result == "success") {
                        $('#room_main_detail_container').html(response.htmldata);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $('#property_room_image_select_form').on('submit', function(e){
            e.preventDefault();
            var form = $(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            var url = form.attr('action');

            var formData = new FormData(form[0]);
            var submit_btn = form.find('.form-submit-btn');
            submit_btn.addClass('m-loader m-loader--right m-loader--accent').attr('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    submit_btn.removeClass('m-loader m-loader--right m-loader--accent').attr('disabled', false);
                    if (response.result === "success") {
                        var generatedImage = '\
                                            <div class="single-img-container">\
                                            <a href="javascript:;" data-room_id="'+response.room_id+'" data-image_id="'+response.image_id+'" class="property_room_image_delete_btn" title="Delete"><i class="la la-trash"></i></a>\
                                            <img src="'+response.image_url+'" alt="">\
                                            </div>\
                                            ';
                        $('#room_main_detail_container>.room_image_container').append(generatedImage);
                        slimDestroy();
                        slimInit();
                        $('#property_room_image_select_modal').modal('hide');
                    }
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $(document).on('click', '.property_room_image_delete_btn', function(e) {
            e.preventDefault();
            var $this = $(this);
            var roomId = $this.data('room_id');
            var imageId = $this.data('image_id');
            $.ajax({
                url: '/admin/properties/room/image/delete/'+roomId+'/'+imageId,
                type: 'get',
                success: function(response) {
                    console.log(response);
                    if (response.result == "success") {
                        $this.parent().remove();

                        var imageCount = 0;
                        $('#property_main_photo_container img').each(function(e) {
                            imageCount ++;
                        });

                        if (imageCount === 0) {
                            localStorage.setItem("isPassStep_9", "false");
                            checkStepPass();
                        }
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        })

        $('#property-add-complete-btn').on('click', function(){
            formComplete = true;

            window.history.pushState(null, null, '/admin/properties');
            window.location.reload();
        });

        $(document).on('click', '.property-network-speed-img-remove-btn', function(){
            var imageChooseBtn = '\
                                <a href="#slim-image-select-modal" data-toggle="modal" class="btn m-btn--square btn-outline-success m-btn m-btn--custom">Upload Image</a>\
                                ';
            $('.room-network-speed-img-container').html(imageChooseBtn);
        });

        $('#property-amenity-add-btn').on('click', function(e) {
            $('#property_amenity_add_box').css({'display': 'block'});
        });

        $('#property_amenity_add_box a.property_amenity_save_btn').on('click', function(){
            var new_amenity = $('#property_amenity_add_box input').val();

            if (new_amenity == "") {
                swal({
                    title: "",
                    text: "Please add correct amenity.",
                    type: "error",
                    confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"
                });

                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            $.post(
                '/admin/properties/amenity/add',
                {'contents': new_amenity},
                function(response, status){
                    if (response.result === "success") {
                        console.log(response);
                        var amenityContainer = $('#property_amenity_container');
                        var html = '\
                        <label class="col-xl-3 col-lg-4 col-md-6 m-checkbox m-checkbox--solid m-checkbox--brand" style="margin-bottom: 10px;margin-right: 0;">\
                        <input type="checkbox" name="property_amentives[]" checked value="'+response.data.id+'">'+response.data.name+'\
                        <span></span>\
                        </label>\
                        ';
                        amenityContainer.append(html);
                        $('#property_amenity_add_box').css({'display': 'none'});
                        $('#property_amenity_add_box input').val("");
                    }
                }
            );
        })

        $('#property_amenity_add_box a.property_amenity_cancel_btn').on('click', function(){
            $('#property_amenity_add_box').css({'display': 'none'});
            $('#property_amenity_add_box input').val("");
        });

        $('#property-activity-add-btn').on('click', function(e) {
            $('#property_activity_add_box').css({'display': 'block'});
        });

        $('#property_activity_add_box a.property_activity_save_btn').on('click', function(){
            var new_activiy = $('#property_activity_add_box input').val();

            if (new_activiy == "") {
                swal({
                    title: "",
                    text: "Please add correct activity.",
                    type: "error",
                    confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"
                });

                return false;
            }

            var activitiesContainer = $('#property_activities_container');

            var html = '\
            <label class="m-checkbox m-checkbox--solid m-checkbox--brand">\
            <input type="checkbox" class="property_activities" name="property_activities[]" checked value="'+new_activiy+'"> '+new_activiy+'\
            <span></span>\
            </label>\
            ';

            activitiesContainer.append(html);

            $('#property_activity_add_box input').val("");
            $('#property_activity_add_box').css({'display': 'none'});
        });

        $('#property_activity_add_box a.property_activity_cancel_btn').on('click', function(){
            $('#property_activity_add_box input').val("");
            $('#property_activity_add_box').css({'display': 'none'});
        });
    };

    var checkSecondStepPass = function() {
        if ($('#property_room_container>table>tbody>tr').length > 0) {
            localStorage.setItem('isPassStep_2', "true");
        } else {
            localStorage.setItem('isPassStep_2', "false");
        }

        checkStepPass();
    }

    var initLocalStorage = function() {
        localStorage.setItem('currentPropertyId', "null");
        localStorage.setItem('isPassStep_1', "false");
        localStorage.setItem('isPassStep_2', "false");
        localStorage.setItem('isPassStep_3', "false");
        localStorage.setItem('isPassStep_4', "false");
        localStorage.setItem('isPassStep_5', "false");
        localStorage.setItem('isPassStep_6', "false");
        localStorage.setItem('isPassStep_7', "false");
        localStorage.setItem('isPassStep_8', "false");
        localStorage.setItem('isPassStep_9', "false");
        localStorage.setItem('isPassStep_10', "false");
    }

    var checkStepPass = function() {
        var tabBtnContainer = $('#list-tab');
        tabBtnContainer.find('.list-group-item').each(function(e) {
            var $this = $(this);
            var thisTargetTab = $this.data('target_tab');
            var isPassThis = localStorage.getItem('isPassStep_' + thisTargetTab);
            if (isPassThis === "true") {
                $this.addClass('tab-passed');
            } else {
                $this.removeClass('tab-passed');
            }
        });
    }

    var goToTap = function(step) {
        var tabBtnContainer = $('#list-tab');
        tabBtnContainer.find('.list-group-item').each(function(e) {
            var $this = $(this);
            $this.removeClass('active');
        });
        tabBtnContainer.find('.list-group-item').each(function(e) {
            var $this = $(this);
            var thisTargetTab = $this.data('target_tab');
            if (Number(thisTargetTab) === Number(step)) {
                $this.addClass('active');
            }
        });

        var tabContainer = $('#nav-tabContent');
        tabContainer.find('.tab-pane').each(function() {
            var $this = $(this);
            $this.removeClass('show active');
        });

        tabContainer.find('.tab-pane').each(function() {
            var $this = $(this);
            var thisTabStep = $this.data('tab_step');
            if (Number(thisTabStep) === Number(step)) {
                $this.addClass('show active');
            }
        });
    }

    var getCurrentTab = function() {
        var tabContainer = $('#nav-tabContent');
        var currentStep = 1;
        tabContainer.find('.tab-pane').each(function() {
            var $this = $(this);
            if ($this.hasClass('active')) {
                currentStep = $this.data('tab_step');
            }
        });

        return currentStep;
    }

    var slimInit = function() {
        wifiSlimImg = new Slim(document.getElementById('slim-image-select-slim'), {
            minSize: {
                width: 100,
                height: 100
            },
            download: false,
            label: 'Drop your image here or Click',
            statusImageTooSmall: 'Image too small. Min Size is $0 pixel. Try again.'
        });

        wifiSlimImg.size = {
            width: 1000,
            height: 1000
        };

        propertyMainPhoto = new Slim(document.getElementById('property_main_slim-image-select-slim'), {
            minSize: {
                width: 100,
                height: 100
            },
            download: false,
            label: 'Drop your image here or Click',
            statusImageTooSmall: 'Image too small. Min Size is $0 pixel. Try again.'
        });

        propertyMainPhoto.size = {
            width: 1000,
            height: 1000
        };

        propertyRoomImage = new Slim(document.getElementById('property_room_image_select_slim'), {
            minSize: {
                width: 100,
                height: 100
            },
            download: false,
            label: 'Drop your image here or Click',
            statusImageTooSmall: 'Image too small. Min Size is $0 pixel. Try again.'
        });

        propertyRoomImage.size = {
            width: 1000,
            height: 1000
        };
    }

    var slimDestroy = function() {
        wifiSlimImg.destroy();

        propertyMainPhoto.destroy();

        propertyRoomImage.destroy();
    }

    var initPlugin = function() {
        $('.m_selectpicker').selectpicker();
        $('.m-timepicker').timepicker()

        $("input.input_mask_integer").each(function(){
            $(this).inputmask('decimal', {
                leftAlignNumerics: true
            });
        });
        $("[data-switch=true]").bootstrapSwitch();
    }

    return {
        // public functions
        init: function() {
            var wifiSlimImg,
                propertyMainPhoto,
                propertyRoomImage;
            slimInit();
            initPlugin();
            initLocalStorage();
            property();
        }
    };
}();

jQuery(document).ready(function() {
    PropertyAdd.init();
});
