<!doctype html>
<html lang="ru" class="h-full">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="index,follow">
  <meta name="format-detection" content="phone=no">
  <meta name="theme-color" content="#FB923C">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ asset('assets/img/favicon.svg') }}" type="image/svg+xml">
  <title>@yield('title', config('app.name')) | {{ config('app.name') }}</title>
  <meta name="description" content="@yield('description', config('app.name'))">
  <meta name="currency" content="ruble">


  {{-- <link rel="canonical" href="https://example.com/article/?page=2"> --}}

  @stack('header-meta')
  <style>
    [x-cloak] {
      display: none !important;
    }

  </style>
  @stack('header-css')
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">

  <livewire:styles>
    @stack('header-script')

</head>

<body class="grid min-h-full antialiased leading-none text-gray-800 bg-gray-50">
