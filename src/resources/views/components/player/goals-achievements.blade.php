<div class="p-6 bg-white rounded-lg shadow">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-medium text-gray-900">Season Goals</h3>
        <span class="px-3 py-1 text-sm font-medium text-green-800 bg-green-100 rounded-full">
            {{ $progress }}% Complete
        </span>
    </div>
    
    <div class="mb-4">
        <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
        </div>
    </div>
    
    <div class="space-y-4">
        @foreach($goals as $goal)
        <div class="flex items-start">
            <div class="flex items-center h-5">
                <input id="goal-{{ $goal['id'] }}" type="checkbox" {{ $goal['completed'] ? 'checked' : '' }} 
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            </div>
            <div class="ml-3 text-sm">
                <label for="goal-{{ $goal['id'] }}" class="font-medium {{ $goal['completed'] ? 'text-gray-500 line-through' : 'text-gray-700' }}">
                    {{ $goal['title'] }}
                </label>
                @if($goal['target'])
                <p class="text-gray-500">
                    Target: {{ $goal['current'] }}/{{ $goal['target'] }}
                    @if($goal['unit'])
                    {{ $goal['unit'] }}
                    @endif
                </p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="mt-6">
        <button type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add New Goal
        </button>
    </div>
</div>