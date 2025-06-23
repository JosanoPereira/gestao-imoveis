<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>


    <link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
{{--    <link rel="manifest" href="assets/favicon/manifest.json">--}}
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">


    <link rel="stylesheet" href="{{asset('coreui/dist/css/coreui.min.css')}}">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="{{asset('simplebar/dist/simplebar.css')}}">
    <link rel="stylesheet" href="{{asset('scss/vendors/simplebar.scss')}}">
    <!-- Main styles for this application-->
    <link href="{{asset('scss/style.scss')}}" rel="stylesheet">
    <link href="{{asset('scss/examples.scss')}}" rel="stylesheet">

    <script src="js/config.js"></script>
    <script src="js/color-modes.js"></script>

    <link href="chartjs/dist/css/coreui-chartjs.css" rel="stylesheet">

    <style>
        .gest-bg-grey-table{
            background-color: #6c7577 !important;
            text-transform: capitalize;
            color: white;
        }
    </style>

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>
<body class="font-sans antialiased">
@inertia

<!-- CoreUI and necessary plugins-->
<script src="coreui/dist/js/coreui.bundle.min.js"></script>
<script src="dist/simplebar.min.js"></script>
<script>
    const header = document.querySelector('header.header');

    document.addEventListener('scroll', () => {
        if (header) {
            header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        const themeToggle = document.getElementById('theme-toggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                toggleTheme();
            });
        }
    });

    function toggleTheme() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('myChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: { /* seus dados */ },
                options: { /* opções */ }
            });
        }
    });

    const themeElement = document.querySelector('[data-theme]');
    if (themeElement) {
        themeElement.classList.add('active');
    }
</script>
<!-- Plugins and scripts required by this view-->
<script src="chartjs/dist/chart.umd.js"></script>
<script src="chartjs/dist/js/coreui-chartjs.js"></script>
<script src="utils/dist/umd/index.js"></script>
<script src="js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
</script>
</body>
</html>
