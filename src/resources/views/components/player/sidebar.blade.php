<?php
// File: resources/views/components/sidebar.blade.php
?>
<div class="bg-indigo-900 text-white w-64 flex-shrink-0 overflow-y-auto" x-data="{ activeMenu: '{{ request()->route()->getName() }}' }">
    <!-- Logo -->
    <div class="p-6 border-b border-indigo-800">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                <i class="fas fa-futbol text-indigo-900 text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold">Mwatate FC</h1>
                <p class="text-indigo-300 text-sm">Admin Panel</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="p-4">
        <ul class="space-y-2">
            @php
            $menuItems = [
                ['route' => 'dashboard', 'icon' => 'fas fa-chart-bar', 'label' => 'Dashboard'],
                ['route' => 'players', 'icon' => 'fas fa-users', 'label' => 'Players'],
                ['route' => 'fixtures', 'icon' => 'fas fa-calendar-alt', 'label' => 'Fixtures'],
                ['route' => 'staff', 'icon' => 'fas fa-user-tie', 'label' => 'Staff'],
                ['route' => 'performance', 'icon' => 'fas fa-chart-line', 'label' => 'Performance'],
                ['route' => 'settings', 'icon' => 'fas fa-cog', 'label' => 'Settings']
            ];
            @endphp

            @foreach($menuItems as $item)
            <li>
                <a href="{{ route($item['route']) }}"
                   class="flex items-center space-x-3 p-3 rounded-lg transition-colors duration-200"
                   :class="activeMenu === '{{ $item['route'] }}' ? 'bg-indigo-800 text-white' : 'text-indigo-200 hover:bg-indigo-800 hover:text-white'"
                   @click="activeMenu = '{{ $item['route'] }}'">
                    <i class="{{ $item['icon'] }}"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </nav>
</div>
