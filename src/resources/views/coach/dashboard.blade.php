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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        .section-bg { background-size: cover; background-position: center; background-repeat: no-repeat; }
        .bg-overlay { background-color: rgba(255, 255, 255, 0.9); }
        .player-card:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
        .chat-scroll::-webkit-scrollbar { width: 6px; }
        .chat-scroll::-webkit-scrollbar-track { background: #f1f1f1; }
        .chat-scroll::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }
        .chat-scroll::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
        [x-cloak] { display: none !important; }

        /* Custom Toggle Switch */
        .toggle-checkbox:checked {
            right: 0;
            border-color: #10B981;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #10B981;
        }
    </style>
</head>

<body x-data="coachDashboard" class="bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 flex-shrink-0 bg-white shadow-md z-20">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="h-16 flex items-center justify-center border-b bg-gradient-to-r from-green-600 to-green-800">
                    <div class="flex items-center space-x-2">
                        <div class="inline-flex items-center justify-center w-10 h-10 bg-white rounded-full">
                            <i class="fas fa-futbol text-green-600 text-xl"></i>
                        </div>
                        <span class="text-xl font-bold text-white">Mwatate FC</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="flex-1 px-4 py-4 space-y-1 bg-gradient-to-b from-green-700 to-green-900">
                    <a href="#dashboard" @click="currentRoute = 'dashboard'"
                        :class="currentRoute === 'dashboard' ? 'bg-green-600 text-white' : 'text-green-100 hover:bg-green-700'"
                        class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                        <i class="fas fa-home w-5 mr-3 text-center"></i> Dashboard
                    </a>
                    <a href="#players" @click="currentRoute = 'players'"
                        :class="currentRoute === 'players' ? 'bg-green-600 text-white' : 'text-green-100 hover:bg-green-700'"
                        class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                        <i class="fas fa-users w-5 mr-3 text-center"></i> Players
                    </a>
                    <a href="#training" @click="currentRoute = 'training'"
                        :class="currentRoute === 'training' ? 'bg-green-600 text-white' : 'text-green-100 hover:bg-green-700'"
                        class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                        <i class="fas fa-clipboard-list w-5 mr-3 text-center"></i> Training Planner
                    </a>
                    <a href="#analytics" @click="currentRoute = 'analytics'"
                        :class="currentRoute === 'analytics' ? 'bg-green-600 text-white' : 'text-green-100 hover:bg-green-700'"
                        class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                        <i class="fas fa-video w-5 mr-3 text-center"></i> Video Analytics
                    </a>
                    <a href="#calendar" @click="currentRoute = 'calendar'"
                        :class="currentRoute === 'calendar' ? 'bg-green-600 text-white' : 'text-green-100 hover:bg-green-700'"
                        class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                        <i class="fas fa-calendar-alt w-5 mr-3 text-center"></i> Calendar
                    </a>
                    <a href="#communication" @click="currentRoute = 'communication'"
                        :class="currentRoute === 'communication' ? 'bg-green-600 text-white' : 'text-green-100 hover:bg-green-700'"
                        class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                        <i class="fas fa-comments w-5 mr-3 text-center"></i> Communication
                    </a>
                    <a href="#stats" @click="currentRoute = 'stats'"
                        :class="currentRoute === 'stats' ? 'bg-green-600 text-white' : 'text-green-100 hover:bg-green-700'"
                        class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                        <i class="fas fa-chart-bar w-5 mr-3 text-center"></i> Team Stats
                    </a>

                    <!-- User Profile Footer -->
                    <div class="mt-auto border-t border-green-600 p-4" x-data="{ showDropdown: false }">
                        <div class="relative">
                            <button @click="showDropdown = !showDropdown"
                                class="flex items-center w-full px-3 py-2 text-sm text-green-100 hover:bg-green-700 rounded-lg transition-all duration-200">
                                <img class="w-8 h-8 rounded-full mr-3"
                                    :src="`https://ui-avatars.com/api/?name=${coach.name || 'Coach'}&background=random`"
                                    alt="Avatar">
                                <div class="flex-1 text-left">
                                    <p class="font-medium" x-text="coach.name || 'Coach'"></p>
                                    <p class="text-xs text-green-200 truncate" x-text="coach.email || 'Loading...'"></p>
                                </div>
                                <i class="fas fa-chevron-down w-4 ml-2" :class="showDropdown ? 'rotate-180' : ''"></i>
                            </button>
                            <div x-show="showDropdown" @click.away="showDropdown = false" x-cloak
                                class="absolute bottom-full left-0 right-0 mb-2 bg-white rounded-lg shadow-lg border border-gray-200 py-1">
                                <button @click="logout(); showDropdown = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-all duration-200">
                                    <i class="fas fa-sign-out-alt w-4 mr-2"></i> Logout
                                </button>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-auto h-screen relative">

            <!-- Dashboard Section -->
            <div x-show="currentRoute === 'dashboard'" class="section-bg"
                style="background-image: url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')">
                <div class="bg-overlay min-h-screen p-6 lg:p-8">
                    <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Welcome back, <span x-text="coach.name || 'Coach'"></span>!</h2>
                            <p class="text-sm text-gray-500">Here's what's happening with your team today.</p>
                        </div>
                        <div class="flex items-center space-x-2 mt-4 md:mt-0">
                            <button @click="currentRoute = 'training'; showTrainingModal = true"
                                class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none transition-all duration-200">
                                Create Session
                            </button>
                            <button @click="currentRoute = 'communication'"
                                class="px-4 py-2 text-sm font-semibold text-gray-700 bg-white rounded-lg shadow-sm border hover:bg-gray-50 focus:outline-none transition-all duration-200">
                                Team Message
                            </button>
                        </div>
                    </header>
                    <!-- Dashboard Cards -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-2 space-y-8">
                            <div class="p-6 bg-white rounded-lg shadow-sm border border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-800 border-b pb-4">Recent Training Plans</h3>
                                <div class="mt-4 space-y-4">
                                    <template x-if="trainingPlans.length === 0">
                                        <p class="text-gray-500 text-sm">No plans created yet.</p>
                                    </template>
                                    <template x-for="(plan, index) in trainingPlans.slice(0, 3)" :key="plan.id">
                                        <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all duration-200 cursor-pointer"
                                            @click="currentRoute = 'training'">
                                            <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                                                <i class="fas fa-clipboard-list"></i>
                                            </div>
                                            <div class="ml-4 flex-1">
                                                <p class="font-semibold text-gray-800" x-text="plan.subject"></p>
                                                <p class="text-sm text-gray-500">
                                                    <span x-text="plan.type"></span> • <span x-text="formatDate(plan.created_at)"></span>
                                                </p>
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
                                    <div class="flex flex-col items-center"><div class="flex items-center justify-center w-10 h-10 font-bold text-white bg-green-500 rounded-full">W</div><span class="text-xs mt-1 text-gray-500">3-1</span></div>
                                    <div class="flex flex-col items-center"><div class="flex items-center justify-center w-10 h-10 font-bold text-white bg-green-500 rounded-full">W</div><span class="text-xs mt-1 text-gray-500">2-0</span></div>
                                    <div class="flex flex-col items-center"><div class="flex items-center justify-center w-10 h-10 font-bold text-white bg-red-500 rounded-full">L</div><span class="text-xs mt-1 text-gray-500">0-1</span></div>
                                    <div class="flex flex-col items-center"><div class="flex items-center justify-center w-10 h-10 font-bold text-white bg-gray-400 rounded-full">D</div><span class="text-xs mt-1 text-gray-500">1-1</span></div>
                                    <div class="flex flex-col items-center"><div class="flex items-center justify-center w-10 h-10 font-bold text-white bg-green-500 rounded-full">W</div><span class="text-xs mt-1 text-gray-500">2-1</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Players Section -->
            <div x-show="currentRoute === 'players'" class="section-bg"
                style="background-image: url('https://images.unsplash.com/photo-1579952363873-27f3bade9f55?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80')">
                <div class="bg-overlay min-h-screen p-6 lg:p-8">
                    <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Player Management</h2>
                            <p class="text-sm text-gray-500">View and manage your squad players</p>
                        </div>
                    </header>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="relative w-full max-w-md">
                                <input type="text" placeholder="Search players..."
                                    class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <i class="fas fa-search text-gray-400 absolute left-3 top-3"></i>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <template x-for="player in players" :key="player.id">
                                <div class="border rounded-lg overflow-hidden hover:shadow-md transition-all duration-200 player-card bg-white">
                                    <div class="bg-gradient-to-r from-green-600 to-green-800 p-4 flex items-center">
                                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center overflow-hidden">
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
                                            <span class="font-medium truncate max-w-[150px]" x-text="player.email"></span>
                                        </div>
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
                                            <button @click="openEditPlayer(player)"
                                                class="flex-1 py-1.5 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700 transition-all duration-200">
                                                Edit
                                            </button>
                                            <button @click="openDirectMessage(player)"
                                                class="flex-1 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-all duration-200">
                                                Message
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Training Plans Section (UPDATED with Loading & Logic) -->
            <div x-show="currentRoute === 'training'" class="section-bg"
                style="background-image: url('https://images.unsplash.com/photo-1526232761682-d26e03ac148e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80')">
                <div class="bg-overlay min-h-screen p-6 lg:p-8">
                    <!-- Header -->
                    <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Training Planner</h2>
                            <p class="text-sm text-gray-500">Design sessions and assign them to your squad</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <button @click="showTrainingModal = true"
                                class="flex items-center px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-lg shadow-sm hover:bg-green-700 transition-all duration-200">
                                <i class="fas fa-plus mr-2"></i> Create New Plan
                            </button>
                        </div>
                    </header>

                    <!-- Content -->
                    <div class="space-y-6">
                        <!-- Loading State -->
                        <template x-if="isLoadingPlans">
                            <div class="text-center py-12">
                                <svg class="animate-spin h-8 w-8 text-green-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <p class="text-gray-500 mt-2">Loading training plans...</p>
                            </div>
                        </template>

                        <!-- Empty State -->
                        <template x-if="!isLoadingPlans && trainingPlans.length === 0">
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                                <i class="fas fa-clipboard-list text-4xl text-gray-300 mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900">No Training Plans Yet</h3>
                                <p class="text-gray-500 mt-1">Create your first training session to share with players.</p>
                            </div>
                        </template>

                        <!-- Plans Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-show="!isLoadingPlans && trainingPlans.length > 0">
                            <template x-for="plan in trainingPlans" :key="plan.id">
                                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-all duration-200 flex flex-col h-full">
                                    <!-- Card Header -->
                                    <div class="p-5 border-b border-gray-100">
                                        <div class="flex justify-between items-start mb-2">
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold"
                                                :class="{
                                                    'bg-blue-100 text-blue-800': plan.type === 'Technical',
                                                    'bg-purple-100 text-purple-800': plan.type === 'Tactical',
                                                    'bg-red-100 text-red-800': plan.type === 'Physical',
                                                    'bg-green-100 text-green-800': plan.type === 'Warm Up',
                                                    'bg-gray-100 text-gray-800': !['Technical','Tactical','Physical','Warm Up'].includes(plan.type)
                                                }" x-text="plan.type">
                                            </span>
                                            <span class="text-xs text-gray-400" x-text="formatDate(plan.created_at)"></span>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-800 line-clamp-1" x-text="plan.subject"></h3>
                                        <p class="text-xs text-gray-500 mt-1">Created by: <span x-text="plan.coach_name || 'You'"></span></p>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="p-5 flex-1">
                                        <p class="text-sm text-gray-600 line-clamp-4" x-text="plan.description"></p>
                                    </div>

                                    <!-- Card Footer -->
                                    <div class="p-4 bg-gray-50 rounded-b-lg border-t border-gray-100 flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <!-- Logic to show video type icon -->
                                            <template x-if="plan.video_url || plan.video_path">
                                                <a :href="plan.video_url || plan.video_path" target="_blank" class="flex items-center text-xs text-blue-600 hover:text-blue-800 font-medium">
                                                    <i class="fas fa-play-circle mr-1"></i>
                                                    <span x-text="plan.video_path ? 'Watch Uploaded Video' : 'Watch Link'"></span>
                                                </a>
                                            </template>
                                            <template x-if="!plan.video_url && !plan.video_path">
                                                <span class="text-xs text-gray-400 italic">No video attached</span>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Communication Section -->
            <div x-show="currentRoute === 'communication'" class="section-bg"
                style="background-image: url('https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?ixlib=rb-4.0.3&auto=format&fit=crop&w=1469&q=80')">
                <div class="bg-overlay min-h-screen p-6 lg:p-8">
                    <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Team Communication</h2>
                            <p class="text-sm text-gray-500">Chat with your players and staff</p>
                        </div>
                    </header>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex flex-col h-[calc(100vh-200px)]">
                        <!-- Chat Area -->
                        <div class="flex-1 overflow-y-auto pr-2 chat-scroll space-y-4">
                            <template x-if="messages.length === 0">
                                <div class="flex flex-col items-center justify-center h-full text-gray-400">
                                    <i class="far fa-comments text-4xl mb-2 opacity-50"></i>
                                    <p>No messages yet. Start the conversation!</p>
                                </div>
                            </template>
                            <template x-for="msg in messages" :key="msg.id">
                                <div class="flex items-start space-x-4 border-b border-gray-100 pb-4 last:border-0">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full bg-yellow-200 flex items-center justify-center text-yellow-800 font-bold text-sm">
                                            <span x-text="(msg.sender_id == coach.id || msg.sender_id == null) ? (coach.name || 'Coach').substring(0,2).toUpperCase() : (players.find(p => p.id == msg.sender_id)?.name || 'U').substring(0,2).toUpperCase()"></span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between mb-1">
                                            <h4 class="text-sm font-bold text-gray-900"
                                                x-text="(msg.sender_id == coach.id || msg.sender_id == null) ? (coach.name || 'Coach') : (players.find(p => p.id == msg.sender_id)?.name || 'Unknown User')">
                                            </h4>
                                            <span class="text-xs text-gray-400" x-text="formatDate(msg.created_at)"></span>
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

                        <!-- Footer Input -->
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="md:col-span-1">
                                    <select x-model="newMessage.recipient"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Select Recipient...</option>
                                        <option value="all">All Players</option>
                                        <optgroup label="Individual Players">
                                            <template x-for="p in players" :key="p.id">
                                                <option :value="p.id" x-text="p.email"></option>
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
                                            Send <i class="fas fa-paper-plane ml-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Other Sections -->
            <div x-show="currentRoute === 'analytics'" class="section-bg" style="background-image: url('https://images.unsplash.com/photo-1552667466-07770ae110d0?auto=format&fit=crop&w=1470&q=80')">
                <div class="bg-overlay min-h-screen p-6 lg:p-8"><h2 class="text-2xl font-bold">Video Analytics</h2></div>
            </div>
            <div x-show="currentRoute === 'calendar'" class="section-bg" style="background-image: url('https://images.unsplash.com/photo-1517649763962-0c623066013b?auto=format&fit=crop&w=1470&q=80')">
                <div class="bg-overlay min-h-screen p-6 lg:p-8"><h2 class="text-2xl font-bold">Calendar</h2></div>
            </div>
            <div x-show="currentRoute === 'stats'" class="section-bg" style="background-image: url('https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?auto=format&fit=crop&w=1605&q=80')">
                <div class="bg-overlay min-h-screen p-6 lg:p-8"><h2 class="text-2xl font-bold">Team Stats</h2></div>
            </div>
        </main>
    </div>

    <!-- MODALS -->

    <!-- Enhanced Training Modal (UPDATED with Video Toggle & Email Selection) -->
    <div x-show="showTrainingModal" x-cloak
        class="fixed inset-0 z-50 overflow-y-auto"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="showTrainingModal = false"></div>

        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-2xl transform overflow-hidden rounded-lg bg-white shadow-xl transition-all">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Create New Training Plan</h3>
                    <button @click="showTrainingModal = false" class="text-gray-400 hover:text-gray-500"><i class="fas fa-times text-xl"></i></button>
                </div>

                <div class="p-6">
                    <form @submit.prevent="createTrainingPlan()" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                                <input x-model="newTrainingPlan.subject" type="text" placeholder="e.g., Set Piece Drills"
                                    class="w-full rounded-md border-gray-300 border px-3 py-2 text-sm focus:border-green-500 focus:ring-green-500 outline-none" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Training Type</label>
                                <select x-model="newTrainingPlan.type" class="w-full rounded-md border-gray-300 border px-3 py-2 text-sm focus:border-green-500 focus:ring-green-500 outline-none" required>
                                    <option value="">Select Type</option>
                                    <option value="Warm Up">Warm Up</option>
                                    <option value="Technical">Technical</option>
                                    <option value="Tactical">Tactical</option>
                                    <option value="Physical">Physical</option>
                                    <option value="Recovery">Recovery</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea x-model="newTrainingPlan.description" placeholder="Detailed instructions..."
                                class="w-full rounded-md border-gray-300 border px-3 py-2 text-sm focus:border-green-500 focus:ring-green-500 outline-none h-24" required></textarea>
                        </div>

                        <!-- INTELLIGENT VIDEO UPLOAD OR LINK -->
                        <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Video Reference</label>

                            <!-- Toggle Switch -->
                            <div class="flex items-center mb-4">
                                <span class="text-sm mr-3" :class="videoUploadMode ? 'text-gray-500' : 'font-bold text-blue-700'">External Link</span>
                                <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                    <input type="checkbox" name="toggle" id="videoToggle" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" x-model="videoUploadMode"/>
                                    <label for="videoToggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                </div>
                                <span class="text-sm ml-1" :class="videoUploadMode ? 'font-bold text-blue-700' : 'text-gray-500'">Upload File</span>
                            </div>

                            <!-- Input 1: External Link -->
                            <div x-show="!videoUploadMode">
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-100 text-gray-500 text-sm">URL</span>
                                    <input x-model="newTrainingPlan.video_url" type="url" placeholder="https://youtube.com/..."
                                        class="w-full rounded-none rounded-r-md border-gray-300 border px-3 py-2 text-sm focus:border-green-500 focus:ring-green-500 outline-none">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Paste a link from YouTube, Vimeo, or Google Drive.</p>
                            </div>

                            <!-- Input 2: File Upload -->
                            <div x-show="videoUploadMode">
                                <input type="file" @change="handleFileChange($event)" accept="video/mp4,video/x-m4v,video/*"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="text-xs text-gray-500 mt-1">Supported formats: MP4, MOV (Max 50MB)</p>
                            </div>
                        </div>

                        <!-- ASSIGN BY EMAIL -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Assign Players (Select by Email)</label>
                            <div class="border rounded-md p-3 max-h-40 overflow-y-auto bg-gray-50">
                                <label class="flex items-center p-2 hover:bg-white rounded cursor-pointer mb-2 border-b border-gray-200 sticky top-0 bg-gray-50 z-10">
                                    <input type="checkbox" @change="toggleAllPlayers($event)" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded mr-2">
                                    <span class="font-bold text-sm text-gray-800">Select All</span>
                                </label>
                                <template x-for="player in players" :key="player.id">
                                    <label class="flex items-center p-1 hover:bg-white rounded cursor-pointer group">
                                        <input type="checkbox" :value="player.id" x-model="newTrainingPlan.assigned_players"
                                            class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded mr-2">
                                        <!-- Intelligent Display: Email Priority -->
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-700 group-hover:text-blue-700" x-text="player.email"></span>
                                            <span class="text-xs text-gray-400" x-text="player.name + ' (' + (player.position || 'N/A') + ')'"></span>
                                        </div>
                                    </label>
                                </template>
                            </div>
                            <p class="text-xs text-blue-600 mt-1" x-text="newTrainingPlan.assigned_players.length + ' players selected'"></p>
                        </div>

                        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                            <button type="button" @click="showTrainingModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Cancel</button>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">Create Plan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Player Modal -->
    <div x-show="showEditPlayerModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4" @click.away="showEditPlayerModal = false">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Edit Player</h3>
                    <button @click="showEditPlayerModal = false" class="text-gray-400 hover:text-gray-500"><i class="fas fa-times"></i></button>
                </div>
                <div class="space-y-4">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label><input type="text" x-model="editingPlayer.name" class="w-full px-3 py-2 border rounded-md"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Position</label>
                        <select x-model="editingPlayer.position" class="w-full px-3 py-2 border rounded-md">
                            <option value="Goalkeeper">Goalkeeper</option>
                            <option value="Defender">Defender</option>
                            <option value="Midfielder">Midfielder</option>
                            <option value="Forward">Forward</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button @click="showEditPlayerModal = false" class="px-4 py-2 border rounded-md">Cancel</button>
                    <button @click="updatePlayer()" class="px-4 py-2 bg-blue-600 text-white rounded-md">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Message Modal -->
    <div x-show="showMessageModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4" @click.away="showMessageModal = false">
            <div class="p-6">
                <h3 class="text-xl font-bold mb-4">New Message</h3>
                <div class="space-y-4">
                    <div class="text-sm text-gray-500">To: <span class="font-bold text-gray-800" x-text="players.find(p => p.id === newMessage.recipient)?.email || 'Unknown'"></span></div>
                    <input type="text" x-model="newMessage.subject" placeholder="Subject" class="w-full border rounded p-2">
                    <textarea x-model="newMessage.content" placeholder="Content..." class="w-full border rounded p-2" rows="4"></textarea>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button @click="showMessageModal = false" class="px-4 py-2 border rounded">Cancel</button>
                    <button @click="sendMessage()" class="px-4 py-2 bg-blue-600 text-white rounded">Send</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const API_URL = '/api';
        const getHeaders = (isMultipart = false) => {
            const headers = {
                'Authorization': 'Bearer ' + localStorage.getItem('api_token')
            };
            // Do NOT set Content-Type for FormData; browser does it automatically with boundaries
            if (!isMultipart) {
                headers['Content-Type'] = 'application/json';
                headers['Accept'] = 'application/json';
            }
            return headers;
        };

        document.addEventListener('alpine:init', () => {
            Alpine.data('coachDashboard', () => ({
                currentRoute: 'dashboard',
                showTrainingModal: false,
                showMessageModal: false,
                showEditPlayerModal: false,
                isLoadingPlans: false,
                videoUploadMode: false, // Toggle state

                // Data
                coach: {},
                players: [],
                messages: [],
                trainingPlans: [],

                // Forms
                newTrainingPlan: {
                    subject: '',
                    type: '',
                    description: '',
                    video_url: '',
                    video_file: null, // Holds the raw file
                    assigned_players: []
                },
                newMessage: { recipient: '', subject: '', content: '' },
                editingPlayer: { id: null, name: '', position: '' },

                init() {
                    const hash = window.location.hash.substring(1) || 'dashboard';
                    this.currentRoute = hash;
                    this.fetchCoach();
                    this.fetchPlayers();
                    this.fetchMessages();
                    this.fetchTrainingPlans();
                    window.addEventListener('hashchange', () => this.currentRoute = window.location.hash.substring(1));
                },

                formatDate(dateString) {
                    if (!dateString) return '';
                    return new Date(dateString).toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' });
                },

                // --- DATA FETCHING ---
                async fetchCoach() {
                    try {
                        const res = await fetch(`${API_URL}/user`, { headers: getHeaders() });
                        const data = await res.json();
                        this.coach = data.user || data;
                    } catch (e) { console.error(e); }
                },

                async fetchPlayers() {
                    try {
                        // Backend already filters by role=player based on your previous code
                        const res = await fetch(`${API_URL}/users?role=player`, { headers: getHeaders() });
                        const data = await res.json();
                        this.players = data.data || [];
                    } catch (e) { console.error(e); }
                },

                async fetchMessages() {
                    try {
                        const res = await fetch(`${API_URL}/messages`, { headers: getHeaders() });
                        const data = await res.json();
                        this.messages = data.data || [];
                    } catch (e) { console.error(e); }
                },

                async fetchTrainingPlans() {
                    this.isLoadingPlans = true;
                    try {
                        const res = await fetch(`${API_URL}/training-plans`, { headers: getHeaders() });
                        const data = await res.json();
                        this.trainingPlans = data.data || [];
                    } catch (e) { console.error(e); }
                    finally { this.isLoadingPlans = false; }
                },

                // --- SMART FILE HANDLING ---
                handleFileChange(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.newTrainingPlan.video_file = file;
                    }
                },

                toggleAllPlayers(event) {
                    if (event.target.checked) {
                        this.newTrainingPlan.assigned_players = this.players.map(p => p.id);
                    } else {
                        this.newTrainingPlan.assigned_players = [];
                    }
                },

                // --- CREATE ACTION WITH FORMDATA ---
                async createTrainingPlan() {
                    try {
                        if (this.newTrainingPlan.assigned_players.length === 0) {
                            alert('Please select at least one player (by email).');
                            return;
                        }

                        // Use FormData to handle file uploads + text data
                        const formData = new FormData();
                        formData.append('subject', this.newTrainingPlan.subject);
                        formData.append('type', this.newTrainingPlan.type);
                        formData.append('description', this.newTrainingPlan.description);

                        // Handle Video Logic
                        if (this.videoUploadMode && this.newTrainingPlan.video_file) {
                            formData.append('video_file', this.newTrainingPlan.video_file);
                        } else if (!this.videoUploadMode && this.newTrainingPlan.video_url) {
                            formData.append('video_url', this.newTrainingPlan.video_url);
                        }

                        // Handle Array in FormData
                        this.newTrainingPlan.assigned_players.forEach((id, index) => {
                            formData.append(`assigned_players[${index}]`, id);
                        });

                        const res = await fetch(`${API_URL}/training-plans`, {
                            method: 'POST',
                            headers: getHeaders(true), // Pass true to omit Content-Type (browser sets multipart)
                            body: formData
                        });

                        if (res.ok) {
                            alert('Training plan created successfully!');
                            this.showTrainingModal = false;
                            this.newTrainingPlan = { subject: '', type: '', description: '', video_url: '', video_file: null, assigned_players: [] };
                            this.fetchTrainingPlans();
                        } else {
                            const err = await res.json();
                            alert('Failed to create: ' + (err.message || 'Unknown error'));
                        }
                    } catch (e) {
                        console.error(e);
                        alert('Network error occurred');
                    }
                },

                // --- OTHER ACTIONS ---
                async sendMessage() {
                    /* Existing logic */
                    if (!this.newMessage.recipient || !this.newMessage.content) return alert('Fill all fields');
                    const payload = { sender_id: this.coach.id, recipient_group: this.newMessage.recipient, subject: this.newMessage.subject, content: this.newMessage.content };
                    await fetch(`${API_URL}/messages`, { method: 'POST', headers: getHeaders(), body: JSON.stringify(payload) });
                    this.showMessageModal = false; this.newMessage = {recipient:'',subject:'',content:''}; this.fetchMessages();
                },
                openDirectMessage(player) {
                    this.newMessage.recipient = player.id; this.newMessage.subject = `Msg: ${player.email}`; this.showMessageModal = true;
                },
                openEditPlayer(p) { this.editingPlayer = {...p}; this.showEditPlayerModal = true; },
                async updatePlayer() {
                     await fetch(`${API_URL}/admin/update/${this.editingPlayer.id}`, { method: 'PUT', headers: getHeaders(), body: JSON.stringify({name:this.editingPlayer.name, position:this.editingPlayer.position}) });
                     this.showEditPlayerModal = false; this.fetchPlayers();
                },
                async logout() { localStorage.removeItem('api_token'); window.location.href = '/'; }
            }));
        });
    </script>
</body>
</html>
