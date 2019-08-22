<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Elabram - 403  Access Denied</title>
    <meta name="description" content="Elabram - 403  Access Denied">
    <meta name="author" content="ElabramSystems">
    <link rel="shortcut icon" type="image/png" href="{{{ URL::asset(env('PUBLIC_PATH').'images/Elabram_favicon.ico') }}}" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
        crossorigin="anonymous">
    <style>
        body{
            overflow: hidden;
        }
        .container {
            position: relative;
            padding: 0;
            min-height: 100vh;
            max-height: 100vh;
            min-width: 90vw;
            max-width: 90vw;
        }

        .image {
            min-height: 100vh;
            max-height: 100vh;
            min-width: 100vw;
            max-width: 100vw;
        }

        .text {
            width: 540px;
            color: #005a92;
            font-size: 20px;
            position: absolute;
            top: 140px;
            right: 0;
        }

        .brand-logo {
            max-width: 60px;
        }

        .brand-text {
            max-width: 180px;
        }

        .error {
            font-size: 140px;
            font-weight: bold;
        }

        .error-text {
            font-size: 48px;
            margin-bottom: 5px;
            max-width: 416px;
        }

        .error-text-small{
            max-width: 416px;
            font-size: 23px;
            margin-bottom: 10px;
        }

        .btn-full {
            border-color: transparent;
            background-color: #1a7bcd;
            color: #fff;
            padding: 12px 15px;
        }

        .btn-full:hover {
            border-color: #1a7bcd;
            background-color: transparent;
            color: #1a7bcd;
            padding: 12px 15px;
            cursor: pointer;
        }

        .fa {
            vertical-align: baseline;
            padding-right: 3px;
        }
    </style>

</head>

<body style="overflow: hidden; min-height: 100vh; max-height: 100vh; min-width: 100vw; max-width: 100vw;">
    <div class="container">
        <img src="{{ URL::asset(env('PUBLIC_PATH').'images/403_image.svg') }}" class="image" alt="404" />
        <div class="text">
            <img class="brand-logo" alt="Elabram System" src="{{ URL::asset(env('PUBLIC_PATH').'images/Elabram_logo.svg') }}">
            <img class="brand-text" alt="Elabram System" src="{{ URL::asset(env('PUBLIC_PATH').'images/Elabram_text.svg') }}">
            <div class="error">403</div>
            <div class="error-text">Access denied</div>
            <div class="error-text-small">You don't have permission to access this site</div>
            <div class="return-button">
                <button type="button" class="btn btn-full m-btn m-btn--pill m-btn--custom">
                    <i class="fa fa-arrow-left"></i>
                    Back to the Last Page
                </button>
                or
                <button type="button" class="btn btn-full m-btn m-btn--pill m-btn--custom">
                    <i class="fa fa-home"></i>
                    Return to the Homepage
                </button>
            </div>
        </div>
    </div>
</body>

</html>
