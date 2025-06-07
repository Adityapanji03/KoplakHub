@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 mt-14 sm:ml-64 font-montserrat overflow-hidden">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-black"><i class="fas fa-box-open text-yellow-600 mr-2 "></i>Daftar Produk</h1>
            <p class="text-black mt-1">Kelola produk toko Anda</p>
        </div>
        <a href="{{ route('productsAdmin.create') }}" class="border-b-4 border-black px-5 py-2.5 bg-koplak text-gray-900 font-bold rounded-lg hover:bg-koplak-dark focus:ring-4 focus:ring-koplak-darker transition-all duration-200 flex items-center">
            <i class="fas fa-plus-circle mr-2"></i>Tambah Produk
        </a>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
    <div id="alert-success" class="p-4 mb-6 text-green-100 border border-green-800 rounded-lg bg-gradient-to-br from-green-900 to-gray-900 animate-fade-in" role="alert">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3 text-green-400"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button type="button" class="text-green-400 hover:text-white" data-dismiss-target="#alert-success" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    <!-- Product Table -->
    <div class="border-b-8 border-r-4 border-koplak bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-400">
                <thead class="text-xs uppercase bg-black text-gray-300">
                    <tr>
                        <th scope="col" class="text-koplak px-6 py-4">Gambar</th>
                        <th scope="col" class="text-koplak px-6 py-4">Nama Produk</th>
                        <th scope="col" class="text-koplak px-6 py-4">Harga</th>
                        <th scope="col" class="text-koplak px-6 py-4">Stok</th>
                        <th scope="col" class="text-koplak px-6 py-4">Status</th>
                        <th scope="col" class="text-koplak px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr class="border-b border-gray-700 hover:bg-gray-700/50 transition-colors duration-150">
                        <!-- Product Image -->
                        <td class="px-6 py-4">
                            <div class="w-14 h-14 rounded-lg overflow-hidden border border-gray-600">
                                <img src="{{ Storage::url($product->gambar_produk) }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-cover">
                            </div>
                        </td>

                        <!-- Product Name -->
                        <td class="px-6 py-4 font-medium text-white">
                            <div class="flex items-center">
                                {{ $product->nama_produk }}
                                @if($product->created_at->diffInDays() < 7)
                                <span class="ml-2 bg-koplak/20 text-koplak text-xs px-2 py-0.5 rounded-full">Baru</span>
                                @endif
                            </div>
                        </td>

                        <!-- Price -->
                        <td class="px-6 py-4">
                            <span class="font-semibold text-white">Rp {{ number_format($product->harga_produk, 0, ',', '.') }}</span>
                        </td>

                        <!-- Stock -->
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <span class="mr-2">{{ $product->stok_produk }}</span>
                                <div class="w-16 bg-gray-700 rounded-full h-1.5">
                                    @php
                                        $stockPercentage = min(100, ($product->stok_produk / 50) * 100);
                                        $stockColor = $stockPercentage > 50 ? 'bg-green-500' : ($stockPercentage > 20 ? 'bg-yellow-500' : 'bg-red-500');
                                    @endphp
                                    <div class="h-1.5 rounded-full {{ $stockColor }}" style="width: {{ $stockPercentage }}%"></div>
                                </div>
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4">
                            @if($product->stok_produk > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-300">
                                    <i class="fas fa-circle text-[8px] mr-1"></i> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-900 text-red-300">
                                    <i class="fas fa-circle text-[8px] mr-1"></i> Habis
                                </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4">
                            <div class="flex justify-end space-x-3">
                                <!-- View -->
                                <a href="{{ route('productsAdmin.showProduk', $product) }}"
                                   class="text-blue-500 hover:text-blue-400 transition-colors duration-200"
                                   data-tooltip-target="tooltip-view-{{ $product->id }}">
                                    <i class="fas fa-eye text-lg"></i>
                                </a>
                                <div id="tooltip-view-{{ $product->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                                    Lihat Detail
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>

                                <!-- Edit -->
                                <a href="{{ route('productsAdmin.editProduk', $product) }}"
                                   class="text-koplak hover:text-yellow-500 transition-colors duration-200"
                                   data-tooltip-target="tooltip-edit-{{ $product->id }}">
                                    <i class="fas fa-edit text-lg"></i>
                                </a>
                                <div id="tooltip-edit-{{ $product->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                                    Edit Produk
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>

                                <!-- Deactivate -->
                                <button data-modal-target="deactivateModal-{{ $product->id }}"
                                        data-modal-toggle="deactivateModal-{{ $product->id }}"
                                        class="text-red-600 hover:text-red-400 transition-colors duration-200"
                                        data-tooltip-target="tooltip-deactivate-{{ $product->id }}">
                                    <i class="fas fa-ban text-lg"></i>
                                </button>
                                <div id="tooltip-deactivate-{{ $product->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                                    Nonaktifkan
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- Deactivate Modal -->
                    <div id="deactivateModal-{{ $product->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full">
                            <div class="relative bg-gray-800 rounded-lg shadow border border-gray-700">
                                <div class="p-6 text-center">
                                    <i class="fas fa-exclamation-triangle text-4xl text-yellow-400 mb-4"></i>
                                    <h3 class="mb-5 text-lg font-normal text-gray-300">Nonaktifkan produk "{{ $product->nama_produk }}"?</h3>
                                    <p class="text-gray-400 mb-6">Produk ini akan diarsipkan dan tidak akan muncul di toko.</p>
                                    <div class="flex justify-center gap-4">
                                        <form action="{{ route('productsAdmin.deactivate', $product) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-gray-900 bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-400 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors duration-200">
                                                <i class="fas fa-ban mr-2"></i>Ya, Nonaktifkan
                                            </button>
                                        </form>
                                        <button data-modal-hide="deactivateModal-{{ $product->id }}" type="button" class="text-gray-300 bg-gray-700 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-500 rounded-lg border border-gray-600 text-sm font-medium px-5 py-2.5 transition-colors duration-200">
                                            <i class="fas fa-times mr-2"></i>Batal
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr class="border-b border-gray-700">
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-500">
                                <i class="fas fa-box-open text-4xl mb-3 text-gray-600"></i>
                                <h4 class="text-lg font-medium text-gray-300 mb-1">Tidak ada produk</h4>
                                <p class="text-sm">Tambahkan produk pertama Anda</p>
                                <a href="{{ route('productsAdmin.create') }}" class="mt-4 px-4 py-2 text-sm bg-koplak text-gray-900 rounded-lg hover:bg-koplak-dark transition-colors duration-200">
                                    <i class="fas fa-plus mr-1"></i>Tambah Produk
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
        <div class="px-6 py-4 border-t border-gray-700">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>


<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }

    /* Custom scrollbar for dark theme */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    ::-webkit-scrollbar-track {
        background: #1f2937;
    }
    ::-webkit-scrollbar-thumb {
        background: #4b5563;
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #6b7280;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
@endsection

