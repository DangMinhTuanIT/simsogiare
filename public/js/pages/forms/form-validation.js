$(function () {
    $.validator.addMethod("valueNotEquals", function(value, element, arg){
        return arg != element.value;
    }, "Value must not equal arg.");

    $.validator.messages = {
        required: "Vui lòng nhập thông tin.",
        remote: "Vui lòng sửa lại thông tin này.",
        email: "Vui lòng nhập email hợp lệ.",
        url: "Vui lòng nhập URL hợp lệ.",
        date: "Vui lòng nhập một ngày hợp lệ.",
        dateISO: "Vui lòng nhập một ngày hợp lệ (ISO).",
        number: "Vui lòng nhập một số hợp lệ.",
        digits: "Chỉ nhập chữ.",
        equalTo: "Vui lòng nhập thông tin trùng nhau.",
        maxlength: $.validator.format( "Vui lòng không nhập thêm {0} ký tự." ),
        minlength: $.validator.format( "Vui lòng nhập ít nhất {0} ký tự." ),
        rangelength: $.validator.format( "Vui lòng nhập độ dài trong khoảng {0} và {1} ký tự." ),
        range: $.validator.format( "Vui lòng nhập giá trị trong khoảng {0} và {1}." ),
        max: $.validator.format( "Vui lòng nhập giá trị ít hơn hoặc bằng {0}." ),
        min: $.validator.format( "Vui lòng nhập giá trị lớn hơn hoặc bằng {0}." ),
        step: $.validator.format( "Vui lòng nhập nhiều của {0}." )
    };

    $('.form_validation').validate({
        highlight: function (input) {
            $(input).parents('.form-line, .form-control').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line, .form-control').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-group').append(error);
        }
    });

    //Advanced Form Validation
    $('#form_advanced_validation').validate({
        rules: {
            'date': {
                customdate: true
            },
            'creditcard': {
                creditcard: true
            }
        },
        highlight: function (input) {
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-group').append(error);
        }
    });

    //Custom Validations ===============================================================================
    //Date
    $.validator.addMethod('customdate', function (value, element) {
        return value.match(/^\d\d\d\d?-\d\d?-\d\d$/);
    },
        'Please enter a date in the format YYYY-MM-DD.'
    );

    //Credit card
    $.validator.addMethod('creditcard', function (value, element) {
        return value.match(/^\d\d\d\d?-\d\d\d\d?-\d\d\d\d?-\d\d\d\d$/);
    },
        'Please enter a credit card in the format XXXX-XXXX-XXXX-XXXX.'
    );
    //==================================================================================================
});
$(document).ready(function () {
    $('.form_validation select').on('change', function () {
        $(this).parent('.bootstrap-select').removeClass('error');
    });
});