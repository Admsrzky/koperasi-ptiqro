<x-app-layout title="Laporan Peminjam">
    <!-- Form pencarian -->
    <form method="GET" action="{{ route('report.peminjam') }}" class="mb-4 flex justify-end">
        <div class="relative w-64"> <!-- Width diubah menjadi 64 (16rem) -->
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                placeholder="Cari nama, NIP, atau jumlah...">
            @if (request('search'))
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <a href="{{ route('report.peminjam') }}" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            @endif
        </div>
    </form>

    <div class="bg-white rounded-lg shadow-lg">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-t-lg">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold flex items-center">
                    <i class="fas fa-file-alt mr-3"></i>
                    Laporan Kasbon
                </h2>
                <a href="{{ route('peminjaman.index') }}"
                    class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        <div class="p-6">
            <div class="overflow-auto">
                <table id="reportTable" class="datatable min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                NIP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Kasbon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah Kasbon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Kasbon</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($peminjam as $p)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $p->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $p->nip }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                                    Rp {{ number_format($p->pinjaman_aktif, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $p->peminjaman->count() }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($p->peminjaman->first()?->tanggal_pengajuan)->translatedFormat('d F Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-file-alt text-gray-400 text-4xl mb-4"></i>
                                        <p class="text-gray-500 text-lg">Tidak ada data peminjam</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchInput');
                const table = document.getElementById('reportTable');
                const rows = table.getElementsByTagName('tr');

                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();

                    for (let i = 1; i < rows.length; i++) { // Mulai dari 1 untuk melewati header
                        const cells = rows[i].getElementsByTagName('td');
                        let found = false;

                        for (let j = 0; j < cells.length; j++) {
                            const cellText = cells[j].textContent.toLowerCase();
                            if (cellText.includes(searchTerm)) {
                                found = true;
                                break;
                            }
                        }

                        if (found) {
                            rows[i].style.display = '';
                        } else {
                            rows[i].style.display = 'none';
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
