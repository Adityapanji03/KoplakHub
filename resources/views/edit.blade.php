<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <!-- Tailwind CSS 4.1 -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        utama: '#FFA75B',
                        primary: '#FFA75B',
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                        'lily': ['"Lily Script One"', 'cursive']
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
<body class="bg-gray-100 font-poppins">
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
            <a href="#products">Products</a>
            <a href="#forum">Forum</a>
            @auth
                <a href="{{ route('logout') }}">Logout</a>
            @else
            @endauth
        </div>

        <div class="navbar-extra">
            @auth
                <a href="{{ route('profile.show') }}" id="akun"><i data-feather="user" style="display:inline-block;"></i></a>
            @else
                <a href="profile.php" id="akun" style="display:none;"><i data-feather="user"></i></a>
            @endauth

            <a href="#" id="keranjang"><i data-feather="shopping-cart" style="display:inline-block;"></i></a>
            <a href="#" id="menu"><i data-feather="menu" style="display:inline-block;"></i></a>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-10 mt-12">
        <section class="content">
            <div class="py-6 md:py-12">
                <div class="max-w-7xl mx-auto">
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl">
                        <div class="p-4 md:p-6 bg-white border-b border-gray-200">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                                <h2 class="text-2xl font-bold text-gray-800">Edit Profil</h2>
                            </div>

                            <form action="{{ route('profile.update') }}" method="POST" class="space-y-8">
                                @csrf
                                @method('PUT')

                                <div class="bg-gray-50 p-4 md:p-6 rounded-xl shadow-inner">
                                    <h3 class="text-lg font-medium text-gray-800 border-b border-gray-200 pb-3 mb-6">Informasi Personal</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                            <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}"
                                                class="block w-full rounded-lg border-gray-300 shadow-sm py-2.5 px-4
                                                focus:ring-2 focus:ring-primary focus:border-primary
                                                transition-all duration-300">
                                            @error('nama')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                            <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
                                                class="block w-full rounded-lg border-gray-300 shadow-sm py-2.5 px-4
                                                focus:ring-2 focus:ring-primary focus:border-primary
                                                transition-all duration-300">
                                            @error('username')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="md:col-span-2">
                                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                                class="block w-full rounded-lg border-gray-300 shadow-sm py-2.5 px-4
                                                focus:ring-2 focus:ring-primary focus:border-primary
                                                transition-all duration-300">
                                            @error('email')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-4 md:p-6 rounded-xl shadow-inner">
                                    <h3 class="text-lg font-medium text-gray-800 border-b border-gray-200 pb-3 mb-6">Informasi Alamat</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="provinsi" class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                                            <input type="text" name="provinsi" id="provinsi" value="{{ old('provinsi', $user->provinsi) }}"
                                                class="block w-full rounded-lg border-gray-300 shadow-sm py-2.5 px-4
                                                focus:ring-2 focus:ring-primary focus:border-primary
                                                transition-all duration-300">
                                            @error('provinsi')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="kabupaten_kota" class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/Kota</label>
                                            <input type="text" name="kabupaten_kota" id="kabupaten_kota" value="{{ old('kabupaten_kota', $user->kabupaten_kota) }}"
                                                class="block w-full rounded-lg border-gray-300 shadow-sm py-2.5 px-4
                                                focus:ring-2 focus:ring-primary focus:border-primary
                                                transition-all duration-300">
                                            @error('kabupaten_kota')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                                            <input type="text" name="kecamatan" id="kecamatan" value="{{ old('kecamatan', $user->kecamatan) }}"
                                                class="block w-full rounded-lg border-gray-300 shadow-sm py-2.5 px-4
                                                focus:ring-2 focus:ring-primary focus:border-primary
                                                transition-all duration-300">
                                            @error('kecamatan')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="kelurahan" class="block text-sm font-medium text-gray-700 mb-1">Kelurahan</label>
                                            <input type="text" name="kelurahan" id="kelurahan" value="{{ old('kelurahan', $user->kelurahan) }}"
                                                class="block w-full rounded-lg border-gray-300 shadow-sm py-2.5 px-4
                                                focus:ring-2 focus:ring-primary focus:border-primary
                                                transition-all duration-300">
                                            @error('kelurahan')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="md:col-span-2">
                                            <label for="detail_alamat" class="block text-sm font-medium text-gray-700 mb-1">Detail Alamat</label>
                                            <textarea name="detail_alamat" id="detail_alamat" rows="3"
                                                class="block w-full rounded-lg border-gray-300 shadow-sm py-2.5 px-4
                                                focus:ring-2 focus:ring-primary focus:border-primary
                                                transition-all duration-300">{{ old('detail_alamat', $user->detail_alamat) }}</textarea>
                                            @error('detail_alamat')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-between">
                                    <div>
                                        <a href="{{ route('profile.show') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-wider hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-all duration-300 shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                            </svg>
                                            Kembali
                                        </a>
                                    </div>
                                    <div>
                                        <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-primary border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-wider hover:bg-amber-500 active:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-all duration-300 shadow-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        feather.replace();
    </script>
    <!-- my js -->
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
