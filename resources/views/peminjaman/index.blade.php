<x-app-layout title="Data Peminjaman">
    <div class="bg-white rounded-lg shadow-lg">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-t-lg">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold flex items-center">
                    <i class="fas fa-money-bill-wave mr-3"></i>
                    Data Kasbon
                </h2>
                <div class="flex space-x-2">
                    <a href="{{ route('peminjaman.create') }}"
                        class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition font-medium">
                        <i class="fas fa-plus mr-2"></i>Tambah Kasbon
                    </a>
                    <a href="{{ route('report.peminjam') }}"
                        class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition font-medium">
                        <i class="fas fa-file-alt mr-2"></i>Laporan Kasbon
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6 overflow-auto">
            <table id="peminjamanTable" class="datatable min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor
                            Pengajuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Karyawan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Pengajuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($peminjaman as $p)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $p->nomor_pengajuan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $p->karyawan->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">Rp
                                {{ number_format($p->jumlah_pinjaman, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $p->tanggal_pengajuan->format('d-m-Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 text-xs rounded-full font-medium
                                    {{ $p->status == 'pending'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : ($p->status == 'disetujui'
                                            ? 'bg-green-100 text-green-800'
                                            : ($p->status == 'dicairkan'
                                                ? 'bg-blue-100 text-blue-800'
                                                : 'bg-red-100 text-red-800')) }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('peminjaman.show', $p) }}"
                                        class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1 rounded-lg transition">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if ($p->status == 'pending')
                                        <form action="{{ route('peminjaman.approve', $p) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" onclick="return confirm('Setujui peminjaman ini?')"
                                                class="bg-green-100 text-green-700 hover:bg-green-200 px-3 py-1 rounded-lg transition">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <button onclick="openRejectModal({{ $p->id }})"
                                            class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1 rounded-lg transition">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @elseif($p->status == 'disetujui')
                                        <form action="{{ route('peminjaman.disburse', $p) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" onclick="return confirm('Cairkan peminjaman ini?')"
                                                class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1 rounded-lg transition">
                                                <i class="fas fa-money-bill"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('peminjaman.print', $p) }}"
                                        class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-3 py-1 rounded-lg transition">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-money-bill-wave text-gray-400 text-4xl mb-4"></i>
                                    <p class="text-gray-500 text-lg">Tidak ada data peminjaman</p>
                                    <a href="{{ route('peminjaman.create') }}"
                                        class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                        Tambah Peminjaman Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Tolak Peminjaman</h3>
            <form id="rejectForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Penolakan</label>
                    <textarea name="catatan" class="w-full border border-gray-300 rounded-lg px-3 py-2" rows="4" required></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeRejectModal()"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">Batal</button>
                    <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Tolak</button>
                </div>
            </form>
        </div>
    </div>




    <script>
        $(document).ready(function() {
            @if ($peminjaman->count() > 0)
                $('#peminjamanTable').DataTable({
                    dom: 'Blfrtip', // Include buttons in the DOM layout
                    buttons: [{
                            extend: 'print',
                            text: 'Data Peminjaman - Print',
                            className: 'bg-blue-500 hover:bg-blue-600 text-white font-medium px-4 py-2 rounded-lg mr-2',
                            exportOptions: {
                                columns: ':visible' // Export only visible columns
                            },
                            title: 'Data Peminjaman'
                        },
                        {
                            extend: 'excel',
                            text: 'Data Peminjaman - Excel',
                            className: 'bg-green-500 hover:bg-green-600 text-white font-medium px-4 py-2 rounded-lg mr-2',
                            exportOptions: {
                                columns: ':visible' // Export only visible columns
                            },
                            title: 'Data_Peminjaman'
                        },
                        {
                            extend: 'pdf',
                            text: 'Data Peminjaman - PDF',
                            className: 'bg-red-500 hover:bg-red-600 text-white font-medium px-4 py-2 rounded-lg mr-2',
                            exportOptions: {
                                columns: ':visible' // Export only visible columns
                            },
                            title: 'Data Peminjaman'
                        }
                    ],
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
                    },
                    "pageLength": 10,
                    "responsive": true,
                    "order": [
                        [0, "desc"]
                    ]
                });
            @endif
        });
    </script>


    <script>
        function openRejectModal(id) {
            document.getElementById('rejectForm').action = `/peminjaman/${id}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('rejectForm').reset();
        }
    </script>
</x-app-layout>
