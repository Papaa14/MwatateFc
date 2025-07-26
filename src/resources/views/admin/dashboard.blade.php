<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mwatate FC Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Background images for each section */
        .dashboard-bg {
            background-image: linear-gradient(rgba(255,255,255,0.95), rgba(255,255,255,0.95)), 
                            url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .uploads-bg {
            background-image: linear-gradient(rgba(255,255,255,0.95), rgba(255,255,255,0.95)), 
                            url('https://images.unsplash.com/photo-1589487391730-58f20eb2c308?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
        }
        
        .players-bg {
            background-image: linear-gradient(rgba(255,255,255,0.95), rgba(255,255,255,0.95)), 
                            url('https://images.unsplash.com/photo-1543357486-c2505d3d0385?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
        }
        
        .staff-bg {
            background-image: linear-gradient(rgba(255,255,255,0.95), rgba(255,255,255,0.95)), 
                            url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
        }
        
        .financials-bg {
            background-image: linear-gradient(rgba(255,255,255,0.95), rgba(255,255,255,0.95)), 
                            url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
        }
        
        .blog-bg {
            background-image: linear-gradient(rgba(255,255,255,0.95), rgba(255,255,255,0.95)), 
                            url('https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
        }
        
        /* Button animations and styles */
        .btn {
            transition: all 0.3s ease-in-out;
            transform: translateY(0);
            position: relative;
            overflow: hidden;
            cursor: pointer;
            font-weight: 500;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .btn:active {
            transform: translateY(1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.6);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }
        .btn:focus:not(:active)::after {
            animation: ripple 0.6s ease-out;
        }
        .btn-primary {
            background-color: #2563eb;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.1);
        }
        .btn-primary:hover {
            background-color: #1d4ed8;
        }
        .btn-secondary {
            background-color: #e5e7eb;
            color: #374151;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .btn-secondary:hover {
            background-color: #d1d5db;
        }
        .btn-danger {
            background-color: #ef4444;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.1);
        }
        .btn-danger:hover {
            background-color: #dc2626;
        }
        .btn-icon {
            padding: 0.5rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }
        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1.125rem;
        }
        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            100% {
                transform: scale(20, 20);
                opacity: 0;
            }
        }
        
        /* Active navigation button */
        .nav-btn.active {
            background-color: #2563eb;
            color: white;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
        }
        .nav-btn:not(.active):hover {
            background-color: #f1f5f9;
            color: #1e40af;
        }
        
        /* Content transition */
        .content-section {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }
        .content-section.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Card hover effects */
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .card {
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="dashboard-bg">
    <div class="flex min-h-screen">
        <!-- Sidebar Navigation -->
        <aside class="w-64 flex-shrink-0 bg-white shadow-md">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="h-16 flex items-center justify-center border-b">
                     <div class="flex items-center space-x-2">
                        <div class="inline-flex items-center justify-center w-10 h-10 bg-green-100 rounded-full">
                           <i class="fas fa-futbol text-green-600 text-xl"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-800">Mwatate FC</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="flex-1 px-4 py-4 space-y-2">
                    <button data-section="dashboard" class="nav-btn active btn w-full flex items-center px-4 py-3 text-sm font-medium rounded-lg">
                        <i class="fas fa-chart-bar mr-3"></i>
                        Dashboard
                    </button>
                    <button data-section="uploads" class="nav-btn btn w-full flex items-center px-4 py-3 text-sm font-medium text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-upload mr-3"></i>
                        Uploads
                    </button>
                    <div>
                        <p class="px-4 pt-4 pb-2 text-xs font-semibold text-gray-400 uppercase">Manage</p>
                        <button data-section="players" class="nav-btn btn w-full flex items-center px-4 py-3 text-sm font-medium text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100">
                            <i class="fas fa-users mr-3"></i>
                            Players
                        </button>
                         <button data-section="staff" class="nav-btn btn w-full flex items-center px-4 py-3 text-sm font-medium text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100">
                            <i class="fas fa-user-tie mr-3"></i>
                            Coaching Staff
                        </button>
                    </div>
                     <button data-section="financials" class="nav-btn btn w-full flex items-center px-4 py-3 text-sm font-medium text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-money-bill-wave mr-3"></i>
                        Financials
                    </button>
                    <button data-section="blog" class="nav-btn btn w-full flex items-center px-4 py-3 text-sm font-medium text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-newspaper mr-3"></i>
                        Blog
                    </button>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 lg:p-8 overflow-auto">
            <!-- Dashboard Content -->
            <section id="dashboard-content" class="content-section active">
                <!-- Header -->
                <header class="flex items-center justify-between mb-8">
                    <div>
                        <p class="text-sm text-gray-500">Home / <span class="font-semibold text-gray-800">Dashboard</span></p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="btn p-2 text-gray-500 bg-white rounded-full shadow-sm hover:text-gray-700 hover:bg-gray-100 focus:outline-none">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center transform translate-x-1 -translate-y-1">3</span>
                        </button>
                        <img class="w-10 h-10 rounded-full ring-2 ring-blue-500" src="https://i.pravatar.cc/150?u=a042581f4e29026704d" alt="Admin Avatar">
                    </div>
                </header>

                <!-- Stat Cards -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                    <div class="card p-6 rounded-lg shadow-sm">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase">Total Players</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900">32</p>
                                <button id="view-players-btn" class="btn mt-4 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    View Players
                                </button>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-full">
                               <i class="fas fa-users text-blue-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card p-6 rounded-lg shadow-sm">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase">Active Fans</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900">12,480</p>
                                <button id="view-analytics-btn" class="btn mt-4 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    View Analytics
                                </button>
                            </div>
                            <div class="p-3 bg-green-100 rounded-full">
                                <i class="fas fa-users text-green-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card p-6 rounded-lg shadow-sm">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase">Coaching Staff</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900">8</p>
                                <button class="btn mt-4 px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Manage Staff
                                </button>
                            </div>
                            <div class="p-3 bg-red-100 rounded-full">
                               <i class="fas fa-user-tie text-red-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Chart / Content -->
                <div class="mt-8 card rounded-lg shadow-sm">
                    <div class="p-6 border-b">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Team Performance Overview</h3>
                                <p class="text-sm text-gray-500">January - June 2023</p>
                            </div>
                            <button class="btn px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Export Data
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <!-- Chart Placeholder -->
                        <div class="flex items-center justify-center w-full h-80 bg-gray-50 rounded-lg">
                            <p class="text-gray-400">Chart will be rendered here (e.g., using Chart.js)</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Table -->
                <div class="mt-8 card rounded-lg shadow-sm">
                    <div class="p-6 border-b">
                         <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-gray-800">Upcoming Fixtures</h3>
                            <button class="btn px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Add Fixture
                            </button>
                         </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Opponent</th>
                                    <th scope="col" class="px-6 py-3">Competition</th>
                                    <th scope="col" class="px-6 py-3">Date</th>
                                    <th scope="col" class="px-6 py-3">Venue</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">Vihiga United</th>
                                    <td class="px-6 py-4">National Super League</td>
                                    <td class="px-6 py-4">28 Oct 2023</td>
                                    <td class="px-6 py-4">Home</td>
                                    <td class="px-6 py-4">
                                        <button class="btn text-blue-600 hover:text-blue-800 mr-3">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">Shabana FC</th>
                                    <td class="px-6 py-4">FKF Cup</td>
                                    <td class="px-6 py-4">04 Nov 2023</td>
                                    <td class="px-6 py-4">Away</td>
                                    <td class="px-6 py-4">
                                        <button class="btn text-blue-600 hover:text-blue-800 mr-3">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                 <tr class="bg-white hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">Bandari FC</th>
                                    <td class="px-6 py-4">Friendly</td>
                                    <td class="px-6 py-4">11 Nov 2023</td>
                                    <td class="px-6 py-4">Home</td>
                                    <td class="px-6 py-4">
                                        <button class="btn text-blue-600 hover:text-blue-800 mr-3">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Uploads Content -->
            <section id="uploads-content" class="content-section">
                <div class="card p-6 rounded-lg shadow-sm">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Uploads Management</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Upload Card -->
                        <div class="card p-4 rounded-lg border border-gray-200 hover:border-blue-300">
                            <div class="flex items-center justify-between mb-3">
                                <i class="fas fa-image text-blue-500 text-2xl"></i>
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Images</span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">Team Photos</h3>
                            <p class="text-sm text-gray-500 mb-3">Last updated: 15 Oct 2023</p>
                            <button class="btn w-full py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                View Uploads
                            </button>
                        </div>
                        <!-- More upload cards would go here -->
                    </div>
                </div>
            </section>

            <!-- Players Content -->
            <section id="players-content" class="content-section">
                <div class="card p-6 rounded-lg shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Player Management</h2>
                        <button 
                            id="add-player-btn"
                            class="btn px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            onclick="showPlayerModal()"
                        >
                            Add New Player
                        </button>
                    </div>

                    <!-- Add Player Modal -->
                    <div id="playerModal" class="fixed inset-0 z-50 hidden">
                        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"></div>
                        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                            <div class="bg-white rounded-lg shadow-xl max-w-md w-full transform transition-all">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-xl font-bold text-gray-800">Add New Player</h3>
                                        <button onclick="hidePlayerModal()" class="text-gray-400 hover:text-gray-500">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <form id="addPlayerForm" class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                            <input type="text" id="playerName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Position</label>
                                            <select id="playerPosition" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                <option value="">Select Position</option>
                                                <option value="Goalkeeper">Goalkeeper</option>
                                                <option value="Defender">Defender</option>
                                                <option value="Midfielder">Midfielder</option>
                                                <option value="Forward">Forward</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Jersey Number</label>
                                            <input type="number" id="jerseyNumber" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Status</label>
                                            <select id="playerStatus" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                <option value="Active">Active</option>
                                                <option value="Injured">Injured</option>
                                                <option value="Suspended">Suspended</option>
                                            </select>
                                        </div>
                                        <div class="mt-6 flex justify-end space-x-3">
                                            <button type="button" onclick="hidePlayerModal()" class="btn-secondary">
                                                Cancel
                                            </button>
                                            <button type="submit" class="btn-primary">
                                                Add Player
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Player</th>
                                    <th scope="col" class="px-6 py-3">Position</th>
                                    <th scope="col" class="px-6 py-3">Jersey #</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img class="w-8 h-8 rounded-full mr-3" src="https://i.pravatar.cc/150?u=player1" alt="Player">
                                            John Okoro
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">Striker</td>
                                    <td class="px-6 py-4">9</td>
                                    <td class="px-6 py-4">
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Active</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button 
                                            class="btn text-blue-600 hover:text-blue-800 mr-3"
                                            data-section="players"
                                            onclick="
                                                document.querySelectorAll('.nav-btn').forEach(btn => {
                                                    btn.classList.remove('active', 'text-white', 'bg-blue-600');
                                                    btn.classList.add('text-gray-700', 'bg-gray-50');
                                                });
                                                document.querySelector('[data-section=players]').classList.add('active', 'text-white', 'bg-blue-600');
                                                document.querySelector('[data-section=players]').classList.remove('text-gray-700', 'bg-gray-50');
                                                document.querySelectorAll('.content-section').forEach(section => {
                                                    section.classList.remove('active');
                                                });
                                                document.getElementById('players-content').classList.add('active');
                                                document.body.className = 'antialiased players-bg';
                                            "
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button 
                                            class="btn text-red-600 hover:text-red-800"
                                            data-section="players"
                                            onclick="
                                                document.querySelectorAll('.nav-btn').forEach(btn => {
                                                    btn.classList.remove('active', 'text-white', 'bg-blue-600');
                                                    btn.classList.add('text-gray-700', 'bg-gray-50');
                                                });
                                                document.querySelector('[data-section=players]').classList.add('active', 'text-white', 'bg-blue-600');
                                                document.querySelector('[data-section=players]').classList.remove('text-gray-700', 'bg-gray-50');
                                                document.querySelectorAll('.content-section').forEach(section => {
                                                    section.classList.remove('active');
                                                });
                                                document.getElementById('players-content').classList.add('active');
                                                document.body.className = 'antialiased players-bg';
                                            "
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <!-- More player rows would go here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Coaching Staff Content -->
            <section id="staff-content" class="content-section">
                <div class="card p-6 rounded-lg shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Coaching Staff</h2>
                        <button class="btn px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                            Add Staff Member
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Staff Card -->
                        <div class="card p-4 rounded-lg border border-gray-200 hover:border-blue-300">
                            <div class="flex items-center mb-4">
                                <img class="w-12 h-12 rounded-full mr-4" src="https://i.pravatar.cc/150?u=coach1" alt="Coach">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Coach Miller</h3>
                                    <p class="text-sm text-gray-500">Head Coach</p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm bg-blue-100 text-blue-800 px-2 py-1 rounded">Full-time</span>
                                <button class="btn text-blue-600 hover:text-blue-800">
                                    View Profile
                                </button>
                            </div>
                        </div>
                        <!-- More staff cards would go here -->
                    </div>
                </div>
            </section>

            <!-- Financials Content -->
            <section id="financials-content" class="content-section">
                <div class="card p-6 rounded-lg shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Financial Overview</h2>
                        <button class="btn px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                            Generate Report
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Financial Card -->
                        <div class="card p-4 rounded-lg border border-gray-200">
                            <p class="text-sm font-medium text-gray-500 uppercase">Total Revenue</p>
                            <p class="mt-2 text-2xl font-bold text-green-600">$245,380</p>
                            <p class="text-xs text-gray-500 mt-1">Last 30 days</p>
                        </div>
                        <!-- More financial cards would go here -->
                    </div>
                    
                    <div class="h-80 bg-gray-50 rounded-lg flex items-center justify-center">
                        <p class="text-gray-400">Financial charts will be rendered here</p>
                    </div>
                </div>
            </section>

            <!-- Blog Content -->
            <section id="blog-content" class="content-section">
                <div class="card p-6 rounded-lg shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Blog Management</h2>
                        <button class="btn px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                            New Post
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Blog Post Card -->
                        <div class="card p-4 rounded-lg border border-gray-200 hover:border-blue-300">
                            <div class="h-40 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                                <i class="fas fa-image text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Match Recap: Victory Against Vihiga</h3>
                            <p class="text-sm text-gray-500 mb-4">Published: 16 Oct 2023</p>
                            <div class="flex justify-between items-center">
                                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Published</span>
                                <button class="btn text-blue-600 hover:text-blue-800">
                                    Edit
                                </button>
                            </div>
                        </div>
                        <!-- More blog post cards would go here -->
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>
        // Player Modal Functions
        function showPlayerModal() {
            const modal = document.getElementById('playerModal');
            modal.classList.remove('hidden');
            showNotification('Opening add player form...', 'info');
        }

        function hidePlayerModal() {
            const modal = document.getElementById('playerModal');
            modal.classList.add('hidden');
            // Reset form
            document.getElementById('addPlayerForm').reset();
        }

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Add Player Form Submission
            document.getElementById('addPlayerForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Get form values
                const name = document.getElementById('playerName').value;
                const position = document.getElementById('playerPosition').value;
                const number = document.getElementById('jerseyNumber').value;
                const status = document.getElementById('playerStatus').value;

                if (!name || !position || !number) {
                    showNotification('Please fill in all required fields', 'error');
                    return;
                }

                // Show processing notification
                showNotification('Adding new player...', 'info');

                // Simulate API call delay
                setTimeout(() => {
                    // Here you would typically make an API call to save the player
                    
                    // Show success message
                    showNotification('Player added successfully!', 'success');
                    
                    // Close modal
                    hidePlayerModal();
                }, 1000);
            });

            // Close modal when clicking outside
            document.getElementById('playerModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    hidePlayerModal();
                }
            });

            // Get all navigation buttons and content sections
            const navButtons = document.querySelectorAll('.nav-btn');
            const contentSections = document.querySelectorAll('.content-section');
            
            // Add click event listeners to navigation buttons
            navButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const sectionId = this.getAttribute('data-section');
                    
                    // Update active button
                    navButtons.forEach(btn => {
                        btn.classList.remove('active', 'text-white', 'bg-blue-600');
                        btn.classList.add('text-gray-700', 'bg-gray-50');
                    });
                    
                    this.classList.add('active', 'text-white', 'bg-blue-600');
                    this.classList.remove('text-gray-700', 'bg-gray-50');
                    
                    // Show corresponding content section
                    contentSections.forEach(section => {
                        section.classList.remove('active');
                    });
                    
                    document.getElementById(`${sectionId}-content`).classList.add('active');
                    
                    // Update body background based on section
                    document.body.className = 'antialiased ' + sectionId + '-bg';
                });
            });
            
            // Notification function
            function showNotification(message, type = 'success') {
                const notification = document.createElement('div');
                notification.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg text-white text-sm font-medium z-50 transition-all duration-300 transform translate-y-full opacity-0 ${
                    type === 'success' ? 'bg-green-600' : 
                    type === 'error' ? 'bg-red-600' : 
                    'bg-blue-600'
                }`;
                notification.textContent = message;
                document.body.appendChild(notification);
                
                requestAnimationFrame(() => {
                    notification.classList.remove('translate-y-full', 'opacity-0');
                });
                
                setTimeout(() => {
                    notification.classList.add('translate-y-full', 'opacity-0');
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }

            // Button click handlers
            const buttons = [
                'view-players-btn', 'view-analytics-btn'
            ];
            
            buttons.forEach(btnId => {
                const btn = document.getElementById(btnId);
                if (btn) {
                    btn.addEventListener('click', function(e) {
                        // Ripple effect
                        const ripple = document.createElement('span');
                        ripple.classList.add('ripple');
                        this.appendChild(ripple);
                        
                        // Get click position
                        const rect = this.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;
                        
                        // Position ripple
                        ripple.style.left = `${x}px`;
                        ripple.style.top = `${y}px`;
                        
                        // Remove ripple after animation
                        setTimeout(() => {
                            ripple.remove();
                        }, 600);
                        
                        // Button specific actions
                        if (btnId === 'view-players-btn') {
                            // Navigate to players section
                            showNotification('Loading player management...', 'info');
                            navButtons.forEach(btn => {
                                btn.classList.remove('active', 'text-white', 'bg-blue-600');
                                btn.classList.add('text-gray-700', 'bg-gray-50');
                            });
                            
                            document.querySelector('[data-section="players"]').classList.add('active', 'text-white', 'bg-blue-600');
                            document.querySelector('[data-section="players"]').classList.remove('text-gray-700', 'bg-gray-50');
                            
                            contentSections.forEach(section => {
                                section.classList.remove('active');
                            });
                            
                            document.getElementById('players-content').classList.add('active');
                            document.body.className = 'antialiased players-bg';
                            
                        } else if (btnId === 'view-analytics-btn') {
                            showNotification('Opening fan analytics dashboard...', 'info');
                            setTimeout(() => {
                                showNotification('Fan analytics dashboard loaded successfully!', 'success');
                            }, 1000);
                        }
                    });
                }
            });

            // Add handlers for all action buttons
            const actionButtons = {
                'add-fixture': 'Adding new fixture...',
                'export-data': 'Exporting team performance data...',
                'generate-report': 'Generating financial report...',
                'new-post': 'Creating new blog post...'
            };

            Object.entries(actionButtons).forEach(([action, message]) => {
                document.querySelectorAll(`[data-action="${action}"]`).forEach(btn => {
                    btn.addEventListener('click', function() {
                        showNotification(message, 'info');
                        setTimeout(() => {
                            showNotification('Action completed successfully!', 'success');
                        }, 1500);
                    });
                });
            });
            
            // Add click handlers to all buttons with btn class
            document.querySelectorAll('.btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!this.id) { // Only add ripple to buttons without specific handlers
                        // Ripple effect
                        const ripple = document.createElement('span');
                        ripple.classList.add('ripple');
                        this.appendChild(ripple);
                        
                        // Get click position
                        const rect = this.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;
                        
                        // Position ripple
                        ripple.style.left = `${x}px`;
                        ripple.style.top = `${y}px`;
                        
                        // Remove ripple after animation
                        setTimeout(() => {
                            ripple.remove();
                        }, 600);
                        
                        // Show a notification for buttons without specific functionality
                        if (this.textContent.trim()) {
                            const buttonText = this.textContent.trim();
                            if (buttonText.toLowerCase().includes('delete') || buttonText.toLowerCase().includes('remove')) {
                                showNotification(`Confirm: ${buttonText}?`, 'error');
                            } else if (buttonText.toLowerCase().includes('edit') || buttonText.toLowerCase().includes('update')) {
                                showNotification(`Opening ${buttonText.toLowerCase()} form...`, 'info');
                            } else {
                                showNotification(`Processing: ${buttonText}`, 'info');
                                setTimeout(() => {
                                    showNotification('Action completed successfully!', 'success');
                                }, 1000);
                            }
                        }
                    }
                });
            });
            
            // Initialize tooltips for buttons with icons
            document.querySelectorAll('.btn-icon').forEach(btn => {
                btn.setAttribute('title', btn.getAttribute('aria-label') || 'Action');
            });
        });
    </script>
</body>
</html>