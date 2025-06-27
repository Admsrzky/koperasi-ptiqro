<x-app-layout title="Edit Penggajian">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6">
                <h2 class="text-2xl font-bold flex items-center">
                    <i class="fas fa-money-pen mr-3"></i>
                    Edit Penggajian
                </h2>
            </div>

            <form action="{{ route('penggajian.update', $penggajian) }}" method="POST" class="p-6">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-1"></i>Karyawan
                        </label>
                        <p class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100">{{ $penggajian->karyawan->nama }} ({{ $penggajian->karyawan->nip }})</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar mr-1"></i>Periode
                        </label>
                        <p class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100">{{ $penggajian->periode }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-money-bill-wave mr-1"></i>Lembur
                        </label>
                        <input type="number" name="lembur" value="{{ old('lembur', $penggajian->lembur) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600"
                               placeholder="0" min="0">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-gift mr-1"></i>Bonus
                        </label>
                        <input type="number" name="bonus" value="{{ old('bonus', $penggajian->bonus) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600"
                               placeholder="0" min="0">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-minus-circle mr-1"></i>Potongan Lain
                        </label>
                        <input type="number" name="potongan_lain" value="{{ old('potongan_lain', $penggajian->potongan_lain) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600"
                               placeholder="0" min="0">
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