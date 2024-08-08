var PropertyBooking = function() {
  var booking = function() {
      var bookingsDatatable = $('#m_booking_ends_datatable');

      bookingsDatatable.mDatatable({
        // datasource definition
        data: {
          type: 'remote',
          source: {
  			read: {
  				url: '/admin/bookings/getEndBookingData',
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
            field: 'username',
            title: 'User Name',
            width: 100,
            template: function(row, index, datatable) {
                return '\
                <a data-user_id="'+row.user_id+'" class="view_user_detail_btn" href="javascript:;">'+row.username+'</a>\
                ';
            }
          }, {
            field: 'property_name',
            title: 'Property Name',
            width: 100,
          }, {
            field: 'property_address',
            title: 'Address',
            width: 200,
          }, {
            field: 'due_date',
            title: 'Date',
            width: 150,
          }, {
            field: 'price',
            title: 'Price',
            width: 80,
          }, {
            field: 'status',
            title: 'Status',
            width: 100,
            overflow: "visible",
            template: function (row, index, datatable) {
                if (row.status == 0) {
                    return '<span class="m--font-bold m--font-accent">Accepeted</span>';
                } else {
                    var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';

                    var status = {
                      0: {'title': 'Accept', 'state': 'accent'},
                      1: {'title': 'Pending', 'state': 'warning'},
                      2: {'title': 'Reject', 'state': 'danger'},
                    };

                    return '\
                            <span class="m--font-bold m--font-' + status[row.status].state + '"> \
                            '+status[row.status].title+' </span>\
                            ';
                }
            }
          }, {
              field: "Actions",
              width: 70,
              title: "Actions",
              sortable: false,
              overflow: 'visible',
              template: function (row, index, datatable) {
                  return '\
                      <a href="javascript:;" data-booking_id="'+row.id+'" class="view_booking_detail_btn m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                      <i class="la la-edit"></i>\
                      </a>\
                  ';
              }
          }],
      });

      $(document).on('click', '.booking_accept_btn', function(){
          var $this = $(this);
          var bookId = $this.data('booking_id');

          $.ajax({
              url: '/admin/bookings/confirm/'+bookId,
              type: 'get',
              success: function(response){
                  if (response.result === "success") {
                      bookingsDatatable.reload();
                  }
              },
              error: function(error){
                  console.log(error);
              }
          });
      });

      $(document).on('click', '.booking_reject_btn', function(){
          var $this = $(this);
          var bookId = $this.data('booking_id');

          $.ajax({
              url: '/admin/bookings/reject/'+bookId,
              type: 'get',
              success: function(response){
                  if (response.result === "success") {
                      bookingsDatatable.reload();
                  }
              },
              error: function(error){
                  console.log(error);
              }
          });
      });

      $(document).on('click', '.view_booking_detail_btn', function(){
          var $this = $(this);
          var bookId = $this.data('booking_id');

          $.ajax({
              url: '/admin/bookings/getSingleDetail/'+bookId,
              type: 'get',
              success: function(response){
                  if (response.result === "success") {
                      $('#booking_detail_view_modal div.modal-body').html(response.data);
                      $('#booking_detail_view_modal').modal('show');
                  }
              },
              error: function(error){
                  console.log(error);
              }
          });
      })

      $(document).on('click', '.view_user_detail_btn', function(){
          var $this = $(this);
          var userId = $this.data('user_id');

          $.ajax({
              url: '/admin/bookings/getUserDetail/'+userId,
              type: 'get',
              success: function(response){
                  if (response.result === "success") {
                      $('#user_detail_view_modal div.modal-body').html(response.data);
                      $('#user_detail_view_modal').modal('show');
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
      booking();
    },
  };
}();

jQuery(document).ready(function() {
  PropertyBooking.init();
});
