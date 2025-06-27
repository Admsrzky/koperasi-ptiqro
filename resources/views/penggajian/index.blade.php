<x-app-layout title="Data Penggajian">
    <div class="bg-white rounded-lg shadow-lg">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-t-lg">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold flex items-center">
                    <i class="fas fa-money-check-alt mr-3"></i>
                    Data Penggajian
                </h2>
                <a href="{{ route('penggajian.create') }}" class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition font-medium">
                    <i class="fas fa-plus mr-2"></i>Tambah Penggajian
                </a>
            </div>
        </div>

        <div class="p-6 overflow-auto">
            <table id="penggajianTable" class="datatable min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Karyawan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Gaji</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($penggajian as $p)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $p->periode }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $p->karyawan->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">Rp {{ number_format($p->total_gaji, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs rounded-full font-medium {{ $p->status == 'lunas' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('penggajian.edit', $p) }}"
                                       class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-1 rounded-lg transition">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('penggajian.slip', $p) }}"
                                       class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1 rounded-lg transition">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-money-check-alt text-gray-400 text-4xl mb-4"></i>
                                    <p class="text-gray-500 text-lg">Tidak ada data penggajian</p>
                                    <a href="{{ route('penggajian.create') }}" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                        Tambah Penggajian Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>



    
   <script>
    $(document).ready(function() {
        @if ($penggajian->count() > 0)
            $('#penggajianTable').DataTable({
                dom: 'Blfrtip', // Include buttons in the DOM layout
                buttons: [
                    {
                        extend: 'print',
                        text: 'Data Penggajian - Print',
                        className: 'bg-blue-500 hover:bg-blue-600 text-white font-medium px-4 py-2 rounded-lg mr-2',
                        exportOptions: {
                            columns: ':visible' // Export only visible columns
                        },
                        title: 'Data Penggajian'
                    },
                    {
                        extend: 'excel',
                        text: 'Data Penggajian - Excel',
                        className: 'bg-green-500 hover:bg-green-600 text-white font-medium px-4 py-2 rounded-lg mr-2',
                        exportOptions: {
                            columns: ':visible' // Export only visible columns
                        },
                        title: 'Data_Penggajian'
                    },
                    {
                        extend: 'pdf',
                        text: 'Data Penggajian - PDF',
                        className: 'bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg',
                        exportOptions: {
                            columns: ':visible' // Export only visible columns
                        },
                        title: 'Data Penggajian'
                    }
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
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


</x-app-layout>