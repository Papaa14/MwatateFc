<!DOCTYPE html>
<html lang="en" class="antialiased">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fan Dashboard - Mwatate FC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #94c5e3;
        }

        .diagonal-bg-container {
            position: relative;
            z-index: 1;
        }

        .diagonal-bg-container::before,
        .diagonal-bg-container::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            z-index: -1;
        }

        .diagonal-bg-container::before {
            right: 0;
            width: 60%;
            background-color: #4c5267;
            transform: skewX(-15deg);
            transform-origin: top right;
        }

        .diagonal-bg-container::after {
            right: 0;
            width: 25%;
            background-color: #c1121f;
            transform: skewX(-15deg);
            transform-origin: top right;
        }

        /* Button animations */
        .btn {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn:active {
            transform: translateY(1px);
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background-color: white;
            border-radius: 0.5rem;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Navbar active link styles */
        .nav-link.active {
            color: #ffffff;
            position: relative;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #ffffff;
            animation: underline 0.3s ease-out;
        }

        @keyframes underline {
            from {
                transform: scaleX(0);
            }

            to {
                transform: scaleX(1);
            }
        }

        /* Centered Toast */
        #toast-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2000;
            transition: all 0.3s ease;
            opacity: 0;
            pointer-events: none;
        }

        #toast-container.show {
            opacity: 1;
            top: 50%;
        }
    </style>
</head>

<body class="min-h-screen">

    <!-- Pass Laravel Auth Data to JS -->
    <script>
        const CURRENT_USER_ID = "{{ Auth::id() }}";
        const CURRENT_USER_NAME = "{{ Auth::user()->name ?? 'Guest' }}";
    </script>

    <!-- Toast Notification -->
    <div id="toast-container"
        class="bg-gray-800 text-white px-8 py-4 rounded-xl shadow-2xl flex items-center space-x-3">
        <i id="toast-icon" class="fas fa-check-circle text-green-400 text-xl"></i>
        <span id="toast-message" class="font-medium text-lg">Action Successful</span>
    </div>

    <div class="diagonal-bg-container">
        <!-- Header -->
        <header class="relative z-10">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div
                        class="inline-flex items-center justify-center w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-2.757 0-5-3.228-5-9S5.243 3 8 3s5 4.772 5 9">
                            </path>
                        </svg>
                    </div>
                    <span class="text-white font-bold text-lg tracking-wide">MWATATE FC</span>
                </div>
                <!-- Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="#home"
                        class="nav-link text-sm font-semibold text-white tracking-wider uppercase hover:text-opacity-80 transition">Home</a>
                    <a href="#fixtures"
                        class="nav-link text-sm font-semibold text-white tracking-wider uppercase hover:text-opacity-80 transition">Fixtures</a>
                    <a href="#shop"
                        class="nav-link text-sm font-semibold text-white tracking-wider uppercase hover:text-opacity-80 transition">Shop</a>
                    <a href="#news"
                        class="nav-link text-sm font-semibold text-white tracking-wider uppercase hover:text-opacity-80 transition">News</a>
                    <a href="#forum"
                        class="nav-link text-sm font-semibold text-white tracking-wider uppercase hover:text-opacity-80 transition">Forum</a>
                </nav>
                <!-- Profile Dropdown -->
                <div class="relative">
                    <button id="profileButton" class="flex items-center space-x-2 focus:outline-none">
                        <span
                            class="text-white font-medium hidden sm:block">{{ Auth::user()->name ?? 'Guest User' }}</span>
                        <img class="w-10 h-10 rounded-full ring-2 ring-white/50"
                            src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Guest') }}&background=random"
                            alt="Fan Avatar">
                        <i class="fas fa-chevron-down text-white text-xs"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="profileDropdown"
                        class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                        <div class="p-3 border-b border-gray-100">
                            <p class="font-medium text-gray-800">{{ Auth::user()->name ?? 'Guest User' }}</p>
                            <p class="text-sm text-gray-500">{{ Auth::user()->email ?? 'guest@example.com' }}</p>
                        </div>
                        <div class="py-1">
                            <button onclick="logout()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition text-left">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Logout
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-6 py-8">
            <!-- Welcome Banner -->
            <div id="home"
                class="lg:col-span-3 p-6 bg-white/20 backdrop-blur-sm rounded-xl border border-white/30 mb-8">
                <h1 class="text-3xl font-bold text-white">Welcome back,
                    {{ explode(' ', Auth::user()->name ?? 'Fan')[0] }}!
                </h1>
                <p class="text-white/80 mt-1">Everything you need to support Mwatate FC, all in one place.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column (Fixtures, Shop, News) -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Fixtures Card -->
                    <div id="fixtures" class="bg-white/90 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden">
                        <div class="p-6 border-b border-gray-100">
                            <h2 class="text-xl font-bold text-gray-800">Upcoming Fixtures</h2>
                            <p class="text-sm text-gray-500">Secure your spot for the next big game.</p>
                        </div>
                        <div id="fixtures-list" class="space-y-2 px-6 pb-6 pt-4">
                            <!-- Dynamic Fixtures Loading Here -->
                            <p class="text-center text-gray-500 py-4">Loading fixtures...</p>
                        </div>
                    </div>

                    <!-- SHOP SECTION (New) -->
                    <div id="shop" class="bg-white/90 backdrop-blur-sm rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-2">Official Store</h2>
                        <p class="text-sm text-gray-500 mb-6">Get your official jerseys and merchandise.</p>

                        <div id="shop-grid" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Dynamic Jerseys Loading Here -->
                            <div class="col-span-full text-center py-4 text-gray-500">Loading shop items...</div>
                        </div>
                    </div>

                    <!-- News Card -->
                    <div id="news" class="bg-white/90 backdrop-blur-sm rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Latest Club News</h2>
                        <div id="news-grid" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Dynamic News Loading Here -->
                            <p class="col-span-full text-center text-gray-500">Loading latest news...</p>
                        </div>
                    </div>
                </div>

                <!-- Right Column (Profile, Form, Forum) -->
                <div class="space-y-8">
                    <!-- Profile Card -->
                    <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-lg p-6 text-center">
                        <img class="w-24 h-24 rounded-full mx-auto ring-4 ring-blue-500/50"
                            src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Guest') }}&background=0D8ABC&color=fff"
                            alt="Fan Avatar">
                        <h3 class="mt-4 text-xl font-bold text-gray-800">{{ Auth::user()->name ?? 'Guest User' }}</h3>
                        <p class="text-sm text-gray-500">{{ Auth::user()->email ?? 'Join us today!' }}</p>
                        <button onclick="showProfileModal()"
                            class="btn mt-4 w-full px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-full hover:bg-gray-300">Edit
                            Profile</button>
                    </div>

                    <!-- Team Form Card (Static for visual, can be dynamic if needed) -->
                    <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Form</h3>
                        <div class="flex items-center justify-around">
                            <div
                                class="flex items-center justify-center w-12 h-12 font-bold text-lg text-white bg-green-500 rounded-full border-2 border-white">
                                W</div>
                            <div
                                class="flex items-center justify-center w-12 h-12 font-bold text-lg text-white bg-green-500 rounded-full border-2 border-white">
                                W</div>
                            <div
                                class="flex items-center justify-center w-12 h-12 font-bold text-lg text-white bg-red-500 rounded-full border-2 border-white">
                                L</div>
                            <div
                                class="flex items-center justify-center w-12 h-12 font-bold text-lg text-white bg-gray-400 rounded-full border-2 border-white">
                                D</div>
                            <div
                                class="flex items-center justify-center w-12 h-12 font-bold text-lg text-white bg-green-500 rounded-full border-2 border-white">
                                W</div>
                        </div>
                    </div>

                    <!-- Fan Forum Card -->
                    <div id="forum" class="bg-white/90 backdrop-blur-sm rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Fan Forum</h3>
                        <p class="text-sm text-gray-500 mb-4">Share your thoughts on the last match!</p>
                        <form id="forumForm">
                            <textarea
                                class="w-full h-24 p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                placeholder="We need to be more clinical in front of goal..."></textarea>
                            <button type="submit"
                                class="btn mt-3 w-full px-4 py-2 text-sm font-semibold text-white bg-slate-800 rounded-full hover:bg-slate-900">Post
                                View</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Purchase/Order Modal (Used for both Tickets and Jerseys) -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 id="orderModalTitle" class="text-xl font-bold text-gray-800">Complete Purchase</h3>
                    <button onclick="hideModal('orderModal')" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="bg-blue-50 p-4 rounded-lg mb-4">
                    <h4 class="font-bold text-gray-800" id="orderProductName">Product Name</h4>
                    <p class="text-blue-600 font-bold mt-1">KES <span id="orderUnitPrice">0.00</span> <span
                            class="text-xs font-normal text-gray-500">per unit</span></p>
                </div>

                <form id="orderForm" onsubmit="handleOrderSubmit(event)" class="space-y-4">
                    <!-- Hidden inputs for logic -->
                    <input type="hidden" name="product" id="inputProductName">
                    <input type="hidden" name="price" id="inputProductPrice">
                    <!-- Send unit price, backend/frontend calc total -->

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Quantity</label>
                        <select name="quantity" id="inputQuantity" onchange="updateTotal()"
                            class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>

                    <div class="border-t pt-4 flex justify-between items-center">
                        <span class="text-gray-600 font-medium">Total Amount:</span>
                        <span class="text-2xl font-bold text-gray-900">KES <span id="orderTotal">0.00</span></span>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" onclick="hideModal('orderModal')"
                            class="btn px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-full hover:bg-gray-300">
                            Cancel
                        </button>
                        <button type="submit"
                            class="btn px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700">
                            Confirm Purchase
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- News Detail Modal -->
    <div id="newsModal" class="modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800" id="newsDetailTitle">News Title</h3>
                    <button onclick="hideModal('newsModal')" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div id="newsDetailImageContainer" class="hidden mb-4">
                    <img id="newsDetailImage" src="" class="rounded-lg w-full h-56 object-cover">
                </div>
                <div class="prose max-w-none">
                    <p class="text-gray-700 leading-relaxed" id="newsDetailContent">Content...</p>
                </div>
                <div class="mt-6">
                    <button onclick="hideModal('newsModal')"
                        class="btn w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Modal (Static for now) -->
    <div id="profileModal" class="modal">
        <div class="modal-content">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Edit Profile</h3>
                <p class="text-gray-500 text-sm mb-4">Profile editing is disabled in this demo.</p>
                <button onclick="hideModal('profileModal')"
                    class="btn w-full px-4 py-2 bg-gray-200 rounded-full">Close</button>
            </div>
        </div>
    </div>

    <script>
        const API_URL = '/api';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // --- UTILITIES ---
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast-container');
            const icon = document.getElementById('toast-icon');
            const msg = document.getElementById('toast-message');

            msg.innerText = message;
            if (type === 'success') {
                icon.className = 'fas fa-check-circle text-green-400 text-xl';
            } else {
                icon.className = 'fas fa-exclamation-circle text-red-400 text-xl';
            }

            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        function formatCurrency(amount) {
            return parseFloat(amount).toLocaleString(undefined, { minimumFractionDigits: 2 });
        }

        // --- MODAL LOGIC ---
        function showModal(id) { document.getElementById(id).classList.add('active'); }
        function hideModal(id) { document.getElementById(id).classList.remove('active'); }

        // Close on click outside
        document.querySelectorAll('.modal').forEach(m => {
            m.addEventListener('click', e => { if (e.target === m) hideModal(m.id); });
        });

        // --- FETCHING DATA ---

        async function logout() {
            try {
                await fetch(`${API_URL}/logout`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                window.location.href = '/';
            } catch (e) {
                window.location.href = '/';
            }
        }


        // 1. Fetch Fixtures with Tickets
        async function loadFixtures() {
            try {
                const res = await fetch(`${API_URL}/fixtures`);
                const json = await res.json();
                const container = document.getElementById('fixtures-list');

                if (!json.data || json.data.length === 0) {
                    container.innerHTML = '<div class="col-span-full text-center text-gray-500 p-4 border rounded-lg border-dashed">No upcoming matches.</div>';
                    return;
                }

                container.innerHTML = '';
                for (const fixture of json.data) {
                    // Fetch tickets for this fixture
                    const ticketsRes = await fetch(`${API_URL}/tickets?fixture_id=${fixture.id}`);
                    const ticketsJson = await ticketsRes.json();
                    const tickets = ticketsJson.data || [];

                    container.innerHTML += `
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">vs ${fixture.opponent}</h3>
                            <p class="text-sm text-gray-500">${new Date(fixture.match_date).toLocaleDateString()}</p>
                            <p class="text-xs text-gray-400">${fixture.competition}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-bold rounded ${fixture.venue === 'Home' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800'}">${fixture.venue}</span>
                    </div>
                    ${tickets.length > 0 ? `
                        <div class="space-y-2">
                            ${tickets.map(ticket => `
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded border">
                                    <div>
                                        <span class="font-medium text-gray-800">${ticket.type} Ticket</span>
                                        <p class="text-xs text-gray-500">${ticket.quantity_available} available</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="font-bold text-blue-600">KES ${formatCurrency(ticket.price)}</span>
                                        <button onclick="prepareTicketOrder('${fixture.opponent}', '${fixture.match_date}', ${ticket.id}, ${ticket.price})" 
                                            class="ml-2 btn bg-blue-600 text-white text-xs px-3 py-1 rounded hover:bg-blue-700">
                                            Book Now
                                        </button>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    ` : `
                        <p class="text-gray-400 text-sm">No tickets available yet</p>
                    `}
                </div>
            `;
                }
            } catch (e) { console.error(e); }
        }



        // 2. Fetch News
        async function loadNews() {
            try {
                const res = await fetch(`${API_URL}/news`);
                const json = await res.json();
                const container = document.getElementById('news-grid');
                const data = json.data || json;

                container.innerHTML = '';

                if (data.length === 0) {
                    container.innerHTML = '<p class="text-gray-500">No news available.</p>';
                    return;
                }

                data.forEach(item => {
                    if (item.image_path) {
                        // Image Card
                        container.innerHTML += `
                            <div class="group cursor-pointer bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition" onclick='openNewsModal(${JSON.stringify(item)})'>
                                <img src="/storage/${item.image_path}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="p-4">
                                    <h3 class="font-bold text-gray-800 group-hover:text-blue-600 transition mb-2">${item.title}</h3>
                                    <p class="text-sm text-gray-600 line-clamp-2">${item.content}</p>
                                </div>
                            </div>
                        `;
                    } else {
                        // Text Only Card
                        container.innerHTML += `
                            <div class="group cursor-pointer bg-blue-50 rounded-lg p-6 shadow-sm hover:shadow-md transition border border-blue-100 flex flex-col justify-center" onclick='openNewsModal(${JSON.stringify(item)})'>
                                <h3 class="font-bold text-gray-800 group-hover:text-blue-600 transition mb-2 text-lg">${item.title}</h3>
                                <p class="text-sm text-gray-600 line-clamp-3">${item.content}</p>
                                <div class="mt-4 text-xs text-blue-500 font-bold uppercase tracking-wide">Read More &rarr;</div>
                            </div>
                        `;
                    }
                });
            } catch (e) { console.error(e); }
        }

        // 3. Fetch Shop (Jerseys)
        async function loadShop() {
            try {
                const res = await fetch(`${API_URL}/jerseys`);
                const json = await res.json();
                console.log('Shop API Response:', json); // Debug log
                const container = document.getElementById('shop-grid');

                // Check different possible response structures
                const data = json.data || json || [];

                if (!data || data.length === 0) {
                    container.innerHTML = '<div class="col-span-full text-center text-gray-500 p-4 border rounded-lg border-dashed">No items in the shop currently.</div>';
                    return;
                }

                container.innerHTML = '';
                data.forEach(item => {
                    container.innerHTML += `
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden group hover:shadow-lg transition flex flex-col">
                    <div class="h-48 bg-gray-100 relative overflow-hidden">
                        <img src="/storage/${item.image_path}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute top-2 right-2 bg-white/90 px-2 py-1 rounded text-xs font-bold text-gray-800 shadow-sm">
                            Official Kit
                        </div>
                    </div>
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-gray-800">Team Jersey 2023/24</h3>
                            <p class="text-gray-500 text-xs mb-3">Authentic Home/Away Kit</p>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-lg font-bold text-blue-600">KES ${formatCurrency(item.price)}</span>
                            <button onclick="prepareJerseyOrder(${item.id}, ${item.price})" 
                                class="btn bg-gray-900 text-white text-xs px-4 py-2 rounded-full hover:bg-gray-800">
                                Buy Now
                            </button>
                        </div>
                    </div>
                </div>
            `;
                });
            } catch (e) {
                console.error('Shop loading error:', e);
                document.getElementById('shop-grid').innerHTML = '<div class="col-span-full text-center text-red-500 p-4">Error loading shop items</div>';
            }
        }
        // --- ACTION HANDLERS ---

        function openNewsModal(item) {
            document.getElementById('newsDetailTitle').innerText = item.title;
            document.getElementById('newsDetailContent').innerText = item.content;

            const imgContainer = document.getElementById('newsDetailImageContainer');
            if (item.image_path) {
                document.getElementById('newsDetailImage').src = '/storage/' + item.image_path;
                imgContainer.classList.remove('hidden');
            } else {
                imgContainer.classList.add('hidden');
            }
            showModal('newsModal');
        }

        // Update the prepareTicketOrder function
        function prepareTicketOrder(opponent, date, ticketId, price) {
            const displayDate = new Date(date).toLocaleDateString();
            const productName = `Ticket: vs ${opponent} (${displayDate})`;

            document.getElementById('orderModalTitle').innerText = 'Book Match Ticket';
            document.getElementById('orderProductName').innerText = productName;
            document.getElementById('orderUnitPrice').innerText = formatCurrency(price);

            // Set Form Values
            document.getElementById('inputProductName').value = productName;
            document.getElementById('inputProductPrice').value = price;
            document.getElementById('inputQuantity').value = 1;

            updateTotal();
            showModal('orderModal');
        }



        // Setup Order Modal for Jersey
        function prepareJerseyOrder(id, price) {
            const productName = "Official Team Jersey";

            document.getElementById('orderModalTitle').innerText = 'Buy Jersey';
            document.getElementById('orderProductName').innerText = productName;
            document.getElementById('orderUnitPrice').innerText = formatCurrency(price);

            // Set Form Values
            document.getElementById('inputProductName').value = productName; // Or send ID if backend logic differs
            document.getElementById('inputProductPrice').value = price;
            document.getElementById('inputQuantity').value = 1;

            updateTotal();
            showModal('orderModal');
        }

        function updateTotal() {
            const price = parseFloat(document.getElementById('inputProductPrice').value);
            const qty = parseInt(document.getElementById('inputQuantity').value);
            document.getElementById('orderTotal').innerText = formatCurrency(price * qty);
        }

        // Submit Order to API
        async function handleOrderSubmit(e) {
            e.preventDefault();

            const form = new FormData(e.target);
            // Add customer_id manually
            const payload = {
                customer_id: CURRENT_USER_ID,
                product: form.get('product'),
                price: form.get('price'),
                quantity: form.get('quantity')
            };

            // Basic validation
            if (!payload.customer_id) {
                showToast('Please login to purchase', 'error');
                return;
            }

            try {
                const res = await fetch(`${API_URL}/orders`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(payload)
                });

                if (res.ok) {
                    showToast('Order placed successfully!');
                    hideModal('orderModal');
                } else {
                    const err = await res.json();
                    showToast(err.message || 'Failed to place order', 'error');
                }
            } catch (error) {
                console.error(error);
                showToast('Network error occurred', 'error');
            }
        }

        async function loadCurrentUser() {
            try {
                const res = await fetch(`${API_URL}/user`, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')}`,
                        'Accept': 'application/json'
                    }
                });
                if (res.ok) {
                    const user = await res.json();
                    // Update UI with user info
                    document.querySelectorAll('.user-name').forEach(el => el.textContent = user.name);
                    document.querySelectorAll('.user-email').forEach(el => el.textContent = user.email);
                }
            } catch (e) {
                console.log('User info not available');
            }
        }

        function showProfileModal() { showModal('profileModal'); }

        // --- INIT ---
        document.addEventListener('DOMContentLoaded', () => {
            loadCurrentUser()
            loadFixtures();
            loadNews();
            loadShop();

            // Nav Highlighting Logic (Preserved from original)
            const navLinks = document.querySelectorAll('.nav-link');
            const sections = document.querySelectorAll('main > div[id]');

            window.addEventListener('scroll', () => {
                let current = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;
                    if (pageYOffset >= (sectionTop - 200)) {
                        current = '#' + section.getAttribute('id');
                    }
                });
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === current) link.classList.add('active');
                });
            });
            // Profile dropdown toggle
            document.getElementById('profileButton').addEventListener('click', function (e) {
                e.stopPropagation();
                const dropdown = document.getElementById('profileDropdown');
                dropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function () {
                document.getElementById('profileDropdown').classList.add('hidden');
            });

        });
    </script>
</body>

</html>