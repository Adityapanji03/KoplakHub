<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{

    public function index()
    {
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


    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $keranjangItem = Keranjang::findOrFail($id);
        $produk = Produk::findOrFail($keranjangItem->produk_id);

        // Check if user owns this keranjang item
        $userId = Auth::check() ? Auth::id() : session()->getId();
        if ($keranjangItem->user_id != $userId) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengubah item ini.');
        }

        // Check if product has enough stock
        if ($produk->stok_produk < $request->jumlah) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Stok produk tidak mencukupi.');
        }

        // Update quantity
        $keranjangItem->jumlah = $request->jumlah;
        $keranjangItem->save();

        return redirect()->route('keranjang.index')
            ->with('success', 'Jumlah produk berhasil diperbarui!');
    }


    public function increaseQuantity($id)
    {
        try {
            $userId = Auth::check() ? Auth::id() : session()->getId();

            $cartItem = Keranjang::with('produk')
                ->where('id', $id)
                ->where('user_id', $userId)
                ->firstOrFail();

            // Check product stock
            if ($cartItem->produk->stok_produk <= $cartItem->jumlah) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok produk tidak mencukupi'
                ], 400);
            }

            $cartItem->increment('jumlah');
            $cartItem->refresh(); // Refresh untuk mendapatkan nilai terbaru

            return response()->json([
                'success' => true,
                'new_quantity' => $cartItem->jumlah,
                'message' => 'Quantity berhasil ditambah'
            ]);

        } catch (\Exception $e) {
            \Log::error('Increase quantity error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambah quantity: ' . $e->getMessage()
            ], 500);
        }
    }

    public function decreaseQuantity($id)
    {
        try {
            $userId = Auth::check() ? Auth::id() : session()->getId();

            $cartItem = Keranjang::where('id', $id)
                ->where('user_id', $userId)
                ->firstOrFail();

            if ($cartItem->jumlah <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Quantity tidak boleh kurang dari 1'
                ], 400);
            }

            $cartItem->decrement('jumlah');
            $cartItem->refresh(); // Refresh untuk mendapatkan nilai terbaru

            return response()->json([
                'success' => true,
                'new_quantity' => $cartItem->jumlah,
                'message' => 'Quantity berhasil dikurangi'
            ]);

        } catch (\Exception $e) {
            \Log::error('Decrease quantity error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengurangi quantity: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        // Clean the ID by extracting only numeric parts
        $cleanId = preg_replace('/[^0-9]/', '', $id);

        if (!is_numeric($cleanId)) {
            return response()->json([
                'success' => false,
                'message' => 'ID keranjang tidak valid'
            ], 400);
        }

        try {
            $cartItem = Keranjang::where('id', $cleanId)
                        ->where('user_id', auth()->id())
                        ->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => false,  // Changed from true to false
                    'message' => 'Item tidak ditemukan'
                ], 404);
            }

            $cartItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item berhasil dihapus',
                'data' => [
                    'remaining_items' => auth()->user()->cartItems()->count(),
                    'new_total' => auth()->user()->cartTotal()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem'
            ], 500);
        }
    }

    public function removeByProduct(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|integer'
        ]);


        try {
            $produk = Produk::find($request->produk_id);

            if (!$produk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan'
                ], 404);
            }

            $cartItem = Keranjang::where('produk_id', $produk->id)
                                 ->where('user_id', auth()->id())
                                 ->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item sudah tidak ada di keranjang'
                ]);
            }

            $cartItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item berhasil dihapus dari keranjang',
                'data' => [
                    'remaining_items' => auth()->user()->cartItems()->count(),
                    'new_total' => auth()->user()->cartTotal()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus item: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroyBig($id)
    {
        $keranjangItem = Keranjang::findOrFail($id);

        // Check if user owns this keranjang item
        $userId = Auth::check() ? Auth::id() : session()->getId();
        if ($keranjangItem->user_id != $userId) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus item ini.');
        }

        // Delete keranjang item
        $keranjangItem->delete();

        return redirect()->route('keranjang.index')
            ->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    public function getKeranjang()
    {
        $userId = Auth::check() ? Auth::id() : session()->getId();

        $items = Keranjang::with('produk')
            ->where('user_id', $userId)
            ->get();

        return response()->json([
            'items' => $items,
            'total' => $items->sum('jumlah')
        ]);
    }
}
