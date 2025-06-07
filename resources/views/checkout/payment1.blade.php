<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @midtransScript
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <a href="/" class="text-xl font-bold text-indigo-600">NamaToko</a>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">Hi, {{ Auth::user()->name }}</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Left Column - Payment Info -->
                    <div class="lg:w-2/3">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-6">Metode Pembayaran</h2>

                            <!-- Payment Container -->
                            <div id="payment-container" class="mb-6">
                                <!-- Midtrans Payment Form will be rendered here -->
                                <button id="pay-button" class="hidden">Bayar Sekarang</button>
                            </div>

                            <!-- Order Summary -->
                            <div class="border-t border-gray-200 pt-6">
                                <h3 class="text-lg font-medium text-gray-800 mb-4">Ringkasan Pesanan</h3>
                                <div class="space-y-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Subtotal</span>
                                        <span class="text-gray-800">@money($transaksi->total_harga)</span>
                                    </div>
                                    {{-- <div class="flex justify-between">
                                        <span class="text-gray-600">Biaya Pengiriman</span>
                                        <span class="text-gray-800">@money($transaksi->biaya_pengiriman)</span>
                                    </div> --}}
                                    <div class="flex justify-between border-t border-gray-200 pt-4">
                                        <span class="text-lg font-semibold">Total Pembayaran</span>
                                        <span class="text-lg font-semibold text-indigo-600">@money($transaksi->total_bayar)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Order Details -->
                    <div class="lg:w-1/3">
                        <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                            <h2 class="text-xl font-semibold text-gray-800 mb-6">Detail Pesanan</h2>

                            <!-- Order ID -->
                            <div class="mb-4">
                                <span class="block text-sm text-gray-500">ID Transaksi</span>
                                <span class="font-medium">{{ $transaksi->midtrans_order_id }}</span>
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <span class="block text-sm text-gray-500">Status</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Menunggu Pembayaran
                                </span>
                            </div>

                            <!-- Shipping Address -->
                            <div class="mb-4">
                                <span class="block text-sm text-gray-500">Alamat Pengiriman</span>
                                @php
                                    $alamat = json_decode($transaksi->alamat_pengiriman, true);
                                @endphp
                                <address class="not-italic mt-1">
                                    {{ $alamat['detail_alamat'] }},<br>
                                    {{ $alamat['kelurahan'] }}, {{ $alamat['kecamatan'] }},<br>
                                    {{ $alamat['kabupaten'] }}, {{ $alamat['provinsi'] }}
                                </address>
                            </div>

                            <!-- Contact -->
                            <div>
                                <span class="block text-sm text-gray-500">Kontak</span>
                                <div class="mt-1">
                                    <p>{{ Auth::user()->name }}</p>
                                    <p class="text-gray-600">{{ $alamat['no_hp'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <p class="text-center text-gray-500 text-sm">&copy; {{ date('Y') }} NamaToko. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <!-- Midtrans Payment Script -->
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // For example trigger on button clicked, or any time you need
            var payButton = document.getElementById('pay-button');

            // Configure Midtrans
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    /* You may add your own implementation here */
                    console.log(result);
                    window.location.href = "{{ route('home', $transaksi->id) }}";
                },
                onPending: function(result){
                    /* You may add your own implementation here */
                    console.log(result);
                    window.location.href = "{{ route('home', $transaksi->id) }}";
                },
                onError: function(result){
                    /* You may add your own implementation here */
                    console.log(result);
                    window.location.href = "{{ route('checkout.failed') }}";
                },
                onClose: function(){
                    /* You may add your own implementation here */
                    console.log('customer closed the popup without finishing the payment');
                }
            });
        });
    </script>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{env('MIDTRANS_CLIENT_KEY')}}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(){
        // SnapToken acquired from previous step
        snap.pay('<?=$snapToken?>', {
            // Optional
            onSuccess: function(result){
            /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            },
            // Optional
            onPending: function(result){
            /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            },
            // Optional
            onError: function(result){
            /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            }
        });
        };
    </script>
</body>
</html>
