<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Review;
use App\Models\Keranjang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{

    public function index()
    {
        $totalProducts = Produk::count();
        $totalTransaksi = Transaksi::where('status_pembayaran', 'success')->count();
        $products = Produk::latest()->paginate(10);
        return view('productsAdmin.index', compact('products', 'totalProducts', 'totalTransaksi'));
    }

    public function customer()
    {
        $products = Produk::withCount('reviews')->get()->map(function($product) {
            $product->average_rating = $product->reviews()->avg('rating') ?? 0;
            $product->sold_count = $product->reviews()->count();
            return $product;
        });

        return view('products', [
            'products' => $products,
        ]);
    }


    public function create()
    {
        return view('productsAdmin.create');
    }


    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_produk' => 'required|integer|min:1',
            'stok_produk' => 'required|integer|max:9999',
            'deskripsi_produk' => 'required|string',
            'gambar_produk' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('gambar_produk')) {
            // Store the image file and get its path
            $imagePath = $request->file('gambar_produk')->store('products', 'public');
            $validated['gambar_produk'] = $imagePath;
        }

        // Create product
        Produk::create($validated);

        return redirect()->route('productsAdmin.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }


    public function show(Produk $produk)
    {
        return view('productsAdmin.showProduk', compact('produk'));
    }


    public function edit(Produk $produk)
    {
        return view('productsAdmin.editProduk', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        // Validate request
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_produk' => 'required|integer|min:1',
            'stok_produk' => 'required|integer|max:9999',
            'deskripsi_produk' => 'required|string',
            'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('gambar_produk')) {
            // Delete old image if exists
            if ($produk->gambar_produk && Storage::disk('public')->exists($produk->gambar_produk)) {
                Storage::disk('public')->delete($produk->gambar_produk);
            }

            // Store the new image file and get its path
            $imagePath = $request->file('gambar_produk')->store('products', 'public');
            $validated['gambar_produk'] = $imagePath;
        }

        // Update product
        $produk->update($validated);

        return redirect()->route('productsAdmin.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function deactivate(Produk $produk)
    {
        // Set product stock to 0 (deactivate)
        $produk->update(['stok_produk' => 0]);

        return redirect()->route('productsAdmin.index')
            ->with('success', 'Produk berhasil dinonaktifkan!');
    }


    public function destroy(Produk $produk)
    {
        // Redirect to deactivate instead
        return $this->deactivate($produk);
    }


    public function detail($id)
    {
        $product = Produk::findOrFail($id);

        // // Check if product has stock
        // if ($product->stok_produk <= 0) {
        //     return redirect()->route('products')
        //         ->with('error', 'Produk tidak tersedia.');
        // }

        return view('products.detail', compact('product'));
    }


    public function addToKeranjang(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $produkId = $request->input('produk_id');
        $jumlah = $request->input('jumlah');

        $produk = Produk::findOrFail($produkId);
        $userId = Auth::check() ? Auth::id() : session()->getId();

        $keranjangItem = Keranjang::where('user_id', $userId)
            ->where('produk_id', $produkId)
            ->first();

        $totalQuantity = $jumlah;
        if ($keranjangItem) {
            $totalQuantity += $keranjangItem->jumlah;
        }

        if ($produk->stok_produk < $totalQuantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk tidak mencukupi. Stok tersedia: ' . $produk->stok_produk .
                            ', jumlah di keranjang: ' . ($keranjangItem ? $keranjangItem->jumlah : 0)
            ], 400);
        }

        if ($keranjangItem) {
            $keranjangItem->jumlah += $jumlah;
            $keranjangItem->save();
        } else {
            Keranjang::create([
                'user_id' => $userId,
                'produk_id' => $produkId,
                'jumlah' => $jumlah,
                'harga' => $produk->harga_produk
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'cart_count' => Keranjang::where('user_id', $userId)->sum('jumlah')
        ]);
    }
    public function DetailaddToKeranjang(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $produkId = $request->input('produk_id');
        $jumlah = $request->input('jumlah');

        $produk = Produk::findOrFail($produkId);
        $userId = Auth::check() ? Auth::id() : session()->getId();

        $keranjangItem = Keranjang::where('user_id', $userId)
            ->where('produk_id', $produkId)
            ->first();

        $totalQuantity = $jumlah;
        if ($keranjangItem) {
            $totalQuantity += $keranjangItem->jumlah;
        }

        if ($produk->stok_produk < $totalQuantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk tidak mencukupi. Stok tersedia: ' . $produk->stok_produk .
                            ', jumlah di keranjang: ' . ($keranjangItem ? $keranjangItem->jumlah : 0)
            ], 400);
        }

        if ($keranjangItem) {
            $keranjangItem->jumlah += $jumlah;
            $keranjangItem->save();
        } else {
            Keranjang::create([
                'user_id' => $userId,
                'produk_id' => $produkId,
                'jumlah' => $jumlah,
                'harga' => $produk->harga_produk
            ]);
        }

        // Get user ID (can be user ID or session ID for guests)
        $userId = Auth::check() ? Auth::id() : session()->getId();

        // Get keranjang items with product information
        $keranjangItems = Keranjang::where('user_id', $userId)
            ->with('produk')
            ->get();

        // Calculate keranjang total
        $total = $keranjangItems->sum(function($item) {
            return $item->jumlah * $item->harga;
        });

        return view('keranjang.index', compact('keranjangItems', 'total'));
    }

    public function apiIndex()
    {
        try {
            $products = Produk::select([
                    'id',
                    'nama_produk',
                    'harga_produk',
                    'gambar_produk',
                    'deskripsi_produk',
                    'stok_produk',
                ])
                ->where('stok_produk', '>', 0)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $products,
                'message' => 'Products retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve products: ' . $e->getMessage()
            ], 500);
        }
    }
}
