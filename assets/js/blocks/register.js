$(function() {
    let regFormEmail = $('#registration_form_email');

    regFormEmail.on('blur', function() {
        if (regFormEmail.val().length > 5) {
            $.ajax({
                url: '/user/register/email/check/' + regFormEmail.val(),
                type: 'GET',
                success: function(data) {
                    $('.email-error').remove();
                    if (data.length > 0) {
                        regFormEmail.after(data);
                    }
                }
            });
        }
    });
});