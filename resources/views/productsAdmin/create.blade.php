@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 mt-14 sm:ml-64 font-montserrat">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-black flex items-center">
                <i class="fas fa-cube mr-3 text-yellow-500"></i>
                Tambah Produk Baru
            </h1>
            <p class="text-black mt-2">Lengkapi form berikut untuk menambahkan produk baru</p>
        </div>
        <a href="{{ route('productsAdmin.index') }}" class="border-b-4 border-koplak px-5 py-2.5 bg-black text-white font-bold rounded-lg hover:bg-gray-600 focus:ring-4 focus:ring-gray-200 transition-all duration-200 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <!-- Form Container -->
    <div class="border-b-8 border-r-4 border-koplak bg-gray-800 shadow-xl rounded-xl p-6 max-w-3xl mx-auto">
        <form action="{{ route('productsAdmin.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Product Name -->
            <div>
                <label for="nama_produk" class="block mb-2 text-sm font-medium text-gray-300 flex items-center">
                    <i class="fas fa-tag mr-2 text-koplak"></i>Nama Produk
                </label>
                <div class="relative">
                    <input type="text" id="nama_produk" name="nama_produk" value="{{ old('nama_produk') }}"
                           class="bg-gray-700 border border-gray-600 text-gray-100 text-sm rounded-lg focus:ring-koplak focus:border-koplak block w-full p-3 pl-10 placeholder-gray-200"
                           placeholder="Masukkan nama produk" required>
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-pen text-gray-200"></i>
                    </div>
                </div>
                @error('nama_produk')
                    <p class="mt-2 text-sm text-red-400 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Price and Stock -->
            <div class="grid gap-6 md:grid-cols-2">
                <!-- Price -->
                <div>
                    <label for="harga_produk" class="block mb-2 text-sm font-medium text-gray-300 flex items-center">
                        <i class="fas fa-money-bill-wave mr-2 text-koplak"></i>Harga Produk
                    </label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-sm text-gray-100 bg-gray-700 border border-r-0 border-gray-600 rounded-l-md">
                            Rp
                        </span>
                        <input type="number" id="harga_produk" name="harga_produk" value="{{ old('harga_produk') }}"
                               class="bg-gray-700 border border-gray-600 text-gray-100 text-sm rounded-r-lg focus:ring-koplak focus:border-koplak block w-full p-3"
                               min="1" placeholder="0" required>
                    </div>
                    @error('harga_produk')
                        <p class="mt-2 text-sm text-red-400 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label for="stok_produk" class="block mb-2 text-sm font-medium text-gray-300 flex items-center">
                        <i class="fas fa-boxes mr-2 text-koplak"></i>Stok Produk
                    </label>
                    <div class="relative">
                        <input type="number" id="stok_produk" name="stok_produk" value="{{ old('stok_produk') }}"
                               class="bg-gray-700 border border-gray-600 text-gray-100 text-sm rounded-lg focus:ring-koplak focus:border-koplak block w-full p-3 pl-10"
                               min="0" max="9999" placeholder="0" required>
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-hashtag text-gray-200"></i>
                        </div>
                    </div>
                    @error('stok_produk')
                        <p class="mt-2 text-sm text-red-400 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="deskripsi_produk" class="block mb-2 text-sm font-medium text-gray-300 flex items-center">
                    <i class="fas fa-align-left mr-2 text-koplak"></i>Deskripsi Produk
                </label>
                <textarea id="deskripsi_produk" name="deskripsi_produk" rows="4"
                          class="bg-gray-700 border border-gray-600 text-gray-100 text-sm rounded-lg focus:ring-koplak focus:border-koplak block w-full p-3 placeholder-gray-200"
                          placeholder="Masukkan deskripsi produk..." required>{{ old('deskripsi_produk') }}</textarea>
                @error('deskripsi_produk')
                    <p class="mt-2 text-sm text-red-400 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Image Upload -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-300 flex items-center">
                    <i class="fas fa-image mr-2 text-koplak"></i>Gambar Produk
                </label>

                <!-- File Upload -->
                <div class="flex items-center justify-center w-full">
                    <label for="image_input" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-600 border-dashed rounded-lg cursor-pointer bg-gray-700 hover:bg-gray-700/50 transition-colors duration-200">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
                            <p class="mb-2 text-sm text-gray-400"><span class="font-semibold">Klik untuk upload</span> atau drag & drop</p>
                            <p class="text-xs text-gray-200">JPEG, PNG atau JPG (MAX. 2MB)</p>
                        </div>
                        <input id="image_input" name="gambar_produk" type="file" class="hidden" accept="image/jpeg,image/png,image/jpg">
                    </label>
                </div>
                @error('gambar_produk')
                    <p class="mt-2 text-sm text-red-400 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror

                <!-- Image Preview and Cropping Area -->
                <div class="mt-4 hidden" id="image_preview_container">
                    <div class="mb-4 relative">
                        <img id="image_preview" class="max-w-full max-h-64 rounded-lg mx-auto" src="#" alt="Preview Gambar Produk" style="display: none;">
                    </div>
                    <div class="flex justify-center gap-3 hidden" id="crop_controls">
                        <button type="button" id="crop_button" class="px-4 py-2 bg-koplak text-gray-900 font-medium rounded-lg hover:bg-koplak-dark focus:outline-none focus:ring-2 focus:ring-koplak-darker transition-colors duration-200 flex items-center">
                            <i class="fas fa-crop mr-2"></i>Crop Gambar
                        </button>
                        <button type="button" id="cancel_crop" class="px-4 py-2 bg-gray-600 text-gray-100 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-colors duration-200 flex items-center">
                            <i class="fas fa-times mr-2"></i>Batal
                        </button>
                    </div>
                    <input type="hidden" id="cropped_image_data" name="cropped_image">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit" class="w-full sm:w-auto px-5 py-3 bg-koplak text-gray-900 font-medium rounded-lg hover:bg-koplak-dark focus:ring-4 focus:outline-none focus:ring-koplak-darker transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i>Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image_input');
    const imagePreview = document.getElementById('image_preview');
    const imagePreviewContainer = document.getElementById('image_preview_container');
    const cropControls = document.getElementById('crop_controls');
    const cropButton = document.getElementById('crop_button');
    const cancelCrop = document.getElementById('cancel_crop');
    const croppedImageData = document.getElementById('cropped_image_data');

    let cropper;

    imageInput.addEventListener('change', function(e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            const file = files[0];
            const reader = new FileReader();

            reader.onload = function(event) {
                imagePreview.src = event.target.result;
                imagePreview.style.display = 'block';
                imagePreviewContainer.classList.remove('hidden');

                if (cropper) {
                    cropper.destroy();
                }

                cropper = new Cropper(imagePreview, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 0.8,
                    responsive: true,
                    guides: true,
                    background: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true
                });

                cropControls.classList.remove('hidden');
            };

            reader.readAsDataURL(file);
        }
    });

    cropButton.addEventListener('click', function() {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas({
                width: 800,
                height: 800,
                minWidth: 256,
                minHeight: 256,
                maxWidth: 2000,
                maxHeight: 2000,
                fillColor: 'transparent',
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            if (canvas) {
                canvas.toBlob(function(blob) {
                    const file = new File([blob], imageInput.files[0].name, {
                        type: 'image/jpeg',
                        lastModified: Date.now()
                    });

                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);

                    imageInput.files = dataTransfer.files;

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        croppedImageData.value = e.target.result;
                    };
                    reader.readAsDataURL(blob);

                    // Hide crop controls
                    cropControls.classList.add('hidden');
                    cropper.destroy();
                }, 'image/jpeg', 0.9);
            }
        }
    });

    cancelCrop.addEventListener('click', function() {
        if (cropper) {
            cropper.destroy();
            imagePreview.src = '';
            imagePreview.style.display = 'none';
            imagePreviewContainer.classList.add('hidden');
            cropControls.classList.add('hidden');
            imageInput.value = '';
        }
    });
});
</script>

<style>
    .cropper-view-box,
    .cropper-face {
        border-radius: 8px;
        box-shadow: 0 0 0 1px rgba(255, 235, 59, 0.5);
    }

    .cropper-line {
        background-color: rgba(255, 235, 59, 0.5);
    }

    .cropper-point {
        background-color: #FFEB3B;
        width: 8px;
        height: 8px;
    }

    #image_preview_container {
        max-width: 100%;
    }

    .cropper-container {
        margin: 0 auto;
        max-width: 100%;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }
</style>
@endsection
