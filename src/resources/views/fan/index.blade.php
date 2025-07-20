<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fan Dashboard - Mwatate FC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #94c5e3; /* Base light blue */
        }

        /* This creates the diagonal background effect */
        .diagonal-bg-container {
            position: relative;
            z-index: 1;
        }

        .diagonal-bg-container::before, .diagonal-bg-container::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            z-index: -1;
        }

        /* Dark slate diagonal */
        .diagonal-bg-container::before {
            right: 0;
            width: 60%;
            background-color: #4c5267;
            transform: skewX(-15deg);
            transform-origin: top right;
        }

        /* Red accent diagonal */
        .diagonal-bg-container::after {
            right: 0;
            width: 25%;
            background-color: #c1121f;
            transform: skewX(-15deg);
            transform-origin: top right;
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="diagonal-bg-container">
        <!-- Header -->
        <header class="relative z-10">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div class="inline-flex items-center justify-center w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full">
                       <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-2.757 0-5-3.228-5-9S5.243 3 8 3s5 4.772 5 9"></path></svg>
                    </div>
                </div>
                <!-- Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="#" class="text-sm font-semibold text-white tracking-wider uppercase hover:text-opacity-80 transition">Home</a>
                    <a href="#" class="text-sm font-semibold text-white tracking-wider uppercase hover:text-opacity-80 transition">Fixtures</a>
                    <a href="#" class="text-sm font-semibold text-white tracking-wider uppercase hover:text-opacity-80 transition">News</a>
                    <a href="#" class="text-sm font-semibold text-white tracking-wider uppercase hover:text-opacity-80 transition">Forum</a>
                </nav>
                <!-- Profile Dropdown -->
                <div class="flex items-center space-x-4">
                    <span class="text-white font-medium hidden sm:block">Jane Doe</span>
                    <button class="flex items-center space-x-2">
                        <img class="w-10 h-10 rounded-full ring-2 ring-white/50" src="https://i.pravatar.cc/150?u=jane.doe" alt="Fan Avatar">
                    </button>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-6 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Welcome Banner (Full Width) -->
                <div class="lg:col-span-3 p-6 bg-white/20 backdrop-blur-sm rounded-xl border border-white/30">
                    <h1 class="text-3xl font-bold text-white">Welcome to the Fan Hub!</h1>
                    <p class="text-white/80 mt-1">Everything you need to support Mwatate FC, all in one place.</p>
                </div>

                <!-- Left Column (Fixtures & News) -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Fixtures & Tickets Card -->
                    <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-800">Upcoming Fixtures</h2>
                            <p class="text-sm text-gray-500">Don't miss a moment. Book your tickets now!</p>
                        </div>
                        <div class="space-y-2 px-6 pb-6">
                            <!-- Fixture Item -->
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="text-center w-16">
                                    <p class="font-bold text-lg text-gray-800">28</p>
                                    <p class="text-xs font-semibold text-gray-500 uppercase">Oct</p>
                                </div>
                                <div class="h-10 w-px bg-gray-200 mx-4"></div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">Mwatate FC vs Vihiga United</p>
                                    <p class="text-sm text-gray-500">Home Stadium - 3:00 PM</p>
                                </div>
                                <button class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-full shadow-sm hover:bg-blue-700">Book Tickets</button>
                            </div>
                            <!-- Fixture Item -->
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="text-center w-16">
                                    <p class="font-bold text-lg text-gray-800">04</p>
                                    <p class="text-xs font-semibold text-gray-500 uppercase">Nov</p>
                                </div>
                                <div class="h-10 w-px bg-gray-200 mx-4"></div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">Shabana FC vs Mwatate FC</p>
                                    <p class="text-sm text-gray-500">Away - 4:00 PM</p>
                                </div>
                                <button class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-full shadow-sm hover:bg-blue-700">Get Info</button>
                            </div>
                        </div>
                    </div>

                    <!-- News & Blog Card -->
                    <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Latest News</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- News Item -->
                            <div class="group">
                                <img src="https://images.unsplash.com/photo-1579952363873-27f3bade9f55?q=80&w=2970&auto=format&fit=crop" class="rounded-lg mb-2 h-40 w-full object-cover">
                                <h3 class="font-bold text-gray-800 group-hover:text-blue-600 transition">Manager's Pre-Match Press Conference</h3>
                                <p class="text-sm text-gray-600">The gaffer shares his thoughts ahead of the big clash this weekend...</p>
                            </div>
                            <!-- News Item -->
                            <div class="group">
                                <img src="https://images.unsplash.com/photo-1551958219-acbc608c6377?q=80&w=2970&auto=format&fit=crop" class="rounded-lg mb-2 h-40 w-full object-cover">
                                <h3 class="font-bold text-gray-800 group-hover:text-blue-600 transition">John Okoro Voted Player of the Month</h3>
                                <p class="text-sm text-gray-600">Our star striker wins the fan-voted award after a stellar October...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column (Profile, Form, Forum) -->
                <div class="space-y-8">
                    <!-- Profile Card -->
                    <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-lg p-6 text-center">
                        <img class="w-24 h-24 rounded-full mx-auto ring-4 ring-blue-500/50" src="https://i.pravatar.cc/150?u=jane.doe" alt="Fan Avatar">
                        <h3 class="mt-4 text-xl font-bold text-gray-800">Jane Doe</h3>
                        <p class="text-sm text-gray-500">Member Since 2021</p>
                        <button class="mt-4 w-full px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-full hover:bg-gray-300">Edit Profile</button>
                    </div>

                    <!-- Team Form Card -->
                    <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Form</h3>
                        <div class="flex items-center justify-around">
                             <div class="flex items-center justify-center w-12 h-12 font-bold text-lg text-white bg-green-500 rounded-full border-2 border-white">W</div>
                             <div class="flex items-center justify-center w-12 h-12 font-bold text-lg text-white bg-green-500 rounded-full border-2 border-white">W</div>
                             <div class="flex items-center justify-center w-12 h-12 font-bold text-lg text-white bg-red-500 rounded-full border-2 border-white">L</div>
                             <div class="flex items-center justify-center w-12 h-12 font-bold text-lg text-white bg-gray-400 rounded-full border-2 border-white">D</div>
                             <div class="flex items-center justify-center w-12 h-12 font-bold text-lg text-white bg-green-500 rounded-full border-2 border-white">W</div>
                        </div>
                    </div>

                    <!-- Fan Forum Card -->
                    <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Fan Forum</h3>
                        <p class="text-sm text-gray-500 mb-4">Share your thoughts on the last match!</p>
                        <form>
                            <textarea class="w-full h-24 p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="We need to be more clinical in front of goal..."></textarea>
                            <button type="submit" class="mt-3 w-full px-4 py-2 text-sm font-semibold text-white bg-slate-800 rounded-full hover:bg-slate-900">Post View</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>