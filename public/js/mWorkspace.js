var ManageWorkspace = function() {
  var workspace = function() {
      var workspaceDatatable = $('#m_workspace_datatable');

      workspaceDatatable.mDatatable({
        // datasource definition
        data: {
          type: 'remote',
          source: {
  			read: {
  				url: '/admin/workspace/getWorkspaceData',
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
            field: 'workspace_name',
            title: 'Listing Name',
            width: 150,
          }, {
            field: 'workspace_address',
            title: 'Address',
            width: 300,
          }, {
              field: "is_show",
              width: 100,
              title: "Show / Hidden",
              sortable: false,
              overflow: 'visible',
              template: function(row, index, datatable) {
                  var dropup = (datatable.getPageSize() - index) <= 4
                      ? 'dropup'
                      : '';

                  var status = {
                      0: {
                          'title': 'Hidden',
                          'state': 'danger'
                      },
                      1: {
                          'title': 'Show',
                          'state': 'accent'
                      }
                  };

                  return '\
                  <div class="dropdown ' + dropup + '">\
                  <a href="javascript:;" style="padding: 5px 10px;" class="btn m-btn--hover-metal" data-toggle="dropdown">\
                  <span class="m--font-bold m--font-' + status[row.is_show].state + '"> \
                  ' + status[row.is_show].title + ' </span>\
                  </a>\
                  <div class="dropdown-menu dropdown-menu-right">\
                  <a class="dropdown-item workspace_hidden_btn" data-workspace_id="' + row.id + '" data-status="0" href="javascript:;">\
                  <span class="m--font-bold m--font-' + status[0].state + '">' + status[0].title + '</span></a>\
                  <a class="dropdown-item workspace_show_btn" data-workspace_id="' + row.id + '" data-status="1" href="javascript:;">\
                  <span class="m--font-bold m--font-' + status[1].state + '">' + status[1].title + '</span></a>\
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

                  return '\
                      <a href="'+domain_url+'/workspace/update/'+row.id+'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                      <i class="la la-edit"></i>\
                      </a>\
                      <a href="javascript:;" data-workspace_id="'+row.id+'" class="workspace_delete_btn m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete ">\
                      <i class="la la-trash"></i>\
                      </a>\
                  ';
              }
          }],
      });

      $(document).on('click', '.workspace_hidden_btn', function() {
          var $this = $(this);
          var workspaceId = $this.data('workspace_id');
          $.ajax({
              url: '/admin/workspace/hidden/' + workspaceId,
              type: 'get',
              success: function(response) {
                  if (response.result == "success") {
                      workspaceDatatable.reload();
                  }
              },
              error: function(error) {
                  console.log(error);
              }
          });
      });

      $(document).on('click', '.workspace_show_btn', function() {
          var $this = $(this);
          var workspaceId = $this.data('workspace_id');
          $.ajax({
              url: '/admin/workspace/unhidden/' + workspaceId,
              type: 'get',
              success: function(response) {
                  if (response.result == "success") {
                      workspaceDatatable.reload();
                  }
              },
              error: function(error) {
                  console.log(error);
              }
          });
      });

      $(document).on('click', '.workspace_delete_btn', function() {
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
                  var workspaceId = $this.data('workspace_id');
                  $.ajax({
                      url: '/admin/workspace/destroy/'+workspaceId,
                      type: 'get',
                      success: function(response){
                          if (response.result == "success") {
                              swal({
                                  "title": "Success",
                                  "text": "Working Space Deleted !.",
                                  "type": "success",
                                  "confirmButtonClass": "btn m-btn--air m-btn btn-outline-accent m-btn--wide"
                              });
                              workspaceDatatable.reload();
                          } else if (response.result == "error") {
                              swal({
                                  "title": "Faild",
                                  "text": "Can not find Working Space !.",
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
  };

  return {
    // public functions
    init: function() {
      workspace();
    },
  };
}();

jQuery(document).ready(function() {
  ManageWorkspace.init();
});
