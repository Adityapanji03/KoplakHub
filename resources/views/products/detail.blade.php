@extends('layouts.appCustomer-nav')

@section('content')
<div class="max-w-7xl mx-auto px-4 pt-16 pb-12">
    <div class="mb-6">
        <a href="{{ route('products') }}" class="font-bold rounded-lg border-b-8 bg-koplak border-black p-4 inline-flex items-center text-black hover:text-gray-600 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Produk
        </a>
    </div>

    {{-- START: New Wrapper Card --}}
    <div class="bg-white rounded-2xl p-8 shadow-xl border border-gray-800">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
            <div class="border-b-4 border-black bg-white rounded-2xl overflow-hidden shadow-xl border border-gray-800">
                <div class="relative">
                    <img src="{{ asset('storage/' . $product->gambar_produk) }}"
                         alt="{{ $product->nama_produk }}"
                         class="w-full h-auto object-cover transition-transform duration-500 hover:scale-105">
                    @if($product->stok_produk <= 0)
                    <div class="absolute inset-0 bg-white bg-opacity-70 flex items-center justify-center">
                        <span class="bg-red-600 text-white px-4 py-2 rounded-lg font-bold">STOK HABIS</span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <!-- Product Title and Rating -->
                <div>
                    <h1 class="text-3xl font-bold text-black">{{ $product->nama_produk }}</h1>
                    <div class="flex items-center mt-2">
                        @php $rating = $product->reviews->avg('rating') ?? 0; @endphp
                        <div class="flex text-koplak mr-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($rating))
                                    <i class="fas fa-star"></i>
                                @elseif($i - 0.5 <= $rating)
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="text-black text-sm">({{ $product->reviews->count() }} ulasan)</span>
                    </div>
                </div>

                <!-- Price and Stock -->
                <div class="border-b-4 border-black bg-white p-4 rounded-lg border border-gray-700">
                    <div class="flex items-end space-x-4">
                        <span class="text-2xl font-bold text-black">Rp {{ number_format($product->harga_produk, 0, ',', '.') }}</span>
                        @if($product->stok_produk > 0)
                        <span class="text-green-600 text-sm">
                            <i class="fas fa-check-circle mr-1"></i> Stok tersedia: {{ $product->stok_produk }}
                        </span>
                        @else
                        <span class="text-red-400 text-sm">
                            <i class="fas fa-times-circle mr-1"></i> Stok habis
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Product Description -->
                <div class="border-b-4 border-black bg-white p-5 rounded-lg border border-gray-800">
                    <h3 class="text-lg font-semibold text-black mb-3 flex items-center">
                        <i class="fas fa-info-circle text-koplak mr-2"></i>
                        Deskripsi Produk
                    </h3>
                    <p class="text-black leading-relaxed mb-6">{!! nl2br(e($product->deskripsi_produk)) !!}</p>

                    <!-- Services Section -->
                    <div class="mt-6 pt-6 border-t border-gray-800">
                        <h4 class="text-md font-semibold text-black mb-4">Layanan yang Anda dapatkan:</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 text-koplak mr-3 mt-1">
                                    <i class="fas fa-shipping-fast text-lg"></i>
                                </div>
                                <div>
                                    <h5 class="font-medium text-black">Pengiriman Cepat</h5>
                                    <p class="text-sm text-black">Pesanan dikirim dalam 1-2 hari kerja</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 text-koplak mr-3 mt-1">
                                    <i class="fas fa-shield-alt text-lg"></i>
                                </div>
                                <div>
                                    <h5 class="font-medium text-black">Garansi Produk</h5>
                                    <p class="text-sm text-black">Garansi 100% produk asli dan berkualitas</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 text-koplak mr-3 mt-1">
                                    <i class="fas fa-headset text-lg"></i>
                                </div>
                                <div>
                                    <h5 class="font-medium text-black">Dukungan 24/7</h5>
                                    <p class="text-sm text-black">Admin siap membantu kapan saja</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 text-koplak mr-3 mt-1">
                                    <i class="fas fa-exchange-alt text-lg"></i>
                                </div>
                                <div>
                                    <h5 class="font-medium text-black">Pengembalian Mudah</h5>
                                    <p class="text-sm text-black">Proses pengembalian produk yang simpel</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add to Cart Form -->
                @if($product->stok_produk > 0)
                <form action="{{ route('products.DetailaddToKeranjang') }}" method="POST" class="border-b-4 border-black space-y-5 bg-white p-5 rounded-lg border border-gray-800">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $product->id }}">

                    <div>
                        <label for="jumlah" class="block text-black mb-2">Jumlah</label>
                        <div class="flex items-center space-x-2">
                            <button type="button" id="decreaseQty" class="border-b-2 border-black w-10 h-10 flex items-center justify-center bg-gray-100 text-black rounded hover:bg-gray-700 transition">
                                −
                            </button>
                            <input
                                type="number"
                                id="jumlah"
                                name="jumlah"
                                value="1"
                                min="1"
                                max="{{ $product->stok_produk }}"
                                class="border-b-2 border-black w-20 text-center px-2 py-2 bg-gray-100 border border-gray-700 text-black rounded-lg focus:ring-2 focus:ring-koplak focus:outline-none"
                            >
                            <button type="button" id="increaseQty" class="border-b-2 border-black w-10 h-10 flex items-center justify-center bg-gray-100 text-black rounded hover:bg-gray-700 transition">
                                +
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="border-b-2 border-black flex-1 bg-koplak text-black font-bold py-3 px-6 rounded-lg hover:bg-koplak-dark transition flex items-center justify-center">
                            <i class="fas fa-cart-plus mr-2"></i> Tambahkan ke Keranjang
                        </button>
                    </div>
                </form>
                @else
                <div class="bg-white p-5 rounded-lg border border-gray-800 text-center">
                    <p class="text-black">Produk ini sedang tidak tersedia</p>
                    <a href="{{ route('products') }}" class="inline-block mt-3 text-koplak hover:underline">
                        <i class="fas fa-arrow-left mr-1"></i> Lihat Produk Lainnya
                    </a>
                </div>
                @endif

                @if(session('error'))
                <div class="p-4 bg-red-900 border border-red-700 text-red-100 rounded-lg">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                </div>
                @endif
            </div>
        </div>
    </div>


    <!-- Reviews Section -->
    <div class="mt-16">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-black flex items-center">
                <i class="fas fa-star text-koplak mr-2"></i>
                Ulasan Pelanggan
            </h2>
            {{-- @if(auth()->check() && !$product->reviews->where('akun_id', auth()->id())->count())
            <button id="showReviewForm" class="text-koplak hover:text-koplak-dark hover:underline">
                <i class="fas fa-pen mr-1"></i> Tulis Ulasan
            </button>
            @endif --}}
        </div>

        {{-- <!-- Review Form (Hidden by default) -->
        @if(auth()->check() && !$product->reviews->where('akun_id', auth()->id())->count())
        <div id="reviewForm" class="hidden bg-white p-6 rounded-lg border border-gray-800 mb-8">
            <form action="{{ route('products.addReview', $product->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-black mb-2">Rating</label>
                    <div class="rating-stars flex space-x-1">
                        @for($i = 1; $i <= 5; $i++)
                        <i class="far fa-star text-2xl text-black cursor-pointer hover:text-koplak"
                           data-rating="{{ $i }}"></i>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="ratingValue" value="0">
                </div>
                <div class="mb-4">
                    <label for="review" class="block text-black mb-2">Ulasan Anda</label>
                    <textarea name="review" id="review" rows="4"
                              class="w-full px-3 py-2 bg-gray-800 border border-gray-700 text-black rounded-lg focus:ring-2 focus:ring-koplak focus:outline-none"
                              placeholder="Bagikan pengalaman Anda tentang produk ini"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancelReview" class="mr-3 px-4 py-2 bg-gray-700 text-black rounded-lg hover:bg-gray-600 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-koplak text-black font-bold rounded-lg hover:bg-koplak-dark transition">
                        Kirim Ulasan
                    </button>
                </div>
            </form>
        </div>
        @endif --}}

        <!-- Reviews List -->
        @if($product->reviews->where('is_published', true)->count() > 0)
        <div class="space-y-6">
            @foreach($product->reviews->where('is_published', true) as $review)
            <div class="bg-white p-6 rounded-lg border border-gray-800 animate-fade-in">
                <div class="flex items-start">
                    <div class="flex-shrink-0 mr-4">
                        <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-koplak">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center mb-1">
                            <span class="font-semibold text-black">{{ $review->akun->nama }}</span>
                            <span class="mx-2 text-gray-500">•</span>
                            <div class="flex text-koplak text-sm">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="mx-2 text-gray-500">•</span>
                            <span class="text-black text-sm">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-black mb-3">{{ $review->review }}</p>

                        <!-- Admin Reply -->
                        @if($review->reply)
                        <div class="bg-gray-800 p-4 rounded-lg border-l-4 border-koplak mt-3">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 rounded-full bg-koplak text-black flex items-center justify-center mr-2">
                                    <i class="fas fa-crown text-xs"></i>
                                </div>
                                <span class="font-semibold text-koplak">Admin KoplakFood</span>
                            </div>
                            <p class="text-white">{{ $review->reply->reply }}</p>
                            <div class="text-right">
                                <span class="text-white text-xs">{{ $review->reply->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white p-8 rounded-lg border border-gray-800 text-center">
            <i class="fas fa-comment-slash text-4xl text-gray-600 mb-3"></i>
            <p class="text-black">Belum ada ulasan untuk produk ini</p>
            @if(auth()->check())
            <button id="showFirstReview" class="mt-3 text-koplak hover:text-koplak-dark hover:underline">
                Jadilah yang pertama memberikan ulasan
            </button>
            @else
            <p class="mt-3 text-black">Silakan <a href="{{ route('login') }}" class="text-koplak hover:underline">login</a> untuk memberikan ulasan</p>
            @endif
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Quantity controls
        const decreaseBtn = document.getElementById('decreaseQty');
        const increaseBtn = document.getElementById('increaseQty');
        const jumlahInput = document.getElementById('jumlah');

        if (decreaseBtn && increaseBtn && jumlahInput) {
            const maxQty = parseInt(jumlahInput.max);

            decreaseBtn.addEventListener('click', function () {
                let currentValue = parseInt(jumlahInput.value);
                if (currentValue > 1) {
                    jumlahInput.value = currentValue - 1;
                }
            });

            increaseBtn.addEventListener('click', function () {
                let currentValue = parseInt(jumlahInput.value);
                if (currentValue < maxQty) {
                    jumlahInput.value = currentValue + 1;
                }
            });
        }

        // Review form toggle
        const showReviewBtn = document.getElementById('showReviewForm');
        const showFirstReviewBtn = document.getElementById('showFirstReview');
        const reviewForm = document.getElementById('reviewForm');
        const cancelReviewBtn = document.getElementById('cancelReview');

        if (showReviewBtn && reviewForm) {
            showReviewBtn.addEventListener('click', function() {
                reviewForm.classList.remove('hidden');
                reviewForm.scrollIntoView({ behavior: 'smooth' });
            });
        }

        if (showFirstReviewBtn && reviewForm) {
            showFirstReviewBtn.addEventListener('click', function() {
                reviewForm.classList.remove('hidden');
                reviewForm.scrollIntoView({ behavior: 'smooth' });
            });
        }

        if (cancelReviewBtn && reviewForm) {
            cancelReviewBtn.addEventListener('click', function() {
                reviewForm.classList.add('hidden');
            });
        }

        // Star rating
        const stars = document.querySelectorAll('.rating-stars i');
        const ratingValue = document.getElementById('ratingValue');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                ratingValue.value = rating;

                stars.forEach((s, index) => {
                    if (index < rating) {
                        s.classList.remove('far');
                        s.classList.add('fas');
                    } else {
                        s.classList.remove('fas');
                        s.classList.add('far');
                    }
                });
            });

            star.addEventListener('mouseover', function() {
                const hoverRating = parseInt(this.getAttribute('data-rating'));

                stars.forEach((s, index) => {
                    if (index < hoverRating) {
                        s.classList.add('text-koplak');
                    } else {
                        s.classList.remove('text-koplak');
                    }
                });
            });

            star.addEventListener('mouseout', function() {
                const currentRating = parseInt(ratingValue.value);

                stars.forEach((s, index) => {
                    if (index >= currentRating) {
                        s.classList.remove('text-koplak');
                    }
                });
            });
        });
    });
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.6s ease-out forwards;
    }
</style>
@endsection
