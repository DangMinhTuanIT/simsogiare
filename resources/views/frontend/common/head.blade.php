
<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" class="ie" dir="ltr" lang="en-US">
<![endif]-->
<!--[if IE 7]>
<html id="ie7" class="ie" dir="ltr" lang="en-US">
<![endif]-->
<!--[if IE 8]>
<html id="ie8" class="ie" dir="ltr" lang="en-US">
<![endif]-->
<!--[if IE 9]>
<html class="ie" dir="ltr" lang="en-US">
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Favicon-->
<link rel="icon" href="{{URL::to('favicon.ico')}}" type="image/x-icon">
<meta name="theme-color" content="#44a3ea">
<link rel="apple-touch-icon" href="{{URL::to('public/front-end/images/cropped-favicon.jpg')}}" />
<meta name="p:domain_verify" content="c579cd0f77a63791255381a39273ccd1"/>
<link rel="stylesheet" href="{{asset('css/simsogiare/style.css')}}">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">


@yield('seo')
@include('frontend.common.style-minify')
</head>
