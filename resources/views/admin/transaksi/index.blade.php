@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 mt-14 sm:ml-64 font-montserrat">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-black flex items-center">
                <i class="fas fa-exchange-alt text-koplak mr-3"></i>
                Daftar Transaksi
            </h1>
            <p class="text-black mt-2">Kelola semua transaksi pelanggan</p>
        </div>
    </div>

    <!-- Main Card -->
    <div class="border-r-4 border-b-8 border-koplak bg-gray-800 rounded-xl shadow-xl  overflow-hidden">
        <!-- Card Header -->
        <div class="bg-gray-700 px-6 py-4 border-b border-gray-600">
            <h4 class="text-xl font-semibold text-gray-100 flex items-center">
                <i class="fas fa-list-ul text-koplak mr-2"></i>
                Daftar Transaksi
            </h4>
        </div>

        <!-- Card Body -->
        <div class="p-4 md:p-6">
            @if(session('success'))
                <div id="alert-success" class="flex items-center p-4 mb-6 text-green-100 border border-green-800 rounded-lg bg-green-900/30 animate-fade-in">
                    <i class="fas fa-check-circle text-green-400 mr-3"></i>
                    <div class="text-sm font-medium">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 text-green-400 rounded-lg p-1.5 hover:text-green-300" data-dismiss-target="#alert-success">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <!-- Search and Filter Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <!-- Search Input -->
                <div class="w-full md:w-1/2">
                    <form action="{{ route('admin.transaksi.index') }}" method="GET">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fas fa-search text-black"></i>
                            </div>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="block w-full p-2.5 pl-10 text-sm text-black bg-koplak border border-gray-600 rounded-lg focus:ring-koplak focus:border-koplak placeholder-black"
                                placeholder="Cari ID Transaksi atau Nama Customer..."
                            >
                            @if(request('search'))
                                <a href="{{ route('admin.transaksi.index') }}" class="absolute right-2.5 bottom-2.5 text-white hover:text-gray-300">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Status Filter -->
                <div class="w-full md:w-auto">
                    <form action="{{ route('admin.transaksi.index') }}" method="GET">
                        <div class="flex items-center gap-2">
                            <div class="relative">
                                <select
                                    name="status"
                                    onchange="this.form.submit()"
                                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-koplak focus:border-koplak block w-full p-2.5 pr-10 appearance-none" {{-- Add pr-10 here --}}
                                >
                                    <option value="">Semua Status</option>
                                    <option value="dikemas" {{ request('status') == 'dikemas' ? 'selected' : '' }}>Dikemas</option>
                                    <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                    <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-chevron-down text-white"></i>
                                </div>
                            </div>

                            @if(request('search') || request('status'))
                                <a href="{{ route('admin.transaksi.index') }}" class="px-4 py-2.5 text-sm font-medium text-gray-900 bg-koplak rounded-lg hover:bg-koplak-dark focus:ring-4 focus:ring-koplak-darker transition-colors duration-200">
                                    <i class="fas fa-sync-alt mr-1"></i>Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Mobile View - Card Style -->
            <div class="grid grid-cols-1 gap-4 md:hidden">
                @forelse($transactions as $transaction)
                    <div class="bg-gray-700 rounded-lg shadow border border-gray-600 overflow-hidden transition-all duration-200 hover:border-koplak">
                        <!-- Transaction Header -->
                        <div class="flex justify-between items-center p-4 border-b border-gray-600">
                            <div>
                                <span class="text-xs text-white">ID #{{ $transaction->id }}</span>
                                <h5 class="font-medium text-gray-100">{{ $transaction->akun->nama ?? 'Customer' }}</h5>
                            </div>
                            <span class="text-xs text-white">{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
                        </div>

                        <!-- Transaction Details -->
                        <div class="p-4 space-y-3">
                            <div class="flex justify-between">
                                <span class="text-white">Total Harga:</span>
                                <span class="font-medium text-gray-100">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-white">Total Bayar:</span>
                                <span class="font-medium text-gray-100">Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}</span>
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

                            <!-- Nomor Resi (jika ada) -->
                            @if($transaction->nomor_resi && $transaction->status_pengiriman == 'dikirim')
                                <div class="flex justify-between">
                                    <span class="text-white">Nomor Resi:</span>
                                    <span class="text-gray-300 font-mono">{{ $transaction->nomor_resi }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="p-4 border-t border-gray-600 space-y-2">
                            <a href="{{ route('admin.transaksi.show', $transaction->id) }}" class="w-full block text-center px-4 py-2 text-sm font-medium text-gray-900 bg-koplak rounded-lg hover:bg-koplak-dark focus:ring-4 focus:ring-koplak-darker transition-colors duration-200">
                                <i class="fas fa-eye mr-1"></i>Detail Transaksi
                            </a>

                            <!-- WhatsApp Button untuk Status Dikirim -->
                            @if($transaction->status_pengiriman == 'dikirim' && $transaction->akun && $transaction->akun->nomor_hp)
                                <a href="javascript:void(0)"
                                onclick="sendWhatsApp('{{ $transaction->akun->nomor_hp }}', '{{ $transaction->id }}', '{{ $transaction->akun->nama }}', '{{ $transaction->nomor_resi ?? '' }}', '{{ number_format($transaction->total_bayar, 0, ',', '.') }}')"
                                class="w-full block text-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-800 transition-colors duration-200">
                                    <i class="fab fa-whatsapp mr-1"></i>Kirim Info Resi via WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center p-6 text-white">
                        <i class="fas fa-exchange-alt text-4xl mb-3 text-gray-600"></i>
                        <h4 class="text-lg font-medium text-gray-300 mb-1">Tidak ada transaksi</h4>
                        <p class="text-sm">Belum ada transaksi yang tercatat</p>
                    </div>
                @endforelse
            </div>

            <!-- Desktop View - Table Style -->
            <div class="hidden md:block overflow-x-auto rounded-lg border border-gray-700">
                <table class="w-full text-sm text-left text-white">
                    <thead class="text-xs uppercase bg-gray-700 text-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Customer</th>
                            <th scope="col" class="px-6 py-3 text-right">Total Harga</th>
                            <th scope="col" class="px-6 py-3 text-right">Total Bayar</th>
                            <th scope="col" class="px-6 py-3">Metode</th>
                            <th scope="col" class="px-6 py-3">Status Pembayaran</th>
                            <th scope="col" class="px-6 py-3">Status Pengiriman</th>
                            <th scope="col" class="px-6 py-3">Nomor Resi</th>
                            <th scope="col" class="px-6 py-3">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr class="border-b border-gray-700 bg-gray-800 hover:bg-gray-700/50 transition-colors duration-150">
                                <td class="px-6 py-4 font-medium text-white">#{{ $transaction->id }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-user mr-2 text-white"></i>
                                        <div>
                                            <div>{{ $transaction->akun->nama ?? 'Customer' }}</div>
                                            @if($transaction->akun && $transaction->akun->nomor_hp)
                                                <div class="text-xs text-gray-400">{{ $transaction->akun->nomor_hp }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right">Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <span class="bg-gray-700 text-gray-300 px-2 py-1 rounded text-xs">{{ $transaction->metode_pembayaran ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-300">
                                        <i class="fas fa-check-circle mr-1 text-xs"></i>Success
                                    </span>
                                </td>
                                <td class="px-6 py-4">
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
                                </td>
                                <td class="px-6 py-4">
                                    @if($transaction->nomor_resi)
                                        <span class="font-mono text-xs bg-gray-700 px-2 py-1 rounded">{{ $transaction->nomor_resi }}</span>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-white">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex flex-col gap-1">
                                        <a href="{{ route('admin.transaksi.show', $transaction->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-gray-900 bg-koplak rounded-lg hover:bg-koplak-dark focus:ring-4 focus:ring-koplak-darker transition-colors duration-200">
                                            <i class="fas fa-eye mr-1"></i>Detail
                                        </a>

                                        <!-- WhatsApp Button untuk Status Dikirim -->
                                        @if($transaction->status_pengiriman == 'dikirim' && $transaction->akun && $transaction->akun->nomor_hp)
                                            <a href="javascript:void(0)"
                                            onclick="sendWhatsApp('{{ $transaction->akun->nomor_hp }}', '{{ $transaction->id }}', '{{ $transaction->akun->nama }}', '{{ $transaction->nomor_resi ?? '' }}', '{{ number_format($transaction->total_bayar, 0, ',', '.') }}')"
                                            class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-800 transition-colors duration-200"
                                            title="Kirim info resi via WhatsApp">
                                                <i class="fab fa-whatsapp mr-1"></i>WA
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-6 py-4 text-center text-white">
                                    <div class="flex flex-col items-center justify-center py-6">
                                        <i class="fas fa-exchange-alt text-4xl mb-3 text-gray-600"></i>
                                        <h4 class="text-lg font-medium text-gray-300 mb-1">Tidak ada transaksi</h4>
                                        <p class="text-sm">Belum ada transaksi yang tercatat</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($transactions->hasPages())
                <div class="mt-6">
                    <nav class="flex justify-center">
                        {{ $transactions->onEachSide(1)->links() }}
                    </nav>
                </div>
            @endif
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
    // Function untuk mengirim pesan WhatsApp
    function sendWhatsApp(nomorHp, transactionId, customerName, nomorResi, totalBayar) {
        // Bersihkan nomor HP dari karakter non-numeric
        let phoneNumber = nomorHp.replace(/\D/g, '');

        // Tambahkan kode negara Indonesia jika belum ada
        if (phoneNumber.startsWith('0')) {
            phoneNumber = '62' + phoneNumber.substring(1);
        } else if (!phoneNumber.startsWith('62')) {
            phoneNumber = '62' + phoneNumber;
        }

        // Template pesan WhatsApp
        const message = `Halo ${customerName} 👋

    Terima kasih telah berbelanja di toko kami!

    📦 *INFORMASI PENGIRIMAN*
    ━━━━━━━━━━━━━━━━━━━━━━━━
    🆔 ID Transaksi: #${transactionId}
    💰 Total Pembayaran: Rp ${totalBayar}
    📋 Nomor Resi: ${nomorResi || 'Akan segera dikirim'}
    🚚 Status: Sedang dalam pengiriman

    ━━━━━━━━━━━━━━━━━━━━━━━━

    ${nomorResi ? `📱 Anda dapat melacak paket Anda dengan nomor resi: *${nomorResi}*` : '📱 Nomor resi akan segera kami kirimkan.'}

    🕐 Estimasi tiba: 2-3 hari kerja
    📞 Jika ada pertanyaan, silakan hubungi kami

    Terima kasih atas kepercayaan Anda! 🙏`;

        // Encode pesan untuk URL
        const encodedMessage = encodeURIComponent(message);

        // Buat URL WhatsApp
        const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;

        // Buka WhatsApp di tab baru
        window.open(whatsappUrl, '_blank');
    }

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
