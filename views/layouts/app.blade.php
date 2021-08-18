<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Page title -->
    <title>{{ $config->get('App Name') }} - @yield('title')</title>
    <!-- Page meta -->
    <link rel="icon" href="/public/media/logo.png" type="image/png">
    <meta name="title" content="{{ $config->get('App Name') }}">
    <meta name="description" content="{{ $config->get('App Name') }}">
    <meta name="keywords" content="{{ $config->get('App Name') }}, Garry's Mod, Roleplay">
    <meta name="author" content="{{ $config->get('App Name') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $config->get('Domain') }}">
    <meta property="og:title" content="{{ $config->get('App Name') }}">
    <meta property="og:description" content>
    <meta property="og:image" content>
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ $config->get('Domain') }}">
    <meta property="twitter:title" content="{{ $config->get('App Name') }}">
    <meta property="twitter:description" content>
    <meta property="twitter:image" content>

    <!-- Load Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.css" type="text/css"
          integrity="sha512-9LMt8yHSTC2NNj7wxs1u0wfc8JsHPz2IO3hPj5ZOVhM60uMHDhWxEzO+Yz9wBCJRoMa4UHItzgdwW4ZxVG2O4g=="
          crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.css"
          type="text/css"
          integrity="sha512-IOs1XMJ8vPmQX+aSgwGt8nA1wMAvqt5CKH9sqxUnhGdnrAdPZGPwoQexsOexknQHFurLbq2bFLh1WTk2vbGmOQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lato-font/3.0.0/css/lato-font.css" type="text/css"
          integrity="sha512-DdjGGRLdxZPin6QfSJ0dhPPTvyFzCvNl7jhl/AKMa3oyfUmelLEFLXi9thQWf3ynI9q/ehTcVPb+o1z8oo5ydg=="
          crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- Load custom css/js  -->
    <link rel="stylesheet" type="text/css" href="/public/css/index.css">

</head>
<body>
    <header class="mb-4">
        @include('partials.navigation')
    </header>
    <main class="container">
        @yield('content')
    </main>

    <!-- Extra script data -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" type="text/javascript"
            integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.js" type="text/javascript"
            integrity="sha512-ade5OkuVL+OsYvavdORMlKVFmuABDGzIVdepnBzif477QxKtPLjJ8H4/GHucoNV7slHB8fDP8uAY1CtpD8RzpQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>