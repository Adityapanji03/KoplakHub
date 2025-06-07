<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Akun</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'koplak': '#FFEB3B',
                        'koplak-dark': '#FBC02D',
                        'koplak-darker': '#F57F17',
                        'koplak-light': 'rgba(255, 235, 59, 0.1)',
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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .gradient-bg {
            background: linear-gradient(135deg, #FFEB3B 0%, #0D1321 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .profile-photo-container {
            position: relative;
            overflow: hidden;
        }

        .profile-photo-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .profile-photo-container:hover .profile-photo-overlay {
            opacity: 1;
        }

        .btn-koplak {
            background: linear-gradient(135deg, #ffee00 0%, rgb(232, 225, 25) 100%);
            transition: all 0.3s ease;
        }

        .btn-koplak:hover {
            background: linear-gradient(135deg, #FFEB3B 0%, #efef01 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(168, 19, 19, 0.3);
        }

        .btn-black {
            background: linear-gradient(135deg, #ec0707 0%, #b30000 100%);
            transition: all 0.3s ease;
        }

        .btn-black:hover {
            background: linear-gradient(135deg, #720000 0%, #540000 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .info-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .info-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-100 font-montserrat">

    <!-- Header dengan Gradient -->
    <div class="gradient-bg h-32 md:h-40 relative">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative z-10 container mx-auto px-4 py-6">
            <!-- Back Button -->
            <a href="{{ route('home') }}" class="rounded-lg border-b-4 border-koplak py-2 px-4 bg-black inline-flex items-center text-white hover:text-koplak transition-colors duration-300 font-semibold">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="hidden sm:inline">Kembali ke Home</span>
                <span class="sm:hidden">Kembali</span>
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if (session('success'))
    <div id="success-message" class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg animate-slide-up">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <div class="container mx-auto px-4 -mt-16 md:-mt-20 relative z-20 pb-8">
        <!-- Profile Card -->
        <div class="bg-gray-50 glass-card rounded-2xl shadow-2xl overflow-hidden animate-scale-in">
            <!-- Profile Header -->
            <div class="p-6 md:p-8 text-center border-b border-gray-200">
                <div class="relative inline-block mb-4">
                    <!-- Profile Photo -->
                    <div class="w-24 h-24 md:w-32 md:h-32 rounded-full overflow-hidden border-4 border-black shadow-lg profile-photo-container mx-auto">
                        @if($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                            <i class="fas fa-user text-4xl text-gray-400"></i>
                        </div>
                        @endif
                        <div class="profile-photo-overlay">
                            <button class="text-white text-sm">
                                <i class="fas fa-camera text-lg"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Online Indicator -->
                    <div class="absolute bottom-1 right-1 w-6 h-6 bg-green-500 rounded-full border-3 border-white"></div>
                </div>

                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-1">{{ $user->nama }}</h1>
                <p class="text-gray-600 mb-1">{{ $user->email }}</p>
                <p class="text-sm text-gray-600">Member sejak {{ $user->created_at->format('Y') }}</p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 mt-6 justify-center">
                    <a href="{{ route('profile.edit') }}" class="btn-koplak text-white px-6 py-3 rounded-xl font-semibold inline-flex items-center justify-center">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Profil
                    </a>
                    <button id="logout-btn" class="btn-black text-white px-6 py-3 rounded-xl font-semibold inline-flex items-center justify-center">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </button>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="p-6 md:p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Personal Information -->
                    <div class="space-y-4 animate-fade-in">
                        <div class="flex items-center mb-6">
                            <div class="w-1 h-8 bg-koplak rounded-full mr-3"></div>
                            <h2 class="text-xl font-bold text-gray-900">Informasi Personal</h2>
                        </div>

                        <div class="info-item bg-gray-800 p-4 rounded-xl border border-gray-200 shadow-sm">
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-koplak-light rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-user text-koplak"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-300">Nama Lengkap</p>
                                    <p class="text-lg font-semibold text-gray-50 truncate">{{ $user->nama }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="info-item bg-gray-800 p-4 rounded-xl border border-gray-200 shadow-sm">
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-koplak-light rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-at text-koplak"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-300">Username</p>
                                    <p class="text-lg font-semibold text-gray-50 truncate">{{ '@'.$user->username }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="info-item bg-gray-800 p-4 rounded-xl border border-gray-200 shadow-sm">
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-koplak-light rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-phone text-koplak"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-300">Nomor HP</p>
                                    <p class="text-lg font-semibold text-gray-50 truncate">{{ $user->nomor_hp ?? 'Belum diatur' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="space-y-4 animate-fade-in" style="animation-delay: 0.2s;">
                        <div class="flex items-center mb-6">
                            <div class="w-1 h-8 bg-koplak rounded-full mr-3"></div>
                            <h2 class="text-xl font-bold text-gray-900">Informasi Alamat</h2>
                        </div>

                        <div class="info-item bg-gray-800 p-4 rounded-xl border border-gray-200 shadow-sm">
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-koplak-light rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-koplak"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-300">Detail Alamat</p>
                                    <p class="text-lg font-semibold text-gray-50">
                                        {{ $user->detail_alamat ?? 'Belum diatur' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="info-item bg-gray-800 p-4 rounded-xl border border-gray-200 shadow-sm">
                                <div class="flex items-start">
                                    <div class="w-10 h-10 bg-koplak-light rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                        <i class="fas fa-map text-koplak"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-300">Provinsi</p>
                                        <p class="text-lg font-semibold text-gray-50 truncate">{{ $user->provinsi ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="info-item bg-gray-800 p-4 rounded-xl border border-gray-200 shadow-sm">
                                <div class="flex items-start">
                                    <div class="w-10 h-10 bg-koplak-light rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                        <i class="fas fa-city text-koplak"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-300">Kota/Kab</p>
                                        <p class="text-lg font-semibold text-gray-50 truncate">{{ $user->kabupaten_kota ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="info-item bg-gray-800 p-4 rounded-xl border border-gray-200 shadow-sm">
                                <div class="flex items-start">
                                    <div class="w-10 h-10 bg-koplak-light rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                        <i class="fas fa-map-marked-alt text-koplak"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-300">Kecamatan</p>
                                        <p class="text-lg font-semibold text-gray-50 truncate">{{ $user->kecamatan ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="info-item bg-gray-800 p-4 rounded-xl border border-gray-200 shadow-sm">
                                <div class="flex items-start">
                                    <div class="w-10 h-10 bg-koplak-light rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                        <i class="fas fa-map-pin text-koplak"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-300">Kelurahan</p>
                                        <p class="text-lg font-semibold text-gray-50 truncate">{{ $user->kelurahan ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        // Auto-hide success message
        setTimeout(function() {
            var successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.opacity = '0';
                setTimeout(() => successMessage.remove(), 300);
            }
        }, 3000);

        // SweetAlert for logout confirmation
        document.getElementById('logout-btn').addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Logout?',
                text: "Anda yakin ingin keluar dari akun ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#A41313',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl',
                    confirmButton: 'rounded-xl px-6 py-3 font-semibold',
                    cancelButton: 'rounded-xl px-6 py-3 font-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        });

        // Animation for info items
        document.querySelectorAll('.info-item').forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.animation = `fadeIn 0.6s ease-out ${index * 0.1}s forwards`;
        });
    </script>
</body>
</html>
