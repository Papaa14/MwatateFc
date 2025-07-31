<div class="py-12 bg-gray-50">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Match Highlights</h2>
            <p class="max-w-2xl mx-auto mt-3 text-xl text-gray-500 sm:mt-4">Relive the best moments from our recent matches</p>
        </div>
        
        <div class="grid max-w-lg gap-5 mx-auto mt-12 lg:grid-cols-3 lg:max-w-none">
            @foreach($highlights as $highlight)
            <div class="flex flex-col overflow-hidden bg-white rounded-lg shadow-lg">
                <div class="flex-shrink-0">
                    <div class="relative pt-[56.25%] overflow-hidden">
                        <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/{{ $highlight->video_id }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="flex flex-col justify-between flex-1 p-6">
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-blue-600">
                                {{ $highlight->competition }}
                            </span>
                            <span class="text-sm text-gray-500">
                                {{ $highlight->match_date->format('M d, Y') }}
                            </span>
                        </div>
                        <a href="#" class="block mt-2">
                            <h3 class="text-xl font-semibold text-gray-900">
                                {{ $highlight->title }}
                            </h3>
                            <p class="mt-3 text-base text-gray-500">
                                {{ $highlight->description }}
                            </p>
                        </a>
                    </div>
                    <div class="flex items-center mt-6">
                        <div class="flex-shrink-0">
                            <span class="px-3 py-1 text-sm font-medium text-white bg-gray-800 rounded-full">
                                {{ $highlight->score }}
                            </span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">
                                {{ $highlight->venue }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-10 text-center">
            <a href="#" class="inline-flex items-center px-4 py-2 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">
                View All Highlights
                <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </a>
        </div>
    </div>
</div>