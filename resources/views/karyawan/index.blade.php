<x-app-layout title="Data Karyawan">
    <div class="bg-white rounded-lg shadow-lg">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-t-lg">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold flex items-center">
                    <i class="fas fa-users mr-3"></i>
                    Data Karyawan
                </h2>
                <a href="{{ route('karyawan.create') }}"
                    class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition font-medium">
                    <i class="fas fa-plus mr-2"></i>Tambah Karyawan
                </a>
            </div>
        </div>

        <div class="p-6 overflow-auto">
            <table id="karyawanTable" class="datatable min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jabatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Departemen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gaji
                            Pokok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($karyawan as $k)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $k->nip }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <div
                                            class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <i class="fas fa-user text-blue-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $k->nama }}</div>
                                        <div class="text-sm text-gray-500">{{ $k->telepon }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $k->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $k->jabatan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $k->departemen }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">Rp
                                {{ number_format($k->gaji_pokok, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 text-xs rounded-full font-medium {{ $k->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($k->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('karyawan.show', $k) }}"
                                        class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1 rounded-lg transition">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('karyawan.edit', $k) }}"
                                        class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-1 rounded-lg transition">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('karyawan.destroy', $k) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirmDelete(this.form)"
                                            class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1 rounded-lg transition">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
                                    <p class="text-gray-500 text-lg">Tidak ada data karyawan</p>
                                    <a href="{{ route('karyawan.create') }}"
                                        class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                        Tambah Karyawan Pertama
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
            @if ($karyawan->count() > 0)
                $('#karyawanTable').DataTable({
                    dom: 'Blfrtip', // Include buttons in the DOM layout
                    buttons: [{
                            extend: 'print',
                            text: 'Data Karyawan - Print',
                            className: 'bg-blue-500 hover:bg-blue-600 text-white font-medium px-4 py-2 rounded-lg mr-2',
                            exportOptions: {
                                columns: ':visible' // Export only visible columns
                            },
                            title: 'Data Karyawan'
                        },
                        {
                            extend: 'excel',
                            text: 'Data Karyawan - Excel',
                            className: 'bg-green-500 hover:bg-green-600 text-white font-medium px-4 py-2 rounded-lg mr-2',
                            exportOptions: {
                                columns: ':visible' // Export only visible columns
                            },
                            title: 'Data_Karyawan'
                        },
                        {
                            extend: 'pdf',
                            text: 'Data Karyawan - PDF',
                            className: 'bg-red-500 hover:bg-red-600 text-white font-medium px-4 py-2 rounded-lg mr-2',
                            exportOptions: {
                                columns: ':visible' // Export only visible columns
                            },
                            title: 'Data Karyawan'
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


</x-app-layout>
