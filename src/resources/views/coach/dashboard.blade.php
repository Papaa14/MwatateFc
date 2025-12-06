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

        /* Custom Scrollbar for Chat */
        .chat-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .chat-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .chat-scroll::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }

        .chat-scroll::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>
</head>

<body x-data="coachDashboard" class="bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 flex-shrink-0 bg-white shadow-md">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div
                    class="h-16 flex items-center justify-center border-b bg-gradient-to-r from-green-600 to-green-800">
                    <div class="flex items-center space-x-2">
                        <div class="inline-flex items-center justify-center w-10 h-10 bg-white rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-2.757 0-5-3.228-5-9S5.243 3 8 3s5 4.772 5 9">
                                </path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white">Mwatate FC</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="flex-1 px-4 py-4 space-y-1 bg-gradient-to-b from-green-700 to-green-900">
                    <a href="#dashboard" @click="currentRoute = 'dashboard'"
                        :class="currentRoute === 'dashboard' ? 'bg-green-600 text-white' : 'text-green-100 hover:bg-green-700'"
                        class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg> Dashboard
                    </a>
                    <a href="#players" @click="currentRoute = 'players'"
                        :class="currentRoute === 'players' ? 'bg-green-600 text-white' : 'text-green-100 hover:bg-green-700'"
                        class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m0 0A10.99 10.99 0 002.04 15m9.92-1.296A10.99 10.99 0 0021.96 15">
                            </path>
                        </svg> Players
                    </a>
                    <a href="#training" @click="currentRoute = 'training'"
                        :class="currentRoute === 'training' ? 'bg-green-600 text-white' : 'text-green-100 hover:bg-green-700'"
                        class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg> Training Planner
                    </a>
                    <a href="#analytics" @click="currentRoute = 'analytics'"
                        :class="currentRoute === 'analytics' ? 'bg-green-600 text-white' : 'text-green-100 hover:bg-green-700'"
                        class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg> Video Analytics
                    </a>
                    <a href="#calendar" @click="currentRoute = 'calendar'"
                        :class="currentRoute === 'calendar' ? 'bg-green-600 text-white' : 'text-green-100 hover:bg-green-700'"
                        class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg> Calendar
                    </a>
                    <a href="#communication" @click="currentRoute = 'communication'"
                        :class="currentRoute === 'communication' ? 'bg-green-600 text-white' : 'text-green-100 hover:bg-green-700'"
                        class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg> Communication
                    </a>
                    <a href="#stats" @click="currentRoute = 'stats'"
                        :class="currentRoute === 'stats' ? 'bg-green-600 text-white' : 'text-green-100 hover:bg-green-700'"
                        class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg> Team Stats
                    </a>

                    <!-- User Profile Footer -->
                    <div class="mt-auto border-t border-green-600 p-4" x-data="{ showDropdown: false }">
                        <div class="relative">
                            <button @click="showDropdown = !showDropdown"
                                class="flex items-center w-full px-3 py-2 text-sm text-green-100 hover:bg-green-700 rounded-lg transition-all duration-200">
                                <img class="w-8 h-8 rounded-full mr-3"
                                    :src="`https://ui-avatars.com/api/?name=${coach.name || 'Coach'}&background=random`"
                                    alt="Coach Avatar">
                                <div class="flex-1 text-left">
                                    <p class="font-medium" x-text="coach.name || 'Coach'"></p>
                                    <p class="text-xs text-green-200 truncate" x-text="coach.email || 'Loading...'"></p>
                                </div>
                                <svg class="w-4 h-4 ml-2" :class="showDropdown ? 'rotate-180' : ''" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="showDropdown" @click.away="showDropdown = false"
                                class="absolute bottom-full left-0 right-0 mb-2 bg-white rounded-lg shadow-lg border border-gray-200 py-1">
                                <button @click="logout(); showDropdown = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg> Logout
                                </button>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-auto">

            <!-- Dashboard Section -->
            <div x-show="currentRoute === 'dashboard'" class="section-bg"
                style="background-image: url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80')">
                <div class="bg-overlay min-h-screen p-6 lg:p-8">
                    <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Welcome back, <span
                                    x-text="coach.name || 'Coach'"></span>!</h2>
                            <p class="text-sm text-gray-500">Here's what's happening with your team today.</p>
                        </div>
                        <div class="flex items-center space-x-2 mt-4 md:mt-0">
                            <button @click="currentRoute = 'training'"
                                class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">Create
                                Training Session</button>
                            <button @click="currentRoute = 'communication'"
                                class="px-4 py-2 text-sm font-semibold text-gray-700 bg-white rounded-lg shadow-sm border hover:bg-gray-50 focus:outline-none transition-all duration-200">Send
                                Team Message</button>
                        </div>
                    </header>
                    <!-- Dashboard Cards -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-2 space-y-8">
                            <div class="p-6 bg-white rounded-lg shadow-sm border border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-800 border-b pb-4">Upcoming Events</h3>
                                <div class="mt-4 space-y-4">
                                    <template x-if="trainings.length === 0">
                                        <p class="text-gray-500 text-sm">No upcoming events scheduled.</p>
                                    </template>
                                    <template x-for="(session, index) in trainings.slice(0, 3)" :key="session.id">
                                        <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all duration-200 cursor-pointer"
                                            @click="currentRoute = 'training'">
                                            <div class="p-3 bg-blue-100 rounded-full"><svg class="w-6 h-6 text-blue-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.5">
                                                    <path d="M8.25 4.5l7.5 7.5-7.5 7.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg></div>
                                            <div class="ml-4 flex-1">
                                                <p class="font-semibold text-gray-800" x-text="session.type"></p>
                                                <p class="text-sm text-gray-500"><span
                                                        x-text="formatDate(session.date)"></span> at <span
                                                        x-text="formatTime(session.time)"></span> - <span
                                                        x-text="session.location"></span></p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-8">
                            <div class="p-6 bg-white rounded-lg shadow-sm border border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Form</h3>
                                <div class="flex items-center justify-between space-x-2">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="flex items-center justify-center w-10 h-10 font-bold text-white bg-green-500 rounded-full">
                                            W</div><span class="text-xs mt-1 text-gray-500">3-1</span>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="flex items-center justify-center w-10 h-10 font-bold text-white bg-green-500 rounded-full">
                                            W</div><span class="text-xs mt-1 text-gray-500">2-0</span>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="flex items-center justify-center w-10 h-10 font-bold text-white bg-red-500 rounded-full">
                                            L</div><span class="text-xs mt-1 text-gray-500">0-1</span>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="flex items-center justify-center w-10 h-10 font-bold text-white bg-gray-400 rounded-full">
                                            D</div><span class="text-xs mt-1 text-gray-500">1-1</span>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="flex items-center justify-center w-10 h-10 font-bold text-white bg-green-500 rounded-full">
                                            W</div><span class="text-xs mt-1 text-gray-500">2-1</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Players Section -->
            <div x-show="currentRoute === 'players'" class="section-bg"
                style="background-image: url('https://images.unsplash.com/photo-1579952363873-27f3bade9f55?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80')">
                <div class="bg-overlay min-h-screen p-6 lg:p-8">
                    <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Player Management</h2>
                            <p class="text-sm text-gray-500">View and manage your squad players</p>
                        </div>
                        <div></div>
                    </header>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="relative w-full max-w-md">
                                <input type="text" placeholder="Search players..."
                                    class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Dynamic Player Cards -->
                            <template x-for="player in players" :key="player.id">
                                <div
                                    class="border rounded-lg overflow-hidden hover:shadow-md transition-all duration-200 player-card">
                                    <div class="bg-gradient-to-r from-green-600 to-green-800 p-4 flex items-center">
                                        <div
                                            class="w-16 h-16 bg-white rounded-full flex items-center justify-center overflow-hidden">
                                            <img :src="`https://ui-avatars.com/api/?name=${player.name}&background=random`"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-bold text-white" x-text="player.name"></h3>
                                            <p class="text-sm text-green-100">Mwatate FC</p>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <div class="flex justify-between text-sm mb-3">
                                            <span class="text-gray-500">Email</span>
                                            <span class="font-medium truncate max-w-[150px]"
                                                x-text="player.email"></span>
                                        </div>
                                        <!-- UPDATED: Position Replaces Jersey -->
                                        <div class="flex justify-between text-sm mb-3">
                                            <span class="text-gray-500">Position</span>
                                            <span class="font-medium" x-text="player.position || 'N/A'"></span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-500">Status</span>
                                            <span class="px-2 py-0.5 rounded-full text-xs font-medium"
                                                :class="player.status === 'injured' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'"
                                                x-text="player.status || 'Active'"></span>
                                        </div>
                                        <div class="mt-4 flex space-x-2">
                                            <!-- UPDATED: View Profile calls edit modal -->
                                            <button @click="openEditPlayer(player)"
                                                class="flex-1 py-1.5 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700 transition-all duration-200">
                                                View Profile
                                            </button>
                                            <!-- UPDATED: Send Message pre-fills ID -->
                                            <button @click="openDirectMessage(player)"
                                                class="flex-1 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-all duration-200">
                                                Send Message
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Communication Section (UPDATED DESIGN) -->
            <div x-show="currentRoute === 'communication'" class="section-bg"
                style="background-image: url('https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1469&q=80')">
                <div class="bg-overlay min-h-screen p-6 lg:p-8">
                    <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Team Communication</h2>
                            <p class="text-sm text-gray-500">Chat with your players and staff</p>
                        </div>
                    </header>

                    <!-- Main White Card Container -->
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex flex-col h-[calc(100vh-200px)]">
                        <!-- Chat Area (Scrollable) -->
                        <div class="flex-1 overflow-y-auto pr-2 chat-scroll space-y-4">
                            <template x-if="messages.length === 0">
                                <div class="flex flex-col items-center justify-center h-full text-gray-400">
                                    <svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                        </path>
                                    </svg>
                                    <p>No messages yet. Start the conversation!</p>
                                </div>
                            </template>
                            <template x-for="msg in messages" :key="msg.id">
                                <div class="flex items-start space-x-4 border-b border-gray-100 pb-4 last:border-0">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-10 h-10 rounded-full bg-yellow-200 flex items-center justify-center text-yellow-800 font-bold text-sm">
                                            <span
                                                x-text="(msg.sender_id == coach.id || msg.sender_id == null) ? (coach.name || 'Coach').substring(0,2).toUpperCase() : (players.find(p => p.id == msg.sender_id)?.name || 'U').substring(0,2).toUpperCase()"></span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between mb-1">
                                            <h4 class="text-sm font-bold text-gray-900"
                                                x-text="(msg.sender_id == coach.id || msg.sender_id == null) ? (coach.name || 'Coach') : (players.find(p => p.id == msg.sender_id)?.name || 'Unknown User')">
                                            </h4>
                                            <span class="text-xs text-gray-400"
                                                x-text="formatDate(msg.created_at)"></span>
                                        </div>
                                        <div class="mb-1">
                                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded-full"
                                                x-text="msg.subject || 'General'"></span>
                                        </div>
                                        <p class="text-sm text-gray-700" x-text="msg.content"></p>
                                    </div>
                                </div>
                            </template>


                        </div>

                        <!-- Footer Input Area -->
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="md:col-span-1">
                                    <select x-model="newMessage.recipient"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Select Recipient...</option>
                                        <option value="all">All Players</option>
                                        <option value="squad">First Squad</option>
                                        <option value="reserves">Reserves</option>
                                        <optgroup label="Individual Players">
                                            <template x-for="p in players" :key="p.id">
                                                <option :value="p.id" x-text="p.name"></option>
                                            </template>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="md:col-span-3">
                                    <input type="text" x-model="newMessage.subject" placeholder="Subject / Topic"
                                        class="w-full mb-2 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <div class="flex gap-2">
                                        <input type="text" x-model="newMessage.content"
                                            placeholder="Type your message here..."
                                            class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <button @click="sendMessage()"
                                            class="bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-blue-800 transition-colors flex items-center">
                                            Send <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Other Sections (Placeholders) -->
            <div x-show="currentRoute === 'training'" class="section-bg"
                style="background-image: url('https://images.unsplash.com/photo-1543357480-c60d400e7ef6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80')">
                <div class="bg-overlay min-h-screen p-6 lg:p-8">
                    <h2 class="text-2xl font-bold">Training Planner</h2>
                </div>
            </div>
            <div x-show="currentRoute === 'analytics'" class="section-bg"
                style="background-image: url('https://images.unsplash.com/photo-1552667466-07770ae110d0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80')">
                <div class="bg-overlay min-h-screen p-6 lg:p-8">
                    <h2 class="text-2xl font-bold">Video Analytics</h2>
                </div>
            </div>
            <div x-show="currentRoute === 'calendar'" class="section-bg"
                style="background-image: url('https://images.unsplash.com/photo-1517649763962-0c623066013b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80')">
                <div class="bg-overlay min-h-screen p-6 lg:p-8">
                    <h2 class="text-2xl font-bold">Calendar</h2>
                </div>
            </div>
            <div x-show="currentRoute === 'stats'" class="section-bg"
                style="background-image: url('https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1605&q=80')">
                <div class="bg-overlay min-h-screen p-6 lg:p-8">
                    <h2 class="text-2xl font-bold">Team Stats</h2>
                </div>
            </div>
        </main>
    </div>

    <!-- MODALS -->

    <!-- Edit Player Modal (NEW: Name/Position Only) -->
    <div x-show="showEditPlayerModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4" @click.away="showEditPlayerModal = false">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Edit Player Details</h3>
                    <button @click="showEditPlayerModal = false" class="text-gray-400 hover:text-gray-500"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" x-model="editingPlayer.name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Position</label>
                        <select x-model="editingPlayer.position"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="Goalkeeper">Goalkeeper</option>
                            <option value="Defender">Defender</option>
                            <option value="Midfielder">Midfielder</option>
                            <option value="Forward">Forward</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button @click="showEditPlayerModal = false"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Cancel</button>
                    <button @click="updatePlayer()"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Message Modal (For direct send from card) -->
    <div x-show="showMessageModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4" @click.away="showMessageModal = false">
            <div class="p-6">
                <h3 class="text-xl font-bold mb-4">New Message</h3>
                <div class="space-y-4">
                    <!-- Read-only input for recipient name to confirm selection -->
                    <div class="text-sm text-gray-500 mb-1">Recipient: <span class="font-bold text-gray-800"
                            x-text="players.find(p => p.id === newMessage.recipient)?.name || 'Unknown'"></span></div>
                    <input type="text" x-model="newMessage.subject" placeholder="Subject"
                        class="w-full border rounded p-2">
                    <textarea x-model="newMessage.content" placeholder="Message content..."
                        class="w-full border rounded p-2" rows="4"></textarea>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button @click="showMessageModal = false" class="px-4 py-2 border rounded">Cancel</button>
                    <button @click="sendMessage()" class="px-4 py-2 bg-blue-600 text-white rounded">Send</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Training Modal -->
    <div x-show="showTrainingModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4" @click.away="showTrainingModal = false">
            <div class="p-6">
                <h3 class="text-xl font-bold mb-4">New Session</h3>
                <div class="space-y-4">
                    <input type="date" x-model="newTraining.date" class="w-full border rounded p-2">
                    <input type="time" x-model="newTraining.time" class="w-full border rounded p-2">
                    <input type="text" x-model="newTraining.location" placeholder="Location"
                        class="w-full border rounded p-2">
                    <select x-model="newTraining.type" class="w-full border rounded p-2">
                        <option>Technical</option>
                        <option>Tactical</option>
                    </select>
                    <textarea x-model="newTraining.description" placeholder="Description"
                        class="w-full border rounded p-2"></textarea>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button @click="showTrainingModal = false" class="px-4 py-2 border rounded">Cancel</button>
                    <button @click="createTrainingSession()"
                        class="px-4 py-2 bg-blue-600 text-white rounded">Create</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const API_URL = '/api';
        const getHeaders = () => ({
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('api_token')
        });

        document.addEventListener('alpine:init', () => {
            Alpine.data('coachDashboard', () => ({
                currentRoute: 'dashboard',
                showTrainingModal: false,
                showMessageModal: false,
                showEditPlayerModal: false,

                // Data
                coach: { name: '', email: '' },
                players: [],
                trainings: [],
                messages: [],

                // Forms
                newTraining: { date: '', time: '', location: '', type: '', description: '' },
                newMessage: { recipient: '', subject: '', content: '' },
                editingPlayer: { id: null, name: '', position: '' },

                init() {
                    const hash = window.location.hash.substring(1) || 'dashboard';
                    this.currentRoute = hash;

                    this.fetchCoach();
                    this.fetchPlayers();
                    this.fetchTrainings();
                    this.fetchMessages();

                    window.addEventListener('hashchange', () => {
                        this.currentRoute = window.location.hash.substring(1);
                    });
                },

                // Utilities
                formatDate(dateString) {
                    if (!dateString) return '';
                    const options = { month: 'short', day: 'numeric', year: 'numeric' };
                    return new Date(dateString).toLocaleDateString(undefined, options);
                },
                formatTime(timeString) {
                    if (!timeString) return '';
                    const [hours, minutes] = timeString.split(':');
                    return `${hours}:${minutes}`;
                },

                // Open Direct Message from Player Card
                openDirectMessage(player) {
                    this.newMessage.recipient = player.id; // Sends specific ID
                    this.newMessage.subject = `Message for ${player.name}`;
                    this.showMessageModal = true;
                },

                // Open Edit Player Modal
                openEditPlayer(player) {
                    this.editingPlayer = { ...player };
                    this.showEditPlayerModal = true;
                },

                // Update Player
                async updatePlayer() {
                    try {
                        const payload = {
                            name: this.editingPlayer.name,
                            position: this.editingPlayer.position
                        };
                        const res = await fetch(`${API_URL}/admin/update/${this.editingPlayer.id}`, {
                            method: 'PUT',
                            headers: getHeaders(),
                            body: JSON.stringify(payload)
                        });

                        if (res.ok) {
                            alert('Player updated successfully!');
                            this.showEditPlayerModal = false;
                            this.fetchPlayers();
                        } else {
                            const err = await res.json();
                            alert('Failed to update: ' + (err.message || 'Unknown error'));
                        }
                    } catch (e) {
                        console.error(e);
                        alert('Network error updating player');
                    }
                },

                // Fetch Coach Info
                async fetchCoach() {
                    try {
                        const res = await fetch(`${API_URL}/user`, { headers: getHeaders() });
                        const data = await res.json();
                        if (data.success || data.user) {
                            this.coach = data.user || data;
                        }
                    } catch (e) { console.error('Error fetching coach:', e); }
                },

                // Players
                async fetchPlayers() {
                    try {
                        const res = await fetch(`${API_URL}/users?role=player`, { headers: getHeaders() });
                        const data = await res.json();
                        this.players = data.data || [];
                    } catch (e) { console.error(e); }
                },

                // Trainings
                async fetchTrainings() {
                    try {
                        const res = await fetch(`${API_URL}/training-sessions`, { headers: getHeaders() });
                        const data = await res.json();
                        this.trainings = data.data || [];
                    } catch (e) { console.error(e); }
                },

                async createTrainingSession() {
                    try {
                        const res = await fetch(`${API_URL}/training-sessions`, {
                            method: 'POST',
                            headers: getHeaders(),
                            body: JSON.stringify(this.newTraining)
                        });
                        if (res.ok) {
                            alert('Session created!');
                            this.showTrainingModal = false;
                            this.fetchTrainings();
                        }
                    } catch (e) { console.error(e); }
                },

                // Messages
                async fetchMessages() {
                    try {
                        const res = await fetch(`${API_URL}/messages`, { headers: getHeaders() });
                        const data = await res.json();
                        this.messages = data.data || [];
                    } catch (e) { console.error(e); }
                },

                async sendMessage() {
                    try {
                        // Validate required fields
                        if (!this.newMessage.recipient || !this.newMessage.content) {
                            alert('Please select a recipient and enter a message');
                            return;
                        }

                        const payload = {
                            sender_id: this.coach.id,
                            recipient_group: this.newMessage.recipient,
                            subject: this.newMessage.subject || 'General',
                            content: this.newMessage.content
                        };

                        const res = await fetch(`${API_URL}/messages`, {
                            method: 'POST',
                            headers: getHeaders(),
                            body: JSON.stringify(payload)
                        });

                        if (res.ok) {
                            alert('Message sent successfully!');
                            // Clear form
                            this.newMessage = { recipient: '', subject: '', content: '' };
                            // Refresh messages
                            this.fetchMessages();
                        } else {
                            const err = await res.json();
                            alert('Failed to send message: ' + (err.message || 'Unknown error'));
                        }
                    } catch (e) {
                        console.error(e);
                        alert('Network error occurred');
                    }
                },


                async logout() {
                    try {
                        await fetch(`${API_URL}/logout`, { method: 'POST', headers: getHeaders() });
                        localStorage.removeItem('api_token');
                        window.location.href = '/';
                    } catch (e) {
                        localStorage.removeItem('api_token');
                        window.location.href = '/';
                    }
                }
            }));
        });
    </script>
</body>

</html>
