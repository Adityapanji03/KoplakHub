<?php

namespace App\Services;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfExportService
{
    public function exportDashboard($periode, $tanggal_mulai, $tanggal_akhir, $data)
    {
        $pdf = Pdf::loadView('exports.dashboard', [
            'periode' => $periode,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir,
            'data' => $data,
            'tanggal_cetak' => Carbon::now()->format('d F Y H:i:s')
        ]);

        return $pdf->download('laporan-penjualan.pdf');
    }
}
