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

        header {
            line-height: 0.6cm;
            position: fixed;
            top: 0.7cm;
            left: 1.5cm;
            right: 1.5cm;
            height: 4cm;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0.5cm;
            right: 1.5cm;
            height: 2cm;
        }

        .pagenum:before {
            content: counter(page);
        }

        .page-break {
            page-break-after: always;
        }
    </style>


</head>

<body>

    @include('partials.header-pdf')

    @yield('content')

    @include('partials.footer-pdf')

</body>

</html>