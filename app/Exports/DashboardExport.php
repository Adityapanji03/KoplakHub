<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class DashboardExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $periode;
    protected $tanggal_mulai;
    protected $tanggal_akhir;
    protected $data;

    public function __construct($periode, $tanggal_mulai, $tanggal_akhir, $data)
    {
        $this->periode = $periode;
        $this->tanggal_mulai = $tanggal_mulai;
        $this->tanggal_akhir = $tanggal_akhir;
        $this->data = $data;
    }

    public function collection()
    {
        // We'll use an empty collection since we're building custom data
        return collect([]);
    }

    public function headings(): array
    {
        return [
            ['LAPORAN DASHBOARD'],
            ['Periode: ' . $this->getPeriodeText()],
            ['Tanggal: ' . $this->tanggal_mulai . ' - ' . $this->tanggal_akhir],
            [], // Empty row
            ['Ringkasan', '', '', ''],
            ['Total Modal', 'Total Transaksi', 'Pendapatan Kotor', 'Pendapatan Bersih'],
        ];
    }

    public function map($row): array
    {
        // Summary data
        return [
            [], // Empty row
            [
                number_format($this->data['total_modal'], 0, ',', '.'),
                $this->data['total_transaksi'],
                number_format($this->data['pendapatan_kotor'], 0, ',', '.'),
                number_format($this->data['pendapatan_bersih'], 0, ',', '.')
            ],
            [], // Empty row
            ['Produk Terlaris', 'Jumlah Terjual', 'Total Pendapatan'],
            ...$this->data['produk_terlaris']->map(function($item) {
                return [
                    $item->nama_produk,
                    $item->total_terjual,
                    number_format($item->total_pendapatan, 0, ',', '.')
                ];
            })->toArray(),
            [], // Empty row
            ['Tanggal', 'Total Penjualan'],
            ...$this->data['data_penjualan_harian']->map(function($item) {
                return [
                    Carbon::parse($item->tanggal)->format('d M Y'),
                    number_format($item->total_penjualan, 0, ',', '.')
                ];
            })->toArray()
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true, 'size' => 16]],
            2 => ['font' => ['bold' => true]],
            5 => ['font' => ['bold' => true]],
            6 => ['font' => ['bold' => true]],
            'A6:D6' => ['font' => ['bold' => true]],

            // Set column widths
            'A' => 25,
            'B' => 15,
            'C' => 20,
            'D' => 20,

            // Add borders
            'A6:D7' => ['borders' => ['allBorders' => ['borderStyle' => 'thin']]],
            'A9:C'.(9 + count($this->data['produk_terlaris'])) => ['borders' => ['allBorders' => ['borderStyle' => 'thin']]],
            'A'.(11 + count($this->data['produk_terlaris'])) . ':B'.(11 + count($this->data['produk_terlaris']) + count($this->data['data_penjualan_harian'])) => ['borders' => ['allBorders' => ['borderStyle' => 'thin']]],
        ];
    }

    protected function getPeriodeText()
    {
        switch ($this->periode) {
            case 'hari': return 'Harian';
            case 'minggu': return 'Mingguan';
            case 'bulan': return 'Bulanan';
            default: return 'Custom';
        }
    }
}
