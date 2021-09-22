<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title') - {{ $config->get('App Name') }}</title>
  <link rel="icon" href="{{ $config->get('Domain') }}/public/media/logo.png" type="image/png">
  <meta name="title" content="{{ $config->get('App Name') }} - @yield('title')">
  <meta name="description" content>
  <meta name="keywords" content="{{ $config->get('App Name') }} - @yield('title'), Garry's Mod, Roleplay">
  <meta name="author" content="{{ $config->get('App Name') }} - @yield('title')">

  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ $config->get('Domain') }}">
  <meta property="og:title" content="{{ $config->get('App Name') }} - @yield('title')">
  <meta property="og:description" content>
  <meta property="og:image" content>

  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:url" content="{{ $config->get('Domain') }}">
  <meta property="twitter:title" content="{{ $config->get('App Name') }} - @yield('title')">
  <meta property="twitter:description" content>
  <meta property="twitter:image" content>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" type="text/javascript"
          integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>

  <link rel="stylesheet" type="text/css" href="{{ $config->get('Domain') }}/public/fomantic/semantic.min.css">
  <script src="{{ $config->get('Domain') }}/public/fomantic/semantic.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lato-font/3.0.0/css/lato-font.css" type="text/css"
    integrity="sha512-DdjGGRLdxZPin6QfSJ0dhPPTvyFzCvNl7jhl/AKMa3oyfUmelLEFLXi9thQWf3ynI9q/ehTcVPb+o1z8oo5ydg=="
    crossorigin="anonymous" referrerpolicy="no-referrer">
  <link rel="stylesheet" href="{{ $config->get('Domain') }}/public/css/main.css" type="text/css">

  <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
  <script src="/public/js/quill_toolbar.js"></script>
  <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
  <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

  <script>
    $(document)
            .ready(function() {
              // create sidebar and attach to menu open
              $('.ui.sidebar')
                      .sidebar('attach events', '.toc.item')
              ;
              $('.ui.progress')
                      .progress()
              ;
            })
    ;
  </script>
</head>

<body>
  @include('partials.navigation')
  <div class="ui container" style="margin-top: 20px; padding-bottom: 5px;">
    @yield('content')
  </div>
</body>

</html>