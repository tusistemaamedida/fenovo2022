<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" />
    <link href="{{asset('assets/css/style-pdf.css')}}" rel="stylesheet" type="text/css" />

    @yield('css')

</head>

<body>
    @yield('content')
</body>

</html>