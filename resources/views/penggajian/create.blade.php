<x-app-layout title="Tambah Penggajian">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6">
                <h2 class="text-2xl font-bold flex items-center">
                    <i class="fas fa-money-check-alt mr-3"></i>
                    Tambah Penggajian Baru
                </h2>
            </div>

            <form action="{{ route('penggajian.store') }}" method="POST" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar mr-1"></i>Periode
                        </label>
                        <input type="text" name="periode" value="{{ old('periode', $periode) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="YYYY-MM" required>
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-users mr-1"></i>Pilih Karyawan
                    </label>
                    <div class="border border-gray-300 rounded-lg p-4 max-h-64 overflow-y-auto">
                        @foreach($karyawan as $k)
                            <div class="flex items-center mb-2">
                                <input type="checkbox" name="karyawan_ids[]" value="{{ $k->id }}"
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                       {{ in_array($k->id, old('karyawan_ids', [])) ? 'checked' : '' }}>
                                <label class="ml-2 text-sm text-gray-900">{{ $k->nama }} ({{ $k->nip }})</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('penggajian.index') }}"
                       class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>