@extends('layouts.appCustomer-nav')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-200">
    <div class="container mx-auto px-4 py-8 lg:py-12">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 lg:mb-12 gap-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-koplak rounded-full shadow-lg">
                    <i class="fas fa-star text-black text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-black font-montserrat">Your Reviews</h1>
                    <p class="text-black text-sm mt-1">Berikut adalah produk yang telah kamu review</p>
                </div>
            </div>
            <a href="{{ route('home') }}" class="border-b-4 border-black bg-gradient-to-r from-koplak to-koplak-dark hover:from-koplak-dark hover:to-koplak-darker text-black px-4 py-2.5 rounded-lg text-sm font-semibold flex items-center justify-center transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl min-w-max">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="hidden sm:inline">Kembali</span>
                <span class="sm:hidden">Back</span>
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-gradient-to-r from-green-500/20 to-green-600/20 border border-green-500/50 text-green-300 px-6 py-4 rounded-xl mb-6 backdrop-blur-sm animate-fade-in">
            <div class="flex items-center gap-3">
                <i class="fas fa-check-circle text-green-400"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <!-- Reviews Grid -->
        <div class="space-y-6">
            @forelse($reviews as $review)
            <div class="border-b-2 border-koplak bg-white rounded-2xl p-6 lg:p-8 shadow-2xl hover:shadow-koplak/10 transition-all duration-300 transform hover:-translate-y-1 animate-fade-in">
                <!-- Product Info Header -->
                <div class="flex flex-col lg:flex-row items-start lg:items-center gap-4 lg:gap-6 mb-6">
                    <div class="flex-shrink-0 relative group">
                        @if($review->produk->gambar_produk)
                            <img src="{{ asset('storage/' . $review->produk->gambar_produk) }}" alt="{{ $review->produk->nama }}" class="w-20 h-20 lg:w-24 lg:h-24 object-cover rounded-xl shadow-lg group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute inset-0 bg-koplak/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        @else
                            <div class="w-20 h-20 lg:w-24 lg:h-24 bg-gradient-to-br from-gray-700 to-gray-800 rounded-xl flex items-center justify-center border border-gray-600">
                                <i class="fas fa-image text-black text-xl"></i>
                            </div>
                        @endif
                    </div>

                    <div class="flex-grow min-w-0">
                        <h3 class="font-bold text-lg lg:text-xl text-white mb-2 font-montserrat truncate">{{ $review->produk->nama }}</h3>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 text-sm">
                            <div class="flex items-center gap-2 text-black">
                                <i class="fas fa-receipt text-koplak"></i>
                                <span class="text-black">Transaction #{{ $review->transaksi_id }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-black">
                                <i class="fas fa-calendar-alt text-koplak"></i>
                                <span class="text-black">{{ $review->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rating Section -->
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-3">
                        <i class="fas fa-star text-koplak"></i>
                        <label class="text-sm font-semibold text-black font-montserrat">Your Rating</label>
                    </div>
                    <div class="flex items-center gap-3 p-4 bg-gray-900 rounded-xl border border-gray-700/50">
                        <div class="flex space-x-1">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="text-2xl lg:text-3xl transition-all duration-200 {{ $i <= $review->rating ? 'text-koplak drop-shadow-lg' : 'text-gray-600' }}">
                                    ★
                                </span>
                            @endfor
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-lg font-bold text-white">{{ $review->rating }}</span>
                            <span class="text-white text-sm">/5</span>
                            <div class="hidden sm:block w-px h-4 bg-gray-600 mx-2"></div>
                            <span class="hidden sm:inline text-sm text-white font-medium">
                                @if($review->rating >= 4.5) Excellent
                                @elseif($review->rating >= 4) Very Good
                                @elseif($review->rating >= 3) Good
                                @elseif($review->rating >= 2) Fair
                                @else Poor
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Review Content -->
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <i class="fas fa-comment-dots text-black"></i>
                        <label class="text-sm font-semibold text-black font-montserrat">Your Review</label>
                    </div>
                    <div class="bg-gray-900 border border-gray-700/50 p-6 rounded-xl">
                        @if($review->review)
                            <p class="text-white leading-relaxed">{{ $review->review }}</p>
                        @else
                            <div class="flex items-center gap-3 text-gray-500">
                                <i class="fas fa-info-circle"></i>
                                <span class="italic">No review comment provided</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <!-- Empty State -->
            <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-8 lg:p-12 text-center shadow-2xl">
                <div class="mb-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-koplak/20 to-koplak-dark/20 rounded-full mb-4">
                        <i class="fas fa-star-half-alt text-4xl text-koplak"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2 font-montserrat">No Reviews Yet</h3>
                    <p class="text-black mb-6">Anda belum membuat review apapun.</p>
                </div>
                <a href="{{ route('products') }}" class="inline-flex items-center gap-3 bg-gradient-to-r from-koplak to-koplak-dark hover:from-koplak-dark hover:to-koplak-darker text-black px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Buat pesanan dan review terlebih dahulu</span>
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($reviews->hasPages())
        <div class="mt-8 lg:mt-12">
            <div class="flex justify-center">
                <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 rounded-xl p-4">
                    {{ $reviews->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Custom Styles -->
<style>
    /* Custom pagination styles */
    .pagination {
        @apply flex items-center gap-2;
    }
    .pagination .page-link {
        @apply px-3 py-2 text-sm font-medium text-black bg-gray-700/50 border border-gray-600 rounded-lg hover:bg-koplak hover:text-black transition-all duration-200;
    }
    .pagination .page-item.active .page-link {
        @apply bg-koplak text-black border-koplak;
    }
    .pagination .page-item.disabled .page-link {
        @apply text-gray-500 bg-gray-800 border-gray-700 cursor-not-allowed;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .container {
            @apply px-3;
        }
    }

    /* Animation keyframes */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    'koplak': '#FFEB3B',
                    'koplak-dark': '#FBC02D',
                    'koplak-darker': '#F57F17',
                },
                fontFamily: {
                    'montserrat': ['Montserrat', 'sans-serif'],
                },
                animation: {
                    'fade-in': 'fadeIn 0.6s ease-out forwards',
                }
            }
        }
    }

    // Add smooth scroll behavior and enhanced interactions
    document.addEventListener('DOMContentLoaded', function() {
        // Add stagger animation to review cards
        const reviewCards = document.querySelectorAll('.animate-fade-in');
        reviewCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });

        // Add hover effects to rating stars
        const starContainers = document.querySelectorAll('.flex.space-x-1');
        starContainers.forEach(container => {
            const stars = container.querySelectorAll('span');
            stars.forEach((star, index) => {
                star.addEventListener('mouseenter', () => {
                    stars.forEach((s, i) => {
                        if (i <= index) {
                            s.style.transform = 'scale(1.1)';
                        }
                    });
                });
                star.addEventListener('mouseleave', () => {
                    stars.forEach(s => {
                        s.style.transform = 'scale(1)';
                    });
                });
            });
        });
    });
</script>
@endsection
