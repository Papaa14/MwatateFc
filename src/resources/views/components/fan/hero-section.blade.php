<div class="relative bg-gray-900">
    <!-- Hero image -->
    <div class="absolute inset-0 overflow-hidden opacity-75">
        <img class="object-cover w-full h-full" src="{{ asset('images/stadium-hero.jpg') }}" alt="Stadium full of fans">
    </div>
    
    <div class="relative px-4 py-32 mx-auto max-w-7xl sm:py-48 sm:px-6 lg:px-8">
        <div class="max-w-3xl text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                Welcome to the {{ config('app.name') }} Family
            </h1>
            <p class="mt-6 text-xl text-gray-300">
                Join thousands of passionate fans supporting our team through every match
            </p>
            <div class="flex justify-center mt-10 space-x-4">
                <a href="#" class="inline-flex items-center px-6 py-3 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">
                    Latest News
                </a>
                <a href="#" class="inline-flex items-center px-6 py-3 text-base font-medium text-white bg-transparent border border-white rounded-md hover:bg-white hover:bg-opacity-10">
                    Match Tickets
                </a>
            </div>
        </div>
    </div>
    
    <!-- Next match info -->
    <div class="relative pb-16">
        <div class="max-w-md mx-auto overflow-hidden bg-white rounded-lg shadow-lg sm:max-w-xl">
            <div class="px-6 py-4 bg-gray-800 sm:px-8 sm:py-6">
                <h3 class="text-lg font-medium text-center text-white">Next Match</h3>
                <div class="flex items-center justify-between mt-4">
                    <div class="flex flex-col items-center">
                        <img class="w-16 h-16" src="{{ asset('images/team-logo.png') }}" alt="Our team logo">
                        <span class="mt-2 font-medium text-white">{{ config('app.name') }}</span>
                    </div>
                    <div class="px-4 py-2 mx-2 text-white bg-gray-700 rounded">
                        <span class="text-sm font-medium">SAT</span>
                        <div class="text-xl font-bold">15:00</div>
                    </div>
                    <div class="flex flex-col items-center">
                        <img class="w-16 h-16" src="{{ asset('images/opponent-logo.png') }}" alt="Opponent team logo">
                        <span class="mt-2 font-medium text-white">Opponent FC</span>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <a href="#" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Get Tickets
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>