<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-21
 * Time: 14:35
 */
?>
        <!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en"/>
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ url('/') . '/' }}favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('/') . '/' }}favicon.ico"/>
    <!-- Generated: 2018-04-16 09:29:05 +0200 -->
    <title>@yield('title', 'AEC')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <script src="{{ url('/') . '/' }}assets/js/vendors/jquery-3.2.1.min.js"></script>
    <script src="{{ url('/') . '/' }}assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="{{ url('/') . '/' }}assets/js/require.min.js"></script>
    <script>
        requirejs.config({
            baseUrl: "{{ url('/') . '/' }}"
        });
    </script>
    <!-- Dashboard Core -->
    <link href="{{ url('/') . '/' }}assets/css/dashboard.css" rel="stylesheet"/>
    <script src="{{ url('/') . '/' }}assets/js/dashboard.js"></script>
    <!-- c3.js Charts Plugin -->
    <link href="{{ url('/') . '/' }}assets/plugins/charts-c3/plugin.css" rel="stylesheet"/>
    <script src="{{ url('/') . '/' }}assets/plugins/charts-c3/plugin.js"></script>
    <!-- Google Maps Plugin -->
    <link href="{{ url('/') . '/' }}assets/plugins/maps-google/plugin.css" rel="stylesheet"/>
    <script src="{{ url('/') . '/' }}assets/plugins/maps-google/plugin.js"></script>
    <!-- Input Mask Plugin -->
    <script src="{{ url('/') . '/' }}assets/plugins/input-mask/plugin.js"></script>
    <!-- datetime picker -->
    <link href="{{ url('/') . '/' }}assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    @section('head')
    @show
</head>
<body class="">
<div class="page">
    <div class="page-main">
        @include('public.header')
        <div class="my-3 my-md-5">
            <div class="container">
                @if(count($errors) > 0)
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-icon alert-danger" role="alert">
                            <i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i>
                            {{ $error or '' }}
                            <button type="button" class="close" data-dismiss="alert"></button>
                        </div>
                    @endforeach
                @endif
                @section("container")
                    <div class="page-header">
                        <h1 class="page-title">
                            @yield('h1', 'Dashboard')
                        </h1>
                    </div>
                @show
            </div>
        </div>
    </div>
    @include('public.footer')
</div>
@section('foot')
@show
</body>
</html>