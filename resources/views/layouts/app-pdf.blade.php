<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" />
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />

    <style>
        @page {
            margin: 0px 0px;
        }

        body {
            margin-top: 4.5cm;
            margin-left: 1.5cm;
            margin-right: 1.5cm;
            margin-bottom: 2cm;
            font-size: 8;
        }

        .page-break {
            page-break-after: always;
        }
    </style>

    @yield('css')


</head>

<body>

    @yield('content')

</body>

</html>