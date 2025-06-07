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
                <a href="{{ route('products') }}" class="menu-item font-bold transition duration-200">PRODUCTS</a>

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
