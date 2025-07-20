
<?php
// File: resources/views/components/top-nav.blade.php
?>
<header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <h2 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
            <span class="text-gray-500">{{ date('d M Y') }}</span>
        </div>

        <div class="flex items-center space-x-4">
            <!-- Notifications -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="relative p-2 text-gray-600 hover:text-gray-800">
                    <i class="fas fa-bell text-lg"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                </button>
            </div>

            <!-- User Profile -->
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-semibold text-sm">HP</span>
                </div>
                <span class="text-gray-700 font-medium">Howard Pilsworth</span>
            </div>
        </div>
    </div>
</header>
