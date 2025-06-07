@extends('layouts.appCustomer-nav')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Keranjang Belanja</h2>

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

    @if($keranjangItems->count() > 0)
        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Produk</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Harga</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Jumlah</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Subtotal</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($keranjangItems as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    <img src="{{ asset('storage/' . $item->produk->gambar_produk) }}"
                                         alt="{{ $item->produk->nama_produk }}"
                                         class="w-16 h-16 object-cover rounded mr-4">
                                    <div>
                                        <h6 class="text-gray-800 font-medium">{{ $item->produk->nama_produk }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-gray-700">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="py-4 px-4">
                                <form action="{{ route('keranjang.update', $item->id) }}" method="POST" class="flex items-center">
                                    @csrf
                                    @method('PUT')
                                    <input type="number"
                                           name="jumlah"
                                           value="{{ $item->jumlah }}"
                                           min="1"
                                           max="{{ $item->produk->stok_produk }}"
                                           class="w-20 px-3 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <button type="submit" class="ml-2 px-3 py-1 bg-blue-100 text-blue-500 rounded hover:bg-blue-200 text-sm">
                                        Update
                                    </button>
                                </form>
                            </td>
                            <td class="py-4 px-4 text-gray-700">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            <td class="py-4 px-4">
                                <form action="{{ route('keranjang.destroyBig', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="py-4 px-4 text-right font-semibold text-gray-700">Total:</td>
                        <td class="py-4 px-4 font-semibold text-gray-800">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row justify-between mt-8 gap-4">
            <a href="{{ route('products') }}" class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 transition flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Lanjutkan Belanja
            </a>

            @auth
                <a href="{{ route('checkout') }}" class="border-b-4 border-black font-bold px-6 py-2 bg-koplak text-black px-6 py-2 rounded-md hover:bg-yellow-500 transition flex items-center justify-center">
                    Checkout
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            @else
                <button type="button" onclick="showLoginAlert()" class="border-b-4 border-black font-bold px-6 py-2 bg-koplak text-black rounded-md hover:bg-yellow-500 transition flex items-center justify-center cursor-pointer">
                    Checkout
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            @endauth
        </div>

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
        </script>
    @else
        <div class="bg-blue-100 border border-blue-400 text-yellow-500 px-4 py-3 rounded mt-6">
            Keranjang belanja Anda kosong. <a href="{{ route('products') }}" class="text-koplak hover:text-blue-800 font-medium">Belanja sekarang</a>
        </div>
    @endif
</div>
@endsection
