<head>
	<meta charset="utf-8" />
	<title>Fenovo</title>
	<meta name="description" content="fenovo frioteka congelados" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<link rel="shortcut icon" href="{{asset('favicon.ico')}}" />
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link href="{{asset('assets/css/style.css?v=1.0')}}" rel="stylesheet" type="text/css" />

	@auth
        <link href="{{asset('assets/css/style.css?v=1.0')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/navbar.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/api/pace/pace-theme-flat-top.css')}}" rel="stylesheet" type="text/css" />

        <link href="{{asset('assets/api/mcustomscrollbar/jquery.mCustomScrollbar.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/api/datatable/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/toastr.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/ymz_box.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/toastr.min.css')}}">
        <link href="{{asset('assets/api/select2/select2.min.css')}}" rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('assets/css/loading.css')}}">
	@endauth

	{!! htmlScriptTagJsApi() !!}

</head>
