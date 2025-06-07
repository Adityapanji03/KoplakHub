    <!-- Footer -->
    <footer class="bg-black text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-xl font-bold mb-4 text-koplak">KoplakFood</h3>
                    <p class="mb-4">
                        Premium coffee roasted to perfection since 2018.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/koplakfood/" target="_blank" class="text-gray-400 hover:text-koplak transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.instagram.com/koplak_food?igsh=MXFlMTRxbTN0NzQ2dg==" target="_blank" class="text-gray-400 hover:text-koplak transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://twitter.com/FoodKoplak" target="_blank" class="text-gray-400 hover:text-koplak transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold mb-4">SHOP</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('products') }}" class="text-gray-400 hover:text-white transition">All Coffee</a></li>
                        <li><a href="/products/3/detail" class="text-gray-400 hover:text-white transition">Kopi Biji Salak</a></li>
                        <li><a href="/products/1/detail" class="text-gray-400 hover:text-white transition">Robusta</a></li>
                        <li><a href="/products/2/detail" class="text-gray-400 hover:text-white transition">Arabica</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-4">ABOUT</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}#about" class="text-gray-400 hover:text-white transition">Our Story</a></li>
                        <li><a href="https://www.instagram.com/koplak_food?igsh=MXFlMTRxbTN0NzQ2dg==" target="_blank" class="text-gray-400 hover:text-white transition">Instagram</a></li>
                        <li><a href="https://www.facebook.com/koplakfood/" target="_blank" class="text-gray-400 hover:text-white transition">Facebook</a></li>
                        <li><a href="https://twitter.com/FoodKoplak" target="_blank" class="text-gray-400 hover:text-white transition">Twitter</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-4">HELP</h4>
                    <ul class="space-y-2">
                        <li><a href="https://wa.me/083113126056" class="text-gray-400 hover:text-white transition">Contact Us on Whatsapp</a></li>
                        <li><a href="https://g.co/kgs/CpZ3kfh" class="text-gray-400 hover:text-white transition">Our Location</a></li>
                        <li><a href="https://www.gramedia.com/best-seller/kopi-biji-salak/" class="text-gray-400 hover:text-white transition">What is kopi salak</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-gray-800 text-center text-gray-400 text-sm">
                <p>&copy; 2025 KoplakFood Roasters. All rights reserved.</p>
            </div>
        </div>
    </footer>
