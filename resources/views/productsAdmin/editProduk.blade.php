@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 mt-12 p-4 sm:ml-64 bg-gray-50 min-h-screen">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <h1 class="text-2xl font-bold text-black flex items-center">
            <i class="text-yellow-500 fas fa-edit mr-3"></i> Edit Produk
        </h1>
        <a href="{{ route('productsAdmin.index') }}" class="border-b-4 border-koplak px-4 py-2 bg-black hover:bg-gray-600 text-white font-bold rounded-lg focus:ring-4 focus:ring-gray-600 flex items-center transition-all duration-200 shadow-md">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="bg-gray-800 shadow-xl rounded-xl p-6 max-w-2xl mx-auto border border-gray-700 animate-fade-in">
        <form action="{{ route('productsAdmin.update', $produk) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Product Name -->
            <div class="mb-6">
                <label for="nama_produk" class="block mb-3 text-sm font-medium text-gray-300 flex items-center">
                    <i class="fas fa-tag mr-2 text-koplak"></i> Nama Produk
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <input type="text" id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}"
                        class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-koplak focus:border-koplak block w-full pl-10 p-2.5 placeholder-gray-400"
                        placeholder="Masukkan nama produk" required>
                </div>
                @error('nama_produk')
                    <p class="mt-2 text-sm text-red-400 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Price and Stock -->
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <!-- Price -->
                <div>
                    <label for="harga_produk" class="block mb-3 text-sm font-medium text-gray-300 flex items-center">
                        <i class="fas fa-money-bill-wave mr-2 text-koplak"></i> Harga Produk
                    </label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-sm text-white bg-gray-700 border border-r-0 border-gray-600 rounded-l-lg">
                            <i class="fas fa-rp-sign"></i>
                        </span>
                        <input type="number" id="harga_produk" name="harga_produk" value="{{ old('harga_produk', $produk->harga_produk) }}"
                            class="bg-gray-700 border border-gray-600 text-white text-sm rounded-r-lg focus:ring-koplak focus:border-koplak block w-full p-2.5"
                            min="1" placeholder="0" required>
                    </div>
                    @error('harga_produk')
                        <p class="mt-2 text-sm text-red-400 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label for="stok_produk" class="block mb-3 text-sm font-medium text-gray-300 flex items-center">
                        <i class="fas fa-layer-group mr-2 text-koplak"></i> Stok Produk
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                            <i class="fas fa-cubes"></i>
                        </div>
                        <input type="number" id="stok_produk" name="stok_produk" value="{{ old('stok_produk', $produk->stok_produk) }}"
                            class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-koplak focus:border-koplak block w-full pl-10 p-2.5"
                            min="0" max="9999" placeholder="0" required>
                    </div>
                    @error('stok_produk')
                        <p class="mt-2 text-sm text-red-400 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="deskripsi_produk" class="block mb-3 text-sm font-medium text-gray-300 flex items-center">
                    <i class="fas fa-align-left mr-2 text-koplak"></i> Deskripsi Produk
                </label>
                <div class="relative">
                    <textarea id="deskripsi_produk" name="deskripsi_produk" rows="4"
                        class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-koplak focus:border-koplak block w-full p-2.5 pl-10 placeholder-gray-400"
                        placeholder="Masukkan deskripsi produk" required>{{ old('deskripsi_produk', $produk->deskripsi_produk) }}</textarea>
                    <div class="absolute top-3 left-3 text-gray-400">
                        <i class="fas fa-pen"></i>
                    </div>
                </div>
                @error('deskripsi_produk')
                    <p class="mt-2 text-sm text-red-400 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Product Image -->
            <div class="mb-8">
                <label class="block mb-3 text-sm font-medium text-gray-300 flex items-center">
                    <i class="fas fa-image mr-2 text-koplak"></i> Gambar Produk
                </label>
                <div class="mb-4 flex flex-col items-center sm:flex-row sm:items-start gap-4">
                    <div class="relative group">
                        <img src="{{ Storage::url($produk->gambar_produk) }}" alt="{{ $produk->nama_produk }}"
                            class="w-32 h-32 object-cover rounded-lg border-2 border-gray-600 group-hover:border-koplak transition-all duration-200">
                        <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg">
                            <span class="text-white text-sm font-medium"><i class="fas fa-search-plus mr-1"></i> Preview</span>
                        </div>
                    </div>
                    <div class="flex-1 w-full">
                        <div class="flex items-center justify-center w-full">
                            <label for="gambar_produk" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-600 border-dashed rounded-lg cursor-pointer bg-gray-700 hover:bg-gray-600 transition-colors duration-200">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
                                    <p class="mb-2 text-sm text-gray-400"><span class="font-semibold">Klik untuk upload</span></p>
                                    <p class="text-xs text-gray-500">JPEG, PNG atau JPG (MAX. 2MB)</p>
                                </div>
                                <input id="gambar_produk" name="gambar_produk" type="file" class="hidden" accept="image/jpeg,image/png,image/jpg">
                            </label>
                        </div>
                    </div>
                </div>
                <p class="mt-1 text-sm text-gray-400 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i> Biarkan kosong jika tidak ingin mengubah gambar.
                </p>
                @error('gambar_produk')
                    <p class="mt-2 text-sm text-red-400 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="text-gray-900 bg-koplak hover:bg-koplak-dark focus:ring-4 focus:outline-none focus:ring-koplak-darker font-medium rounded-lg text-sm px-5 py-2.5 text-center shadow-md transition-all duration-200 flex items-center">
                    <i class="fas fa-save mr-2"></i> Update Produk
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }

    #gambar_produk + label:hover {
        border-color: #FBC02D;
    }
</style>

<script>
    // Preview image
    document.getElementById('gambar_produk').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.querySelector('.group img').src = event.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
