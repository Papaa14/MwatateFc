@props(['role'])

@php
    $roleClasses = [
        'admin' => 'bg-purple-100 text-purple-800',
        'editor' => 'bg-blue-100 text-blue-800',
        'user' => 'bg-green-100 text-green-800',
        'default' => 'bg-gray-100 text-gray-800'
    ];
    
    $class = $roleClasses[strtolower($role)] ?? $roleClasses['default'];
@endphp

<span class="px-2 py-1 text-xs font-semibold rounded-full {{ $class }}">
    {{ ucfirst($role) }}
</span>