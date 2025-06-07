<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Products - KoplakFood Roasters</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            overflow-x: hidden;
        }

        .hero-banner {
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.4)), url('assets/img/coffee-beans-top-view-white-background-space-text 1.png');
            background-size: cover;
            background-position: center;
            height: 60vh;
        }

        .product-card {
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .category-filter {
            scrollbar-width: none; /* Firefox */
        }

        .category-filter::-webkit-scrollbar {
            display: none; /* Chrome/Safari */
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
        .menu-item::after {
            content: '';
            display: block;
            width: 0;
            height: 2px;
            background: #000;
            transition: width 0.3s;
        }

        .menu-item:hover::after {
            width: 100%;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
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
                        'koplak-light': '#FFF9C4',
                    },
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                    },
                    height: {
                        'banner-mobile': '40vh',
                        'banner-desktop': '60vh',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white text-gray-900 font-montserrat" x-data="{
    // Menu & Cart State
    mobileMenuOpen: false,
    cartOpen: false,
    cartItems: [],
    transaksiOpen: false,
    products: [],
    filteredProducts: [],

    // Product Filtering
    activeCategory: 'all',
    categories: ['all', 'coffee', 'food'],
    filteredProducts: [],
    products: [],

    // Methods
    filterProducts(category) {
        this.activeCategory = category;
        if(category === 'all') {
            this.filteredProducts = this.products;
        } else {
            this.filteredProducts = this.products.filter(product => product.category === category);
        }
    },
    // Fungsi untuk mengelola keranjang
    removeFromCart(index) {
        this.cartItems.splice(index, 1);
    },

    get cartTotal() {
        return this.cartItems.reduce((total, item) => total + (item.price * (item.quantity || 1)), 0);
    },

    get cartItemCount() {
        return this.cartItems.reduce((count, item) => count + (item.quantity || 1), 0);
    },

    // Fungsi utama addToCart dengan AJAX
    async addToCart(item) {
        console.log('Produk yang diklik:', item.id); // Pastikan ID yang diklik benar
        try {
            const response = await fetch('{{ route('products.addToKeranjang') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    produk_id: item.id, // Pastikan ini sesuai dengan console.log di atas
                    jumlah: 1
                })
            });
            console.log('Request body:', JSON.stringify({ produk_id: item.id, jumlah: 1 }));

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || 'Gagal menambahkan ke keranjang');
            }

            // Update UI cart
            const existingItem = this.cartItems.find(cartItem => cartItem.id === item.id);

            if (existingItem) {
                existingItem.quantity = (existingItem.quantity || 1) + 1;
            } else {
                this.cartItems.push({
                    ...item,
                    quantity: 1
                });
            }

            // Show success notification
            this.showNotification('Produk berhasil ditambahkan ke keranjang!');

        } catch (error) {
            console.error('Error:', error);
            this.showNotification(error.message, 'error');
        }
    },

    // Fungsi notifikasi
    showNotification(message, type = 'success', duration = 3000) {
        // Dispatch event to the notification component
        const event = new CustomEvent('notification', {
            detail: {
                message,
                type,
                duration
            }
        });
        document.dispatchEvent(event);
    },


    // Fungsi untuk memuat produk
    async loadProducts() {
        try {
            const response = await fetch('{{ route('api.products') }}');
            const data = await response.json();

            if (response.ok) {
                this.products = data;
                this.filteredProducts = data;
            }
        } catch (error) {
            console.error('Gagal memuat produk:', error);
        }
    },
    // Fungsi untuk menambah quantity
    async increaseQuantity(index, productId) {
        try {
            const response = await fetch(`/keranjang/${this.cartItems[index].cart_id}/increase`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const data = await response.json();

            if (response.ok) {
                this.cartItems[index].quantity += 1;
                this.showNotification('Quantity updated', 'success');
            } else {
                throw new Error(data.message || 'Failed to update quantity');
            }
        } catch (error) {
            this.showNotification(error.message, 'error');
        }
    },

    // Fungsi untuk mengurangi quantity
    async decreaseQuantity(index) {
        try {
            const response = await fetch(`/keranjang/${this.cartItems[index].cart_id}/decrease`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const data = await response.json();

            if (response.ok) {
                if (this.cartItems[index].quantity > 1) {
                    this.cartItems[index].quantity -= 1;
                    this.showNotification('Quantity updated', 'success');
                }
            } else {
                throw new Error(data.message || 'Failed to update quantity');
            }
        } catch (error) {
            this.showNotification(error.message, 'error');
        }
    },

    // Fungsi untuk menghapus item
    async removeItem(index, itemId) {
        // Validasi itemId
        if (!itemId) {
            this.showNotification('ID produk tidak valid', 'error');
            return;
        }

        // Simpan item untuk fallback
        const itemBackup = this.cartItems[index];

        try {
            // Optimistic UI update
            this.cartItems.splice(index, 1);
            this.updateCartTotals();

            const response = await fetch(`/keranjang`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    produk_id: itemId // Menggunakan produk_id sebagai parameter
                })
            });

            // Handle response
            if (response.status === 404) {
                this.showNotification('Item sudah tidak ada di keranjang', 'info');
                return;
            }


            this.showNotification('Item berhasil dihapus', 'success');

        } catch (error) {
            console.error('Delete error:', error);

            // Rollback UI
            this.cartItems.splice(index, 0, itemBackup);
            this.updateCartTotals();

            // Tampilkan notifikasi error
            const errorMsg = error.message.includes('tidak ditemukan')
                ? 'Item sudah tidak ada'
                : 'Gagal menghapus item: ' + error.message;

            this.showNotification(errorMsg, 'error');
        }
    },

    updateCartTotals() {
        this.cartTotal = this.cartItems.reduce((total, item) => total + (item.price * item.quantity), 0);
        this.cartItemCount = this.cartItems.reduce((count, item) => count + item.quantity, 0);
    },

    // Fungsi untuk memuat keranjang
    async loadCart() {
        try {
            const response = await fetch('{{ route('keranjang.get') }}');
            const data = await response.json();

            if (response.ok) {
                this.cartItems = data.items.map(item => ({
                    cart_id: item.id,
                    id: item.produk_id,
                    name: item.produk.nama_produk,
                    price: item.harga,
                    image: item.produk.gambar_produk ? '{{ asset('storage') }}/' + item.produk.gambar_produk : '',
                    quantity: item.jumlah,
                    stock: item.produk.stok_produk
                }));
            }
        } catch (error) {
            console.error('Gagal memuat keranjang:', error);
        }
    },

    // Initialization
    init() {
        // Initialize with server-side data first
        this.products = [
            @foreach($products as $product)
            {
                id: {{ $product->id }},
                name: '{{ addslashes($product->nama_produk) }}',
                price: {{ $product->harga_produk }},
                image: '{{ $product->gambar_produk ? asset('storage/' . $product->gambar_produk) : '' }}',
                description: '{{ addslashes($product->deskripsi_produk) }}',
                category: '{{ $product->kategori_produk ?? 'coffee' }}',
                rating: {{ $product->average_rating ?? 0 }},
                sold: {{ $product->sold_count ?? 0 }},
                stock: {{ $product->stok_produk ?? 10 }}
            },
            @endforeach
        ];
        this.filteredProducts = [...this.products];

        // Then load fresh data from API
        this.loadProducts();
        this.loadCart();
    }
}">
    <!-- Notification Container -->
    <div x-data="notification()" class="fixed inset-0 flex items-center justify-center p-4 pointer-events-none z-[9999]">
        <template x-for="(notification, index) in notifications" :key="index">
            <div x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="w-full max-w-md bg-white rounded-lg shadow-xl pointer-events-auto transform transition-all"
                :class="{
                    'ring-2 ring-green-500': notification.type === 'success',
                    'ring-2 ring-red-500': notification.type === 'error',
                    'ring-2 ring-blue-500': notification.type === 'info'
                }">
                <div class="p-6 text-center">
                    <div class="flex justify-center mb-4">
                        <svg x-show="notification.type === 'success'"
                            class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <svg x-show="notification.type === 'error'"
                            class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <svg x-show="notification.type === 'info'"
                            class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 x-text="notification.message" class="text-lg font-bold text-gray-900 mb-4"></h3>
                    <div class="flex justify-center">
                        <button @click="remove(index)"
                                class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-md transition duration-150">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
    <!-- Navigation -->
    <header class="sticky top-0 z-50">
        <nav class="bg-white shadow-md">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <a href="{{ route('home') }}" class="inline-block transform hover:scale-105 transition-all duration-300">
                    <span class="text-3xl font-extrabold tracking-tighter bg-gradient-to-r from-black to-gray-800 text-transparent bg-clip-text">
                        KOPLAK
                    </span>
                    <span class="text-3xl font-extrabold tracking-tighter bg-gradient-to-r from-yellow-500 to-yellow-300 text-transparent bg-clip-text">
                        HUB
                    </span>
                </a>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="menu-item font-bold transition duration-200">HOME</a>
                    <a href="{{ route('products') }}" class="border-b-2 border-black font-bold text-black">PRODUCTS</a>

                    <div class="flex items-center space-x-4">
                        @auth
                            <div class="relative" x-data="{ transaksiOpen: false }">
                                <button @click="transaksiOpen = !transaksiOpen"
                                        @click.away="transaksiOpen = false"
                                        class="font-bold hover:border-b-2 hover:border-black transition duration-200 flex items-center">
                                    TRANSAKSI
                                    <i data-feather="chevron-down"
                                       class="w-4 h-4 ml-1 transition-transform duration-200"
                                       :class="{ 'transform rotate-180': transaksiOpen }"></i>
                                </button>
                                <div x-show="transaksiOpen"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute bg-white shadow-lg rounded-md mt-2 py-1 w-48 z-50">
                                    <a href="{{ route('transaksi.payment') }}" class="block px-4 py-2 hover:bg-yellow-400 transition duration-200">Menunggu Pembayaran</a>
                                    <a href="{{ route('transaksi.histori') }}" class="block px-4 py-2 hover:bg-yellow-400 transition duration-200">Riwayat Transaksi</a>
                                    <a href="{{ route('customer.reviews.index') }}" class="block px-4 py-2 hover:bg-yellow-400 transition duration-200">Review Pesanan</a>
                                </div>
                            </div>
                            <a href="{{ route('profile.show') }}" class="p-2 hover:text-koplak">
                                <i class="fas fa-user"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 bg-black text-koplak rounded font-bold text-sm hover:bg-gray-800 transition">
                                LOGIN OR REGISTER
                            </a>
                        @endauth

                        <button @click="cartOpen = true" class="p-2 hover:text-koplak relative">
                            <i class="fas fa-shopping-cart"></i>
                            <span x-show="cartItems.length > 0" x-text="cartItems.length"
                                class="absolute -top-2 -right-2 bg-koplak text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"></span>
                        </button>
                    </div>
                </div>

                <div class="md:hidden flex items-center space-x-4">
                    <button @click="cartOpen = true" class="p-2 relative">
                        <i class="fas fa-shopping-cart"></i>
                        <span x-show="cartItems.length > 0" x-text="cartItems.length"
                            class="absolute -top-2 -right-2 bg-koplak text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"></span>
                    </button>
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </nav>

        <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false"
            class="md:hidden bg-white shadow-lg absolute w-full z-50" x-cloak>
            <div class="container mx-auto px-4 py-4 flex flex-col space-y-4">
                <a href="{{ route('home') }}" class="py-2 font-bold border-b border-gray-100">HOME</a>
                <a href="{{ route('products') }}" class="py-2 font-bold border-b border-gray-100">PRODUCTS</a>

                <div class="pt-4">
                    @auth
                    <div class="relative">
                        <button @click="transaksiOpen = !transaksiOpen" class="w-full py-2 font-bold border-b border-gray-100 flex justify-between items-center">
                            TRANSAKSI
                            <i :class="{'transform rotate-180': transaksiOpen}" class="fas fa-chevron-down transition-transform duration-200"></i>
                        </button>
                        <div x-show="transaksiOpen" class="pl-4 py-2 space-y-2">
                            <a href="{{ route('transaksi.payment') }}" class="block py-1 transition duration-200">Menunggu Pembayaran</a>
                            <a href="{{ route('transaksi.histori') }}" class="block py-1 transition duration-200">Riwayat Transaksi</a>
                            <a href="{{ route('customer.reviews.index') }}" class="block py-1 transition duration-200">Review Pesanan</a>
                        </div>
                    </div>
                    <a href="{{ route('profile.show') }}" class="block py-2 font-bold border-b border-gray-100">MY ACCOUNT</a>
                    @else
                        <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 bg-black text-koplak rounded font-bold text-sm hover:bg-gray-800 transition">
                            LOGIN OR REGISTER
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <script>
        feather.replace();
    </script>


    <!-- Hero Banner -->
    <section class="hero-banner bg-gray-900 flex items-center justify-center h-banner-mobile md:h-banner-desktop">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 animate-fade-in">Discover Our Premium Selection</h1>
            <p class="text-xl md:text-2xl text-koplak-light mb-8 max-w-2xl mx-auto animate-fade-in delay-100">
                Handcrafted with passion, perfected for your palate
            </p>
            <a href="#products" class="inline-block px-8 py-3 bg-koplak text-black font-bold rounded-lg hover:bg-koplak-dark transition animate-fade-in delay-200">
                EXPLORE NOW
            </a>
        </div>
    </section>

    <!-- Product Categories -->
    <section class="py-8 bg-gray-50 sticky top-16 z-40 shadow-sm">
        <div class="container mx-auto px-4">
            <div class="flex overflow-x-auto space-x-4 pb-2 category-filter" x-data="{ scrollLeft: 0 }">
                <template x-for="category in categories" :key="category">
                    <button
                        @click="filterProducts(category)"
                        :class="{
                            'bg-koplak text-black': activeCategory === category,
                            'bg-white text-gray-800 hover:bg-gray-100': activeCategory !== category
                        }"
                        class="px-6 py-2 rounded-full font-bold whitespace-nowrap transition-all duration-300 flex-shrink-0"
                    >
                        <span x-text="category.charAt(0).toUpperCase() + category.slice(1)"></span>
                    </button>
                </template>
            </div>
        </div>
    </section>
    <!-- Products Grid -->
    <section id="products" class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" x-data="productComponent()" x-init="init()">
                <template x-for="(product, index) in filteredProducts" :key="product.id">
                    <div class="product-card border-b-4 border-black bg-white rounded-xl overflow-hidden shadow-md animate-fade-in"
                        :style="`animation-delay: ${index * 0.1}s`">
                        <!-- Product Image -->
                        <div class="relative overflow-hidden h-48 md:h-56">
                            <template x-if="product.image">
                                <img :src="product.image" :alt="product.name"
                                    class="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
                                    @load="product.imageLoaded = true"
                                    x-show="product.imageLoaded"
                                    :class="{'hidden': !product.imageLoaded}">
                            </template>
                            <template x-if="product.image">
                                <div x-show="!product.imageLoaded" class="absolute inset-0 bg-gray-200 animate-pulse rounded"></div>
                            </template>
                            <template x-if="!product.image">
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </template>

                            <!-- Stock Badge -->
                            <div x-show="product.stock > 0" class="absolute top-3 left-3 bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                                In Stock
                            </div>
                            <div x-show="product.stock <= 0" class="absolute top-3 left-3 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                Out of Stock
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-bold" x-text="product.name"></h3>
                                <span class="font-bold text-black" x-text="`Rp ${product.price.toLocaleString('id-ID')}`"></span>
                            </div>

                            <p class="text-gray-600 text-sm mb-4 line-clamp-2" x-text="product.description"></p>

                            <!-- Rating Section - Updated for Alpine.js -->
                            <div class="flex items-center mb-2">
                                <div class="flex text-yellow-400">
                                    <template x-for="i in 5" :key="i">
                                        <span>
                                            <i x-show="i <= Math.floor(product.rating)" class="fas fa-star"></i>
                                            <i x-show="i > Math.floor(product.rating) && i <= Math.ceil(product.rating) && (product.rating % 1 > 0)"
                                            class="fas fa-star-half-alt"></i>
                                            <i x-show="i > Math.ceil(product.rating) || (i > Math.floor(product.rating) && (product.rating % 1 === 0))"
                                            class="far fa-star"></i>
                                        </span>
                                    </template>
                                    <span class="text-gray-600 text-sm ml-1" x-text="`(${product.rating.toFixed(1)})`"></span>
                                </div>
                                <span class="text-sm text-gray-600 ml-2" x-text="`Terjual: ${product.sold}`"></span>
                            </div>

                            <!-- Buttons -->
                            <div class="flex space-x-2">
                                <a :href="`/products/${product.id}/detail`"
                                class="flex-1 text-center bg-black text-white py-2 px-4 rounded-lg hover:bg-gray-800 transition font-bold">
                                Details
                                </a>
                                <button @click="addToCart({
                                    id: product.id,
                                    name: product.name,
                                    price: product.price,
                                    image: product.image
                                })"
                                class="px-6 py-2 bg-koplak text-black font-bold hover:bg-koplak-dark transition">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Empty State -->
                <template x-if="filteredProducts.length === 0">
                    <div class="col-span-full text-center py-16">
                        <div class="max-w-md mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <h3 class="text-xl font-bold text-gray-700 mb-2">No products found</h3>
                            <p class="text-gray-500 mb-4">We couldn't find any products matching your selection.</p>
                            <button @click="filterProducts('all')" class="px-6 py-2 bg-koplak text-black rounded-lg font-bold hover:bg-koplak-dark transition">
                                View All Products
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>
    <template x-if="product.image">
        <div x-show="!product.imageLoaded" class="absolute inset-0 bg-gray-200 animate-pulse rounded"></div>
    </template>

    <!-- CTA Section -->
    <section class="py-16 bg-gray-900 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Experience the Best?</h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                Join our community of coffee lovers and food enthusiasts today!
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#" class="px-8 py-3 bg-koplak text-black font-bold rounded-lg hover:bg-koplak-dark transition">
                    ORDER NOW
                </a>
                <a href="https://wa.me/083113126056" class="px-8 py-3 border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-black transition">
                    CONTACT US
                </a>
            </div>
        </div>
    </section>

    <!-- Cart Drawer -->
    <div class="fixed inset-0 overflow-hidden z-50" x-show="cartOpen" x-cloak>
        <div class="absolute inset-0 overflow-hidden">
            <!-- Overlay -->
            <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                @click="cartOpen = false"></div>

            <!-- Cart Panel -->
            <div class="fixed inset-y-0 right-0 max-w-full flex">
                <div class="w-screen max-w-md">
                    <div class="h-full flex flex-col bg-white shadow-xl">
                        <!-- Cart header -->
                        <div class="flex-1 py-6 overflow-y-auto px-4 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-bold text-gray-900">Shopping cart</h2>
                                <button @click="cartOpen = false" class="ml-3 h-7 flex items-center">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <!-- Cart items -->
                            <div class="mt-8">
                                <div class="flow-root">
                                    <ul class="-my-6 divide-y divide-gray-200">
                                        <template x-for="(item, index) in cartItems" :key="item.id">
                                            <li class="py-6 flex">
                                                <div class="flex-shrink-0 w-24 h-24 border border-gray-200 rounded-md overflow-hidden">
                                                    <img x-bind:src="item.image" class="w-full h-full object-center object-cover">
                                                </div>

                                                <div class="ml-4 flex-1 flex flex-col">
                                                    <div>
                                                        <div class="flex justify-between text-base font-bold text-gray-900">
                                                            <h3 x-text="item.name"></h3>
                                                            <p class="ml-4" x-text="'Rp' + (item.price * item.quantity).toFixed(2)"></p>
                                                        </div>
                                                        <p class="mt-1 text-sm text-gray-500" x-text="item.category"></p>
                                                    </div>
                                                    <div class="flex-1 flex items-center justify-between text-sm">
                                                        <!-- Quantity Controls -->
                                                        <div class="flex items-center border rounded-md">
                                                            <button @click="decreaseQuantity(index)"
                                                                    class="px-3 py-1 border-r hover:bg-gray-100"
                                                                    :disabled="item.quantity <= 1">
                                                                -
                                                            </button>
                                                            <span class="px-3" x-text="item.quantity"></span>
                                                            <button @click="increaseQuantity(index, item.id)"
                                                                    class="px-3 py-1 border-l hover:bg-gray-100"
                                                                    :disabled="item.quantity >= item.stock">
                                                                +
                                                            </button>
                                                        </div>

                                                        <!-- Remove Button -->
                                                        <button @click="removeItem(index, item.id)"
                                                                class="font-bold text-red-600 hover:text-red-500 ml-4">
                                                            Remove
                                                        </button>
                                                    </div>

                                                    <!-- Remove Button -->
                                                    <button @click="removeItem(index, item.id)"
                                                            class="font-bold text-red-600 hover:text-red-500 ml-4">
                                                        Remove
                                                    </button>
                                                </div>
                                                </div>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Cart footer -->
                        <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
                            <div class="flex justify-between text-base font-bold text-gray-900">
                                <p>Subtotal</p>
                                <p x-text="'Rp' + cartTotal.toFixed(2)"></p>
                            </div>
                            <p class="mt-0.5 text-sm text-gray-500">Harga total belum termasuk pengiriman.</p>
                            <div class="mt-6">
                                @auth
                                <a href="{{ route('checkout') }}" class="border-b-4 border-black px-6 py-2 bg-koplak text-black rounded-md hover:bg-yellow-700 transition flex items-center justify-center">
                                        Checkout
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                @else
                                    <button type="button" onclick="showLoginAlert()" class="border-b-4 border-black px-6 py-2 bg-koplak text-black rounded-md hover:bg-yellow-700 transition flex items-center justify-center cursor-pointer">
                                        Checkout
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Mobile Bottom Navigation -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white shadow-lg z-50">
        <div class="flex justify-around py-3">
            <a href="{{ route('home') }}" class="flex flex-col items-center text-gray-600">
                <i class="fas fa-home text-xl"></i>
                <span class="text-xs mt-1">Home</span>
            </a>
            <a href="{{ route('products') }}" class="flex flex-col items-center text-koplak">
                <i class="fas fa-coffee text-xl"></i>
                <span class="text-xs mt-1">Products</span>
            </a>
            <a href="#" class="flex flex-col items-center text-gray-600">
                <i class="fas fa-search text-xl"></i>
                <span class="text-xs mt-1">Search</span>
            </a>
            <a href="{{ route('profile.show') }}" class="flex flex-col items-center text-gray-600">
                <i class="fas fa-user text-xl"></i>
                <span class="text-xs mt-1">Account</span>
            </a>
        </div>
    </div>
    <script>
        // alpin notif
        document.addEventListener('alpine:init', () => {
            Alpine.data('notification', () => ({
                notifications: [],

                init() {
                    // Listen for notification events
                    document.addEventListener('notification', (e) => {
                        this.add(e.detail.message, e.detail.type, e.detail.duration);
                    });
                },

                add(message, type = 'success', duration = 3000) {
                    const notification = {
                        message,
                        type,
                        id: Date.now()
                    };

                    this.notifications.push(notification);

                    // Auto-remove after duration
                    if (duration > 0) {
                        setTimeout(() => {
                            this.removeById(notification.id);
                        }, duration);
                    }
                },

                remove(index) {
                    this.notifications.splice(index, 1);
                },

                removeById(id) {
                    const index = this.notifications.findIndex(n => n.id === id);
                    if (index !== -1) {
                        this.notifications.splice(index, 1);
                    }
                }
            }));
        });
    </script>
</body>
</html>
