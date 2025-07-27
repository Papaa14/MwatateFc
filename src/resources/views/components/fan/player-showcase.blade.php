<div class="py-12 bg-white">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Meet The Team</h2>
            <p class="max-w-2xl mx-auto mt-3 text-xl text-gray-500 sm:mt-4">Get to know the players who make it all happen</p>
        </div>

        <div class="grid grid-cols-2 gap-6 mt-12 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
            @foreach($players as $player)
            <div class="relative group">
                <div class="overflow-hidden bg-gray-200 rounded-lg aspect-w-1 aspect-h-1">
                    <img class="object-cover w-full h-full transition duration-300 group-hover:scale-105" src="{{ $player->photo_url }}" alt="{{ $player->name }}">
                    <div class="absolute inset-0 transition-opacity bg-gradient-to-t from-black to-transparent opacity-50"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                        <h3 class="text-lg font-bold">{{ $player->name }}</h3>
                        <p class="text-sm">{{ $player->position }}</p>
                        <p class="text-xs">{{ $player->jersey_number }}</p>
                    </div>
                </div>
                <div class="mt-2 text-center">
                    <button @click="openModal('player-{{ $player->id }}')" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                        View Profile
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('team') }}" class="inline-flex items-center px-4 py-2 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">
                View Full Squad
                <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </a>
        </div>
    </div>

    <!-- Player modals (one for each player) -->
    @foreach($players as $player)
    <div x-show="modalOpen === 'player-{{ $player->id }}'" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="modalOpen === 'player-{{ $player->id }}'" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" @click="modalOpen = null"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="modalOpen === 'player-{{ $player->id }}'" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white">
                    <div class="sm:flex">
                        <div class="flex-shrink-0">
                            <img class="object-cover w-full h-48 sm:w-48 sm:h-full" src="{{ $player->photo_url }}" alt="{{ $player->name }}">
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-2xl font-bold text-gray-900" id="modal-title">{{ $player->name }}</h3>
                                <span class="px-3 py-1 text-lg font-bold text-white bg-blue-600 rounded-full">{{ $player->jersey_number }}</span>
                            </div>
                            <div class="mt-2">
                                <span class="text-lg font-medium text-gray-600">{{ $player->position }}</span>
                                <span class="mx-2 text-gray-400">|</span>
                                <span class="text-gray-600">{{ $player->nationality }}</span>
                            </div>
                            <div class="mt-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Age</p>
                                        <p class="font-medium">{{ $player->age }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Height</p>
                                        <p class="font-medium">{{ $player->height }} cm</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Weight</p>
                                        <p class="font-medium">{{ $player->weight }} kg</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Joined</p>
                                        <p class="font-medium">{{ $player->joined_at->format('M Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <h4 class="font-medium text-gray-900">Bio</h4>
                                <p class="mt-1 text-gray-600">{{ $player->bio }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm" @click="modalOpen = null">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>