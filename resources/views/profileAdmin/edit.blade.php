@extends('layouts.appProfile')

@section('content')
    <div class="container mx-auto px-4 py-10 mt-14 sm:ml-64">
        <div class="container mx-auto px-4 py-8">
            <!-- Back Button -->
            <div class="mb-6 animate-fade-in">
                <a href="{{ route('profileAdmin.show') }}" class="p-2 border border-b-8 border-black rounded bg-koplak font-bold inline-flex items-center text-black hover:text-black-dark transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke profil
                </a>
            </div>

            <!-- Profile Card -->
            <div class="profile-card rounded-2xl overflow-hidden animate-fade-in">
                <div class="flex flex-col lg:flex-row">
                    <!-- Profile Picture Section -->
                    <div class="w-full lg:w-1/3 p-8 flex flex-col items-center justify-center bg-gradient-to-br from-koplak-dark to-koplak">
                        <div class="relative mb-6">
                            <div class="w-40 h-40 rounded-full border-4 border-white overflow-hidden shadow-xl">
                                @if($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                                    <i class="fas fa-user text-6xl text-gray-400"></i>
                                </div>
                                @endif
                            </div>
                            <button type="button" class="absolute bottom-0 right-0 bg-koplak text-black p-2 rounded-full shadow-md hover:bg-koplak-darker transition">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                        <h2 class="text-black text-2xl font-bold text-center">{{ $user->nama }}</h2>
                        <p class="text-black mt-1">{{ '@'.$user->username }}</p>
                    </div>

                    <!-- Edit Form Section -->
                    <div class="bg-black w-full lg:w-2/3 p-8">
                        <form action="{{ route('profileAdmin.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Hidden file input for profile photo -->
                            <input type="file" id="profile-photo-input" name="profile_photo" class="hidden" accept="image/*">

                            <!-- Personal Info -->
                            <div>
                                <div class="flex items-center mb-6">
                                    <div class="h-8 w-1 bg-koplak mr-3 rounded-full"></div>
                                    <h3 class="text-xl text-white font-bold">Informasi Personal</h3>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="nama" class="block text-sm font-medium text-gray-300 mb-2">Nama Lengkap</label>
                                        <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}"
                                               class="form-input text-white bg-gray-800 block w-full rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-koplak">
                                        @error('nama')
                                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="username" class="block text-sm font-medium text-gray-300 mb-2">Username</label>
                                        <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
                                               class="form-input text-white bg-gray-800 block w-full rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-koplak">
                                        @error('username')
                                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="md:col-span-2">
                                        <label for="nomor_hp" class="block text-sm font-medium text-gray-300 mb-2">Nomor HP</label>
                                        <input type="text" name="nomor_hp" id="nomor_hp" value="{{ old('nomor_hp', $user->nomor_hp) }}"
                                               class="form-input text-white bg-gray-800 block w-full rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-koplak">
                                        @error('nomor_hp')
                                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Change Password -->
                            <div>
                                <div class="flex items-center mb-6">
                                    <div class="h-8 w-1 bg-koplak mr-3 rounded-full"></div>
                                    <h3 class="text-xl text-white font-bold">Ubah Password</h3>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="md:col-span-2">
                                        <label for="current_password" class="block text-sm font-medium text-gray-300 mb-2">Password Saat Ini</label>
                                        <input type="password" name="current_password" id="current_password"
                                               class="form-input text-white bg-gray-800 block w-full rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-koplak">
                                        @error('current_password')
                                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password Baru</label>
                                        <input type="password" name="password" id="password"
                                               class="form-input text-white bg-gray-800 block w-full rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-koplak">
                                        @error('password')
                                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                               class="form-input text-white bg-gray-800 block w-full rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-koplak">
                                    </div>
                                </div>
                            </div>

                            <!-- Address Info -->
                            <div>
                                <div class="flex items-center mb-6">
                                    <div class="h-8 w-1 bg-koplak mr-3 rounded-full"></div>
                                    <h3 class="text-xl text-white font-bold">Informasi Alamat</h3>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="provinsi" class="block text-sm font-medium text-gray-300 mb-2">Provinsi</label>
                                        <input type="hidden" id="provinsi_nama" name="provinsi" value="{{ old('provinsi', $user->provinsi) }}">
                                        <select id="provinsi" class="form-select block w-full rounded-lg py-2.5 px-4 pr-10 bg-darker border border-gray-600 text-gray-200 focus:ring-2 focus:ring-koplak focus:border-transparent">
                                            <option value="" class="bg-darker">Memuat Provinsi...</option>
                                        </select>
                                        @error('provinsi')
                                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="kabupatenKota" class="block text-sm font-medium text-gray-300 mb-2">Kabupaten/Kota</label>
                                        <input type="hidden" id="kabupatenKota_nama" name="kabupaten_kota" value="{{ old('kabupaten_kota', $user->kabupaten_kota) }}">
                                        <select id="kabupatenKota" class="form-select block w-full rounded-lg py-2.5 px-4 pr-10 bg-darker border border-gray-600 text-gray-200 focus:ring-2 focus:ring-koplak focus:border-transparent">
                                            <option value="" class="bg-darker">Pilih Kabupaten/Kota</option>
                                        </select>
                                        @error('kabupaten_kota')
                                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="kecamatan" class="block text-sm font-medium text-gray-300 mb-2">Kecamatan</label>
                                        <input type="hidden" id="kecamatan_nama" name="kecamatan" value="{{ old('kecamatan', $user->kecamatan) }}">
                                        <select id="kecamatan" class="form-select block w-full rounded-lg py-2.5 px-4 pr-10 bg-darker border border-gray-600 text-gray-200 focus:ring-2 focus:ring-koplak focus:border-transparent">
                                            <option value="" class="bg-darker">Pilih Kecamatan</option>
                                        </select>
                                        @error('kecamatan')
                                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="kelurahan" class="block text-sm font-medium text-gray-300 mb-2">Kelurahan</label>
                                        <input type="hidden" id="kelurahan_nama" name="kelurahan" value="{{ old('kelurahan', $user->kelurahan) }}">
                                        <select id="kelurahan" class="form-select block w-full rounded-lg py-2.5 px-4 pr-10 bg-darker border border-gray-600 text-gray-200 focus:ring-2 focus:ring-koplak focus:border-transparent">
                                            <option value="" class="bg-darker">Pilih Kelurahan</option>
                                        </select>
                                        @error('kelurahan')
                                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="md:col-span-2">
                                        <label for="detail_alamat" class="block text-sm font-medium text-gray-300 mb-2">Detail Alamat</label>
                                        <textarea name="detail_alamat" id="detail_alamat" rows="3"
                                                class="form-input bg-gray-800 block w-full rounded-lg py-2.5 px-4 bg-darker border border-gray-600 text-gray-200 focus:ring-2 focus:ring-koplak focus:border-transparent">{{ old('detail_alamat', $user->detail_alamat) }}</textarea>
                                        @error('detail_alamat')
                                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex justify-end pt-6">
                                <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-koplak text-black font-semibold rounded-lg hover:bg-koplak-dark transition shadow-md">
                                    <i class="fas fa-save mr-2"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- SweetAlert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- JavaScript -->
        <script>

            // SweetAlert for errors
            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Data Tidak Valid',
                    html: `Harap periksa kembali data yang dimasukkan`,
                    confirmButtonColor: '#F57F17',
                    background: '#111827',
                    color: '#FFF'
                });
            @elseif (session()->has('success_once'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success_once') }}',
                    icon: 'success',
                    confirmButtonColor: '#F57F17',
                    background: '#111827',
                    color: '#FFF'
                }).then(() => {
                    window.location.href = "{{ route('profileAdmin.show') }}";
                });
            @endif

            // Animation for form elements
            document.querySelectorAll('input, select, textarea').forEach((el, index) => {
                el.style.animationDelay = `${index * 0.05}s`;
                el.classList.add('animate-fade-in');
            });
        </script>
    <!-- my js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/editprofile.js') }}"></script>
    <style>
        .form-input {
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
@endsection
