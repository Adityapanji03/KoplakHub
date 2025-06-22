@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 mt-14 sm:ml-64 font-montserrat">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-black flex items-center">
                <i class="fas fa-receipt text-koplak mr-3"></i>
                Detail Transaksi #{{ $transaction->id }}
            </h1>
            <p class="text-black mt-2">Detail lengkap transaksi pelanggan</p>
        </div>
        <a href="{{ route('admin.transaksi.index') }}" class="border-b-4 border-koplak px-4 py-2.5 bg-black text-white font-bold rounded-lg hover:bg-gray-600 focus:ring-4 focus:ring-gray-500 transition-colors duration-200 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <!-- Success Notification -->
    @if(session('success'))
        <div id="alert-success" class="flex items-center p-4 mb-6 text-green-100 border border-green-800 rounded-lg bg-green-500 animate-fade-in">
            <i class="fas fa-check-circle text-green-600 mr-3"></i>
            <div class="text-black text-sm font-medium">
                {{ session('success') }}
            </div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 text-green-400 rounded-lg p-1.5 hover:text-green-300" data-dismiss-target="#alert-success">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Main Card -->
    <div class="bg-gray-800 rounded-xl shadow-xl border border-gray-700 overflow-hidden">
        <!-- Customer & Transaction Info -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-6">
            <!-- Customer Info Card -->
            <div class="bg-gray-700 rounded-lg shadow border border-gray-600">
                <div class="border-b border-gray-600 px-5 py-4">
                    <h5 class="text-lg font-semibold text-gray-100 flex items-center">
                        <i class="fas fa-user-circle text-koplak mr-2"></i>
                        Informasi Pembeli
                    </h5>
                </div>
                <div class="p-5 space-y-3 text-sm">
                    @php
                        $raw = $transaction->alamat_pengiriman;
                        $alamat = is_string($raw) ? json_decode($raw, true) : $raw;
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="block text-white mb-1">Nama:</span>
                            <span class="font-medium text-gray-100">{{ $transaction->akun->nama ?? 'Customer' }}</span>
                        </div>
                        <div>
                            <span class="block text-white mb-1">No. HP:</span>
                            <span class="text-gray-300">{{ $transaction->akun->nomor_hp ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="pt-4 mt-4 border-t border-gray-600">
                        <h6 class="text-white mb-2 flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-koplak"></i>
                            Alamat Pengiriman
                        </h6>
                        <div class="space-y-2">
                            <div>
                                <span class="block text-white mb-1">Detail Alamat:</span>
                                <span class="text-gray-300">{{ $alamat['detail_alamat'] ?? 'N/A' }}</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <span class="block text-white mb-1">Kelurahan:</span>
                                    <span class="text-gray-300">{{ $alamat['kelurahan'] ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="block text-white mb-1">Kecamatan:</span>
                                    <span class="text-gray-300">{{ $alamat['kecamatan'] ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="block text-white mb-1">Kabupaten:</span>
                                    <span class="text-gray-300">{{ $alamat['kabupaten'] ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="block text-white mb-1">Provinsi:</span>
                                    <span class="text-gray-300">{{ $alamat['provinsi'] ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction Info Card -->
            <div class="bg-gray-700 rounded-lg shadow border border-gray-600">
                <div class="border-b border-gray-600 px-5 py-4">
                    <h5 class="text-lg font-semibold text-gray-100 flex items-center">
                        <i class="fas fa-info-circle text-koplak mr-2"></i>
                        Informasi Transaksi
                    </h5>
                </div>
                <div class="p-5 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-white">Total Harga:</span>
                        <span class="text-gray-100">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-white">Total Bayar:</span>
                        <span class="font-bold text-gray-100">Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-white">Metode Pembayaran:</span>
                        <span class="text-gray-300">{{ $transaction->metode_pembayaran ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-white">Status Pembayaran:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-300">
                            <i class="fas fa-check-circle mr-1 text-xs"></i>Success
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-white">Status Pengiriman:</span>
                        @if($transaction->status_pengiriman == 'dikemas')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-900 text-yellow-300">
                                <i class="fas fa-box mr-1 text-xs"></i>Dikemas
                            </span>
                        @elseif($transaction->status_pengiriman == 'dikirim')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-900 text-blue-300">
                                <i class="fas fa-truck mr-1 text-xs"></i>Dikirim
                            </span>
                        @elseif($transaction->status_pengiriman == 'diterima')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-300">
                                <i class="fas fa-check-circle mr-1 text-xs"></i>Diterima
                            </span>
                        @endif
                    </div>
                    <div class="flex justify-between">
                        <span class="text-white">Tanggal Transaksi:</span>
                        <span class="text-gray-300">{{ $transaction->created_at->format('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="bg-gray-700 rounded-lg shadow border border-gray-600 mx-6 mb-6">
            <div class="border-b border-gray-600 px-5 py-4">
                <h5 class="text-lg font-semibold text-gray-100 flex items-center">
                    <i class="fas fa-shopping-bag text-koplak mr-2"></i>
                    Produk yang Dibeli
                </h5>
            </div>
            <div class="p-5">
                <!-- Mobile View - Product Cards -->
                <div class="md:hidden space-y-4">
                    @foreach($transaction->detailTransaksi as $item)
                        <div class="bg-gray-800 rounded-lg border border-gray-600 overflow-hidden">
                            <div class="flex items-center p-4 border-b border-gray-600">
                                @if($item->produk->gambar_produk)
                                    <img src="{{ asset('storage/' . $item->produk->gambar_produk) }}" alt="{{ $item->produk->nama_produk }}" class="w-16 h-16 object-cover rounded-md mr-4">
                                @else
                                    <div class="w-16 h-16 bg-gray-700 rounded-md mr-4 flex items-center justify-center">
                                        <i class="fas fa-box-open text-gray-500 text-xl"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="font-medium text-gray-100">{{ $item->produk->nama_produk ?? 'Produk' }}</h6>
                                    <span class="text-xs text-white">ID: {{ $item->produk->id ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="p-4 space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-white">Harga:</span>
                                    <span class="text-gray-300">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-white">Jumlah:</span>
                                    <span class="text-gray-300">{{ $item->jumlah }}</span>
                                </div>
                                <div class="flex justify-between font-medium">
                                    <span class="text-gray-300">Subtotal:</span>
                                    <span class="text-gray-100">Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Desktop View - Table -->
                <div class="hidden md:block overflow-x-auto rounded-lg border border-gray-600">
                    <table class="w-full text-sm text-left text-white">
                        <thead class="text-xs uppercase bg-gray-800 text-gray-300">
                            <tr>
                                <th scope="col" class="px-6 py-3">Produk</th>
                                <th scope="col" class="px-6 py-3 text-right">Harga</th>
                                <th scope="col" class="px-6 py-3 text-right">Jumlah</th>
                                <th scope="col" class="px-6 py-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction->detailTransaksi as $item)
                                <tr class="border-b border-gray-600 bg-gray-800 hover:bg-gray-700/50">
                                    <td class="px-6 py-4 font-medium text-white">
                                        <div class="flex items-center">
                                            @if($item->produk->gambar_produk)
                                                <img src="{{ asset('storage/' . $item->produk->gambar_produk) }}" alt="{{ $item->produk->nama }}" class="w-10 h-10 object-cover rounded-md mr-3">
                                            @else
                                                <div class="w-10 h-10 bg-gray-700 rounded-md mr-3 flex items-center justify-center">
                                                    <i class="fas fa-box-open text-gray-500"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div>{{ $item->produk->nama_produk ?? 'Produk' }}</div>
                                                <div class="text-xs text-white">ID: {{ $item->produk->id ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-right">{{ $item->jumlah }}</td>
                                    <td class="px-6 py-4 text-right font-medium text-gray-100">Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Update Shipping Section -->
        <div class="bg-gray-700 rounded-lg shadow border border-gray-600 mx-6 mb-6">
            <div class="border-b border-gray-600 px-5 py-4">
                <h5 class="text-lg font-semibold text-gray-100 flex items-center">
                    <i class="fas fa-truck text-koplak mr-2"></i>
                    Update Pengiriman
                </h5>
            </div>
            <div class="p-5">
                <form action="{{ route('admin.transaksi.update', $transaction->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="nomor_resi" class="block mb-2 text-sm font-medium text-gray-300 flex items-center">
                                <i class="fas fa-barcode mr-2 text-koplak"></i>
                                Nomor Resi
                            </label>
                            <div class="relative">
                                <input type="text" id="nomor_resi" name="nomor_resi"
                                       class="bg-gray-800 border border-gray-600 text-gray-100 text-sm rounded-lg focus:ring-koplak focus:border-koplak block w-full p-2.5"
                                       value="{{ $transaction->nomor_resi ?? old('nomor_resi') }}"
                                       placeholder="Masukkan nomor resi">
                                @error('nomor_resi')
                                    <p class="mt-2 text-sm text-red-400 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="status_pengiriman" class="block mb-2 text-sm font-medium text-gray-300 flex items-center">
                                <i class="fas fa-truck-loading mr-2 text-koplak"></i>
                                Status Pengiriman
                            </label>
                            <div class="relative">
                                <select id="status_pengiriman" name="status_pengiriman"
                                        class="bg-gray-800 border border-gray-600 text-gray-100 text-sm rounded-lg focus:ring-koplak focus:border-koplak block w-full p-2.5 appearance-none">
                                    <option value="dikemas" {{ $transaction->status_pengiriman == 'dikemas' ? 'selected' : '' }}>Dikemas</option>
                                    <option value="dikirim" {{ $transaction->status_pengiriman == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-chevron-down text-white"></i>
                                </div>
                                @error('status_pengiriman')
                                    <p class="mt-2 text-sm text-red-400 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full md:w-auto px-5 py-2.5 bg-koplak text-gray-900 font-medium rounded-lg hover:bg-koplak-dark focus:ring-4 focus:ring-koplak-darker transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
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

    /* Custom select arrow */
    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
</style>

<script>
    // Initialize dismissible alerts
    document.addEventListener('DOMContentLoaded', function() {
        const dismissButtons = document.querySelectorAll('[data-dismiss-target]');
        dismissButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-dismiss-target');
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.remove();
                }
            });
        });
    });
</script>
@endsection
