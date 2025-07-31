<div class="p-6 bg-white rounded-lg shadow">
    <h3 class="mb-6 text-lg font-medium text-gray-900">Season Statistics</h3>
    
    <div class="grid grid-cols-2 gap-6 md:grid-cols-4">
        <div class="p-4 text-center bg-gray-50 rounded-lg">
            <p class="text-sm font-medium text-gray-500">Matches Played</p>
            <p class="mt-1 text-3xl font-bold text-gray-900">{{ $stats['matches'] }}</p>
            <p class="mt-1 text-sm text-gray-500">{{ $stats['starts'] }} starts</p>
        </div>
        
        <div class="p-4 text-center bg-gray-50 rounded-lg">
            <p class="text-sm font-medium text-gray-500">Goals</p>
            <p class="mt-1 text-3xl font-bold text-gray-900">{{ $stats['goals'] }}</p>
            <p class="mt-1 text-sm text-gray-500">{{ $stats['goals_per_match'] }} per match</p>
        </div>
        
        <div class="p-4 text-center bg-gray-50 rounded-lg">
            <p class="text-sm font-medium text-gray-500">Assists</p>
            <p class="mt-1 text-3xl font-bold text-gray-900">{{ $stats['assists'] }}</p>
            <p class="mt-1 text-sm text-gray-500">{{ $stats['assists_per_match'] }} per match</p>
        </div>
        
        <div class="p-4 text-center bg-gray-50 rounded-lg">
            <p class="text-sm font-medium text-gray-500">Avg. Rating</p>
            <p class="mt-1 text-3xl font-bold text-gray-900">{{ $stats['rating'] }}</p>
            <p class="mt-1 text-sm text-gray-500">Top {{ $stats['rating_percentile'] }}% in league</p>
        </div>
    </div>
    
    <div class="mt-6">
        <h4 class="mb-3 text-sm font-medium text-gray-900">Detailed Stats</h4>
        <div class="overflow-hidden border border-gray-200 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">Minutes Played</td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $stats['minutes'] }}'</td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $stats['minutes_per_match'] }}' per match</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">Shots</td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $stats['shots'] }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $stats['shot_accuracy'] }}% on target</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">Passes</td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $stats['passes'] }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $stats['pass_accuracy'] }}% accuracy</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">Tackles</td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $stats['tackles'] }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $stats['tackle_success'] }}% success</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>