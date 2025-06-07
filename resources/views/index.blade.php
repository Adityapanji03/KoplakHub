<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KoplakFood Roasters</title>
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

        .hero-text {
            font-size: clamp(3rem, 10vw, 8rem);
            line-height: 0.9;
        }

        .product-card:hover .product-overlay {
            opacity: 1;
            transform: translateY(0);
        }

        .cart-slide {
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }

        .cart-slide.open {
            transform: translateX(0);
        }

        .cart-overlay {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease-in-out;
        }

        .cart-overlay.open {
            opacity: 1;
            pointer-events: auto;
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
        .swal-custom-confirm-cool {
            background-color: #4CAF50 !important;
            background-image: linear-gradient(to bottom, #4CAF50, #45a049) !important;
            color: white !important;
            border: none !important;
            border-radius: 8px !important;
            font-size: 1.2em !important;
            padding: 4px 15px !important;
            cursor: pointer !important;
            transition: background-color 0.3s ease, transform 0.2s ease !important; /
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2) !important;
        }

        .swal-custom-confirm-cool:hover {
            background-color: #45a049 !important;
            background-image: linear-gradient(to bottom, #45a049, #3e8e41) !important;
            transform: translateY(-2px) !important;
        }

        .swal-custom-confirm-cool:active {
            transform: translateY(0) !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2) !important;
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
    </script>
</head>
<body class="bg-white text-gray-900 font-montserrat" x-data="{
    cartOpen: false,
    transaksiOpen: false,
    mobileMenuOpen: false,
    cartItems: [],
    products: [],
    filteredProducts: [],

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
        try {
            const response = await fetch('{{ route('products.addToKeranjang') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    produk_id: item.id,
                    jumlah: 1
                })
            });

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

    // Inisialisasi komponen
    init() {
        // Load products
        this.loadProducts();

        // Load cart
        this.loadCart();
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
    }
}">
    @auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('alert_tampil'))
                const nama = "{{ session('nama_login') }}";
                Swal.fire({
                    title: 'Login Berhasil!',
                    text: `Selamat datang, ${nama}!`,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'swal-custom-confirm-cool',
                    },
                    buttonsStyling: false,
                });
                @php
                    session()->forget('alert_tampil');
                    session()->forget('nama_login');
                @endphp
            @endif
        });
    </script>
    @endauth
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
                    <h3 x-text="notification.message" class="text-lg font-medium text-gray-900 mb-4"></h3>
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
    @include('layouts.navbar')

    <!-- Hero Section -->
    <section class="relative h-screen flex items-center overflow-hidden">
        <!-- Background image -->
        <div class="absolute inset-0 bg-black opacity-40 z-0"></div>
        <img src="{{asset('assets/img/2150691655 1.png')}}"
             alt="Coffee beans" class="absolute inset-0 w-full h-full object-cover z-0">

        <!-- Hero content -->
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-2xl">
                <h1 class="hero-text font-black text-white mb-6 animate-fade-in">
                    PREMIUM COFFEE <span class="text-koplak">ROASTED</span> TO PERFECTION
                </h1>
                <p class="text-white text-lg mb-8 animate-fade-in delay-100">
                    Temukan racikan kopi buatan tangan kami yang bersumber dari kulit salak dan biji kopi terbaik di Jember.
                </p>
                <div class="flex space-x-4 animate-fade-in delay-200">
                    <a href="{{ route('products') }}" class="px-8 py-3 bg-koplak text-black font-bold hover:bg-koplak-dark transition">
                        SHOP NOW
                    </a>
                    <a href="#about" class="px-8 py-3 border-2 border-white text-white font-bold hover:bg-white hover:text-black transition">
                        LEARN MORE
                    </a>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#featured" class="text-white">
                <i class="fas fa-chevron-down text-2xl"></i>
            </a>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="featured" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">OUR SIGNATURE PRODUCTS</h2>
                <div class="w-20 h-1 bg-koplak mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse ($products as $index => $product)
                    <div class="product-card border-b-4 border-black bg-white rounded-lg overflow-hidden shadow-lg relative group animate-fade-in @if($index > 0) delay-{{ $index * 100 }} @endif">
                        <div class="relative overflow-hidden">
                            @if ($product->gambar_produk)
                                <img src="{{ asset('storage/' . $product->gambar_produk) }}"
                                    alt="{{ $product->nama_produk }}"
                                    class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="product-overlay absolute inset-0 bg-black bg-opacity-70 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-4 group-hover:translate-y-0">
                                <button @click="addToCart({
                                    id: {{ $product->id }},
                                    name: '{{ $product->nama_produk }}',
                                    price: '{{ $product->harga_produk }}',
                                    image: '{{ $product->gambar_produk ? asset('storage/' . $product->gambar_produk) : '' }}'
                                })" class="border-black border-4 px-6 py-2 bg-koplak text-black font-bold hover:bg-koplak-dark transition">
                                    ADD TO CART
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2">{{ $product->nama_produk }}</h3>
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-bold text-lg">Rp {{ number_format($product->harga_produk, 0, ',', '.') }}</span>
                                <div class="flex text-yellow-400">
                                    @php
                                        $averageRating = $reviews->where('produk_id', $product->id)->avg('rating');
                                        $soldCount = $reviews->where('produk_id', $product->id)->count();
                                    @endphp

                                    @for ($i = 0; $i < 5; $i++)
                                        @if ($i < floor($averageRating ?? 0))
                                            <i class="fas fa-star"></i>
                                        @elseif ($i == floor($averageRating ?? 0) && ($averageRating ?? 0) - floor($averageRating ?? 0) > 0)
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                    <span class="text-gray-600 text-sm ml-1">({{ number_format($averageRating, 1) }})</span>
                                </div>
                            </div>
                            <div class="text-sm text-gray-600">
                                Terjual: {{ $soldCount }} kali
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="text-xl text-gray-600">Tidak ada produk yang tersedia</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('products') }}" class="inline-block px-8 py-3 border-2 border-black text-black font-bold hover:bg-black hover:text-white transition">
                    VIEW ALL PRODUCTS
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg:w-1/2 mb-12 lg:mb-0 lg:pr-12 animate-fade-in">
                    <img src="https://images.unsplash.com/photo-1461988091159-192b6df7054f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&h=600&q=80"
                         alt="Coffee roasting" class="w-full rounded-lg shadow-xl">
                </div>
                <div class="lg:w-1/2 animate-fade-in delay-100">
                    <h2 class="text-4xl font-bold mb-6">OUR STORY</h2>
                    <div class="w-20 h-1 bg-koplak mb-6"></div>
                    <p class="text-gray-700 mb-6">
                        Didirikan pada tahun 2018, KoplakFood dimulai dengan misi sederhana: mencari dan memanggang biji kopi dengan menambah kulit salak sebagai resep rahasia yang dapat menambah cita rasa kopi membuat kopi kami memiliki kualitas unik dan terbaik sambil tetap menjaga hubungan yang etis dengan para petani.
                    </p>
                    <p class="text-gray-700 mb-8">
                        Proses pemanggangan kecil-kecilan kami memastikan setiap biji kopi mencapai potensi maksimalnya, memberikan rasa yang luar biasa di setiap cangkir. Dari awal mula kami yang sederhana sebagai sebuah tempat pemanggangan tunggal hingga kini melayani para pencinta kopi di seluruh dunia, komitmen kami terhadap kualitas tetap tidak berubah.
                    </p>
                    <a href="https://www.instagram.com/koplak_food?igsh=MXFlMTRxbTN0NzQ2dg==" class="border-b-4 border-r-2 border-black px-8 py-3 bg-koplak text-black font-bold hover:bg-koplak-dark transition">
                        LEARN MORE
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">WHAT OUR CUSTOMERS SAY</h2>
                <div class="w-20 h-1 bg-koplak mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="border-b-4 border-black bg-white p-8 rounded-lg shadow-md animate-fade-in">
                    <div class="flex text-yellow-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-700 mb-6">
                        "Arabica disini adalah kopi terbaik yang pernah saya minum, saya bahkan harus memesan 5kg setiap minggu untuk saya dan keluarga. Profil rasanya luar biasa dan sudah menjadi ritual harian saya."
                    </p>
                    <div class="flex items-center">
                        <img src="https://randomuser.me/api/portraits/women/43.jpg" alt="Sarah J." class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-bold">Azzahra J.</h4>
                            <p class="text-gray-600 text-sm">Pelanggan</p>
                        </div>
                    </div>
                </div>

                <div class="border-b-4 border-black bg-white p-8 rounded-lg shadow-md animate-fade-in delay-100">
                    <div class="flex text-yellow-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-700 mb-6">
                        "Sebagai seorang barista, saya sangat memperhatikan kualitas kopi saya. Espresso Roast dari Koplak kini menjadi andalan saya baik di rumah maupun di kafe. Kualitas yang konsisten setiap saat."
                    </p>
                    <div class="flex items-center">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Michael T." class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-bold">Reyvandi adji p</h4>
                            <p class="text-gray-600 text-sm">Pecinta kopi asal madiun</p>
                        </div>
                    </div>
                </div>

                <div class="border-b-4 border-black bg-white p-8 rounded-lg shadow-md animate-fade-in delay-200">
                    <div class="flex text-yellow-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="text-gray-700 mb-6">
                        "Saya suka bahwa Koplak menawarkan pilihan kopi tanpa kafein yang sangat bagus. Kebanyakan kopi tanpa kafein terasa datar, tetapi kopi mereka memiliki semua kerumitan dan wangi yang berbeda kopi biasa. Sempurna untuk malam hari!"
                    </p>
                    <div class="flex items-center">
                        <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Lisa M." class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-bold">Azazi roqiyah</h4>
                            <p class="text-gray-600 text-sm">Penggemar Kopi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-16 bg-koplak text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="border-b-4 border-black text-3xl font-bold mb-4 text-black animate-fade-in">FOLLOW OUR ACTIVITIES</h2>
            <p class="mb-8 max-w-2xl mx-auto animate-fade-in delay-100 text-black">
                Follow us to get exclusive access to new information, releases and special offers.
            </p>
            <a href="https://www.instagram.com/koplak_food?igsh=MXFlMTRxbTN0NzQ2dg==" target="_blank"
            class="border-b-4 border-white max-w-md mx-auto flex animate-fade-in delay-200 px-6 py-3 bg-black text-koplak font-bold rounded hover:text-black hover:bg-white transition justify-center items-center">
             FOLLOW
           </a>
        </div>
    </section>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Shopping Cart Sidebar -->
    <div x-show="cartOpen" @click.away="cartOpen = false"
         class="fixed inset-0 overflow-hidden z-50" x-cloak>
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50 cart-overlay"
             :class="{ 'open': cartOpen }"></div>

        <!-- Cart sidebar -->
        <div class="cart-slide fixed inset-y-0 right-0 max-w-full flex"
             :class="{ 'open': cartOpen }">
            <div class="relative w-screen max-w-md">
                <div class="h-full flex flex-col bg-white shadow-xl">
                    <div class="flex-1 overflow-y-auto py-6 px-4 sm:px-6">
                        <div class="flex items-start justify-between">
                            <h2 class="text-lg font-medium text-gray-900">SHOPPING CART</h2>
                            <button @click="cartOpen = false" class="p-2 -mr-2 text-gray-400 hover:text-gray-500">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <div class="mt-8">
                            <div class="flow-root">
                                <ul class="-my-6 divide-y divide-gray-200">
                                    <template x-for="(item, index) in cartItems" :key="index">
                                        <li class="py-6 flex">
                                            <div class="flex-shrink-0 w-24 h-24 border border-gray-200 rounded-md overflow-hidden">
                                                <img :src="item.image"
                                                     class="w-full h-full object-cover object-center">
                                            </div>

                                            <div class="ml-4 flex-1 flex flex-col">
                                                <div>
                                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                                        <h3 x-text="item.name"></h3>
                                                        <p class="ml-4" x-text="'Rp' + item.price.toFixed(2)"></p>
                                                    </div>
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
                                                            class="font-medium text-red-600 hover:text-red-500 ml-4">
                                                        Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                    </template>

                                    <div x-show="cartItems.length === 0" class="py-12 text-center">
                                        <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-4"></i>
                                        <p class="text-gray-500">Your cart is empty</p>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 py-6 px-4 sm:px-6" x-show="cartItems.length > 0">
                        <div class="flex justify-between text-base font-medium text-gray-900 mb-4">
                            <p>Subtotal</p>
                            <p x-text="'Rp' + cartTotal.toFixed(2)"></p>
                        </div>
                        <p class="mt-0.5 text-sm text-gray-500 mb-6">
                            Harga total belum termasuk pengiriman.
                        </p>
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
                        <div class="mt-6 flex justify-center text-sm text-center text-gray-500">
                            <p>
                                or
                                <button @click="cartOpen = false" class="text-koplak font-medium hover:text-koplak">
                                    Continue Shopping
                                </button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to top button -->
    <button id="back-to-top" class="fixed bottom-8 right-8 bg-koplak text-black p-3 rounded-full shadow-lg opacity-0 invisible transition-all duration-300 hover:bg-koplak">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        // Back to top button
        document.addEventListener('DOMContentLoaded', function() {
            const backToTopButton = document.getElementById('back-to-top');

            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.remove('opacity-0', 'invisible');
                    backToTopButton.classList.add('opacity-100', 'visible');
                } else {
                    backToTopButton.classList.remove('opacity-100', 'visible');
                    backToTopButton.classList.add('opacity-0', 'invisible');
                }
            });

            backToTopButton.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();

                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;

                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showLoginAlert() {
            Swal.fire({
                title: 'Login Required',
                text: 'Anda harus login terlebih dahulu untuk melanjutkan checkout',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '',
                cancelButtonColor: '',
                confirmButtonText: '<span style="color: #ffffff">Login Sekarang</span>',
                cancelButtonText: 'Batal',
                background: '#ffffff',
                customClass: {
                    popup: 'font-poppins',
                    confirmButton: 'bg-green-400 hover:bg-green-600',
                    cancelButton: 'bg-red-500 hover:bg-red-600'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                }
            });
        }

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
