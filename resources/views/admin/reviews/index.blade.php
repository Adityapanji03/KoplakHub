@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8 mt-14 p-4 sm:ml-64">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-4 animate-fade-in">
            <div class="flex items-center space-x-3">
                <div class="bg-gradient-to-r from-koplak to-koplak-dark p-3 rounded-full shadow-lg">
                    <i class="fas fa-star text-black text-xl"></i>
                </div>
                <div>
                    <h1 class="text-black text-3xl font-bold font-montserrat">Review Pelanggan</h1>
                    <p class="text-black text-sm mt-1">Kelola dan tanggapi ulasan pelanggan</p>
                </div>
            </div>
            <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-gray-700 to-gray-800 font-bold border-b-4 border-koplak hover:from-gray-600 hover:to-gray-700 text-white px-6 py-3 rounded-lg text-sm flex items-center justify-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="hidden sm:inline">Kembali ke Dashboard</span>
                <span class="sm:hidden">Kembali</span>
            </a>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="bg-gradient-to-r from-green-500 to-green-600 border border-green-400 text-white px-6 py-4 rounded-lg mb-6 shadow-lg animate-fade-in flex items-center">
            <i class="fas fa-check-circle mr-3 text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-gradient-to-r from-red-500 to-red-600 border border-red-400 text-white px-6 py-4 rounded-lg mb-6 shadow-lg animate-fade-in flex items-center">
            <i class="fas fa-exclamation-circle mr-3 text-lg"></i>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <!-- Filters Section -->
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl shadow-2xl p-6 mb-8 border border-gray-700 animate-fade-in">
            <div class="flex items-center mb-4">
                <i class="fas fa-filter text-koplak mr-3 text-lg"></i>
                <h3 class="text-lg font-semibold text-white font-montserrat">Filter Reviews</h3>
            </div>
            <form action="{{ route('admin.reviews.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label for="rating" class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-star text-koplak mr-2"></i>Filter by Rating
                    </label>
                    <select id="rating" name="rating" class="w-full rounded-lg bg-gray-700 border-gray-600 text-white shadow-sm focus:border-koplak focus:ring focus:ring-koplak focus:ring-opacity-50 transition-all duration-200 px-4 py-3">
                        <option value="">All Ratings</option>
                        @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="replied" class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-reply text-koplak mr-2"></i>Reply Status
                    </label>
                    <select id="replied" name="replied" class="w-full rounded-lg bg-gray-700 border-gray-600 text-white shadow-sm focus:border-koplak focus:ring focus:ring-koplak focus:ring-opacity-50 transition-all duration-200 px-4 py-3">
                        <option value="">All Reviews</option>
                        <option value="1" {{ request('replied') === '1' ? 'selected' : '' }}>Replied</option>
                        <option value="0" {{ request('replied') === '0' ? 'selected' : '' }}>Not Replied</option>
                    </select>
                </div>

                <div class="md:col-span-2 xl:col-span-1 flex flex-col sm:flex-row justify-center items-center gap-3 mt-4 xl:mt-8">
                    <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-koplak to-koplak-dark hover:from-koplak-dark hover:to-koplak-darker text-black px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i>
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.reviews.index') }}" class="w-full sm:w-auto bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-500 hover:to-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center">
                        <i class="fas fa-undo mr-2"></i>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Reviews Section -->
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl shadow-2xl overflow-hidden border border-gray-700 animate-fade-in">
            <!-- Mobile View -->
            <div class="block lg:hidden">
                <div class="p-4 bg-gradient-to-r from-gray-700 to-gray-800 border-b border-gray-600">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-comments text-koplak mr-2"></i>
                        Customer Reviews
                    </h3>
                </div>

                @forelse($reviews as $review)
                <div class="p-6 border-b border-gray-700 last:border-b-0 hover:bg-gray-750 transition-colors duration-200">
                    <!-- Product Info -->
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 h-12 w-12 mr-4">
                            @if($review->produk->gambar_produk)
                                <img class="h-12 w-12 rounded-lg object-cover shadow-md" src="{{ asset('storage/' . $review->produk->gambar_produk) }}" alt="">
                            @else
                                <div class="h-12 w-12 rounded-lg bg-gradient-to-r from-gray-600 to-gray-700 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h4 class="text-white font-semibold">{{ Str::limit($review->produk->nama_produk, 25) }}</h4>
                            <p class="text-gray-400 text-sm">ID: {{ $review->produk_id }}</p>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div class="mb-4 p-3 bg-gray-700 rounded-lg">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-user text-koplak mr-2"></i>
                            <span class="text-white font-medium">{{ $review->akun->nama }}</span>
                        </div>
                        <div class="flex items-center text-gray-400 text-sm">
                            <i class="fas fa-envelope text-gray-500 mr-2"></i>
                            <span>{{ $review->akun->email }}</span>
                        </div>
                    </div>

                    <!-- Rating & Date -->
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center">
                            <div class="flex space-x-1 mr-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $review->rating ? 'text-koplak' : 'text-gray-600' }} text-lg">★</span>
                                @endfor
                            </div>
                            <span class="text-white font-semibold">{{ $review->rating }}/5</span>
                        </div>
                        <div class="flex items-center text-gray-400 text-sm">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>{{ $review->created_at->format('d M Y') }}</span>
                        </div>
                    </div>

                    <!-- Reply Status & Action -->
                    <div class="flex justify-between items-center">
                        @if($review->reply)
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-500 text-white flex items-center">
                                <i class="fas fa-check mr-1"></i>
                                Replied
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-500 text-white flex items-center">
                                <i class="fas fa-clock mr-1"></i>
                                Pending Reply
                            </span>
                        @endif

                        <a href="{{ route('admin.reviews.show', $review->id) }}" class="bg-gradient-to-r from-koplak to-koplak-dark text-black px-4 py-2 rounded-lg font-semibold transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center">
                            <i class="fas fa-eye mr-2"></i>
                            <span class="hidden sm:inline">View & Reply</span>
                            <span class="sm:hidden">View</span>
                        </a>
                    </div>
                </div>
                @empty
                <div class="p-12 text-center">
                    <i class="fas fa-inbox text-gray-600 text-4xl mb-4"></i>
                    <p class="text-gray-400 text-lg">No reviews found</p>
                    <p class="text-gray-500 text-sm mt-2">Reviews will appear here when customers leave feedback</p>
                </div>
                @endforelse
            </div>

            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4 border-b border-gray-600">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-comments text-koplak mr-2"></i>
                        Customer Reviews
                    </h3>
                </div>

                <table class="w-full divide-y divide-gray-700">
                    <thead class="bg-gradient-to-r from-gray-700 to-gray-800">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-box mr-2 text-koplak"></i>Product
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-user mr-2 text-koplak"></i>Customer
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-star mr-2 text-koplak"></i>Rating
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-calendar mr-2 text-koplak"></i>Date
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-reply mr-2 text-koplak"></i>Status
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-cogs mr-2 text-koplak"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-gradient-to-b from-gray-800 to-gray-900 divide-y divide-gray-700">
                        @forelse($reviews as $review)
                        <tr class="hover:bg-gray-750 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        @if($review->produk->gambar_produk)
                                            <img class="h-12 w-12 rounded-lg object-cover shadow-md" src="{{ asset('storage/' . $review->produk->gambar_produk) }}" alt="">
                                        @else
                                            <div class="h-12 w-12 rounded-lg bg-gradient-to-r from-gray-600 to-gray-700 flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-white">
                                            {{ Str::limit($review->produk->nama_produk, 30) }}
                                        </div>
                                        <div class="text-sm text-gray-400">
                                            ID: {{ $review->produk_id }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-white font-medium">{{ $review->akun->nama }}</div>
                                <div class="text-sm text-gray-400">{{ $review->akun->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex space-x-1 mr-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="{{ $i <= $review->rating ? 'text-koplak' : 'text-gray-600' }}">★</span>
                                        @endfor
                                    </div>
                                    <span class="text-sm text-white font-semibold">{{ $review->rating }}/5</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                <i class="fas fa-calendar mr-2 text-gray-500"></i>
                                {{ $review->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($review->reply)
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-500 text-white flex items-center w-fit">
                                        <i class="fas fa-check mr-1"></i>
                                        Replied
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-500 text-white flex items-center w-fit">
                                        <i class="fas fa-clock mr-1"></i>
                                        Not Replied
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.reviews.show', $review->id) }}" class="bg-gradient-to-r from-koplak to-koplak-dark text-black px-4 py-2 rounded-lg font-semibold transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center w-fit">
                                    <i class="fas fa-eye mr-2"></i>
                                    View & Reply
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <i class="fas fa-inbox text-gray-600 text-4xl mb-4"></i>
                                <p class="text-gray-400 text-lg">No reviews found</p>
                                <p class="text-gray-500 text-sm mt-2">Reviews will appear here when customers leave feedback</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($reviews->hasPages())
            <div class="px-6 py-4 bg-gradient-to-r from-gray-700 to-gray-800 border-t border-gray-600">
                <div class="pagination-wrapper">
                    {{ $reviews->appends(request()->query())->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .pagination-wrapper .pagination {
        @apply flex justify-center space-x-2;
    }

    .pagination-wrapper .pagination a,
    .pagination-wrapper .pagination span {
        @apply px-3 py-2 text-sm rounded-lg transition-all duration-200;
    }

    .pagination-wrapper .pagination a {
        @apply bg-gray-600 text-white hover:bg-koplak hover:text-black;
    }

    .pagination-wrapper .pagination .active span {
        @apply bg-koplak text-black font-semibold;
    }

    .pagination-wrapper .pagination .disabled span {
        @apply bg-gray-800 text-gray-500 cursor-not-allowed;
    }

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

@endsection
