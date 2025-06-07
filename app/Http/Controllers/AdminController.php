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
use Illuminate\Support\Facades\Process;
use App\Services\PdfExportService;


class AdminController extends Controller
{
    public function index(Request $request)
    {
        $totalProducts = Produk::count();
        $totalTransaksi = Transaksi::where('status_pembayaran', 'success')->count();

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

        $modal = Modal::whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])
                      ->orderBy('tanggal', 'desc')
                      ->get();

        $total_modal = $modal->sum('jumlah');

        $transaksi = Transaksi::whereBetween('created_at', [$tanggal_mulai, $tanggal_akhir])->get();
        $total_transaksi = $transaksi->where('status_pembayaran', 'success')->count();

        $pendapatan_kotor = DetailTransaksi::whereHas('transaksi', function($query) use ($tanggal_mulai, $tanggal_akhir) {
                                $query->whereBetween('created_at', [$tanggal_mulai, $tanggal_akhir]);
                            })
                            ->sum('subtotal');
        $pendapatan_bersih = $pendapatan_kotor - $total_modal;

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

        // data 12 bulan terakhir
        $historicalData = [];
        for ($i = 11; $i >= 0; $i--) {
            $startDate = Carbon::now()->subMonths($i)->startOfMonth();
            $endDate = Carbon::now()->subMonths($i)->endOfMonth();

            $monthlyModal = Modal::whereBetween('tanggal', [$startDate, $endDate])->sum('jumlah');
            $monthlyGross = DetailTransaksi::whereHas('transaksi', function($query) use ($startDate, $endDate) {
                                $query->whereBetween('created_at', [$startDate, $endDate])
                                      ->where('status_pembayaran', 'success');
                            })->sum('subtotal');

            $monthlyNet = $monthlyGross - $monthlyModal;

            $historicalData[] = [
                'month' => $startDate->month,
                'year' => $startDate->year,
                'net_revenue' => $monthlyNet
            ];
        }

        // Simple prediction dari 3 bulan terakhir
        $last3Months = array_slice($historicalData, -3);
        $sum = 0;
        foreach ($last3Months as $month) {
            $sum += $month['net_revenue'];
        }
        $predictedValue = $sum / 3;

        $currentMonthRevenue = end($historicalData)['net_revenue'];
        $previousMonthRevenue = $historicalData[count($historicalData)-2]['net_revenue'];
        if ($currentMonthRevenue != 0) {
            $accuracy = 100 - (abs($currentMonthRevenue - $predictedValue) / $currentMonthRevenue) * 100;
        } else {
            // Jika pendapatan bulan ini nol, akurasi bisa dianggap nol atau tidak terdefinisi
            $accuracy = 0;
        }

        // Pastikan akurasi tidak lebih dari 100 atau kurang dari 0
        $accuracy = max(0, min(100, $accuracy));
        // $accuracy = 100 - min(100, abs(($previousMonthRevenue - $currentMonthRevenue) / ($previousMonthRevenue ?: 1)) * 100);

        // Calculate percentage change
        $change = $currentMonthRevenue != 0
            ? (($predictedValue - $currentMonthRevenue) / $currentMonthRevenue) * 100
            : 0;

        $prediction = [
            'value' => max(0, $predictedValue), // gada negatif
            'accuracy' => $accuracy,
            'change' => $change,
            'method' => '3-Month Average'
        ];

        // Format bln dpn
        $nextMonth = Carbon::now()->addMonth();
        $nextMonthFormatted = $nextMonth->format('F Y');

        return view('admin.dashboard', compact(
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
            'nextMonthFormatted',
            'historicalData',
            'currentMonthRevenue',
            'prediction',
            'totalProducts',
            'totalTransaksi'
        ));
    }


    public function exportPdf(Request $request)
    {
        $data = $this->getDashboardData($request);

        $pdfService = new PdfExportService();
        return $pdfService->exportDashboard(
            $data['periode'],
            $data['tanggal_mulai'],
            $data['tanggal_akhir'],
            $data
        );
    }

    protected function getDashboardData(Request $request)
    {
        $totalProducts = Produk::count();
        $totalTransaksi = Transaksi::where('status_pembayaran', 'success')->count();
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

        return [
            'periode' => $periode,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir,
            'total_modal' => $total_modal,
            'total_transaksi' => $total_transaksi,
            'pendapatan_kotor' => $pendapatan_kotor,
            'pendapatan_bersih' => $pendapatan_bersih,
            'produk_terlaris' => $produk_terlaris,
            'data_penjualan_harian' => $data_penjualan_harian,
            'totalProducts' => $totalProducts,
            'totalTransaksi' => $totalTransaksi
        ];
    }
}
