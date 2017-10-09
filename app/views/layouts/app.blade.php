<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="assets/css/app.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>

    @yield('content')


    <ul class='custom-menu'>
        <li data-action="first"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Buy This!</li>
        <li data-action="second"><i class="fa fa-money" aria-hidden="true"></i> Make Offers!</li>
        <li data-action="third"><i class="fa fa-id-card-o" aria-hidden="true"></i> Get License</li>
    </ul>

    <!-- HTML -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>