@extends('layouts.appProfile')

@section('content')
    {{-- form profile --}}
    <div class="container mx-auto px-4 py-10 mt-14 sm:ml-64">
        <div class="container mx-auto px-4 py-8">
            <!-- Back Button -->
            <div class="mb-6 animate-fade-in">
                <a href="{{route('dashboard')}}" class="p-2 border border-b-8 border-black rounded bg-koplak font-bold inline-flex items-center text-black hover:text-black-dark transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>

            <!-- Success Message -->
            @if (session('success'))
            <div id="success-message" class="mb-6 bg-green-900 border border-green-600 text-green-100 px-4 py-3 rounded-lg animate-fade-in" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
            @endif

            <!-- Profile Card -->
            <div class="profile-card rounded-2xl overflow-hidden animate-fade-in">
                <div class="flex flex-col lg:flex-row">
                    <!-- Profile Picture Section -->
                    <div class="w-full lg:w-1/3 p-8 flex flex-col items-center justify-center bg-gradient-to-br from-koplak to-koplak-dark">
                        <div class="relative mb-6">
                            <div class="w-40 h-40 rounded-full border-4 border-white overflow-hidden shadow-xl">
                                @if($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                                    <i class="fas fa-user text-6xl text-white"></i>
                                </div>
                                @endif
                            </div>
                            <button class="absolute bottom-0 right-0 bg-koplak text-black p-2 rounded-full shadow-md hover:bg-koplak-darker transition">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                        <h2 class="text-black text-2xl font-bold text-center">{{ $user->nama }}</h2>
                        <p class="text-black mt-1">{{ '@'.$user->username }}</p>

                        <div class="mt-6 flex space-x-4">
                            <a href="{{ route('profileAdmin.edit') }}" class="px-4 py-2 bg-black bg-opacity-50 text-koplak rounded-lg font-medium hover:bg-opacity-70 transition flex items-center">
                                <i class="fas fa-edit mr-2"></i> Edit
                            </a>
                            <button id="logout-button" class="px-4 py-2 bg-red-600 bg-opacity-50 text-white rounded-lg font-medium hover:bg-opacity-70 transition flex items-center">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </div>
                    </div>

                    <!-- Profile Info Section -->
                    <div class="shadow-lg border-b-8 border-koplak bg-black w-full lg:w-2/3 p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Info -->
                            <div class="col-span-1">
                                <div class="flex items-center mb-6">
                                    <div class="h-8 w-1 bg-koplak mr-3 rounded-full"></div>
                                    <h3 class="text-white text-xl font-bold">Informasi Personal</h3>
                                </div>

                                <div class="space-y-4">
                                    <div class="info-card border-white border p-4 rounded-lg">
                                        <p class="text-sm text-white flex items-center">
                                            <i class="fas fa-user mr-2"></i> Nama Lengkap
                                        </p>
                                        <p class="text-white mt-1 font-semibold">{{ $user->nama }}</p>
                                    </div>

                                    <div class="info-card border-white border p-4 rounded-lg">
                                        <p class="text-sm text-white flex items-center">
                                            <i class="fas fa-at mr-2"></i> Username
                                        </p>
                                        <p class="text-white mt-1 font-semibold">{{ '@'.$user->username }}</p>
                                    </div>

                                    <div class="info-card border-white border p-4 rounded-lg">
                                        <p class="text-sm text-white flex items-center">
                                            <i class="fas fa-phone mr-2"></i> Nomor HP
                                        </p>
                                        <p class="text-white mt-1 font-semibold">{{ $user->nomor_hp ?: '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Address Info -->
                            <div class="col-span-1">
                                <div class="flex items-center mb-6">
                                    <div class="h-8 w-1 bg-koplak mr-3 rounded-full"></div>
                                    <h3 class="text-white text-xl font-bold">Informasi Alamat</h3>
                                </div>

                                <div class="space-y-4">
                                    <div class="info-card border-white border p-4 rounded-lg">
                                        <p class="text-sm text-white flex items-center">
                                            <i class="fas fa-map-marker-alt mr-2"></i> Alamat Lengkap
                                        </p>
                                        <p class="text-white mt-1 font-semibold">
                                            {{ $user->detail_alamat ?: 'Belum diisi' }}
                                        </p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="info-card border-white border p-4 rounded-lg">
                                            <p class="text-sm text-white">Provinsi</p>
                                            <p class="text-white mt-1 font-semibold">{{ $user->provinsi ?: '-' }}</p>
                                        </div>
                                        <div class="info-card border-white border p-4 rounded-lg">
                                            <p class="text-sm text-white">Kota/Kab</p>
                                            <p class="text-white mt-1 font-semibold">{{ $user->kabupaten_kota ?: '-' }}</p>
                                        </div>
                                        <div class="info-card border-white border p-4 rounded-lg">
                                            <p class="text-sm text-white">Kecamatan</p>
                                            <p class="text-white mt-1 font-semibold">{{ $user->kecamatan ?: '-' }}</p>
                                        </div>
                                        <div class="info-card border-white border p-4 rounded-lg">
                                            <p class="text-sm text-white">Kelurahan</p>
                                            <p class="text-white mt-1 font-semibold">{{ $user->kelurahan ?: '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- my js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
@endsection
