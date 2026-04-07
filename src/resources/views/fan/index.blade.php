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

        /* Enhanced Stadium Styles */
        #stadiumVisualizationContainer {
            background: #1a1a2e; /* Darker professional background */
            border-radius: 1rem;
            position: relative;
        }

        .sector {
            transition: all 0.2s ease;
            cursor: pointer;
            stroke: #1a1a2e;
            stroke-width: 2;
            opacity: 0.8;
        }

        .sector:hover {
            opacity: 1;
            filter: brightness(1.2);
            transform: scale(1.02);
            transform-origin: center;
        }

        .sector.selected {
            stroke: #ffffff;
            stroke-width: 3;
            opacity: 1;
            filter: drop-shadow(0 0 8px rgba(255,255,255,0.5));
        }

        .field-grass {
            fill: #2d5a27;
            stroke: #ffffff33;
            stroke-width: 2;
        }

        /* Sidebar Legend styling */
        .legend-scroll {
            max-height: 400px;
            overflow-y: auto;
            scrollbar-width: thin;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.8;
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>

<body class="min-h-screen">

    <!-- Pass Laravel Auth Data to JS -->
    <script>
        const CURRENT_USER_ID = "{{ Auth::check() ? Auth::id() : '' }}";
        const CURRENT_USER_NAME = "{{ Auth::check() ? Auth::user()->name : 'Guest' }}";
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
                <!-- Profile -->
                <div class="relative">
                    <button id="profileButton" class="flex items-center space-x-2 focus:outline-none">
                        <span
                            class="user-name text-white font-medium hidden sm:block">{{ Auth::user()->name ?? 'Guest User' }}</span>
                        <img class="w-10 h-10 rounded-full ring-2 ring-white/50"
                            src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Guest') }}&background=random"
                            alt="Fan Avatar">
                        <i class="fas fa-chevron-down text-white text-xs"></i>
                    </button>
                    <!-- Dropdown Menu -->
                    <div id="profileDropdown"
                        class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                        <div class="p-3 border-b border-gray-100">
                            <p class="user-name font-medium text-gray-800">{{ Auth::user()->name ?? 'Guest User' }}</p>
                            <p class="user-email text-sm text-gray-500">{{ Auth::user()->email ?? 'guest@example.com' }}
                            </p>
                        </div>
                        <div class="py-1">
                            <button onclick="logout()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition text-left">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-6 py-8">
            <div id="home"
                class="lg:col-span-3 p-6 bg-white/20 backdrop-blur-sm rounded-xl border border-white/30 mb-8">
                <h1 class="text-3xl font-bold text-white">Welcome back,
                    {{ explode(' ', Auth::user()->name ?? 'Fan')[0] }}!
                </h1>
                <p class="text-white/80 mt-1">Everything you need to support Mwatate FC, all in one place.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Fixtures -->
                    <div id="fixtures" class="bg-white/90 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden">
                        <div class="p-6 border-b border-gray-100">
                            <h2 class="text-xl font-bold text-gray-800">Upcoming Fixtures</h2>
                            <p class="text-sm text-gray-500">Secure your spot for the next big game.</p>
                        </div>
                        <div id="fixtures-list" class="space-y-2 px-6 pb-6 pt-4">
                            <p class="text-center text-gray-500 py-4">Loading fixtures...</p>
                        </div>
                    </div>

                    <!-- Shop -->
                    <div id="shop" class="bg-white/90 backdrop-blur-sm rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-2">Official Store</h2>
                        <p class="text-sm text-gray-500 mb-6">Get your official jerseys and merchandise.</p>
                        <div id="shop-grid" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="col-span-full text-center py-4 text-gray-500">Loading shop items...</div>
                        </div>
                    </div>

                    <!-- News -->
                    <div id="news" class="bg-white/90 backdrop-blur-sm rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Latest Club News</h2>
                        <div id="news-grid" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <p class="col-span-full text-center text-gray-500">Loading latest news...</p>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-8">
                    <!-- Profile -->
                    <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-lg p-6 text-center">
                        <img class="w-24 h-24 rounded-full mx-auto ring-4 ring-blue-500/50"
                            src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Guest') }}&background=0D8ABC&color=fff"
                            alt="Fan Avatar">
                        <h3 class="user-name mt-4 text-xl font-bold text-gray-800">
                            {{ Auth::user()->name ?? 'Guest User' }}
                        </h3>
                        <p class="user-email text-sm text-gray-500">{{ Auth::user()->email ?? 'Join us today!' }}</p>
                        <button onclick="showProfileModal()"
                            class="btn mt-4 w-full px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-full hover:bg-gray-300">Edit
                            Profile</button>
                    </div>

                    <!-- Order History (Moved/Added here for visibility) -->
                    <div id="orders" class="bg-white/90 backdrop-blur-sm rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">My Purchases</h3>
                        <div id="orders-list" class="space-y-3 max-h-64 overflow-y-auto">
                            <p class="text-sm text-gray-500">Loading history...</p>
                        </div>
                    </div>

                    <!-- Form -->
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

                    <!-- Forum -->
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

    <!-- PURCHASE MODAL WITH STK PUSH -->
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

                <form id="orderForm" onsubmit="handlePaymentSubmit(event)" class="space-y-4">
                    <!-- Updated hidden fields for item identification -->
                    <input type="hidden" id="itemType">
                    <input type="hidden" id="itemId">
                    <input type="hidden" id="itemPrice">

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Quantity</label>
                        <select id="inputQuantity" onchange="updateTotal()"
                            class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>

                    <!-- Added Phone Number for M-Pesa -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">M-Pesa Phone Number</label>
                        <input type="text" id="inputPhone" placeholder="07XXXXXXXX or 254XXXXXXXXX" required
                            class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">

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
                        <button type="submit" id="payButton"
                            class="btn px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-full hover:bg-green-700 shadow-md">
                            Pay with M-Pesa
                        </button>
                    </div>
                </form>

                <!-- Payment Status Indicator -->
                <div id="paymentStatus"
                    class="hidden mt-4 text-center p-3 bg-yellow-50 text-yellow-800 rounded text-sm animate-pulse border border-yellow-200">
                    <i class="fas fa-circle-notch fa-spin mr-2"></i> Request sent to phone. Enter PIN...
                </div>
            </div>
        </div>
    </div>

    <!-- STADIUM VISUALIZATION MODAL FOR TICKET BOOKING -->
    <div id="stadiumModal" class="modal">
        <div class="modal-content" style="max-width: 900px; max-height: 95vh; overflow-y: auto;">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-2xl font-bold text-gray-800" id="stadiumModalTitle">Select Your Seats</h3>
                    <button onclick="hideModal('stadiumModal')" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>

                <!-- Match Info -->
                <div class="bg-blue-50 p-4 rounded-lg mb-6 border border-blue-200">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-xs text-gray-600 font-semibold">OPPONENT</p>
                            <p class="text-lg font-bold text-gray-800" id="stadiumOpponent">-</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-semibold">MATCH DATE</p>
                            <p class="text-lg font-bold text-gray-800" id="stadiumDate">-</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-semibold">STADIUM</p>
                            <p class="text-lg font-bold text-gray-800" id="stadiumName">-</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-semibold">SECTION</p>
                            <p class="text-lg font-bold text-blue-600" id="selectedSection">Select</p>
                        </div>
                    </div>
                </div>

                <!-- Stadium Grid Visualization -->
                <div id="stadiumVisualizationContainer" class="mb-6 bg-gray-900 rounded-lg p-6 overflow-x-auto shadow-lg">
                    <!-- Grid blocks will be injected here -->
                </div>

                <!-- Legend Below Stadium -->
                <div id="sectionLegend" class="mb-6 bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <!-- Legend items will be injected here -->
                </div>

                <!-- Booking Summary Below -->
                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Selected Section -->
                        <div class="bg-white rounded p-4 border border-gray-200">
                            <p class="text-xs text-gray-600 font-semibold mb-2">SELECTED SECTION</p>
                            <p class="text-lg font-bold text-gray-800" id="sectionCardName">No Section</p>
                            <p class="text-sm text-blue-600 font-bold mt-2">KES <span id="sectionCardPrice">0.00</span></p>
                        </div>

                        <!-- Quantity Selector -->
                        <div class="bg-white rounded p-4 border border-gray-200">
                            <p class="text-xs text-gray-600 font-semibold mb-2">NUMBER OF TICKETS</p>
                            <input type="number" id="seatQuantity" value="1" min="1" onchange="calculateTotalSeats()"
                                   class="w-full text-center border border-gray-300 rounded-lg py-2 font-bold focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Total Price -->
                        <div class="bg-blue-600 text-white rounded-lg p-4">
                            <p class="text-xs opacity-80 mb-1">TOTAL TO PAY</p>
                            <p class="text-2xl font-bold">KES <span id="totalSeatPrice">0.00</span></p>
                            <button type="button" onclick="proceedToPayment()"
                                    class="w-full mt-3 py-2 bg-blue-700 text-white rounded font-bold hover:bg-blue-800 transition text-sm">
                                Proceed to Payment
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- News Modal -->
    <div id="newsModal" class="modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800" id="newsDetailTitle"></h3>
                    <button onclick="hideModal('newsModal')" class="text-gray-400 hover:text-gray-500"><i
                            class="fas fa-times"></i></button>
                </div>
                <div id="newsDetailImageContainer" class="hidden mb-4"><img id="newsDetailImage" src=""
                        class="rounded-lg w-full h-56 object-cover"></div>
                <div class="prose max-w-none">
                    <p class="text-gray-700 leading-relaxed" id="newsDetailContent"></p>
                </div>
                <div class="mt-6"><button onclick="hideModal('newsModal')"
                        class="btn w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Modal -->
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
        const token = localStorage.getItem('api_token');

        // --- UTILITIES ---
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast-container');
            const icon = document.getElementById('toast-icon');
            const msg = document.getElementById('toast-message');
            msg.innerText = message;
            icon.className = type === 'success' ? 'fas fa-check-circle text-green-400 text-xl' : 'fas fa-exclamation-circle text-red-400 text-xl';
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        function formatCurrency(amount) {
            return parseFloat(amount).toLocaleString(undefined, { minimumFractionDigits: 2 });
        }

        // --- MODAL LOGIC ---
        function showModal(id) { document.getElementById(id).classList.add('active'); }
        function hideModal(id) { document.getElementById(id).classList.remove('active'); }
        document.querySelectorAll('.modal').forEach(m => {
            m.addEventListener('click', e => { if (e.target === m) hideModal(m.id); });
        });

        // --- FETCHING DATA ---
        async function logout() {
            try { await fetch(`${API_URL}/logout`, { method: 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken } }); } catch (e) { }
            window.location.href = '/';
        }

        async function loadFixtures() {
            try {
                const res = await fetch(`${API_URL}/fixtures`);
                const json = await res.json();
                const container = document.getElementById('fixtures-list');
                if (!json.data || json.data.length === 0) { container.innerHTML = '<div class="col-span-full text-center text-gray-500 p-4 border rounded-lg border-dashed">No upcoming matches.</div>'; return; }
                container.innerHTML = '';
                for (const fixture of json.data) {
                    const ticketsRes = await fetch(`${API_URL}/tickets?fixture_id=${fixture.id}`);
                    const ticketsJson = await ticketsRes.json();
                    const tickets = ticketsJson.data || [];
                    container.innerHTML += `
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                            <div class="flex justify-between items-start mb-4">
                                <div><h3 class="font-bold text-gray-800 text-lg">vs ${fixture.opponent}</h3><p class="text-sm text-gray-500">${new Date(fixture.match_date).toLocaleDateString()}</p><p class="text-xs text-gray-400">${fixture.competition}</p></div>
                                <span class="px-2 py-1 text-xs font-bold rounded ${fixture.venue === 'Home' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800'}">${fixture.venue}</span>
                            </div>
                            ${tickets.length > 0 ? `<div class="space-y-2">${tickets.map(ticket => `
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded border">
                                    <div><span class="font-medium text-gray-800">${ticket.type} Ticket</span><p class="text-xs text-gray-500">${ticket.quantity_available} available</p></div>
                                    <div class="text-right"><span class="font-bold text-blue-600">KES ${formatCurrency(ticket.price)}</span>
                                        <button onclick="prepareTicketWithStadium('${fixture.opponent}', ${ticket.id}, ${ticket.price}, ${JSON.stringify(fixture).replace(/"/g, '&quot;')})" class="ml-2 btn bg-blue-600 text-white text-xs px-3 py-1 rounded hover:bg-blue-700">Book Now</button>
                                    </div>
                                </div>`).join('')}</div>` : `<p class="text-gray-400 text-sm">No tickets available yet</p>`}
                        </div>`;
                }
            } catch (e) { console.error(e); }
        }

        function prepareTicketWithStadium(opponent, ticketId, price, fixture) {
            // Setup initial modal data
            document.getElementById('itemType').value = 'ticket';
            document.getElementById('itemId').value = ticketId;
            document.getElementById('itemPrice').value = price;

            // Always open stadium visualization modal
            openStadiumVisualization(opponent, ticketId, fixture);
        }

        async function loadNews() {
            try {
                const res = await fetch(`${API_URL}/news`);
                const json = await res.json();
                const container = document.getElementById('news-grid');
                const data = json.data || json || [];
                container.innerHTML = '';
                if (data.length === 0) { container.innerHTML = '<p class="text-gray-500">No news available.</p>'; return; }
                data.forEach(item => {
                    container.innerHTML += `
                        <div class="group cursor-pointer bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition" onclick='openNewsModal(${JSON.stringify(item)})'>
                            ${item.image_path ? `<img src="/storage/${item.image_path}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">` : ''}
                            <div class="p-4"><h3 class="font-bold text-gray-800 group-hover:text-blue-600 transition mb-2">${item.title}</h3><p class="text-sm text-gray-600 line-clamp-2">${item.content}</p></div>
                        </div>`;
                });
            } catch (e) { console.error(e); }
        }

        async function loadShop() {
            try {
                const res = await fetch(`${API_URL}/jerseys`);
                const json = await res.json();
                const container = document.getElementById('shop-grid');
                const data = json.data || json || [];
                container.innerHTML = '';
                if (data.length === 0) { container.innerHTML = '<div class="col-span-full text-center text-gray-500 p-4">No items.</div>'; return; }
                data.forEach(item => {
                    container.innerHTML += `
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden group hover:shadow-lg transition flex flex-col">
                            <div class="h-48 bg-gray-100 relative overflow-hidden"><img src="/storage/${item.image_path}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"></div>
                            <div class="p-4 flex-1 flex flex-col justify-between">
                                <div><h3 class="font-bold text-gray-800">Team Jersey</h3><p class="text-gray-500 text-xs mb-3">Authentic Kit</p></div>
                                <div class="flex items-center justify-between mt-2"><span class="text-lg font-bold text-blue-600">KES ${formatCurrency(item.price)}</span><button onclick="prepareJerseyOrder(${item.id}, ${item.price})" class="btn bg-gray-900 text-white text-xs px-4 py-2 rounded-full hover:bg-gray-800">Buy Now</button></div>
                            </div>
                        </div>`;
                });
            } catch (e) { console.error(e); }
        }

        async function loadMyOrders() {
            try {
                const res = await fetch(`${API_URL}/my-orders`, { headers: { 'Authorization': `Bearer ${token}` } });
                const json = await res.json();
                const container = document.getElementById('orders-list');
                container.innerHTML = '';
                if (!json.data || json.data.length === 0) { container.innerHTML = '<p class="text-sm text-gray-400">No purchases yet.</p>'; return; }
                json.data.forEach(order => {
                    container.innerHTML += `
        <div class="flex justify-between items-center p-3 bg-gray-50 rounded border border-gray-100">
            <div><p class="font-bold text-gray-800 text-sm">${order.product}</p><p class="text-xs text-gray-500">${new Date(order.created_at).toLocaleDateString()} • Qty: ${order.quantity}</p></div>
            <div class="text-right">
                <p class="font-bold text-green-600 text-sm">KES ${formatCurrency(order.price)}</p>
                <span class="text-[10px] bg-green-100 text-green-800 px-2 py-0.5 rounded-full font-bold">PAID</span>
            </div>
        </div>`;
                });
            } catch (e) { console.error(e); }
        }

        async function loadCurrentUser() {
            try {
                const res = await fetch(`${API_URL}/user`, { headers: { 'Authorization': `Bearer ${token}` } });
                if (res.ok) {
                    const user = await res.json();
                    document.querySelectorAll('.user-name').forEach(el => el.textContent = user.user?.name || user.name);
                    document.querySelectorAll('.user-email').forEach(el => el.textContent = user.user?.email || user.email);
                }
            } catch (e) { }
        }

        // --- PAYMENT & ORDER LOGIC ---

        function prepareTicketOrder(opponent, id, price) {
            setupModal(`Ticket vs ${opponent}`, price, 'ticket', id);
        }

        function prepareJerseyOrder(id, price) {
            setupModal("Official Jersey", price, 'jersey', id);
        }

        function setupModal(name, price, type, id) {
            document.getElementById('orderProductName').innerText = name;
            document.getElementById('orderUnitPrice').innerText = formatCurrency(price);
            document.getElementById('itemType').value = type;
            document.getElementById('itemId').value = id;
            document.getElementById('itemPrice').value = price;
            document.getElementById('inputQuantity').value = 1;
            updateTotal();
            showModal('orderModal');
            resetPaymentUI();
        }

        function updateTotal() {
            const price = parseFloat(document.getElementById('itemPrice').value);
            const qty = document.getElementById('inputQuantity').value;
            document.getElementById('orderTotal').innerText = formatCurrency(price * qty);
        }

        async function handlePaymentSubmit(e) {
            e.preventDefault();
            const btn = document.getElementById('payButton');
            const statusDiv = document.getElementById('paymentStatus');
            const phone = document.getElementById('inputPhone').value;

            // Simple validation
            if (phone.length < 10) {
                showToast('Please enter a valid phone number', 'error');
                return;
            }

            const payload = {
                phone_number: phone,
                item_type: document.getElementById('itemType').value,
                item_id: document.getElementById('itemId').value,
                quantity: document.getElementById('inputQuantity').value
            };

            // Add seat data if it exists
            const seatData = sessionStorage.getItem('seatData');
            if (seatData) {
                const seats = JSON.parse(seatData);
                payload.section_name = seats.section_name;
                payload.seat_numbers = seats.seat_numbers;
                payload.fixture_id = seats.fixture_id;
                payload.ticket_type = seats.ticket_type;
            }

            // Loading state
            btn.disabled = true;
            btn.classList.add('opacity-50');
            btn.innerText = 'Processing...';

            try {
                // 1. Initiate STK Push
                const res = await fetch(`${API_URL}/orders/pay`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'Authorization': `Bearer ${token}` },
                    body: JSON.stringify(payload)
                });

                const data = await res.json();

                if (res.ok) {
                    // 2. Show polling status
                    statusDiv.classList.remove('hidden');
                    // 3. Poll for status
                    pollPaymentStatus(data.lipia_reference);
                } else {
                    throw new Error(data.message || 'Payment initiation failed');
                }
            } catch (e) {
                console.error(e);
                showToast(e.message, 'error');
                resetPaymentUI();
            }
        }

        async function pollPaymentStatus(reference) {
            const statusDiv = document.getElementById('paymentStatus');
            let attempts = 0;
            const maxAttempts = 20; // 60 seconds

            const interval = setInterval(async () => {
                attempts++;
                try {
                    const res = await fetch(`${API_URL}/orders/status/${reference}`, {
                        headers: { 'Authorization': `Bearer ${token}` }
                    });
                    const data = await res.json();

                    if (data.status === 'SUCCESS') {
                        clearInterval(interval);
                        sessionStorage.removeItem('seatData'); // Clear seat data after successful payment
                        showToast('Payment Successful! Order Confirmed and Receipt sent to your email.', 'success');
                        hideModal('orderModal');
                        loadMyOrders(); // Refresh history
                        loadFixtures(); // Update ticket count
                    } else if (data.status === 'FAILED' || attempts >= maxAttempts) {
                        clearInterval(interval);
                        statusDiv.innerHTML = '<i class="fas fa-times-circle mr-2"></i> Payment Failed or Timed Out.';
                        statusDiv.classList.replace('bg-yellow-50', 'bg-red-50');
                        statusDiv.classList.replace('text-yellow-800', 'text-red-800');
                        document.getElementById('payButton').disabled = false;
                        document.getElementById('payButton').classList.remove('opacity-50');
                        document.getElementById('payButton').innerText = 'Retry Payment';
                    }
                } catch (e) { console.error(e); }
            }, 3000);
        }


        function resetPaymentUI() {
            const btn = document.getElementById('payButton');
            const statusDiv = document.getElementById('paymentStatus');
            btn.disabled = false;
            btn.classList.remove('opacity-50');
            btn.innerText = 'Pay with M-Pesa';
            statusDiv.classList.add('hidden');
            statusDiv.classList.remove('bg-red-50', 'text-red-800');
            statusDiv.classList.add('bg-yellow-50', 'text-yellow-800');
            statusDiv.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> Request sent to phone. Enter PIN...';
        }

        // --- STADIUM VISUALIZATION & SEAT SELECTION ---
        let currentFixture = null;
        let currentTicket = null;
        let currentSection = null;
        let allocatedSeats = [];
        const sectionColors = {
            'VVIP': '#6d28d9',
            'VIP': '#2563eb',
            'Regular': '#10b981',
            'Premium': '#f59e0b',
            'Standard': '#6366f1',
            'East': '#8b5cf6',
            'West': '#ec4899',
            'North': '#f97316',
            'South': '#14b8a6'
        };

        async function openStadiumVisualization(opponent, ticketId, fixture) {
            currentFixture = fixture;
            currentTicket = {
                id: ticketId,
                price: document.getElementById('itemPrice').value,
                type: document.getElementById('itemType').value
            };

            // Hide the order modal and show stadium modal instead
            hideModal('orderModal');

            // Populate match info
            document.getElementById('stadiumOpponent').innerText = opponent;
            document.getElementById('stadiumDate').innerText = new Date(fixture.match_date).toLocaleDateString('en-US', {
                weekday: 'short',
                month: 'short',
                day: 'numeric'
            });
            document.getElementById('stadiumName').innerText = fixture.stadium_name || 'TBA';

            // Default sections if not provided
            const sections = fixture.sections_config && Array.isArray(fixture.sections_config) ? fixture.sections_config : [
                { name: 'VVIP', seats: 500, price: 5000 },
                { name: 'VIP', seats: 800, price: 3000 },
                { name: 'Regular', seats: 2000, price: 1500 },
                { name: 'Premium', seats: 1000, price: 2500 }
            ];

            // Load stadium data and render visualization
            renderStadiumVisualization(sections);
            renderLegend(sections);

            // Reset state
            currentSection = null;
            allocatedSeats = [];
            document.getElementById('seatQuantity').value = 1;
            document.getElementById('selectedSection').innerText = 'Select';

            showModal('stadiumModal');
        }

        function renderStadiumVisualization(sections) {
            const container = document.getElementById('stadiumVisualizationContainer');

            const cx = 260, cy = 210, rx = 190, ry = 160, ix = 112, iy = 90;
            const sectionCount = 80;
            const gap = 1.2;

            function polar(a, b, deg) {
                const r = deg * Math.PI / 180;
                return [cx + a * Math.cos(r), cy + b * Math.sin(r)];
            }

            function makePath(a1, a2) {
                const [x1,y1] = polar(rx,ry,a1), [x2,y2] = polar(rx,ry,a2);
                const [x3,y3] = polar(ix,iy,a2), [x4,y4] = polar(ix,iy,a1);
                const laf = (a2-a1) > 180 ? 1 : 0;
                return `M${x1},${y1} A${rx},${ry} 0 ${laf},1 ${x2},${y2} L${x3},${y3} A${ix},${iy} 0 ${laf},0 ${x4},${y4} Z`;
            }

            function labelPos(a1, a2) {
                const mid = (a1+a2)/2 * Math.PI/180;
                return [cx + (rx+ix)/2 * Math.cos(mid), cy + (ry+iy)/2 * Math.sin(mid)];
            }

            const degPer = 360 / sectionCount;
            let sectorPaths = '';
            let labelPaths = '';

            for (let i = 0; i < sectionCount; i++) {
                const sIdx = Math.floor(i * sections.length / sectionCount);
                const sec = sections[sIdx];
                const color = sectionColors[sec.name] || '#666';
                const a1 = i * degPer - 90 + gap/2;
                const a2 = (i+1) * degPer - 90 - gap/2;
                sectorPaths += `<path d="${makePath(a1,a2)}" fill="${color}" opacity="0.85" class="sector"
                    onclick="selectSection('${sec.name}',${sec.seats},${sec.price})"
                    title="${sec.name}">
                    <title>${sec.name} — KES ${sec.price} — ${sec.seats} seats</title>
                </path>`;
                if (i % 2 === 0) {
                    const [lx,ly] = labelPos(a1, a2 + degPer);
                    labelPaths += `<text x="${lx}" y="${ly}" text-anchor="middle" dominant-baseline="central"
                        fill="rgba(255,255,255,0.65)" font-size="9" font-family="sans-serif"
                        pointer-events="none">${i+1}</text>`;
                }
            }

            container.innerHTML = `
            <svg viewBox="0 0 520 430" width="100%" xmlns="http://www.w3.org/2000/svg">
              <text x="260" y="20" text-anchor="middle" fill="#9ca3af" font-size="12" font-family="sans-serif">East tribune «C»</text>
              <text x="260" y="422" text-anchor="middle" fill="#9ca3af" font-size="12" font-family="sans-serif">West tribune «A»</text>
              <text x="16" y="215" text-anchor="middle" fill="#9ca3af" font-size="12" font-family="sans-serif" transform="rotate(-90,16,215)">North tribune «B»</text>
              <text x="508" y="215" text-anchor="middle" fill="#9ca3af" font-size="12" font-family="sans-serif" transform="rotate(90,508,215)">South tribune «D»</text>
              ${sectorPaths}
              ${labelPaths}
              <ellipse cx="${cx}" cy="${cy}" rx="108" ry="86" fill="#1a5c28"/>
              <ellipse cx="${cx}" cy="${cy}" rx="108" ry="86" fill="none" stroke="#2d8a3e" stroke-width="2"/>
              <ellipse cx="${cx}" cy="${cy}" rx="36" ry="28" fill="none" stroke="#2d8a3e" stroke-width="1.5"/>
              <line x1="${cx-105}" y1="${cy}" x2="${cx+105}" y2="${cy}" stroke="#2d8a3e" stroke-width="1.5"/>
              <rect x="${cx-45}" y="${cy-43}" width="90" height="42" rx="2" fill="none" stroke="#2d8a3e" stroke-width="1.2"/>
              <rect x="${cx-23}" y="${cy-29}" width="46" height="28" rx="2" fill="none" stroke="#2d8a3e" stroke-width="1"/>
              <rect x="${cx-45}" y="${cy+1}" width="90" height="42" rx="2" fill="none" stroke="#2d8a3e" stroke-width="1.2"/>
              <rect x="${cx-23}" y="${cy+1}" width="46" height="28" rx="2" fill="none" stroke="#2d8a3e" stroke-width="1"/>
              <circle cx="${cx}" cy="${cy}" r="3" fill="#2d8a3e"/>
            </svg>`;
        }



        function renderLegend(sections) {
            const container = document.getElementById('sectionLegend');
            container.innerHTML = `
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Select sector on the scheme</p>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                    ${sections.map(sec => {
                        const color = sectionColors[sec.name] || '#666';
                        return `<div class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 p-2 rounded-lg transition"
                             onclick="selectSection('${sec.name}', ${sec.seats}, ${sec.price})">
                            <div class="w-3 h-3 rounded-full flex-shrink-0" style="background:${color}"></div>
                            <div>
                                <p class="text-xs font-bold text-gray-800">${sec.name}</p>
                                <p class="text-xs text-gray-500">${sec.seats.toLocaleString()} seats</p>
                            </div>
                        </div>`;
                    }).join('')}
                </div>`;
        }

        function selectSection(sectionName, availableSeats, price) {
            currentSection = { name: sectionName, availableSeats: availableSeats, price: price };

            // Update UI Labels
            document.getElementById('selectedSection').innerText = sectionName;
            document.getElementById('sectionCardName').innerText = sectionName;
            document.getElementById('sectionCardPrice').innerText = formatCurrency(price);

            // Reset quantity logic
            document.getElementById('seatQuantity').value = 1;
            calculateTotalSeats();
        }

        function increaseQuantity() {
            const qty = parseInt(document.getElementById('seatQuantity').value);
            if (currentSection && qty < currentSection.availableSeats) {
                document.getElementById('seatQuantity').value = qty + 1;
                calculateTotalSeats();
            } else {
                showToast('Not enough seats available in this section', 'error');
            }
        }

        function decreaseQuantity() {
            const qty = parseInt(document.getElementById('seatQuantity').value);
            if (qty > 1) {
                document.getElementById('seatQuantity').value = qty - 1;
                calculateTotalSeats();
            }
        }

        function calculateTotalSeats() {
            if (!currentSection) {
                document.getElementById('seatQuantity').value = 1;
                return;
            }

            const qty = parseInt(document.getElementById('seatQuantity').value);

            // Generate seat numbers
            allocatedSeats = [];
            for (let i = 1; i <= qty; i++) {
                allocatedSeats.push(`${currentSection.name.charAt(0)}${i}`);
            }

            // Update display
            document.getElementById('totalSeatPrice').innerText = formatCurrency(currentSection.price * qty);
        }

        async function proceedToPayment() {
            if (!currentSection || allocatedSeats.length === 0) {
                showToast('Please select a section and number of seats', 'error');
                return;
            }

            // Store seat data
            document.getElementById('itemType').value = 'ticket';
            document.getElementById('itemId').value = currentTicket.id;
            document.getElementById('itemPrice').value = currentSection.price;
            document.getElementById('inputQuantity').value = allocatedSeats.length;

            // Store seat and section info in hidden fields
            const seatData = {
                section_name: currentSection.name,
                seat_numbers: allocatedSeats,
                fixture_id: currentFixture.id,
                ticket_type: currentFixture.opponent
            };

            // Store in session storage to pass to payment handler
            sessionStorage.setItem('seatData', JSON.stringify(seatData));

            // Hide stadium modal and show payment modal
            hideModal('stadiumModal');

            // Setup and show order modal
            document.getElementById('orderProductName').innerText = `${currentFixture.opponent} - ${currentSection.name} Tickets`;
            document.getElementById('orderUnitPrice').innerText = formatCurrency(currentSection.price);
            document.getElementById('orderTotal').innerText = formatCurrency(currentSection.price * allocatedSeats.length);

            showModal('orderModal');
            resetPaymentUI();
        }

        function openNewsModal(item) {
            document.getElementById('newsDetailTitle').innerText = item.title;
            document.getElementById('newsDetailContent').innerText = item.content;
            const imgContainer = document.getElementById('newsDetailImageContainer');
            if (item.image_path) { document.getElementById('newsDetailImage').src = '/storage/' + item.image_path; imgContainer.classList.remove('hidden'); } else { imgContainer.classList.add('hidden'); }
            showModal('newsModal');
        }

        function showProfileModal() { showModal('profileModal'); }

        document.addEventListener('DOMContentLoaded', () => {
            loadCurrentUser();
            loadFixtures();
            loadNews();
            loadShop();
            loadMyOrders();

            // Nav Highlighting
            const navLinks = document.querySelectorAll('.nav-link');
            const sections = document.querySelectorAll('main > div[id]');
            window.addEventListener('scroll', () => {
                let current = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    if (pageYOffset >= (sectionTop - 200)) current = '#' + section.getAttribute('id');
                });
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === current) link.classList.add('active');
                });
            });

            document.getElementById('profileButton').addEventListener('click', e => { e.stopPropagation(); document.getElementById('profileDropdown').classList.toggle('hidden'); });
            document.addEventListener('click', () => document.getElementById('profileDropdown').classList.add('hidden'));
        });
    </script>
</body>

</html>
