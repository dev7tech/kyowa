function init_plugins(){
    $('.m_selectpicker').selectpicker();
}

var ManagePersonal = function() {
  var adminManage = function() {

      init_plugins();

      var admin_add_form = $('#admin-add-form');
      var admin_edit_form = $('#admin-edit-form');

      var adminsDatatable = $('#m_admins_datatable');

      adminsDatatable.mDatatable({
        // datasource definition
        data: {
          type: 'remote',
          source: {
  			read: {
  				url: '/admin/admins/getAdminDatas',
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
            field: 'email',
            title: 'Email',
            width: 100,
          }, {
           field: 'level',
           title: 'Level',
           width: 150,
           template: function (row, index, datatable) {
               var levelText;

               if (row.role == 1) {
                   levelText = "Property Owner";
               } else if (row.role == 2) {
                   levelText = "Blog Poster";
               }
               return '\
                   <span>'+levelText+'</span>\
               ';
           }
         }, {
          field: 'approve',
          title: 'Approve',
          width: 100,
          template: function (row, index, datatable) {
              var statueText;

              if (row.approve == 1) {
                  statueText = "Approved";
              } else if (row.approve == 0) {
                  statueText = "Pending";
              } else if (row.approve == 2) {
                  statueText = "Rejected";
              }
              return '\
                  <span>'+statueText+'</span>\
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
                      <a href="javascript:;" data-admin_id="'+row.id+'" class="admin-edit_btn m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                      <i class="la la-edit"></i>\
                      </a>\
                      <a href="javascript:;" data-admin_id="'+row.id+'" class="admin-delete_btn m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete ">\
                      <i class="la la-trash"></i>\
                      </a>\
                  ';
              }
          }],
      });

      admin_add_form.validate({
          rules: {
              admin_first_name: {
                  required: true
              },
              admin_last_name: {
                  required: true
              },
              admin_email: {
                  required: true,
                  email: true
              },
              password: {
                  required: true,
                  minlength: 6
              }
          }
      });

      admin_edit_form.validate({
          rules: {
              _admin_first_name: {
                  required: true
              },
              _admin_last_name: {
                  required: true
              },
              _admin_email: {
                  required: true,
                  email: true
              },
              _password: {
                  minlength: 6
              },
          }
      });

      admin_add_form.on('submit', function(e) {
          e.preventDefault();
          if (!admin_add_form.valid()) {
              return false;
          }

          $.ajaxSetup({
              headers: {
                  'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
              }
          });

          var url = admin_add_form.attr( 'action' );

          var formData = new FormData(admin_add_form[0]);

          var submit_btn = admin_add_form.find('.form-submit-btn');
          submit_btn.addClass('m-loader m-loader--right m-loader--accent').attr('disabled', true);

          $.ajax({
              url: url,
              type: 'POST',
              data: formData,
              success: function (data) {
                  submit_btn.removeClass('m-loader m-loader--right m-loader--accent').attr('disabled', false);

                  if (data.result === "success") {
                      adminsDatatable.reload();
                      admin_add_form[0].reset();
                      $('#admin-add-modal').modal('hide');
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

      admin_edit_form.on('submit', function(e) {
          e.preventDefault();
          if (!admin_edit_form.valid()) {
              return false;
          }

          $.ajaxSetup({
              headers: {
                  'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
              }
          });

          var url = admin_edit_form.attr( 'action' );

          var formData = new FormData(admin_edit_form[0]);

          var submit_btn = admin_edit_form.find('.form-submit-btn');
          submit_btn.addClass('m-loader m-loader--right m-loader--accent').attr('disabled', true);

          $.ajax({
              url: url,
              type: 'POST',
              data: formData,
              success: function (data) {
                  submit_btn.removeClass('m-loader m-loader--right m-loader--accent').attr('disabled', false);

                  if (data.result === "success") {
                      adminsDatatable.reload();
                      admin_edit_form[0].reset();
                      $('#admin-edit-modal').modal('hide');
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

      $(document).on('click', '.admin-edit_btn', function() {
          var $this = $(this);
          var adminId = $this.data('admin_id');

          $.ajax({
              url: '/admin/admins/getSingleAdmin/'+adminId,
              type: 'get',
              success: function(response){
                  if (response.result === "success") {

                      admin_edit_form.find('#admin_id_for_edit').val(response.data.id);
                      admin_edit_form.find('#_admin_first_name').val(response.data.first_name);
                      admin_edit_form.find('#_admin_last_name').val(response.data.last_name);
                      admin_edit_form.find('#_admin_email').val(response.data.email);
                      admin_edit_form.find('#_facebook').val(response.data.facebook);
                      admin_edit_form.find('#_website').val(response.data.website);
                      admin_edit_form.find('#_password').val("");
                      admin_edit_form.find('#_admin_role').selectpicker('destroy');
                      admin_edit_form.find('#_admin_role').attr('value', response.data.role);
                      admin_edit_form.find('#_admin_role').val(response.data.role);
                      admin_edit_form.find('#_admin_role').selectpicker();

                      admin_edit_form.find('#_admin_approve').selectpicker('destroy');
                      admin_edit_form.find('#_admin_approve').attr('value', response.data.approve);
                      admin_edit_form.find('#_admin_approve').val(response.data.approve);
                      admin_edit_form.find('#_admin_approve').selectpicker();
                      admin_edit_form.find('#_description').val(response.data.description);
                      $('#admin-edit-modal').modal('show');
                  }
              },
              error: function(error){
                  console.log(error);
              }
          });
      });

      $(document).on('click', '.admin-delete_btn', function() {
          var $this = $(this);

          swal({
              title: 'Are you sure?',
              text: "Delete Admin !",
              type: 'warning',
              showCancelButton: true,
              confirmButtonText: ' Yes !',
              confirmButtonClass: "btn m-btn--air btn-outline-danger m-btn m-btn--wide",
              cancelButtonClass: "btn m-btn--air btn-outline-primary m-btn m-btn--wide",
          }).then(function(result) {
              if (result.value) {
                  var adminId = $this.data('admin_id');
                  $.ajax({
                      url: '/admin/admins/destroy/'+adminId,
                      type: 'get',
                      success: function(response){
                          if (response.result == "success") {
                              swal({
                                  "title": "Success",
                                  "text": "Admin Deleted !.",
                                  "type": "success",
                                  "confirmButtonClass": "btn m-btn--air m-btn btn-outline-accent m-btn--wide"
                              });
                              adminsDatatable.reload();
                          } else if (response.result == "error") {
                              swal({
                                  "title": "Faild",
                                  "text": "Can not find Admin !.",
                                  "type": "error",
                                  "confirmButtonClass": "bbtn m-btn--air btn-outline-accent m-btn m-btn--wide"
                              });
                          }
                      },
                      error: function(error){
                          console.log(error);
                      }
                  });
              }
          });
      })
  };

  return {
    // public functions
    init: function() {
      adminManage();
    },
  };
}();

jQuery(document).ready(function() {
  ManagePersonal.init();
});
