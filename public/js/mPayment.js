var ManageSetting = function() {
    var setting = function() {
        var paymentDetailForm = $('#payment_detail_form');

        var paymentDetailFormValid = paymentDetailForm.validate({
            ignore: ":hidden",
            rules: {
                bank_user_first_name: {
                    required: true
                },
                bank_user_last_name: {
                    required: true
                },
                bank_account_address: {
                    required: true
                },
                bank_currency: {
                    required: true
                },
                bank_name: {
                    required: true
                },
                bank_address: {
                    required: true
                },
                iban_number: {
                    required: true
                },
                bic_swift_code: {
                    required: true
                },
            },
            errorPlacement: function(error, element) {},
        });

        paymentDetailForm.on('submit', function(e) {
            e.preventDefault();

            if (!paymentDetailFormValid.form()) {
                swal({title: "", text: "Please fill all field.", type: "error", confirmButtonClass: "btn m-btn--air m-btn btn-outline-accent m-btn--wid"})
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            var url = paymentDetailForm.attr('action');

            var formData = new FormData(paymentDetailForm[0]);
            var submit_btn = paymentDetailForm.find('.form-submit-btn');
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
                            text: "Payment Detail Updated.",
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
        })
    };

    var initPlugin = function() {
        $('.m_selectpicker').select2({
            placeholder: "Currency",
            allowClear: !0
        });
    }

    return {
        init: function() {
            setting();
            initPlugin();
        },
    };
}();
jQuery(document).ready(function(){
    ManageSetting.init();
});
