var ManageLocation = function() {
  var location = function() {

      var locationId = $('#location_id').val();
      var locationWorkspacesDatatable = $('#m_location_workspaces_datatable');
      var restWorkspacesDatatable = $('#m_location_rest_workspace_datatable');

      locationWorkspacesDatatable.mDatatable({
        // datasource definition
        data: {
          type: 'remote',
          source: {
  			read: {
  				url: '/admin/locations/getLocationWorkspacesData/'+locationId,
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
            responsive: {
                visible: "lg"
            },
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
                          <a class="dropdown-item location_workspace_hidden_btn" data-workspace_id="'+row.id+'" data-status="0" href="javascript:;">\
                          <span class="m--font-bold m--font-' + status[0].state + '">'+status[0].title+'</span></a>\
                          <a class="dropdown-item location_workspace_show_btn" data-workspace_id="'+row.id+'" data-status="1" href="javascript:;">\
                          <span class="m--font-bold m--font-' + status[1].state + '">'+status[1].title+'</span></a>\
                          </div>\
                          </div>\
                          ';
              }
          }],
      });

      restWorkspacesDatatable.mDatatable({
        // datasource definition
        data: {
          type: 'remote',
          source: {
  			read: {
  				url: '/admin/locations/getRestWorkspacesData/'+locationId,
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
				<input type="checkbox" class="new_workspace_ids" name="workspace_ids[]" value="'+row.id+'">\
				<span></span>\
				</label>\
                ';
            }
          }, {
              field: 'workspace_name',
              title: 'Listing Name',
              textAlign: 'center',
              width: 100,
          }],
      });

      $(document).on('click', '.location_workspace_hidden_btn', function() {
          var $this = $(this);
          var workspaceId = $this.data('workspace_id');
          $.ajax({
              url: '/admin/locations/workspace/update/hidden/'+locationId+"/"+workspaceId,
              type: 'get',
              success: function(response){
                  if (response.result == "success") {
                      locationWorkspacesDatatable.reload();
                  }
              },
              error: function(error){
                  console.log(error);
              }
          });
      });

      $(document).on('click', '.location_workspace_show_btn', function() {
          var $this = $(this);
          var workspaceId = $this.data('workspace_id');
          $.ajax({
              url: '/admin/locations/workspace/update/show/'+locationId+"/"+workspaceId,
              type: 'get',
              success: function(response){
                  if (response.result == "success") {
                      locationWorkspacesDatatable.reload();
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

      $('#assign_workspace_modal_open').on('click', function(){
          $('#assign_new_workspace_modal').modal('show');
          restWorkspacesDatatable.reload();
      });

      $('#assign_new_workspace_form').on('submit', function(e){
          e.preventDefault();

          var form = $(this);
          var submitable = false;
          form.find('input.new_workspace_ids').each(function() {
              if ($(this).is(':checked')) {
                  submitable = true;
              }
          });

          if (submitable ==  false) {
              swal({
                  title: "",
                  text: "Please check workspaces",
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
                      $('#assign_new_workspace_modal').modal('hide');
                      locationWorkspacesDatatable.reload();
                      restWorkspacesDatatable.reload();
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
