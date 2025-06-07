<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Koplak Food</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Lily+Script+One&family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
        .register-bg {
            background-image: url('https://d1r9hss9q19p18.cloudfront.net/uploads/2017/04/2017-04-15-04.41.12-1-1.jpg');
            background-size: cover;
            background-position: center;
        }
        .form-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            transition: all 0.3s ease;
        }
        .form-input:focus {
            background: rgba(255, 255, 255, 0.3);
            border-color: #FBC02D;
            box-shadow: 0 0 0 2px rgba(251, 192, 45, 0.3);
        }
        .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }
        .form-select:focus {
            border-color: #FBC02D;
            box-shadow: 0 0 0 2px rgba(251, 192, 45, 0.3);
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
                        'dark': '#111827',
                        'darker': '#0D1321'
                    },
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                        'poppins': ['Poppins', 'sans-serif'],
                        'lily': ['"Lily Script One"', 'cursive']
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.6s ease-out forwards',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white font-poppins">

    <!-- Registration Section -->
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-6xl bg-gray-900 rounded-2xl shadow-xl overflow-hidden border border-gray-800">
            <div class="flex flex-col lg:flex-row">
                <!-- Image Section -->
                <div class="lg:w-1/2 register-bg hidden lg:block relative">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center p-10">
                        <div class="text-center">
                            <h2 class="text-4xl font-bold text-koplak mb-4 animate-fade-in" style="font-family: 'Lily Script One', cursive;">KoplakFood</h2>
                            <p class="text-gray-300 text-lg animate-fade-in" style="animation-delay: 0.2s;">Bergabunglah dengan pecinta kopi lain, dan rasakan kenikmatan kopi khas kami</p>
                            <div class="mt-8 space-y-4 text-left animate-fade-in" style="animation-delay: 0.4s;">
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-koplak mt-1 mr-3"></i>
                                    <span class="text-gray-300">Akses ke produk sangat mudah</span>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-koplak mt-1 mr-3"></i>
                                    <span class="text-gray-300">Proses pemesanan lebih cepat</span>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-koplak mt-1 mr-3"></i>
                                    <span class="text-gray-300">Riwayat pesanan lengkap</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Section -->
                <div class="lg:w-1/2 p-8 md:p-12">
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold text-white mb-2 animate-fade-in">Daftar Akun <span class="text-koplak" style="font-family: 'Lily Script One', cursive;">KoplakHub</span></h1>
                        <p class="text-gray-400 animate-fade-in" style="animation-delay: 0.1s;">Bergabunglah dengan kami sekarang</p>
                    </div>

                    <form id="registrationForm" method="POST" action="{{ route('register.submit') }}" class="space-y-5">
                        @csrf
                        <!-- Personal Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="animate-fade-in" style="animation-delay: 0.2s;">
                                <label for="nama" class="block text-gray-300 mb-2">Nama Lengkap</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-500"></i>
                                    </div>
                                    <input type="text" id="nama" name="nama" required
                                           class="form-input w-full pl-10 pr-3 py-3 rounded-lg"
                                           placeholder="Masukkan nama lengkap">
                                </div>
                                @error('nama')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="animate-fade-in" style="animation-delay: 0.3s;">
                                <label for="username" class="block text-gray-300 mb-2">Username</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-at text-gray-500"></i>
                                    </div>
                                    <input type="text" id="username" name="username" required
                                           class="form-input w-full pl-10 pr-3 py-3 rounded-lg"
                                           placeholder="Buat username">
                                </div>
                                @error('username')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="animate-fade-in" style="animation-delay: 0.4s;">
                            <label for="nomor_hp" class="block text-gray-300 mb-2">Nomor HP</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-gray-500"></i>
                                </div>
                                <input type="text" id="nomor_hp" name="nomor_hp" required
                                       class="form-input w-full pl-10 pr-3 py-3 rounded-lg"
                                       placeholder="Contoh: 081234567890">
                            </div>
                            @error('nomor_hp')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="animate-fade-in" style="animation-delay: 0.5s;">
                                <label for="password" class="block text-gray-300 mb-2">Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-500"></i>
                                    </div>
                                    <input type="password" id="password" name="password" required
                                           class="form-input w-full pl-10 pr-4 py-3 rounded-lg"
                                           placeholder="Buat password">
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="animate-fade-in" style="animation-delay: 0.6s;">
                                <label for="confirmPassword" class="block text-gray-300 mb-2">Konfirmasi Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-500"></i>
                                    </div>
                                    <input type="password" id="confirmPassword" name="confirmPassword" required
                                           class="form-input w-full pl-10 pr-4 py-3 rounded-lg"
                                           placeholder="Ulangi password">
                                </div>
                                @error('confirmPassword')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="animate-fade-in" style="animation-delay: 0.7s;">
                            <h3 class="text-lg font-medium text-gray-200 mb-4 flex items-center">
                                <i class="fas fa-map-marker-alt mr-2 text-koplak"></i>
                                Alamat Lengkap
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="provinsi" class="block text-gray-300 mb-2">Provinsi</label>
                                    <input type="hidden" id="provinsi_nama" name="provinsi">
                                    <select id="provinsi" class="form-select w-full py-3 rounded-lg bg-darker border border-gray-600 text-gray-200">
                                        <option value="">Memuat Provinsi...</option>
                                    </select>
                                    @error('provinsi')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="kabupatenKota" class="block text-gray-300 mb-2">Kabupaten/Kota</label>
                                    <input type="hidden" id="kabupatenKota_nama" name="kabupatenKota">
                                    <select id="kabupatenKota" class="form-select w-full py-3 rounded-lg bg-darker border border-gray-600 text-gray-200">
                                        <option value="">Pilih Kabupaten/Kota</option>
                                    </select>
                                    @error('kabupatenKota')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="kecamatan" class="block text-gray-300 mb-2">Kecamatan</label>
                                    <input type="hidden" id="kecamatan_nama" name="kecamatan">
                                    <select id="kecamatan" class="form-select w-full py-3 rounded-lg bg-darker border border-gray-600 text-gray-200">
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                    @error('kecamatan')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="kelurahan" class="block text-gray-300 mb-2">Kelurahan</label>
                                    <input type="hidden" id="kelurahan_nama" name="kelurahan">
                                    <select id="kelurahan" class="form-select w-full py-3 rounded-lg bg-darker border border-gray-600 text-gray-200">
                                        <option value="">Pilih Kelurahan</option>
                                    </select>
                                    @error('kelurahan')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-5">
                                <label for="detailAlamat" class="block text-gray-300 mb-2">Detail Alamat</label>
                                <textarea id="detailAlamat" name="detailAlamat" rows="3"
                                          class="form-input w-full py-3 rounded-lg"
                                          placeholder="Contoh: Jalan Merdeka No. 10, RT 05/RW 02"></textarea>
                                @error('detailAlamat')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex flex-col sm:flex-row justify-between gap-4 pt-6">
                            <a href="{{ route('index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-gray-800 text-gray-300 rounded-lg hover:bg-gray-700 transition">
                                <i class="fas fa-arrow-left mr-2"></i> Kembali
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center justify-center px-6 py-3 bg-koplak text-black font-bold rounded-lg hover:bg-koplak-dark transition">
                                <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-6 text-gray-400">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-koplak hover:text-koplak-dark hover:underline">Masuk disini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Valid',
                html: `Harap periksa kembali data yang dimasukkan`,
                confirmButtonColor: '#F57F17',
                background: '#111827',
                color: '#FFF'
            });
        @elseif(session('success_swal'))
            Swal.fire({
                title: 'Pendaftaran Berhasil!',
                text: '{{ session('success_swal') }}',
                icon: 'success',
                confirmButtonColor: '#F57F17',
                background: '#111827',
                color: '#FFF'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                }
            });
        @endif

        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleIcon = document.getElementById(`toggle${fieldId === 'password' ? 'Password' : 'ConfirmPassword'}Icon`);
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            toggleIcon.classList.toggle('fa-eye');
            toggleIcon.classList.toggle('fa-eye-slash');
        }

        // Animation for elements
        document.querySelectorAll('.animate-fade-in').forEach((el, index) => {
            el.style.animationDelay = `${index * 0.1}s`;
        });
    </script>

    <!-- Address Selector Script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/login_regis.js') }}"></script>
</body>
</html>
