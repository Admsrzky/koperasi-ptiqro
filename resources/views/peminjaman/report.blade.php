{{-- /views/peminjaman/report.blade.php --}}
<x-app-layout title="Laporan Peminjam">
    {{-- Menambahkan style khusus untuk mode cetak --}}
    @push('styles')
        <style>
            @media print {
                body * {
                    visibility: hidden;
                }

                #print-area,
                #print-area * {
                    visibility: visible;
                }

                #print-area {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                }

                .shadow-lg {
                    box-shadow: none !important;
                }

                table {
                    width: 100%;
                }

                /* PERUBAHAN: Sembunyikan semua elemen yang tidak perlu dicetak */
                .no-print {
                    display: none !important;
                }

                /* PERUBAHAN: Sembunyikan header tabel saat mencetak */
                #reportTable thead {
                    display: none !important;
                }
            }
        </style>
    @endpush

    {{-- PERUBAHAN: Form filter diperbarui dengan dropdown bulan dan tahun --}}
    <form method="GET" action="{{ route('report.peminjam') }}"
        class="flex flex-wrap items-center justify-end gap-4 mb-4 no-print">
        {{-- Filter Bulan --}}
        <div class="relative">
            <select name="month" id="monthFilter" onchange="this.form.submit()"
                class="block w-full py-2 pl-3 pr-10 leading-5 bg-white border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="">Semua Bulan</option>
                @php
                    $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                @endphp
                @foreach ($months as $index => $month)
                    <option value="{{ $index + 1 }}" {{ request('month') == $index + 1 ? 'selected' : '' }}>
                        {{ $month }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Filter Tahun --}}
        <div class="relative">
            <select name="year" id="yearFilter" onchange="this.form.submit()"
                class="block w-full py-2 pl-3 pr-10 leading-5 bg-white border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="">Semua Tahun</option>
                @for ($year = date('Y'); $year >= date('Y') - 5; $year--)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endfor
            </select>
        </div>

        {{-- Filter Pencarian --}}
        <div class="relative w-64">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="text-gray-400 fas fa-search"></i>
            </div>
            <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                class="block w-full py-2 pl-10 pr-3 leading-5 placeholder-gray-500 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                placeholder="Cari nama atau NIP...">
        </div>

        {{-- Tombol Reset --}}
        <a href="{{ route('report.peminjam') }}"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
            Reset
        </a>
    </form>


    <div id="print-area">
        <div class="bg-white rounded-lg shadow-lg">
            {{-- PERUBAHAN: Judul laporan diberi kelas 'no-print' agar tidak ikut tercetak --}}
            <div class="p-6 text-white rounded-t-lg bg-gradient-to-r from-blue-500 to-blue-600 no-print">
                <div class="flex items-center justify-between">
                    <h2 class="flex items-center text-2xl font-bold">
                        <i class="mr-3 fas fa-file-alt"></i>
                        Laporan Kasbon
                    </h2>
                    <div class="flex items-center space-x-2">
                        <button id="printAllButton"
                            class="flex items-center px-4 py-2 font-medium text-white transition bg-green-500 rounded-lg hover:bg-green-600">
                            <i class="mr-2 fas fa-print"></i>Cetak Laporan
                        </button>
                        <a href="{{ route('peminjaman.index') }}"
                            class="flex items-center px-4 py-2 font-medium text-blue-600 transition bg-white rounded-lg hover:bg-gray-100">
                            <i class="mr-2 fas fa-arrow-left"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="overflow-auto">
                    <table id="reportTable" class="min-w-full divide-y divide-gray-200 datatable">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Nama</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    NIP</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Total Kasbon</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Jumlah Kasbon</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Tanggal Kasbon</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase no-print">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($peminjam as $p)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                        {{ $p->nama }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $p->nip }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-green-600 whitespace-nowrap">
                                        Rp {{ number_format($p->pinjaman_aktif, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        {{ $p->peminjaman->count() }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($p->peminjaman->first()?->tanggal_pengajuan)->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap no-print">
                                        <a href="{{ route('peminjaman.cetak', $p->peminjaman->first()?->id) }}"
                                            target="_blank"
                                            class="px-3 py-1 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
                                            <i class="fas fa-print"></i> Cetak
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class="mb-4 text-4xl text-gray-400 fas fa-file-alt"></i>
                                            <p class="text-lg text-gray-500">Tidak ada data untuk filter yang dipilih
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        {{-- Script pencarian sisi klien dan fungsionalitas cetak tetap sama --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchInput');
                const reportTable = document.getElementById('reportTable');
                const printAllButton = document.getElementById('printAllButton');

                if (!reportTable || !printAllButton) {
                    return;
                }

                const tableBody = reportTable.tBodies[0];
                const tableRows = tableBody.getElementsByTagName('tr');

                const applyClientFilter = () => {
                    if (!searchInput) return;
                    const searchTerm = searchInput.value.toLowerCase();

                    for (const row of tableRows) {
                        if (row.cells[0] && row.cells[0].hasAttribute('colspan')) {
                            continue;
                        }

                        let found = false;
                        for (let i = 0; i < row.cells.length - 1; i++) {
                            if (row.cells[i].textContent.toLowerCase().includes(searchTerm)) {
                                found = true;
                                break;
                            }
                        }
                        row.style.display = found ? '' : 'none';
                    }
                };

                if(searchInput) {
                    searchInput.addEventListener('keyup', applyClientFilter);
                }

                printAllButton.addEventListener('click', () => {
                    for (const row of tableRows) {
                        row.style.display = '';
                    }
                    window.print();
                });

                window.onafterprint = applyClientFilter;

                if (searchInput && searchInput.value) {
                    applyClientFilter();
                }
            });
        </script>
    @endpush
</x-app-layout>
