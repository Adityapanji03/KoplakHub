<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Akun</title>

    <script src="https://cdn.tailwindcss.com"></script>
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

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
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

    {{-- form profile --}}
    <div class="container mx-auto px-4 py-10 mt-12">
        <section class="content">
            <div class="py-6 md:py-12">
                <div class="max-w-7xl mx-auto">
                    @if (session('success'))
                        <div id="success-message" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif


                    <div class="bg-white overflow-hidden shadow-lg rounded-xl">
                        <div class="p-4 md:p-6 bg-white border-b border-gray-200">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                                <h2 class="text-2xl font-bold text-gray-800">Profil Akun</h2>

                            </div>

                            <div class="bg-gray-50 p-4 md:p-6 rounded-xl shadow-inner">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-6">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Informasi Personal</h3>
                                            <div class="mt-4 space-y-4">
                                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                                    <p class="text-sm font-medium text-gray-500">Nama Lengkap</p>
                                                    <p class="mt-1 text-base font-semibold text-gray-800">{{ $user->nama }}</p>
                                                </div>
                                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                                    <p class="text-sm font-medium text-gray-500">Username</p>
                                                    <p class="mt-1 text-base font-semibold text-gray-800">{{ $user->username }}</p>
                                                </div>
                                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                                    <p class="text-sm font-medium text-gray-500">Email</p>
                                                    <p class="mt-1 text-base font-semibold text-gray-800">{{ $user->email }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-6">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Informasi Alamat</h3>
                                            <div class="mt-4 space-y-4">
                                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                                    <p class="text-sm font-medium text-gray-500">Provinsi</p>
                                                    <p class="mt-1 text-base font-semibold text-gray-800">{{ $user->provinsi ?: 'Belum diisi' }}</p>
                                                </div>
                                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                                    <p class="text-sm font-medium text-gray-500">Kabupaten/Kota</p>
                                                    <p class="mt-1 text-base font-semibold text-gray-800">{{ $user->kabupaten_kota ?: 'Belum diisi' }}</p>
                                                </div>
                                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                                    <p class="text-sm font-medium text-gray-500">Kecamatan</p>
                                                    <p class="mt-1 text-base font-semibold text-gray-800">{{ $user->kecamatan ?: 'Belum diisi' }}</p>
                                                </div>
                                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                                    <p class="text-sm font-medium text-gray-500">Kelurahan</p>
                                                    <p class="mt-1 text-base font-semibold text-gray-800">{{ $user->kelurahan ?: 'Belum diisi' }}</p>
                                                </div>
                                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                                    <p class="text-sm font-medium text-gray-500">Detail Alamat</p>
                                                    <p class="mt-1 text-base font-semibold text-gray-800">{{ $user->detail_alamat ?: 'Belum diisi' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="justify-center flex flex-col sm:flex-row gap-3">
                                <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center px-4 py-2 bg-utama border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-wider hover:bg-orange-500 active:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-all duration-300 shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    Edit Profil
                                </a>
                                <a href="{{ route('profile.password.edit') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-wider hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-300 shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    Ubah Password
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        feather.replace();
    </script>
    {{-- notif setelah update profil --}}
    <script>
        setTimeout(function() {
            var successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 2000);
    </script>
    <!-- my js -->
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
