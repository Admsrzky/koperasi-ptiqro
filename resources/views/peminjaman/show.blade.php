<x-app-layout title="Detail Peminjaman">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6">
                <h2 class="text-2xl font-bold flex items-center">
                    <i class="fas fa-money-bill-wave mr-3"></i>
                    Detail Kasbon
                </h2>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor Pengajuan</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $peminjaman->nomor_pengajuan }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Karyawan</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $peminjaman->karyawan->nama }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jumlah Pinjaman</label>
                        <p class="mt-1 text-lg font-semibold text-green-600">Rp {{ number_format($peminjaman->jumlah_pinjaman, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Pengajuan</label>
                        <p class="mt-1 text-lg text-gray-900">{{ $peminjaman->tanggal_pengajuan->format('d-m-Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Pencairan</label>
                        <p class="mt-1 text-lg text-gray-900">{{ $peminjaman->tanggal_cair ? $peminjaman->tanggal_cair->format('d-m-Y') : '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <span class="px-3 py-1 text-xs rounded-full font-medium
                            {{ ($peminjaman->status == 'pending' ? 'bg-yellow-100 text-yellow-800' :
                               ($peminjaman->status == 'disetujui' ? 'bg-green-100 text-green-800' :
                               ($peminjaman->status == 'dicairkan' ? 'bg-blue-100 text-blue-800' :
                               'bg-red-100 text-red-800'))) }}">
                            {{ ucfirst($peminjaman->status) }}
                        </span>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Keperluan</label>
                        <p class="mt-1 text-lg text-gray-900">{{ $peminjaman->keperluan }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Catatan</label>
                        <p class="mt-1 text-lg text-gray-900">{{ $peminjaman->catatan ?: '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">File Pengajuan</label>
                        @if($peminjaman->file_pengajuan)
                            <a href="{{ Storage::url($peminjaman->file_pengajuan) }}" target="_blank"
                               class="text-blue-600 hover:underline">Lihat File</a>
                        @else
                            <p class="mt-1 text-lg text-gray-900">-</p>
                        @endif
                    </div>
                </div>

                <div class="flex justify-end mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('peminjaman.index') }}"
                       class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>