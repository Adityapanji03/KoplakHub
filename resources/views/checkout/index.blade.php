@extends('layouts.appCustomer-nav')

@section('content')
<div class="container mx-auto px-4 py-12">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ url()->previous() }}" class="p-2 border-b-2 border-black rounded bg-koplak font-bold inline-flex items-center text-black hover:text-black-dark transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>

    <h1 class="text-3xl font-bold text-black mb-8">Ringkasan Pesanan</h1>

    @if(session('success'))
        <div class="bg-green-900 border border-green-600 text-green-100 px-4 py-3 rounded-lg mb-6 animate-fade-in">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-900 border border-red-600 text-red-100 px-4 py-3 rounded-lg mb-6 animate-fade-in">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Left Column - Order Items -->
        <div class="lg:w-2/3">
            <div class="bg-gray-100 rounded-xl shadow-lg p-6 border border-gray-800">
                <h2 class="text-xl font-semibold text-black mb-6 flex items-center">
                    <i class="fas fa-shopping-basket mr-2"></i>
                    Ringkasan Produk
                </h2>

                <div class="divide-y divide-gray-800">
                    @foreach($keranjangItems as $item)
                    <div class="py-4 flex items-start hover:bg-koplak transition px-2 rounded-lg">
                        <div class="w-20 h-20 rounded-lg overflow-hidden border border-gray-700 flex-shrink-0">
                            <img src="{{ asset('storage/' . $item->produk->gambar_produk) }}"
                                 alt="{{ $item->produk->nama_produk }}"
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="ml-4 flex-grow">
                            <h3 class="font-medium  text-black">{{ $item->produk->nama_produk }}</h3>
                            <div class="flex justify-between mt-2">
                                <span class="text-black">Rp {{ number_format($item->harga, 0, ',', '.') }} × {{ $item->jumlah }}</span>
                                <span class="font-medium text-black">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="bg-gray-100 rounded-xl shadow-lg p-6 border border-gray-800 mt-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-black flex items-center">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        Alamat Pengiriman
                    </h2>
                    <a href="{{ route('profile.edit') }}" class="text-black hover:text-black-dark text-sm flex items-center">
                        <i class="fas fa-edit mr-1"></i> Ubah
                    </a>
                </div>

                <!-- Tambahkan di bagian atas view untuk menampilkan error -->
                @if(isset($error))
                <div class="bg-red-900 border border-red-600 text-red-100 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ $error }}
                        @if(empty($akun->provinsi) || empty($akun->kabupaten_kota))
                            <a href="{{ route('profile.edit') }}" class="ml-2 text-white underline">
                                Lengkapi Alamat Sekarang
                            </a>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Shipping Options -->
                <div class="bg-gray-100 rounded-xl shadow-lg p-6 border border-gray-800 mt-6">
                    <h2 class="text-xl font-semibold text-black mb-6 flex items-center">
                        <i class="fas fa-truck mr-2"></i>
                        Opsi Pengiriman
                    </h2>

                    @if(!empty($availableCouriers))
                        <div class="space-y-4" id="shipping-options">
                            @foreach($availableCouriers as $courierCode => $courier)
                                <div class="courier-group">
                                    <h3 class="font-bold text-black mb-2 flex items-center">
                                        @if($courierCode == 'jnt')
                                            <i class="fas fa-shipping-fast mr-2 text-red-600"></i>
                                        @endif
                                        {{ $courier['name'] }}
                                    </h3>
                                    <div class="space-y-3 ml-6">
                                        @foreach($courier['services'] as $service)
                                            <div class="flex items-center bg-white rounded-lg p-4 border border-gray-300 hover:border-red-400 transition-colors">
                                                <input type="radio"
                                                    name="shipping_method"
                                                    id="shipping-{{ $courierCode }}-{{ $loop->index }}"
                                                    value="{{ $courierCode }}|{{ $service['service'] }}|{{ $service['cost'] }}"
                                                    class="form-radio h-5 w-5 text-red-500 shipping-option focus:ring-red-500"
                                                    data-cost="{{ $service['cost'] }}"
                                                    @if($courierCode == 'jnt' && $loop->first) checked @endif>
                                                <label for="shipping-{{ $courierCode }}-{{ $loop->index }}" class="ml-3 flex-grow cursor-pointer">
                                                    <div class="flex justify-between items-start">
                                                        <div>
                                                            <span class="font-semibold text-black text-lg">{{ $service['service'] }}</span>
                                                            <div class="text-sm text-gray-600 mt-1">
                                                                <i class="fas fa-box mr-1"></i>
                                                                {{ $service['description'] }}
                                                            </div>
                                                            <div class="text-sm text-gray-600 mt-1">
                                                                <i class="fas fa-clock mr-1"></i>
                                                                Estimasi pengiriman: {{ $service['etd'] }}
                                                            </div>
                                                        </div>
                                                        <div class="text-right">
                                                            <span class="text-red-600 font-bold text-lg">Rp {{ number_format($service['cost'], 0, ',', '.') }}</span>
                                                            <div class="text-xs text-gray-500 mt-1">Berat: {{ number_format($beratTotal/1000, 1) }} kg</div>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Informasi Tambahan -->
                        <div class="mt-4 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        <strong>Informasi Pengiriman:</strong>
                                    </p>
                                    <ul class="text-xs text-blue-600 mt-1 list-disc list-inside">
                                        <li>Barang akan dikirim dari Jember</li>
                                        <li>Estimasi waktu dapat berbeda tergantung kondisi cuaca dan operasional</li>
                                        <li>Pastikan alamat pengiriman sudah benar dan lengkap</li>
                                        <li>Nomor resi akan dikirim via WhatsApp/Email setelah barang dikirim</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-yellow-900 border border-yellow-700 text-yellow-100 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle mr-3 text-yellow-400"></i>
                                <div>
                                    <p class="font-semibold">Tidak dapat menampilkan opsi pengiriman</p>
                                    <p class="text-sm mt-1">Pastikan data berikut sudah lengkap:</p>
                                </div>
                            </div>
                            <ul class="list-disc list-inside mt-3 text-sm ml-6">
                                <li>Alamat pengiriman sudah diisi lengkap di profil</li>
                                <li>Provinsi sudah dipilih dengan benar</li>
                                <li>Kabupaten/kota sudah diisi</li>
                            </ul>
                            <div class="mt-3">
                                <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-lg transition-colors">
                                    <i class="fas fa-edit mr-2"></i>
                                    Lengkapi Profil
                                </a>
                            </div>
                        </div>

                        @if($error)
                            <div class="bg-red-900 border border-red-700 text-red-100 px-4 py-3 rounded-lg mt-4">
                                <div class="flex items-center">
                                    <i class="fas fa-times-circle mr-3 text-red-400"></i>
                                    <p class="font-semibold">Error: {{ $error }}</p>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
                @if($user)
                <div class="bg-gray-100 rounded-lg p-4 border border-gray-700">
                    <h3 class="font-medium text-black">{{ $user->nama }}</h3>
                    <p class="text-black mt-2">
                        <i class="fas fa-phone-alt mr-2"></i> {{ $user->nomor_hp }}
                    </p>
                    <div class="mt-3 text-black">
                        <i class="fas fa-home mr-2"></i>
                        {{ $user->detail_alamat }},
                        Kel. {{ $user->kelurahan }}, Kec. {{ $user->kecamatan }},
                        {{ $user->kabupaten_kota }}, {{ $user->provinsi }}
                    </div>
                </div>
                @else
                <div class="bg-yellow-900 border border-yellow-700 text-yellow-100 px-4 py-3 rounded-lg flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <span>
                        Anda belum menambahkan alamat. Harap tambahkan alamat terlebih dahulu di
                        <a href="{{ route('profile.edit') }}" class="underline font-medium text-black">profil Anda</a>.
                    </span>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Column - Payment Summary -->
        <div class="lg:w-1/3">
            <div class="bg-gray-100 rounded-xl shadow-lg p-6 border border-gray-800 sticky top-6">
                <h2 class="text-xl font-semibold text-black mb-6 flex items-center">
                    <i class="fas fa-receipt mr-2"></i>
                    Ringkasan Pembayaran
                </h2>

                <div class="space-y-4">
                    <div class="flex justify-between text-black">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-black">
                        <span>Biaya Pengiriman</span>
                        <span>Rp {{ number_format($biayaPengiriman, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-gray-800 pt-4 flex justify-between text-lg font-semibold text-black">
                        <span>Total</span>
                        <span class="text-black">Rp {{ number_format($total + $biayaPengiriman, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-black mb-4 flex items-center">
                        <i class="fas fa-credit-card mr-2"></i>
                        Metode Pembayaran
                    </h3>

                    <div class="space-y-3 font-bold mt-4 text-xs text-gray-500 text-center">
                        Setelah mengeklik checkout anda dapat membayar melalui gateway midtrans
                    </div>
                </div>

                <!-- Checkout Button -->
                <form id="checkout-form" action="{{ route('transaksi.store') }}" method="POST" class="mt-8">
                    @csrf
                    <input type="hidden" name="metode_pembayaran" value="transfer">
                    <input type="hidden" name="shipping_cost" id="shipping_cost_input" value="{{ $biayaPengiriman }}">
                    <input type="hidden" name="shipping_method" id="shipping_method_input" value="">
                    <input type="hidden" name="berat_total" value="{{ $beratTotal }}">

                    <button type="button" id="pay-button" class="w-full py-3 bg-koplak text-black font-bold rounded-lg hover:bg-koplak-dark transition flex items-center justify-center">
                        <i class="fas fa-lock mr-2"></i>
                        Bayar Sekarang
                    </button>
                </form>

                <div class="font-bold mt-4 text-xs text-gray-500 text-center">
                    Dengan melanjutkan, Anda menyetujui
                    <a href="#" class="text-black hover:underline">Syarat & Ketentuan</a> kami.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Update shipping method saat form submit
    document.getElementById('checkout-form').addEventListener('submit', function() {
        const selectedOption = document.querySelector('.shipping-option:checked');
        if (selectedOption) {
            document.getElementById('shipping_method_input').value = selectedOption.value;
        }
    });
</script>

<!-- JavaScript untuk update total -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const shippingOptions = document.querySelectorAll('.shipping-option');
        const totalElement = document.getElementById('total-pembayaran');
        const shippingCostElement = document.getElementById('shipping-cost');
        const baseTotal = {{ $total }};

        shippingOptions.forEach(option => {
            option.addEventListener('change', function() {
                if (this.checked) {
                    const shippingCost = parseInt(this.dataset.cost);
                    const newTotal = baseTotal + shippingCost;

                    // Update shipping cost display
                    if (shippingCostElement) {
                        shippingCostElement.textContent = 'Rp ' + shippingCost.toLocaleString('id-ID');
                    }

                    // Update total payment
                    if (totalElement) {
                        totalElement.textContent = 'Rp ' + newTotal.toLocaleString('id-ID');
                    }
                }
            });
        });
    });
    </script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    // Checkout confirmation
    document.getElementById('pay-button').addEventListener('click', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Konfirmasi Pembayaran',
            html: `Anda akan melakukan pembayaran sebesar <b>Rp ${({{ $total }} + {{ $biayaPengiriman }}).toLocaleString('id-ID')}</b>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#F57F17',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Lanjutkan Pembayaran',
            cancelButtonText: 'Batal',
            background: '#fff',
            color: '#000',
            customClass: {
                confirmButton: 'text-white font-bold py-2 px-4 rounded',
                cancelButton: 'text-white font-bold py-2 px-4 rounded'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('checkout-form').submit();
            }
        });
    });

    // Animation for elements
    document.querySelectorAll('.animate-fade-in').forEach((el, index) => {
        el.style.animationDelay = `${index * 0.1}s`;
    });
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }
    .form-radio {
        border-color: #6B7280;
    }
    .form-radio:checked {
        background-color: #FFEB3B;
        border-color: #FFEB3B;
    }
</style>
@endsection
