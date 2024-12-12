<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>@yield('title', 'RydeChair')</title>

    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/vendors.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <style>
        .mm-navbars-bottom{
            display:none !important;
        }
        @media (max-width: 767px) {
            .mm-listview li {
                padding: 5px !important;
            }
            .main-menu ul a, .main-menu ul li a {
                font-weight: 500;
                color: #ececec !important;
            }             
        }        
        .call_section .box_how i{
            color: #fff !important;
        }
        .main-menu ul a, .main-menu ul li a {
            font-weight: 500;
            color: #333;
        }      
          
    </style>
    @stack('head')
</head>