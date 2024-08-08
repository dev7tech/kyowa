var PropertyBooking = function() {
    var booking = function() {
      $(document).on('click', '.booking_accept_btn', function(){
          var $this = $(this);
          var bookId = $this.data('booking_id');

          $.ajax({
              url: '/admin/bookings/confirm/'+bookId,
              type: 'get',
              success: function(response){
                  if (response.result === "success") {
                      $('#booking_id_'+bookId).remove();
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

          $('#booking_reject_reason_form').find('input[name=booking_id]').val(bookId);

          $('#booking_reject_reason_modal').modal('show');
      });

      var rejectForm = $('#booking_reject_reason_form');

      var rejectFormValid = rejectForm.validate({
          ignore: ":hidden",
          rules: {
              booking_reject_reason: {
                  required: true
              },
          },
          messages: {},
          errorPlacement: function(error, element) {},
          invalidHandler: function(e, r) {}
      });

      rejectForm.on('submit', function(e) {
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
                      $('#booking_id_'+bookId).remove();
                      $('#booking_reject_reason_modal').modal('hide');
                  }
              },
              processData: false,
              contentType: false,
              error: function(error) {
                  console.log(error);
              }
          });
      })

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
        initPlugin();
    },
  };
}();

jQuery(document).ready(function() {
  PropertyBooking.init();
});
