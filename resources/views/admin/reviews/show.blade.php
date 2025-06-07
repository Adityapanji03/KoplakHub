@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 mt-14 p-4 sm:ml-64 bg-gray-50 min-h-screen">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <h1 class="text-2xl font-bold text-black flex items-center">
            <i class="fas fa-star text-koplak mr-2"></i> Review Detail
        </h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.reviews.index') }}" class="font-bold border border-b-4 border-koplak bg-black hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm flex items-center justify-center transition-colors duration-200 shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Reviews
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-800 border border-green-600 text-green-100 px-4 py-3 rounded-lg mb-4 flex items-center">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-800 border border-red-600 text-red-100 px-4 py-3 rounded-lg mb-4 flex items-center">
        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
    </div>
    @endif

    <!-- Review Detail Card -->
    <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden mb-6 border border-gray-700">
        <div class="p-6">
            <!-- Product and Customer Info -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Product Info -->
                <div class="bg-gray-750 p-4 rounded-xl border border-gray-700">
                    <h3 class="font-semibold text-lg text-koplak mb-3 flex items-center">
                        <i class="fas fa-box-open mr-2"></i> Product Information
                    </h3>
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            @if($review->produk->gambar_produk)
                                <img src="{{ asset('storage/' . $review->produk->gambar_produk) }}" alt="{{ $review->produk->nama_produk }}" class="w-20 h-20 object-cover rounded-lg border-2 border-koplak">
                            @else
                                <div class="w-20 h-20 bg-gray-700 rounded-lg flex items-center justify-center border-2 border-gray-600">
                                    <i class="fas fa-image text-gray-500"></i>
                                </div>
                            @endif
                        </div>
                        <div class="text-gray-300">
                            <p class="font-medium text-white">{{ $review->produk->nama_produk }}</p>
                            <p class="text-sm"><i class="fas fa-hashtag mr-1 text-gray-400"></i> {{ $review->produk_id }}</p>
                            <p class="text-sm"><i class="fas fa-tag mr-1 text-gray-400"></i> Rp {{ number_format($review->produk->harga_produk, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="bg-gray-750 p-4 rounded-xl border border-gray-700">
                    <h3 class="font-semibold text-lg text-koplak mb-3 flex items-center">
                        <i class="fas fa-user-circle mr-2"></i> Customer Information
                    </h3>
                    <div class="text-gray-300">
                        <p class="font-medium text-white flex items-center">
                            <i class="fas fa-user mr-2 text-gray-400"></i> {{ $review->akun->nama }}
                        </p>
                        <p class="text-sm mt-2"><i class="fas fa-phone-alt mr-2 text-gray-400"></i> {{ $review->akun->nomor_hp }}</p>
                        <p class="text-sm mt-2"><i class="fas fa-calendar-alt mr-2 text-gray-400"></i> Member since {{ $review->akun->created_at->format('d M Y') }}</p>
                        <p class="text-sm mt-2"><i class="fas fa-receipt mr-2 text-gray-400"></i> Transaction ID: #{{ $review->transaksi_id }}</p>
                    </div>
                </div>
            </div>

            <!-- Review Content -->
            <div class="mb-6">
                <h3 class="font-semibold text-lg text-koplak mb-3 flex items-center">
                    <i class="fas fa-clipboard-list mr-2"></i> Review Details
                </h3>
                <div class="bg-gray-750 p-4 rounded-xl border border-gray-700">
                    <div class="flex items-center mb-3">
                        <p class="font-medium text-gray-300 mr-2 flex items-center">
                            <i class="fas fa-star mr-2 text-yellow-400"></i> Rating:
                        </p>
                        <div class="flex space-x-1 text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-600' }}">★</span>
                            @endfor
                        </div>
                        <span class="ml-2 text-sm text-gray-400">{{ $review->rating }}/5</span>
                    </div>
                    <div class="mb-3">
                        <p class="font-medium text-gray-300 flex items-center">
                            <i class="fas fa-clock mr-2 text-gray-400"></i> Review Date:
                        </p>
                        <p class="text-gray-400 ml-6">{{ $review->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="font-medium text-gray-300 flex items-center">
                            <i class="fas fa-comment-alt mr-2 text-gray-400"></i> Review Content:
                        </p>
                        <div class="mt-2 p-3 bg-gray-700 rounded-lg border border-gray-600 text-gray-200">
                            @if($review->review)
                                <i class="fas fa-quote-left text-gray-500 float-left mr-1"></i>
                                {{ $review->review }}
                                <i class="fas fa-quote-right text-gray-500 float-right ml-1"></i>
                            @else
                                <span class="text-gray-500 italic">No review comment provided</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Reply Section -->
            <div>
                <h3 class="font-semibold text-lg text-koplak mb-3 flex items-center">
                    <i class="fas fa-reply mr-2"></i> Admin Reply
                </h3>

                @if($review->reply)
                    <div class="bg-gray-750 p-4 rounded-xl border border-koplak mb-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium text-koplak flex items-center">
                                    <i class="fas fa-crown mr-2"></i> Admin Response:
                                </p>
                                <p class="text-sm text-gray-400 ml-6">
                                    Replied by: {{ $review->reply->admin->name ?? 'Admin' }} on {{ $review->reply->created_at->format('d M Y, H:i') }}
                                    @if($review->reply->created_at != $review->reply->updated_at)
                                        (Edited on {{ $review->reply->updated_at->format('d M Y, H:i') }})
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="mt-3 p-3 bg-gray-700 rounded-lg border border-koplak text-gray-200">
                            <i class="fas fa-quote-left text-koplak float-left mr-1"></i>
                            {{ $review->reply->reply }}
                            <i class="fas fa-quote-right text-koplak float-right ml-1"></i>
                        </div>
                    </div>
                @endif

                <form action="{{ route('admin.reviews.reply', $review->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="reply" class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
                            <i class="fas fa-edit mr-2"></i> {{ $review->reply ? 'Edit Reply' : 'Add Reply' }}
                        </label>
                        <textarea
                            id="reply"
                            name="reply"
                            rows="4"
                            class="block w-full rounded-lg bg-gray-700 border-gray-600 text-white shadow-sm focus:border-koplak focus:ring focus:ring-koplak focus:ring-opacity-50"
                            placeholder="Enter your reply to the customer's review..."
                            required
                        >{{ $review->reply ? $review->reply->reply : '' }}</textarea>
                        @error('reply')
                            <p class="text-red-400 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-koplak hover:bg-koplak-dark text-gray-900 px-4 py-2 rounded-lg transition-colors duration-200 shadow-md flex items-center">
                            <i class="fas fa-paper-plane mr-2"></i> {{ $review->reply ? 'Update Reply' : 'Submit Reply' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>
@endsection
