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
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        .section-bg {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .bg-overlay {
            background-color: rgba(255, 255, 255, 0.9);
        }
        .player-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body x-data="{ 
    currentRoute: 'dashboard',
    showPlayerModal: false,
    showTrainingModal: false,
    showEventModal: false,
    showMessageModal: false,
    showAnnouncementModal: false,
    newPlayer: {
        name: '',
        position: '',
        jerseyNumber: '',
        status: 'active'
    },
    newTraining: {
        date: '',
        time: '',
        location: '',
        type: '',
        description: ''
    },
    newEvent: {
        title: '',
        date: '',
        time: '',
        location: '',
        description: ''
    },
    newMessage: {
        recipient: '',
        subject: '',
        content: ''
    }
}" class="bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 flex-shrink-0 bg-white shadow-md">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="h-16 flex items-center justify-center border-b bg-gradient-to-r from-green-600 to-green-800">
                     <div class="flex items-center space-x-2">
                        <div class="inline-flex items-center justify-center w-10 h-10 bg-white rounded-full">
                           <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-2.757 0-5-3.228-5-9S5.243 3 8 3s5 4.772 5 9"></path></svg>
                        </div>
                        <span class="text-xl font-bold text-white">Mwatate FC</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="flex-1 px-4 py-4 space-y-1 bg-gradient-to-b from-green-700 to-green-900">
                    <a href="#dashboard" 
                       @click="currentRoute = 'dashboard'"
                       :class="currentRoute === 'dashboard' ? 'bg-green-600 text-white' : 'text-green-100 hover:bg-green-700'"
                       class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </a>
                    <a href="#players" 
                       @click="currentRoute = 'players'"
                       :class="currentRoute === 'players' ? 'bg-green-600 text-white' : 'text-green-100 hover:bg-green-700'"
                       class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m0 0A10.99 10.99 0 002.04 15m9.92-1.296A10.99 10.99 0 0021.96 15"></path></svg>
                        Players
                    </a>
                    <a href="#training" 
                       @click="currentRoute = 'training'"
                       :class="currentRoute === 'training' ? 'bg-green-600 text-white' : 'text-green-100 hover:bg-green-700'"
                       class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                         <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Training Planner
                    </a>
                    <a href="#analytics" 
                       @click="currentRoute = 'analytics'"
                       :class="currentRoute === 'analytics' ? 'bg-green-600 text-white' : 'text-green-100 hover:bg-green-700'"
                       class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        Video Analytics
                    </a>
                    <a href="#calendar" 
                       @click="currentRoute = 'calendar'"
                       :class="currentRoute === 'calendar' ? 'bg-green-600 text-white' : 'text-green-100 hover:bg-green-700'"
                       class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                         <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Calendar
                    </a>
                     <a href="#communication" 
                        @click="currentRoute = 'communication'"
                        :class="currentRoute === 'communication' ? 'bg-green-600 text-white' : 'text-green-100 hover:bg-green-700'"
                        class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        Communication
                    </a>
                     <a href="#stats" 
                        @click="currentRoute = 'stats'"
                        :class="currentRoute === 'stats' ? 'bg-green-600 text-white' : 'text-green-100 hover:bg-green-700'"
                        class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Team Stats
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-auto">
            <!-- Dashboard Section -->
            <div x-show="currentRoute === 'dashboard'" class="section-bg" style="background-image: url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80')">
                <div class="bg-overlay min-h-screen p-6 lg:p-8">
                    <!-- Header -->
                    <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Welcome back, Coach!</h2>
                            <p class="text-sm text-gray-500">Here's what's happening with your team today.</p>
                        </div>
                        <div class="flex items-center space-x-2 mt-4 md:mt-0">
                            <button @click="currentRoute = 'training'" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                Create Training Session
                            </button>
                            <button @click="currentRoute = 'communication'" class="px-4 py-2 text-sm font-semibold text-gray-700 bg-white rounded-lg shadow-sm border hover:bg-gray-50 focus:outline-none transition-all duration-200">
                                Send Team Message
                            </button>
                        </div>
                    </header>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Left Column -->
                        <div class="lg:col-span-2 space-y-8">
                            <!-- Upcoming Events Card -->
                            <div class="p-6 bg-white rounded-lg shadow-sm border border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-800 border-b pb-4">Upcoming Events</h3>
                                <div class="mt-4 space-y-4">
                                    <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all duration-200 cursor-pointer" @click="currentRoute = 'training'">
                                        <div class="p-3 bg-blue-100 rounded-full"><svg class="w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg></div>
                                        <div class="ml-4 flex-1">
                                            <p class="font-semibold text-gray-800">Technical Drills Session</p>
                                            <p class="text-sm text-gray-500">Today at 10:00 AM - Training Ground</p>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </div>
                                    <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all duration-200 cursor-pointer" @click="currentRoute = 'calendar'">
                                        <div class="p-3 bg-green-100 rounded-full"><svg class="w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18" /></svg></div>
                                        <div class="ml-4 flex-1">
                                            <p class="font-semibold text-gray-800">Match vs. Vihiga United</p>
                                            <p class="text-sm text-gray-500">Saturday, 28 Oct - Home Stadium</p>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Player Watchlist -->
                            <div class="p-6 bg-white rounded-lg shadow-sm border border-gray-200">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800">Player Watchlist</h3>
                                        <p class="text-sm text-gray-500">Monitor individual progress and status.</p>
                                    </div>
                                    <button @click="currentRoute = 'players'" class="text-sm font-medium text-blue-600 hover:underline">View All</button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Player Card -->
                                    <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50 transition-all duration-200 cursor-pointer player-card" @click="currentRoute = 'players'">
                                        <img class="w-12 h-12 rounded-full object-cover border-2 border-green-200" src="https://i.pravatar.cc/150?u=player1" alt="Player Avatar">
                                        <div class="ml-4">
                                            <p class="font-semibold text-gray-800">John Okoro</p>
                                            <p class="text-xs text-gray-500">Striker | Jersey #9</p>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-1">Top Performer</span>
                                        </div>
                                    </div>
                                    <!-- Player Card -->
                                    <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50 transition-all duration-200 cursor-pointer player-card" @click="currentRoute = 'players'">
                                        <img class="w-12 h-12 rounded-full object-cover border-2 border-green-200" src="https://i.pravatar.cc/150?u=player2" alt="Player Avatar">
                                        <div class="ml-4">
                                            <p class="font-semibold text-gray-800">Michael Wanjala</p>
                                            <p class="text-xs text-gray-500">Midfielder | Jersey #8</p>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mt-1">Returning to Training</span>
                                        </div>
                                    </div>
                                    <!-- Player Card -->
                                    <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50 transition-all duration-200 cursor-pointer player-card" @click="currentRoute = 'players'">
                                        <img class="w-12 h-12 rounded-full object-cover border-2 border-green-200" src="https://i.pravatar.cc/150?u=player3" alt="Player Avatar">
                                        <div class="ml-4">
                                            <p class="font-semibold text-gray-800">David Otieno</p>
                                            <p class="text-xs text-gray-500">Defender | Jersey #4</p>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-1">Needs Fitness Test</span>
                                        </div>
                                    </div>
                                    <!-- Player Card -->
                                    <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50 transition-all duration-200 cursor-pointer player-card" @click="currentRoute = 'players'">
                                        <img class="w-12 h-12 rounded-full object-cover border-2 border-green-200" src="https://i.pravatar.cc/150?u=player4" alt="Player Avatar">
                                        <div class="ml-4">
                                            <p class="font-semibold text-gray-800">James Mwangi</p>
                                            <p class="text-xs text-gray-500">Goalkeeper | Jersey #1</p>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 mt-1">Injured</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-8">
                            <!-- Team Form Card -->
                            <div class="p-6 bg-white rounded-lg shadow-sm border border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Form</h3>
                                <div class="flex items-center justify-between space-x-2">
                                    <div class="flex flex-col items-center">
                                        <div class="flex items-center justify-center w-10 h-10 font-bold text-white bg-green-500 rounded-full">W</div>
                                        <span class="text-xs mt-1 text-gray-500">3-1</span>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <div class="flex items-center justify-center w-10 h-10 font-bold text-white bg-green-500 rounded-full">W</div>
                                        <span class="text-xs mt-1 text-gray-500">2-0</span>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <div class="flex items-center justify-center w-10 h-10 font-bold text-white bg-red-500 rounded-full">L</div>
                                        <span class="text-xs mt-1 text-gray-500">0-1</span>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <div class="flex items-center justify-center w-10 h-10 font-bold text-white bg-gray-400 rounded-full">D</div>
                                        <span class="text-xs mt-1 text-gray-500">1-1</span>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <div class="flex items-center justify-center w-10 h-10 font-bold text-white bg-green-500 rounded-full">W</div>
                                        <span class="text-xs mt-1 text-gray-500">2-1</span>
                                    </div>
                                </div>
                                <button @click="currentRoute = 'stats'" class="mt-4 w-full py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition-all duration-200">
                                    View Full Statistics
                                </button>
                            </div>
                            
                            <!-- Recent Messages Card -->
                            <div class="p-6 bg-white rounded-lg shadow-sm border border-gray-200">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800">Recent Messages</h3>
                                    <button @click="currentRoute = 'communication'" class="text-sm font-medium text-blue-600 hover:underline">View All</button>
                                </div>
                                <ul class="space-y-4">
                                    <li class="flex items-start hover:bg-gray-50 p-2 rounded-lg cursor-pointer transition-all duration-200" @click="currentRoute = 'communication'">
                                        <img class="w-10 h-10 rounded-full" src="https://i.pravatar.cc/150?u=admin" alt="Admin Avatar">
                                        <div class="ml-3">
                                            <p class="text-sm font-semibold text-gray-900">Admin</p>
                                            <p class="text-sm text-gray-600">Reminder: Submit your match report by EOD.</p>
                                            <span class="text-xs text-gray-400">2 hours ago</span>
                                        </div>
                                    </li>
                                    <li class="flex items-start hover:bg-gray-50 p-2 rounded-lg cursor-pointer transition-all duration-200" @click="currentRoute = 'communication'">
                                        <img class="w-10 h-10 rounded-full" src="https://i.pravatar.cc/150?u=physio" alt="Physio Avatar">
                                        <div class="ml-3">
                                            <p class="text-sm font-semibold text-gray-900">Team Physio</p>
                                            <p class="text-sm text-gray-600">Michael Wanjala is cleared for light training.</p>
                                            <span class="text-xs text-gray-400">Yesterday</span>
                                        </div>
                                    </li>
                                    <li class="flex items-start hover:bg-gray-50 p-2 rounded-lg cursor-pointer transition-all duration-200" @click="currentRoute = 'communication'">
                                        <img class="w-10 h-10 rounded-full" src="https://i.pravatar.cc/150?u=captain" alt="Captain Avatar">
                                        <div class="ml-3">
                                            <p class="text-sm font-semibold text-gray-900">Team Captain</p>
                                            <p class="text-sm text-gray-600">Can we discuss the training schedule?</p>
                                            <span class="text-xs text-gray-400">2 days ago</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Players Section -->
            <div x-show="currentRoute === 'players'" class="section-bg" style="background-image: url('https://images.unsplash.com/photo-1579952363873-27f3bade9f55?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80')">
                <div class="bg-overlay min-h-screen p-6 lg:p-8">
                    <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Player Management</h2>
                            <p class="text-sm text-gray-500">View and manage your squad players</p>
                        </div>
                        <div class="flex items-center space-x-2 mt-4 md:mt-0">
                            <button @click="showPlayerModal = true" class="px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                                Add New Player
                            </button>
                            <button class="px-4 py-2 text-sm font-semibold text-gray-700 bg-white rounded-lg shadow-sm border hover:bg-gray-50 focus:outline-none transition-all duration-200">
                                Export Roster
                            </button>
                        </div>
                    </header>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="relative w-full max-w-md">
                                <input type="text" placeholder="Search players..." class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <div class="flex space-x-2 ml-4">
                                <button class="px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200">
                                    Filter
                                </button>
                                <button class="px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200">
                                    Sort
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Player cards would be dynamically loaded here -->
                            <div class="border rounded-lg overflow-hidden hover:shadow-md transition-all duration-200 player-card">
                                <div class="bg-gradient-to-r from-green-600 to-green-800 p-4 flex items-center">
                                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center">
                                        <span class="text-xl font-bold text-green-700">9</span>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-bold text-white">John Okoro</h3>
                                        <p class="text-sm text-green-100">Striker</p>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <div class="flex justify-between text-sm mb-3">
                                        <span class="text-gray-500">Age</span>
                                        <span class="font-medium">24</span>
                                    </div>
                                    <div class="flex justify-between text-sm mb-3">
                                        <span class="text-gray-500">Height</span>
                                        <span class="font-medium">182cm</span>
                                    </div>
                                    <div class="flex justify-between text-sm mb-3">
                                        <span class="text-gray-500">Weight</span>
                                        <span class="font-medium">78kg</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Status</span>
                                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                    </div>
                                    <div class="mt-4 flex space-x-2">
                                        <button class="flex-1 py-1.5 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700 transition-all duration-200">
                                            View
                                        </button>
                                        <button class="flex-1 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-all duration-200">
                                            Edit
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- More player cards... -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Training Planner Section -->
            <div x-show="currentRoute === 'training'" class="section-bg" style="background-image: url('https://images.unsplash.com/photo-1543357480-c60d400e7ef6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80')">
                <div class="bg-overlay min-h-screen p-6 lg:p-8">
                    <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Training Planner</h2>
                            <p class="text-sm text-gray-500">Schedule and manage training sessions</p>
                        </div>
                        <div class="flex items-center space-x-2 mt-4 md:mt-0">
                            <button @click="showTrainingModal = true" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                New Training Session
                            </button>
                            <button @click="generateTrainingReport()" class="px-4 py-2 text-sm font-semibold text-gray-700 bg-white rounded-lg shadow-sm border hover:bg-gray-50 focus:outline-none transition-all duration-200">
                                Generate Report
                            </button>
                        </div>
                    </header>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <div class="lg:col-span-2">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Upcoming Sessions</h3>
                                <div class="space-y-4">
                                    <div class="border rounded-lg p-4 hover:bg-gray-50 transition-all duration-200 cursor-pointer">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-800">Technical Drills Session</h4>
                                                <p class="text-sm text-gray-500">Today, 10:00 AM - 12:00 PM</p>
                                                <p class="text-sm text-gray-600 mt-2">Focus: Passing accuracy and ball control</p>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">In Progress</span>
                                        </div>
                                        <div class="mt-3 flex items-center text-sm text-gray-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            Main Training Ground
                                        </div>
                                    </div>
                                    <div class="border rounded-lg p-4 hover:bg-gray-50 transition-all duration-200 cursor-pointer">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-800">Tactical Training</h4>
                                                <p class="text-sm text-gray-500">Tomorrow, 9:00 AM - 11:00 AM</p>
                                                <p class="text-sm text-gray-600 mt-2">Focus: Defensive organization</p>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Scheduled</span>
                                        </div>
                                        <div class="mt-3 flex items-center text-sm text-gray-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            Main Training Ground
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Training Statistics</h3>
                                <div class="space-y-4">
                                    <div class="border rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-medium text-gray-700">Attendance Rate</span>
                                            <span class="text-sm font-bold text-green-600">92%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-green-600 h-2.5 rounded-full" style="width: 92%"></div>
                                        </div>
                                    </div>
                                    <div class="border rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-medium text-gray-700">Completed Sessions</span>
                                            <span class="text-sm font-bold text-blue-600">24/28</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: 85%"></div>
                                        </div>
                                    </div>
                                    <div class="border rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-medium text-gray-700">Player Fitness</span>
                                            <span class="text-sm font-bold text-yellow-600">78%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-yellow-400 h-2.5 rounded-full" style="width: 78%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Video Analytics Section -->
            <div x-show="currentRoute === 'analytics'" class="section-bg" style="background-image: url('https://images.unsplash.com/photo-1552667466-07770ae110d0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80')">
                <div class="bg-overlay min-h-screen p-6 lg:p-8">
                    <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Video Analytics</h2>
                            <p class="text-sm text-gray-500">Analyze match and training footage</p>
                        </div>
                        <div class="flex items-center space-x-2 mt-4 md:mt-0">
                            <button class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                Upload New Video
                            </button>
                            <button class="px-4 py-2 text-sm font-semibold text-gray-700 bg-white rounded-lg shadow-sm border hover:bg-gray-50 focus:outline-none transition-all duration-200">
                                Compare Matches
                            </button>
                        </div>
                    </header>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <div class="lg:col-span-2">
                                <div class="aspect-w-16 aspect-h-9 bg-black rounded-lg overflow-hidden">
                                    <!-- Video player placeholder -->
                                    <div class="w-full h-full flex items-center justify-center text-white bg-gray-800">
                                        <div class="text-center">
                                            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <p>Select a video to analyze</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 flex space-x-2 overflow-x-auto pb-2">
                                    <div class="flex-shrink-0 w-40 h-24 bg-gray-200 rounded-lg overflow-hidden cursor-pointer hover:ring-2 hover:ring-blue-500 transition-all duration-200">
                                        <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <div class="p-2">
                                            <p class="text-xs font-medium truncate">Match vs Vihiga United</p>
                                            <p class="text-xs text-gray-500">28 Oct 2023</p>
                                        </div>
                                    </div>
                                    <!-- More video thumbnails... -->
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Match Statistics</h3>
                                <div class="space-y-4">
                                    <div class="border rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-medium text-gray-700">Possession</span>
                                            <span class="text-sm font-bold text-green-600">58%</span>
                                        </div>
                                        <div class="flex h-2.5 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="bg-green-600" style="width: 58%"></div>
                                            <div class="bg-red-600" style="width: 42%"></div>
                                        </div>
                                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                                            <span>Us</span>
                                            <span>Opponent</span>
                                        </div>
                                    </div>
                                    <div class="border rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-medium text-gray-700">Shots on Target</span>
                                            <span class="text-sm font-bold text-blue-600">7/12</span>
                                        </div>
                                        <div class="flex h-2.5 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="bg-blue-600" style="width: 58%"></div>
                                            <div class="bg-red-600" style="width: 42%"></div>
                                        </div>
                                    </div>
                                    <div class="border rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-medium text-gray-700">Pass Accuracy</span>
                                            <span class="text-sm font-bold text-yellow-600">82%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-yellow-400 h-2.5 rounded-full" style="width: 82%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar Section -->
            <div x-show="currentRoute === 'calendar'" class="section-bg" style="background-image: url('https://images.unsplash.com/photo-1517649763962-0c623066013b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80')">
                <div class="bg-overlay min-h-screen p-6 lg:p-8">
                    <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Team Calendar</h2>
                            <p class="text-sm text-gray-500">View and manage team schedule</p>
                        </div>
                        <div class="flex items-center space-x-2 mt-4 md:mt-0">
                            <button @click="showEventModal = true" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                Add New Event
                            </button>
                            <button @click="exportCalendar()" class="px-4 py-2 text-sm font-semibold text-gray-700 bg-white rounded-lg shadow-sm border hover:bg-gray-50 focus:outline-none transition-all duration-200">
                                Export Calendar
                            </button>
                        </div>
                    </header>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <div class="lg:col-span-2">
                                <!-- Calendar view would go here -->
                                <div class="border rounded-lg p-4 h-96 flex items-center justify-center bg-gray-50">
                                    <div class="text-center">
                                        <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <p class="text-gray-500">Calendar view would appear here</p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Upcoming Events</h3>
                                <div class="space-y-4">
                                    <div class="border rounded-lg p-4 hover:bg-gray-50 transition-all duration-200 cursor-pointer">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-800">Match: Vihiga United</h4>
                                                <p class="text-sm text-gray-500">Saturday, 28 Oct - 3:00 PM</p>
                                                <p class="text-sm text-gray-600 mt-2">Home Stadium</p>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Match</span>
                                        </div>
                                    </div>
                                    <div class="border rounded-lg p-4 hover:bg-gray-50 transition-all duration-200 cursor-pointer">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-800">Team Meeting</h4>
                                                <p class="text-sm text-gray-500">Friday, 27 Oct - 10:00 AM</p>
                                                <p class="text-sm text-gray-600 mt-2">Club House</p>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Meeting</span>
                                        </div>
                                    </div>
                                    <div class="border rounded-lg p-4 hover:bg-gray-50 transition-all duration-200 cursor-pointer">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-800">Recovery Session</h4>
                                                <p class="text-sm text-gray-500">Sunday, 29 Oct - 9:00 AM</p>
                                                <p class="text-sm text-gray-600 mt-2">Training Ground</p>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Training</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Communication Section -->
            <div x-show="currentRoute === 'communication'" class="section-bg" style="background-image: url('https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1469&q=80')">
                <div class="bg-overlay min-h-screen p-6 lg:p-8">
                    <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Team Communication</h2>
                            <p class="text-sm text-gray-500">Send messages and announcements to the team</p>
                        </div>
                        <div class="flex items-center space-x-2 mt-4 md:mt-0">
                            <button @click="showMessageModal = true" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                New Message
                            </button>
                            <button @click="showAnnouncementModal = true" class="px-4 py-2 text-sm font-semibold text-gray-700 bg-white rounded-lg shadow-sm border hover:bg-gray-50 focus:outline-none transition-all duration-200">
                                Announcement
                            </button>
                        </div>
                    </header>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <div class="lg:col-span-2">
                                <div class="border rounded-lg p-4 h-96 overflow-y-auto">
                                    <div class="space-y-4">
                                        <div class="flex items-start">
                                            <img class="w-10 h-10 rounded-full" src="https://i.pravatar.cc/150?u=coach" alt="Coach Avatar">
                                            <div class="ml-3 bg-blue-50 p-3 rounded-lg max-w-xs lg:max-w-md">
                                                <p class="text-sm font-semibold text-gray-900">You</p>
                                                <p class="text-sm text-gray-600 mt-1">Don't forget we have training tomorrow at 9am sharp. Bring both sets of kits.</p>
                                                <span class="text-xs text-gray-400 mt-1 block">Today, 2:45 PM</span>
                                            </div>
                                        </div>
                                        <div class="flex items-start justify-end">
                                            <div class="bg-gray-100 p-3 rounded-lg max-w-xs lg:max-w-md">
                                                <p class="text-sm font-semibold text-gray-900">Team Captain</p>
                                                <p class="text-sm text-gray-600 mt-1">Got it coach. I'll remind everyone.</p>
                                                <span class="text-xs text-gray-400 mt-1 block">Today, 2:52 PM</span>
                                            </div>
                                        </div>
                                        <!-- More messages... -->
                                    </div>
                                </div>
                                <div class="mt-4 flex">
                                    <input type="text" placeholder="Type your message..." class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <button class="px-4 py-2 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700 transition-all duration-200">
                                        Send
                                    </button>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Team Members</h3>
                                <div class="space-y-3">
                                    <div class="flex items-center p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                                        <img class="w-8 h-8 rounded-full" src="https://i.pravatar.cc/150?u=player1" alt="Player Avatar">
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">John Okoro</p>
                                            <p class="text-xs text-gray-500">Striker</p>
                                        </div>
                                        <span class="ml-auto w-2 h-2 bg-green-500 rounded-full"></span>
                                    </div>
                                    <!-- More team members... -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team Stats Section -->
            <div x-show="currentRoute === 'stats'" class="section-bg" style="background-image: url('https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1605&q=80')">
                <div class="bg-overlay min-h-screen p-6 lg:p-8">
                    <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Team Statistics</h2>
                            <p class="text-sm text-gray-500">Performance metrics and analytics</p>
                        </div>
                        <div class="flex items-center space-x-2 mt-4 md:mt-0">
                            <button class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                Generate Report
                            </button>
                            <button class="px-4 py-2 text-sm font-semibold text-gray-700 bg-white rounded-lg shadow-sm border hover:bg-gray-50 focus:outline-none transition-all duration-200">
                                Compare Season
                            </button>
                        </div>
                    </header>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <div class="lg:col-span-2">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Season Performance</h3>
                                <!-- Chart placeholder -->
                                <div class="border rounded-lg p-4 h-64 flex items-center justify-center bg-gray-50">
                                    <div class="text-center">
                                        <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                        <p class="text-gray-500">Performance chart would appear here</p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Key Metrics</h3>
                                <div class="space-y-4">
                                    <div class="border rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-medium text-gray-700">Goals Scored</span>
                                            <span class="text-sm font-bold text-green-600">24</span>
                                        </div>
                                        <div class="text-xs text-gray-500">+5 from last season</div>
                                    </div>
                                    <div class="border rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-medium text-gray-700">Goals Conceded</span>
                                            <span class="text-sm font-bold text-red-600">12</span>
                                        </div>
                                        <div class="text-xs text-gray-500">-3 from last season</div>
                                    </div>
                                    <div class="border rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-medium text-gray-700">Clean Sheets</span>
                                            <span class="text-sm font-bold text-blue-600">8</span>
                                        </div>
                                        <div class="text-xs text-gray-500">+2 from last season</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add Player Modal -->
    <div x-show="showPlayerModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4" @click.away="showPlayerModal = false">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Add New Player</h3>
                    <button @click="showPlayerModal = false" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" x-model="newPlayer.name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Position</label>
                        <select x-model="newPlayer.position" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Select Position</option>
                            <option value="Goalkeeper">Goalkeeper</option>
                            <option value="Defender">Defender</option>
                            <option value="Midfielder">Midfielder</option>
                            <option value="Forward">Forward</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jersey Number</label>
                        <input type="number" x-model="newPlayer.jerseyNumber" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select x-model="newPlayer.status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="active">Active</option>
                            <option value="injured">Injured</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button @click="showPlayerModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                        Cancel
                    </button>
                    <button @click="addPlayer()" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                        Add Player
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- New Training Session Modal -->
    <div x-show="showTrainingModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4" @click.away="showTrainingModal = false">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800">New Training Session</h3>
                    <button @click="showTrainingModal = false" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <input type="date" x-model="newTraining.date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                        <input type="time" x-model="newTraining.time" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <input type="text" x-model="newTraining.location" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select x-model="newTraining.type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Type</option>
                            <option value="Technical">Technical</option>
                            <option value="Tactical">Tactical</option>
                            <option value="Physical">Physical</option>
                            <option value="Recovery">Recovery</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea x-model="newTraining.description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button @click="showTrainingModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        Cancel
                    </button>
                    <button @click="createTrainingSession()" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        Create Session
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- New Event Modal -->
    <div x-show="showEventModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4" @click.away="showEventModal = false">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Add New Event</h3>
                    <button @click="showEventModal = false" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" x-model="newEvent.title" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <input type="date" x-model="newEvent.date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                        <input type="time" x-model="newEvent.time" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <input type="text" x-model="newEvent.location" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea x-model="newEvent.description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button @click="showEventModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        Cancel
                    </button>
                    <button @click="createEvent()" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        Add Event
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- New Message Modal -->
    <div x-show="showMessageModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4" @click.away="showMessageModal = false">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800">New Message</h3>
                    <button @click="showMessageModal = false" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">To</label>
                        <select x-model="newMessage.recipient" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Recipient</option>
                            <option value="all">All Players</option>
                            <option value="squad">First Squad</option>
                            <option value="reserves">Reserves</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <input type="text" x-model="newMessage.subject" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea x-model="newMessage.content" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button @click="showMessageModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        Cancel
                    </button>
                    <button @click="sendMessage()" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        Send Message
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle initial page load and hash changes
        document.addEventListener('DOMContentLoaded', function() {
            // Set initial route based on URL hash
            const hash = window.location.hash.substring(1);
            if (hash) {
                Alpine.store('currentRoute', hash);
            } else {
                window.location.hash = 'dashboard';
            }

            // Update route when hash changes
            window.addEventListener('hashchange', function() {
                const newHash = window.location.hash.substring(1);
                Alpine.store('currentRoute', newHash);
            });
        });

        // Function to add a new player
        function addPlayer() {
            // Here you would typically make an API call to save the player
            alert(`Player ${this.newPlayer.name} added successfully!`);
            this.showPlayerModal = false;
            this.newPlayer = {
                name: '',
                position: '',
                jerseyNumber: '',
                status: 'active'
            };
        }

        // Function to create a new training session
        function createTrainingSession() {
            // Here you would typically make an API call to save the training session
            alert('New training session created successfully!');
            this.showTrainingModal = false;
            this.newTraining = {
                date: '',
                time: '',
                location: '',
                type: '',
                description: ''
            };
        }

        // Function to add a new calendar event
        function createEvent() {
            // Here you would typically make an API call to save the event
            alert('New event added successfully!');
            this.showEventModal = false;
            this.newEvent = {
                title: '',
                date: '',
                time: '',
                location: '',
                description: ''
            };
        }

        // Function to send a new message
        function sendMessage() {
            // Here you would typically make an API call to send the message
            alert('Message sent successfully!');
            this.showMessageModal = false;
            this.newMessage = {
                recipient: '',
                subject: '',
                content: ''
            };
        }

        // Function to create an announcement
        function createAnnouncement() {
            // Here you would typically make an API call to create the announcement
            alert('Announcement created successfully!');
            this.showAnnouncementModal = false;
        }

        // Function to generate training report
        function generateTrainingReport() {
            // Here you would typically make an API call to generate the report
            alert('Training report is being generated...');
        }

        // Function to export calendar
        function exportCalendar() {
            // Here you would typically make an API call to export the calendar
            alert('Calendar export started...');
        }
    </script>
</body>
</html>