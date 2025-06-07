<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

        :root {
            --koplak: #FFEB3B;
            --koplak-dark: #FBC02D;
            --koplak-darker: #F57F17;
            --bg-dark: #111827;
            --bg-darker: #0D1321;
            --text-light: #E5E7EB;
            --text-lighter: #F3F4F6;
            --border-color: #374151;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-light);
            padding: 2rem;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background-color: var(--bg-darker);
            border-radius: 0.5rem;
            border-left: 4px solid var(--koplak);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--koplak);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .periode {
            font-size: 0.9rem;
            color: var(--text-lighter);
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .periode i {
            color: var(--koplak);
            margin-right: 0.5rem;
        }

        .section {
            margin-bottom: 2rem;
            background-color: var(--bg-darker);
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-weight: 600;
            font-size: 1.25rem;
            color: var(--koplak);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--border-color);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        th {
            background-color: var(--koplak);
            color: #000;
            font-weight: 600;
            padding: 0.75rem 1rem;
            text-align: left;
        }

        td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-color);
            background-color: rgba(255, 255, 255, 0.05);
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background-color: rgba(255, 235, 59, 0.1);
        }

        .text-right {
            text-align: right;
        }

        .text-koplak {
            color: var(--koplak);
        }

        .footer {
            margin-top: 3rem;
            font-size: 0.8rem;
            text-align: right;
            color: var(--text-lighter);
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer i {
            color: var(--koplak);
            margin-right: 0.5rem;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success {
            background-color: rgba(74, 222, 128, 0.1);
            color: #4ADE80;
        }

        .badge-warning {
            background-color: rgba(251, 191, 36, 0.1);
            color: #FBBF24;
        }

        @page {
            size: A4;
            margin: 2cm;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-chart-line"></i> LAPORAN PENJUALAN</h1>
        <div class="periode">
            <span><i class="fas fa-calendar-alt"></i> Periode: {{ ucfirst($periode) }}</span>
            <span><i class="fas fa-calendar-day"></i> Tanggal: {{ $tanggal_mulai }} s/d {{ $tanggal_akhir }}</span>
        </div>
    </div>

    <div class="section">
        <div class="section-title"><i class="fas fa-chart-pie"></i> Ringkasan</div>
        <table>
            <thead>
                <tr>
                    <th><i class="fas fa-money-bill-wave mr-1"></i> Total Modal</th>
                    <th><i class="fas fa-receipt mr-1"></i> Total Transaksi</th>
                    <th><i class="fas fa-coins mr-1"></i> Pendapatan Kotor</th>
                    <th><i class="fas fa-wallet mr-1"></i> Pendapatan Bersih</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-koplak">Rp{{ number_format($data['total_modal'], 0, ',', '.') }}</td>
                    <td><span class="badge badge-success">{{ $data['total_transaksi'] }} transaksi</span></td>
                    <td class="text-koplak">Rp{{ number_format($data['pendapatan_kotor'], 0, ',', '.') }}</td>
                    <td class="text-koplak">Rp{{ number_format($data['pendapatan_bersih'], 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title"><i class="fas fa-star"></i> Produk Terlaris</div>
        <table>
            <thead>
                <tr>
                    <th><i class="fas fa-cube mr-1"></i> Nama Produk</th>
                    <th><i class="fas fa-sort-amount-up mr-1"></i> Jumlah Terjual</th>
                    <th><i class="fas fa-money-bill-trend-up mr-1"></i> Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['produk_terlaris'] as $produk)
                <tr>
                    <td>{{ $produk->nama_produk }}</td>
                    <td><span class="badge badge-warning">{{ $produk->total_terjual }} pcs</span></td>
                    <td class="text-koplak">Rp{{ number_format($produk->total_pendapatan, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title"><i class="fas fa-calendar-day"></i> Penjualan Harian</div>
        <table>
            <thead>
                <tr>
                    <th><i class="fas fa-calendar mr-1"></i> Tanggal</th>
                    <th><i class="fas fa-chart-bar mr-1"></i> Total Penjualan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['data_penjualan_harian'] as $penjualan)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d M Y') }}</td>
                    <td class="text-koplak">Rp{{ number_format($penjualan->total_penjualan, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <div><i class="fas fa-print"></i> Dicetak oleh Sistem</div>
        <div><i class="fas fa-clock"></i> {{ $tanggal_cetak }}</div>
    </div>
</body>
</html>
