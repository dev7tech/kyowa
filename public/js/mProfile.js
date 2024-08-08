var ManageProfile = function() {

    var profile = function() {
        $('#profile_avatar_img_form').on('submit', function(e) {
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
                        $('#profile_avatar_img').attr('src', response.image_url);
                        $('#profile_avatar_img_modal').modal('hide');
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
        })

        $('#profile_bio_update_form').on('submit', function(e) {
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
                    if (response.result == "success") {
                        $('#profile_update_alert').removeClass('m--hide');
                    }
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        })

        var passwordUpdateForm = $('#profile_password_update_form');

        var passwordUpdateFormValid = passwordUpdateForm.validate({
            ignore: ":hidden",
            rules: {
                old_password: {
                    required: true
                },
                password: {
                    required: true
                },
                confirm_password: {
                    required: true,
                    equalTo: '#confirm_password'
                }
            },
        });

        $('#profile_password_update_form').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);

            if (!passwordUpdateFormValid.form()) {
                return false;
            }

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
                    if (response.result == "success") {
                        form[0].reset();
                        $('#profile_password_update_alert').removeClass('m--hide');
                    } else {
                        swal({
                            title: "Error",
                            text: response.msg,
                            type: "error", confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"
                        });
                    }
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        })

        $('#profile_host_update_form').on('submit', function(e) {
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
                    if (response.result == "success") {
                        $('#host_update_alert').removeClass('m--hide');
                    }
                },
                processData: false,
                contentType: false,
                error: function(error) {
                    console.log(error);
                }
            });
        })
    }

    var initSlim = function() {
        avatarSlim = new Slim(document.getElementById('profile_avatar_img_slim'), {
            ratio: '1:1',
            minSize: {
                width: 100,
                height: 100
            },
            download: false,
            label: 'Drop your image here or Click',
            statusImageTooSmall: 'Image too small. Min Size is $0 pixel. Try again.'
        });

        avatarSlim.size = {
            width: 500,
            height: 500
        };
    }

    var destroySlim = function() {
        avatarSlim.destroy();
    }
    return {
        init: function() {
            var avatarSlim;
            profile();
            initSlim();
        },
    };
}();

jQuery(document).ready(function() {
    ManageProfile.init();
});
