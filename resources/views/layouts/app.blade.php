<html>
    <head>
        <title>App Name - @yield('title')</title>
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <script src="{{ mix('js/app.js') }}"></script>
        <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

    </head>
    <body>
        @section('sidebar')

        @show

        <div class="container">
            @yield('content')
        </div>
    </body>
            @stack('scripts')
</html>