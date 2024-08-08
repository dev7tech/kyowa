var ManageLocation = function() {
  var location = function() {

      var locationId = $('#location_id').val();
      var locationPropertiesDatatable = $('#m_location_properties_datatable');
      var restPropertiesDatatable = $('#m_location_rest_property_datatable');

      locationPropertiesDatatable.mDatatable({
        // datasource definition
        data: {
          type: 'remote',
          source: {
  			read: {
  				url: '/admin/locations/getLocationPropertiesData/'+locationId,
                  method: 'GET',
  			},
  		},
          pageSize: 5,
        },

        // column sorting
        sortable: true,

        pagination: true,

        toolbar: {
          // toolbar items
          items: {
            // pagination
            pagination: {
              // page size select
              pageSizeSelect: [5, 10, 20, 30, 50, 100],
            },
          },
        },

        search: {
          input: $('#generalSearch'),
        },

        // columns definition
        columns: [{
            field: 'property_name',
            title: 'Listing Name',
            width: 150,
          }, {
            field: 'property_address',
            title: 'Address',
            width: 300,
            responsive: {
                visible: "lg"
            },
          }, {
            field: 'owner_name',
            title: 'Owner',
            width: 100,
          }, {
            field: 'property_approved',
            title: 'Status',
            width: 100,
            overflow: "visible",
            template: function (row, index, datatable) {
                var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';

                var status = {
                  0: {'title': 'Pending', 'state': 'danger'},
                  1: {'title': 'Approved', 'state': 'accent'},
                };

                return '\
                        <div class="dropdown ' + dropup + '">\
                        <a href="javascript:;" style="padding: 5px 10px;" class="btn m-btn--hover-metal" data-toggle="dropdown">\
                        <span class="m--font-bold m--font-' + status[row.property_approved].state + '"> \
                        '+status[row.property_approved].title+' </span>\
                        </a>\
                        <div class="dropdown-menu dropdown-menu-right">\
                        <a class="dropdown-item property-status-change-btn" data-property_id="'+row.id+'" data-status="0" href="javascript:;">\
                        <span class="m--font-bold m--font-' + status[0].state + '">'+status[0].title+'</span></a>\
                        <a class="dropdown-item property-status-change-btn" data-property_id="'+row.id+'" data-status="1" href="javascript:;">\
                        <span class="m--font-bold m--font-' + status[1].state + '">'+status[1].title+'</span></a>\
                        </div>\
                        </div>\
                        ';
            }
          }, {
              field: "Actions",
              width: 100,
              title: "Show / Hidden",
              sortable: false,
              overflow: 'visible',
              template: function (row, index, datatable) {
                  var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';

                  var status = {
                    0: {'title': 'Hidden', 'state': 'danger'},
                    1: {'title': 'Show', 'state': 'accent'},
                  };

                  return '\
                          <div class="dropdown ' + dropup + '">\
                          <a href="javascript:;" style="padding: 5px 10px;" class="btn m-btn--hover-metal" data-toggle="dropdown">\
                          <span class="m--font-bold m--font-' + status[row.show].state + '"> \
                          '+status[row.show].title+' </span>\
                          </a>\
                          <div class="dropdown-menu dropdown-menu-right">\
                          <a class="dropdown-item location_property_hidden_btn" data-property_id="'+row.id+'" data-status="0" href="javascript:;">\
                          <span class="m--font-bold m--font-' + status[0].state + '">'+status[0].title+'</span></a>\
                          <a class="dropdown-item location_property_show_btn" data-property_id="'+row.id+'" data-status="1" href="javascript:;">\
                          <span class="m--font-bold m--font-' + status[1].state + '">'+status[1].title+'</span></a>\
                          </div>\
                          </div>\
                          ';
              }
          }],
      });

      restPropertiesDatatable.mDatatable({
        // datasource definition
        data: {
          type: 'remote',
          source: {
  			read: {
  				url: '/admin/locations/getRestPropertiesData/'+locationId,
                  method: 'GET',
  			},
  		},
          pageSize: 5,
        },

        // column sorting
        sortable: true,

        pagination: true,

        toolbar: {
          // toolbar items
          items: {
            // pagination
            pagination: {
              // page size select
              pageSizeSelect: [5, 10, 20, 30, 50, 100],
            },
          },
        },

        search: {
          input: $('#generalSearch'),
        },

        // columns definition
        columns: [{
            field: "id",
            title: "ID",
            width: 30,
            sortable: false,
            overflow: 'visible',
            textAlign: 'center',
            template: function (row, index, datatable) {
                return '\
                <label class="m-checkbox m-checkbox--solid m-checkbox--brand">\
				<input type="checkbox" class="new_property_ids" name="property_ids[]" value="'+row.id+'">\
				<span></span>\
				</label>\
                ';
            }
          }, {
              field: 'property_name',
              title: 'Listing Name',
              textAlign: 'center',
              width: 100,
          }, {
            field: 'owner_name',
            title: 'Owner',
            textAlign: 'center',
            width: 100,
          }],
      });

      $(document).on('click', '.location-delete_btn', function() {
          var $this = $(this);

          swal({
              title: 'Are you sure?',
              text: "Delete Location !",
              type: 'warning',
              showCancelButton: true,
              confirmButtonText: ' Yes !',
              confirmButtonClass: "btn m-btn--air btn-outline-danger m-btn m-btn--wide",
              cancelButtonClass: "btn m-btn--air btn-outline-primary m-btn m-btn--wide",
          }).then(function(result) {
              if (result.value) {
                  var locationId = $this.data('location_id');
                  $.ajax({
                      url: '/locations/destroy/'+locationId,
                      type: 'get',
                      success: function(response){
                          if (response.result == "success") {
                              swal({
                                  "title": "Success",
                                  "text": "Location Deleted !.",
                                  "type": "success",
                                  "confirmButtonClass": "btn m-btn--air m-btn btn-outline-accent m-btn--wide"
                              });
                              locationPropertiesDatatable.reload();
                          } else if (response.result == "error") {
                              swal({
                                  "title": "Faild",
                                  "text": "Can not find Location !.",
                                  "type": "error",
                                  "confirmButtonClass": "btn m-btn--air m-btn btn-outline-accent m-btn--wide"
                              });
                          }
                      },
                      error: function(error){
                          console.log(error);
                      }
                  });
              }
          });
      });

      $(document).on('click', '.location_property_hidden_btn', function() {
          var $this = $(this);
          var propertyId = $this.data('property_id');
          $.ajax({
              url: '/admin/locations/property/update/hidden/'+locationId+"/"+propertyId,
              type: 'get',
              success: function(response){
                  if (response.result == "success") {
                      locationPropertiesDatatable.reload();
                  }
              },
              error: function(error){
                  console.log(error);
              }
          });
      });

      $(document).on('click', '.location_property_show_btn', function() {
          var $this = $(this);
          var propertyId = $this.data('property_id');
          $.ajax({
              url: '/admin/locations/property/update/show/'+locationId+"/"+propertyId,
              type: 'get',
              success: function(response){
                  if (response.result == "success") {
                      locationPropertiesDatatable.reload();
                  }
              },
              error: function(error){
                  console.log(error);
              }
          });
      });

      $(document).on('click', '.property-status-change-btn', function(){
          var $this = $(this);
          var property_id = $this.data('property_id');
          var property_status = $this.data('status');
          $.ajax({
              url: '/admin/properties/update/status/'+property_id+'/'+property_status,
              type: 'get',
              success: function(response){
                  if (response.result == "success") {
                      locationPropertiesDatatable.reload();
                  }
              },
              error: function(error){
                  console.log(error);
              }
          });
      });

      $('#assign_property_modal_open').on('click', function(){
          $('#assign_new_property_modal').modal('show');
          restPropertiesDatatable.reload();
      });

      $('#assign_new_property_form').on('submit', function(e){
          e.preventDefault();

          var form = $(this);
          var submitable = false;
          form.find('input.new_property_ids').each(function() {
              if ($(this).is(':checked')) {
                  submitable = true;
              }
          });

          if (submitable ==  false) {
              swal({
                  title: "",
                  text: "Please check properties",
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

          var url = form.attr('action');

          var formData = new FormData(form[0]);
          var submit_btn = form.find('.submit-btn');
          submit_btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

          $.ajax({
              url: url,
              type: 'POST',
              data: formData,
              success: function(response) {
                  submit_btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                  if (response.result === "success") {
                      $('#assign_new_property_modal').modal('hide');
                      locationPropertiesDatatable.reload();
                      restPropertiesDatatable.reload();
                  }
              },
              processData: false,
              contentType: false,
              error: function(error) {
                  console.log(error);
              }
          });
      });
  };

  return {
    // public functions
    init: function() {
      location();
    },
  };
}();

jQuery(document).ready(function() {
  ManageLocation.init();
});
