<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Feather icon -->
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- css --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- font awesom --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <!-- Include Cropper JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: #4CAF50; /* Green 500 */
            --danger-color: #F44336;   /* Red 500 */
            --background-color: #f3f4f6;  /* gray-100 */
            --text-color: #6b7280; /* gray-500 */
        }

        .swal2-confirm {
            background-color: var(--primary-color) !important;
        }

        .swal2-cancel {
            background-color: var(--danger-color) !important;
        }

    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'koplak': '#FFEB3B',
                        'koplak-dark': '#FBC02D',
                        'koplak-darker': '#F57F17',
                        'koplak-light': '#111827',
                        'dark': '#111827',
                        'darker': '#0D1321'
                    },
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.6s ease-out forwards',
                        'scale-in': 'scaleIn 0.5s ease-out forwards',
                        'slide-up': 'slideUp 0.5s ease-out forwards'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-montserrat">
    @include('layouts.navbarAdmin')

    <div class="min-h-screen">
        <!-- Sidebar -->
        @include('layouts.sidebar')
        @yield('content')
    </div>

    @yield('modal-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>
</html>
