var formComplete = false;
var WorkspaceEdit = function() {
    var workspace = function() {
        var givenLat = $('#workspace_lat').val();
        givenLat = Number(givenLat);
        var givenLng = $('#workspace_lng').val();
        givenLng = Number(givenLng);

        var myLatLng = {
            lat: givenLat,
            lng: givenLng
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

            $('#workspace_lat').val(latLng.lat());
            $('#workspace_lng').val(latLng.lng());

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

                $('#workspace_lat').val(latitude);
                $('#workspace_lng').val(longitude);

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

        var basicDetailForm = $('#workspace_basic_detail_form');

        var basicDetailFormValid = basicDetailForm.validate({
            ignore: ":hidden",
            rules: {
                workspace_name: {
                    required: true
                },
            },
            messages: {},
            errorPlacement: function(error, element) {},
            invalidHandler: function(e, r) {
                swal({
                    title: "",
                    text: "Please add Working Space Name.",
                    type: "error",
                    confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"
                });
            }
        });

        basicDetailForm.find('input[name=workspace_opening_always]').on('change', function(e) {
            var $this = $(this);
            if ($this.is(':checked')) {
                basicDetailForm.find('.workspace_openning_choose_container_div').css({'display': 'none'});
            } else {
                basicDetailForm.find('.workspace_openning_choose_container_div').css({'display': 'block'});
            }
        });

        basicDetailForm.find('input[name=workspace_open_sat]').on('change', function(e) {
            console.log("Asdfasdf");
            var $this = $(this);
            if ($this.is(':checked')) {
                basicDetailForm.find('#saturday_opening_time_container').css({'display': 'block'});
            } else {
                basicDetailForm.find('#saturday_opening_time_container').css({'display': 'none'});
            }
        });

        basicDetailForm.find('input[name=workspace_open_sun]').on('change', function(e) {
            console.log("Asdfasdf");
            var $this = $(this);
            if ($this.is(':checked')) {
                basicDetailForm.find('#sunday_opening_time_container').css({'display': 'block'});
            } else {
                basicDetailForm.find('#sunday_opening_time_container').css({'display': 'none'});
            }
        });

        basicDetailForm.on('submit', function(e) {
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
            var submit_btn = basicDetailForm.find('.submit-btn');
            submit_btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    submit_btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                    if (response.result === "success") {
                        localStorage.setItem("isPassStep_1", "true");
                        $('#workspace-website-url-span').html(response.workspace.workspace_website);
                        checkStepPass();
                        goToTap(2);
                    }
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        });

        //description
        var descriptionForm = $('#workspace_description_form');

        descriptionForm.find('button.description_normall_txt').on('click', function(e) {
            var count = descriptionPosition();
            var textInputBox = '\
                <div class="form-group m-form__group row description-content">\
                <div class="col-lg-8" style="position: relative;">\
                <a class="description-content-remove-btn" ><i class="la la-remove" ></i></a>\
                <textarea class="form-control m-input m-input--air workspace-description-textarea normall" name="workspace_desciprion" data-order="'+count+'" data-text_type="0" rows="4"></textarea>\
                </div>\
                </div>\
                ';
            var descriptionContainer = descriptionForm.find('.workspace_description_container');
            descriptionContainer.append(textInputBox);
        });

        descriptionForm.find('button.description_bold_txt').on('click', function(e) {
            var count = descriptionPosition();
            var textInputBox = '\
                <div class="form-group m-form__group row description-content">\
                <div class="col-lg-8" style="position: relative;">\
                <a class="description-content-remove-btn" ><i class="la la-remove" ></i></a>\
                <textarea class="form-control m-input m-input--air workspace-description-textarea bold" name="workspace_desciprion" data-order="'+count+'" data-text_type="1" rows="4"></textarea>\
                </div>\
                </div>\
                ';
            var descriptionContainer = descriptionForm.find('.workspace_description_container');
            descriptionContainer.append(textInputBox);
        });

        descriptionForm.find('button.description_italic_txt').on('click', function(e) {
            var count = descriptionPosition();
            var textInputBox = '\
                <div class="form-group m-form__group row description-content">\
                <div class="col-lg-8" style="position: relative;">\
                <a class="description-content-remove-btn" ><i class="la la-remove" ></i></a>\
                <textarea class="form-control m-input m-input--air workspace-description-textarea italic" name="workspace_desciprion" data-order="'+count+'" data-text_type="2" rows="4"></textarea>\
                </div>\
                </div>\
                ';
            var descriptionContainer = descriptionForm.find('.workspace_description_container');
            descriptionContainer.append(textInputBox);
        });

        $(document).on('click', '#workspace_description_form a.description-content-remove-btn', function(){
            var $this = $(this);
            $this.parents('.form-group.description-content').remove();
            var count = descriptionPosition();
        });

        descriptionForm.on('submit', function(e) {
            e.preventDefault();

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

            descriptionForm.find('textarea[name=workspace_desciprion]').each(function(){
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

            descriptionForm.find('textarea[name=workspace_desciprion]').each(function(){
                var $this = $(this);
                var descriptionValue = $this.val();
                var descriptionPosition = $this.data('order');
                var descriptionType = $this.data('text_type');

                var textContent = {"position": descriptionPosition, "type": descriptionType, "value": descriptionValue};

                requestArray.push(textContent);
            });

            var workspaceId = descriptionForm.find('input[name=workspace_id]').val();

            if (requestArray.length > 0) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                    }
                });

                var url = descriptionForm.attr( 'action' );
                var submit_btn = descriptionForm.find('.submit-btn');
                submit_btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

                var finalDescription = {
                    'workspace_id': workspaceId,
                    'description': requestArray
                };

                $.post(
                    url,
                    {'contents': finalDescription},
                    function(response, status){
                        submit_btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                        // console.log(response);
                        if (response.result === "success") {
                            localStorage.setItem("isPassStep_2", "true");
                            checkStepPass();
                            goToTap(3);
                        }
                    }
                );
            }
        });

        //photo
        var PhotoSlimForm = $('#workspace_main_slim_image_form');

        PhotoSlimForm.on('submit', function(e) {
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
                                                <a href="javascript:;" data-workspace_id="'+response.workspace_id+'" data-image_id="'+response.image_id+'" class="workspace_image_delete_btn" title="Delete"><i class="la la-trash"></i></a>\
                                                <img src="'+response.image_url+'" alt="">\
                                                </div>\
                                                ';
                        $('#workspace_photo_container').append(imageSelectedForm);

                        localStorage.setItem("isPassStep_3", "true");
                        checkStepPass();

                        slimDestroy();
                        slimInit();
                        $('#workspace_main_slim_image_modal').modal('hide');
                    }
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $('#workspace_photo_form').on('submit', function(e) {
            e.preventDefault();

            var imageCount = 0;

            $('#workspace_photo_container img').each(function(e) {
                imageCount ++;
            });

            if (imageCount === 0) {
                swal({
                    title: "",
                    text: "Please add photos.",
                    type: "error",
                    confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"
                });

                return false;
            }

            localStorage.setItem("isPassStep_3", "true");
            checkStepPass();
            goToTap(4);
        });

        var locationSetForm = $('#workspace_location_form');

        var locationSetFormValid = locationSetForm.validate({
            ignore: ":hidden",
            rules: {
                workspace_address: {
                    required: true
                },
            },
            errorPlacement: function(error, element) {},
            invalidHandler: function(e, r) {
                swal({
                    title: "",
                    text: "Please point correct addrres on map.",
                    type: "error",
                    confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"
                });
            }
        });

        locationSetForm.on('submit', function(e) {
            e.preventDefault();

            if (!locationSetFormValid.form()) {
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            var url = locationSetForm.attr('action');

            var formData = new FormData(locationSetForm[0]);
            var submit_btn = locationSetForm.find('.submit-btn');
            submit_btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);
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
                        swal({
                            title: "Error",
                            text: response.msg,
                            type: "error",
                            confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"
                        });
                    }
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        });

        var amenityForm = $('#workspace_amenities_form');

        $(document).on('click', '#workspace_amenities_form a.workspace_new_amenity_add_btn', function(e) {
            var $this = $(this);
            var categoryId = $this.data('category_id');
            $('#workspace_add_amenity_form>input[name=category_id]').val(categoryId);
            $('#workspace_add_amenity_modal').modal('show');
        });

        $('#workspace_add_amenity_form').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            var url = form.attr('action');

            var formData = new FormData(form[0]);
            var submit_btn = form.find('.submit-btn');
            submit_btn.addClass('m-loader m-loader--right m-loader--accent').attr('disabled', true);
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    submit_btn.removeClass('m-loader m-loader--right m-loader--accent').attr('disabled', false);

                    if (response.result == "success") {
                        var amenityCheckbox = '\
                                            <label class="m-checkbox m-checkbox--solid m-checkbox--brand" style="margin-bottom: 10px;margin-right: 0;">\
                                            <input type="checkbox" class="amenity-check-box" checked name="workspace_amentives[]" value="'+response.amenity.id+'">'+response.amenity.name+'\
                                            <span></span>\
                                            </label>\
                                            ';
                        var amenityCatDiv = $('#workspace_amenities_cat_'+response.amenity.cat_id);
                        amenityCatDiv.append(amenityCheckbox);
                        $('#workspace_add_amenity_modal').modal('hide');
                        form[0].reset();
                    }
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        })

        $('#workspace_add_amenity_category_form').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            var url = form.attr('action');

            var formData = new FormData(form[0]);
            var submit_btn = form.find('.submit-btn');
            submit_btn.addClass('m-loader m-loader--right m-loader--accent').attr('disabled', true);
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    submit_btn.removeClass('m-loader m-loader--right m-loader--accent').attr('disabled', false);
                    console.log(response);
                    if (response.result == "success") {
                        var amenitycatList = '\
                                            <div class="col-xl-4 col-lg-6" style="margin-bottom: 20px;">\
                                            <div class="m-checkbox-list" id="workspace_amenities_cat_'+response.category.id+'">\
                                            <label>'+response.category.cat_name+'</label></div>\
                                            <a href="javascript:;" class="workspace_new_amenity_add_btn" data-category_id="'+response.category.id+'" >add Amenity</a>\
                                            </div>\
                                            ';
                        $('#add_amenity_category_container_div').before(amenitycatList);
                        $('#workspace_add_amenity_category_modal').modal('hide');
                        form[0].reset();
                    }
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        });

        amenityForm.on('submit', function(e) {
            e.preventDefault();

            var submitable = false;

            amenityForm.find('input.amenity-check-box').each(function() {
                var $this = $(this);
                if ($this.is(':checked')) {
                    submitable = true;
                }
            });

            if (!submitable) {
                swal({
                    title: "Error",
                    text: 'Please choose at least one amenity.',
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

            var url = amenityForm.attr('action');

            var formData = new FormData(amenityForm[0]);
            var submit_btn = amenityForm.find('.submit-btn');
            submit_btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);
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
                        swal({
                            title: "Error",
                            text: response.msg,
                            type: "error",
                            confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"
                        });
                    }
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        });

        var pricingForm = $('#workspace_pricing_form');

        var pricingFormValid = pricingForm.validate({
            ignore: ":hidden",
            rules: {
                workspace_pricing: {
                    required: true
                },
            },
            errorPlacement: function(error, element) {},
            invalidHandler: function(e, r) {
                swal({
                    title: "",
                    text: "Please Write your Pricing Text.",
                    type: "error",
                    confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"
                });
            }
        });

        pricingForm.on('submit', function(e) {
            e.preventDefault();

            if (!pricingFormValid.form()) {
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            var url = pricingForm.attr('action');

            var formData = new FormData(pricingForm[0]);
            var submit_btn = pricingForm.find('.submit-btn');
            submit_btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    submit_btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                    if (response.result === "success") {
                        localStorage.setItem("isPassStep_6", "true");
                        checkStepPass();
                        window.history.pushState(null, null, '/admin/workspace');
                        window.location.reload();
                    } else {
                        swal({
                            title: "Error",
                            text: response.msg,
                            type: "error",
                            confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"
                        });
                    }
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        })
    };

    var initLocalStorage = function() {
        localStorage.setItem('isPassStep_1', "true");
        localStorage.setItem('isPassStep_2', "true");
        localStorage.setItem('isPassStep_3', "true");
        localStorage.setItem('isPassStep_4', "true");
        localStorage.setItem('isPassStep_5', "true");
        localStorage.setItem('isPassStep_6', "true");
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

    var descriptionPosition = function() {
        var descriptionForm = $('#workspace_description_form');

        var count = 0;

        descriptionForm.find('textarea[name=workspace_desciprion]').each(function(){
            var $this = $(this);
            $this.data("order", count);
            count++;
        });

        return count;
    }

    var slimInit = function() {
        workspacePhoto = new Slim(document.getElementById('workspace_main_slim_image_slim'), {
            minSize: {
                width: 100,
                height: 100
            },
            download: false,
            label: 'Drop your image here or Click',
            statusImageTooSmall: 'Image too small. Min Size is $0 pixel. Try again.'
        });

        workspacePhoto.size = {
            width: 1000,
            height: 1000
        };
    }

    var slimDestroy = function() {
        workspacePhoto.destroy();
    }

    var initPlugin = function() {
        $('.m_selectpicker').selectpicker();
        $('.m-timepicker').timepicker();
    }

    return {
        // public functions
        init: function() {
            var workspacePhoto;
            slimInit();
            initPlugin();
            initLocalStorage();
            workspace();
            checkStepPass();
        }
    };
}();

jQuery(document).ready(function() {
    WorkspaceEdit.init();
});
