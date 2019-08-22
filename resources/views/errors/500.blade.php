<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Elabram - 500 Under Maintenance</title>
    <meta name="description" content="Elabram - 500 Under Maintenance">
    <meta name="author" content="ElabramSystems">
    <link rel="shortcut icon" type="image/png" href="{{{ URL::asset(env('PUBLIC_PATH').'images/Elabram_favicon.ico') }}}" />
    @section('script')
    @include('Eleave/notification')
    @endsection
</head>

<body style="overflow: hidden; min-height: 100vh; max-height: 100vh; min-width: 100vw; max-width: 100vw;">
    <a href="{{ URL::to('index') }}" class="btn btn-circle grey-salsa btn-outline"><i class="fa fa-times"></i> Back to
        Portal</a>
    <img src="{{ URL::asset(env('PUBLIC_PATH').'images/under_maintenance.svg') }}" alt="under-maintenance"
        style="min-height: 100vh; max-height: 100vh; min-width: 100vw; max-width: 100vw;" />

    <?php die(); ?>

</body>

</html>