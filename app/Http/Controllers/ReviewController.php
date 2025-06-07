<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ReviewReply;
use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    public function create($transactionId)
    {
        $transaction = Transaksi::with(['detailTransaksi.produk'])
            ->where('akun_id', Auth::id())
            ->findOrFail($transactionId);

        // Verify payment status is success
        if ($transaction->status_pembayaran !== 'success') {
            return redirect()->route('transaksi.histori')
                ->with('error', 'Only completed transactions can be reviewed.');
        }

        // Check if reviews already exist for this transaction
        $existingReviews = Review::where('transaksi_id', $transactionId)
            ->where('akun_id', Auth::id())
            ->pluck('produk_id')
            ->toArray();

        return view('customer.reviews.create', compact('transaction', 'existingReviews'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'transaksi_id' => 'required|exists:transaksi,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        // Verify the transaction belongs to the user
        $transaction = Transaksi::where('id', $request->transaksi_id)
            ->where('akun_id', Auth::id())
            ->firstOrFail();

        // Verify the product is part of this transaction
        $productExists = $transaction->detailTransaksi()
            ->whereHas('produk', function ($query) use ($request) {
                $query->where('id', $request->produk_id);
            })
            ->exists();

        if (!$productExists) {
            return back()->with('error', 'This product is not part of the specified transaction.');
        }

        // Check if a review already exists
        $existingReview = Review::where('akun_id', Auth::id())
            ->where('produk_id', $request->produk_id)
            ->where('transaksi_id', $request->transaksi_id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product for this transaction.');
        }

        // Create the review
        Review::create([
            'akun_id' => Auth::id(),
            'produk_id' => $request->produk_id,
            'transaksi_id' => $request->transaksi_id,
            'rating' => $request->rating,
            'review' => $request->review,
            'is_published' => true,
        ]);

        return back()->with('success', 'Thank you for your review!');
    }


    public function index()
    {
        $reviews = Review::with(['produk'])
            ->where('akun_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('customer.reviews.index', compact('reviews'));
    }

    public function indexAdmin(Request $request)
    {
        $query = Review::with(['produk', 'akun', 'reply']);

        // Filter by rating
        if ($request->has('rating') && $request->rating) {
            $query->where('rating', $request->rating);
        }

        // Filter by reply status
        if ($request->has('replied') && $request->replied !== '') {
            if ($request->replied == '1') {
                $query->whereHas('reply');
            } else {
                $query->whereDoesntHave('reply');
            }
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        // Validate sort fields
        $validSortFields = ['created_at', 'rating'];
        $sortField = in_array($sortField, $validSortFields) ? $sortField : 'created_at';
        $sortDirection = in_array($sortDirection, ['asc', 'desc']) ? $sortDirection : 'desc';

        $query->orderBy($sortField, $sortDirection);

        $reviews = $query->paginate(10)->appends($request->query());
        $products = Produk::orderBy('nama_produk')->get();
        $totalProducts = Produk::count();
        $totalTransaksi = Transaksi::where('status_pembayaran', 'success')->count();

        return view('admin.reviews.index', compact('reviews', 'products', 'totalProducts', 'totalTransaksi'));
    }


    public function show($id)
    {
        $review = Review::with(['produk', 'akun', 'reply'])->findOrFail($id);
        return view('admin.reviews.show', compact('review'));
    }
    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string|max:1000',
        ]);

        $review = Review::findOrFail($id);

        // Check if reply already exists
        if ($review->reply) {
            // Update existing reply
            $review->reply->update([
                'reply' => $request->reply,
                'admin_id' => auth()->id(),
            ]);

            $message = 'Reply berhasil diupdate';
        } else {
            // Create new reply
            ReviewReply::create([
                'review_id' => $review->id,
                'reply' => $request->reply,
                'admin_id' => auth()->id(),
            ]);

            $message = 'Reply berhasil ditambahkan';
        }

        return redirect()->route('admin.reviews.show', $review->id)
            ->with('success', $message);
    }
}
