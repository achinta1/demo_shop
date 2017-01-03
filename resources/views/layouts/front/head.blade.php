<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
		<title>{{ isset($data['meta_title'])?$data['meta_title']:'DemoShop' }}</title>
		<!-- Custom CSS -->
		<link href="{{ asset('public/front/css/style.css')}}" rel="stylesheet.css">
		<!-- Bootstrap Core CSS -->
		<link href="{{ asset('public/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
		<!-- Custom Fonts -->
		<link href="{{ asset('public/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
		
		<!-- jquery JavaScript -->
		<script src="{{asset('public/jquery/jquery-3.1.1.min.js')}}"></script>
</head>