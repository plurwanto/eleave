<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <title>Elabram - 404 Page Not Found</title>
    <meta name="description" content="Elabram - 404">
    <meta name="author" content="ElabramSystems">
    <link rel="shortcut icon" type="image/png" href="{{{ URL::asset(env('PUBLIC_PATH').'images/Elabram_favicon.ico') }}}" />
</head>

<body style="overflow: hidden; min-height: 100vh; max-height: 100vh; min-width: 100vw; max-width: 100vw;">
    <img src="{{ URL::asset(env('PUBLIC_PATH').'images/404.svg') }}" alt="page-not-found"
        style="min-height: 100vh; max-height: 100vh; min-width: 100vw; max-width: 100vw;" />
    <?php die(); ?>
</body>

</html>