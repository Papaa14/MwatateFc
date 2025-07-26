<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Dashboard - Mwatate FC Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
        <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Tailwind CSS -->
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        .modal-enter {
            opacity: 0;
            transform: scale(0.95);
        }
        .modal-enter-active {
            opacity: 1;
            transform: scale(1);
            transition: opacity 300ms ease-out, transform 300ms ease-out;
        }
        .modal-leave {
            opacity: 1;
            transform: scale(1);
        }
        .modal-leave-active {
            opacity: 0;
            transform: scale(0.95);
            transition: opacity 200ms ease-in, transform 200ms ease-in;
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        
        /* Background images */
        .dashboard-bg {
            background-image: linear-gradient(rgba(255,255,255,0.95), rgba(255,255,255,0.95)), 
                            url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .performance-bg {
            background-image: linear-gradient(rgba(255,255,255,0.95), rgba(255,255,255,0.95)), 
                            url('https://images.unsplash.com/photo-1543357486-c2505d3d0385?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
        }
        
        .training-bg {
            background-image: linear-gradient(rgba(255,255,255,0.95), rgba(255,255,255,0.95)), 
                            url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
        }
        
        /* Button animations */
        .btn {
            transition: all 0.2s ease-in-out;
            transform: translateY(0);
            position: relative;
            overflow: hidden;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }
        .btn:focus:not(:active)::after {
            animation: ripple 0.6s ease-out;
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
    </style>
</head>
<body class="dashboard-bg">
    <div class="flex min-h-screen">
        <!-- Sidebar Navigation -->
        <aside class="w-64 flex-shrink-0 bg-white shadow-md border-r border-gray-200">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="h-20 flex items-center justify-center border-b border-gray-200 px-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-lg">
                            <i class="fas fa-futbol text-blue-600 text-xl"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-800">Mwatate FC</span>
                    </div>
                </div>

                <!-- Player Navigation Links -->
                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                    <button data-section="dashboard" class="nav-btn active btn w-full flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                        <i class="fas fa-chart-bar mr-3 w-5 text-center"></i>
                        Dashboard
                    </button>
                    <button data-section="performance" class="nav-btn btn w-full flex items-center px-4 py-3 text-sm font-medium text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-chart-line mr-3 w-5 text-center"></i>
                        My Performance
                    </button>
                    <button data-section="training" class="nav-btn btn w-full flex items-center px-4 py-3 text-sm font-medium text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-dumbbell mr-3 w-5 text-center"></i>
                        Training Plan
                    </button>
                    <button data-section="messages" class="nav-btn btn w-full flex items-center px-4 py-3 text-sm font-medium text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-comments mr-3 w-5 text-center"></i>
                        Messages
                        <span class="ml-auto bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-0.5 rounded-full">3</span>
                    </button>
                    <button data-section="videos" class="nav-btn btn w-full flex items-center px-4 py-3 text-sm font-medium text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-video mr-3 w-5 text-center"></i>
                        Video Library
                    </button>
                    <button data-section="calendar" class="nav-btn btn w-full flex items-center px-4 py-3 text-sm font-medium text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-calendar-alt mr-3 w-5 text-center"></i>
                        My Calendar
                    </button>
                </nav>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-auto">
            <!-- Dashboard Header -->
            <header class="sticky top-0 z-10 bg-white/80 backdrop-blur-sm border-b border-gray-200 px-6 py-4 shadow-sm">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800" id="page-title">Dashboard</h2>
                        <p class="text-sm text-gray-500" id="page-subtitle">Welcome back, John! Here's your overview.</p>
                    </div>
                    <div class="flex items-center space-x-4 mt-4 md:mt-0">
                        <button class="p-2 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-100">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center transform translate-x-1 -translate-y-1">3</span>
                        </button>
                        <div class="flex items-center space-x-3">
                            <img class="w-10 h-10 rounded-full ring-2 ring-blue-500 ring-offset-2" src="https://i.pravatar.cc/150?u=player1" alt="Player Avatar">
                            <div>
                                <p class="font-semibold text-gray-800">John Okoro</p>
                                <p class="text-xs text-gray-500">Striker / #9</p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Sections -->
            <div class="p-6 lg:p-8">
                <!-- Dashboard Content -->
                <section id="dashboard-content" class="content-section active">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Left Column -->
                        <div class="lg:col-span-2 space-y-8">
                            <!-- Next Up Card -->
                            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6">
                                <div class="flex justify-between items-center mb-6">
                                    <h3 class="text-xl font-semibold text-gray-800">What's Next?</h3>
                                    <button id="view-all-btn" class="nav-btn active btn px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        View All
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <button class="btn flex items-start p-4 bg-gray-50/80 backdrop-blur-sm rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                        <div class="p-3 bg-blue-100 rounded-full">
                                            <i class="fas fa-running text-blue-500"></i>
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <p class="text-xs text-blue-600 font-semibold uppercase">NEXT TRAINING</p>
                                            <p class="font-semibold text-gray-800">Finishing Drills</p>
                                            <p class="text-sm text-gray-500">Today at 10:00 AM</p>
                                        </div>
                                    </button>
                                    <button class="btn flex items-start p-4 bg-gray-50/80 backdrop-blur-sm rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                        <div class="p-3 bg-green-100 rounded-full">
                                            <i class="fas fa-calendar-check text-green-500"></i>
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <p class="text-xs text-green-600 font-semibold uppercase">NEXT MATCH</p>
                                            <p class="font-semibold text-gray-800">vs. Vihiga United</p>
                                            <p class="text-sm text-gray-500">Saturday, 28 Oct</p>
                                        </div>
                                    </button>
                                </div>
                            </div>

                            <!-- Performance Snapshot -->
                            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6">
                                <div class="flex justify-between items-center mb-6">
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-800">Performance Snapshot</h3>
                                        <p class="text-sm text-gray-500">Based on last 5 sessions & matches</p>
                                    </div>
                                    <button id="view-details-btn" class="nav-btn active btn px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        View Details
                                    </button>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-sm font-medium text-gray-700">Passing Accuracy</span>
                                            <span class="text-sm font-medium text-gray-700">88%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: 88%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-sm font-medium text-gray-700">Sprints / Match</span>
                                            <span class="text-sm font-medium text-gray-700">18/20 (Goal)</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-green-500 h-2.5 rounded-full" style="width: 90%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-sm font-medium text-gray-700">Last Match Rating</span>
                                            <span class="text-sm font-medium text-gray-700">8.2 / 10</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: 82%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-8">
                            <!-- Wellness Check-in -->
                            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6">
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Daily Wellness Check</h3>
                                <p class="text-sm text-gray-500 mb-4">How are you feeling today?</p>
                                <form class="space-y-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-700">Fatigue Level</label>
                                        <div class="flex justify-between mt-1 text-xs text-gray-500">
                                            <span>Low</span>
                                            <span>High</span>
                                        </div>
                                        <input type="range" min="1" max="5" value="3" class="w-full mt-2">
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-700">Soreness Level</label>
                                        <div class="flex justify-between mt-1 text-xs text-gray-500">
                                            <span>None</span>
                                            <span>High</span>
                                        </div>
                                        <input type="range" min="1" max="5" value="2" class="w-full mt-2">
                                    </div>
                                    <button id="submit-wellness-btn" type="button" class="nav-btn active btn w-full mt-4 px-4 py-3 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Submit Wellness Check
                                    </button>
                                </form>
                            </div>

                            <!-- Coach's Focus -->
                            <div class="bg-blue-50/80 backdrop-blur-sm border-l-4 border-blue-500 rounded-r-lg p-6">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-semibold text-gray-800">Coach's Focus</h3>
                                    <button class="p-1 text-blue-600 hover:text-blue-800 rounded-full hover:bg-blue-100">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                </div>
                                <p class="text-sm text-gray-700 mb-4">"John, let's work on your off-the-ball movement in the final third this week. Watch the clips I've sent you."</p>
                                <button class="btn inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    View Video Clips
                                    <i class="fas fa-chevron-right ml-1 text-sm"></i>
                                </button>
                            </div>
                            
                            <!-- Recent Messages -->
                            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800">Recent Messages</h3>
                                    <button class="btn px-3 py-1 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100">
                                        View All
                                    </button>
                                </div>
                                <ul class="space-y-4">
                                    <li class="flex items-start group">
                                        <img class="w-10 h-10 rounded-full group-hover:ring-2 group-hover:ring-blue-500 transition-all duration-200" src="https://i.pravatar.cc/150?u=coach" alt="Coach Avatar">
                                        <div class="ml-3 flex-1">
                                            <div class="flex justify-between">
                                                <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">Coach Miller</p>
                                                <span class="text-xs text-gray-500">2h ago</span>
                                            </div>
                                            <p class="text-sm text-gray-600 truncate">Video analysis for the last match is up. Take a look...</p>
                                            <button class="mt-1 btn inline-flex items-center text-xs text-blue-600 hover:text-blue-800">
                                                Reply
                                                <i class="fas fa-reply ml-1 text-xs"></i>
                                            </button>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Performance Content -->
                <section id="performance-content" class="content-section performance-bg">
                    <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">My Performance Metrics</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Performance Charts -->
                            <div class="bg-gray-50/80 backdrop-blur-sm p-6 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Last 5 Matches</h3>
                                <div class="h-64 bg-white border border-gray-200 rounded-lg p-4">
                                    <!-- Chart placeholder -->
                                    <div class="flex items-center justify-center h-full text-gray-400">
                                        <i class="fas fa-chart-line text-4xl mr-3"></i>
                                        <span>Performance Chart</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Stats Overview -->
                            <div class="bg-gray-50/80 backdrop-blur-sm p-6 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Season Statistics</h3>
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-gray-200">
                                        <div>
                                            <p class="text-sm font-medium text-gray-700">Goals Scored</p>
                                            <p class="text-xs text-gray-500">Current Season</p>
                                        </div>
                                        <span class="text-xl font-bold text-blue-600">12</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-gray-200">
                                        <div>
                                            <p class="text-sm font-medium text-gray-700">Assists</p>
                                            <p class="text-xs text-gray-500">Current Season</p>
                                        </div>
                                        <span class="text-xl font-bold text-blue-600">8</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-gray-200">
                                        <div>
                                            <p class="text-sm font-medium text-gray-700">Pass Accuracy</p>
                                            <p class="text-xs text-gray-500">Last Match</p>
                                        </div>
                                        <span class="text-xl font-bold text-blue-600">88%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Training Plan Content -->
                <section id="training-content" class="content-section training-bg">
                    <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">Training Plan</h2>
                            <button id="download-schedule-btn" class="nav-btn active btn px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Download Schedule
                            </button>
                        </div>
                        
                        <!-- Weekly Schedule -->
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">This Week's Schedule</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Day</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Session Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Focus Area</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coach</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Monday</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">09:00 - 11:00</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Technical</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Finishing</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Coach Miller</td>
                                    </tr>
                                    <!-- More rows would go here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- Messages Content -->
                <section id="messages-content" class="content-section">
                    <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">Messages</h2>
                            <button id="new-message-btn" class="nav-btn active btn px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                New Message
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Inbox List -->
                            <div class="lg:col-span-1 bg-gray-50/80 backdrop-blur-sm rounded-lg p-4">
                                <div class="relative mb-4">
                                    <input type="text" placeholder="Search messages..." class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                </div>
                                
                                <div class="space-y-2 overflow-y-auto max-h-96">
                                    <!-- Message Thread -->
                                    <div class="p-3 bg-white rounded-lg border border-gray-200 cursor-pointer hover:border-blue-300">
                                        <div class="flex items-center">
                                            <img class="w-10 h-10 rounded-full mr-3" src="https://i.pravatar.cc/150?u=coach" alt="Coach Avatar">
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">Coach Miller</p>
                                                <p class="text-xs text-gray-500">Video analysis for last match</p>
                                            </div>
                                            <span class="ml-auto text-xs text-gray-400">2h ago</span>
                                        </div>
                                    </div>
                                    <!-- More message threads would go here -->
                                </div>
                            </div>
                            
                            <!-- Message Content -->
                            <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 p-6">
                                <div class="border-b border-gray-200 pb-4 mb-4">
                                    <div class="flex items-center">
                                        <img class="w-12 h-12 rounded-full mr-4" src="https://i.pravatar.cc/150?u=coach" alt="Coach Avatar">
                                        <div>
                                            <p class="text-lg font-semibold text-gray-900">Coach Miller</p>
                                            <p class="text-sm text-gray-500">to me</p>
                                        </div>
                                        <div class="ml-auto flex space-x-2">
                                            <button class="p-2 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-100">
                                                <i class="fas fa-reply"></i>
                                            </button>
                                            <button class="p-2 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-100">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Video analysis for last match</h3>
                                    <p class="text-sm text-gray-700 mb-4">Hi John,</p>
                                    <p class="text-sm text-gray-700 mb-4">I've reviewed the footage from our last match against Vihiga United. You'll find the video analysis in your video library. Pay special attention to your positioning in the 32nd and 67th minutes - these are key moments we can improve on.</p>
                                    <p class="text-sm text-gray-700">Let me know if you have any questions.</p>
                                </div>
                                
                                <div class="border-t border-gray-200 pt-4">
                                    <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" rows="3" placeholder="Write your reply..."></textarea>
                                    <div class="flex justify-end mt-2 space-x-2">
                                        <button class="btn px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                            Cancel
                                        </button>
                                        <button id="send-message-btn" class="btn px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                            Send
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Video Library Content -->
                <section id="videos-content" class="content-section">
                    <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">Video Library</h2>
                            <button id="upload-video-btn" class="nav-btn active btn px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Upload Video
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Video Card -->
                            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
                                <div class="relative pt-[56.25%] bg-gray-200">
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <i class="fas fa-play text-4xl text-gray-400"></i>
                                    </div>
                                    <span class="absolute bottom-2 right-2 bg-black bg-opacity-70 text-white text-xs px-2 py-1 rounded">8:24</span>
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-1">Match Analysis vs Vihiga</h3>
                                    <p class="text-sm text-gray-500 mb-3">Uploaded: 16 Oct 2023</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded">Coach Review</span>
                                        <button id="watch-video-btn" class="btn text-blue-600 hover:text-blue-800 text-sm font-medium focus:outline-none">
                                            Watch
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- More video cards would go here -->
                        </div>
                    </div>
                </section>

                <!-- Calendar Content -->
                <section id="calendar-content" class="content-section" x-data="dashboard()">
                    <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">My Calendar</h2>
                            <div class="flex space-x-2">
                                <button class="btn px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                    Today
                                </button>
                                <button id="add-event-btn" @click="showEventModal = true" class="nav-btn active btn px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Add Event
                                </button>
                            </div>
                        </div>
                        
                    <!-- Add Event Modal -->
                    <div x-show="showEventModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" @click.away="showEventModal = false">
                        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-xl font-bold text-gray-800">Add New Event</h3>
                                    <button @click="showEventModal = false" class="text-gray-400 hover:text-gray-500">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Event Title</label>
                                        <input type="text" x-model="newEvent.title" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Event Type</label>
                                        <select x-model="newEvent.type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Select Type</option>
                                            <option value="training">Training</option>
                                            <option value="match">Match</option>
                                            <option value="team-meeting">Team Meeting</option>
                                            <option value="personal">Personal</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                                        <input type="date" x-model="newEvent.date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                                            <input type="time" x-model="newEvent.startTime" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                                            <input type="time" x-model="newEvent.endTime" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                        <input type="text" x-model="newEvent.location" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                        <textarea x-model="newEvent.description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Reminder</label>
                                        <select x-model="newEvent.reminder" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="none">No Reminder</option>
                                            <option value="15">15 minutes before</option>
                                            <option value="30">30 minutes before</option>
                                            <option value="60">1 hour before</option>
                                            <option value="1440">1 day before</option>
                                        </select>
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
                        
                        <!-- Upcoming Events -->
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Upcoming Events</h3>
                        <div class="space-y-3">
                            <div class="p-3 bg-gray-50/80 backdrop-blur-sm rounded-lg border border-gray-200">
                                <div class="flex items-center">
                                    <div class="p-2 bg-blue-100 rounded-full mr-3">
                                        <i class="fas fa-running text-blue-500"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Morning Training Session</p>
                                        <p class="text-xs text-gray-500">Today, 09:00 - 11:00</p>
                                    </div>
                                </div>
                            </div>
                            <!-- More events would go here -->
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Alpine.js data
            window.Alpine = window.Alpine || {};
            window.Alpine.data = window.Alpine.data || {};
            
            window.Alpine.data.dashboard = function() {
                return {
                    showEventModal: false,
                    newEvent: {
                        title: '',
                        type: '',
                        date: '',
                        startTime: '',
                        endTime: '',
                        location: '',
                        description: '',
                        reminder: 'none'
                    },
                    createEvent() {
                        // TODO: Add API call to save event
                        showNotification('Event created successfully!', 'success');
                        this.showEventModal = false;
                        this.resetEventForm();
                    },
                    resetEventForm() {
                        this.newEvent = {
                            title: '',
                            type: '',
                            date: '',
                            startTime: '',
                            endTime: '',
                            location: '',
                            description: '',
                            reminder: 'none'
                        };
                    }
                };
            };

            // Get all navigation buttons and content sections
            const navButtons = document.querySelectorAll('.nav-btn');
            const contentSections = document.querySelectorAll('.content-section');
            const pageTitle = document.getElementById('page-title');
            const pageSubtitle = document.getElementById('page-subtitle');
            
            // Page titles and subtitles for each section
            const pageTitles = {
                'dashboard': 'Dashboard',
                'performance': 'My Performance',
                'training': 'Training Plan',
                'messages': 'Messages',
                'videos': 'Video Library',
                'calendar': 'My Calendar'
            };
            
            const pageSubtitles = {
                'dashboard': 'Welcome back, John! Here\'s your overview.',
                'performance': 'Track your progress and statistics.',
                'training': 'View and manage your training schedule.',
                'messages': 'Communicate with coaches and staff.',
                'videos': 'Access training and match videos.',
                'calendar': 'Manage your schedule and events.'
            };
            
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
                    
                    // Update page title and subtitle
                    pageTitle.textContent = pageTitles[sectionId];
                    pageSubtitle.textContent = pageSubtitles[sectionId];
                    
                    // Update body background based on section
                    document.body.className = 'antialiased ' + sectionId + '-bg';
                });
            });
            
            // Button click handlers with active state and animations
            const buttons = [
                'view-all-btn', 'view-details-btn', 'submit-wellness-btn',
                'download-schedule-btn', 'new-message-btn', 'send-message-btn',
                'upload-video-btn', 'watch-video-btn', 'add-event-btn'
            ];
            
            const buttonToSection = {
                'view-all-btn': 'calendar',
                'view-details-btn': 'performance',
                'submit-wellness-btn': 'dashboard',
                'download-schedule-btn': 'training',
                'new-message-btn': 'messages',
                'send-message-btn': 'messages',
                'upload-video-btn': 'videos',
                'watch-video-btn': 'videos',
                'add-event-btn': 'calendar'
            };
            
            buttons.forEach(btnId => {
                const btn = document.getElementById(btnId);
                if (btn) {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        // Add active state feedback
                        this.classList.add('active');
                        
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
                        
                        // Remove ripple and active state after animation
                        setTimeout(() => {
                            ripple.remove();
                            this.classList.remove('active');
                        }, 600);

                        // Handle section navigation
                        const targetSection = buttonToSection[btnId];
                        if (targetSection) {
                            const sectionButton = document.querySelector(`[data-section="${targetSection}"]`);
                            if (sectionButton) {
                                sectionButton.click();
                            }
                        }

                        // Show notification feedback
                        switch(btnId) {
                            case 'view-all-btn':
                                showNotification('Loading upcoming events...', 'info');
                                break;
                            case 'view-details-btn':
                                showNotification('Loading performance details...', 'info');
                                break;
                            case 'submit-wellness-btn':
                                showNotification('Wellness check submitted!', 'success');
                                break;
                            case 'download-schedule-btn':
                                showNotification('Downloading training schedule...', 'info');
                                setTimeout(() => {
                                    showNotification('Schedule downloaded successfully!', 'success');
                                }, 1500);
                                break;
                            case 'new-message-btn':
                                showNotification('Opening message composer...', 'info');
                                break;
                            case 'send-message-btn':
                                showNotification('Message sent successfully!', 'success');
                                break;
                            case 'upload-video-btn':
                                showNotification('Opening video upload dialog...', 'info');
                                break;
                            case 'watch-video-btn':
                                showNotification('Loading video player...', 'info');
                                break;
                            case 'add-event-btn':
                                showNotification('Opening event creator...', 'info');
                                break;
                        }
                        
                        // Button specific actions with enhanced feedback
                        switch(btnId) {
                            case 'view-all-btn':
                                showNotification('Loading all upcoming events...', 'success');
                                break;
                            case 'view-details-btn':
                                showNotification('Loading performance details...', 'success');
                                break;
                            case 'submit-wellness-btn':
                                showNotification('Wellness check submitted successfully!', 'success');
                                break;
                            case 'download-schedule-btn':
                                showNotification('Downloading training schedule...', 'info');
                                setTimeout(() => {
                                    showNotification('Schedule downloaded successfully!', 'success');
                                }, 1500);
                                break;
                            case 'new-message-btn':
                                showNotification('Opening message composer...', 'info');
                                break;
                            case 'send-message-btn':
                                showNotification('Sending message...', 'info');
                                setTimeout(() => {
                                    showNotification('Message sent successfully!', 'success');
                                }, 1000);
                                break;
                            case 'upload-video-btn':
                                showNotification('Opening video upload dialog...', 'info');
                                break;
                            case 'watch-video-btn':
                                showNotification('Loading video player...', 'info');
                                break;
                            case 'add-event-btn':
                                showNotification('Opening event creator...', 'info');
                                break;
                        }
                    });
                }
            });
            
            // Notification function
            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg text-white text-sm font-medium z-50 transition-all duration-300 transform translate-y-full opacity-0 ${
                    type === 'success' ? 'bg-green-600' : 'bg-blue-600'
                }`;
                notification.textContent = message;
                document.body.appendChild(notification);
                
                // Animate in
                setTimeout(() => {
                    notification.classList.remove('translate-y-full', 'opacity-0');
                }, 100);
                
                // Remove after delay
                setTimeout(() => {
                    notification.classList.add('translate-y-full', 'opacity-0');
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                }, 3000);
            }
            
            // Initialize wellness check form
            const wellnessForm = document.querySelector('form');
            if (wellnessForm) {
                wellnessForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('Wellness check submitted successfully!');
                });
            }
        });
    </script>
</body>
</html>