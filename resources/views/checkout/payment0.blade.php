@extends('layouts.appCustomer')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Pembayaran</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header pembayaran -->
            <div class="bg-blue-600 text-white p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold">Pembayaran #{{ $transaksi->id }}</h2>
                        <p class="text-blue-100 mt-1">Selesaikan pembayaran sebelum:</p>
                        <p class="font-medium">{{ $transaksi->created_at->addDay()->format('d M Y, H:i') }} WIB</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-blue-100">Total Pembayaran</p>
                        <p class="text-2xl font-bold">Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Instruksi pembayaran -->
            <div class="p-6">
                <!-- Metode pembayaran yang dipilih -->
                <div class="flex items-center mb-6">
                    <span class="text-gray-700 mr-2">Metode Pembayaran:</span>
                    <div class="flex items-center">
                        @if($transaksi->metode_pembayaran == 'dana')
                            <img src="{{ asset('images/dana-logo.png') }}" alt="DANA" class="h-6 mr-2">
                            <span class="font-medium">DANA</span>
                        @elseif($transaksi->metode_pembayaran == 'gopay')
                            <img src="{{ asset('images/gopay-logo.png') }}" alt="GoPay" class="h-6 mr-2">
                            <span class="font-medium">GoPay</span>
                        @elseif($transaksi->metode_pembayaran == 'bri')
                            <img src="{{ asset('images/bri-logo.png') }}" alt="BRI" class="h-6 mr-2">
                            <span class="font-medium">Bank BRI</span>
                        @endif
                    </div>
                </div>

                <!-- Instructions based on payment method -->
                <div class="border rounded-lg p-6 bg-gray-50 mb-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Cara Pembayaran</h3>

                    @if($transaksi->metode_pembayaran == 'dana')
                        <ol class="list-decimal pl-5 space-y-2 text-gray-700">
                            <li>Buka aplikasi DANA di smartphone Anda</li>
                            <li>Scan QR Code di bawah ini dengan aplikasi DANA</li>
                            <li>Masukkan nominal pembayaran: <span class="font-semibold">Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</span></li>
                            <li>Periksa kembali detail transaksi</li>
                            <li>Masukkan PIN DANA Anda untuk mengkonfirmasi</li>
                            <li>Pembayaran selesai! Halaman ini akan diperbarui secara otomatis</li>
                        </ol>
                        <div class="flex justify-center my-6">
                            <div class="bg-white p-4 border rounded-lg">
                                <img src="{{ asset('images/qr-dana.png') }}" alt="QR Code DANA" class="w-48 h-48">
                            </div>
                        </div>
                    @elseif($transaksi->metode_pembayaran == 'gopay')
                        <ol class="list-decimal pl-5 space-y-2 text-gray-700">
                            <li>Buka aplikasi Gojek di smartphone Anda</li>
                            <li>Pilih menu 'Bayar' dan scan QR Code di bawah ini</li>
                            <li>Masukkan nominal pembayaran: <span class="font-semibold">Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</span></li>
                            <li>Periksa kembali detail transaksi</li>
                            <li>Konfirmasi pembayaran dengan PIN GoPay Anda</li>
                            <li>Pembayaran selesai! Halaman ini akan diperbarui secara otomatis</li>
                        </ol>
                        <div class="flex justify-center my-6">
                            <div class="bg-white p-4 border rounded-lg">
                                <img src="{{ asset('images/qr-gopay.png') }}" alt="QR Code GoPay" class="w-48 h-48">
                            </div>
                        </div>
                    @elseif($transaksi->metode_pembayaran == 'bri')
                        <ol class="list-decimal pl-5 space-y-2 text-gray-700">
                            <li>Transfer ke rekening BRI berikut:</li>
                            <li class="font-medium ml-4">Nomor Rekening: 1234567890</li>
                            <li class="font-medium ml-4">Atas Nama: PT Toko Online</li>
                            <li class="font-medium ml-4">Jumlah: Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</li>
                            <li>Transfer dapat dilakukan melalui mobile banking, internet banking, atau ATM BRI</li>
                            <li>Setelah transfer, upload bukti pembayaran pada form di bawah</li>
                        </ol>
                        <div class="mt-6">
                            <form action="{{ route('transaksi.konfirmasi', $transaksi->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label for="bukti_pembayaran" class="block text-gray-700 mb-2">Upload Bukti Pembayaran:</label>
                                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran"
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        accept="image/*" required>
                                </div>
                                <div class="mb-4">
                                    <label for="catatan" class="block text-gray-700 mb-2">Catatan (opsional):</label>
                                    <textarea name="catatan" id="catatan" rows="2"
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Masukkan catatan jika ada"></textarea>
                                </div>
                                <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                    Konfirmasi Pembayaran
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- Ringkasan Pesanan -->
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h3>
                    <div class="border rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($transaksi->detail_transaksi as $detail)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img src="{{ asset('storage/' . $detail->produk->gambar_produk) }}"
                                                alt="{{ $detail->produk->nama_produk }}"
                                                class="w-10 h-10 object-cover rounded-md mr-3">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $detail->produk->nama_produk }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $detail->jumlah }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="2" class="px-6 py-3 text-right text-sm font-medium text-gray-500">
                                        Subtotal:
                                    </td>
                                    {{-- <td class="px-6 py-3 text-sm text-gray-900">
                                        Rp {{ number_format($transaksi->jumlah - $transaksi->biaya_pengiriman, 0, ',', '.') }}
                                    </td> --}}
                                </tr>
                                <tr>
                                    <td colspan="2" class="px-6 py-3 text-right text-sm font-medium text-gray-500">
                                        Biaya Pengiriman:
                                    </td>
                                    {{-- <td class="px-6 py-3 text-sm text-gray-900">
                                        Rp {{ number_format($transaksi->biaya_pengiriman, 0, ',', '.') }}
                                    </td> --}}
                                </tr>
                                <tr>
                                    <td colspan="2" class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                        Total:
                                    </td>
                                    <td class="px-6 py-3 text-sm font-medium text-gray-900">
                                        Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Alamat Pengiriman -->
                <div>
                    <h3 class="font-semibold text-gray-800 mb-4">Alamat Pengiriman</h3>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <h4 class="font-medium text-gray-800">{{ $transaksi->akun->name }}</h4>
                        <p class="text-gray-700 mt-2">
                            {{ $transaksi->alamat_pengiriman }},<br>
                            {{ $transaksi->akun->phone }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 p-6 border-t">
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <div class="mb-4 sm:mb-0">
                        <p class="text-gray-700">Butuh bantuan? Hubungi <a href="#" class="text-blue-600 hover:underline">Customer Service</a></p>
                    </div>
                    <a href="{{ route('transaksi.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Kembali ke Daftar Transaksi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Script untuk mengecek status pembayaran secara periodik (untuk metode DANA dan GoPay)
    @if(in_array($transaksi->metode_pembayaran, ['dana', 'gopay']))
    document.addEventListener('DOMContentLoaded', function() {
        // Cek status pembayaran setiap 10 detik
        const checkPaymentStatus = setInterval(function() {
            fetch('{{ route("transaksi.status", $transaksi->id) }}')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'paid') {
                        clearInterval(checkPaymentStatus);
                        window.location.href = '{{ route("transaksi.success", $transaksi->id) }}';
                    }
                })
                .catch(error => console.error('Error checking payment status:', error));
        }, 10000); // 10 detik
    });
    @endif
</script>
@endpush

@endsection
