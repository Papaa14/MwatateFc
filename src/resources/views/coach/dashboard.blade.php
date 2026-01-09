<!DOCTYPE html>
<html lang="en" class="antialiased">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coach Dashboard - Mwatate FC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }

        [x-cloak] {
            display: none !important;
        }

        .chat-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .chat-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .chat-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
    </style>
</head>

<body x-data="coachDashboard" x-cloak class="bg-gray-50 h-screen overflow-hidden flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white shadow-xl flex flex-col z-20">
        <div class="h-16 flex items-center justify-center border-b border-gray-100 bg-green-700">
            <div class="flex items-center gap-2 text-white">
                <i class="fas fa-futbol text-xl"></i>
                <span class="text-lg font-bold">Mwatate FC</span>
            </div>
        </div>

        <nav class="flex-1 py-4 space-y-1 overflow-y-auto">
            <template x-for="item in navItems">
                <a href="#" @click.prevent="currentRoute = item.id"
                    :class="currentRoute === item.id ? 'bg-green-50 text-green-700 border-r-4 border-green-600' : 'text-gray-600 hover:bg-gray-50'"
                    class="flex items-center px-6 py-3 text-sm font-medium transition-colors">
                    <i :class="item.icon" class="w-5 mr-3"></i>
                    <span x-text="item.label"></span>
                </a>
            </template>
        </nav>

        <div class="p-4 border-t border-gray-100">
            <button @click="logout"
                class="flex items-center w-full px-4 py-2 text-sm text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition">
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
                <p class="text-sm text-gray-500">Manage your team effectively.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-gray-800" x-text="coach.name || 'Head Coach'"></p>
                    <p class="text-xs text-green-600">Online</p>
                </div>
                <img :src="`https://ui-avatars.com/api/?name=${coach.name || 'Coach'}&background=15803d&color=fff`"
                    class="w-10 h-10 rounded-full border-2 border-green-100">
            </div>
        </header>

        <div class="p-8 max-w-7xl mx-auto min-h-full">

            <!-- 1. DASHBOARD OVERVIEW -->
            <div x-show="currentRoute === 'dashboard'" class="space-y-6">
                <!-- Stats Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div
                        class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Total Players</p>
                            <h3 class="text-3xl font-bold text-gray-800" x-text="players.length">0</h3>
                        </div>
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-lg"><i class="fas fa-users text-xl"></i></div>
                    </div>
                    <div
                        class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Coaching Staff</p>
                            <h3 class="text-3xl font-bold text-gray-800" x-text="stats.totalCoaches">0</h3>
                        </div>
                        <div class="p-3 bg-green-50 text-green-600 rounded-lg"><i
                                class="fas fa-clipboard-user text-xl"></i></div>
                    </div>
                    <!-- Recent Form -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <p class="text-sm text-gray-500 font-medium mb-2">Recent Form</p>
                        <div class="flex gap-2">
                            <template x-for="result in ['W', 'W', 'D', 'L', 'W']">
                                <span
                                    class="w-8 h-8 flex items-center justify-center rounded-full text-xs font-bold text-white"
                                    :class="{
                                          'bg-green-500': result === 'W',
                                          'bg-gray-400': result === 'D',
                                          'bg-red-500': result === 'L'
                                      }" x-text="result"></span>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Fixtures Table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800">Upcoming Fixtures</h3>
                        <button @click="currentRoute = 'calendar'" class="text-sm text-green-600 hover:underline">View
                            Calendar</button>
                    </div>
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500">
                            <tr>
                                <th class="px-6 py-3">Date</th>
                                <th class="px-6 py-3">Opponent</th>
                                <th class="px-6 py-3">Venue</th>
                                <th class="px-6 py-3">Competition</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <template x-for="match in fixtures.slice(0, 5)" :key="match.id">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium" x-text="formatDate(match.match_date)"></td>
                                    <td class="px-6 py-4 font-bold text-gray-800" x-text="match.opponent"></td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded text-xs font-bold uppercase"
                                            :class="match.venue === 'Home' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700'"
                                            x-text="match.venue"></span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500" x-text="match.competition"></td>
                                </tr>
                            </template>
                            <tr x-show="fixtures.length === 0">
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">No upcoming fixtures found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 2. PLAYERS LIST -->
            <div x-show="currentRoute === 'players'">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <template x-for="player in players" :key="player.id">
                        <div
                            class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition group">
                            <div class="bg-gradient-to-r from-green-700 to-green-600 p-4 flex items-center gap-4">
                                <img :src="`https://ui-avatars.com/api/?name=${player.name}&background=fff&color=15803d`"
                                    class="w-12 h-12 rounded-full">
                                <div>
                                    <h3 class="font-bold text-white text-lg" x-text="player.name"></h3>
                                    <p class="text-green-100 text-sm" x-text="player.position || 'Player'"></p>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-500">Email:</span>
                                    <span class="text-gray-800" x-text="player.email"></span>
                                </div>
                                <div class="mt-4 flex gap-2">
                                    <button @click="startChat(player)"
                                        class="flex-1 bg-green-50 text-green-700 py-2 rounded-lg text-sm font-medium hover:bg-green-100 transition">
                                        <i class="fas fa-comment-alt mr-1"></i> Message
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- 3. TRAINING PLANNER (CRUD) -->
            <div x-show="currentRoute === 'training'">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Training Schedule</h3>
                    <button @click="openTrainingModal()"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 shadow">
                        <i class="fas fa-plus mr-2"></i> Add Session
                    </button>
                </div>

                <div class="space-y-4">
                    <template x-for="session in trainings" :key="session.id">
                        <div
                            class="bg-white p-5 rounded-xl border border-gray-200 flex flex-col md:flex-row md:items-center justify-between hover:shadow-sm transition">
                            <div class="flex items-start gap-4 mb-4 md:mb-0">
                                <div
                                    class="bg-blue-50 text-blue-600 w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-dumbbell text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800" x-text="session.type"></h4>
                                    <p class="text-sm text-gray-500 mt-1"
                                        x-text="session.description || 'No description'"></p>
                                    <div class="flex gap-4 mt-2 text-xs font-medium text-gray-500">
                                        <span class="flex items-center"><i class="far fa-calendar mr-1"></i> <span
                                                x-text="formatDate(session.date)"></span></span>
                                        <span class="flex items-center"><i class="far fa-clock mr-1"></i> <span
                                                x-text="session.time"></span></span>
                                        <span class="flex items-center"><i class="fas fa-map-marker-alt mr-1"></i> <span
                                                x-text="session.location"></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button @click="openTrainingModal(session)"
                                    class="text-gray-400 hover:text-blue-600 p-2"><i class="fas fa-edit"></i></button>
                                <button @click="deleteItem('training-sessions', session.id)"
                                    class="text-gray-400 hover:text-red-600 p-2"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- 4. COMMUNICATION (WhatsApp Style) -->
            <div x-show="currentRoute === 'communication'"
                class="h-[calc(100vh-140px)] bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex">

                <!-- Left Sidebar: Chat List -->
                <div class="w-1/3 border-r border-gray-200 flex flex-col bg-gray-50">
                    <div class="p-4 border-b border-gray-200">
                        <input type="text" placeholder="Search players..." x-model="chatSearch"
                            class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div class="flex-1 overflow-y-auto">
                        <!-- Group Chat Option -->
                        <div @click="activeChat = 'all'"
                            :class="activeChat === 'all' ? 'bg-white border-l-4 border-green-500 shadow-sm' : 'hover:bg-gray-100 border-l-4 border-transparent'"
                            class="p-4 cursor-pointer transition border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold">
                                    <i class="fas fa-users"></i></div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">Team Announcement</h4>
                                    <p class="text-xs text-gray-500 truncate">Broadcast to everyone</p>
                                </div>
                            </div>
                        </div>
                        <!-- Player List -->
                        <template x-for="player in filteredPlayers" :key="player.id">
                            <div @click="activeChat = player"
                                :class="(activeChat && activeChat.id === player.id) ? 'bg-white border-l-4 border-green-500 shadow-sm' : 'hover:bg-gray-100 border-l-4 border-transparent'"
                                class="p-4 cursor-pointer transition border-b border-gray-100">
                                <div class="flex items-center gap-3">
                                    <img :src="`https://ui-avatars.com/api/?name=${player.name}&background=random`"
                                        class="w-10 h-10 rounded-full">
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-sm" x-text="player.name"></h4>
                                        <p class="text-xs text-gray-500 truncate" x-text="player.position"></p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Right Pane: Conversation -->
                <div class="flex-1 flex flex-col bg-[#e5ddd5] relative">
                    <!-- Chat Background Pattern Overlay -->
                    <div class="absolute inset-0 opacity-10"
                        style="background-image: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png');">
                    </div>

                    <!-- Chat Header -->
                    <div class="bg-white p-3 border-b border-gray-200 flex items-center gap-3 z-10 shadow-sm">
                        <template x-if="activeChat && activeChat !== 'all'">
                            <div class="flex items-center gap-3">
                                <img :src="`https://ui-avatars.com/api/?name=${activeChat.name}&background=random`"
                                    class="w-10 h-10 rounded-full">
                                <div>
                                    <h4 class="font-bold text-gray-800" x-text="activeChat.name"></h4>
                                    <p class="text-xs text-green-600">Online</p>
                                </div>
                            </div>
                        </template>
                        <template x-if="activeChat === 'all'">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-green-600 text-white flex items-center justify-center">
                                    <i class="fas fa-bullhorn"></i></div>
                                <div>
                                    <h4 class="font-bold text-gray-800">Team Broadcast</h4>
                                    <p class="text-xs text-gray-500">All players will receive this.</p>
                                </div>
                            </div>
                        </template>
                        <template x-if="!activeChat">
                            <div class="text-gray-500 text-sm">Select a chat to start messaging</div>
                        </template>
                    </div>

                    <!-- Messages Area -->
                    <div class="flex-1 overflow-y-auto p-4 space-y-3 z-10 chat-scroll" id="chatContainer">
                        <template x-for="msg in currentChatMessages" :key="msg.id">
                            <div class="flex" :class="msg.sender_id == coach.id ? 'justify-end' : 'justify-start'">
                                <div class="max-w-[70%] rounded-lg px-4 py-2 shadow-sm text-sm relative"
                                    :class="msg.sender_id == coach.id ? 'bg-[#dcf8c6] text-gray-800 rounded-tr-none' : 'bg-white text-gray-800 rounded-tl-none'">
                                    <p x-text="msg.content"></p>
                                    <div class="text-[10px] text-right mt-1 opacity-60"
                                        x-text="new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})">
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template x-if="!activeChat">
                            <div class="h-full flex items-center justify-center flex-col text-gray-400">
                                <i class="fas fa-comments text-4xl mb-2"></i>
                                <p>Select a player to chat</p>
                            </div>
                        </template>
                    </div>

                    <!-- Input Area -->
                    <div class="bg-white p-3 z-10" x-show="activeChat">
                        <form @submit.prevent="sendMessage" class="flex gap-2">
                            <input type="text" x-model="newMessageInput" placeholder="Type a message..."
                                class="flex-1 border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:border-green-500 text-sm">
                            <button type="submit"
                                class="bg-green-600 text-white w-10 h-10 rounded-full hover:bg-green-700 shadow flex items-center justify-center">
                                <i class="fas fa-paper-plane text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- 5. VIDEO ANALYTICS (CRUD) -->
            <div x-show="currentRoute === 'analytics'">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Video Library</h3>
                    <button @click="openVideoModal()"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 shadow">
                        <i class="fas fa-cloud-upload-alt mr-2"></i> Upload Video
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <template x-for="video in videos" :key="video.id">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden group">
                            <div class="bg-black h-48 flex items-center justify-center relative">
                                <video controls class="w-full h-full object-cover">
                                    <source :src="'/storage/' + video.video_path" type="video/mp4">
                                </video>
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-gray-800 truncate" x-text="video.title"></h4>
                                <p class="text-sm text-gray-500 line-clamp-2 mt-1"
                                    x-text="video.description || 'No description'"></p>
                                <div class="mt-4 flex justify-end gap-2 border-t border-gray-100 pt-3">
                                    <button @click="openVideoModal(video)"
                                        class="text-sm text-blue-600 hover:underline">Edit Info</button>
                                    <button @click="deleteItem('video-analysis', video.id)"
                                        class="text-sm text-red-600 hover:underline">Delete</button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- 6. CALENDAR (Visual) -->
            <div x-show="currentRoute === 'calendar'">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-800" x-text="calendarMonth"></h2>
                        <div class="flex gap-2">
                            <button @click="changeMonth(-1)" class="p-2 hover:bg-gray-100 rounded"><i
                                    class="fas fa-chevron-left"></i></button>
                            <button @click="changeMonth(1)" class="p-2 hover:bg-gray-100 rounded"><i
                                    class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>

                    <!-- Calendar Grid -->
                    <div class="grid grid-cols-7 gap-2 mb-2 text-center text-sm font-bold text-gray-400 uppercase">
                        <div>Sun</div>
                        <div>Mon</div>
                        <div>Tue</div>
                        <div>Wed</div>
                        <div>Thu</div>
                        <div>Fri</div>
                        <div>Sat</div>
                    </div>
                    <div class="grid grid-cols-7 gap-2">
                        <!-- Blanks -->
                        <template x-for="blank in blanks" :key="blank">
                            <div class="h-24 bg-gray-50/50 rounded-lg"></div>
                        </template>
                        <!-- Days -->
                        <template x-for="day in days" :key="day.date">
                            <div
                                class="h-24 border border-gray-100 rounded-lg p-2 relative hover:border-green-300 transition bg-white group">
                                <span class="text-sm font-medium text-gray-700" x-text="day.dayNumber"></span>
                                <!-- Event Marker -->
                                <template x-if="day.fixture">
                                    <div class="mt-1 p-1 bg-orange-100 text-orange-800 text-xs rounded truncate font-bold"
                                        :title="'vs ' + day.fixture.opponent">
                                        <i class="fas fa-tshirt mr-1"></i><span x-text="day.fixture.opponent"></span>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- MODALS -->

    <!-- Training Modal -->
    <div x-show="modals.training"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-transition>
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <h3 class="text-xl font-bold mb-4" x-text="trainingForm.id ? 'Edit Session' : 'New Session'"></h3>
            <form @submit.prevent="saveTraining" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <input type="date" x-model="trainingForm.date" required class="border p-2 rounded w-full">
                    <input type="time" x-model="trainingForm.time" required class="border p-2 rounded w-full">
                </div>
                <input type="text" x-model="trainingForm.location" placeholder="Location" required
                    class="border p-2 rounded w-full">
                <select x-model="trainingForm.type" class="border p-2 rounded w-full">
                    <option>Technical</option>
                    <option>Tactical</option>
                    <option>Fitness</option>
                    <option>Recovery</option>
                </select>
                <textarea x-model="trainingForm.description" placeholder="Drill details..." rows="3"
                    class="border p-2 rounded w-full"></textarea>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="modals.training = false"
                        class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Video Modal -->
    <div x-show="modals.video" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
        x-transition>
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <h3 class="text-xl font-bold mb-4" x-text="videoForm.id ? 'Edit Video Details' : 'Upload Video'"></h3>
            <form @submit.prevent="saveVideo" class="space-y-4">
                <input type="text" x-model="videoForm.title" placeholder="Video Title" required
                    class="border p-2 rounded w-full">
                <textarea x-model="videoForm.description" placeholder="Analysis notes..." rows="3"
                    class="border p-2 rounded w-full"></textarea>

                <div x-show="!videoForm.id">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Video File</label>
                    <input type="file" @change="videoFile = $event.target.files[0]" accept="video/*"
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="modals.video = false"
                        class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save</button>
                </div>
            </form>
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
            Alpine.data('coachDashboard', () => ({
                currentRoute: 'dashboard',
                coach: { id: null, name: '' },

                // Data Stores
                players: [],
                fixtures: [],
                trainings: [],
                videos: [],
                messages: [],

                // Communication State
                chatSearch: '',
                activeChat: null, // 'all' or player object
                newMessageInput: '',

                // Stats
                stats: { totalCoaches: 0 },

                // Calendar State
                currDate: new Date(),

                // Modals & Forms
                modals: { training: false, video: false },
                trainingForm: { id: null, date: '', time: '', location: '', type: 'Technical', description: '' },
                videoForm: { id: null, title: '', description: '' },
                videoFile: null,

                navItems: [
                    { id: 'dashboard', label: 'Dashboard', icon: 'fas fa-chart-pie' },
                    { id: 'players', label: 'Players', icon: 'fas fa-users' },
                    { id: 'communication', label: 'Chat', icon: 'fas fa-comments' },
                    { id: 'training', label: 'Training', icon: 'fas fa-clipboard-list' },
                    { id: 'analytics', label: 'Video Analysis', icon: 'fas fa-video' },
                    { id: 'calendar', label: 'Calendar', icon: 'far fa-calendar-alt' }
                ],

                get pageTitle() {
                    return this.navItems.find(n => n.id === this.currentRoute)?.label || 'Dashboard';
                },

                init() {
                    this.fetchUser();
                    this.fetchData();
                    // Auto-refresh chat
                    setInterval(() => { if (this.currentRoute === 'communication') this.fetchMessages() }, 5000);
                },

                async fetchUser() {
                    try {
                        const res = await fetch(`${API_URL}/user`, { headers: getHeaders() });
                        const data = await res.json();
                        this.coach = data.user || data;
                    } catch (e) { console.error(e); }
                },

                async fetchData() {
                    // Fetch Users (Players & Coaches)
                    try {
                        const res = await fetch(`${API_URL}/users`, { headers: getHeaders() });
                        const json = await res.json();
                        // Filter logic based on request
                        this.players = json.data.filter(u => u.role === 'player');
                        this.stats.totalCoaches = json.data.filter(u => u.role === 'coach').length;
                    } catch (e) { }

                    // Fetch Fixtures
                    try {
                        const res = await fetch(`${API_URL}/fixtures`, { headers: getHeaders() });
                        const json = await res.json();
                        this.fixtures = json.data || [];
                    } catch (e) { }

                    // Fetch Trainings
                    try {
                        const res = await fetch(`${API_URL}/training-sessions`, { headers: getHeaders() });
                        const json = await res.json();
                        this.trainings = json.data || [];
                    } catch (e) { }

                    // Fetch Videos
                    try {
                        const res = await fetch(`${API_URL}/videos`, { headers: getHeaders() });
                        const json = await res.json();
                        this.videos = json.data || [];
                    } catch (e) { }

                    this.fetchMessages();
                },

                // --- CALENDAR LOGIC ---
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
                    for (let i = 1; i <= daysInMonth; i++) {
                        const dateStr = `${this.currDate.getFullYear()}-${String(this.currDate.getMonth() + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                        // Map Fixture
                        const fixture = this.fixtures.find(f => f.match_date.startsWith(dateStr));
                        days.push({ dayNumber: i, date: dateStr, fixture: fixture });
                    }
                    return days;
                },
                changeMonth(val) {
                    this.currDate = new Date(this.currDate.getFullYear(), this.currDate.getMonth() + val, 1);
                },

                // --- COMMUNICATION LOGIC ---
                async fetchMessages() {
                    try {
                        const res = await fetch(`${API_URL}/chat/messages`, { headers: getHeaders() });
                        const json = await res.json();
                        this.messages = json.data || [];
                        this.scrollChat();
                    } catch (e) { }
                },

                get filteredPlayers() {
                    if (!this.chatSearch) return this.players;
                    return this.players.filter(p => p.name.toLowerCase().includes(this.chatSearch.toLowerCase()));
                },

                get currentChatMessages() {
                    if (!this.activeChat) return [];
                    if (this.activeChat === 'all') {
                        // Filter broadcasts (where recipient_group is set)
                        return this.messages.filter(m => m.recipient_group === 'all' || m.recipient_group === 'squad');
                    }
                    // Filter Individual conversation
                    const pid = this.activeChat.id;
                    const cid = this.coach.id;
                    return this.messages.filter(m =>
                        (m.sender_id == pid && m.receiver_id == cid) ||
                        (m.sender_id == cid && m.receiver_id == pid)
                    ).sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                },

                startChat(player) {
                    this.currentRoute = 'communication';
                    this.activeChat = player;
                    setTimeout(() => this.scrollChat(), 100);
                },

                async sendMessage() {
                    if (!this.newMessageInput.trim()) return;

                    const payload = { content: this.newMessageInput, subject: 'Chat' };

                    if (this.activeChat === 'all') {
                        payload.recipient_group = 'all';
                    } else {
                        payload.receiver_id = this.activeChat.id;
                    }

                    try {
                        const res = await fetch(`${API_URL}/chat/send`, {
                            method: 'POST',
                            headers: { ...getHeaders(), 'Content-Type': 'application/json' },
                            body: JSON.stringify(payload)
                        });
                        if (res.ok) {
                            this.newMessageInput = '';
                            this.fetchMessages();
                        }
                    } catch (e) { alert('Failed to send'); }
                },

                scrollChat() {
                    const el = document.getElementById('chatContainer');
                    if (el) el.scrollTop = el.scrollHeight;
                },

                // --- CRUD TRAINING ---
                openTrainingModal(session = null) {
                    if (session) {
                        this.trainingForm = { ...session };
                    } else {
                        this.trainingForm = { id: null, date: '', time: '', location: '', type: 'Technical', description: '' };
                    }
                    this.modals.training = true;
                },

                async saveTraining() {
                    const url = this.trainingForm.id
                        ? `${API_URL}/training-sessions/${this.trainingForm.id}` // Hypothetical update route
                        : `${API_URL}/training-sessions`;

                    // Since specific Update controller wasn't provided, assuming POST for create.
                    // If backend supports PUT, logic would change here. Assuming Create Only for prompt compliance or standard Laravel resource.
                    const method = this.trainingForm.id ? 'PUT' : 'POST';

                    try {
                        const res = await fetch(url, {
                            method: method,
                            headers: { ...getHeaders(), 'Content-Type': 'application/json' },
                            body: JSON.stringify(this.trainingForm)
                        });
                        if (res.ok) {
                            this.modals.training = false;
                            this.fetchData();
                        }
                    } catch (e) { alert('Error saving session'); }
                },

                // --- CRUD VIDEO ---
                openVideoModal(video = null) {
                    if (video) {
                        this.videoForm = { id: video.id, title: video.title, description: video.description };
                        this.videoFile = null; // Can't edit file easily via simple API
                    } else {
                        this.videoForm = { id: null, title: '', description: '' };
                        this.videoFile = null;
                    }
                    this.modals.video = true;
                },

                async saveVideo() {
                    // If creating, we need FormData for file. If editing, JSON is fine for title/desc.
                    if (!this.videoForm.id && !this.videoFile) {
                        alert("Select a file"); return;
                    }

                    const formData = new FormData();
                    formData.append('title', this.videoForm.title);
                    formData.append('description', this.videoForm.description || '');
                    if (this.videoFile) formData.append('video', this.videoFile);

                    // Note: Handling PUT with FormData in Laravel usually involves _method='PUT'
                    let url = `${API_URL}/videos`;
                    let headers = { 'Authorization': 'Bearer ' + localStorage.getItem('api_token'), 'Accept': 'application/json' };

                    if (this.videoForm.id) {
                        // Editing title/desc
                        // NOTE: Provided controller only showed STORE. Assuming simple create for now based on prompt constraints.
                        // But for completeness, just showing Alert as Update endpoint wasn't provided in code block.
                        alert("Update endpoint implementation required on backend");
                        return;
                    }

                    try {
                        const res = await fetch(url, {
                            method: 'POST',
                            headers: headers, // Do NOT set Content-Type for FormData
                            body: formData
                        });
                        if (res.ok) {
                            this.modals.video = false;
                            this.fetchData();
                        }
                    } catch (e) { alert('Error uploading'); }
                },

                async deleteItem(type, id) {
                    if (!confirm('Delete this item?')) return;
                    // Assuming standard RESTful delete routes exist or mapped to destroy
                    // Note: Provided controllers showed destroy for Fixture, but generic for others.
                    // mapping: type = 'fixtures', 'trainings', etc.
                    // The provided code had specific controllers but didn't show the route definitions for DELETE on training/video.
                    // Implies: /api/trainings/{id}
                    try {
                        // Mapping simple plural names to likely API routes based on context
                        let endpoint = type;
                        if (type === 'training-sessions') endpoint = 'training-sessions'; // based on TrainingSessionController index route provided earlier as /trainings
                        if (type === 'video-analysis') endpoint = 'videos';

                        const res = await fetch(`${API_URL}/${endpoint}/${id}`, {
                            method: 'DELETE',
                            headers: getHeaders()
                        });
                        if (res.ok) this.fetchData();
                    } catch (e) { alert('Delete failed'); }
                },

                formatDate(str) { return new Date(str).toLocaleDateString(); },

                logout() {
                    localStorage.removeItem('api_token');
                    window.location.href = '/login';
                }
            }));
        });
    </script>
</body>

</html>
