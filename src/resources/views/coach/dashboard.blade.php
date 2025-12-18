<!DOCTYPE html>
<html lang="en" class="antialiased">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coach Dashboard - Mwatate FC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        
        .section-bg { background-size: cover; background-position: center; background-repeat: no-repeat; }
        .bg-overlay { background-color: rgba(255, 255, 255, 0.95); }
        
        /* Custom Scrollbar */
        .custom-scroll::-webkit-scrollbar { width: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .custom-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        [x-cloak] { display: none !important; }

        /* Toggle Switch */
        .toggle-checkbox:checked { right: 0; border-color: #2563eb; }
        .toggle-checkbox:checked + .toggle-label { background-color: #2563eb; }
        
        /* Clean Calendar */
        .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); border-top: 1px solid #e2e8f0; border-left: 1px solid #e2e8f0; }
        .calendar-cell { min-height: 120px; background-color: white; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; padding: 0.5rem; transition: background-color 0.2s; }
        .calendar-cell:hover { background-color: #f8fafc; }
    </style>
</head>

<body x-data="coachDashboard" class="bg-slate-50 text-slate-800">
    <div class="flex min-h-screen">
        
        <!-- Sidebar -->
        <aside class="w-64 flex-shrink-0 bg-white shadow-lg z-20 border-r border-slate-200">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="h-16 flex items-center justify-center border-b border-slate-100">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white">
                            <i class="fas fa-futbol"></i>
                        </div>
                        <span class="text-lg font-bold text-slate-800">Mwatate FC</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="flex-1 px-3 py-4 space-y-1">
                    <template x-for="item in navItems">
                        <a :href="'#' + item.id" @click="currentRoute = item.id"
                            :class="currentRoute === item.id ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                            class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 cursor-pointer group">
                            <i :class="item.icon + ' w-5 mr-3 text-center transition-colors group-hover:text-blue-500'" 
                               :class="currentRoute === item.id ? 'text-blue-600' : 'text-slate-400'"></i> 
                            <span x-text="item.label"></span>
                        </a>
                    </template>
                </nav>
                
                <!-- Profile Footer -->
                <div class="border-t border-slate-100 p-4" x-data="{ showDropdown: false }">
                    <div class="relative">
                        <button @click="showDropdown = !showDropdown"
                            class="flex items-center w-full p-2 rounded-lg hover:bg-slate-50 transition-colors">
                            <img class="w-8 h-8 rounded-full mr-3 object-cover"
                                :src="`https://ui-avatars.com/api/?name=${coach.name || 'Coach'}&background=random`"
                                alt="Avatar">
                            <div class="flex-1 text-left overflow-hidden">
                                <p class="text-sm font-semibold text-slate-700 truncate" x-text="coach.name || 'Coach'"></p>
                                <p class="text-xs text-slate-500 truncate">Head Coach</p>
                            </div>
                            <i class="fas fa-chevron-up w-3 text-slate-400"></i>
                        </button>
                        
                        <div x-show="showDropdown" @click.away="showDropdown = false" x-cloak
                            class="absolute bottom-full left-0 right-0 mb-2 bg-white rounded-lg shadow-xl border border-slate-100 py-1">
                            <button @click="logout()"
                                class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <i class="fas fa-sign-out-alt w-4 mr-2"></i> Logout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-auto h-screen relative bg-slate-50/50">

            <!-- 1. DASHBOARD -->
            <div x-show="currentRoute === 'dashboard'" class="section-bg" style="background-image: url('https://images.unsplash.com/photo-1522778119026-d647f0565c6a?auto=format&fit=crop&w=1470&q=80')">
                <div class="bg-overlay min-h-screen p-8">
                    <header class="flex justify-between items-center mb-8">
                        <div>
                            <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
                            <p class="text-sm text-slate-500 mt-1">Welcome back, Coach.</p>
                        </div>
                        <button @click="currentRoute = 'training'; showTrainingModal = true" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition flex items-center">
                            <i class="fas fa-plus mr-2"></i> Quick Session
                        </button>
                    </header>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <!-- Stats Cards -->
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-slate-500 uppercase">Squad Size</p>
                                    <h3 class="text-2xl font-bold text-slate-800 mt-1" x-text="players.length"></h3>
                                </div>
                                <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center text-blue-600">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-slate-500 uppercase">Training Plans</p>
                                    <h3 class="text-2xl font-bold text-slate-800 mt-1" x-text="trainingPlans.length"></h3>
                                </div>
                                <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center text-green-600">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-slate-500 uppercase">Next Match</p>
                                    <template x-if="nextMatch">
                                        <h3 class="text-lg font-bold text-slate-800 mt-1 truncate w-32" x-text="'vs ' + nextMatch.opponent"></h3>
                                    </template>
                                    <template x-if="!nextMatch">
                                        <h3 class="text-lg font-bold text-slate-400 mt-1">No Games</h3>
                                    </template>
                                </div>
                                <div class="w-10 h-10 bg-orange-50 rounded-full flex items-center justify-center text-orange-600">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-slate-500 uppercase">Messages</p>
                                    <h3 class="text-2xl font-bold text-slate-800 mt-1" x-text="messages.length"></h3>
                                </div>
                                <div class="w-10 h-10 bg-purple-50 rounded-full flex items-center justify-center text-purple-600">
                                    <i class="fas fa-comment-dots"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. PLAYERS -->
            <div x-show="currentRoute === 'players'" class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-slate-800">Player Management</h2>
                    <button @click="openAddPlayerModal()" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition">
                        <i class="fas fa-user-plus mr-2"></i> Add Player
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <template x-for="player in players" :key="player.id">
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-shadow">
                            <div class="p-5 flex items-center space-x-4">
                                <img :src="`https://ui-avatars.com/api/?name=${player.name}&background=random`" class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-sm">
                                <div>
                                    <h3 class="font-bold text-slate-800" x-text="player.name"></h3>
                                    <p class="text-sm text-slate-500" x-text="player.email"></p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 mt-2" x-text="player.position || 'Player'"></span>
                                </div>
                            </div>
                            <div class="bg-slate-50 px-5 py-3 border-t border-slate-100 flex gap-2">
                                <button @click="openDirectMessage(player)" 
                                    class="flex-1 text-xs font-medium text-slate-600 bg-white border border-slate-200 py-2 rounded hover:bg-slate-50 transition">
                                    <i class="fas fa-comment mr-1"></i> Message
                                </button>
                                <button @click="openEditPlayer(player)" 
                                    class="flex-1 text-xs font-medium text-blue-600 bg-white border border-slate-200 py-2 rounded hover:bg-blue-50 transition">
                                    Edit
                                </button>
                                <button @click="deletePlayer(player.id)" 
                                    class="px-3 text-xs font-medium text-red-600 bg-white border border-slate-200 py-2 rounded hover:bg-red-50 transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- 3. TRAINING & ANALYTICS (CONSOLIDATED UI) -->
            <div x-show="currentRoute === 'training' || currentRoute === 'analytics'" class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800">Training & Analysis</h2>
                        <p class="text-sm text-slate-500">Manage drills, physical sessions, and video reviews.</p>
                    </div>
                    <button @click="showTrainingModal = true" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition">
                        <i class="fas fa-plus mr-2"></i> Create Plan
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Filter plans based on route context if needed, currently showing all -->
                    <template x-for="plan in trainingPlans" :key="plan.id">
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:border-blue-300 transition-colors">
                            <div class="flex justify-between items-start mb-3">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600" x-text="plan.type"></span>
                                <span class="text-xs text-slate-400" x-text="formatDate(plan.created_at)"></span>
                            </div>
                            <h3 class="font-bold text-slate-800 mb-2" x-text="plan.subject"></h3>
                            <p class="text-sm text-slate-600 mb-4 line-clamp-3" x-text="plan.description"></p>
                            
                            <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                                <template x-if="plan.video_url || plan.video_path">
                                    <a :href="plan.video_url || plan.video_path" target="_blank" class="flex items-center text-xs font-medium text-blue-600 hover:text-blue-700">
                                        <i class="fas fa-play-circle mr-1.5"></i> Watch Media
                                    </a>
                                </template>
                                <template x-if="!plan.video_url && !plan.video_path">
                                    <span class="text-xs text-slate-400 italic">No media attached</span>
                                </template>
                                <span class="text-xs text-slate-500" x-text="(plan.assigned_players?.length || 0) + ' Assigned'"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- 4. CALENDAR -->
            <div x-show="currentRoute === 'calendar'" class="p-8 h-full flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-slate-800">Fixture Calendar</h2>
                    <div class="flex space-x-2 bg-white rounded-lg shadow-sm border border-slate-200 p-1">
                        <button @click="changeMonth(-1)" class="p-2 hover:bg-slate-50 rounded text-slate-600"><i class="fas fa-chevron-left"></i></button>
                        <span class="px-4 py-2 font-semibold text-slate-700 min-w-[140px] text-center" x-text="calendar.monthNames[calendar.month] + ' ' + calendar.year"></span>
                        <button @click="changeMonth(1)" class="p-2 hover:bg-slate-50 rounded text-slate-600"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 flex-1 flex flex-col overflow-hidden">
                    <div class="grid grid-cols-7 border-b border-slate-200 bg-slate-50">
                        <template x-for="day in ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']">
                            <div class="py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider" x-text="day"></div>
                        </template>
                    </div>
                    <div class="calendar-grid flex-1">
                        <template x-for="blank in calendar.blankDays"><div class="bg-slate-50/50 border-r border-b border-slate-100"></div></template>
                        <template x-for="date in calendar.daysInMonth" :key="date">
                            <div class="calendar-cell relative">
                                <span class="text-sm font-medium text-slate-700" x-text="date"></span>
                                <div class="mt-2 space-y-1">
                                    <template x-for="fixture in getFixturesForDate(date)">
                                        <div @click="openEditFixture(fixture)" 
                                             class="cursor-pointer text-xs p-1.5 rounded border-l-4 truncate hover:opacity-80 transition"
                                             :class="fixture.venue === 'Home' ? 'bg-green-50 border-green-500 text-green-700' : 'bg-orange-50 border-orange-500 text-orange-700'">
                                            <div class="font-bold truncate" x-text="fixture.opponent"></div>
                                            <div class="flex justify-between mt-0.5 text-[10px] opacity-75">
                                                <span x-text="formatTime(fixture.match_date)"></span>
                                                <span x-show="fixture.status !== 'scheduled'" x-text="fixture.home_score + '-' + fixture.away_score"></span>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- 5. COMMUNICATION (FIXED) -->
            <div x-show="currentRoute === 'communication'" class="p-8 h-full flex flex-col">
                <h2 class="text-2xl font-bold text-slate-800 mb-6">Team Communication</h2>
                
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 flex flex-col flex-1 overflow-hidden">
                    <!-- Chat Messages -->
                    <div class="flex-1 overflow-y-auto p-6 custom-scroll space-y-6">
                        <template x-if="messages.length === 0">
                            <div class="h-full flex flex-col items-center justify-center text-slate-400">
                                <i class="far fa-comments text-4xl mb-3"></i>
                                <p>No messages yet.</p>
                            </div>
                        </template>
                 <template x-for="msg in messages" :key="msg.id">
                            <div class="flex flex-col">
                                <div class="flex items-baseline justify-between mb-1">
                                    <span class="font-semibold text-sm text-slate-900" 
                                          x-text="(msg.sender_id == coach.id) ? coach.email : (players.find(p => p.id == msg.sender_id)?.email || 'Unknown')">
                                    </span>
                                    <span class="text-xs text-slate-400" x-text="formatDate(msg.created_at)"></span>
                                </div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs text-slate-500" x-text="getRecipientText(msg)"></span>
                                </div>
                                <div class="bg-slate-50 p-4 rounded-lg rounded-tl-none border border-slate-100 text-sm text-slate-700">
                                    <div x-show="msg.subject" class="font-semibold text-blue-600 mb-1 text-xs uppercase" x-text="msg.subject"></div>
                                    <p x-text="msg.content"></p>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Input Area -->
                    <div class="p-4 bg-slate-50 border-t border-slate-200">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                            <!-- RECIPIENT SELECTOR -->
                            <div class="md:col-span-1">
                                <select x-model="newMessage.recipient" class="w-full text-sm border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="" disabled>Select Recipient...</option>
                                    <option value="all">All Players</option>
                                    <optgroup label="Individual Players">
                                        <template x-for="p in players" :key="p.id">
                                            <option :value="p.id" x-text="p.name"></option>
                                        </template>
                                    </optgroup>
                                </select>
                            </div>
                            <div class="md:col-span-3">
                                <input x-model="newMessage.subject" type="text" placeholder="Subject (Optional)" class="w-full text-sm border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <textarea x-model="newMessage.content" placeholder="Type your message here..." rows="2" class="flex-1 text-sm border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
                            <button @click="sendMessage()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-medium shadow-sm transition self-end">
                                Send
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 6. STATS -->
            <div x-show="currentRoute === 'stats'" class="p-8">
                <h2 class="text-2xl font-bold text-slate-800 mb-6">Team Statistics</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
                        <div class="text-3xl font-bold text-slate-800" x-text="stats.wins"></div>
                        <div class="text-sm text-slate-500 uppercase tracking-wide font-medium">Wins</div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-slate-400">
                        <div class="text-3xl font-bold text-slate-800" x-text="stats.draws"></div>
                        <div class="text-sm text-slate-500 uppercase tracking-wide font-medium">Draws</div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-red-500">
                        <div class="text-3xl font-bold text-slate-800" x-text="stats.losses"></div>
                        <div class="text-sm text-slate-500 uppercase tracking-wide font-medium">Losses</div>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                    <h3 class="font-bold text-slate-800 mb-4">Player Positions</h3>
                    <div class="space-y-4">
                        <template x-for="pos in ['Goalkeeper', 'Defender', 'Midfielder', 'Forward']">
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-medium text-slate-700" x-text="pos"></span>
                                    <span class="text-slate-500" x-text="getPositionCount(pos)"></span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" :style="`width: ${(getPositionCount(pos) / (players.length || 1)) * 100}%`"></div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- MODAL: ADD/EDIT PLAYER -->
    <div x-show="showPlayerModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" 
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="showPlayerModal = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-md bg-white rounded-xl shadow-2xl p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4" x-text="playerForm.id ? 'Edit Player' : 'Add New Player'"></h3>
                <form @submit.prevent="savePlayer()" class="space-y-4">
                    <input type="hidden" x-model="playerForm.role" value="player">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                        <input x-model="playerForm.name" type="text" class="w-full border-slate-300 rounded-lg text-sm focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                        <input x-model="playerForm.email" type="email" class="w-full border-slate-300 rounded-lg text-sm focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Position</label>
                        <select x-model="playerForm.position" class="w-full border-slate-300 rounded-lg text-sm focus:ring-blue-500">
                            <option value="">Select Position</option>
                            <option value="Goalkeeper">Goalkeeper</option>
                            <option value="Defender">Defender</option>
                            <option value="Midfielder">Midfielder</option>
                            <option value="Forward">Forward</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1" x-text="playerForm.id ? 'New Password (Optional)' : 'Password'">Password</label>
                        <input x-model="playerForm.password" type="password" class="w-full border-slate-300 rounded-lg text-sm focus:ring-blue-500" :required="!playerForm.id">
                    </div>
                    <div class="flex justify-end gap-2 mt-6">
                        <button type="button" @click="showPlayerModal = false" class="px-4 py-2 text-sm text-slate-600 hover:bg-slate-100 rounded-lg">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save Player</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: TRAINING PLAN -->
    <div x-show="showTrainingModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" 
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="showTrainingModal = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-2xl bg-white rounded-xl shadow-2xl p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Create Session</h3>
                <form @submit.prevent="createTrainingPlan()" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Subject</label>
                            <input x-model="newTrainingPlan.subject" type="text" class="w-full border-slate-300 rounded-lg text-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Type</label>
                            <select x-model="newTrainingPlan.type" class="w-full border-slate-300 rounded-lg text-sm">
                                <option value="Warm Up">Warm Up</option>
                                <option value="Technical">Technical</option>
                                <option value="Tactical">Tactical</option>
                                <option value="Physical">Physical</option>
                                <option value="Video Analysis">Video Analysis</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                        <textarea x-model="newTrainingPlan.description" rows="3" class="w-full border-slate-300 rounded-lg text-sm" required></textarea>
                    </div>
                    
                    <!-- Media -->
                    <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                        <div class="flex items-center mb-3">
                            <span class="text-xs font-bold uppercase text-slate-500 mr-2">Attachment:</span>
                            <label class="inline-flex items-center cursor-pointer">
                                <span class="mr-2 text-sm" :class="!videoUploadMode ? 'text-blue-600 font-bold' : 'text-slate-500'">Link</span>
                                <div class="relative">
                                    <input type="checkbox" class="sr-only peer" @change="videoUploadMode = !videoUploadMode">
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                                </div>
                                <span class="ml-2 text-sm" :class="videoUploadMode ? 'text-blue-600 font-bold' : 'text-slate-500'">Upload</span>
                            </label>
                        </div>
                        <div x-show="!videoUploadMode">
                            <input x-model="newTrainingPlan.video_url" type="url" placeholder="Paste YouTube/Video URL" class="w-full border-slate-300 rounded-lg text-sm">
                        </div>
                        <div x-show="videoUploadMode">
                            <input type="file" @change="handleFileChange($event)" accept="video/*,image/*" class="w-full text-sm text-slate-500">
                        </div>
                    </div>

                    <!-- Players -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Assign To</label>
                        <div class="border border-slate-200 rounded-lg max-h-32 overflow-y-auto bg-slate-50 p-2">
                            <label class="flex items-center p-2 hover:bg-white rounded cursor-pointer border-b border-slate-100">
                                <input type="checkbox" @change="toggleAllPlayers($event)" class="rounded text-blue-600 mr-2">
                                <span class="text-sm font-bold text-slate-700">Select All Players</span>
                            </label>
                            <template x-for="player in players" :key="player.id">
                                <label class="flex items-center p-2 hover:bg-white rounded cursor-pointer">
                                    <input type="checkbox" :value="player.id" x-model="newTrainingPlan.assigned_players" class="rounded text-blue-600 mr-2">
                                    <span class="text-sm text-slate-600" x-text="player.name"></span>
                                </label>
                            </template>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="showTrainingModal = false" class="px-4 py-2 text-sm text-slate-600 hover:bg-slate-100 rounded-lg">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save Plan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: UPDATE FIXTURE -->
    <div x-show="showFixtureModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" 
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="showFixtureModal = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-sm bg-white rounded-xl shadow-2xl p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Update Match</h3>
                <form @submit.prevent="updateFixture()">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                        <select x-model="editingFixture.status" class="w-full border-slate-300 rounded-lg text-sm">
                            <option value="scheduled">Scheduled</option>
                            <option value="live">Live Now</option>
                            <option value="fulltime">Full Time</option>
                        </select>
                    </div>
                    <div x-show="editingFixture.status !== 'scheduled'" class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Home</label>
                            <input x-model="editingFixture.home_score" type="number" class="w-full border-slate-300 rounded-lg text-center font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Away</label>
                            <input x-model="editingFixture.away_score" type="number" class="w-full border-slate-300 rounded-lg text-center font-bold">
                        </div>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" @click="showFixtureModal = false" class="px-4 py-2 text-sm border rounded-lg hover:bg-slate-50">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const API_URL = '/api';

        const getHeaders = (isMultipart = false) => {
            const token = localStorage.getItem('api_token');
            if (!token) return {};
            const headers = { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' };
            if (!isMultipart) headers['Content-Type'] = 'application/json';
            return headers;
        };

        document.addEventListener('alpine:init', () => {
            Alpine.data('coachDashboard', () => ({
                currentRoute: 'dashboard',
                showTrainingModal: false,
                showFixtureModal: false,
                showPlayerModal: false,
                videoUploadMode: false,
                
                navItems: [
                    {id: 'dashboard', label: 'Dashboard', icon: 'fas fa-home'},
                    {id: 'players', label: 'Players', icon: 'fas fa-users'},
                    {id: 'training', label: 'Training & Analysis', icon: 'fas fa-clipboard-list'},
                    {id: 'calendar', label: 'Calendar', icon: 'fas fa-calendar-alt'},
                    {id: 'communication', label: 'Communication', icon: 'fas fa-comments'},
                    {id: 'stats', label: 'Team Stats', icon: 'fas fa-chart-bar'}
                ],

                // Data
                coach: {},
                players: [],
                trainingPlans: [],
                messages: [],
                fixtures: [],

                // Calendar State
                calendar: {
                    year: new Date().getFullYear(),
                    month: new Date().getMonth(),
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    daysInMonth: [],
                    blankDays: []
                },

                // Forms
                playerForm: { id: null, name: '', email: '', password: '', role: 'player', position: '' },
                newTrainingPlan: { subject: '', type: 'Technical', description: '', video_url: '', video_file: null, assigned_players: [] },
                newMessage: { recipient: '', subject: '', content: '' },
                editingFixture: { id: null, status: 'scheduled', home_score: 0, away_score: 0 },

                init() {
                    if (!localStorage.getItem('api_token')) window.location.href = '/';
                    this.currentRoute = window.location.hash.substring(1) || 'dashboard';
                    
                    this.fetchData();
                    this.generateCalendar();
                    window.addEventListener('hashchange', () => this.currentRoute = window.location.hash.substring(1));
                },

                async fetchData() {
                    await this.fetchCoach();
                    await this.fetchPlayers();
                    await this.fetchTrainingPlans();
                    await this.fetchMessages();
                    await this.fetchFixtures();
                },

                // API Calls
                async fetchCoach() { try { const r = await fetch(`${API_URL}/user`, { headers: getHeaders() }); this.coach = (await r.json()).user; } catch(e){} },
                async fetchPlayers() { try { const r = await fetch(`${API_URL}/users?role=player`, { headers: getHeaders() }); this.players = (await r.json()).data || []; } catch(e){} },
                async fetchTrainingPlans() { try { const r = await fetch(`${API_URL}/training-plans`, { headers: getHeaders() }); this.trainingPlans = (await r.json()).data || []; } catch(e){} },
                async fetchMessages() { try { const r = await fetch(`${API_URL}/messages`, { headers: getHeaders() }); this.messages = (await r.json()).data || []; } catch(e){} },
                async fetchFixtures() { try { const r = await fetch(`${API_URL}/fixtures`, { headers: getHeaders() }); this.fixtures = (await r.json()).data || []; } catch(e){} },
                     getRecipientText(msg) {
                    if (msg.recipient_group === 'all') {
                        return 'To: All Players';
                    } else if (msg.recipient_group) {
                        const player = this.players.find(p => p.id == msg.recipient_group);
                        return 'To: ' + (player ? player.name : 'Unknown Player');
                    }
                    return '';
                },

                // --- PLAYER MANAGEMENT ---
                openAddPlayerModal() {
                    this.playerForm = { id: null, name: '', email: '', password: '', role: 'player', position: '' };
                    this.showPlayerModal = true;
                },
                openEditPlayer(p) {
                    this.playerForm = { id: p.id, name: p.name, email: p.email, password: '', role: 'player', position: p.position };
                    this.showPlayerModal = true;
                },
                async savePlayer() {
                    const url = this.playerForm.id ? `${API_URL}/admin/update/${this.playerForm.id}` : `${API_URL}/admin/register`;
                    const method = this.playerForm.id ? 'PUT' : 'POST';
                    
                    // Filter empty password on update
                    const payload = {...this.playerForm};
                    if(this.playerForm.id && !this.playerForm.password) delete payload.password;

                    try {
                        const res = await fetch(url, {
                            method: method,
                            headers: getHeaders(),
                            body: JSON.stringify(payload)
                        });
                        if (res.ok) {
                            alert('Player saved!');
                            this.showPlayerModal = false;
                            this.fetchPlayers();
                        } else {
                            const err = await res.json();
                            alert('Error: ' + (err.message || 'Check inputs'));
                        }
                    } catch (e) { alert('Network error'); }
                },
                async deletePlayer(id) {
                    if (!confirm('Are you sure?')) return;
                    await fetch(`${API_URL}/admin/delete/${id}`, { method: 'DELETE', headers: getHeaders() });
                    this.fetchPlayers();
                },

                // --- MESSAGING ---
                openDirectMessage(player) {
                    this.currentRoute = 'communication'; // Switch tab
                    this.newMessage.recipient = player.id; // Auto-select player
                    this.newMessage.subject = `Message for ${player.name}`;
                },
                async sendMessage() {
                    if (!this.newMessage.recipient || !this.newMessage.content) return alert('Select recipient and type message');
                    try {
                        await fetch(`${API_URL}/messages`, {
                            method: 'POST',
                            headers: getHeaders(),
                            body: JSON.stringify({
                                sender_id: this.coach.id,
                                recipient: this.newMessage.recipient,
                                subject: this.newMessage.subject || 'General',
                                content: this.newMessage.content
                            })
                        });
                        this.newMessage.content = '';
                        this.fetchMessages();
                    } catch (e) { alert('Failed to send'); }
                },

                // --- TRAINING ---
                handleFileChange(e) { this.newTrainingPlan.video_file = e.target.files[0]; },
                toggleAllPlayers(e) { this.newTrainingPlan.assigned_players = e.target.checked ? this.players.map(p => p.id) : []; },
                async createTrainingPlan() {
                    const fd = new FormData();
                    fd.append('subject', this.newTrainingPlan.subject);
                    fd.append('type', this.newTrainingPlan.type);
                    fd.append('description', this.newTrainingPlan.description);
                    
                    if (this.videoUploadMode && this.newTrainingPlan.video_file) {
                        fd.append('video_file', this.newTrainingPlan.video_file);
                        fd.append('video_url', ''); 
                    } else {
                        fd.append('video_url', this.newTrainingPlan.video_url || ''); 
                    }
                    this.newTrainingPlan.assigned_players.forEach((id, i) => fd.append(`assigned_players[${i}]`, id));

                    try {
                        const res = await fetch(`${API_URL}/training-plans`, { method: 'POST', headers: getHeaders(true), body: fd });
                        if(res.ok) { 
                            alert('Created!'); 
                            this.showTrainingModal = false; 
                            this.newTrainingPlan = { subject:'', type:'Technical', description:'', video_url:'', video_file:null, assigned_players:[] };
                            this.fetchTrainingPlans(); 
                        }
                    } catch(e) { alert('Error creating plan'); }
                },

                // --- CALENDAR & STATS HELPER ---
              get nextMatch() {
    const now = new Date();
    const futureFixtures = this.fixtures.filter(f => new Date(f.match_date) >= now);
    if (futureFixtures.length > 0) {
        return futureFixtures.sort((a, b) => new Date(a.match_date) - new Date(b.match_date))[0];
    }
    // Fallback: Show the most recent past match if no future ones exist
    return this.fixtures.filter(f => f.status === 'scheduled').sort((a, b) => new Date(b.match_date) - new Date(a.match_date))[0];
},
                generateCalendar() {
                    const firstDay = new Date(this.calendar.year, this.calendar.month, 1).getDay();
                    const days = new Date(this.calendar.year, this.calendar.month + 1, 0).getDate();
                    this.calendar.blankDays = Array.from({length: firstDay}, (_,i) => i);
                    this.calendar.daysInMonth = Array.from({length: days}, (_,i) => i + 1);
                },
                changeMonth(off) {
                    let m = this.calendar.month + off;
                    if(m < 0) { this.calendar.month = 11; this.calendar.year--; }
                    else if(m > 11) { this.calendar.month = 0; this.calendar.year++; }
                    else this.calendar.month = m;
                    this.generateCalendar();
                },
                getFixturesForDate(d) {
                    const m = String(this.calendar.month + 1).padStart(2, '0');
                    const day = String(d).padStart(2, '0');
                    return this.fixtures.filter(f => f.match_date.startsWith(`${this.calendar.year}-${m}-${day}`));
                },
                openEditFixture(f) { this.editingFixture = {...f}; this.showFixtureModal = true; },
                async updateFixture() {
                    await fetch(`${API_URL}/admin/fixtures/${this.editingFixture.id}`, {
                        method: 'PUT', headers: getHeaders(),
                        body: JSON.stringify({ status: this.editingFixture.status, home_score: this.editingFixture.home_score, away_score: this.editingFixture.away_score })
                    });
                    this.showFixtureModal = false;
                    this.fetchFixtures();
                },
                formatDate(d) { return new Date(d).toLocaleDateString(); },
                formatTime(d) { return new Date(d).toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'}); },
                getPositionCount(pos) { return this.players.filter(p => p.position === pos).length; },
                get stats() {
                    const finished = this.fixtures.filter(f => f.status === 'fulltime');
                    let wins = 0, draws = 0, losses = 0;
                    finished.forEach(f => {
                        const isHome = f.venue === 'Home';
                        const my = isHome ? f.home_score : f.away_score;
                        const opp = isHome ? f.away_score : f.home_score;
                        if(my > opp) wins++; else if(my == opp) draws++; else losses++;
                    });
                    return { wins, draws, losses };
                },
                async logout() { localStorage.removeItem('api_token'); window.location.href = '/'; }
            }));
        });
    </script>
</body>
</html>