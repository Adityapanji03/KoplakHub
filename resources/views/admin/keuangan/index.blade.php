@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 mt-14 sm:ml-64 font-montserrat">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-black flex items-center">
                <i class="fas fa-wallet text-koplak mr-3"></i>
                Manajemen Keuangan
            </h1>
            <p class="text-black mt-2">Analisis dan kelola keuangan toko Anda</p>
        </div>
    </div>

    <!-- Success Notification -->
    @if(session('success'))
        <div id="success-popup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-70 z-50 animate-fade-in">
            <div class="bg-gray-800 rounded-xl shadow-2xl p-6 max-w-sm w-full border border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 text-xl mr-2"></i>
                        <h3 class="text-lg font-semibold text-gray-100">Berhasil!</h3>
                    </div>
                    <button onclick="closePopup()" class="text-gray-400 hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <p class="text-white mb-4">{{ session('success') }}</p>
                <div class="flex justify-end">
                    <button onclick="closePopup()" class="px-4 py-2 bg-koplak text-gray-900 font-medium rounded-lg hover:bg-koplak-dark transition-colors duration-200">
                        OK
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="bg-gray-800 rounded-xl shadow-lg p-4 mb-6 border-b-8 border-r-4 border-koplak ">
        <form action="{{ route('admin.keuangan.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="tanggal_mulai" class="block mb-2 text-sm font-medium text-white flex items-center">
                    <i class="fas fa-calendar-day text-koplak mr-2"></i>Tanggal Mulai
                </label>
                <div class="relative">
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ $tanggal_mulai }}"
                           class="bg-koplak border border-gray-600  font-bold text-black text-sm rounded-lg focus:ring-koplak focus:border-koplak block w-full p-2.5">
                </div>
            </div>
            <div>
                <label for="tanggal_akhir" class="block mb-2 text-sm font-medium text-white flex items-center">
                    <i class="fas fa-calendar-day text-koplak mr-2"></i>Tanggal Akhir
                </label>
                <div class="relative">
                    <input type="date" id="tanggal_akhir" name="tanggal_akhir" value="{{ $tanggal_akhir }}"
                           class="bg-koplak border border-gray-600 text-black font-bold text-sm rounded-lg focus:ring-koplak focus:border-koplak block w-full p-2.5">
                </div>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full sm:w-auto px-4 py-2.5 bg-koplak text-gray-900 font-medium rounded-lg hover:bg-koplak-dark focus:ring-4 focus:ring-koplak-darker transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
        </form>
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

    <!-- Charts and Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Sales Chart -->
        <div class="bg-gray-800 rounded-xl shadow-lg p-4 border border-gray-700">
            <h2 class="text-lg font-semibold text-gray-100 mb-4 flex items-center">
                <i class="fas fa-chart-bar text-koplak mr-2"></i>Grafik Penjualan
            </h2>
            <div id="sales-chart" style="height: 300px;"></div>
        </div>

        <!-- Best Selling Products Chart -->
        <div class="bg-gray-800 rounded-xl shadow-lg p-4 border border-gray-700">
            <h2 class="text-lg font-semibold text-gray-100 mb-4 flex items-center">
                <i class="fas fa-star text-koplak mr-2"></i>5 Produk Terlaris
            </h2>
            <div id="best-products-chart" style="height: 300px;"></div>
        </div>

        <!-- Product Analysis -->
        <div class="lg:col-span-2 bg-gray-800 rounded-xl shadow-lg p-4 border border-gray-700">
            <h2 class="text-lg font-semibold text-gray-100 mb-4 flex items-center">
                <i class="fas fa-trophy text-koplak mr-2"></i>Produk Terlaris
            </h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-400">
                    <thead class="text-xs uppercase bg-gray-700 text-white">
                        <tr>
                            <th class="px-4 py-3">Nama Produk</th>
                            <th class="px-4 py-3 text-right">Terjual</th>
                            <th class="px-4 py-3 text-right">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produk_terlaris as $produk)
                            <tr class="border-b border-gray-700 hover:bg-gray-700/50">
                                <td class="px-4 py-3 font-medium text-white">{{ $produk->nama_produk }}</td>
                                <td class="text-white px-4 py-3 text-right">{{ $produk->total_terjual }}</td>
                                <td class="text-white px-4 py-3 text-right">Rp {{ number_format($produk->total_pendapatan, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-center text-gray-400">
                                    <i class="fas fa-box-open mr-2"></i>Tidak ada data produk terjual
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Management -->
        <div class="lg:col-span-2 bg-gray-800 rounded-xl shadow-lg p-4 border border-gray-700">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-100 flex items-center">
                    <i class="fas fa-money-bill-transfer text-koplak mr-2"></i>Manajemen Modal
                </h2>
                <button type="button" id="btn-add-modal" class="px-4 py-2 bg-koplak text-gray-900 font-medium rounded-lg hover:bg-koplak-dark focus:ring-4 focus:ring-koplak-darker transition-colors duration-200 flex items-center">
                    <i class="fas fa-plus mr-2"></i>Tambah Modal
                </button>
            </div>

            <!-- Modal Form -->
            <div id="modal-form" class="hidden bg-gray-700/50 p-4 rounded-lg mb-4 border border-gray-600">
                <form action="{{ route('admin.keuangan.store-modal') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="tanggal" class="block mb-2 text-sm font-medium text-white flex items-center">
                                <i class="fas fa-calendar text-koplak mr-2"></i>Tanggal
                            </label>
                            <input type="date" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" required
                                   class="bg-gray-700 border border-gray-600 text-gray-100 text-sm rounded-lg focus:ring-koplak focus:border-koplak block w-full p-2.5">
                        </div>
                        <div>
                            <label for="jumlah" class="block mb-2 text-sm font-medium text-white flex items-center">
                                <i class="fas fa-coins text-koplak mr-2"></i>Jumlah Modal (Rp)
                            </label>
                            <input type="number" id="jumlah" name="jumlah" min="0" step="1000" required
                                   class="bg-gray-700 border border-gray-600 text-gray-100 text-sm rounded-lg focus:ring-koplak focus:border-koplak block w-full p-2.5">
                        </div>
                        <div>
                            <label for="keterangan" class="block mb-2 text-sm font-medium text-white flex items-center">
                                <i class="fas fa-info-circle text-koplak mr-2"></i>Keterangan
                            </label>
                            <textarea id="keterangan" name="keterangan"
                                      class="bg-gray-700 border border-gray-600 text-gray-100 text-sm rounded-lg focus:ring-koplak focus:border-koplak block w-full p-2.5"
                                      rows="2"></textarea>
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" id="btn-cancel-modal" class="px-4 py-2 bg-gray-600 text-gray-100 font-medium rounded-lg hover:bg-gray-500 focus:ring-4 focus:ring-gray-500 transition-colors duration-200">
                                <i class="fas fa-times mr-2"></i>Batal
                            </button>
                            <button type="submit" class="px-4 py-2 bg-koplak text-gray-900 font-medium rounded-lg hover:bg-koplak-dark focus:ring-4 focus:ring-koplak-darker transition-colors duration-200">
                                <i class="fas fa-save mr-2"></i>Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal List -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-400">
                    <thead class="text-xs uppercase bg-gray-700 text-white">
                        <tr>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3 text-right">Jumlah</th>
                            <th class="px-4 py-3">Keterangan</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($modal as $m)
                            <tr class="border-b border-gray-700 hover:bg-gray-700/50">
                                <td class="px-4 py-3">{{ Carbon\Carbon::parse($m->tanggal)->format('d M Y') }}</td>
                                <td class="px-4 py-3 text-right font-medium text-white">Rp {{ number_format($m->jumlah, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">{{ $m->keterangan ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center space-x-2">
                                        <button type="button" class="btn-edit-modal text-blue-400 hover:text-blue-300"
                                                data-id="{{ $m->id }}"
                                                data-tanggal="{{ $m->tanggal }}"
                                                data-jumlah="{{ $m->jumlah }}"
                                                data-keterangan="{{ $m->keterangan }}"
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.keuangan.destroy-modal', $m->id) }}" method="POST" class="inline" id="delete-form-{{ $m->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete({{ $m->id }})" class="text-red-400 hover:text-red-300" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-center text-gray-400">
                                    <i class="fas fa-money-bill-wave mr-2"></i>Tidak ada data modal
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal Dialog -->
<div id="edit-modal-dialog" class="fixed inset-0 bg-black bg-opacity-70 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-gray-800 rounded-xl shadow-2xl p-6 w-full max-w-md border border-gray-700">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-100 flex items-center">
                <i class="fas fa-edit text-koplak mr-2"></i>Edit Data Modal
            </h3>
            <button id="btn-close-edit-modal" class="text-gray-400 hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="edit-modal-form" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="edit-tanggal" class="block mb-2 text-sm font-medium text-white flex items-center">
                        <i class="fas fa-calendar text-koplak mr-2"></i>Tanggal
                    </label>
                    <input type="date" id="edit-tanggal" name="tanggal" required
                           class="bg-gray-700 border border-gray-600 text-gray-100 text-sm rounded-lg focus:ring-koplak focus:border-koplak block w-full p-2.5">
                </div>
                <div>
                    <label for="edit-jumlah" class="block mb-2 text-sm font-medium text-white flex items-center">
                        <i class="fas fa-coins text-koplak mr-2"></i>Jumlah Modal (Rp)
                    </label>
                    <input type="number" id="edit-jumlah" name="jumlah" min="0" step="1000" required
                           class="bg-gray-700 border border-gray-600 text-gray-100 text-sm rounded-lg focus:ring-koplak focus:border-koplak block w-full p-2.5">
                </div>
                <div>
                    <label for="edit-keterangan" class="block mb-2 text-sm font-medium text-white flex items-center">
                        <i class="fas fa-info-circle text-koplak mr-2"></i>Keterangan
                    </label>
                    <textarea id="edit-keterangan" name="keterangan"
                              class="bg-gray-700 border border-gray-600 text-gray-100 text-sm rounded-lg focus:ring-koplak focus:border-koplak block w-full p-2.5"
                              rows="2"></textarea>
                </div>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" id="btn-close-edit-modal" class="px-4 py-2 bg-gray-600 text-gray-100 font-medium rounded-lg hover:bg-gray-500 focus:ring-4 focus:ring-gray-500 transition-colors duration-200">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-koplak text-gray-900 font-medium rounded-lg hover:bg-koplak-dark focus:ring-4 focus:ring-koplak-darker transition-colors duration-200">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@section('modal-scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    function closePopup() {
        document.getElementById('success-popup').style.display = 'none';
    }

    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            background: '#1f2937',
            color: '#f3f4f6'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    // Auto-close success popup after 5 seconds
    @if(session('success'))
        setTimeout(closePopup, 5000);
    @endif

    // Modal Form Toggle
    document.addEventListener('DOMContentLoaded', function() {
        // Tambah Modal
        const btnAddModal = document.getElementById('btn-add-modal');
        const modalForm = document.getElementById('modal-form');
        const btnCancelModal = document.getElementById('btn-cancel-modal');

        if(btnAddModal && modalForm) {
            btnAddModal.addEventListener('click', function() {
                modalForm.classList.toggle('hidden');
            });

            btnCancelModal.addEventListener('click', function() {
                modalForm.classList.add('hidden');
            });
        }

        // Edit Modal
        const editButtons = document.querySelectorAll('.btn-edit-modal');
        const editModalDialog = document.getElementById('edit-modal-dialog');
        const editModalForm = document.getElementById('edit-modal-form');
        const btnCloseEditModal = document.getElementById('btn-close-edit-modal');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const tanggal = this.dataset.tanggal;
                const jumlah = this.dataset.jumlah;
                const keterangan = this.dataset.keterangan || '';

                document.getElementById('edit-tanggal').value = tanggal;
                document.getElementById('edit-jumlah').value = jumlah;
                document.getElementById('edit-keterangan').value = keterangan;

                editModalForm.action = `/admin/keuangan/modal/${id}`;
                editModalDialog.classList.remove('hidden');
            });
        });

        if(btnCloseEditModal) {
            btnCloseEditModal.addEventListener('click', function() {
                editModalDialog.classList.add('hidden');
            });
        }

        // Sales Chart
        const salesData = @json($data_penjualan_harian);
        const salesChartEl = document.getElementById('sales-chart');

        if (salesData.length > 0 && salesChartEl) {
            const salesChartOptions = {
                series: [{
                    name: 'Penjualan',
                    data: salesData.map(item => item.total_penjualan)
                }],
                chart: {
                    height: 300,
                    type: 'area',
                    toolbar: { show: false },
                    background: 'transparent',
                    foreColor: '#9CA3AF'
                },
                dataLabels: { enabled: false },
                stroke: {
                    curve: 'smooth',
                    colors: ['#FFEB3B'],
                    width: 2
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.3,
                        stops: [0, 100]
                    },
                    colors: ['#FFEB3B']
                },
                xaxis: {
                    type: 'category',
                    categories: salesData.map(item => {
                        const date = new Date(item.tanggal);
                        return date.toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'short'
                        });
                    }),
                    labels: {
                        style: {
                            colors: '#FFFFFF'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#FFFFFF'
                        },
                        formatter: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    },
                    theme: 'dark'
                },
                colors: ['#FFEB3B'],
                grid: {
                    borderColor: '#374151'
                }
            };

            const salesChart = new ApexCharts(salesChartEl, salesChartOptions);
            salesChart.render();
        } else if (salesChartEl) {
            salesChartEl.innerHTML = '<div class="flex items-center justify-center h-full text-gray-400"><i class="fas fa-chart-line mr-2"></i>Tidak ada data penjualan untuk periode ini</div>';
        }

        // Best Selling Products Chart
        const bestProductsData = @json($produk_terlaris);
        const bestProductsChartEl = document.getElementById('best-products-chart');

        if (bestProductsData && bestProductsData.length > 0 && bestProductsChartEl) {
            const bestProductsChartOptions = {
                series: [{
                    name: 'Jumlah Terjual',
                    data: bestProductsData.map(item => item.total_terjual)
                },
                {
                    name: 'Total Pendapatan',
                    data: bestProductsData.map(item => item.total_pendapatan)
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: { show: false },
                    stacked: false
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: false,
                        columnWidth: '55%',
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 1,
                    colors: ['#fff']
                },
                xaxis: {
                    categories: bestProductsData.map(item => item.nama_produk),
                    labels: {
                        style: {
                            fontSize: '12px',
                            fontWeight: 600,
                            colors: '#FFFFFF'
                        },
                        formatter: function(value) {
                            return value.length > 10 ? value.substring(0, 10) + '...' : value;
                        }
                    }
                },
                yaxis: [{
                    title: {
                        text: 'Jumlah Terjual',
                        style: {
                            color: '#FFFFFF'
                        }
                    },
                    labels: {
                        style: {
                            colors: '#FFFFFF'
                        }
                    }
                }, {
                    opposite: true,
                    title: {
                        text: 'Pendapatan (Rp)',
                        style: {
                            color: '#FFFFFF'
                        }
                    },
                    labels: {
                        formatter: function(value) {
                            return 'Rp' + new Intl.NumberFormat('id-ID').format(value / 1000) + 'k';
                        },
                        style: {
                            colors: '#FFFFFF'
                        }
                    }
                }],
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function(value, { seriesIndex }) {
                            return seriesIndex === 0
                                ? value + ' unit'
                                : 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                },
                colors: ['#10b981', '#3b82f6'],
                legend: {
                    position: 'top',
                    labels: {
                    colors: '#FFFFFF'
                }
                }
            };

            const bestProductsChart = new ApexCharts(bestProductsChartEl, bestProductsChartOptions);
            bestProductsChart.render();
        } else if (bestProductsChartEl) {
            bestProductsChartEl.innerHTML = '<div class="flex items-center justify-center h-full text-gray-500">Tidak ada data produk terlaris</div>';
        }

        // Auto submit filter
        const tanggalMulai = document.getElementById('tanggal_mulai');
        const tanggalAkhir = document.getElementById('tanggal_akhir');

        if(tanggalMulai) {
            tanggalMulai.addEventListener('change', function() {
                this.form.submit();
            });
        }

        if(tanggalAkhir) {
            tanggalAkhir.addEventListener('change', function() {
                this.form.submit();
            });
        }
    });
</script>
@endsection



