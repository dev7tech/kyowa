var displayContainer = $('#location_image_container');

function init_plugins(){
    // .selectpicker();
    $('.m_selectpicker').select2({
        placeholder: "Currency",
        allowClear: !0
    });
}

var renderDisplayTemplate = function(file){
    var single_img_container = '\
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-xs-12 single-img-container">\
        <input type="hidden" name="image_ids[]" value="'+file.imageId+'" />\
        <img class="img-responsive thumbnail" src="'+file.realThumbnailUrl+'">\
        <a class="lightgallery-preview-btn" href="'+file.imageUrl+'"><i class="la la-arrows-alt"></i></a>\
        <button type="button" class="lightgallery-delete-btn" href="javascript:void(0)"><i class="la la-trash"></i></button>\
        </div>';
    displayContainer.append(single_img_container);
    $('#location_image_container').data('lightGallery').destroy(true);
    lightgalleryInit();
}

function lightgalleryInit () {
    $('#location_image_container').lightGallery({
        thumbnail: false,
        selector: 'a'
    });
}

var ManageLocation = function() {
  var location = function() {
      init_plugins();
      lightgalleryInit();

      $('#fileupload').fileupload({
          disableImageResize: false,
          autoUpload: false,
          disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
          maxFileSize: 5000000,
          acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
      });

      var givenLat = $('#pac-input-latitude').val();
      givenLat = Number(givenLat);
      var givenLng = $('#pac-input-longitude').val();
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

      $(document).on('click', '.lightgallery-delete-btn', function(e) {
          var $this = $(this);
          var currentImageContainer = $this.parents('.single-img-container');
          currentImageContainer.remove();
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
          console.log(repo);
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
          initSelection: function(element, callback){
              var airpot_id = element.data('initial_id');
              var airportName = element.data('airport_name');
              var airportSymbol = element.data('airport_symbol');
              return callback({id: 1, airport_name: airportName, airport_symbol: airportSymbol });;
          }
      });

      $('.single-airbnb-img-container>.link_edit_and_delete_btn_container>a.edit-btn').on('click', function(e) {
          var $this = $(this);
          var airbnb_id = $this.data('airbnb_id');

          $.ajax({
              url: '/admin/locations/getSingleAirbnb/'+airbnb_id,
              type: 'get',
              success: function(response){
                  console.log(response);
                  if (response.result === "success") {
                      var image_content = '<img src="'+response.data.image_url+'" />';
                      edit_airbnb_image.destroy();
                      var edit_form = $('#location_airbnb_edit_form');
                      edit_form.find('#airbnb_id_edit').val(response.data.id);
                      edit_form.find('#edit_airbnb_image_select_slim').append(image_content);
                      edit_airbnb_image = new Slim(document.getElementById('edit_airbnb_image_select_slim'), {
                          minSize: {
                              width: 100,
                              height: 100
                          },
                          download: false,
                          label: 'Drop your image here or Click',
                          statusImageTooSmall: 'Image too small. Min Size is $0 pixel. Try again.'
                      });
                      edit_airbnb_image.size = {
                          width: 1000,
                          height: 1000
                      };
                      edit_form.find('#_location_airbnb_title').val(response.data.airbnb_title);
                      edit_form.find('#_location_airbnb_price').val(response.data.airbnb_price);
                      edit_form.find('#_location_airbnb_link').val(response.data.airbnb_link);
                      $('#location_airbnb_edit_modal').modal('show');
                  }
              },
              error: function(error){
                  console.log(error);
              }
          });
      });

      $('#location_airbnb_add_form').on('submit', function(e){
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
                      window.location.reload()
                  }
              },
              processData: false,
              contentType: false,
              error: function(error) {
                  console.log(error);
              }
          });
      });

      $('#location_airbnb_edit_form').on('submit', function(e){
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
                      window.location.reload()
                  }
              },
              processData: false,
              contentType: false,
              error: function(error) {
                  console.log(error);
              }
          });
      });

      $('.single-airbnb-img-container>.link_edit_and_delete_btn_container>a.delete-btn').on('click', function(e) {
          var $this = $(this);
          var airbnb_id = $this.data('airbnb_id');

          $.ajax({
              url: '/admin/locations/airbnb/delete/'+airbnb_id,
              type: 'get',
              success: function(response){
                  console.log(response);
                  if (response.result === "success") {
                      $('#single_airbnb_'+airbnb_id).remove();
                  }
              },
              error: function(error){
                  console.log(error);
              }
          });
      });
  };

  var airImageInit = function() {
      airbnb_image = new Slim(document.getElementById('airbnb_image_select_slim'), {
          minSize: {
              width: 100,
              height: 100
          },
          download: false,
          label: 'Drop your image here or Click',
          statusImageTooSmall: 'Image too small. Min Size is $0 pixel. Try again.'
      });

      airbnb_image.size = {
          width: 1000,
          height: 1000
      };

      edit_airbnb_image = new Slim(document.getElementById('edit_airbnb_image_select_slim'), {
          minSize: {
              width: 100,
              height: 100
          },
          download: false,
          label: 'Drop your image here or Click',
          statusImageTooSmall: 'Image too small. Min Size is $0 pixel. Try again.'
      });

      edit_airbnb_image.size = {
          width: 1000,
          height: 1000
      };
  }

  return {
    // public functions
    init: function() {
        var airbnb_image, edit_airbnb_image;
        location();
        airImageInit();
    },
  };
}();

jQuery(document).ready(function() {
  ManageLocation.init();
});
