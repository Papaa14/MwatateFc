<?php
// File: resources/views/components/player-card.blade.php
?>
@props(['player', 'compact' => false])

<div class="bg-white rounded-xl shadow-sm border border-gray-200 {{ $compact ? 'p-4' : 'p-6' }}">
    <div class="flex items-center {{ $compact ? 'space-x-3' : 'space-x-4' }}">
        <!-- Player Avatar -->
        <div class="{{ $compact ? 'w-10 h-10' : 'w-12 h-12' }} bg-gradient-to-r from-indigo-500 to-blue-500 rounded-full flex items-center justify-center">
            <span class="text-white font-bold {{ $compact ? 'text-sm' : 'text-lg' }}">
                {{ $player['jersey_number'] ?? '#' }}
            </span>
        </div>

        <!-- Player Info -->
        <div class="flex-1">
            <h3 class="{{ $compact ? 'text-sm' : 'text-base' }} font-semibold text-gray-900">
                {{ $player['name'] ?? 'Player Name' }}
            </h3>
            <p class="text-xs text-gray-500">{{ $player['position'] ?? 'Position' }}</p>

            @if(!$compact && isset($player['stats']))
            <div class="flex space-x-4 mt-2">
                @foreach($player['stats'] as $stat => $value)
                <div class="text-center">
                    <p class="text-sm font-semibold text-gray-900">{{ $value }}</p>
                    <p class="text-xs text-gray-500">{{ ucfirst($stat) }}</p>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Player Status -->
        @if(isset($player['status']))
        <div class="flex flex-col items-end">
            <span class="px-2 py-1 text-xs rounded-full {{ $player['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ ucfirst($player['status']) }}
            </span>
        </div>
        @endif
    </div>
</div>
