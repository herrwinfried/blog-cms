$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        var formData = {
            loginModal_username: $('#loginModal_username').val(),
            loginModal_password: $('#loginModal_password').val()
        };

        $.ajax({
            url: window.location.origin + '/layouts/login.data.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === "success") {
                    $('#alert-danger').text("").fadeOut();
                    $('#alert-success').text(response.message).fadeIn();
                    $('#loginRegisterButton').fadeOut();
                    $('#loginForm')[0].reset();
                    setTimeout(function() {
                        window.location.href = '';
                    }, 1000);
                } else {
                    $('#loginRegisterButton').fadeIn();
                    $('#alert-success').text("").fadeOut();
                    $('#alert-danger').text(response.message).fadeIn();
                }
            },
            error: function(xhr, status, error) {
                $('#loginRegisterButton').fadeIn();
                $('#alert-success').text("").fadeOut();
                $('#alert-danger').text('An error occurred: ' + error).fadeIn();
            }
        });
    });

    $('#loginModal').on('click', '.btn, .btn-close', function() {
        $('#loginRegisterButton').fadeOut();
        $('#alert-success').text("").fadeOut();
        $('#alert-danger').text("").fadeOut();
    });

    $('#registerForm').on('submit', function(e) {
        e.preventDefault();
        var formData = {
            registerModal_username: $('#registerModal_username').val(),
            registerModal_email: $('#registerModal_email').val(),
            registerModal_display: $('#registerModal_display').val(),
            registerModal_password: $('#registerModal_password').val(),
            registerModal_password1: $('#registerModal_password1').val()
        };

        $.ajax({
            url: window.location.origin + '/layouts/register.data.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === "success") {
                    $('#ralert-danger').text("").fadeOut();
                    $('#ralert-success').text(response.message).fadeIn()
                    $('#registerLoginButton').fadeIn();
                    $('#registerForm')[0].reset();
                } else {
                    $('#registerLoginButton').fadeOut();
                    $('#ralert-success').text("").fadeOut();
                    $('#ralert-danger').text(response.message).fadeIn()
                }
            },
            error: function(xhr, status, error) {
                $('#registerLoginButton').fadeOut();
                $('#ralert-success').text("").fadeOut();
                $('#ralert-danger').text('An error occurred: ' + error).fadeIn()
            }
        });
    });

    $('#registerModal').on('click', '.btn, .btn-close', function() {
        $('#registerLoginButton').fadeOut();
        $('#ralert-success').text("").fadeOut();
        $('#ralert-danger').text("").fadeOut();
    });
});