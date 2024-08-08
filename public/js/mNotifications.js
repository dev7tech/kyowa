function init_plugins(){
    $('.m_selectpicker').selectpicker();
}

var ManagePersonal = function() {
  var userManage = function() {

      init_plugins();

      var notificationsDatatable = $('#m_user_notifications_datatable');

      notificationsDatatable.mDatatable({
        // datasource definition
        data: {
          type: 'remote',
          source: {
  			read: {
  				url: '/admin/notifications/getAllNotifications',
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
        columns: [
          {
            field: 'notify_title',
            title: 'Notification Title',
            width: 150,
          }, {
            field: 'notify_body',
            title: 'Notification Body',
            width: 150,
          }, {
            field: 'username',
            title: 'User Name',
            width: 100,
         }, {
            field: 'created_at',
            title: 'Time',
            width: 150,
          }],
      });

      $("#new_notification_modal").on("shown.bs.modal", function() {
          $("#m_notify_user_select").select2({placeholder: "Select a User"});
      })

      var new_notify_form = $('#new_notification_form');

      var notifyFormValid = new_notify_form.validate({
          rules: {
              user_id: {
                  required: true,
              },
              notify_title: {
                  required: true
              },
              notify_body: {
                  required: true
              }
          },
          errorPlacement: function(error, element) {},
          invalidHandler: function(e, r) {
              swal({
                  title: "",
                  text: "Please Write correct Title and Body.",
                  type: "error",
                  confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"
              });
          }
      });

      new_notify_form.on('submit', function(e) {
          e.preventDefault();

          if (!notifyFormValid.form()) {
              return false;
          }

          var userIds = new_notify_form.find('#m_notify_user_select').val();

          if (userIds == "null") {
              swal({
                  "title": "Error",
                  "text": 'There is not user to send notification.',
                  "type": "error",
                  "confirmButtonClass": "btn btn-outline-accent m-btn m-btn--custom m-btn--square"
              });
              return false;
          }

          $.ajaxSetup({
              headers: {
                  'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
              }
          });

          var url = new_notify_form.attr( 'action' );

          var formData = new FormData(new_notify_form[0]);

          var submit_btn = new_notify_form.find('.submit-btn');
          submit_btn.addClass('m-loader m-loader--right m-loader--accent').attr('disabled', true);

          $.ajax({
              url: url,
              type: 'POST',
              data: formData,
              success: function (data) {
                  submit_btn.removeClass('m-loader m-loader--right m-loader--accent').attr('disabled', false);

                  if (data.result === "success") {
                      notificationsDatatable.reload();
                      new_notify_form[0].reset();
                      $('#new_notification_modal').modal('hide');
                      destroySlim();
                      initSlim();
                  }else {
                      swal({
                          "title": "Error",
                          "text": data.msg,
                          "type": "error",
                          "confirmButtonClass": "btn btn-outline-accent m-btn m-btn--custom m-btn--square"
                      });
                  }
              },
              processData: false,
              contentType: false,
              error: function(data)
             {
                 console.log(data);
             }
          });
      })
  };

  var initSlim = function() {
      notificationSlim = new Slim(document.getElementById('push_notification_image'), {
          ratio: '1:1',
          minSize: {
              width: 100,
              height: 100
          },
          download: false,
          label: 'Drop your image here or Click',
          statusImageTooSmall: 'Image too small. Min Size is $0 pixel. Try again.'
      });

      notificationSlim.size = {
          width: 500,
          height: 500
      };
  }

  var destroySlim = function() {
      notificationSlim.destroy();
  }

  return {
    // public functions
    init: function() {
        var notificationSlim;
        userManage();
        initSlim();
    },
  };
}();

jQuery(document).ready(function() {
  ManagePersonal.init();
});
