var ManageProperty = function() {
  var property = function() {
      var propertiesDatatable = $('#m_property_datatable');

      propertiesDatatable.mDatatable({
        // datasource definition
        data: {
          type: 'remote',
          source: {
  			read: {
  				url: '/admin/properties/getPropertyDatas',
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
                  0: {'title': 'Pending', 'state': 'warning'},
                  1: {'title': 'Approved', 'state': 'accent'},
                  2: {'title': 'Reject', 'state': 'danger'},
                };

                return '\
                        <div class="dropdown ' + dropup + '">\
                        <a href="javascript:;" style="padding: 5px 10px;" class="btn m-btn--hover-metal" data-toggle="dropdown">\
                        <span class="m--font-bold m--font-' + status[row.property_approved].state + '"> \
                        '+status[row.property_approved].title+' </span>\
                        </a>\
                        <div class="dropdown-menu dropdown-menu-right">\
                        <a class="dropdown-item property_status_reject_btn" data-property_id="'+row.id+'" data-status="2" href="javascript:;">\
                        <span class="m--font-bold m--font-' + status[2].state + '">'+status[2].title+'</span></a>\
                        <a class="dropdown-item property_status_accept_btn" data-property_id="'+row.id+'" data-status="1" href="javascript:;">\
                        <span class="m--font-bold m--font-' + status[1].state + '">'+status[1].title+'</span></a>\
                        </div>\
                        </div>\
                        ';
            }
          }, {
              field: "Actions",
              width: 70,
              title: "Actions",
              sortable: false,
              overflow: 'visible',
              template: function (row, index, datatable) {
                  var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';

                  return '\
                      <a href="'+domain_url+'/properties/update/'+row.id+'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                      <i class="la la-edit"></i>\
                      </a>\
                      <a href="javascript:;" data-property_id="'+row.id+'" class="property-delete_btn m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete ">\
                      <i class="la la-trash"></i>\
                      </a>\
                  ';
              }
          }],
      });

      $(document).on('click', '.property-delete_btn', function() {
          var $this = $(this);

          swal({
              title: 'Are you sure?',
              text: "Delete Listing !",
              type: 'warning',
              showCancelButton: true,
              confirmButtonText: ' Yes !',
              confirmButtonClass: "btn m-btn--air btn-outline-danger m-btn m-btn--wide",
              cancelButtonClass: "btn m-btn--air btn-outline-primary m-btn m-btn--wide",
          }).then(function(result) {
              if (result.value) {
                  var propertyId = $this.data('property_id');
                  $.ajax({
                      url: '/admin/properties/destroy/'+propertyId,
                      type: 'get',
                      success: function(response){
                          if (response.result == "success") {
                              swal({
                                  "title": "Success",
                                  "text": "Property Deleted !.",
                                  "type": "success",
                                  "confirmButtonClass": "btn m-btn--air m-btn btn-outline-accent m-btn--wide"
                              });
                              propertiesDatatable.reload();
                          } else if (response.result == "error") {
                              swal({
                                  "title": "Faild",
                                  "text": "Can not find Property !.",
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

      $(document).on('click', '.property_status_accept_btn', function(){
          var $this = $(this);
          var property_id = $this.data('property_id');
          var property_status = $this.data('status');
          $.ajax({
              url: '/admin/properties/update/status/'+property_id+'/'+property_status,
              type: 'get',
              success: function(response){
                  if (response.result == "success") {
                      propertiesDatatable.reload();
                  }
              },
              error: function(error){
                  console.log(error);
              }
          });
      });

      $(document).on('click', '.property_status_reject_btn', function(){
          var $this = $(this);
          var property_id = $this.data('property_id');

          $('#property_reject_reason_form').find('input[name=property_id]').val(property_id);

          $('#property_reject_reason_modal').modal('show');
      });

      var rejectForm = $('#property_reject_reason_form');

      var rejectFormValid = rejectForm.validate({
          ignore: ":hidden",
          rules: {
              property_reject_reason: {
                  required: true
              },
          },
          messages: {},
          errorPlacement: function(error, element) {},
          invalidHandler: function(e, r) {}
      });

      $('#property_reject_reason_form').on('submit', function(e) {
          e.preventDefault();

          if (!rejectFormValid.form()) {
              swal({title: "", text: "Please Write Reason.", type: "error", confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"})
              return false;
          }

          var form = $(this);

          $.ajaxSetup({
              headers: {
                  'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
              }
          });

          var url = form.attr('action');

          var bookId = form.find('input[name=booking_id]').val();

          var formData = new FormData(form[0]);
          var submit_btn = form.find('.form-submit-btn');
          submit_btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

          $.ajax({
              url: url,
              type: 'POST',
              data: formData,
              success: function(response) {
                  submit_btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                  if (response.result === "success") {
                      propertiesDatatable.reload();
                      $('#property_reject_reason_modal').modal('hide');
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
  };

  return {
    // public functions
    init: function() {
      property();
    },
  };
}();

jQuery(document).ready(function() {
  ManageProperty.init();
});
