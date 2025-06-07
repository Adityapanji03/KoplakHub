<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Modal;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{

    public function index(Request $request)
    {
        // Set default filter period to current month if not provided
        $periode = $request->periode ?? 'bulan';
        $tanggal_mulai = null;
        $tanggal_akhir = null;

        // Set date range based on selected period
        if ($request->has('tanggal_mulai') && $request->has('tanggal_akhir')) {
            $tanggal_mulai = $request->tanggal_mulai;
            $tanggal_akhir = $request->tanggal_akhir;
        } else {
            $today = Carbon::today();

            switch ($periode) {
                case 'hari':
                    $tanggal_mulai = $today->format('Y-m-d');
                    $tanggal_akhir = $today->format('Y-m-d');
                    break;
                case 'minggu':
                    $tanggal_mulai = $today->startOfWeek()->format('Y-m-d');
                    $tanggal_akhir = $today->endOfWeek()->format('Y-m-d');
                    break;
                case 'bulan':
                default:
                    $tanggal_mulai = $today->startOfMonth()->format('Y-m-d');
                    $tanggal_akhir = $today->endOfMonth()->format('Y-m-d');
                    break;
            }
        }

        // Get modal data
        $modal = Modal::whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])
                      ->orderBy('tanggal', 'desc')
                      ->get();

        $total_modal = $modal->sum('jumlah');

        // Get transaction data
        $transaksi = Transaksi::whereBetween('created_at', [$tanggal_mulai, $tanggal_akhir])->get();
        $total_transaksi = $transaksi->where('status_pembayaran', 'success')->count();

        // Calculate gross revenue
        $pendapatan_kotor = DetailTransaksi::whereHas('transaksi', function($query) use ($tanggal_mulai, $tanggal_akhir) {
                                $query->whereBetween('created_at', [$tanggal_mulai, $tanggal_akhir]);
                            })
                            ->sum('subtotal');

        // Calculate net revenue
        $pendapatan_bersih = $pendapatan_kotor - $total_modal;

        // Get top selling products
        $produk_terlaris = DB::table('detail_transaksi')
            ->join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
            ->join('produk', 'detail_transaksi.produk_id', '=', 'produk.id')
            ->whereBetween('transaksi.created_at', [$tanggal_mulai, $tanggal_akhir])
            ->select(
                'produk.id',
                'produk.nama_produk',
                DB::raw('SUM(detail_transaksi.jumlah) as total_terjual'),
                DB::raw('SUM(detail_transaksi.subtotal) as total_pendapatan')
            )
            ->groupBy('produk.id', 'produk.nama_produk')
            ->orderBy('total_terjual', 'desc')
            ->limit(5)
            ->get();


        // Calculate daily sales for chart
        $data_penjualan_harian = DB::table('transaksi')
            ->join('detail_transaksi', 'transaksi.id', '=', 'detail_transaksi.transaksi_id')
            ->whereBetween('transaksi.created_at', [$tanggal_mulai, $tanggal_akhir])
            ->select(
                DB::raw('DATE(transaksi.created_at) as tanggal'),
                DB::raw('SUM(detail_transaksi.subtotal) as total_penjualan')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $totalProducts = Produk::count();
        $totalTransaksi = Transaksi::where('status_pembayaran', 'success')->count();
        return view('admin.keuangan.index', compact(
            'periode',
            'tanggal_mulai',
            'tanggal_akhir',
            'modal',
            'total_modal',
            'total_transaksi',
            'pendapatan_kotor',
            'pendapatan_bersih',
            'produk_terlaris',
            'data_penjualan_harian',
            'totalProducts',
            'totalTransaksi'
        ));
    }

    public function storeModal(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $validated['akun_id'] = Auth::id();

        Modal::create($validated);

        return redirect()->route('admin.keuangan.index')
                         ->with('success', 'Modal berhasil ditambahkan');
    }

    public function updateModal(Request $request, Modal $modal)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $modal->update($validated);

        return redirect()->route('admin.keuangan.index')
                         ->with('success', 'Modal berhasil diperbarui');
    }

    public function destroyModal(Modal $modal)
    {
        $modal->delete();

        return redirect()->route('admin.keuangan.index')
                         ->with('success', 'Modal berhasil dihapus');
    }


    public function report(Request $request)
    {
        return view('admin.keuangan.report');
    }
}
