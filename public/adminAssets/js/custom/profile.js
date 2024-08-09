$(document).ready(function () {
    $("#admin-change-password").validate({
        rules: {
            old_password: {
                required: true,
                remote: {
                    url: base_url + '/admin/checkoldpassword',
                    type: "post",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                },
            },
            new_password: {
                required: true,
                minlength: 6,
                maxlength: 20,
                notEqual: "#old_password",
            },
            confirm_password: {
                required: true,
                minlength: 6,
                maxlength: 20,
                equalTo: "#new_password",
            },
        },
        messages: {
            old_password: {
                required: "Old password is required.",
                remote: "Current password does not match.",
            },
            new_password: {
                required: "New password is required.",
                minlength: "Password cannot less than 6 characters",
                maxlength: "Password cannot greater than 20 characters",
            },
            confirm_password: {
                required: "Confirm password is required.",
                minlength: "Confim password cannot less than 6 characters",
                maxlength: "Confim password cannot greater than 20 characters",
                equalTo: "Confim password and new password should be same.",
            },
        },
    });

    if (notificationMessage) {
        $.notify(notificationMessage, {
            type: notificationStatus, // 'success' or 'error'
            allow_dismiss: true,
            delay: 1500,
            animate: {
                enter: "animated fadeInDown",
                exit: "animated fadeOutUp",
            },
        });
    }
});
