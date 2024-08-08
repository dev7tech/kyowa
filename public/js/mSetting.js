var ManageSetting = function() {
    var setting = function() {
        $settingForm = $('#setting_form');

        $settingFrotnendClientForm = $('#setting_frontend_client_form');

        $settingForm.on('submit', function(e) {
            e.preventDefault();
            var form = $(this);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            var url = form.attr('action');

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
                        swal({
                            title: "",
                            text: "Setting Update.",
                            type: "success",
                            confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"
                        });
                    }
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $settingFrotnendClientForm.on('submit', function(e) {
            e.preventDefault();
            var form = $(this);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            var url = form.attr('action');

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
                        swal({
                            title: "",
                            text: "Setting Update.",
                            type: "success",
                            confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"
                        });
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
        init: function() {
            setting();
        },
    };
}();
jQuery(document).ready(function(){
    ManageSetting.init();
});
