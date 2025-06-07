@extends('layouts.appCustomer-nav')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Review Your Purchases</h1>

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

    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Order #{{ $transaction->id }}</h2>
        <p class="text-gray-600 mb-2">Order Date: {{ $transaction->created_at->format('d M Y, H:i') }}</p>

        <div class="mt-8">
            @foreach($transaction->detailTransaksi as $index => $item)
            <div class="border rounded-lg p-6 mb-6">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-4 mb-4">
                    <div class="flex-shrink-0">
                        @if($item->produk->gambar_produk)
                            <img src="{{ asset('storage/' . $item->produk->gambar_produk) }}" alt="{{ $item->produk->nama }}" class="w-20 h-20 object-cover rounded-md">
                        @else
                            <div class="w-20 h-20 bg-gray-200 rounded-md flex items-center justify-center">
                                <span class="text-gray-500">No Image</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow">
                        <h3 class="font-medium text-lg">{{ $item->produk->nama }}</h3>
                        <p class="text-gray-500">Quantity: {{ $item->jumlah }} × Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        <p class="font-medium mt-1">Total: Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    @if(in_array($item->produk->id, $existingReviews))
                        <div class="bg-gray-50 p-4 rounded-md">
                            <p class="text-gray-600">You have already reviewed this product.</p>
                            <a href="{{ route('customer.reviews.index') }}" class="text-blue-600 hover:underline mt-2 inline-block">
                                View your reviews
                            </a>
                        </div>
                    @else
                        <h4 class="font-medium text-lg mb-3">Your Review</h4>
                        <form action="{{ route('customer.reviews.store') }}" method="POST" id="reviewForm{{ $index }}">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $item->produk->id }}">
                            <input type="hidden" name="transaksi_id" value="{{ $transaction->id }}">

                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">Rating</label>
                                <div class="flex items-center">
                                    <div class="rating rating-group">
                                        <input type="hidden" name="rating" id="rating{{ $index }}" value="0">
                                        <div class="flex space-x-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <button
                                                    type="button"
                                                    class="rating-star text-2xl focus:outline-none transition-colors duration-200"
                                                    data-value="{{ $i }}"
                                                    data-form-index="{{ $index }}"
                                                    onclick="setRating({{ $index }}, {{ $i }})"
                                                >
                                                    <span class="star-inactive">☆</span>
                                                    <span class="star-active hidden">★</span>
                                                </button>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                @error('rating')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="review{{ $index }}" class="block text-sm font-medium mb-2">Comments</label>
                                <textarea
                                    id="review{{ $index }}"
                                    name="review"
                                    rows="4"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Share your thoughts about this product..."
                                ></textarea>
                                @error('review')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end">
                                <button
                                    type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                >
                                    Submit Review
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    function setRating(formIndex, value) {
        // Update hidden input with selected rating value
        document.getElementById('rating' + formIndex).value = value;

        // Update star appearance
        const stars = document.querySelectorAll('.rating-star[data-form-index="' + formIndex + '"]');
        stars.forEach((star, index) => {
            const activeSpan = star.querySelector('.star-active');
            const inactiveSpan = star.querySelector('.star-inactive');

            if (index < value) {
                // Selected stars
                activeSpan.classList.remove('hidden');
                inactiveSpan.classList.add('hidden');
                star.classList.add('text-yellow-400');
            } else {
                // Unselected stars
                activeSpan.classList.add('hidden');
                inactiveSpan.classList.remove('hidden');
                star.classList.remove('text-yellow-400');
            }
        });
    }

    // Initialize star rating functionality
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form[id^="reviewForm"]');
        forms.forEach((form, index) => {
            // Add submit handling if needed
            form.addEventListener('submit', function(e) {
                const rating = document.getElementById('rating' + index).value;
                if (rating === '0') {
                    e.preventDefault();
                    alert('Please select a rating before submitting');
                }
            });
        });
    });
</script>
@endsection
