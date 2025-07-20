<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mwatate FC Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* A light gray background for the main area */
        }
    </style>
</head>
<body>
    <div class="flex min-h-screen">
        <!-- Reusable Sidebar Component -->
        <aside class="w-64 flex-shrink-0 bg-white shadow-md">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="h-16 flex items-center justify-center border-b">
                     <div class="flex items-center space-x-2">
                        <div class="inline-flex items-center justify-center w-10 h-10 bg-green-100 rounded-full">
                           <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-2.757 0-5-3.228-5-9S5.243 3 8 3s5 4.772 5 9"></path></svg>
                        </div>
                        <span class="text-xl font-bold text-gray-800">Mwatate FC</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="flex-1 px-4 py-4 space-y-2">
                    <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-blue-700 bg-blue-50 rounded-lg">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Uploads
                    </a>
                    <div>
                        <p class="px-4 pt-4 pb-2 text-xs font-semibold text-gray-400 uppercase">Manage</p>
                        <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m0 0A10.99 10.99 0 002.04 15m9.92-1.296A10.99 10.99 0 0021.96 15"></path></svg>
                            Players
                        </a>
                         <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100">
                           <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-7.5-2.952A3 3 0 006 13.5m-1.5-1.5a3 3 0 00-3-3m7.5 7.5a3 3 0 003 3h3a3 3 0 003-3v-3a3 3 0 00-3-3h-3a3 3 0 00-3 3v3zm-9.352-2.428A3 3 0 006.09 13.5m-4.242 2.122a3 3 0 00-.568 1.077 3 3 0 003.283 3.283c.351-.082.683-.223 1.077-.568m-4.242-2.122L4.5 15.5m5.648-5.648l.707-.707m-5.648 5.648l-.707.707m6.354-5.648l.707.707m-6.354-6.354l-.707-.707M15.5 4.5l.707.707m5.648 5.648l-.707.707m-5.648-5.648l.707-.707" /></svg>
                            Coaching Staff
                        </a>
                    </div>
                     <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01M12 6v-1m0-1H9.382a1 1 0 00-.924.632l-.546 1.275a1 1 0 01-1.848 0L5.43 5.632A1 1 0 004.508 5H4a1 1 0 00-1 1v11a1 1 0 001 1h16a1 1 0 001-1V6a1 1 0 00-1-1h-.508a1 1 0 00-.924-.632l-.546-1.275a1 1 0 01-1.848 0L14.618 5H12z"></path></svg>
                        Financials
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6M7 8h6"></path></svg>
                        Blog
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 lg:p-8">
            <!-- Header -->
            <header class="flex items-center justify-between mb-8">
                <div>
                    <p class="text-sm text-gray-500">Home / <span class="font-semibold text-gray-800">Dashboard</span></p>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="p-2 text-gray-500 bg-white rounded-full shadow-sm hover:text-gray-700 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </button>
                    <img class="w-10 h-10 rounded-full" src="https://i.pravatar.cc/150?u=a042581f4e29026704d" alt="Admin Avatar">
                </div>
            </header>

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                <div class="p-6 bg-white rounded-lg shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Total Players</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">32</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full">
                           <svg class="w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-7.5-2.952A3 3 0 006 13.5m-1.5-1.5a3 3 0 00-3-3m7.5 7.5a3 3 0 003 3h3a3 3 0 003-3v-3a3 3 0 00-3-3h-3a3 3 0 00-3 3v3zm-9.352-2.428A3 3 0 006.09 13.5m-4.242 2.122a3 3 0 00-.568 1.077 3 3 0 003.283 3.283c.351-.082.683-.223 1.077-.568m-4.242-2.122L4.5 15.5m5.648-5.648l.707-.707m-5.648 5.648l-.707.707m6.354-5.648l.707.707m-6.354-6.354l-.707-.707M15.5 4.5l.707.707m5.648 5.648l-.707.707m-5.648-5.648l.707-.707" /></svg>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Active Fans</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">12,480</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Coaching Staff</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">8</p>
                        </div>
                        <div class="p-3 bg-red-100 rounded-full">
                           <svg class="w-6 h-6 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Chart / Content -->
            <div class="mt-8 bg-white rounded-lg shadow-sm">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Team Performance Overview</h3>
                    <p class="text-sm text-gray-500">January - June 2023</p>
                </div>
                <div class="p-6">
                    <!-- Chart Placeholder -->
                    <div class="flex items-center justify-center w-full h-80 bg-gray-50 rounded-lg">
                        <p class="text-gray-400">Chart will be rendered here (e.g., using Chart.js)</p>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Table -->
            <div class="mt-8 bg-white rounded-lg shadow-sm">
                <div class="p-6 border-b">
                     <h3 class="text-lg font-semibold text-gray-800">Upcoming Fixtures</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Opponent</th>
                                <th scope="col" class="px-6 py-3">Competition</th>
                                <th scope="col" class="px-6 py-3">Date</th>
                                <th scope="col" class="px-6 py-3">Venue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">Vihiga United</th>
                                <td class="px-6 py-4">National Super League</td>
                                <td class="px-6 py-4">28 Oct 2023</td>
                                <td class="px-6 py-4">Home</td>
                            </tr>
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">Shabana FC</th>
                                <td class="px-6 py-4">FKF Cup</td>
                                <td class="px-6 py-4">04 Nov 2023</td>
                                <td class="px-6 py-4">Away</td>
                            </tr>
                             <tr class="bg-white">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">Bandari FC</th>
                                <td class="px-6 py-4">Friendly</td>
                                <td class="px-6 py-4">11 Nov 2023</td>
                                <td class="px-6 py-4">Home</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</body>
</html>