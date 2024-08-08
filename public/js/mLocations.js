var ManageLocation = function() {
    var location = function() {
        var locationsDatatable = $('#m_locations_datatable');

        locationsDatatable.mDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/admin/locations/getLocationDatas',
                        method: 'GET'
                    }
                },
                pageSize: 5
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
                        pageSizeSelect: [
                            5,
                            10,
                            20,
                            30,
                            50,
                            100
                        ]
                    }
                }
            },

            search: {
                input: $('#generalSearch')
            },

            // columns definition
            columns: [
                {
                    field: 'name',
                    title: 'Name',
                    width: 100
                }, {
                    field: 'address',
                    title: 'Address',
                    width: 300
                }, {
                    field: "hidden",
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
                        <a class="dropdown-item location_hidden_btn" data-location_id="' + row.id + '" data-status="0" href="javascript:;">\
                        <span class="m--font-bold m--font-' + status[0].state + '">' + status[0].title + '</span></a>\
                        <a class="dropdown-item location_show_btn" data-location_id="' + row.id + '" data-status="1" href="javascript:;">\
                        <span class="m--font-bold m--font-' + status[1].state + '">' + status[1].title + '</span></a>\
                        </div>\
                        </div>\
                        ';
                    }
                }, {
                    field: 'position',
                    title: 'Position',
                    width: 100,
                    textAlign: 'center',
                    overflow: 'visible',
                    template: function(row, index, datatable) {
                        return '\
                            <a href="javascript:;" data-location_id="' + row.id + '" class="change_location_position_btn m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon" title="Position">\
                            <span>' + row.position + '</span>\
                            </a>\
                        ';
                    }
                }, {
                    field: "Actions",
                    width: 150,
                    title: "Actions",
                    sortable: false,
                    overflow: 'visible',
                    template: function(row, index, datatable) {
                        var dropup = (datatable.getPageSize() - index) <= 4
                            ? 'dropup'
                            : '';

                        return '\
                      <a href="' + domain_url + '/locations/update/' + row.id + '" class="location-edit_btn m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                      <i class="la la-edit"></i>\
                      </a>\
                      <a href="javascript:;" data-location_id="' + row.id + '" class="location-delete_btn m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete ">\
                      <i class="la la-trash"></i>\
                      </a>\
                      <a href="' + domain_url + '/locations/update/property/' + row.id + '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                      <i class="flaticon-list-3"></i>\
                      </a>\
                      <a href="' + domain_url + '/locations/update/workspace/' + row.id + '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                      <i class="flaticon-imac"></i>\
                      </a>\
                  ';
                    }
                }
            ]
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
                cancelButtonClass: "btn m-btn--air btn-outline-primary m-btn m-btn--wide"
            }).then(function(result) {
                if (result.value) {
                    var locationId = $this.data('location_id');
                    $.ajax({
                        url: '/admin/locations/destroy/' + locationId,
                        type: 'get',
                        success: function(response) {
                            if (response.result == "success") {
                                swal({"title": "Success", "text": "Location Deleted !.", "type": "success", "confirmButtonClass": "btn m-btn--air m-btn btn-outline-accent m-btn--wide"});
                                locationsDatatable.reload();
                            } else if (response.result == "error") {
                                swal({"title": "Faild", "text": "Can not find Location !.", "type": "error", "confirmButtonClass": "btn m-btn--air m-btn btn-outline-accent m-btn--wide"});
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        });

        $(document).on('click', '.location_hidden_btn', function() {
            var $this = $(this);
            var locationId = $this.data('location_id');
            $.ajax({
                url: '/admin/locations/hidden/' + locationId,
                type: 'get',
                success: function(response) {
                    if (response.result == "success") {
                        locationsDatatable.reload();
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $(document).on('click', '.location_show_btn', function() {
            var $this = $(this);
            var locationId = $this.data('location_id');
            $.ajax({
                url: '/admin/locations/unhidden/' + locationId,
                type: 'get',
                success: function(response) {
                    if (response.result == "success") {
                        locationsDatatable.reload();
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $(document).on('click', '.change_location_position_btn', function(){
            var $this = $(this);
            var locationId = $this.data('location_id');

            $.ajax({
                url: '/admin/locations/getSinglePosition/'+locationId,
                type: 'get',
                success: function(response){
                    if (response.result == "success") {
                        $('#change_locaion_position_form #locaion_id').val(locationId);
                        $('#change_locaion_position_form #locaion_position_item_container').html(response.html);

                        $('#change_location_position_modal').modal('show');
                    }
                },
                error: function(error){
                    console.log(error);
                }
            });
        });

        $('#change_locaion_position_form').on('submit', function(e) {
            e.preventDefault();

            var from = $(this);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            var url = from.attr( 'action' );

            var formData = new FormData(from[0]);

            var submit_btn = from.find('.form-submit-btn');
            submit_btn.addClass('m-loader m-loader--right m-loader--accent').attr('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function (response) {
                    submit_btn.removeClass('m-loader m-loader--right m-loader--accent').attr('disabled', false);
                    if (response.result === "success") {
                        locationsDatatable.reload();
                        $('#change_location_position_modal').modal('hide');
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

    return {
        // public functions
        init: function() {
            location();
        }
    };
}();

jQuery(document).ready(function() {
    ManageLocation.init();
});
