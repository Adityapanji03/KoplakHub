@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 mt-14 p-4 sm:ml-64">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Produk</h1>
        <a href="{{ route('productsAdmin.index') }}" class="px-4 py-2 bg-gray-500 text-white font-medium rounded-lg hover:bg-gray-600 focus:ring-4 focus:ring-gray-300">
            Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden max-w-4xl mx-auto">
        <div class="md:flex">
            <div class="md:w-1/3">
                <img src="{{ Storage::url($produk->gambar_produk) }}" alt="{{ $produk->nama_produk }}" class="w-full h-80 object-cover">
            </div>
            <div class="p-8 md:w-2/3">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $produk->nama_produk }}</h2>
                    @if($produk->stok_produk > 0)
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                            Aktif
                        </span>
                    @else
                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">
                            Tidak Aktif
                        </span>
                    @endif
                </div>
                <div class="flex items-center mb-4">
                    <span class="text-3xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</span>
                </div>
                <div class="mb-4">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Stok: {{ $produk->stok_produk }}</span>
                </div>
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Deskripsi</h3>
                    <p class="text-gray-700 dark:text-gray-300">{{ $produk->deskripsi_produk }}</p>
                </div>
                <div class="flex space-x-4 mt-8">
                    <a href="{{ route('productsAdmin.editProduk', $produk) }}" class="px-4 py-2 bg-yellow-500 text-white font-medium rounded-lg hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300">
                        Edit
                    </a>
                    <button data-modal-target="deactivateModal" data-modal-toggle="deactivateModal" class="px-4 py-2 bg-red-500 text-white font-medium rounded-lg hover:bg-red-600 focus:ring-4 focus:ring-red-300">
                        Nonaktifkan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deactivate -->
<div id="deactivateModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="deactivateModal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-6 text-center">
                <svg class="mx-auto mb-4 text-yellow-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Nonaktifkan produk "{{ $produk->nama_produk }}"?</h3>
                <div class="flex justify-center gap-4">
                    <form action="{{ route('productsAdmin.deactivate', $produk) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Ya, nonaktifkan
                        </button>
                    </form>
                    <button data-modal-hide="deactivateModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
@endsection

