<!DOCTYPE html>
<html lang="en" class="antialiased">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Dashboard - Mwatate FC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        [x-cloak] { display: none !important; }
        .chat-scroll::-webkit-scrollbar { width: 6px; }
        .chat-scroll::-webkit-scrollbar-track { background: #f1f1f1; }
        .chat-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .chat-bg { background-image: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png'); opacity: 0.1; }
    </style>
</head>

<body x-data="playerDashboard" x-cloak class="bg-gray-50 h-screen overflow-hidden flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white shadow-xl flex flex-col z-20">
        <div class="h-16 flex items-center justify-center border-b border-gray-100 bg-blue-700">
            <div class="flex items-center gap-2 text-white">
                <i class="fas fa-futbol text-xl"></i>
                <span class="text-lg font-bold">Mwatate FC</span>
            </div>
        </div>

        <nav class="flex-1 py-4 space-y-1 overflow-y-auto">
            <template x-for="item in navItems">
                <a href="#" @click.prevent="currentRoute = item.id"
                   :class="currentRoute === item.id ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50'"
                   class="flex items-center px-6 py-3 text-sm font-medium transition-colors">
                    <i :class="item.icon" class="w-5 mr-3"></i>
                    <span x-text="item.label"></span>
                </a>
            </template>
        </nav>

        <div class="p-4 border-t border-gray-100">
            <button @click="logout" class="flex items-center w-full px-4 py-2 text-sm text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </button>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 overflow-y-auto relative scroll-smooth">

        <!-- HEADER -->
        <header class="bg-white border-b border-gray-200 sticky top-0 z-10 px-8 py-4 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800" x-text="pageTitle"></h2>
                <p class="text-sm text-gray-500">Player Portal</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-gray-800" x-text="user.name || 'Player'"></p>
                    <p class="text-xs text-green-600">Online</p>
                </div>
                <img :src="`https://ui-avatars.com/api/?name=${user.name || 'Player'}&background=1d4ed8&color=fff`" class="w-10 h-10 rounded-full border-2 border-blue-100">
            </div>
        </header>

        <div class="p-8 max-w-7xl mx-auto min-h-full">

            <!-- 1. DASHBOARD OVERVIEW -->
            <div x-show="currentRoute === 'dashboard'" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Next Match Card -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10"><i class="fas fa-trophy text-6xl text-blue-600"></i></div>
                        <h3 class="text-gray-500 text-sm font-medium uppercase">Next Match</h3>
                        <template x-if="nextMatch">
                            <div class="mt-4">
                                <p class="text-2xl font-bold text-gray-800" x-text="'vs ' + nextMatch.opponent"></p>
                                <p class="text-blue-600 font-medium mt-1">
                                    <i class="far fa-calendar mr-1"></i> <span x-text="formatDate(nextMatch.match_date)"></span>
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-map-marker-alt mr-1"></i> <span x-text="nextMatch.venue"></span>
                                </p>
                            </div>
                        </template>
                        <template x-if="!nextMatch">
                            <p class="mt-4 text-gray-500 italic">No upcoming matches scheduled.</p>
                        </template>
                    </div>

                    <!-- Next Training Card -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10"><i class="fas fa-running text-6xl text-green-600"></i></div>
                        <h3 class="text-gray-500 text-sm font-medium uppercase">Next Training</h3>
                        <template x-if="nextTraining">
                            <div class="mt-4">
                                <p class="text-2xl font-bold text-gray-800" x-text="nextTraining.type"></p>
                                <p class="text-green-600 font-medium mt-1">
                                    <i class="far fa-clock mr-1"></i> <span x-text="nextTraining.time"></span>
                                    <span class="mx-2">•</span>
                                    <span x-text="nextTraining.location"></span>
                                </p>
                                <p class="text-xs text-gray-500 mt-2" x-text="formatDate(nextTraining.date)"></p>
                            </div>
                        </template>
                        <template x-if="!nextTraining">
                            <p class="mt-4 text-gray-500 italic">No training sessions scheduled.</p>
                        </template>
                    </div>
                </div>

                <!-- Recent Form -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4">Team Form</h3>
                    <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center font-bold shadow-sm">W</span>
                        <span class="w-10 h-10 rounded-full bg-gray-400 text-white flex items-center justify-center font-bold shadow-sm">D</span>
                        <span class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center font-bold shadow-sm">W</span>
                        <span class="w-10 h-10 rounded-full bg-red-500 text-white flex items-center justify-center font-bold shadow-sm">L</span>
                        <span class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center font-bold shadow-sm">W</span>
                        <span class="text-gray-500 text-sm ml-2">Last 5 Matches</span>
                    </div>
                </div>
            </div>

            <!-- 2. TRAINING PLAN -->
            <div x-show="currentRoute === 'training'">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="font-bold text-gray-800 text-lg">Training Schedule</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 text-gray-500 uppercase font-bold text-xs">
                                <tr>
                                    <th class="px-6 py-4">Date</th>
                                    <th class="px-6 py-4">Time</th>
                                    <th class="px-6 py-4">Focus</th>
                                    <th class="px-6 py-4">Location</th>
                                    <th class="px-6 py-4">Description</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <template x-for="session in trainings" :key="session.id">
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium" x-text="formatDate(session.date)"></td>
                                        <td class="px-6 py-4" x-text="session.time"></td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-bold" x-text="session.type"></span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600" x-text="session.location"></td>
                                        <td class="px-6 py-4 text-gray-500 max-w-xs truncate" x-text="session.description || '-'"></td>
                                    </tr>
                                </template>
                                <tr x-show="trainings.length === 0">
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">No training sessions found.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 3. MESSAGES (WhatsApp Style) -->
            <div x-show="currentRoute === 'messages'" class="h-[calc(100vh-140px)] bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex">
                <!-- Sidebar -->
                <div class="w-1/3 border-r border-gray-200 flex flex-col bg-gray-50">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="font-bold text-gray-700">Chats</h3>
                        <button @click="showNewChatModal = true" class="text-blue-600 hover:bg-blue-100 p-2 rounded-full transition" title="New Message">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <div class="flex-1 overflow-y-auto">
                         <!-- Chat Threads List -->
                        <template x-for="thread in chatThreads" :key="thread.user.id">
                            <div @click="activeChat = thread.user; scrollToBottom()"
                                 :class="(activeChat && activeChat.id === thread.user.id) ? 'bg-white border-l-4 border-blue-500' : 'hover:bg-gray-100 border-l-4 border-transparent'"
                                 class="p-4 cursor-pointer border-b border-gray-100 transition">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <img :src="`https://ui-avatars.com/api/?name=${thread.user.name}&background=random`" class="w-10 h-10 rounded-full">
                                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-baseline">
                                            <h4 class="font-bold text-gray-800 text-sm truncate" x-text="thread.user.name"></h4>
                                            <span class="text-xs text-gray-400" x-text="formatTimeShort(thread.lastMessage.created_at)"></span>
                                        </div>
                                        <p class="text-xs text-gray-500 truncate" x-text="thread.lastMessage.content"></p>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div x-show="chatThreads.length === 0" class="p-6 text-center text-gray-400 text-sm">
                            No conversations yet.<br>Click the edit icon to start one.
                        </div>
                    </div>
                </div>

                <!-- Chat Area -->
                <div class="flex-1 flex flex-col relative bg-[#e5ddd5]">
                    <div class="absolute inset-0 chat-bg"></div>

                    <!-- Chat Header -->
                    <div class="bg-white p-3 border-b border-gray-200 flex items-center gap-3 z-10 shadow-sm h-16">
                        <template x-if="activeChat">
                            <div class="flex items-center gap-3">
                                <img :src="`https://ui-avatars.com/api/?name=${activeChat.name}&background=random`" class="w-10 h-10 rounded-full">
                                <div>
                                    <h4 class="font-bold text-gray-800" x-text="activeChat.name"></h4>
                                    <p class="text-xs text-green-600 capitalize" x-text="activeChat.role"></p>
                                </div>
                            </div>
                        </template>
                        <template x-if="!activeChat">
                            <div class="text-gray-500 text-sm">Select a conversation</div>
                        </template>
                    </div>

                    <!-- Messages -->
                    <div class="flex-1 overflow-y-auto p-4 space-y-2 z-10 chat-scroll" id="chatContainer">
                        <template x-for="msg in currentChatMessages" :key="msg.id">
                            <div class="flex" :class="msg.sender_id == user.id ? 'justify-end' : 'justify-start'">
                                <div class="max-w-[70%] rounded-lg px-3 py-2 shadow-sm text-sm relative"
                                     :class="msg.sender_id == user.id ? 'bg-[#dcf8c6] text-gray-800 rounded-tr-none' : 'bg-white text-gray-800 rounded-tl-none'">
                                    <p x-text="msg.content"></p>
                                    <div class="text-[10px] text-right mt-1 opacity-60"
                                         x-text="formatTime(msg.created_at)"></div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Input -->
                    <div class="bg-white p-3 z-10" x-show="activeChat">
                        <form @submit.prevent="sendMessage" class="flex gap-2">
                            <input type="text" x-model="newMessageInput" placeholder="Type a message..."
                                   class="flex-1 border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:border-blue-500 text-sm">
                            <button type="submit" class="bg-blue-600 text-white w-10 h-10 rounded-full hover:bg-blue-700 shadow flex items-center justify-center">
                                <i class="fas fa-paper-plane text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- 4. VIDEO LIBRARY -->
            <div x-show="currentRoute === 'videos'">
                <h3 class="font-bold text-gray-800 text-lg mb-6">Match Analysis & Training Clips</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <template x-for="video in videos" :key="video.id">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden group hover:shadow-md transition">
                            <div class="bg-black h-48 flex items-center justify-center relative">
                                <video controls class="w-full h-full object-cover">
                                    <source :src="'/storage/' + video.video_path" type="video/mp4">
                                </video>
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-gray-800 truncate" x-text="video.title"></h4>
                                <p class="text-sm text-gray-500 line-clamp-2 mt-1" x-text="video.description || 'No description provided'"></p>
                                <div class="mt-4 pt-3 border-t border-gray-100 flex justify-between items-center">
                                    <span class="text-xs text-gray-400" x-text="formatDate(video.created_at)"></span>
                                    <button class="text-blue-600 text-sm font-medium hover:underline">Watch</button>
                                </div>
                            </div>
                        </div>
                    </template>
                    <div x-show="videos.length === 0" class="col-span-full text-center py-10 text-gray-500">
                        No videos available in the library.
                    </div>
                </div>
            </div>

            <!-- 5. CALENDAR -->
            <div x-show="currentRoute === 'calendar'">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-800" x-text="calendarMonth"></h2>
                        <div class="flex gap-2">
                             <button @click="changeMonth(-1)" class="p-2 hover:bg-gray-100 rounded text-gray-600"><i class="fas fa-chevron-left"></i></button>
                             <button @click="changeMonth(1)" class="p-2 hover:bg-gray-100 rounded text-gray-600"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>

                    <!-- Calendar Grid -->
                    <div class="grid grid-cols-7 gap-2 mb-2 text-center text-sm font-bold text-gray-400 uppercase">
                        <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
                    </div>
                    <div class="grid grid-cols-7 gap-2">
                         <!-- Blanks -->
                         <template x-for="blank in blanks" :key="blank">
                             <div class="h-28 bg-gray-50/50 rounded-lg"></div>
                         </template>
                         <!-- Days -->
                         <template x-for="day in days" :key="day.date">
                             <div class="h-28 border border-gray-100 rounded-lg p-2 relative hover:border-blue-300 transition bg-white overflow-hidden group"
                                  :class="isToday(day.date) ? 'ring-2 ring-blue-500 ring-offset-1' : ''">
                                 <span class="text-sm font-medium text-gray-700" x-text="day.dayNumber"></span>

                                 <div class="mt-1 space-y-1 overflow-y-auto max-h-[80px]">
                                     <!-- Fixture Marker -->
                                     <template x-if="day.fixture">
                                         <div class="p-1 bg-orange-100 text-orange-800 text-[10px] rounded font-bold truncate border-l-2 border-orange-500">
                                             <span x-text="'vs ' + day.fixture.opponent"></span>
                                         </div>
                                     </template>
                                     <!-- Training Marker -->
                                     <template x-if="day.training">
                                         <div class="p-1 bg-blue-100 text-blue-800 text-[10px] rounded font-medium truncate border-l-2 border-blue-500">
                                             <span x-text="day.training.type + ' (' + day.training.time + ')'"></span>
                                         </div>
                                     </template>
                                 </div>
                             </div>
                         </template>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- NEW CHAT MODAL -->
    <div x-show="showNewChatModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-transition>
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 max-h-[80vh] flex flex-col">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Start Conversation</h3>
                <button @click="showNewChatModal = false" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
            </div>
            <input type="text" x-model="userSearch" placeholder="Search team members..." class="border p-2 rounded mb-4 w-full">

            <div class="overflow-y-auto flex-1 space-y-2">
                <template x-for="u in filteredUsers" :key="u.id">
                    <div @click="startChat(u)" class="flex items-center gap-3 p-3 hover:bg-blue-50 rounded-lg cursor-pointer transition">
                        <img :src="`https://ui-avatars.com/api/?name=${u.name}&background=random`" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-bold text-gray-800" x-text="u.name"></p>
                            <p class="text-xs text-gray-500 capitalize" x-text="u.role"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- LOGIC -->
    <script>
        const API_URL = '/api';
        const getHeaders = () => ({
            'Authorization': 'Bearer ' + localStorage.getItem('api_token'),
            'Accept': 'application/json'
        });

        document.addEventListener('alpine:init', () => {
            Alpine.data('playerDashboard', () => ({
                currentRoute: 'dashboard',
                user: { id: null, name: '' },

                // Data
                fixtures: [],
                trainings: [],
                videos: [],
                messages: [],
                allUsers: [], // For new chat modal

                // Chat State
                activeChat: null,
                newMessageInput: '',
                showNewChatModal: false,
                userSearch: '',

                // Calendar State
                currDate: new Date(),

                navItems: [
                    { id: 'dashboard', label: 'Dashboard', icon: 'fas fa-chart-pie' },
                    { id: 'training', label: 'Training Plan', icon: 'fas fa-clipboard-list' },
                    { id: 'messages', label: 'Messages', icon: 'fas fa-comments' },
                    { id: 'videos', label: 'Video Library', icon: 'fas fa-film' },
                    { id: 'calendar', label: 'Calendar', icon: 'far fa-calendar-alt' }
                ],

                get pageTitle() {
                    return this.navItems.find(n => n.id === this.currentRoute)?.label || 'Dashboard';
                },

                // Dashboard Computed
                get nextMatch() {
                    const now = new Date();
                    return this.fixtures
                        .filter(f => new Date(f.match_date) >= now)
                        .sort((a,b) => new Date(a.match_date) - new Date(b.match_date))[0] || null;
                },
                get nextTraining() {
                    const now = new Date();
                    // Assumes training.date is YYYY-MM-DD and time is HH:mm
                    return this.trainings
                        .filter(t => new Date(t.date + ' ' + t.time) >= now)
                        .sort((a,b) => new Date(a.date) - new Date(b.date))[0] || null;
                },

                init() {
                    this.fetchUser();
                    this.fetchData();
                    // Poll chat
                    setInterval(() => {
                        if(this.currentRoute === 'messages') this.fetchMessages();
                    }, 5000);
                },

                async fetchUser() {
                    try {
                        const res = await fetch(`${API_URL}/user`, { headers: getHeaders() });
                        const data = await res.json();
                        this.user = data.user || data;
                    } catch(e) { console.error(e); }
                },

                async fetchData() {
                    // Fixtures
                    try {
                        const res = await fetch(`${API_URL}/fixtures`, { headers: getHeaders() });
                        const json = await res.json();
                        this.fixtures = json.data || [];
                    } catch(e) {}

                    // Training Sessions
                    try {
                        const res = await fetch(`${API_URL}/training-sessions`, { headers: getHeaders() });
                        const json = await res.json();
                        this.trainings = json.data || [];
                    } catch(e) {}

                    // Videos
                    try {
                        const res = await fetch(`${API_URL}/videos`, { headers: getHeaders() });
                        const json = await res.json();
                        this.videos = json.data || [];
                    } catch(e) {}

                    // Users (for chat modal)
                    try {
                        const res = await fetch(`${API_URL}/users`, { headers: getHeaders() });
                        const json = await res.json();
                        this.allUsers = json.data.filter(u => u.id !== this.user.id);
                    } catch(e) {}

                    this.fetchMessages();
                },

                // --- CALENDAR ---
                get calendarMonth() {
                    return this.currDate.toLocaleDateString('default', { month: 'long', year: 'numeric' });
                },
                get blanks() {
                    const firstDay = new Date(this.currDate.getFullYear(), this.currDate.getMonth(), 1).getDay();
                    return Array(firstDay).fill(null);
                },
                get days() {
                    const daysInMonth = new Date(this.currDate.getFullYear(), this.currDate.getMonth() + 1, 0).getDate();
                    const days = [];
                    for(let i=1; i<=daysInMonth; i++) {
                        const dateStr = `${this.currDate.getFullYear()}-${String(this.currDate.getMonth()+1).padStart(2,'0')}-${String(i).padStart(2,'0')}`;

                        const fixture = this.fixtures.find(f => f.match_date.startsWith(dateStr));
                        const training = this.trainings.find(t => t.date === dateStr);

                        days.push({ dayNumber: i, date: dateStr, fixture, training });
                    }
                    return days;
                },
                changeMonth(val) {
                    this.currDate = new Date(this.currDate.getFullYear(), this.currDate.getMonth() + val, 1);
                },
                isToday(dateStr) {
                    return new Date().toDateString() === new Date(dateStr).toDateString();
                },

                // --- CHAT LOGIC ---
                async fetchMessages() {
                    try {
                        const res = await fetch(`${API_URL}/chat/messages`, { headers: getHeaders() });
                        const json = await res.json();
                        this.messages = json.data || [];
                        // Scroll if already open
                        if(this.activeChat) {
                             // Only scroll if near bottom or if needed, for simplicity we check if div exists
                             // Ideally handled by watcher
                        }
                    } catch(e) {}
                },

                // Computed: Group messages by other user to form "Threads"
                get chatThreads() {
                    const threads = {};
                    this.messages.forEach(msg => {
                        // Determine the "other" person
                        const otherId = msg.sender_id === this.user.id ? msg.receiver_id : msg.sender_id;
                        // Skip if group message for now unless handled specifically
                        if(!otherId) return;

                        if(!threads[otherId]) {
                            // Find user details from allUsers or infer from message
                            const u = this.allUsers.find(user => user.id === otherId) ||
                                     (msg.sender_id === otherId ? msg.sender : msg.receiver);

                            if(u) {
                                threads[otherId] = {
                                    user: u,
                                    lastMessage: msg
                                };
                            }
                        } else {
                            // Update last message if this one is newer
                            if(new Date(msg.created_at) > new Date(threads[otherId].lastMessage.created_at)) {
                                threads[otherId].lastMessage = msg;
                            }
                        }
                    });
                    // Convert to array and sort by date desc
                    return Object.values(threads).sort((a,b) =>
                        new Date(b.lastMessage.created_at) - new Date(a.lastMessage.created_at)
                    );
                },

                // Computed: Messages for active chat
                get currentChatMessages() {
                    if(!this.activeChat) return [];
                    const partnerId = this.activeChat.id;
                    return this.messages.filter(m =>
                        (m.sender_id == this.user.id && m.receiver_id == partnerId) ||
                        (m.sender_id == partnerId && m.receiver_id == this.user.id)
                    ).sort((a,b) => new Date(a.created_at) - new Date(b.created_at));
                },

                get filteredUsers() {
                    return this.allUsers.filter(u => u.name.toLowerCase().includes(this.userSearch.toLowerCase()));
                },

                startChat(user) {
                    this.activeChat = user;
                    this.showNewChatModal = false;
                    this.currentRoute = 'messages';
                    this.scrollToBottom();
                },

                async sendMessage() {
                    if(!this.newMessageInput.trim() || !this.activeChat) return;

                    const payload = {
                        content: this.newMessageInput,
                        receiver_id: this.activeChat.id,
                        subject: 'Direct Message' // Optional based on backend
                    };

                    try {
                        const res = await fetch(`${API_URL}/chat/send`, {
                            method: 'POST',
                            headers: { ...getHeaders(), 'Content-Type': 'application/json' },
                            body: JSON.stringify(payload)
                        });
                        if(res.ok) {
                            this.newMessageInput = '';
                            this.fetchMessages();
                            setTimeout(() => this.scrollToBottom(), 100);
                        }
                    } catch(e) { console.error(e); }
                },

                scrollToBottom() {
                    this.$nextTick(() => {
                        const el = document.getElementById('chatContainer');
                        if(el) el.scrollTop = el.scrollHeight;
                    });
                },

                // --- UTILS ---
                formatDate(str) { return new Date(str).toLocaleDateString(); },
                formatTime(str) { return new Date(str).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}); },
                formatTimeShort(str) {
                    const d = new Date(str);
                    const now = new Date();
                    if(d.toDateString() === now.toDateString()) return d.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                    return d.toLocaleDateString([], {month:'short', day:'numeric'});
                },

                logout() {
                    localStorage.removeItem('api_token');
                    window.location.href = '/';
                }
            }));
        });
    </script>
</body>
</html>
