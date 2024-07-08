<!DOCTYPE html>
<html lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title><?php echo app('translator')->get('lang.Login system - Software sales'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo app('translator')->get('login.title'); ?></title>
    <?php echo \App\CusstomPHP\AssetFile::css('jqx.base.css'); ?>

<?php /*    <?php echo \App\CusstomPHP\AssetFile::css('jqx.light.css'); ?>*/ ?>
    <?php echo \App\CusstomPHP\AssetFile::css('jqx.bootstrap.css'); ?>

    <?php echo \App\CusstomPHP\AssetFile::css('jqx.metro.css'); ?>

    <?php echo \App\CusstomPHP\AssetFile::css('font-awesome.min.css'); ?>

    <?php echo \App\CusstomPHP\AssetFile::css('bootraps.css'); ?>

    <?php echo \App\CusstomPHP\AssetFile::css('login.css'); ?>

    <?php echo \App\CusstomPHP\AssetFile::js('jquery.min.js'); ?>

    <?php echo \App\CusstomPHP\AssetFile::js('jqxcore.js'); ?>

    <?php echo \App\CusstomPHP\AssetFile::js('jqxnotification.js'); ?>

    <style>
        body.simple-page {
            background-color: #188ae2;
            padding-top: 8%; }

        .simple-page-wrap {
            max-width: 380px;
            margin: 0 auto; }

        .simple-page-logo {
            text-align: center;
            font-size: 24px;
            margin-bottom: 24px; }
        .simple-page-logo a {
            color: #fff; }

        .simple-page-form {
            background-color: #fff;
            border-radius: 6px;
            padding: 24px;
            margin-bottom: 24px; }
        .simple-page-form .form-group {
            margin-bottom: 32px; }
        .simple-page-form input,
        .simple-page-form input:focus,
        .simple-page-form input:active {
            outline: none;
            box-shadow: none; }
        .simple-page-form input {
            border: none;
            border-bottom: 1px solid #eee;
            height: 40px; }
        .simple-page-form .btn {
            width: 100%; }

        .simple-page-footer p {
            text-align: center;
            margin-bottom: 24px; }

        .simple-page-footer a {
            color: #fff;
            font-weight: 500; }

        .simple-page-footer small {
            margin-right: 16px;
            color: #fff; }

        #_404_title {
            text-align: center;
            font-weight: 900;
            font-size: 140px;
            letter-spacing: 5px;
            color: #fff; }

        #_404_msg {
            color: #fff;
            text-align: center;
            font-size: 16px; }

        #_404_form {
            margin-top: 48px; }
        #_404_form .form-control {
            height: 40px; }
        #_404_form .input-group-addon {
            background: #188ae2;
            border: #188ae2;
            color: #fff; }

        #unlock-user {
            margin-top: 64px;
            margin-bottom: 48px; }
        #unlock-user .avatar {
            display: block;
            margin-right: 0;
            margin: 0 auto;
            width: 80px;
            height: 80px; }
        #unlock-user h4 {
            color: #fff;
            text-align: center;
            text-transform: uppercase; }

        #unlock-form .form-group {
            margin-bottom: 32px; }

        #unlock-form input,
        #unlock-form input:focus,
        #unlock-form input:active {
            outline: none;
            box-shadow: none;
            border: none;
            border-bottom: 1px solid #aaa; }

        #unlock-form input {
            width: 70%;
            margin: 0 auto;
            border-radius: 0;
            text-align: center;
            color: #fff;
            background-color: transparent;
            height: 40px; }
        #unlock-form input::-webkit-input-placeholder {
            color: #fff; }
        #unlock-form input::-moz-placeholder {
            color: #fff; }
        #unlock-form input:-ms-input-placeholder {
            color: #fff; }

        #unlock-form #unlock-btn {
            display: block;
            margin: 0 auto;
            background-color: #fff;
            color: #188ae2;
            border-radius: 3px;
            width: 120px; }

        #back-to-home {
            position: fixed;
            top: 60px;
            left: 60px; }
        #back-to-home a {
            color: #fff;
            font-size: 18px; }
        #back-to-home a i {
            font-size: 24px; }

        /*# sourceMappingURL=misc-pages.css.map */
    </style>
</head>

<body class="simple-page">
<div>
    <div class="simple-page-wrap">
        <div class="simple-page-logo">
            <a href="#">
                <span><i class="fa fa-shopping-bag"></i></span> <span><?php echo app('translator')->get('lang.Software sales HDNET'); ?></span>
            </a>
        </div>
        <div class="simple-page-form animated flipInY" id="login-form">
            <h4 class="form-title m-b-xl text-center"><?php echo app('translator')->get('lang.Login to the system'); ?></h4>
            <form action="#">
                <div class="form-group"><input id="username" type="text"
                                               class="form-control" placeholder="<?php echo app('translator')->get('lang.Username'); ?>">
                </div>
                <div class="form-group">
                    <input id="password" type="password" class="form-control"
                                               placeholder="<?php echo app('translator')->get('lang.Password'); ?>"></div>
                <div class="form-group m-b-xl">
                    <div class="checkbox checkbox-primary">
                        <input type="checkbox" id="keep_me_logged_in">
                        <label for="keep_me_logged_in"><?php echo app('translator')->get('lang.Keep me signed in'); ?></label></div>
                </div>
                <button id="btn_login"  type="button" class="btn btn-primary"> <?php echo app('translator')->get('lang.Login'); ?></button>
            </form>
        </div>
        <div class="simple-page-footer"><p><a href="#"><?php echo app('translator')->get('lang.DO YOU FORGET PASSWORD?'); ?></a></p>
            <p>
                <small><?php echo app('translator')->get('lang.Do not have an account?'); ?></small>
                <a href="#"><?php echo app('translator')->get('lang.CREATE ACCOUNT'); ?></a></p>
        </div>
    </div>
</div>


<div id="messageNotificationErr">
    <div>
        <?php echo app('translator')->get('lang.Login unsuccessful!'); ?>
    </div>
</div>
<div id="messageNotificationSucc">
    <div>
        <?php echo app('translator')->get('lang.Logged in successfully! Redirecting ...'); ?>
    </div>
</div>

<script>
    var btn_login = $('#btn_login');
    //Remove old access_token
    localStorage.setItem('access_token', '');
    var url_login = '<?php echo \App\CusstomPHP\CustomURL::routeApi('login'); ?>';

    function createElement() {
        var window_width = 340;
        var window_y = '10%';
        if ($(window).width() <= 340) {
            window_width = $(window).width() - 30;
            window_y = "20%";
        }
        $("#messageNotificationErr").jqxNotification({
            width: 250, position: "top-right", opacity: 0.9,
            autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "error"
        });
        $("#messageNotificationSucc").jqxNotification({
            width: 250, position: "top-right", opacity: 0.9,
            autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "success"
        });
    }


    function createEvent() {
        btn_login.click(function () {
            btn_login.html('Đang đăng nhập <i class="fa fa-spin fa-spinner" aria-hidden="true"></i>');
            btn_login.prop('disabled', true);
            var username = $('#username').val();
            var password = $('#password').val();


            var form_data = {
                'username': username,
                'password': password,
                'app_id': '<?php echo csrf_token(); ?>',
            };


            $.ajax({
                method: 'POST',
                url: url_login,
                data: form_data,
                dataType: 'json',
                success: function (result) {
                    console.log(result);
                    if (result['success']) {
                        localStorage.setItem('access_token', result['data']['access_token']);
                        $(location).attr('href', result['data']['url_redirect']);
                        $("#messageNotificationSucc").jqxNotification('open');
                    } else {
                        $("#messageNotificationErr").jqxNotification('open');
                    }
                },
                error: function (e) {
                    $("#messageNotificationErr").jqxNotification('open');
                }
            }).always(function () {
                btn_login.prop('disabled', false);
                btn_login.html('Đăng nhập');
            });
        });

        //$('#password')
        $('#password').keyup(function (e) {
            if (e.keyCode == 13) {
                btn_login.click();
            }
        });
        $('#username').keyup(function (e) {
            if (e.keyCode == 13) {
                $('#password').focus();
            }
        });
    }


    $(document).ready(function () {
        $.jqx.theme = 'metro';
        createElement();
        createEvent();
    })
</script>

</body>

</html>
