<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coach Dashboard - Mwatate FC Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
    </style>
</head>
<body>
    <div class="flex min-h-screen">
        <!-- Reusable Sidebar Component -->
        <aside class="w-64 flex-shrink-0 bg-white shadow-md">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="h-16 flex items-center justify-center border-b">
                     <div class="flex items-center space-x-2">
                        <div class="inline-flex items-center justify-center w-10 h-10 bg-green-100 rounded-full">
                           <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-2.757 0-5-3.228-5-9S5.243 3 8 3s5 4.772 5 9"></path></svg>
                        </div>
                        <span class="text-xl font-bold text-gray-800">Mwatate FC</span>
                    </div>
                </div>

                <!-- Coach Navigation Links -->
                <nav class="flex-1 px-4 py-4 space-y-1">
                    <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-blue-700 bg-blue-50 rounded-lg">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m0 0A10.99 10.99 0 002.04 15m9.92-1.296A10.99 10.99 0 0021.96 15"></path></svg>
                        Players
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100">
                         <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Training Planner
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        Video Analytics
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100">
                         <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Calendar
                    </a>
                     <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        Communication
                    </a>
                     <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Team Stats
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 lg:p-8">
            <!-- Header -->
            <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Welcome back, Coach!</h2>
                    <p class="text-sm text-gray-500">Here's what's happening with your team today.</p>
                </div>
                <div class="flex items-center space-x-2 mt-4 md:mt-0">
                    <button class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Create Training Session</button>
                    <button class="px-4 py-2 text-sm font-semibold text-gray-700 bg-white rounded-lg shadow-sm border hover:bg-gray-50 focus:outline-none">Send Team Message</button>
                </div>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Upcoming Events Card -->
                    <div class="p-6 bg-white rounded-lg shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-4">Upcoming Events</h3>
                        <div class="mt-4 space-y-4">
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <div class="p-3 bg-blue-100 rounded-full"><svg class="w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg></div>
                                <div class="ml-4 flex-1">
                                    <p class="font-semibold text-gray-800">Technical Drills Session</p>
                                    <p class="text-sm text-gray-500">Today at 10:00 AM - Training Ground</p>
                                </div>
                                <a href="#" class="text-sm font-medium text-blue-600 hover:underline">View Details</a>
                            </div>
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <div class="p-3 bg-green-100 rounded-full"><svg class="w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18" /></svg></div>
                                <div class="ml-4 flex-1">
                                    <p class="font-semibold text-gray-800">Match vs. Vihiga United</p>
                                    <p class="text-sm text-gray-500">Saturday, 28 Oct - Home Stadium</p>
                                </div>
                                <a href="#" class="text-sm font-medium text-blue-600 hover:underline">Set Lineup</a>
                            </div>
                        </div>
                    </div>

                    <!-- Player Watchlist -->
                    <div class="p-6 bg-white rounded-lg shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-800">Player Watchlist</h3>
                        <p class="text-sm text-gray-500 mb-4">Monitor individual progress and status.</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Player Card -->
                            <div class="flex items-center p-3 border rounded-lg">
                                <img class="w-12 h-12 rounded-full object-cover" src="https://i.pravatar.cc/150?u=player1" alt="Player Avatar">
                                <div class="ml-4">
                                    <p class="font-semibold text-gray-800">John Okoro</p>
                                    <p class="text-xs text-gray-500">Striker</p>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Top Performer</span>
                                </div>
                            </div>
                            <!-- Player Card -->
                            <div class="flex items-center p-3 border rounded-lg">
                                <img class="w-12 h-12 rounded-full object-cover" src="https://i.pravatar.cc/150?u=player2" alt="Player Avatar">
                                <div class="ml-4">
                                    <p class="font-semibold text-gray-800">Michael Wanjala</p>
                                    <p class="text-xs text-gray-500">Midfielder</p>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Returning to Training</span>
                                </div>
                            </div>
                             <!-- Player Card -->
                            <div class="flex items-center p-3 border rounded-lg">
                                <img class="w-12 h-12 rounded-full object-cover" src="https://i.pravatar.cc/150?u=player3" alt="Player Avatar">
                                <div class="ml-4">
                                    <p class="font-semibold text-gray-800">David Otieno</p>
                                    <p class="text-xs text-gray-500">Defender</p>
                                     <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Needs Fitness Test</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-8">
                    <!-- Team Form Card -->
                    <div class="p-6 bg-white rounded-lg shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Form</h3>
                        <div class="flex items-center justify-between space-x-2">
                             <div class="flex items-center justify-center w-10 h-10 font-bold text-white bg-green-500 rounded-full">W</div>
                             <div class="flex items-center justify-center w-10 h-10 font-bold text-white bg-green-500 rounded-full">W</div>
                             <div class="flex items-center justify-center w-10 h-10 font-bold text-white bg-red-500 rounded-full">L</div>
                             <div class="flex items-center justify-center w-10 h-10 font-bold text-white bg-gray-400 rounded-full">D</div>
                             <div class="flex items-center justify-center w-10 h-10 font-bold text-white bg-green-500 rounded-full">W</div>
                        </div>
                    </div>
                    
                    <!-- Recent Messages Card -->
                    <div class="p-6 bg-white rounded-lg shadow-sm">
                         <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Messages</h3>
                         <ul class="space-y-4">
                             <li class="flex items-start">
                                 <img class="w-10 h-10 rounded-full" src="https://i.pravatar.cc/150?u=admin" alt="Admin Avatar">
                                 <div class="ml-3">
                                     <p class="text-sm font-semibold text-gray-900">Admin</p>
                                     <p class="text-sm text-gray-600">Reminder: Submit your match report by EOD.</p>
                                 </div>
                             </li>
                              <li class="flex items-start">
                                 <img class="w-10 h-10 rounded-full" src="https://i.pravatar.cc/150?u=physio" alt="Physio Avatar">
                                 <div class="ml-3">
                                     <p class="text-sm font-semibold text-gray-900">Team Physio</p>
                                     <p class="text-sm text-gray-600">Michael Wanjala is cleared for light training.</p>
                                 </div>
                             </li>
                         </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>