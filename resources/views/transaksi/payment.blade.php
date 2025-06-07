<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi Belum Dibayar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-white min-h-screen text-gray-100 font-montserrat">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div class="flex items-center">
                <i class="fas fa-clock text-koplak text-2xl mr-3"></i>
                <h1 class="text-black text-2xl md:text-3xl font-bold">Menunggu Pembayaran</h1>
            </div>
            <a href="{{ route('home') }}" class="font-bold border-b-8 border border-black bg-koplak hover:bg-koplak-dark text-gray-900 px-4 py-2 rounded-lg text-sm flex items-center transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Beranda
            </a>
        </div>

        <!-- Notification Popup -->
        <div id="notification-popup" class="fixed bottom-4 right-4 bg-green-600 text-white py-3 px-4 rounded-lg shadow-xl flex items-center transform transition-all duration-300 ease-out opacity-0 translate-y-2 hidden z-50">
            <i class="fas fa-check-circle mr-2"></i>
            <span>Pengecekan Berhasil</span>
        </div>

        <!-- Transactions List -->
        <div class="bg-white rounded-xl overflow-hidden shadow-xl">
            <!-- Desktop Table Header -->
            <div class="grid grid-cols-12 bg-black p-4 font-semibold text-gray-300 hidden md:grid">
                <div class="col-span-2 flex items-center">
                    <i class="text-white fas fa-receipt mr-2"></i> ID Transaksi
                </div>
                <div class="col-span-2 flex items-center">
                    <i class="far fa-calendar-alt mr-2 text-red-500"></i> Tanggal
                </div>
                <div class="col-span-2 flex items-center">
                    <i class="text-green-500 fas fa-money-bill-wave mr-2"></i> Total Bayar
                </div>
                <div class="col-span-2 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-gray-300"></i> Status
                </div>
                <div class="col-span-3 flex items-center">
                    <i class="fas fa-box-open mr-2 text-yellow-300"></i> Produk
                </div>
                <div class="col-span-1 flex items-center">
                    <i class="fa-brands fa-paypal text-blue-500"></i> Bayar
                </div>
            </div>

            @forelse ($transaksi as $transaction)
            <!-- Transaction Item -->
            <div class="border-b-4 border-black bg-white p-6 hover:bg-gray-200 transition-colors md:grid md:grid-cols-12 gap-4 mb-4 md:mb-0 rounded-lg md:rounded-none">
                <!-- Mobile: Top Section -->
                <div class="md:hidden flex justify-between items-start mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-receipt text-koplak mr-2"></i>
                        <div>
                            <div class="text-xs text-black">ID Transaksi</div>
                            <div class="font-medium text-sm">
                                {{ $transaction->midtrans_order_id ?? 'TRX-' . $transaction->id }}
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                            @if ($transaction->status_pembayaran == 'pending') bg-yellow-900 text-yellow-200
                            @elseif ($transaction->status_pembayaran == 'success') bg-green-900 text-green-200
                            @elseif ($transaction->status_pembayaran == 'failed') bg-red-900 text-red-200 @endif">
                            <i class="fas
                                @if ($transaction->status_pembayaran == 'pending') fa-clock
                                @elseif ($transaction->status_pembayaran == 'success') fa-check-circle
                                @elseif ($transaction->status_pembayaran == 'failed') fa-times-circle @endif
                            mr-1"></i>
                            {{ ucfirst($transaction->status_pembayaran) }}
                        </span>
                    </div>
                </div>

                <!-- Desktop: ID Transaksi -->
                <div class="hidden md:block md:col-span-2 font-bold flex items-center text-black">
                    <i class="text-white border border-black fas fa-receipt text-koplak mr-2 text-sm"></i>
                    {{ $transaction->midtrans_order_id ?? 'TRX-' . $transaction->id }}
                </div>

                <!-- Desktop: Tanggal -->
                <div class="hidden md:block md:col-span-2 font-bold flex items-center text-black">
                    <i class="far fa-calendar-alt text-red-500 mr-2 text-sm"></i>
                    {{ $transaction->created_at->format('d M Y H:i') }}
                </div>

                <!-- Mobile: Tanggal & Total -->
                <div class="md:hidden flex justify-between items-center mb-4">
                    <div class="flex items-center">
                        <i class="far fa-calendar-alt text-koplak mr-2"></i>
                        <div>
                            <div class="text-xs text-black">Tanggal</div>
                            <div class="text-sm text-black">
                                {{ $transaction->created_at->format('d M Y H:i') }}
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="text-xs text-black">Total Bayar</div>
                        <div class="font-bold text-black text-sm">
                            Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <!-- Desktop: Total Bayar -->
                <div class="hidden md:block md:col-span-2 font-bold text-black flex items-center">
                    <i class="text-green-500 fas fa-money-bill-wave mr-2 text-sm"></i>
                    Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}
                </div>

                <!-- Desktop: Status -->
                <div class="hidden md:block md:col-span-2">
                    <span class="px-3 py-1 rounded-full text-xs font-medium flex items-center w-fit
                        @if ($transaction->status_pembayaran == 'pending') bg-yellow-900 text-yellow-200
                        @elseif ($transaction->status_pembayaran == 'success') bg-green-900 text-green-200
                        @elseif ($transaction->status_pembayaran == 'failed') bg-red-900 text-red-200 @endif">
                        <i class="fas
                            @if ($transaction->status_pembayaran == 'pending') fa-clock
                            @elseif ($transaction->status_pembayaran == 'success') fa-check-circle
                            @elseif ($transaction->status_pembayaran == 'failed') fa-times-circle @endif
                        mr-1"></i>
                        {{ ucfirst($transaction->status_pembayaran) }}
                    </span>
                </div>

                <!-- Produk Section -->
                <div class="md:col-span-3 mb-4 md:mb-0">
                    <div class="text-xs text-white md:hidden mb-2 flex items-center font-bold text-black">
                        <i class="text-yellow-300 fas fa-box-open text-koplak mr-2"></i> Produk
                    </div>
                    <div class="space-y-3">
                        @foreach ($transaction->detailTransaksi as $detail)
                            <div class="flex items-center gap-3 p-3 bg-white border rounded-lg hover:bg-gray-500 transition-colors">
                                <img src="{{ asset('storage/' . $detail->produk->gambar_produk) }}"
                                    alt="{{ $detail->produk->nama_produk }}"
                                    class="w-12 h-12 md:w-14 md:h-14 object-cover rounded-md border border-gray-600">
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-black text-sm md:text-base truncate">{{ $detail->produk->nama_produk }}</p>
                                    <p class="text-xs md:text-sm text-black">
                                        {{ $detail->jumlah }} × Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Aksi Section -->
                <div class="md:col-span-1 flex md:justify-end">
                    <div class="w-full md:w-auto grid grid-cols-2 md:grid-cols-1 gap-2">
                        @if ($transaction->status_pembayaran == 'pending')
                            <button onclick="payTransaction('{{ $transaction->snap_token }}', '{{ $transaction->id }}')"
                                class="bg-koplak hover:bg-yellow-600 text-gray-900 px-3 py-2 rounded-lg text-xs font-medium flex items-center justify-center transition-colors">
                                <i class="fas fa-credit-card mr-1"></i><span class="hidden sm:inline">Bayar</span>
                            </button>
                            <button onclick="showNotificationAndRedirect('{{ route('transaksi.check-status', $transaction->id) }}')"
                                class="bg-gray-700 hover:bg-gray-600 text-gray-200 px-3 py-2 rounded-lg text-xs font-medium flex items-center justify-center transition-colors">
                                <i class="fas fa-sync-alt mr-1"></i><span class="hidden sm:inline">Cek</span>
                            </button>
                        @elseif ($transaction->status_pembayaran == 'success')
                            <a href="{{ route('transaksi.histori', $transaction->id) }}"
                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-xs font-medium flex items-center justify-center col-span-2 md:col-span-1 transition-colors">
                                <i class="fas fa-eye mr-1"></i><span>Detail</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
                <div class="p-8 text-center text-white">
                    <i class="fas fa-receipt text-4xl mb-4 text-koplak"></i>
                    <p class="text-lg">Tidak ada transaksi yang belum dibayar</p>
                    <a href="{{ route('home') }}" class="text-koplak hover:underline mt-4 inline-block font-medium">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke beranda
                    </a>
                </div>
            @endforelse
        </div>

        @if ($transaksi->hasPages())
            <div class="mt-6">
                {{ $transaksi->links() }}
            </div>
        @endif
    </div>

    <!-- Payment Modal -->
    <div id="payment-modal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-gray-800 rounded-xl p-6 w-full max-w-md border border-gray-700 transform transition-all duration-300 ease-out scale-95 opacity-0">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold flex items-center">
                    <i class="fas fa-credit-card text-koplak mr-2"></i> Proses Pembayaran
                </h2>
                <button onclick="closeModal()" class="text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="payment-details" class="mb-6">
                <!-- Content will be inserted here -->
            </div>
            <div class="flex justify-end space-x-3">
                <button onclick="closeModal()"
                    class="px-4 py-2 border border-gray-600 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors">
                    Batal
                </button>
                <button id="confirm-payment" class="px-4 py-2 bg-koplak hover:bg-koplak-dark text-gray-900 font-medium rounded-lg transition-colors">
                    Lanjutkan <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </div>
        </div>
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

        // Fungsi untuk memproses pembayaran
        function payTransaction(snapToken, transactionId) {
            if (!snapToken) {
                showAlert('error', 'Token pembayaran tidak valid. Silakan refresh halaman atau hubungi admin.');
                return;
            }

            // Tampilkan modal konfirmasi
            const modal = document.getElementById('payment-modal');
            const paymentDetails = document.getElementById('payment-details');

            paymentDetails.innerHTML = `
                <div class="mb-4">
                    <p class="text-white mb-1">Anda akan melakukan pembayaran untuk:</p>
                    <div class="bg-gray-750 p-3 rounded-lg border border-gray-700">
                        <div class="flex items-center">
                            <i class="fas fa-receipt text-koplak mr-2"></i>
                            <span class="font-medium">TRX-${transactionId}</span>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-750 p-3 rounded-lg border border-gray-700">
                    <div class="flex items-center text-sm text-gray-300 mb-2">
                        <i class="fas fa-info-circle text-koplak mr-2"></i>
                        <span>Pembayaran diproses melalui Midtrans</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-300">
                        <i class="fas fa-wallet text-koplak mr-2"></i>
                        <span>Pilih metode pembayaran pada halaman berikutnya</span>
                    </div>
                </div>
            `;

            // Show modal with animation
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.querySelector('.transform').classList.remove('scale-95', 'opacity-0');
            }, 10);

            document.getElementById('confirm-payment').onclick = function() {
                closeModal();
                processPayment(snapToken, transactionId);
            };
        }

        function closeModal() {
            const modal = document.getElementById('payment-modal');
            modal.querySelector('.transform').classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Fungsi untuk memproses pembayaran dengan Midtrans
        function processPayment(snapToken, transactionId) {
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    showAlert('success', 'Pembayaran berhasil!');
                    setTimeout(() => {
                        window.location.href = '{{ route('transaksi.histori') }}';
                    }, 1500);
                },
                onPending: function(result) {
                    showAlert('info', 'Pembayaran tertunda. Silakan selesaikan pembayaran Anda.');
                    setTimeout(() => {
                        window.location.href = '{{ route('transaksi.payment') }}';
                    }, 1500);
                },
                onError: function(result) {
                    showAlert('error', 'Pembayaran gagal. Silakan coba lagi atau hubungi admin.');
                },
                onClose: function() {
                    console.log('Widget pembayaran ditutup tanpa menyelesaikan pembayaran');
                }
            });
        }

        function showNotification() {
            const notification = document.getElementById('notification-popup');
            notification.classList.remove('hidden', 'opacity-0', 'translate-y-2');
            setTimeout(() => {
                notification.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => {
                    notification.classList.add('hidden');
                }, 300);
            }, 2000);
        }

        function showNotificationAndRedirect(url) {
            showNotification();
            setTimeout(() => {
                window.location.href = url;
            }, 2300);
        }

        function showAlert(type, message) {
            const colors = {
                success: 'bg-green-600',
                error: 'bg-red-600',
                info: 'bg-blue-600'
            };

            const icons = {
                success: 'fa-check-circle',
                error: 'fa-times-circle',
                info: 'fa-info-circle'
            };

            const alert = document.createElement('div');
            alert.className = `fixed top-4 right-4 ${colors[type]} text-white py-3 px-4 rounded-lg shadow-xl flex items-center transform transition-all duration-300 ease-out z-50`;
            alert.innerHTML = `
                <i class="fas ${icons[type]} mr-2"></i>
                <span>${message}</span>
            `;

            document.body.appendChild(alert);
            setTimeout(() => {
                alert.classList.remove('opacity-0', 'translate-y-2');
            }, 10);

            setTimeout(() => {
                alert.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }, 3000);
        }
    </script>
</body>
</html>
