function init_plugins(){
    $('.m_selectpicker').selectpicker();
}

var ManagePersonal = function() {
  var userManage = function() {

      init_plugins();

      var user_add_form = $('#user-add-form');
      var user_edit_form = $('#user-edit-form');

      var usersDatatable = $('#m_users_datatable');

      usersDatatable.mDatatable({
        // datasource definition
        data: {
          type: 'remote',
          source: {
  			read: {
  				url: '/admin/users/getUserDatas',
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
            field: "id",
            title: "ID",
            width: 30,
            sortable: false,
            textAlign: 'center',
            selector: {class: 'm-checkbox--solid m-checkbox--admin'}
          }, {
            field: 'first_name',
            title: 'First Name',
            width: 100,
          }, {
            field: 'last_name',
            title: 'Last Name',
            width: 100,
          }, {
            field: 'username',
            title: 'Username',
            width: 100,
          }, {
            field: 'email',
            title: 'Email',
            width: 100,
          }, {
            field: 'currency',
            title: 'Currency',
            width: 100,
          }, {
            field: 'featured',
            title: 'Featured',
            width: 100,
            overflow: 'visible',
            sortable: false,
            textAlign: 'center',
            template: function (row, index, datatable) {
                var isCheck = "";
                if (row.featured == 1) {
                    isCheck = "checked";
                }

                return '\
                <label class="m-checkbox m-checkbox--solid m-checkbox--success">\
                <input type="checkbox" data-user_id="'+row.id+'" '+isCheck+' class="featured-user-select-checkbox">\
                <span></span>\
                </label>\
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
                      <a href="javascript:;" data-user_id="'+row.id+'" class="user-edit_btn m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Delete ">\
                      <i class="la la-edit"></i>\
                      </a>\
                      <a href="javascript:;" data-user_id="'+row.id+'" class="user-delete_btn m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete ">\
                      <i class="la la-trash"></i>\
                      </a>\
                  ';
              }
          }],
      });

      user_add_form.validate({
          rules: {
              first_name: {
                  required: true
              },
              last_name: {
                  required: true
              },
              uniquename: {
                  required: true
              },
              user_email: {
                  required: true,
                  email: true
              },
              real_password: {
                  required: true,
                  minlength: 6
              }
          }
      });

      user_edit_form.validate({
          rules: {
              _first_name: {
                  required: true
              },
              _last_name: {
                  required: true
              },
              _uniquename: {
                  required: true
              },
              _admin_email: {
                  required: true,
                  email: true
              },
              _real_password: {
                  minlength: 6
              },
          }
      });

      user_add_form.on('submit', function(e) {
          e.preventDefault();

          if (!user_add_form.valid()) {
              return false;
          }

          $.ajaxSetup({
              headers: {
                  'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
              }
          });

          var url = user_add_form.attr( 'action' );

          var formData = new FormData(user_add_form[0]);

          var submit_btn = user_add_form.find('.form-submit-btn');
          submit_btn.addClass('m-loader m-loader--right m-loader--accent').attr('disabled', true);

          $.ajax({
              url: url,
              type: 'POST',
              data: formData,
              success: function (data) {
                  submit_btn.removeClass('m-loader m-loader--right m-loader--accent').attr('disabled', false);

                  if (data.result === "success") {
                      usersDatatable.reload();
                      user_add_form[0].reset();
                      $('#user-add-modal').modal('hide');
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

      user_edit_form.on('submit', function(e) {
          e.preventDefault();

          if (!user_edit_form.valid()) {
              return false;
          }

          $.ajaxSetup({
              headers: {
                  'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
              }
          });

          var url = user_edit_form.attr( 'action' );

          var formData = new FormData(user_edit_form[0]);

          var submit_btn = user_edit_form.find('.form-submit-btn');
          submit_btn.addClass('m-loader m-loader--right m-loader--accent').attr('disabled', true);

          $.ajax({
              url: url,
              type: 'POST',
              data: formData,
              success: function (data) {
                  submit_btn.removeClass('m-loader m-loader--right m-loader--accent').attr('disabled', false);

                  if (data.result === "success") {
                      usersDatatable.reload();
                      user_edit_form[0].reset();
                      $('#user-edit-modal').modal('hide');
                      swal({
                          "title": "Success",
                          "text": data.msg,
                          "type": "success",
                          "confirmButtonClass": "btn btn-outline-accent m-btn m-btn--custom m-btn--square"
                      });
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

      $(document).on('click', '.user-edit_btn', function() {
          console.log("edit user");
          var $this = $(this);
          var userId = $this.data('user_id');

          $.ajax({
              url: '/admin/users/getSingleUser/'+userId,
              type: 'get',
              success: function(response){
                  if (response.result === "success") {
                      user_edit_form.find('#user_id_for_edit').val(response.data.id);
                      user_edit_form.find('#_first_name').val(response.data.first_name);
                      user_edit_form.find('#_last_name').val(response.data.last_name);
                      user_edit_form.find('#_uniquename').val(response.data.username);
                      user_edit_form.find('#_user_email').val(response.data.email);
                      user_edit_form.find('#_currency').selectpicker('destroy');
                      user_edit_form.find('#_currency').val(response.data.currency);
                      user_edit_form.find('#_currency').selectpicker();
                      user_edit_form.find('#_real_password').val("");
                      $('#user-edit-modal').modal('show');
                  }
              },
              error: function(error){
                  console.log(error);
              }
          });
      })

      $(document).on('click', '.user-delete_btn', function() {
          var $this = $(this);

          swal({
              title: 'Are you sure?',
              text: "Delete User !",
              type: 'warning',
              showCancelButton: true,
              confirmButtonText: ' Yes !',
              confirmButtonClass: "btn m-btn--air btn-outline-danger m-btn m-btn--wide",
              cancelButtonClass: "btn m-btn--air btn-outline-primary m-btn m-btn--wide",
          }).then(function(result) {
              if (result.value) {
                  var userId = $this.data('user_id');
                  $.ajax({
                      url: '/admin/users/destroy/'+userId,
                      type: 'get',
                      success: function(response){
                          if (response.result == "success") {
                              swal({
                                  "title": "Success",
                                  "text": "User Deleted !.",
                                  "type": "success",
                                  "confirmButtonClass": "btn m-btn--air m-btn btn-outline-accent m-btn--wide"
                              });
                              usersDatatable.reload();
                          } else if (response.result == "error") {
                              swal({
                                  "title": "Faild",
                                  "text": "Can not find User !.",
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

      $(document).on('click', '.featured-user-select-checkbox', function(e) {
          // e.preventDefault();
          var $this = $(this);
          var status = 0;
          if ($this.is(':checked')) {
              status = 1;
          }
          var userId = $this.data('user_id');

          $.ajax({
              url: '/admin/users/featured/'+userId+'/'+status,
              type: 'get',
              success: function(response){
                  if (response.result == "success") {
                      usersDatatable.reload();
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
      userManage();
    },
  };
}();

jQuery(document).ready(function() {
  ManagePersonal.init();
});
