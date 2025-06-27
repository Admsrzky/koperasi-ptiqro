<x-app-layout title="Dashboard Detail">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Karyawan</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalAnggota }}</p>
                    <p class="text-sm {{ $anggotaChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $anggotaChange >= 0 ? '+' : '' }}{{ $anggotaChange }}% dari bulan lalu
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Gaji Karyawan</p>
                    <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($totalGajiKaryawan, 2, ',', '.') }}</p>
                    <p class="text-sm text-green-600">+0% dari bulan lalu</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-piggy-bank text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Pinjaman</p>
                    <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($totalPinjaman, 2, ',', '.') }}</p>
                    <p class="text-sm {{ $pinjamanChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $pinjamanChange >= 0 ? '+' : '' }}{{ $pinjamanChange }}% dari bulan lalu
                    </p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-hand-holding-usd text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Keuntungan</p>
                    <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($totalKeuntungan, 2, ',', '.') }}</p>
                    <p class="text-sm {{ $keuntunganChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $keuntunganChange >= 0 ? '+' : '' }}{{ $keuntunganChange }}% dari bulan lalu
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Peminjaman Chart -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Grafik Peminjaman</h3>
                <select id="peminjamanPeriod" class="text-sm border border-gray-300 rounded-md px-3 py-1">
                    <option value="6months">6 Bulan Terakhir</option>
                    <option value="1year">1 Tahun Terakhir</option>
                </select>
            </div>
            <div class="chart-container">
                <canvas id="peminjamanChart"></canvas>
            </div>
        </div>

        <!-- Penambahan Karyawan Chart -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Grafik Penambahan Karyawan</h3>
                <select id="karyawanPeriod" class="text-sm border border-gray-300 rounded-md px-3 py-1">
                    <option value="6months">6 Bulan Terakhir</option>
                    <option value="1year">1 Tahun Terakhir</option>
                </select>
            </div>
            <div class="chart-container">
                <canvas id="karyawanChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activities & Top Members -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activities -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Terbaru</h3>
            <div class="space-y-4">
                @foreach ($recentActivities as $activity)
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-{{ $activity['type'] == 'peminjaman' ? ($activity['status'] == 'disetujui' ? 'green' : ($activity['status'] == 'dicairkan' ? 'blue' : 'yellow')) : 'purple' }}-100 rounded-full flex items-center justify-center">
                            <i class="fas {{ $activity['type'] == 'peminjaman' ? ($activity['status'] == 'disetujui' ? 'fa-handshake' : ($activity['status'] == 'dicairkan' ? 'fa-money-bill' : 'fa-plus')) : 'fa-file-alt' }} text-{{ $activity['type'] == 'peminjaman' ? ($activity['status'] == 'disetujui' ? 'green' : ($activity['status'] == 'dicairkan' ? 'blue' : 'yellow')) : 'purple' }}-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">
                                @if ($activity['type'] == 'peminjaman')
                                    {{ $activity['status'] == 'disetujui' ? 'Pinjaman disetujui' : ($activity['status'] == 'dicairkan' ? 'Pembayaran pinjaman' : 'Pengajuan pinjaman') }}
                                @else
                                    Penggajian dibuat
                                @endif
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $activity['karyawan_nama'] }} - 
                                @if ($activity['type'] == 'peminjaman' && $activity['status'] == 'pengajuan')
                                    {{ \Carbon\Carbon::parse($activity['created_at'])->diffForHumans() }}
                                @else
                                    Rp {{ number_format($activity['jumlah'], 2, ',', '.') }}
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 pt-4 border-t border-gray-200">
                <a href="{{ route('peminjaman.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Lihat semua aktivitas →</a>
            </div>
        </div>

        <!-- Top Members -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Anggota Terbaik</h3>
            <div class="space-y-4">
                @foreach ($topMembers as $index => $member)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 {{ $index == 0 ? 'bg-gradient-to-r from-yellow-400 to-orange-500' : ($index == 1 ? 'bg-gradient-to-r from-gray-400 to-gray-600' : ($index == 2 ? 'bg-gradient-to-r from-orange-400 to-red-500' : 'bg-gray-300')) }} rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-sm">{{ $index + 1 }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $member->nama }}</p>
                                <p class="text-xs text-gray-500">Simpanan: Rp {{ number_format($member->total_gaji, 2, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold {{ $member->status == 'aktif' ? 'text-green-600' : 'text-yellow-600' }}">{{ ucfirst($member->status) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 pt-4 border-t border-gray-200">
                <a href="{{ route('karyawan.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Lihat semua anggota →</a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-6 bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('karyawan.create') }}"
                class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <i class="fas fa-user-plus text-blue-600 text-2xl mb-2"></i>
                <span class="text-sm font-medium text-gray-700">Tambah Anggota</span>
            </a>

            <a href="{{ route('peminjaman.create') }}"
                class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <i class="fas fa-coins text-green-600 text-2xl mb-2"></i>
                <span class="text-sm font-medium text-gray-700">Input Pinjaman</span>
            </a>

            <a href="{{ route('report.peminjam') }}"
                class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <i class="fas fa-file-invoice text-yellow-600 text-2xl mb-2"></i>
                <span class="text-sm font-medium text-gray-700">Lihat Laporan Peminjaman</span>
            </a>

            <a href="{{ route('profile.edit') }}"
                class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <i class="fas fa-cog text-purple-600 text-2xl mb-2"></i>
                <span class="text-sm font-medium text-gray-700">Pengaturan</span>
            </a>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Peminjaman Chart
        const peminjamanChart = new Chart(document.getElementById('peminjamanChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Total Peminjaman (Rp)',
                    data: [],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

        // Penambahan Karyawan Chart
        const karyawanChart = new Chart(document.getElementById('karyawanChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Jumlah Karyawan Baru',
                    data: [],
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });

        // Fetch Peminjaman Data
        function fetchPeminjamanData() {
            const period = document.getElementById('peminjamanPeriod').value;
            fetch(`{{ route('dashboard.revenue-data') }}?period=${period}`)
                .then(response => response.json())
                .then(data => {
                    peminjamanChart.data.labels = data.labels;
                    peminjamanChart.data.datasets[0].data = data.data;
                    peminjamanChart.update();
                });
        }

        // Fetch Penambahan Karyawan Data
        function fetchKaryawanData() {
            const period = document.getElementById('karyawanPeriod').value;
            fetch(`{{ route('dashboard.member-growth-data') }}?period=${period}`)
                .then(response => response.json())
                .then(data => {
                    karyawanChart.data.labels = data.labels;
                    karyawanChart.data.datasets[0].data = data.data;
                    karyawanChart.update();
                });
        }

        // Initial Fetch
        fetchPeminjamanData();
        fetchKaryawanData();

        // Update on Period Change
        document.getElementById('peminjamanPeriod').addEventListener('change', fetchPeminjamanData);
        document.getElementById('karyawanPeriod').addEventListener('change', fetchKaryawanData);
    </script>
</x-app-layout>