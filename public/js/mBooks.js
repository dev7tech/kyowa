var PropertyBooking = function() {
  var booking = function() {
      var bookingsDatatable = $('#m_booking_datatable');

      bookingsDatatable.mDatatable({
        // datasource definition
        data: {
          type: 'remote',
          source: {
  			read: {
  				url: '/admin/bookings/getBookingData',
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

        rows: {
            afterTemplate: function (row, data, index) {
                initPlugin();
            }
        },

        // columns definition
        columns: [{
            field: 'username',
            title: 'User Name',
            width: 100,
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
                            <div class="dropdown ' + dropup + '">\
                            <a href="javascript:;" style="padding: 5px 10px;" class="btn m-btn--hover-brand" data-toggle="dropdown">\
                            <span class="m--font-bold m--font-' + status[row.status].state + '"> \
                            '+status[row.status].title+' </span>\
                            </a>\
                            <div class="dropdown-menu dropdown-menu-right">\
                            <a class="dropdown-item booking_accept_btn" data-booking_id="'+row.id+'" data-status="0" href="javascript:;">\
                            <span class="m--font-bold m--font-' + status[0].state + '">'+status[0].title+'</span></a>\
                            <a class="dropdown-item booking_reject_btn" data-booking_id="'+row.id+'" data-status="1" href="javascript:;">\
                            <span class="m--font-bold m--font-' + status[2].state + '">'+status[2].title+'</span></a>\
                            </div>\
                            </div>\
                            ';
                }
            }
          }, {
            field: 'expire',
            title: 'Expire After',
            width: 100,
            template: function(row, index, datatable) {
                if (row.status == 1) {
                    return '<div data-countdown="'+row.created_at+'"></div>';
                } else {
                    return '<div>Expired</div>';
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
                      <a href="javascript:;" data-booking_id="'+row.id+'" class="view_booking_detail_btn m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View Detail">\
                      <i class="la la-edit"></i>\
                      </a>\
                      <a href="javascript:;" data-booking_id="'+row.id+'" class="send_admin_remind_email_btn m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Send Remind Email">\
                      <i class="la la-bell"></i>\
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

      $(document).on('click', '.send_admin_remind_email_btn', function(){
          var $this = $(this);
          var bookId = $this.data('booking_id');

          $.ajax({
              url: '/admin/bookings/remindAdminEmail/'+bookId,
              type: 'get',
              success: function(response){
                  if (response.result == "success") {
                      swal({
                          "title": "Success",
                          "text": "Sent Email.",
                          "type": "success",
                          "confirmButtonClass": "btn m-btn--air m-btn btn-outline-accent m-btn--wide"
                      });
                  } else if (response.result == "error") {
                      swal({
                          "title": "Faild",
                          "text": "Something went wrong.",
                          "type": "error",
                          "confirmButtonClass": "btn m-btn--air m-btn btn-outline-accent m-btn--wide"
                      });
                  }
              },
              error: function(error){
                  console.log(error);
              }
          });
      })
  };

  var initPlugin = function() {
      $('[data-countdown]').each(function() {
          var $this = $(this);
          var expiredate = $(this).data('countdown');
          var finalDate = moment.tz(expiredate, "GMT").add(1, 'day');
          var currentDate = moment();

          if (finalDate > currentDate) {
              $this.countdown(finalDate.toDate(), function(event) {
                  $this.html(event.strftime('%H:%M:%S'))
              }).on('finish.countdown', function() {
                  alert("Expired");
              });
          } else {
              $this.html("Expired")
          }
      });
  }

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
