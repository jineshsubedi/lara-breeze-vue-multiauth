<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <!-- Vendor CSS Files -->
    <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <!-- <link href="{{asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
        <link href="{{asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet"> -->
    <link href="{{asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/vendor/fullcalendar/main.min.css')}}">

    {{-- fron css  --}}
    <link rel="stylesheet" href="{{asset('front/assets/css/fontawesome.cs')}}s">
    <link rel="stylesheet" href="{{asset('front/assets/css/templatemo-onix-digital.css')}}">
    <link rel="stylesheet" href="{{asset('front/assets/css/animated.css')}}">
    <link rel="stylesheet" href="{{asset('front/assets/css/owl.css')}}">

    <!-- Template Main CSS File -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <!-- Scripts -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset('assets/vendor/jsPdf/jspdf.umd.min.js')}}"></script>
    <!-- <script src="{{asset('assets/vendor/html2canvas/html2canvas.min.css')}}"></script> -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
        .pull-right {
            float: right
        }
    </style>
    @routes
    @vite('resources/js/app.js')
    @inertiaHead
</head>

<body class="font-sans antialiased" id="mainBody">
    @inertia
    <script src="{{asset('theme/plugins/jquery/jquery.min.js')}}"></script>
    <!-- <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script> -->
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- <script src="{{asset('assets/vendor/chart.js/chart.min.js')}}"></script> -->
    <!-- <script src="{{asset('assets/vendor/echarts/echarts.min.js')}}"></script> -->
    <!-- <script src="{{asset('assets/vendor/quill/quill.min.js')}}"></script> -->
    <!-- <script src="{{asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script> -->
    <script src="{{asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>

    <script src="{{asset('assets/vendor/fullcalendar/main.min.js')}}"></script>
    <!-- Template Main JS File -->
    <script src="{{asset('assets/js/main.js')}}"></script>

    {{-- <script src="{{asset('front/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script> --}}
    <script src="{{asset('front/assets/js/owl-carousel.js')}}"></script>
    <script src="{{asset('front/assets/js/animation.js')}}"></script>
    <script src="{{asset('front/assets/js/imagesloaded.js')}}"></script>
    {{-- <script src="{{asset('front/assets/js/custom.js')}}"></script> --}}
</body>

</html>