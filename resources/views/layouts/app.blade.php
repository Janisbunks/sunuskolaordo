<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:ital,opsz,wght@0,8..60,200..900;1,8..60,200..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
        <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
        <meta name="google-site-verification" content="AyazDPKoS6eV6A4O_byN8iDgzfXbwj-OQtcYKoPhTKE" />
    </head>

    <body <?php body_class(); ?>>
        <?php wp_body_open(); ?>
        <?php do_action('get_header'); ?>
        <div id="app">
            @include('sections.header')
            @yield('before-content')
            <div class="{{$container}} py-8 @hasSection('sidebar') gap-6 lg:grid-cols-12 grid @endif">
              <main id="main" class="@hasSection('sidebar')lg:col-span-8 @endif">
                @yield('content')
              </main>
              @hasSection('sidebar')
                <aside class="sidebar lg:col-span-4">
                  @yield('sidebar')
                </aside>
              @endif
            </div>
            @yield('after-content')
            @include('sections.footer')
        </div>
        <?php do_action('get_footer'); ?>
        <?php wp_footer(); ?>
        @stack('after-scripts')
    </body>
</html>