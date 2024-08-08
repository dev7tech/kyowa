var ManageSetting = function() {
    var setting = function() {
        var hostDetailForm = $('#host_detail_form');

        hostDetailForm.on('submit', function(e) {
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
                            text: "Host Detail Update.",
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

        var hostDetailImageForm = $('#host_detail_image_select_form');

        hostDetailImageForm.on('submit', function(e) {
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
            submit_btn.addClass('m-loader m-loader--right m-loader--accent').attr('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    submit_btn.removeClass('m-loader m-loader--right m-loader--accent').attr('disabled', false);
                    if (response.result === "success") {
                        $('#host_image_tag').attr('src', response.image_url);
                        $('#host_detail_image_select_modal').modal('hide');
                        destroySlim();
                        initSlim();
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

    var initSlim = function() {
        hostImageSlim = new Slim(document.getElementById('host_detail_image_select_slim'), {
            minSize: {
                width: 100,
                height: 100
            },
            download: false,
            label: 'Drop your image here or Click',
            statusImageTooSmall: 'Image too small. Min Size is $0 pixel. Try again.'
        });

        hostImageSlim.size = {
            width: 1000,
            height: 1000
        };
    }

    var destroySlim = function() {
        hostImageSlim.destroy();
    }

    return {
        init: function() {
            var hostImageSlim;
            setting();
            initSlim();
        },
    };
}();
jQuery(document).ready(function(){
    ManageSetting.init();
});
