<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-white min-h-screen text-gray-100 font-montserrat">
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Header Section -->
        <div class="border-b-8 border-black bg-gray-800 rounded-xl shadow-xl mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-yellow-500 to-koplak px-6 py-5 flex items-center justify-between">
                <a href="{{ route('home') }}" class="rounded-lg border-b-8 font-bold border-black border p-2 bg-yellow-500 flex items-center text-gray-900 hover:text-gray-800">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                <h1 class="text-black text-xl md:text-2xl font-bold flex items-center">
                    <i class="fas fa-history mr-3"></i> Riwayat Transaksi
                </h1>
                <div class="w-8"></div> <!-- Spacer for alignment -->
            </div>
        </div>

        <!-- Notification -->
        @if(session('success'))
            <div id="alert-success" class="flex items-center p-4 mb-6 rounded-lg bg-green-900/50 border border-green-600 text-green-200">
                <i class="fas fa-check-circle mr-3 text-green-400"></i>
                <div class="text-sm font-medium">
                    {{ session('success') }}
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 p-1.5 hover:bg-green-800/50 rounded-lg inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-success" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Filter Section -->
        <div class="bg-black border-b-8 border-koplak rounded-xl p-4 md:p-6 mb-6 shadow-lg">
            <form action="{{ route('transaksi.histori') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-start md:items-center">
                <div class="w-full md:w-64">
                    <label class="block text-sm font-medium text-gray-400 mb-1">Filter Status</label>
                    <div class="relative">
                        <select name="status" onchange="this.form.submit()"
                            class="bg-gray-750 border border-gray-700 text-gray-200 rounded-lg focus:ring-koplak focus:border-koplak block w-full p-2.5 pr-8 appearance-none">
                            <option value="">Semua Status</option>
                            <option value="dikemas" {{ request('status') == 'dikemas' ? 'selected' : '' }}>Dikemas</option>
                            <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                </div>

                @if(request('status'))
                    <a href="{{ route('transaksi.histori') }}"
                       class="px-4 py-2 text-sm font-medium text-white bg-koplak hover:bg-koplak-dark rounded-lg transition-colors flex items-center">
                        <i class="fas fa-sync-alt mr-2"></i> Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Mobile View - Cards -->
        <div class="md:hidden space-y-4">
            @forelse($transaksi as $transaction)
                <div class="bg-gray-800 rounded-xl p-5 shadow-lg border border-gray-700 hover:border-koplak/50 transition-colors">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-receipt text-koplak mr-2"></i>
                            <span class="text-sm text-gray-400">#{{ $transaction->id }}</span>
                        </div>
                        <span class="text-xs text-gray-400">
                            <i class="far fa-clock mr-1"></i>{{ $transaction->created_at->format('d M Y H:i') }}
                        </span>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 flex items-center">
                                <i class="fas fa-tag mr-2 text-sm"></i> Total Harga
                            </span>
                            <span class="font-medium">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 flex items-center">
                                <i class="fas fa-money-bill-wave mr-2 text-sm"></i> Total Bayar
                            </span>
                            <span class="font-bold text-koplak">Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 flex items-center">
                                <i class="fas fa-credit-card mr-2 text-sm"></i> Metode
                            </span>
                            <span>{{ $transaction->metode_pembayaran ?? '-' }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 flex items-center">
                                <i class="fas fa-check-circle mr-2 text-sm"></i> Pembayaran
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-300">
                                Success
                            </span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 flex items-center">
                                <i class="fas fa-truck mr-2 text-sm"></i> Pengiriman
                            </span>
                            @if($transaction->status_pengiriman == 'dikemas')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-900 text-yellow-300">
                                    <i class="fas fa-box mr-1"></i> Dikemas
                                </span>
                            @elseif($transaction->status_pengiriman == 'dikirim')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-900 text-blue-300">
                                    <i class="fas fa-shipping-fast mr-1"></i> Dikirim
                                </span>
                            @elseif($transaction->status_pengiriman == 'diterima')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-300">
                                    <i class="fas fa-check mr-1"></i> Diterima
                                </span>
                            @endif
                        </div>
                    </div>

                    <form action="{{ route('transaksi.selesaikan', $transaction->id) }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit"
                                class="w-full py-2 px-4 bg-koplak hover:bg-koplak-dark text-gray-900 font-medium rounded-lg transition-colors flex items-center justify-center">
                            <i class="fas fa-check-circle mr-2"></i> Selesaikan Pesanan
                        </button>
                    </form>
                </div>
            @empty
                <div class="bg-gray-800 rounded-xl p-8 text-center border border-gray-700">
                    <i class="fas fa-inbox text-4xl text-gray-600 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-400">Tidak ada transaksi</h3>
                    <a href="{{ route('home') }}" class="inline-block mt-4 text-koplak hover:underline">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke beranda
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Desktop View - Table -->
        <div class="border-b-8 border-koplak hidden md:block bg-gray-800 rounded-xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-400">
                    <thead class="text-xs text-white uppercase bg-black">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium flex-col items-center">
                                <i class="fas fa-hashtag mr-2 text-koplak"></i> ID
                            </th>
                            <th scope="col" class="px-6 py-4 font-medium flex-col items-center">
                                <i class="fas fa-tag mr-2 text-koplak"></i> Total Harga
                            </th>
                            <th scope="col" class="px-6 py-4 font-medium flex-col items-center">
                                <i class="fas fa-money-bill-wave mr-2 text-koplak"></i> Total Bayar
                            </th>
                            <th scope="col" class="px-6 py-4 font-medium flex-col items-center">
                                <i class="fas fa-credit-card mr-2 text-koplak"></i> Metode
                            </th>
                            <th scope="col" class="px-6 py-4 font-medium flex-col items-center">
                                <i class="fas fa-check-circle mr-2 text-koplak"></i> Pembayaran
                            </th>
                            <th scope="col" class="px-6 py-4 font-medium flex-col items-center">
                                <i class="fas fa-truck mr-2 text-koplak"></i> Pengiriman
                            </th>
                            <th scope="col" class="px-6 py-4 font-medium flex-col items-center">
                                <i class="far fa-clock mr-2 text-koplak"></i> Tanggal
                            </th>
                            <th scope="col" class="px-6 py-4 font-medium flex-col items-center">
                                <i class="fas fa-ellipsis-h mr-2 text-koplak"></i> Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksi as $transaction)
                            <tr class="bg-white border-b     border-gray-700 hover:bg-gray-200 transition-colors">
                                <td class="px-6 py-4 font-medium text-black">#{{ $transaction->id }}</td>
                                <td class="px-6 py-4 text-black">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 font-bold text-black">Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-black">{{ $transaction->metode_pembayaran ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-300">
                                        Success
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($transaction->status_pengiriman == 'dikemas')
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-900 text-yellow-300 flex items-center w-fit">
                                            <i class="fas fa-box mr-1"></i> Dikemas
                                        </span>
                                    @elseif($transaction->status_pengiriman == 'dikirim')
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-900 text-blue-300 flex items-center w-fit">
                                            <i class="fas fa-shipping-fast mr-1"></i> Dikirim
                                        </span>
                                    @elseif($transaction->status_pengiriman == 'diterima')
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-300 flex items-center w-fit">
                                            <i class="fas fa-check mr-1"></i> Diterima
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-black">{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('transaksi.selesaikan', $transaction->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="px-4 py-2 bg-koplak hover:bg-koplak-dark text-gray-900 font-medium rounded-lg transition-colors flex items-center justify-center whitespace-nowrap">
                                            <i class="fas fa-check-circle mr-2"></i> Selesaikan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-inbox text-4xl text-gray-600 mb-4"></i>
                                        <h3 class="text-lg font-medium text-gray-400">Tidak ada transaksi</h3>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($transaksi->hasPages())
            <div class="mt-6">
                <nav class="flex justify-center">
                    {{ $transaksi->links() }}
                </nav>
            </div>
        @endif
    </div>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'koplak': '#FFEB3B',
                        'koplak-dark': '#FBC02D',
                        'koplak-darker': '#F57F17',
                        'gray-750': '#2D3748',
                    },
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.3s ease-out forwards',
                    }
                }
            }
        }

        // Auto-dismiss success message after 5 seconds
        const alert = document.getElementById('alert-success');
        if (alert) {
            setTimeout(() => {
                alert.classList.add('opacity-0');
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }, 5000);
        }
    </script>
</body>
</html>
