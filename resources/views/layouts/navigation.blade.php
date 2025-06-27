<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="flex items-center justify-between px-6 py-4">
        <div class="flex items-center">
            <button id="openSidebar" class="lg:hidden text-gray-600 hover:text-gray-900 mr-4">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
        </div>

        <div class="flex items-center space-x-4">
            <!-- User Profile Dropdown -->
            <div class="relative">
                <button id="profileToggle" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        @if (auth()->user()->photos)
                            <img src="{{ asset('storage/' . auth()->user()->photos) }}" alt="User Avatar"
                                class="w-full h-full rounded-full object-cover">
                        @else
                            <i class="fas fa-user text-white text-sm"></i>
                        @endif
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->role }}</p>
                    </div>
                    <i class="fas fa-chevron-down text-xs"></i>
                </button>
                <div id="profileDropdown"
                    class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg hidden z-10">
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>


@props(['current_title'])

<nav class="container ml-7 py-4" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2 text-sm text-gray-500">
        <li>
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a>
        </li>
        <li class="flex items-center">
            <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-500">{{ $current_title ?? '-' }}</span>
        </li>
    </ol>
</nav>




<script>
    // Toggle Profile Dropdown
    const profileToggle = document.getElementById('profileToggle');
    const profileDropdown = document.getElementById('profileDropdown');

    profileToggle.addEventListener('click', () => {
        profileDropdown.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (event) => {
        if (!profileToggle.contains(event.target) && !profileDropdown.contains(event.target)) {
            profileDropdown.classList.add('hidden');
        }
    });
</script>
