<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Dashboard - Mwatate FC</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }

        /* Custom Scrollbar for Chat */
        .chat-scroll::-webkit-scrollbar { width: 6px; }
        .chat-scroll::-webkit-scrollbar-track { background: #f1f1f1; }
        .chat-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .chat-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .dashboard-bg { background-color: #f3f4f6; }
    </style>
</head>

<body class="dashboard-bg" x-data="playerApp()" x-init="initApp()">
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar Navigation -->
        <aside class="w-64 flex-shrink-0 bg-white shadow-xl border-r border-gray-200 z-20 flex flex-col">
            <!-- Logo -->
            <div class="h-20 flex items-center justify-center border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white">
                        <i class="fas fa-futbol text-xl"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-800">Mwatate FC</span>
                </div>
            </div>

            <!-- Nav Links -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <template x-for="item in navItems" :key="item.id">
                    <button @click="currentSection = item.id"
                        :class="currentSection === item.id ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600'"
                        class="w-full flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">
                        <i :class="item.icon" class="mr-3 w-5 text-center"></i>
                        <span x-text="item.label"></span>
                    </button>
                </template>
            </nav>

            <!-- User & Logout -->
            <div class="border-t border-gray-200 p-4">
                <div class="flex items-center p-3 bg-gray-50 rounded-xl mb-3">
                    <img class="w-10 h-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name=John+Doe&background=0D8ABC&color=fff" alt="Player">
                    <div class="ml-3 overflow-hidden">
                        <p class="text-sm font-bold text-gray-900 truncate">John Okoro</p>
                        <p class="text-xs text-green-600 font-medium">● Online</p>
                    </div>
                </div>
                <button @click="logout()" class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto relative scroll-smooth">
            <!-- Header -->
            <header class="sticky top-0 z-10 bg-white/90 backdrop-blur-md border-b border-gray-200 px-8 py-4 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800" x-text="pageTitle"></h2>
                    <p class="text-sm text-gray-500">Welcome back to your player portal.</p>
                </div>
                <button class="relative p-2 text-gray-400 hover:text-blue-600 transition">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
            </header>

            <div class="p-8 max-w-7xl mx-auto">

                <!-- 1. DASHBOARD SECTION -->
                <section x-show="currentSection === 'dashboard'" x-transition.opacity class="space-y-8">
                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Next Match -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
                            <div class="absolute right-0 top-0 h-full w-1 bg-blue-600"></div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Next Match</p>
                            <h3 class="text-lg font-bold text-gray-800 mb-1" x-text="stats.next_match ? stats.next_match.opponent : 'No Match'"></h3>
                            <p class="text-sm text-blue-600 font-medium" x-text="stats.next_match ? formatDate(stats.next_match.match_date) : '--'"></p>
                        </div>

                        <!-- Next Training -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
                            <div class="absolute right-0 top-0 h-full w-1 bg-green-500"></div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Next Training</p>
                            <h3 class="text-lg font-bold text-gray-800 mb-1" x-text="stats.next_training ? stats.next_training.type : 'Rest Day'"></h3>
                            <p class="text-sm text-green-600 font-medium" x-text="stats.next_training ? formatTime(stats.next_training.date) : '--'"></p>
                        </div>

                        <!-- Goals -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Goals Scored</p>
                                    <h3 class="text-3xl font-bold text-gray-800" x-text="stats.goals">0</h3>
                                </div>
                                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                                    <i class="fas fa-futbol"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Assists -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Assists</p>
                                    <h3 class="text-3xl font-bold text-gray-800" x-text="stats.assists">0</h3>
                                </div>
                                <div class="p-3 bg-purple-50 text-purple-600 rounded-lg">
                                    <i class="fas fa-shoe-prints"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity / Placeholder -->
                    <div class="bg-gradient-to-r from-blue-900 to-blue-700 rounded-2xl p-8 text-white shadow-lg">
                        <h3 class="text-2xl font-bold mb-2">Ready for the next game?</h3>
                        <p class="text-blue-100 mb-6 max-w-2xl">Check out the latest video analysis uploaded by the coach to improve your positioning.</p>
                        <button @click="currentSection = 'videos'" class="bg-white text-blue-800 px-6 py-2.5 rounded-lg font-semibold hover:bg-blue-50 transition shadow-lg">
                            Go to Video Library
                        </button>
                    </div>
                </section>

                <!-- 2. TRAINING SECTION -->
                <section x-show="currentSection === 'training'" x-cloak x-transition.opacity>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-800">Upcoming Sessions</h3>
                            <span class="text-sm text-gray-500">This Week</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-gray-50 text-xs text-gray-500 uppercase font-bold">
                                    <tr>
                                        <th class="px-6 py-4">Date & Time</th>
                                        <th class="px-6 py-4">Session Type</th>
                                        <th class="px-6 py-4">Location</th>
                                        <th class="px-6 py-4 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <template x-for="session in trainings" :key="session.id">
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 font-medium text-gray-900">
                                                <div class="flex flex-col">
                                                    <span x-text="new Date(session.date).toLocaleDateString(undefined, {weekday: 'short', month: 'short', day: 'numeric'})"></span>
                                                    <span class="text-xs text-gray-500" x-text="session.time"></span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold" x-text="session.type"></span>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600" x-text="session.location"></td>
                                            <td class="px-6 py-4 text-center">
                                                <i class="fas fa-check-circle text-gray-300"></i>
                                            </td>
                                        </tr>
                                    </template>
                                    <template x-if="trainings.length === 0">
                                        <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">No training sessions scheduled.</td></tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- 3. MESSAGES SECTION (CHAT) -->
                <section x-show="currentSection === 'messages'" x-cloak x-transition.opacity class="h-[calc(100vh-180px)]">
                    <div class="flex h-full bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                        <!-- Chat Sidebar -->
                        <div class="w-80 border-r border-gray-100 bg-gray-50 flex flex-col">
                            <div class="p-4 border-b border-gray-200">
                                <h3 class="font-bold text-gray-800">Coaches</h3>
                            </div>
                            <div class="flex-1 overflow-y-auto p-2 space-y-2">
                                <!-- Hardcoded Coach for Demo, in real app loop through contacts -->
                                <button @click="activeChat = 'coach'"
                                    :class="activeChat === 'coach' ? 'bg-white shadow-sm ring-1 ring-black/5' : 'hover:bg-gray-100'"
                                    class="w-full flex items-center p-3 rounded-lg transition-all">
                                    <div class="relative">
                                        <img src="https://ui-avatars.com/api/?name=Head+Coach&background=1e40af&color=fff" class="w-10 h-10 rounded-full">
                                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                                    </div>
                                    <div class="ml-3 text-left">
                                        <p class="text-sm font-bold text-gray-900">Head Coach</p>
                                        <p class="text-xs text-gray-500 truncate">Tactical analysis...</p>
                                    </div>
                                </button>
                            </div>
                        </div>

                        <!-- Chat Area -->
                        <div class="flex-1 flex flex-col bg-white">
                            <!-- Chat Header -->
                            <div class="p-4 border-b border-gray-100 flex items-center justify-between bg-white">
                                <div class="flex items-center">
                                    <img src="https://ui-avatars.com/api/?name=Head+Coach&background=1e40af&color=fff" class="w-10 h-10 rounded-full">
                                    <div class="ml-3">
                                        <p class="text-sm font-bold text-gray-900">Head Coach</p>
                                        <p class="text-xs text-green-600">Online</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Messages List -->
                            <div class="flex-1 overflow-y-auto p-6 space-y-4 chat-scroll bg-gray-50/50" id="messageContainer">
                                <template x-for="msg in messages" :key="msg.id">
                                    <div :class="msg.sender_id === currentUserId ? 'flex justify-end' : 'flex justify-start'">
                                        <div :class="msg.sender_id === currentUserId ? 'bg-blue-600 text-white rounded-br-none' : 'bg-white border border-gray-200 text-gray-800 rounded-bl-none'"
                                            class="max-w-md px-4 py-3 rounded-2xl shadow-sm">
                                            <p class="text-sm" x-text="msg.content"></p>
                                            <p :class="msg.sender_id === currentUserId ? 'text-blue-200' : 'text-gray-400'"
                                               class="text-[10px] mt-1 text-right" x-text="formatTime(msg.created_at)"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <!-- Input Area -->
                            <div class="p-4 bg-white border-t border-gray-100">
                                <form @submit.prevent="sendMessage" class="flex items-center space-x-3">
                                    <input type="text" x-model="newMessage" placeholder="Type your message..."
                                        class="flex-1 bg-gray-100 text-gray-900 placeholder-gray-500 border-0 rounded-full px-5 py-3 focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                                    <button type="submit"
                                        class="bg-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center hover:bg-blue-700 transition shadow-lg transform hover:scale-105">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 4. VIDEO LIBRARY SECTION -->
                <section x-show="currentSection === 'videos'" x-cloak x-transition.opacity>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <template x-for="video in videos" :key="video.id">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                                <div class="aspect-video bg-gray-900 relative">
                                    <!-- Simple Video Tag -->
                                    <video controls class="w-full h-full object-cover">
                                        <source :src="'/storage/' + video.video_path" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                                <div class="p-4">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h3 class="font-bold text-gray-800 line-clamp-1" x-text="video.title"></h3>
                                            <p class="text-sm text-gray-500 mt-1 line-clamp-2" x-text="video.description || 'No description provided.'"></p>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                                        <span class="text-xs text-gray-400" x-text="new Date(video.created_at).toLocaleDateString()"></span>
                                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded">Analysis</span>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template x-if="videos.length === 0">
                            <div class="col-span-full text-center py-12 bg-white rounded-xl border border-gray-200 border-dashed">
                                <i class="fas fa-video text-gray-300 text-4xl mb-3"></i>
                                <p class="text-gray-500">No videos available in the library yet.</p>
                            </div>
                        </template>
                    </div>
                </section>

                <!-- 5. CALENDAR SECTION -->
                <section x-show="currentSection === 'calendar'" x-cloak x-transition.opacity>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <!-- Calendar Header -->
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-lg font-bold text-gray-800" x-text="calendarMonthYear"></h2>
                            <div class="space-x-2">
                                <button @click="changeMonth(-1)" class="p-2 hover:bg-gray-100 rounded-lg text-gray-600"><i class="fas fa-chevron-left"></i></button>
                                <button @click="changeMonth(1)" class="p-2 hover:bg-gray-100 rounded-lg text-gray-600"><i class="fas fa-chevron-right"></i></button>
                            </div>
                        </div>

                        <!-- Days Header -->
                        <div class="grid grid-cols-7 gap-4 mb-4 text-center">
                            <template x-for="day in ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']">
                                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider" x-text="day"></div>
                            </template>
                        </div>

                        <!-- Calendar Grid -->
                        <div class="grid grid-cols-7 gap-4">
                            <!-- Empty cells for start of month -->
                            <template x-for="blank in calendarBlanks">
                                <div class="h-24 bg-gray-50/50 rounded-xl"></div>
                            </template>

                            <!-- Actual Days -->
                            <template x-for="day in calendarDays" :key="day.date">
                                <div class="h-24 border border-gray-100 rounded-xl p-2 relative hover:border-blue-300 transition bg-white"
                                     :class="isToday(day.date) ? 'ring-2 ring-blue-500 ring-offset-2' : ''">
                                    <span class="text-sm font-medium text-gray-700" x-text="day.number"></span>

                                    <!-- Events in that day -->
                                    <div class="mt-1 space-y-1 overflow-y-auto max-h-[60px] scrollbar-hide">
                                        <template x-for="event in day.events">
                                            <div class="text-[10px] px-1.5 py-0.5 rounded truncate font-medium"
                                                 :class="event.type === 'match' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700'"
                                                 :title="event.title">
                                                <span x-text="event.title"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </section>

            </div>
        </main>
    </div>

    <!-- API Logic -->
    <script>
        const API_URL = '/api'; // Ensure this matches your Laravel API prefix
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function playerApp() {
            return {
                currentSection: 'dashboard',
                activeChat: 'coach',
                currentUserId: 1, // This should be dynamic from auth, usually injected via blade or an API call
                newMessage: '',

                // Data Stores
                stats: { goals: 0, assists: 0, next_match: null, next_training: null },
                trainings: [],
                videos: [],
                fixtures: [],
                messages: [],

                // Calendar Logic
                currentDate: new Date(),

                navItems: [
                    { id: 'dashboard', label: 'Dashboard', icon: 'fas fa-chart-pie' },
                    { id: 'training', label: 'Training Plan', icon: 'fas fa-clipboard-list' },
                    { id: 'messages', label: 'Messages', icon: 'fas fa-comments' },
                    { id: 'videos', label: 'Video Library', icon: 'fas fa-film' },
                    { id: 'calendar', label: 'Calendar', icon: 'fas fa-calendar-alt' }
                ],

                get pageTitle() {
                    return this.navItems.find(i => i.id === this.currentSection).label;
                },

                // Initialization
                async initApp() {
                    await this.fetchDashboardStats();
                    await this.fetchTraining();
                    await this.fetchVideos();
                    await this.fetchFixtures(); // Needed for calendar
                    await this.fetchMessages();

                    // Simple polling for chat (every 5 seconds)
                    setInterval(() => {
                        if(this.currentSection === 'messages') this.fetchMessages();
                    }, 5000);
                },

                // --- API CALLS ---

                async fetchDashboardStats() {
                    try {
                        const res = await fetch(`${API_URL}/player/dashboard-stats`, { headers: { 'Accept': 'application/json' }});
                        const data = await res.json();
                        this.stats = data.data;
                    } catch(e) { console.error('Stats error', e); }
                },

                async fetchTraining() {
                    try {
                        const res = await fetch(`${API_URL}/trainings`, { headers: { 'Accept': 'application/json' }});
                        const data = await res.json();
                        this.trainings = data.data;
                    } catch(e) { console.error('Training error', e); }
                },

                async fetchVideos() {
                    try {
                        const res = await fetch(`${API_URL}/videos`, { headers: { 'Accept': 'application/json' }});
                        const data = await res.json();
                        this.videos = data.data;
                    } catch(e) { console.error('Video error', e); }
                },

                async fetchFixtures() {
                    try {
                        const res = await fetch(`${API_URL}/fixtures`, { headers: { 'Accept': 'application/json' }});
                        const data = await res.json();
                        this.fixtures = data.data;
                    } catch(e) { console.error('Fixture error', e); }
                },

                async fetchMessages() {
                    try {
                        const res = await fetch(`${API_URL}/chat/messages`, { headers: { 'Accept': 'application/json' }});
                        const data = await res.json();
                        this.messages = data.data;
                        this.scrollToBottom();
                    } catch(e) { console.error('Message error', e); }
                },

                async sendMessage() {
                    if (!this.newMessage.trim()) return;

                    try {
                        const payload = { content: this.newMessage, receiver_id: 2 }; // Assuming Coach ID is 2 for demo
                        const res = await fetch(`${API_URL}/chat/send`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': CSRF_TOKEN
                            },
                            body: JSON.stringify(payload)
                        });

                        if (res.ok) {
                            this.newMessage = '';
                            this.fetchMessages(); // Refresh chat
                        }
                    } catch(e) { console.error('Send error', e); }
                },

                async logout() {
                    if(!confirm('Are you sure you want to log out?')) return;
                    try {
                        await fetch(`${API_URL}/logout`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': CSRF_TOKEN
                            }
                        });
                        window.location.href = '/'; // Redirect
                    } catch(e) {
                        window.location.href = '/';
                    }
                },

                // --- CALENDAR HELPERS ---

                get calendarMonthYear() {
                    return this.currentDate.toLocaleString('default', { month: 'long', year: 'numeric' });
                },

                get calendarBlanks() {
                    const firstDayOfMonth = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth(), 1).getDay();
                    return Array(firstDayOfMonth).fill(null);
                },

                get calendarDays() {
                    const daysInMonth = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 0).getDate();
                    const days = [];

                    for (let i = 1; i <= daysInMonth; i++) {
                        const dateStr = `${this.currentDate.getFullYear()}-${String(this.currentDate.getMonth() + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;

                        // Find events for this day
                        const dayEvents = [];

                        // Check Fixtures
                        this.fixtures.forEach(f => {
                            if (f.match_date.startsWith(dateStr)) {
                                dayEvents.push({ title: 'vs ' + f.opponent, type: 'match' });
                            }
                        });

                        // Check Trainings
                        this.trainings.forEach(t => {
                            if (t.date === dateStr) {
                                dayEvents.push({ title: t.type, type: 'training' });
                            }
                        });

                        days.push({
                            number: i,
                            date: dateStr,
                            events: dayEvents
                        });
                    }
                    return days;
                },

                changeMonth(offset) {
                    this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + offset, 1);
                },

                isToday(dateStr) {
                    const today = new Date();
                    const check = new Date(dateStr);
                    return today.toDateString() === check.toDateString();
                },

                // --- UTILS ---
                scrollToBottom() {
                    this.$nextTick(() => {
                        const container = document.getElementById('messageContainer');
                        if (container) container.scrollTop = container.scrollHeight;
                    });
                },

                formatDate(dateStr) {
                    if (!dateStr) return '';
                    return new Date(dateStr).toLocaleDateString(undefined, { weekday: 'short', month: 'short', day: 'numeric' });
                },

                formatTime(dateStr) {
                    if (!dateStr) return '';
                    return new Date(dateStr).toLocaleTimeString(undefined, { hour: '2-digit', minute: '2-digit' });
                }
            }
        }
    </script>
</body>
</html>
    