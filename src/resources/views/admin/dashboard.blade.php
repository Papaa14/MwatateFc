<!DOCTYPE html>
<html lang="en" class="antialiased">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Mwatate FC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    },
                    animation: {
                        fadeIn: 'fadeIn 0.3s ease-out'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(10px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            }
                        }
                    }
                }
            }
        }
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-50 min-h-screen flex flex-col lg:flex-row">

    <!-- Notification Toast -->
    <div id="notification"
        class="fixed bottom-5 right-5 transform translate-y-20 opacity-0 transition-all duration-300 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium">
    </div>

    <!-- Sidebar (Unchanged) -->
    <aside class="w-full lg:w-64 bg-white shadow-lg shrink-0 flex flex-col h-screen sticky top-0 z-30">
        <div class="h-16 flex items-center justify-center border-b border-gray-100">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-futbol text-green-600 text-xl"></i>
                </div>
                <span class="text-xl font-bold text-gray-800">Mwatate FC</span>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <button onclick="switchSection('dashboard')" id="nav-dashboard"
                class="nav-item w-full flex items-center px-4 py-3 text-sm font-medium rounded-lg bg-blue-600 text-white shadow-md">
                <i class="fas fa-chart-pie w-6"></i> Dashboard
            </button>

            <p class="px-4 pt-4 pb-2 text-xs font-bold text-gray-400 uppercase">Team</p>
            <button onclick="switchSection('players')" id="nav-players"
                class="nav-item w-full flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-blue-600">
                <i class="fas fa-users w-6"></i> Players
            </button>
            <button onclick="switchSection('staff')" id="nav-staff"
                class="nav-item w-full flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-blue-600">
                <i class="fas fa-user-tie w-6"></i> Coaching Staff
            </button>

            <p class="px-4 pt-4 pb-2 text-xs font-bold text-gray-400 uppercase">Management</p>
            <button onclick="switchSection('news')" id="nav-news"
                class="nav-item w-full flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-blue-600">
                <i class="fas fa-newspaper w-6"></i> Team News
            </button>
            <button onclick="switchSection('fixtures')" id="nav-fixtures"
                class="nav-item w-full flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-blue-600">
                <i class="fas fa-calendar-alt w-6"></i> Fixtures
            </button>
            <button onclick="switchSection('tickets')" id="nav-tickets"
                class="nav-item w-full flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-blue-600">
                <i class="fas fa-ticket-alt w-6"></i> Tickets
            </button>
            <button onclick="switchSection('jerseys')" id="nav-jerseys"
                class="nav-item w-full flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-blue-600">
                <i class="fa-solid fa-shirt  w-6"></i> Jerseys
            </button>

        </nav>

        <!-- Admin Profile -->
        <div class="border-t border-gray-200 p-4 relative group">
            <button onclick="toggleAdminMenu()"
                class="flex items-center w-full p-2 rounded-lg hover:bg-gray-50 transition-colors focus:outline-none">
                <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold">A
                </div>
                <div class="ml-3 text-left flex-1">
                    <p class="text-sm font-medium text-gray-700">Administrator</p>
                    <p class="text-xs text-green-500 flex items-center"><span
                            class="w-2 h-2 bg-green-500 rounded-full mr-1"></span> Online</p>
                </div>
                <i class="fas fa-chevron-up text-gray-400 text-xs"></i>
            </button>
            <div id="adminMenu" class="hidden absolute bottom-full left-0 w-full mb-2 px-4">
                <div class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden">
                    <button onclick="logout()"
                        class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 flex items-center transition-colors">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout Securely
                    </button>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 h-screen overflow-y-auto p-6 lg:p-8 relative">

        <!-- DASHBOARD SECTION -->
        <section id="dashboard-section" class="section-content block animate-fadeIn">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Overview</h1>

            <!-- User Stats (Existing) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500">Total Players</p>
                            <h3 id="dash-players" class="text-3xl font-bold">...</h3>
                        </div>
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-full"><i class="fas fa-running text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500">Coaching Staff</p>
                            <h3 id="dash-coaches" class="text-3xl font-bold">...</h3>
                        </div>
                        <div class="p-3 bg-green-50 text-green-600 rounded-full"><i class="fas fa-user-tie text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500">Registered Fans</p>
                            <h3 id="dash-fans" class="text-3xl font-bold">...</h3>
                        </div>
                        <div class="p-3 bg-purple-50 text-purple-600 rounded-full"><i class="fas fa-users text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Analytics -->
            <h2 class="text-xl font-bold text-gray-800 mb-4">Financial Analytics</h2>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- 1. Sales Cards Column -->
                <div class="space-y-6">
                    <!-- Total Revenue -->
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 rounded-xl shadow-lg text-white">
                        <p class="text-blue-100 text-sm font-medium mb-1">Total Revenue</p>
                        <h3 id="dash-total-revenue" class="text-3xl font-bold">KES 0.00</h3>
                        <p class="text-xs text-blue-200 mt-2">Combined Jerseys & Tickets</p>
                    </div>

                    <!-- Jersey Sales -->
                    <div
                        class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase">Jersey Sales</p>
                            <h4 id="dash-jersey-revenue" class="text-2xl font-bold text-gray-800">KES 0.00</h4>
                        </div>
                        <div
                            class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600">
                            <i class="fa-solid fa-shirt"></i>
                        </div>
                    </div>

                    <!-- Ticket Sales -->
                    <div
                        class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase">Ticket Sales</p>
                            <h4 id="dash-ticket-revenue" class="text-2xl font-bold text-gray-800">KES 0.00</h4>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-600">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                    </div>
                </div>

                <!-- 2. Chart Section -->
                <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-gray-700">Revenue Distribution</h3>
                        <select class="text-xs border rounded p-1 bg-gray-50 text-gray-500">
                            <option>All Time</option>
                        </select>
                    </div>
                    <!-- Canvas for Chart.js -->
                    <div class="relative h-64 w-full">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </section>

        <!-- PLAYERS SECTION -->
        <section id="players-section" class="section-content hidden animate-fadeIn">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">Team Roster</h2>
                    <button onclick="openAddUserModal('player')"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium transition flex items-center">
                        <i class="fas fa-plus mr-2"></i> Add New Player
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                            <tr>
                                <th class="px-6 py-3">Name</th>
                                <th class="px-6 py-3">Email</th>
                                <th class="px-6 py-3">Position</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="players-table"></tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- STAFF SECTION -->
        <section id="staff-section" class="section-content hidden animate-fadeIn">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">Coaching Staff</h2>
                    <button onclick="openAddUserModal('coach')"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium transition flex items-center">
                        <i class="fas fa-plus mr-2"></i> Add Staff Member
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                            <tr>
                                <th class="px-6 py-3">Name</th>
                                <th class="px-6 py-3">Email</th>
                                <th class="px-6 py-3">Role</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="staff-table"></tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- NEWS SECTION -->
        <section id="news-section" class="section-content hidden animate-fadeIn">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Team News</h2>
                <button onclick="openNewsModal()"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium transition flex items-center">
                    <i class="fas fa-plus mr-2"></i> Post News
                </button>
            </div>
            <div id="news-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Dynamic Content -->
            </div>
        </section>

        <!-- FIXTURES SECTION -->
        <section id="fixtures-section" class="section-content hidden animate-fadeIn">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">Match Fixtures</h2>
                    <button onclick="openFixtureModal()"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium transition flex items-center">
                        <i class="fas fa-plus mr-2"></i> Add Fixture
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                            <tr>
                                <th class="px-6 py-3">Date</th>
                                <th class="px-6 py-3">Opponent</th>
                                <th class="px-6 py-3">Venue</th>
                                <th class="px-6 py-3">Competition & Status</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="fixtures-table"></tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- TICKETS SECTION-->
        <section id="tickets-section" class="section-content hidden animate-fadeIn">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Ticket Management</h2>
                    <button onclick="openTicketModal()"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium transition flex items-center">
                        <i class="fas fa-plus mr-2"></i> Add Ticket Type
                    </button>
                </div>
                <div id="tickets-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Dynamic Content -->
                </div>
            </div>
        </section>

        <!-- JERSEYS SECTION -->
        <section id="jerseys-section" class="section-content hidden animate-fadeIn">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Jerseys Management</h2>
                <button onclick="openJerseyModal()"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium transition flex items-center">
                    <i class="fas fa-shirt mr-2"></i> Add New Jersey
                </button>
            </div>
            <!-- Grid for Jersey Cards -->
            <div id="jerseys-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Dynamic Content Injected Here -->
            </div>
        </section>

    </main>

    <!-- --- MODALS --- -->

    <!-- 1. USER MODAL (Players/Staff) -->
    <div id="userModal"
        class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md">
            <form id="addUserForm" onsubmit="handleRegisterUser(event)" class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 id="userModalTitle" class="text-xl font-bold text-gray-800">Add New User</h3>
                    <button type="button" onclick="closeModal('userModal')"
                        class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
                </div>
                <input type="hidden" name="role" id="userRoleInput">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" required
                            class="w-full border rounded-lg p-2.5 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" required
                            class="w-full border rounded-lg p-2.5 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label id="userPositionLabel"
                            class="block text-sm font-medium text-gray-700 mb-1">Position</label>
                        <select name="position" id="userPositionInput" required
                            class="w-full border rounded-lg p-2.5 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none">
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" name="password" required minlength="8"
                                class="w-full border rounded-lg p-2.5 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm</label>
                            <input type="password" id="confirmPassword" required
                                class="w-full border rounded-lg p-2.5 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('userModal')"
                        class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-md">Create
                        User</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. EDIT USER MODAL -->
    <div id="editUserModal"
        class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md">
            <form id="editUserForm" onsubmit="handleUpdateUser(event)" class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Edit User</h3>
                    <button type="button" onclick="closeModal('editUserModal')"
                        class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
                </div>
                <input type="hidden" name="id" id="editUserId"><input type="hidden" name="role"
                    id="editUserRole">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" id="editName" required
                            class="w-full border rounded-lg p-2.5 bg-gray-50 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" id="editEmail" required
                            class="w-full border rounded-lg p-2.5 bg-gray-50 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label id="editPositionLabel"
                            class="block text-sm font-medium text-gray-700 mb-1">Position</label>
                        <select name="position" id="editPosition" required
                            class="w-full border rounded-lg p-2.5 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none">
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">New Password (Optional)</label>
                        <input type="password" name="password" placeholder="Leave blank to keep current"
                            class="w-full border rounded-lg p-2.5 bg-gray-50 focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('editUserModal')"
                        class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 shadow-md">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 3. NEWS MODAL -->
    <div id="newsModal"
        class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg">
            <form id="newsForm" onsubmit="handleNewsSubmit(event)" class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 id="newsModalTitle" class="text-xl font-bold text-gray-800">Post News</h3>
                    <button type="button" onclick="closeModal('newsModal')"
                        class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
                </div>
                <input type="hidden" name="id" id="newsId">
                <div class="space-y-4">
                    <input type="text" name="title" id="newsTitle" placeholder="Headline" required
                        class="w-full border rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none">
                    <textarea name="content" id="newsContent" rows="4" placeholder="News content..." required
                        class="w-full border rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Cover Image</label><input
                            type="file" name="image" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('newsModal')"
                        class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save
                        News</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 4. FIXTURE MODAL (UPDATED WITH STATUS/SCORES) -->
    <div id="fixtureModal"
        class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg">
            <form id="fixtureForm" onsubmit="handleFixtureSubmit(event)" class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 id="fixtureModalTitle" class="text-xl font-bold text-gray-800">Add Fixture</h3>
                    <button type="button" onclick="closeModal('fixtureModal')"
                        class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
                </div>
                <input type="hidden" name="id" id="fixtureId">
                <div class="space-y-4">
                    <input type="text" name="opponent" id="fixtureOpponent" placeholder="Opponent Name" required
                        class="w-full border rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-blue-500">
                    <div class="grid grid-cols-2 gap-4">
                        <input type="datetime-local" name="match_date" id="fixtureDate" required
                            class="w-full border rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-blue-500">
                        <select name="venue" id="fixtureVenue"
                            class="w-full border rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-blue-500">
                            <option value="Home">Home</option>
                            <option value="Away">Away</option>
                        </select>
                    </div>
                    <input type="text" name="competition" id="fixtureCompetition" placeholder="Competition"
                        required class="w-full border rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-blue-500">

                    <!-- NEW: Status and Scores Section -->
                    <div class="border-t pt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Match Status</label>
                        <select name="status" id="fixtureStatus" onchange="toggleScoreFields()"
                            class="w-full border rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-blue-500">
                            <option value="scheduled">Scheduled</option>
                            <option value="live">Live</option>
                            <option value="fulltime">Full Time</option>
                        </select>
                    </div>

                    <div id="scoreFields" class="hidden grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Home Score</label>
                            <input type="number" name="home_score" id="fixtureHomeScore" min="0"
                                class="w-full border rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Away Score</label>
                            <input type="number" name="away_score" id="fixtureAwayScore" min="0"
                                class="w-full border rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('fixtureModal')"
                        class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save
                        Fixture</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 5. TICKET MODAL -->
    <div id="ticketModal"
        class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg">
            <form id="ticketForm" onsubmit="handleTicketSubmit(event)" class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 id="ticketModalTitle" class="text-xl font-bold text-gray-800">Add Ticket Type</h3>
                    <button type="button" onclick="closeModal('ticketModal')"
                        class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
                </div>
                <input type="hidden" name="id" id="ticketId">
                <div class="space-y-4">
                    <select id="ticketFixtureSelect" name="fixture_id" required
                        class="w-full border rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Fixture...</option>
                    </select>
                    <select name="type" id="ticketType" required
                        class="w-full border rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Ticket Type...</option>
                        <option value="Regular">Regular</option>
                        <option value="VIP">VIP</option>
                    </select>

                    <div class="grid grid-cols-2 gap-4">
                        <input type="number" name="price" id="ticketPrice" placeholder="Price" required
                            min="0"
                            class="w-full border rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-blue-500">
                        <input type="number" name="quantity_available" id="ticketQty" placeholder="Qty" required
                            min="1"
                            class="w-full border rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('ticketModal')"
                        class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save
                        Ticket</button>
                </div>
            </form>
        </div>
    </div>
    <!-- JERSEY MODAL -->
    <div id="jerseyModal"
        class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm">
            <form id="jerseyForm" onsubmit="handleJerseySubmit(event)" class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 id="jerseyModalTitle" class="text-xl font-bold text-gray-800">Add Jersey</h3>
                    <button type="button" onclick="closeModal('jerseyModal')"
                        class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <input type="hidden" name="id" id="jerseyId">

                <div class="space-y-4">
                    <!-- Image Input -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jersey Image</label>
                        <input type="file" name="image" id="jerseyImage" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-400 mt-1">Supported: JPG, PNG, JPEG</p>
                    </div>

                    <!-- Price Input -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Price (KES)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">KES</span>
                            <input type="number" name="price" id="jerseyPrice" placeholder="0.00" required
                                min="0" step="0.01"
                                class="w-full border rounded-lg p-2.5 pl-12 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('jerseyModal')"
                        class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-md">
                        Save Jersey
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const API_URL = '/api';
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        };

        // --- NAVIGATION ---
        function switchSection(id) {
            document.querySelectorAll('.nav-item').forEach(el => {
                el.classList.remove('bg-blue-600', 'text-white', 'shadow-md');
                el.classList.add('text-gray-600', 'hover:bg-gray-50');
            });
            const activeBtn = document.getElementById(`nav-${id}`);
            if (activeBtn) {
                activeBtn.classList.remove('text-gray-600', 'hover:bg-gray-50');
                activeBtn.classList.add('bg-blue-600', 'text-white', 'shadow-md');
            }
            document.querySelectorAll('.section-content').forEach(el => el.classList.add('hidden'));
            document.getElementById(`${id}-section`).classList.remove('hidden');

            if (id === 'dashboard') loadDashboardStats();
            if (id === 'players') fetchUsers('player');
            if (id === 'staff') fetchUsers('coach');
            if (id === 'news') loadNews();
            if (id === 'fixtures') loadFixtures();
            if (id === 'tickets') loadTickets();
            if (id === 'jerseys') loadJerseys();
        }

        function toggleAdminMenu() {
            document.getElementById('adminMenu').classList.toggle('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function showToast(msg, type = 'success') {
            const t = document.getElementById('notification');
            t.innerText = msg;
            t.className =
                `fixed bottom-5 right-5 transform transition-all duration-300 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
            t.classList.remove('translate-y-20', 'opacity-0');
            setTimeout(() => t.classList.add('translate-y-20', 'opacity-0'), 3000);
        }

        // --- PLAYERS & STAFF LOGIC ---
        function openAddUserModal(role) {
            document.getElementById('addUserForm').reset();
            document.getElementById('userRoleInput').value = role;
            document.getElementById('userModalTitle').innerText = role === 'player' ? 'Add New Player' :
                'Add Coaching Staff';

            // UPDATED: Dynamic Select Logic
            const label = document.getElementById('userPositionLabel');
            const select = document.getElementById('userPositionInput');
            select.innerHTML = ''; // clear options

            if (role === 'player') {
                label.innerText = 'Position';
                const options = ['Goalkeeper', 'Defender', 'Midfielder', 'Striker'];
                options.forEach(opt => select.add(new Option(opt, opt)));
            } else {
                label.innerText = 'Role';
                const options = ['Head Coach', 'Assistant Coach', 'Set-piece Coach', 'Medical Coach'];
                options.forEach(opt => select.add(new Option(opt, opt)));
            }

            document.getElementById('userModal').classList.remove('hidden');
        }

        async function handleRegisterUser(e) {
            e.preventDefault();
            if (e.target.password.value !== document.getElementById('confirmPassword').value) return showToast(
                'Passwords mismatch', 'error');
            const payload = Object.fromEntries(new FormData(e.target));
            const res = await fetch(`${API_URL}/register`, {
                method: 'POST',
                headers,
                body: JSON.stringify(payload)
            });
            const data = await res.json();
            if (res.ok) {
                showToast('User added!');
                closeModal('userModal');
                fetchUsers(payload.role);
                loadDashboardStats();
            } else showToast(data.message || 'Error', 'error');
        }

        async function fetchUsers(role) {
            const tbody = document.getElementById(role === 'player' ? 'players-table' : 'staff-table');
            tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4">Loading...</td></tr>';
            const res = await fetch(`${API_URL}/users?role=${role}`, {
                headers
            });
            const json = await res.json();
            tbody.innerHTML = '';
            if (!json.data || json.data.length === 0) {
                tbody.innerHTML =
                    `<tr><td colspan="4" class="text-center py-8 text-gray-500">No records found</td></tr>`;
                return;
            }
            json.data.forEach(u => {
                tbody.innerHTML += `
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900"><div class="flex items-center"><div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mr-3 text-xs font-bold">${u.name.charAt(0)}</div>${u.name}</div></td>
                        <td class="px-6 py-4 text-gray-500">${u.email}</td>
                        <td class="px-6 py-4"><span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">${u.position || 'N/A'}</span></td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button onclick='openEditUserModal(${JSON.stringify(u)})' class="text-blue-600 hover:underline text-sm">Edit</button>
                            <button onclick="deleteUser(${u.id}, '${role}')" class="text-red-600 hover:underline text-sm">Delete</button>
                        </td>
                    </tr>`;
            });
        }

        function openEditUserModal(u) {
            document.getElementById('editUserId').value = u.id;
            document.getElementById('editUserRole').value = u.role;
            document.getElementById('editName').value = u.name;
            document.getElementById('editEmail').value = u.email;

            // UPDATED: Dynamic Select Logic for Edit
            const label = document.getElementById('editPositionLabel');
            const select = document.getElementById('editPosition');
            select.innerHTML = '';

            if (u.role === 'player') {
                label.innerText = 'Position';
                const options = ['Goalkeeper', 'Defender', 'Midfielder', 'Striker'];
                options.forEach(opt => select.add(new Option(opt, opt)));
            } else {
                label.innerText = 'Role';
                const options = ['Head Coach', 'Assistant Coach', 'Set-piece Coach', 'Medical Coach'];
                options.forEach(opt => select.add(new Option(opt, opt)));
            }

            select.value = u.position || '';

            // Clear password field
            const pass = document.querySelector('#editUserModal input[name="password"]');
            if (pass) pass.value = '';

            document.getElementById('editUserModal').classList.remove('hidden');
        }

        async function handleUpdateUser(e) {
            e.preventDefault();
            const fd = new FormData(e.target);
            const payload = {};
            fd.forEach((v, k) => {
                if (k !== 'password' || v.trim() !== '') payload[k] = v;
            });
            const res = await fetch(`${API_URL}/users/${payload.id}`, {
                method: 'PUT',
                headers,
                body: JSON.stringify(payload)
            });
            if (res.ok) {
                showToast('Updated!');
                closeModal('editUserModal');
                fetchUsers(payload.role);
            }
        }

        async function deleteUser(id, role) {
            if (!confirm('Are you sure?')) return;
            const res = await fetch(`${API_URL}/users/${id}`, {
                method: 'DELETE',
                headers
            });
            if (res.ok) {
                showToast('Deleted');
                fetchUsers(role);
                loadDashboardStats();
            }
        }

        // --- NEWS LOGIC ---
        function openNewsModal(item = null) {
            document.getElementById('newsForm').reset();
            document.getElementById('newsId').value = '';
            document.getElementById('newsModalTitle').innerText = 'Post News';
            if (item) {
                document.getElementById('newsId').value = item.id;
                document.getElementById('newsTitle').value = item.title;
                document.getElementById('newsContent').value = item.content;
                document.getElementById('newsModalTitle').innerText = 'Edit News';
            }
            document.getElementById('newsModal').classList.remove('hidden');
        }

        async function loadNews() {
            const res = await fetch(`${API_URL}/news`);
            const json = await res.json();
            const grid = document.getElementById('news-grid');
            const newsData = json.data || json;

            // Separate items by type
            const imageItems = newsData.filter(item => item.image_path);
            const textItems = newsData.filter(item => !item.image_path);

            grid.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    ${imageItems.map(item => `
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                            <div class="aspect-video bg-gray-200 relative overflow-hidden">
                                <img src="/storage/${item.image_path}" class="w-full h-full object-cover" onload="this.parentElement.style.aspectRatio = this.naturalWidth/this.naturalHeight">
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold text-lg text-gray-800 mb-2">${item.title}</h3>
                                <p class="text-gray-600 text-sm line-clamp-3 mb-4">${item.content}</p>
                                <div class="flex justify-between items-center border-t pt-4">
                                    <span class="text-xs text-gray-400">${new Date(item.created_at).toLocaleDateString()}</span>
                                    <div class="space-x-2">
                                        <button onclick='openNewsModal(${JSON.stringify(item)})' class="text-blue-600 hover:text-blue-800"><i class="fas fa-edit"></i></button>
                                        <button onclick="deleteItem('news', ${item.id})" class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `).join('')}
                </div>
                <div class="flex flex-col gap-4 mt-6">
                    ${textItems.map(item => `
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                            <h3 class="font-bold text-xl text-gray-800 mb-3">${item.title}</h3>
                            <p class="text-gray-700 text-base leading-relaxed mb-4">${item.content}</p>
                            <div class="flex justify-between items-center border-t pt-4">
                                <span class="text-sm text-gray-500">${new Date(item.created_at).toLocaleDateString()}</span>
                                <div class="space-x-3">
                                    <button onclick='openNewsModal(${JSON.stringify(item)})' class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</button>
                                    <button onclick="deleteItem('news', ${item.id})" class="text-red-500 hover:text-red-700 text-sm font-medium">Delete</button>
                                </div>
                            </div>
                        </div>
                    `).join('')}
                </div>
            `;
        }

        async function handleNewsSubmit(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const id = document.getElementById('newsId').value;
            let url = id ? `${API_URL}/news/${id}` : `${API_URL}/news`;
            let method = 'POST';
            if (id) formData.append('_method', 'PUT');
            const res = await fetch(url, {
                method: method,
                body: formData
            });
            if (res.ok) {
                showToast('News saved!');
                closeModal('newsModal');
                loadNews();
            }
        }

        // --- FIXTURES LOGIC (UPDATED WITH STATUS & SCORES) ---

        // Helper to show/hide score inputs
        function toggleScoreFields() {
            const status = document.getElementById('fixtureStatus').value;
            const scoreFields = document.getElementById('scoreFields');

            if (status === 'live' || status === 'fulltime') {
                scoreFields.classList.remove('hidden');
            } else {
                scoreFields.classList.add('hidden');
                // Clear scores when hiding to avoid accidental submissions
                document.getElementById('fixtureHomeScore').value = '';
                document.getElementById('fixtureAwayScore').value = '';
            }
        }

        function openFixtureModal(item = null) {
            document.getElementById('fixtureForm').reset();
            document.getElementById('fixtureId').value = '';
            document.getElementById('fixtureModalTitle').innerText = 'Add Fixture';

            // Reset score fields visibility default (hidden)
            document.getElementById('scoreFields').classList.add('hidden');

            if (item) {
                document.getElementById('fixtureId').value = item.id;
                document.getElementById('fixtureOpponent').value = item.opponent;

                const d = new Date(item.match_date);
                d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
                document.getElementById('fixtureDate').value = d.toISOString().slice(0, 16);

                document.getElementById('fixtureVenue').value = item.venue;
                document.getElementById('fixtureCompetition').value = item.competition;

                // Set Status
                document.getElementById('fixtureStatus').value = item.status || 'scheduled';

                // Set Scores
                document.getElementById('fixtureHomeScore').value = item.home_score || '';
                document.getElementById('fixtureAwayScore').value = item.away_score || '';

                document.getElementById('fixtureModalTitle').innerText = 'Edit Fixture';

                // Trigger toggle to show fields if needed based on the loaded status
                toggleScoreFields();
            }
            document.getElementById('fixtureModal').classList.remove('hidden');
        }

        async function loadFixtures() {
            const res = await fetch(`${API_URL}/fixtures`);
            const json = await res.json();
            const tbody = document.getElementById('fixtures-table');
            tbody.innerHTML = '';

            json.data.forEach(item => {
                // Determine Badge Color
                const statusBadge = item.status === 'fulltime' ? 'bg-green-100 text-green-800' :
                                   item.status === 'live' ? 'bg-red-100 text-red-800' :
                                   'bg-gray-100 text-gray-800';

                // Determine Score Display
                const scoreDisplay = (item.status === 'live' || item.status === 'fulltime') &&
                                    item.home_score !== null && item.away_score !== null ?
                                    `<br><span class="text-sm font-bold mt-1 inline-block">Score: ${item.home_score} - ${item.away_score}</span>` : '';

                tbody.innerHTML += `
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium">${new Date(item.match_date).toLocaleString()}</td>
                        <td class="px-6 py-4 font-bold">
                            ${item.opponent}
                            ${scoreDisplay}
                        </td>
                        <td class="px-6 py-4"><span class="${item.venue === 'Home' ? 'text-green-600 bg-green-100' : 'text-orange-600 bg-orange-100'} px-2 py-1 rounded text-xs font-bold uppercase">${item.venue}</span></td>
                        <td class="px-6 py-4">
                            <div>${item.competition}</div>
                            <span class="${statusBadge} px-2 py-0.5 rounded text-[10px] font-bold uppercase mt-1 inline-block">${item.status || 'scheduled'}</span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button onclick='openFixtureModal(${JSON.stringify(item)})' class="text-blue-600 hover:underline text-sm">Edit</button>
                            <button onclick="deleteItem('fixtures', ${item.id})" class="text-red-600 hover:underline text-sm">Delete</button>
                        </td>
                    </tr>`;
            });
            return json.data;
        }

        async function handleFixtureSubmit(e) {
            e.preventDefault();
            const payload = Object.fromEntries(new FormData(e.target));
            const id = document.getElementById('fixtureId').value;
            const url = id ? `${API_URL}/fixtures/${id}` : `${API_URL}/fixtures`;
            const method = id ? 'PUT' : 'POST';
            const res = await fetch(url, {
                method: method,
                headers,
                body: JSON.stringify(payload)
            });
            if (res.ok) {
                showToast('Fixture saved!');
                closeModal('fixtureModal');
                loadFixtures();
            }
        }

        // --- TICKETS LOGIC ---
        async function openTicketModal(item = null) {
            const fixtures = await loadFixtures();
            const select = document.getElementById('ticketFixtureSelect');
            select.innerHTML = '<option value="">Select Fixture...</option>';
            fixtures.forEach(f => select.innerHTML +=
                `<option value="${f.id}">${f.opponent} (${new Date(f.match_date).toLocaleDateString()})</option>`);
            document.getElementById('ticketForm').reset();
            document.getElementById('ticketId').value = '';
            document.getElementById('ticketModalTitle').innerText = 'Add Ticket Type';
            if (item) {
                document.getElementById('ticketId').value = item.id;
                document.getElementById('ticketFixtureSelect').value = item.fixture_id;
                document.getElementById('ticketType').value = item.type;
                document.getElementById('ticketPrice').value = item.price;
                document.getElementById('ticketQty').value = item.quantity_available;
                document.getElementById('ticketModalTitle').innerText = 'Edit Ticket';
            }
            document.getElementById('ticketModal').classList.remove('hidden');
        }

        async function loadTickets() {
            const res = await fetch(`${API_URL}/tickets`);
            const json = await res.json();
            const grid = document.getElementById('tickets-container');
            grid.innerHTML = '';
            json.data.forEach(item => {
                grid.innerHTML += `
                    <div class="border border-gray-200 rounded-xl p-5 hover:border-blue-300 transition relative bg-white shadow-sm">
                        <div class="absolute top-4 right-4 space-x-2">
                             <button onclick='openTicketModal(${JSON.stringify(item)})' class="text-gray-400 hover:text-blue-600"><i class="fas fa-edit"></i></button>
                             <button onclick="deleteItem('tickets', ${item.id})" class="text-gray-400 hover:text-red-500"><i class="fas fa-trash"></i></button>
                        </div>
                        <div class="text-sm text-blue-600 font-bold uppercase tracking-wider mb-1">${item.type} Ticket</div>
                        <div class="text-2xl font-bold text-gray-800 mb-1">KES ${item.price}</div>
                        <div class="text-sm text-gray-500 mb-4">${item.fixture ? 'vs ' + item.fixture.opponent : 'General Entry'}</div>
                        <div class="w-full bg-gray-100 rounded-full h-2 mb-2"><div class="bg-blue-600 h-2 rounded-full" style="width: 100%"></div></div>
                        <div class="text-xs text-gray-500 flex justify-between"><span>Available</span><span class="font-bold text-gray-700">${item.quantity_available}</span></div>
                    </div>`;
            });
        }
        async function handleTicketSubmit(e) {
            e.preventDefault();
            const payload = Object.fromEntries(new FormData(e.target));
            const id = document.getElementById('ticketId').value;
            const url = id ? `${API_URL}/tickets/${id}` : `${API_URL}/tickets`;
            const method = id ? 'PUT' : 'POST';
            const res = await fetch(url, {
                method: method,
                headers,
                body: JSON.stringify(payload)
            });
            if (res.ok) {
                showToast('Ticket saved!');
                closeModal('ticketModal');
                loadTickets();
            }
        }

        // --- JERSEYS LOGIC ---

        // 1. Open Modal
        function openJerseyModal(item = null) {
            document.getElementById('jerseyForm').reset();
            document.getElementById('jerseyId').value = '';
            document.getElementById('jerseyModalTitle').innerText = 'Add New Jersey';

            // Remove "required" from image if editing (since they might not want to change the image)
            document.getElementById('jerseyImage').required = true;

            if (item) {
                document.getElementById('jerseyId').value = item.id;
                document.getElementById('jerseyPrice').value = item.price;
                document.getElementById('jerseyModalTitle').innerText = 'Edit Jersey';
                // Image is optional during edit
                document.getElementById('jerseyImage').required = false;
            }
            document.getElementById('jerseyModal').classList.remove('hidden');
        }

        // 2. Load Data
        async function loadJerseys() {
            const grid = document.getElementById('jerseys-grid');
            grid.innerHTML = '<p class="text-gray-500 col-span-full text-center">Loading jerseys...</p>';

            try {
                const res = await fetch(`${API_URL}/jerseys`);
                const json = await res.json();

                grid.innerHTML = '';

                if (!json.data || json.data.length === 0) {
                    grid.innerHTML =
                    '<p class="text-gray-400 col-span-full text-center py-8">No jerseys added yet.</p>';
                    return;
                }

                json.data.forEach(item => {
                    grid.innerHTML += `
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                <div class="h-56 bg-gray-100 relative overflow-hidden">
                    <img src="/storage/${item.image_path}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute top-2 right-2 flex space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                         <button onclick='openJerseyModal(${JSON.stringify(item)})' class="bg-white p-2 rounded-full shadow text-blue-600 hover:text-blue-800"><i class="fas fa-edit"></i></button>
                         <button onclick="deleteItem('jerseys', ${item.id})" class="bg-white p-2 rounded-full shadow text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <div class="p-4 text-center">
                    <p class="text-gray-500 text-xs uppercase font-bold tracking-wider mb-1">Official Kit</p>
                    <h3 class="text-xl font-bold text-gray-800">KES ${parseFloat(item.price).toLocaleString()}</h3>
                </div>
            </div>`;
                });
            } catch (error) {
                console.error(error);
                grid.innerHTML = '<p class="text-red-500">Failed to load jerseys.</p>';
            }
        }

        // 3. Handle Submit (Create/Update with File Upload)
        async function handleJerseySubmit(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const id = document.getElementById('jerseyId').value;

            let url = `${API_URL}/jerseys`;
            let method = 'POST';

            if (id) {
                url = `${API_URL}/jerseys/${id}`;
                // Laravel requires POST with _method field for file uploads on update
                formData.append('_method', 'PUT');
            }

            try {
                const res = await fetch(url, {
                    method: 'POST', // Always POST when sending FormData with files (even for PUT via _method)
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                        // Note: Do NOT set 'Content-Type': 'application/json' here.
                        // Let the browser set the Content-Type automatically for FormData (multipart/form-data).
                    },
                    body: formData
                });

                const data = await res.json();

                if (res.ok) {
                    showToast('Jersey saved successfully!');
                    closeModal('jerseyModal');
                    loadJerseys();
                } else {
                    showToast(data.message || 'Error saving jersey', 'error');
                }
            } catch (error) {
                showToast('Network error', 'error');
            }
        }

        async function deleteItem(endpoint, id) {
            if (!confirm('Are you sure?')) return;
            const res = await fetch(`${API_URL}/${endpoint}/${id}`, {
                method: 'DELETE',
                headers
            });
            if (res.ok) {
                showToast('Deleted!');
                if (endpoint === 'news') loadNews();
                if (endpoint === 'fixtures') loadFixtures();
                if (endpoint === 'tickets') loadTickets();
                if (endpoint === 'jerseys') loadJerseys();

            }
        }

        // Global variable to store chart instance so we can destroy it before re-drawing
        let salesChartInstance = null;

        // --- UPDATED DASHBOARD LOADER ---
        async function loadDashboardStats() {
            // 1. Load User Counts (Existing)
            try {
                const res = await fetch(`${API_URL}/user-counts`, {
                    headers
                });
                const json = await res.json();
                if (json.success) {
                    document.getElementById('dash-players').innerText = json.data.players;
                    document.getElementById('dash-coaches').innerText = json.data.coaches;
                    document.getElementById('dash-fans').innerText = json.data.fans;
                }
            } catch (e) {
                console.error("Error loading user counts", e);
            }

            // 2. Load Sales Stats (NEW)
            try {
                const res = await fetch(`${API_URL}/sales-stats`, {
                    headers
                });
                const json = await res.json();

                if (json.success) {
                    const data = json.data;

                    // Format numbers to Currency
                    const formatCurrency = (amount) => 'KES ' + parseFloat(amount).toLocaleString(undefined, {
                        minimumFractionDigits: 2
                    });

                    // Update Text Cards
                    document.getElementById('dash-total-revenue').innerText = formatCurrency(data.total_revenue);
                    document.getElementById('dash-jersey-revenue').innerText = formatCurrency(data.jersey_revenue);
                    document.getElementById('dash-ticket-revenue').innerText = formatCurrency(data.ticket_revenue);

                    // Render Chart
                    renderSalesChart(data.jersey_revenue, data.ticket_revenue);
                }
            } catch (e) {
                console.error("Error loading sales stats", e);
            }
        }

        // --- NEW CHART FUNCTION ---
        function renderSalesChart(jerseySales, ticketSales) {
            const ctx = document.getElementById('salesChart').getContext('2d');

            // Destroy existing chart if it exists to prevent overlap/glitches
            if (salesChartInstance) {
                salesChartInstance.destroy();
            }

            // Determine colors
            const jerseyColor = '#f97316'; // Orange-500
            const ticketColor = '#0d9488'; // Teal-600

            salesChartInstance = new Chart(ctx, {
                type: 'doughnut', // 'doughnut' looks modern, 'bar' is also good
                data: {
                    labels: ['Jerseys', 'Tickets'],
                    datasets: [{
                        label: 'Revenue (KES)',
                        data: [jerseySales, ticketSales],
                        backgroundColor: [jerseyColor, ticketColor],
                        hoverOffset: 4,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                font: {
                                    family: 'Inter'
                                }
                            }
                        }
                    },
                    cutout: '70%', // Makes the doughnut thinner
                }
            });
        }

        async function logout() {
            try {
                await fetch(`${API_URL}/logout`, {
                    method: 'POST',
                    headers
                });
                window.location.href = '/';
            } catch (e) {
                window.location.href = '/';
            }
        }

        document.addEventListener('DOMContentLoaded', () => loadDashboardStats());
    </script>
</body>

</html>
