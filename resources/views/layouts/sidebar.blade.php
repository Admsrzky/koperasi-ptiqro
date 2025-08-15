<div id="sidebar"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg sidebar-transition transform -translate-x-full lg:translate-x-0">
    <div class="flex h-16 items-center justify-between bg-blue-600 px-6">
        <div class="flex items-center gap-3">
            <i class="fas fa-handshake text-2xl text-white"></i>
            <div>
                <h1 class="text-sm font-bold text-white">Sistem Informasi Pengelolaan Kasbon</h1>
                <p class="text-md text-white">PT. Iqro Lautan Pena</p>
            </div>
        </div>
        <button id="closeSidebar" class="text-white lg:hidden">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <nav class="mt-8">
        <div class="px-6 py-2">
            <p class="text-gray-500 text-xs uppercase tracking-wider font-semibold">Menu Utama</p>
        </div>
        <a href="{{ route('dashboard') }}"
            class="flex items-center px-6 py-3 {{ request()->routeIs('dashboard') ? 'text-blue-600 bg-blue-50 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-colors' }}">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
        </a>
        @if (auth()->user()->role == 'admin')
            <a href="{{ route('karyawan.index') }}"
                class="flex items-center px-6 py-3 {{ request()->routeIs('karyawan.*') ? 'text-blue-600 bg-blue-50 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-colors' }}">
                <i class="fas fa-users mr-3"></i>
                Karyawan
            </a>
            <a href="{{ route('peminjaman.index') }}"
                class="flex items-center px-6 py-3 {{ request()->routeIs('peminjaman.*') ? 'text-blue-600 bg-blue-50 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-colors' }}">
                <i class="fas fa-hand-holding-usd mr-3"></i>
                Kasbon
            </a>
            <a href="{{ route('penggajian.index') }}"
                class="flex items-center px-6 py-3 {{ request()->routeIs('penggajian.*') ? 'text-blue-600 bg-blue-50 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-colors' }}">
                <i class="fas fa-coins mr-3"></i>
                Penggajian
            </a>
            <a href="{{ route('report.peminjam') }}"
                class="flex items-center px-6 py-3 {{ request()->routeIs('report.*') ? 'text-blue-600 bg-blue-50 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-colors' }}">
                <i class="fas fa-hand-holding-usd mr-3"></i>
                Laporan Kasbon
            </a>
        @endif
    </nav>
</div>
