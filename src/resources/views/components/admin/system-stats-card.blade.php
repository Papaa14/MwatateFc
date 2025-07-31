@props(['title', 'value', 'icon', 'color' => 'blue'])

@php
    $colors = [
        'blue' => 'bg-blue-100 text-blue-800',
        'green' => 'bg-green-100 text-green-800',
        'red' => 'bg-red-100 text-red-800',
        'yellow' => 'bg-yellow-100 text-yellow-800',
        'purple' => 'bg-purple-100 text-purple-800',
    ];
@endphp

<div class="flex items-center p-4 bg-white rounded-lg shadow">
    <div class="p-3 mr-4 rounded-full {{ $colors[$color] }}">
        {!! $icon !!}
    </div>
    <div>
        <p class="mb-2 text-sm font-medium text-gray-600">{{ $title }}</p>
        <p class="text-lg font-semibold text-gray-700">{{ $value }}</p>
    </div>
</div>