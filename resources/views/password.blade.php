<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password</title>
    {{-- tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Warna Utama --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        utama: '#FFA75B',
                    }
                }
            }
        }
    </script>
    <!--font google-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lily+Script+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Feather icon -->
    <script src="https://unpkg.com/feather-icons"></script>
    {{-- css --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-gray-100">
    <!--Navbar-->
    <nav class="navbar">
        <a href ="#" class ="navbar-logo">Koplak<span>Food</span></a>
        <div class="navbar-nav">
            <a href="{{ route('index') }}">Home</a>
            <?php
            session_start();
            ?>

            @auth

            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('regis') }}">Registrasi</a>
            @endauth
            {{-- @if(session()->has('username'))
                @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('regis') }}">Registrasi</a>
            @endif --}}
            <a href="#products">Products</a>
            <a href="#forum">Forum</a>
            @auth
                <a href="{{ route('logout') }}">Logout</a>
            @else
            @endauth

            {{-- @if(session()->has('username'))
                <a href="{{ route('logout') }}">Logout</a>
                @else
            @endif --}}
        </div>

        <div class="navbar-extra">

            @auth
                <a href="{{ route('profile.show') }}" id="akun"><i data-feather="user" style="display:inline-block;"></i></a>
            @else
                <a href="profile.php" id="akun" style="display:none;"><i data-feather="user"></i></a>
            @endauth

            {{-- @if(session()->has('username'))
                <a href="{{ route('profile.show') }}" id="akun"><i data-feather="user" style="display:inline-block;"></i></a>
                @else
                <a href="profile.php" id="akun" style="display:none;"><i data-feather="user"></i></a>
            @endif --}}

            <a href="#" id="keranjang"><i data-feather="shopping-cart" style="display:inline-block;"></i></a>
            <a href="#" id="menu"><i data-feather="menu" style="display:inline-block;"></i></a>
        </div>
    </nav>
    <div class="min-h-screen flex justify-center py-32 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl w-full space-y-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Update Password</h2>

                </div>
                <form class="space-y-6" action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">
                                Password Saat Ini
                            </label>
                            <div class="mt-1">
                                <input id="current_password" name="current_password" type="password" autocomplete="current-password" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-utama focus:border-utama focus:z-1 sm:text-sm">
                            </div>
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                Password Baru
                            </label>
                            <div class="mt-1">
                                <input id="password" name="password" type="password" autocomplete="new-password" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-utama focus:border-utama focus:z-1 sm:text-sm">
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                Konfirmasi Password Baru
                            </label>
                            <div class="mt-1">
                                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-utama focus:border-utama focus:z-1 sm:text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="text-sm">
                            <a href="{{ route('profile.show') }}" class="font-medium text-utama hover:text-utama-dark">
                                Kembali ke Profil
                            </a>
                        </div>

                        <div class="w-full sm:w-auto">
                            <button type="submit" class="ps-8 group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-utama hover:bg-utama-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-utama">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-utama-light group-hover:text-utama-lighter" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                Ubah Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
    {{-- js --}}
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
