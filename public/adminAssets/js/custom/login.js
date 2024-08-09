$('#password').keyup(function() {
    if (jQuery.trim($("#password").val()).length == 0) {
        this.value = $.trim(this.value);
    }
})
$('#email').keyup(function() {
    if (jQuery.trim($("#email").val()).length == 0) {
        this.value = $.trim(this.value);
    }
})

$("form[name='admin-login-form']").on('submit', function(e) {
    e.preventDefault();
}).validate({
    rules: {
        email: {
            required: true,
            normalizer: function(value) {
                return $.trim(value);
            },
        },
        password: {
            required: true,
            normalizer: function(value) {
                return $.trim(value);
            },
        },
    },
    messages: {
        email: {
            required: "Email is required",
        },
        password: {
            required: "Password is required",
        },
    },
    submitHandler: function(form) {
        var form_data = $(form).serialize();
        $("#admin-login-form button[type='submit']").attr('disabled', true);
        $.ajax({
            url: $(form).attr("action"),
            type: 'post',
            data: form_data,
            beforeSend: function() {
                $(".loader").show();
            },
            complete: function() {
                $(".loader").hide();
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = base_url + '/admin/dashboard';
                    $.notify(response.message, {
                        type: 'success'
                    });
                } else if (!response.success) {
                    $.notify(response.message, {
                        type: 'danger'
                    });
                } else {
                    $.notify('Something went wrong', {
                        type: 'danger'
                    });
                }
            },
            fail: function(xhr, status, error) {
                $.each(xhr.responseJSON.errors, function(key, item) {
                    $.notify(item, {
                        type: 'danger'
                    });
                });

            }
        });
        $("#admin-login-form button[type='submit']").attr('disabled', false);
    }
});