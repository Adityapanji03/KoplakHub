<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Koplak Food</title>
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
        .login-bg {
            background-image: url('https://assets-a1.kompasiana.com/items/album/2021/09/08/realistic-coffee-background-with-drawings-79603-603-61386bf906310e556e082ee2.jpg');
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

    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-screen-xl h-[70vh] bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="flex flex-col lg:flex-row h-full"> <div class="lg:w-1/2 login-bg hidden lg:block relative h-full"> <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center p-10">
                        <div class="text-center">
                            <h2 class="text-2xl font-bold text-koplak mb-4 animate-fade-in" style="font-family: 'Lily Script One', cursive;">KoplakFood</h2>
                            <p class="text-white text-l animate-fade-in" style="animation-delay: 0.2s;">Temukan cita rasa kopi dan jajanan autentik dalam produk kami</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-900 border-b-2 border-black lg:w-1/2 p-8 md:p-12 flex flex-col justify-center h-full"> <div class="text-center mb-8">
                        <h1 class="text-2xl font-bold text-white mb-2 animate-fade-in">Welcome back to <span class="text-koplak" style="font-family: 'Lily Script One', cursive;">KoplakHub</span></h1>
                        <p class="text-white text-l animate-fade-in" style="animation-delay: 0.1s;">Silakan masuk ke akun Anda</p>
                    </div>

                    <form action="{{ route('login.submit') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="animate-fade-in" style="animation-delay: 0.2s;">
                            <label for="username" class="block text-white mb-2 text-l">Username</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-500 text-l"></i>
                                </div>
                                <input type="text" name="username" required
                                       class="text-white form-input w-full pl-10 pr-3 py-4 rounded-lg focus:ring-2 focus:ring-koplak text-l"
                                       placeholder="Masukkan username Anda">
                            </div>
                            @error('username')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="animate-fade-in" style="animation-delay: 0.3s;">
                            <label for="password" class="block text-white mb-2 text-l">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-500 text-l"></i>
                                </div>
                                <input type="password" name="password" id="password" required
                                       class="text-white form-input w-full pl-10 pr-10 py-4 rounded-lg focus:ring-2 focus:ring-koplak text-l"
                                       placeholder="Masukkan password Anda">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                </div>
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="animate-fade-in" style="animation-delay: 0.4s;">
                            <button type="submit"
                                    class="border-b-8 border-black w-full bg-koplak hover:bg-koplak-dark text-black font-bold py-4 px-4 rounded-lg transition duration-300 flex items-center justify-center text-xl">
                                <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                            </button>
                        </div>
                    </form>

                    <div class="mt-8 text-center animate-fade-in" style="animation-delay: 0.5s;">
                        <p class="text-white text-l">Belum punya akun?
                            <a href="{{ route('regis') }}" class="text-koplak hover:text-joplak-dark hover:underline">Daftar sekarang</a>
                        </p>
                    </div>

                    <div class=" rounded-lg mt-6 text-center animate-fade-in p-3" style="animation-delay: 0.6s;">
                        <a href="{{route('home')}}" class="font-bold border-b-8 border-black inline-flex items-center text-black hover:text-gray-800 transition text-l bg-koplak rounded-lg p-3 border-b-2 border-black">
                            <i class="fas fa-home mr-2"></i> Kembali ke Beranda
                        </a>
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
                html: `Harap isi kembali`,
                confirmButtonColor: '#F57F17',
                background: '#111827',
                color: '#FFF'
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: 'Username atau password tidak terdaftar',
                confirmButtonColor: '#F57F17',
                background: '#111827',
                color: '#FFF'
            });
        @endif

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePasswordIcon');
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            toggleIcon.classList.toggle('fa-eye');
            toggleIcon.classList.toggle('fa-eye-slash');
        }
    </script>
</body>
</html>
