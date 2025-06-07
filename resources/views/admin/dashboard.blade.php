@extends('layouts.app')

@section('content')
<div class="bg-gray-50 dark:bg-gray-900">

    <!-- Main Content -->
    <div class="p-4 sm:ml-64">
        <div class="p-4 rounded-lg mt-14">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Dashboard</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-white"></i>
                        </div>
                        <input type="text" id="search" class="block p-2 pl-12 text-sm bg-gray-700 text-gray-900 border border-gray-300 rounded-lg w-60 bg-white focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari...">
                    </div>
                    <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-black bg-koplak focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center hover:bg-yellow-500 dark:focus:ring-koplak" type="button">
                        Filter
                        <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- Total Modal -->
                <div class="bg-gray-800 rounded-xl shadow-lg p-4 border border-gray-700 hover:border-koplak transition-colors duration-200">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-white flex items-center">
                            <i class="fas fa-money-bill-wave text-blue-400 mr-2"></i>Total Modal
                        </h3>
                        <div class="w-8 h-8 rounded-full bg-blue-800 flex items-center justify-center">
                            <i class="fas fa-coins text-blue-400 text-sm"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-semibold text-gray-100">Rp {{ number_format($total_modal, 0, ',', '.') }}</p>
                    <div class="mt-1 text-xs text-gray-400">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        {{ Carbon\Carbon::parse($tanggal_mulai)->format('d M Y') }} - {{ Carbon\Carbon::parse($tanggal_akhir)->format('d M Y') }}
                    </div>
                </div>

                <!-- Total Transaksi -->
                <div class="bg-gray-800 rounded-xl shadow-lg p-4 border border-gray-700 hover:border-koplak transition-colors duration-200">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-white flex items-center">
                            <i class="fas fa-shopping-cart text-green-400 mr-2"></i>Total Transaksi
                        </h3>
                        <div class="w-8 h-8 rounded-full bg-green-800 flex items-center justify-center">
                            <i class="fas fa-receipt text-green-400 text-sm"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-semibold text-gray-100">{{ number_format($total_transaksi, 0, ',', '.') }}</p>
                    <div class="mt-1 text-xs text-gray-400">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        {{ Carbon\Carbon::parse($tanggal_mulai)->format('d M Y') }} - {{ Carbon\Carbon::parse($tanggal_akhir)->format('d M Y') }}
                    </div>
                </div>

                <!-- Pendapatan Kotor -->
                <div class="bg-gray-800 rounded-xl shadow-lg p-4 border border-gray-700 hover:border-koplak transition-colors duration-200">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-white flex items-center">
                            <i class="fas fa-chart-line text-purple-400 mr-2"></i>Pendapatan Kotor
                        </h3>
                        <div class="w-8 h-8 rounded-full bg-purple-800 flex items-center justify-center">
                            <i class="fas fa-money-bill-trend-up text-purple-400 text-sm"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-semibold text-gray-100">Rp {{ number_format($pendapatan_kotor, 0, ',', '.') }}</p>
                    <div class="mt-1 text-xs text-gray-400">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        {{ Carbon\Carbon::parse($tanggal_mulai)->format('d M Y') }} - {{ Carbon\Carbon::parse($tanggal_akhir)->format('d M Y') }}
                    </div>
                </div>

                <!-- Pendapatan Bersih -->
                <div class="bg-gray-800 rounded-xl shadow-lg p-4 border border-gray-700 hover:border-koplak transition-colors duration-200">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-white flex items-center">
                            <i class="fas fa-wallet {{ $pendapatan_bersih < 0 ? 'text-red-400' : 'text-green-400' }} mr-2"></i>Pendapatan Bersih
                        </h3>
                        <div class="w-8 h-8 rounded-full {{ $pendapatan_bersih < 0 ? 'bg-red-800' : 'bg-green-800' }} flex items-center justify-center">
                            <i class="fas fa-piggy-bank {{ $pendapatan_bersih < 0 ? 'text-red-400' : 'text-green-400' }} text-sm"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-semibold {{ $pendapatan_bersih < 0 ? 'text-red-400' : 'text-green-400' }}">
                        Rp {{ number_format($pendapatan_bersih, 0, ',', '.') }}
                    </p>
                    <div class="mt-1 text-xs text-gray-400">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        {{ Carbon\Carbon::parse($tanggal_mulai)->format('d M Y') }} - {{ Carbon\Carbon::parse($tanggal_akhir)->format('d M Y') }}
                    </div>
                </div>
            </div>

            {{-- prediksi --}}
            <div class="card bg-gray-800 border-0 shadow-lg mb-6">
                <div class="card-header bg-gray-700 border-gray-600 py-3 px-4 flex items-center justify-between">
                    <h6 class="m-0 font-bold text-xl text-koplak font-montserrat">
                        <i class="fas fa-coins mr-2"></i> Pendapatan Bersih
                    </h6>
                    <div class="dropdown relative">
                        <button class="text-gray-300 hover:text-koplak focus:outline-none">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-gray-700 rounded-md shadow-lg z-10 border border-gray-600">
                            <div class="py-1">
                                <div class="px-4 py-2 text-sm text-gray-300 border-b border-gray-600">Opsi:</div>
                                <a href="{{route('admin.keuangan.index')}}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-600 hover:text-koplak transition">
                                    <i class="fas fa-file-alt mr-2"></i> Detail Laporan
                                </a>
                                <a href="{{route('dashboard.export')}}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-600 hover:text-koplak transition">
                                    <i class="fas fa-file-excel mr-2"></i> Ekspor ke Pdf
                                </a>
                                <div class="border-t border-gray-600"></div>
                                <a href="{{route('dashboard')}}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-600 hover:text-koplak transition">
                                    <i class="fas fa-sync-alt mr-2"></i> Refresh Data
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="flex flex-col md:flex-row">
                        <!-- Chart Section -->
                        <div class="w-full md:w-2/3 p-2">
                            <div class="chart-container relative h-64 md:h-80">
                                <canvas id="revenueChart" class="rounded-lg"></canvas>
                            </div>
                        </div>

                        <!-- Prediction Section -->
                        <div class="w-full md:w-1/3 p-2">
                            <div class="bg-gray-700 rounded-lg p-4 h-full flex flex-col justify-between">
                                <!-- Current Month -->
                                <div class="mb-6 p-3 bg-gray-600 rounded-lg shadow-inner">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-check text-koplak mr-2"></i>
                                            <span class="text-gray-300 font-medium">Bulan Ini</span>
                                        </div>
                                        <span class="text-white font-bold text-lg">
                                            Rp{{ number_format($currentMonthRevenue, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Prediction -->
                                <div class="mb-6 p-3 bg-gray-600 rounded-lg shadow-inner">
                                    <div class="flex flex-col">
                                        <div class="flex items-center justify-between mb-1">
                                            <div class="flex items-center">
                                                <i class="fas fa-chart-line text-koplak mr-2"></i>
                                                <span class="text-gray-300 font-medium">Prediksi Bulan Depan</span>
                                            </div>
                                            <span class="text-white font-bold text-lg">
                                                Rp{{ number_format($prediction['value'], 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="flex items-center justify-end mt-1">
                                            <span class="text-xs font-medium px-2 py-1 rounded-full
                                                {{ $prediction['change'] >= 0 ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                                @if($prediction['change'] >= 0)
                                                    <i class="fas fa-arrow-up mr-1"></i>
                                                @else
                                                    <i class="fas fa-arrow-down mr-1"></i>
                                                @endif
                                                {{ abs(round($prediction['change'])) }}%
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Accuracy -->
                                <div class="mb-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-gray-300 font-medium">
                                            <i class="fas fa-bullseye text-koplak mr-2"></i> Akurasi Prediksi
                                        </span>
                                        <span class="text-koplak font-bold">{{ $prediction['accuracy'] }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-600 rounded-full h-2.5">
                                        <div class="bg-gradient-to-r from-blue-400 to-koplak h-2.5 rounded-full"
                                             style="width: {{ $prediction['accuracy'] }}%"></div>
                                    </div>
                                </div>

                                <!-- Last Updated -->
                                <div class="text-center pt-2 border-t border-gray-600">
                                    <small class="text-gray-400 text-xs">
                                        <i class="far fa-clock mr-1"></i> Diperbarui: {{ now()->format('d M Y, H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;">
    @csrf
</form>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const historicalData = @json($historicalData);

        if (historicalData.length > 0) {
            const categories = historicalData.map(item => {
                const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                                   "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                return monthNames[item.month - 1] + ' ' + item.year;
            });

            const seriesData = historicalData.map(item => item.net_revenue);

            const options = {
                series: [{
                    name: 'Pendapatan Bersih',
                    data: seriesData
                }],
                chart: {
                    height: 300,
                    type: 'line',
                    toolbar: { show: false }
                },
                colors: ['#3b82f6'],
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3 },
                xaxis: {
                    categories: categories
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return 'Rp' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            };

            const chart = new ApexCharts(document.querySelector("#revenue-chart"), options);
            chart.render();
        }
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Set default active tab
    const defaultTab = document.getElementById('dashboard-tab');
    const defaultTabContent = document.getElementById('dashboard');

    if (defaultTab && defaultTabContent) {
        defaultTab.classList.add('text-blue-600', 'border-blue-600', 'dark:text-blue-500', 'dark:border-blue-500');
        defaultTab.setAttribute('aria-selected', 'true');
        defaultTabContent.classList.remove('hidden');
    }
});
</script>

{{-- prediksi --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('revenueChart').getContext('2d');
        var revenueData = @json($historicalData);

        var labels = revenueData.map(function(item) {
            var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            return monthNames[item.month - 1] + ' ' + item.year;
        });

        var revenues = revenueData.map(function(item) {
            return item.net_revenue;
        });

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan Bersih',
                    data: revenues,
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    pointRadius: 3,
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointBorderColor: 'rgba(78, 115, 223, 1)',
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    fill: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: false,
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false
                        }
                    }]
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': Rp ' + new Intl.NumberFormat('id-ID').format(tooltipItem.yLabel);
                        }
                    }
                }
            }
        });
    });
    </script>

<script>
    document.getElementById('logout-button').addEventListener('click', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Konfirmasi Logout',
            text: "Apakah anda yakin ingin logout?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: 'bg-green-500',
            cancelButtonColor: 'bg-red-500',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    });
</script>
<script>
    // Dropdown functionality
    document.querySelector('.dropdown button').addEventListener('click', function(e) {
        e.preventDefault();
        const menu = this.nextElementSibling;
        menu.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                menu.classList.add('hidden');
            });
        }
    });

</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .chart-container {
        animation: fadeIn 0.6s ease-out forwards;
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }

        .chart-container {
            height: 250px;
            margin-bottom: 1rem;
        }
    }
</style>
@endsection
