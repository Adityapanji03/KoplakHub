<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan Resmi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --primary: #090909;
            --primary-light: #090909;
            --accent: #090909;
            --accent-light: #090909;
            --text-dark: #333333;
            --text-medium: #555555;
            --text-light: #777777;
            --border-color: #E0E0E0;
            --success: #388E3C;
            --warning: #FFA000;
            --header-bg: #F5F5F5;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: white;
            color: var(--text-dark);
            padding: 0;
            margin: 0;
            line-height: 1.6;
            font-weight: 400;
        }

        .page-container {
            padding: 2.5cm;
        }

        /* Institutional Header */
        .letterhead {
            border-bottom: 3px solid var(--primary);
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            position: relative;
        }

        .letterhead-top {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .institution-logo {
            width: 80px;
            height: 80px;
            margin-right: 1.5rem;
            border: 2px solid var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
        }

        .institution-logo i {
            font-size: 2.5rem;
            color: var(--primary);
        }

        .institution-info {
            flex: 1;
        }

        .institution-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            margin: 0;
            letter-spacing: 0.5px;
        }

        .institution-subname {
            font-size: 1rem;
            font-weight: 500;
            color: var(--primary-light);
            margin: 0.25rem 0;
        }

        .institution-address {
            font-size: 0.8rem;
            color: var(--text-medium);
            margin: 0.25rem 0;
            line-height: 1.4;
        }

        .document-title {
            text-align: center;
            margin: 2rem 0;
        }

        .document-title h1 {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            position: relative;
            display: inline-block;
            padding-bottom: 0.5rem;
        }

        .document-title h1:after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 25%;
            width: 50%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
        }

        .document-subtitle {
            font-size: 0.9rem;
            color: var(--text-medium);
            margin-top: 0.5rem;
        }

        /* Document Content */
        .periode-info {
            background-color: var(--header-bg);
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
        }

        .periode-item {
            display: flex;
            align-items: center;
        }

        .periode-item i {
            color: var(--primary);
            margin-right: 0.5rem;
            font-size: 0.9rem;
        }

        .section {
            margin-bottom: 2.5rem;
            position: relative;
        }

        .section-title {
            font-weight: 600;
            font-size: 1.2rem;
            color: var(--primary);
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--border-color);
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 0.75rem;
            color: var(--accent);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        th {
            background-color: var(--primary);
            color: white;
            font-weight: 500;
            padding: 0.75rem 1rem;
            text-align: left;
            font-size: 0.85rem;
        }

        td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background-color: rgba(41, 98, 255, 0.03);
        }

        .text-right {
            text-align: right;
        }

        .text-primary {
            color: var(--primary);
            font-weight: 500;
        }

        .text-accent {
            color: var(--accent);
            font-weight: 500;
        }

        .footer {
            margin-top: 3rem;
            font-size: 0.8rem;
            color: var(--text-light);
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-success {
            background-color: rgba(56, 142, 60, 0.1);
            color: var(--success);
            border: 1px solid var(--success);
        }

        .badge-warning {
            background-color: rgba(255, 160, 0, 0.1);
            color: var(--warning);
            border: 1px solid var(--warning);
        }

        .summary-value {
            font-size: 1.1rem;
            font-weight: 500;
        }


        @page {
            size: A4;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="page-container">
        <!-- Official Letterhead -->
        <div class="letterhead">
            <div class="institution-info">
                <h1 class="institution-name">KOPLAKHUB</h1>
                <div class="institution-subname">LAPORAN RESMI PENJUALAN</div>
                <div class="institution-address">
                    Dusun Gumuksegawe, Gumuk Segawe, Pancakarya, Kec. Ajung, Kabupaten Jember, Jawa Timur 68175<br>
                    Telp: 083113126056 | Email: koplakfood@gmail.com
                </div>
            </div>
        </div>

        <!-- Document Title -->
        <div class="document-title">
            <h1>LAPORAN PENJUALAN</h1>
            <div class="document-subtitle">Rekap Penjualan Bulan ini</div>
        </div>

        <!-- Period Information -->
        <div class="periode-info">
            <div class="periode-item">
                <i class="fas fa-calendar-alt"></i>
                <span>Periode: {{ ucfirst($periode) }}</span>
            </div>
            <div class="periode-item">
                <i class="fas fa-calendar-day"></i>
                <span>Tanggal: {{ $tanggal_mulai }} s/d {{ $tanggal_akhir }}</span>
            </div>
        </div>

        <!-- Sales Summary -->
        <div class="section">
            <div class="section-title">
                <i class="fas fa-chart-pie"></i> Ringkasan Penjualan
            </div>
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
                        <td class="text-primary summary-value">Rp{{ number_format($data['total_modal'], 0, ',', '.') }}</td>
                        <td><span class="badge badge-success">{{ $data['total_transaksi'] }} transaksi</span></td>
                        <td class="text-primary summary-value">Rp{{ number_format($data['pendapatan_kotor'], 0, ',', '.') }}</td>
                        <td class="text-primary summary-value">Rp{{ number_format($data['pendapatan_bersih'], 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Best Selling Products -->
        <div class="section">
            <div class="section-title">
                <i class="fas fa-star"></i> Produk Terlaris
            </div>
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
                        <td class="text-accent">Rp{{ number_format($produk->total_pendapatan, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Daily Sales -->
        <div class="section">
            <div class="section-title">
                <i class="fas fa-calendar-day"></i> Penjualan Harian
            </div>
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
                        <td class="text-accent">Rp{{ number_format($penjualan->total_penjualan, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div><i class="fas fa-print"></i> Dicetak oleh Sistem KOPLAKHUB</div>
            <div><i class="fas fa-clock"></i> {{ $tanggal_cetak }}</div>
        </div>
    </div>
</body>
</html>
