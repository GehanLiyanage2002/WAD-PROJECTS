function start_loader() {
    if (!document.getElementById('preloader')) {
        $('body').append(
            '<div id="preloader">' +
                '<div class="loader-holder">' +
                    '<div></div><div></div><div></div><div></div>' +
                '</div>' +
            '</div>'
        );
    }
}

function end_loader() {
    $('#preloader').fadeOut('fast', function () {
        $(this).remove();
    });
}

// toast
window.alert_toast = function ($msg = 'TEST', $bg = 'success', $pos = '') {
    var Toast = Swal.mixin({
        toast: true,
        position: $pos || 'top',
        showConfirmButton: false,
        timer: 3500
    });
    Toast.fire({
        icon: $bg,
        title: $msg
    });
};

$(document).ready(function () {
    // Login (admin)
    $('#login-frm').submit(function (e) {
        e.preventDefault();
        start_loader();
        $('.err_msg').remove();
        $.ajax({
            url: _base_url_ + 'classes/Login.php?f=login',
            method: 'POST',
            data: $(this).serialize(),
            success: function (resp) {
                try {
                    resp = JSON.parse(resp || '{}');
                    if (resp.status === 'success') {
                        location.replace(_base_url_ + 'admin');
                    } else if (resp.status === 'incorrect') {
                        var _frm = $('#login-frm');
                        var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i> Incorrect username or password</div>";
                        _frm.prepend(_msg);
                        _frm.find('input').addClass('is-invalid');
                        $('[name="username"]').focus();
                    } else if (resp.status === 'notverified') {
                        var _frm = $('#login-frm');
                        var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i> Your Account is not yet verified.</div>";
                        _frm.prepend(_msg);
                        _frm.find('input').addClass('is-invalid');
                        $('[name="username"]').focus();
                    }
                } catch (e) {
                    console.error('Invalid JSON:', resp);
                }
            },
            error: function (err) {
                console.log(err);
                alert_toast('An error occurred', 'error');
            },
            complete: function () {
                end_loader();
            }
        });
    });

    // Employer login
    $('#elogin-frm').submit(function (e) {
        e.preventDefault();
        start_loader();
        $('.err_msg').remove();
        $.ajax({
            url: _base_url_ + 'classes/Login.php?f=elogin',
            method: 'POST',
            data: $(this).serialize(),
            success: function (resp) {
                try {
                    resp = JSON.parse(resp || '{}');
                    if (resp.status === 'success') {
                        location.replace(_base_url_);
                    } else if (!!resp.msg) {
                        var _frm = $('#elogin-frm');
                        var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i> " + resp.msg + "</div>";
                        _frm.prepend(_msg);
                        _frm.find('input').addClass('is-invalid');
                        $('[name="email"]').focus();
                    } else {
                        // FIXED: was '#clogin-frm' (wrong); should be '#elogin-frm'
                        var _frm = $('#elogin-frm');
                        var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i> An error occurred.</div>";
                        _frm.prepend(_msg);
                        _frm.find('input').addClass('is-invalid');
                        $('[name="email"]').focus();
                    }
                } catch (e) {
                    console.error('Invalid JSON:', resp);
                    alert_toast('Invalid server response', 'error');
                }
            },
            error: function (err) {
                console.log(err);
                alert_toast('An error occurred', 'error');
            },
            complete: function () {
                end_loader();
            }
        });
    });

    // Student login
    $('#slogin-frm').submit(function (e) {
        e.preventDefault();
        start_loader();
        $('.err_msg').remove();
        $.ajax({
            url: _base_url_ + 'classes/Login.php?f=slogin',
            method: 'POST',
            data: $(this).serialize(),
            success: function (resp) {
                try {
                    resp = JSON.parse(resp || '{}');
                    if (resp.status === 'success') {
                        location.replace(_base_url_ + 'student');
                    } else if (resp.status === 'incorrect') {
                        var _frm = $('#slogin-frm');
                        var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i> Incorrect username or password</div>";
                        _frm.prepend(_msg);
                        _frm.find('input').addClass('is-invalid');
                        $('[name="username"]').focus();
                    }
                } catch (e) {
                    console.error('Invalid JSON:', resp);
                }
            },
            error: function (err) {
                console.log(err);
                alert_toast('An error occurred', 'error');
            },
            complete: function () {
                end_loader();
            }
        });
    });

    // System Info
    $('#system-frm').submit(function (e) {
        e.preventDefault();
        start_loader(); // re-enabled for consistency
        $('.err_msg').remove();
        $.ajax({
            url: _base_url_ + 'classes/SystemSettings.php?f=update_settings',
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function (resp) {
                if (resp == 1) {
                    location.reload();
                } else {
                    $('#msg').html('<div class="alert alert-danger err_msg">An error occurred</div>');
                }
            },
            error: function (err) {
                console.log(err);
                $('#msg').html('<div class="alert alert-danger err_msg">Request failed</div>');
            },
            complete: function () {
                // FIXED: was end_load(); → now the correct name:
                end_loader();
            }
        });
    });
});
