var ManageProperty = function() {
  var property = function() {
      var supportDatatable = $('#m_support_datatable');

      supportDatatable.mDatatable({
        // datasource definition
        data: {
          type: 'remote',
          source: {
  			read: {
  				url: '/admin/support/getAllSupports',
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
            field: 'subject',
            title: 'Subject',
            width: 150,
          }, {
            field: 'message',
            title: 'Message',
            width: 300,
            responsive: {visible: 'lg'},
          }, {
            field: 'created_at',
            title: 'Sent Time',
            width: 150,
          }, {
              field: "Actions",
              width: 70,
              title: "Actions",
              sortable: false,
              overflow: 'visible',
              template: function (row, index, datatable) {
                  var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';

                  return '\
                      <a href="javascript:;" data-support_id="'+row.id+'" class="view_support_detail_btn m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                      <i class="la la-edit"></i>\
                      </a>\
                  ';
              }
          }],
      });

      var newSupportForm = $('#new_support_email_form');

      var newSupportFormValid = newSupportForm.validate({
          ignore: ":hidden",
          rules: {
              support_subject: {
                  required: true
              },
              support_message: {
                  required: true
              },
          },
          errorPlacement: function(error, element) {},
          invalidHandler: function(e, r) {
              swal({title: "", text: "Please fill all field.", type: "error", confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"})
          }
      });

      newSupportForm.on('submit', function(e) {
          e.preventDefault();

          if (!newSupportFormValid.form()) {
              return false;
          }

          $.ajaxSetup({
              headers: {
                  'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
              }
          });

          var url = newSupportForm.attr('action');

          var formData = new FormData(newSupportForm[0]);
          var submit_btn = newSupportForm.find('.form-submit-btn');
          submit_btn.addClass('m-loader m-loader--right m-loader--accent').attr('disabled', true);
          $.ajax({
              url: url,
              type: 'POST',
              data: formData,
              success: function(response) {
                  submit_btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                  if (response.result === "success") {
                      supportDatatable.reload();
                      $('#new_support_email_modal').modal('hide');
                  }
              },
              processData: false,
              contentType: false,
              error: function(error) {
                  console.log(error);
              }
          });
      });

      $(document).on('click', '.view_support_detail_btn', function(e) {
          e.preventDefault();

          var supportId = $(this).data('support_id');

          $.ajax({
              url: '/admin/support/getSingleSupport/'+supportId,
              type: 'get',
              success: function(response){
                  if (response.result === "success") {
                      $('#view_support_email_form #_support_subject').val(response.support.subject);
                      $('#view_support_email_form #_support_message').val(response.support.message);
                      $('#view_support_email_modal').modal('show');
                  }
              },
              error: function(error){
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
