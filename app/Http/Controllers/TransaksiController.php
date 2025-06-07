<?php
namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\Akun;
use App\Services\RajaOngkirService;
use App\Models\Keranjang;
use App\Models\Keuangan;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::where('akun_id', Auth::id())
            ->latest()
            ->paginate(10);



        return view('transaksi.index', compact('transaksis'));
    }


    public function checkout(Request $request)
    {
        $user = Auth::user();
        $akun = Akun::where('id', $user->id)->firstOrFail();
        $keranjangItems = Keranjang::where('user_id', $user->id)->with('produk')->get();
        $total = $keranjangItems->sum('subtotal');
        $beratTotal = 1000; // Berat tetap 1000 gram (1kg)

        // Inisialisasi variabel
        $biayaPengiriman = 10000;
        $availableCouriers = [];
        $error = null;

        // Validasi data alamat
        if (empty($akun->provinsi)) {
            $error = 'Alamat pengiriman belum lengkap. Silakan lengkapi profil Anda terlebih dahulu.';
        } else {
            try {
                // Hitung ongkir berdasarkan provinsi
                $shippingCost = $this->calculateJNTShipping($akun->provinsi, $beratTotal);

                if ($shippingCost === null) {
                    $error = 'Provinsi tidak ditemukan dalam daftar pengiriman JNT.';
                    $biayaPengiriman = 25000; // Default
                } else {
                    $biayaPengiriman = $shippingCost;

                    // Set available couriers hanya JNT
                    $availableCouriers['jnt'] = [
                        'name' => 'JNT',
                        'services' => [
                            [
                                'service' => 'REG',
                                'description' => 'JNT Regular',
                                'cost' => $biayaPengiriman,
                                'etd' => '2-5 hari kerja'
                            ]
                        ]
                    ];
                }
            } catch (\Exception $e) {
                \Log::error('Error calculating JNT shipping: ' . $e->getMessage());
                $error = 'Gagal menghitung ongkos kirim. Silakan coba lagi nanti.';
            }
        }

        return view('checkout.index', [
            'user' => $user,
            'akun' => $akun,
            'keranjangItems' => $keranjangItems,
            'total' => $total,
            'biayaPengiriman' => $biayaPengiriman,
            'availableCouriers' => $availableCouriers,
            'beratTotal' => $beratTotal,
            'error' => $error
        ]);
    }

    private function calculateJNTShipping($provinsi, $berat)
    {
        // Normalisasi nama provinsi (hapus spasi berlebih dan ubah ke lowercase)
        $provinsiNormalized = strtolower(trim($provinsi));

        // Berat dalam kg (pembulatan ke atas)
        $beratKg = ceil($berat / 1000);

        // Mapping provinsi ke zona tarif JNT
        $zonaProvinsi = [
            'jawa timur' => 0,
            // Zona 1 - Jawa (Tarif termurah)
            'dki jakarta' => 1,
            'jawa barat' => 1,
            'jawa tengah' => 1,
            'di yogyakarta' => 1,
            'banten' => 1,

            // Zona 2 - Bali
            'bali' => 2,
            'nusa tenggara barat' => 2,
            'nusa tenggara timur' => 2,

            // Zona 3 - Sumatra bagian tengah dan utara
            'sumatera utara' => 3,
            'sumatera barat' => 3,
            'sumatera selatan' => 3,
            'bengkulu' => 3,
            'lampung' => 3,
            'riau' => 3,
            'aceh' => 3,
            'kepulauan riau' => 3,
            'kepulauan bangka belitung' => 3,
            'jambi' => 3,

            // Zona 4 - Kalimantan dan Sulawesi bagian selatan
            'kalimantan barat' => 4,
            'kalimantan tengah' => 4,
            'kalimantan selatan' => 4,
            'kalimantan timur' => 4,
            'kalimantan utara' => 4,
            'sulawesi selatan' => 4,
            'sulawesi tenggara' => 4,
            'sulawesi barat' => 4,

            // Zona 5 - Sulawesi bagian utara dan NTT
            'sulawesi tengah' => 5,
            'sulawesi utara' => 5,
            'gorontalo' => 5,

            // Zona 6 - Papua dan Maluku (Tarif termahal)
            'maluku' => 6,
            'maluku utara' => 6,
            'papua' => 6,
            'papua barat' => 6,
            'papua selatan' => 6,
            'papua tengah' => 6,
            'papua pegunungan' => 6,
            'papua barat daya' => 6,

            // Tambahan untuk kepulauan
            'kepulauan bangka belitung' => 3,
            'bangka belitung' => 3,
        ];

        // Cari zona berdasarkan provinsi
        $zona = null;
        foreach ($zonaProvinsi as $prov => $z) {
            if (strpos($provinsiNormalized, $prov) !== false || strpos($prov, $provinsiNormalized) !== false) {
                $zona = $z;
                break;
            }
        }

        // Jika provinsi tidak ditemukan, return null
        if ($zona === null) {
            return null;
        }

        // Tarif per kg berdasarkan zona (dalam rupiah)
        $tarifPerKg = [
            0 => 8000, // jatim
            1 => 18000,   // Zona 1 - Jawa
            2 => 22000,  // Zona 2 - Sumatra Selatan & Bali
            3 => 25000,  // Zona 3 - Sumatra Utara & Tengah
            4 => 28000,  // Zona 4 - Kalimantan & Sulawesi Selatan
            5 => 32000,  // Zona 5 - Sulawesi Utara & NTT
            6 => 38000,  // Zona 6 - Papua & Maluku
        ];

        // Hitung total biaya
        $biayaPerKg = $tarifPerKg[$zona];
        $totalBiaya = $biayaPerKg * $beratKg;

        // Minimum charge 1kg
        if ($totalBiaya < $biayaPerKg) {
            $totalBiaya = $biayaPerKg;
        }

        return $totalBiaya;
    }

    // Helper function untuk mapping nama provinsi ke ID RajaOngkir
    private function getProvinceId($provinsiName)
    {
        $provinceMapping = [
            'DKI JAKARTA' => 6,
            'JAWA BARAT' => 9,
            'JAWA TENGAH' => 10,
            'DI YOGYAKARTA' => 5,
            'JAWA TIMUR' => 11,
            'BANTEN' => 3
        ];

        return $provinceMapping[$provinsiName] ?? null;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $akun = Akun::where('id', $user->id)->firstOrFail();
        $keranjangItems = Keranjang::where('user_id', $user->id)->with('produk')->get();

        // Validasi keranjang kosong
        if ($keranjangItems->isEmpty()) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Keranjang belanja Anda kosong');
        }

        // Hitung total
        $subtotal = $keranjangItems->sum(function ($item) {
            return $item->harga * $item->jumlah;
        });

        $beratTotal = 1000;
        $biayaPengiriman = $this->calculateJNTShipping($akun->provinsi, $beratTotal);
        $totalBayar = $subtotal + $biayaPengiriman;

        $transaksi = Transaksi::create([
            'akun_id' => $user->id,
            'total_harga' => $subtotal,
            'biaya_pengiriman' => $biayaPengiriman,
            'total_bayar' => $totalBayar,
            'metode_pembayaran' => null,
            'status_pembayaran' => 'pending',
            'status_pengiriman' => 'dikemas',
            'alamat_pengiriman' => json_encode([
                'detail_alamat' => $user->detail_alamat ?? '',
                'kelurahan' => $user->kelurahan ?? '',
                'kecamatan' => $user->kecamatan ?? '',
                'kabupaten' => $user->kabupaten ?? '',
                'provinsi' => $user->provinsi ?? '',
                'no_hp' => $user->no_hp ?? ''
            ]),
            'snap_token' => null,
            'midtrans_order_id' => null
        ]);


        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Siapkan parameter transaksi
        $params = [
            'transaction_details' => [
                'order_id' => 'TRX-' . $transaksi->id,
                'gross_amount' => $totalBayar,
            ],
            'customer_details' => [
                'first_name' => $user->nama ?? 'Customer',
                'phone' => $user->no_hp ?? '',
            ],
        ];

        try {
            // Dapatkan Snap Token
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Update transaksi dengan snap token
            $transaksi->update([
                'snap_token' => $snapToken,
                'midtrans_order_id' => $params['transaction_details']['order_id']
            ]);

            // Buat detail transaksi
            $this->createDetailTransaksi($transaksi, $keranjangItems);

            // Kosongkan keranjang setelah transaksi dibuat
            Keranjang::where('user_id', $user->id)->delete();


            $transaksi->akun_id = Auth::id();
            $transaksi->save();
            $transaksi = Transaksi::with(['detailTransaksi.produk'])
            ->where('akun_id', auth()->id())
            ->where('status_pembayaran', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            // Redirect ke halaman pembayaran Midtrans
            return view('transaksi.payment', compact('snapToken', 'transaksi'));

        } catch (\Exception $e) {
            // Handle error
            Log::error('Midtrans Token Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }
    }


    private function createDetailTransaksi($transaksi, $keranjangItems)
    {
        $detailTransaksiData = [];

        foreach ($keranjangItems as $item) {
            $detailTransaksiData[] = [
                'transaksi_id' => $transaksi->id,
                'produk_id' => $item->produk_id,
                'jumlah' => $item->jumlah,
                'harga' => $item->harga,
                'subtotal' => $item->harga * $item->jumlah,
                'created_at' => now(),
                'updated_at' => now()
            ];

            // Kurangi stok produk
            $item->produk->decrement('stok_produk', $item->jumlah);
        }

        // Mass insert detail transaksi
        if (!empty($detailTransaksiData)) {
            \App\Models\DetailTransaksi::insert($detailTransaksiData);
        }
    }

    public function notificationHandler(Request $request)
    {
        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');

        try {
            $notification = new \Midtrans\Notification();

            $orderId = $notification->order_id;
            $status = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;
            $paymentType = $notification->payment_type;

            // Extract transaction ID from order_id (assuming format is TRX-{id})
            $transactionId = str_replace('TRX-', '', $orderId);

            // Get the transaction
            $transaksi = Transaksi::find($transactionId);

            if (!$transaksi) {
                Log::error('Transaction not found: ' . $orderId);
                return response()->json(['status' => 'error', 'message' => 'Transaction not found'], 404);
            }

            DB::beginTransaction();

            try {
                if ($status == 'capture') {
                    if ($fraudStatus == 'challenge') {
                        // Set payment status to pending if fraud detection challenged
                        $transaksi->status_pembayaran = 'pending';
                    } else if ($fraudStatus == 'accept') {
                        // Set payment status to success
                        $transaksi->status_pembayaran = 'success';
                        $transaksi->metode_pembayaran = $paymentType;

                        // gdipake
                        // Keuangan::create([
                        //     'transaksi_id' => $transaksi->id,
                        //     'total' => $transaksi->total_bayar,
                        //     'jenis' => 'pemasukan',
                        //     'keterangan' => 'Pembayaran transaksi #' . $transaksi->id
                        // ]);
                    }
                } else if ($status == 'settlement') {
                    // Set payment status to success
                    $transaksi->status_pembayaran = 'success';
                    $transaksi->metode_pembayaran = $paymentType;

                    // gdipke
                    // Keuangan::create([
                    //     'transaksi_id' => $transaksi->id,
                    //     'total' => $transaksi->total_bayar,
                    //     'jenis' => 'pemasukan',
                    //     'keterangan' => 'Pembayaran transaksi #' . $transaksi->id
                    // ]);
                } else if ($status == 'deny' || $status == 'cancel' || $status == 'expire') {
                    // Payment failed or expired, set status accordingly
                    $transaksi->status_pembayaran = $status == 'expire' ? 'expired' : 'failed';

                    // Return product stock
                    $this->returnProductStock($transaksi);
                } else if ($status == 'pending') {
                    // Payment is still pending
                    $transaksi->status_pembayaran = 'pending';
                }

                // Update payment method and save changes
                if (!$transaksi->metode_pembayaran && $paymentType) {
                    $transaksi->metode_pembayaran = $paymentType;
                }

                $transaksi->save();
                DB::commit();

                return response()->json(['status' => 'success']);
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Error processing payment notification: ' . $e->getMessage());
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
        } catch (\Exception $e) {
            Log::error('Notification Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    private function returnProductStock($transaksi)
    {
        // Get all detail transaksi related to this transaction
        $detailTransaksis = DetailTransaksi::where('transaksi_id', $transaksi->id)->with('produk')->get();

        foreach ($detailTransaksis as $detail) {
            // Increment product stock
            if ($detail->produk) {
                $detail->produk->increment('stok_produk', $detail->jumlah);
                Log::info('Returned ' . $detail->jumlah . ' stock for product ID: ' . $detail->produk_id);
            }
        }
    }

    public function payment(Transaksi $transaksi)
    {


        $transaksi = Transaksi::with(['detailTransaksi.produk'])
        ->where('akun_id', auth()->id())
        ->where('status_pembayaran', 'pending')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        $snapToken = null;

        if ($transaksi->isNotEmpty()) {
            $snapToken = $transaksi->first()->snap_token;
        }

        return view('transaksi.payment', compact('transaksi', 'snapToken'));
    }

    public function checkStatus(Transaksi $transaksi)
    {

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');

        try {
            // Get status from Midtrans
            $status = \Midtrans\Transaction::status($transaksi->midtrans_order_id);

            // Update transaction status based on Midtrans response
            $this->updateTransactionStatus($transaksi, $status);

            return redirect()->route('transaksi.histori', $transaksi->id)
                ->with('success', 'Status transaksi berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error checking payment status: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memeriksa status pembayaran.');
        }
    }

    private function updateTransactionStatus($transaksi, $status)
    {
        $transactionStatus = $status->transaction_status ?? null;
        $fraudStatus = $status->fraud_status ?? null;
        $paymentType = $status->payment_type ?? null;

        DB::beginTransaction();

        try {
            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                if ($fraudStatus == 'challenge') {
                    $transaksi->status_pembayaran = 'pending';
                } else {
                    $transaksi->status_pembayaran = 'success';

                }
            } else if ($transactionStatus == 'deny' || $transactionStatus == 'cancel' || $transactionStatus == 'expire') {
                // Payment failed or expired
                $transaksi->status_pembayaran = $transactionStatus == 'expire' ? 'expired' : 'failed';

                // Return product stock if the status is changing to failed or expired
                if ($transaksi->isDirty('status_pembayaran')) {
                    $this->returnProductStock($transaksi);
                }
            }

            // Update payment method if available
            if (!$transaksi->metode_pembayaran && $paymentType) {
                $transaksi->metode_pembayaran = $paymentType;
            }

            $transaksi->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating transaction status: ' . $e->getMessage());
            throw $e;
        }
    }


    public function histori(Request $request)
    {

        $query =  Transaksi::where('akun_id', Auth::id())
            ->where('status_pembayaran', '!=', 'pending')
            ->with('akun')
            ->orderBy('created_at', 'desc');

        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status_pengiriman', $request->status);
        }

        $transaksi = $query->paginate(10);
        $transaksi->appends($request->only(['status']));

        return view('transaksi.histori', compact('transaksi'));
    }

    public function home(Request $request)
    {
        $query = Transaksi::where('status_pembayaran', 'success')
            ->with('akun')
            ->orderBy('created_at', 'desc');

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%$search%")
                ->orWhereHas('akun', function($q) use ($search) {
                    $q->where('nama', 'like', "%$search%");
                });
            });
        }

        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status_pengiriman', $request->status);
        }

        $transactions = $query->paginate(10);
        $transactions->appends($request->only(['search', 'status']));
        $totalProducts = Produk::count();
        $totalTransaksi = Transaksi::where('status_pembayaran', 'success')->count();
        return view('admin.transaksi.index', compact('transactions', 'totalProducts', 'totalTransaksi'));
    }
    public function show($id)
    {
        $transaction = Transaksi::with(['akun', 'detailTransaksi.produk'])
            ->findOrFail($id);

        // Verifikasi status pembayaran success
        if ($transaction->status_pembayaran !== 'success') {
            return redirect()->route('admin.transaksi.index')
                ->with('error', 'Hanya transaksi dengan status pembayaran success yang dapat dilihat.');
        }

        return view('admin.transaksi.show', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_resi' => 'nullable|string|max:50',
            'status_pengiriman' => 'required|in:dikemas,dikirim',
        ]);

        $transaction = Transaksi::findOrFail($id);

        // Verifikasi status pembayaran success
        if ($transaction->status_pembayaran !== 'success') {
            return redirect()->route('admin.transaksi.index')
                ->with('error', 'Hanya transaksi dengan status pembayaran success yang dapat diupdate.');
        }

        $transaction->nomor_resi = $request->nomor_resi;
        $transaction->status_pengiriman = $request->status_pengiriman;
        $transaction->save();

        return redirect()->route('admin.transaksi.show', $transaction->id)
            ->with('success', 'Informasi pengiriman berhasil diperbarui!');
    }
    public function selesaikan($id)
    {
        DB::table('transaksi')
            ->where('id', $id)
            ->update(['status_pengiriman' => 'diterima']);

        return redirect()->route('customer.reviews.create', $id)
            ->with('success', 'Pesanan telah diterima, Terima kasih customer KoplakFood ><');
    }
}

