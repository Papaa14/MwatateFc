<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fan Dashboard - Mwatate FC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
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
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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
            from { transform: scaleX(0); }
            to { transform: scaleX(1); }
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
                    <a href="#home" class="nav-link text-sm font-semibold text-white tracking-wider uppercase hover:text-opacity-80 transition">Home</a>
                    <a href="#fixtures" class="nav-link text-sm font-semibold text-white tracking-wider uppercase hover:text-opacity-80 transition">Fixtures</a>
                    <a href="#news" class="nav-link text-sm font-semibold text-white tracking-wider uppercase hover:text-opacity-80 transition">News</a>
                    <a href="#forum" class="nav-link text-sm font-semibold text-white tracking-wider uppercase hover:text-opacity-80 transition">Forum</a>
                </nav>
                <!-- Profile Dropdown -->
                <div class="flex items-center space-x-4">
                    <span class="text-white font-medium hidden sm:block">Madolla</span>
                    <button class="flex items-center space-x-2">
                        <img class="w-10 h-10 rounded-full ring-2 ring-white/50" src="https://i.pravatar.cc/150?u=jane.doe" alt="Fan Avatar">
                    </button>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-6 py-8">
            <!-- Welcome Banner (Full Width) -->
            <div id="home" class="lg:col-span-3 p-6 bg-white/20 backdrop-blur-sm rounded-xl border border-white/30">
                <h1 class="text-3xl font-bold text-white">Welcome to the Fan Hub!</h1>
                <p class="text-white/80 mt-1">Everything you need to support Mwatate FC, all in one place.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
                <!-- Left Column (Fixtures & News) -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Fixtures & Tickets Card -->
                    <div id="fixtures" class="bg-white/90 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden">
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
                                <button onclick="showTicketModal('Mwatate FC vs Vihiga United', '28 Oct 2023', 'Home Stadium')" class="btn px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-full hover:bg-blue-700">Book Tickets</button>
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
                                <button onclick="showInfoModal('Shabana FC vs Mwatate FC', '04 Nov 2023', 'Away')" class="btn px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-full hover:bg-blue-700">Get Info</button>
                            </div>
                        </div>
                    </div>

                    <!-- News & Blog Card -->
                    <div id="news" class="bg-white/90 backdrop-blur-sm rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Latest News</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- News Item -->
                            <div class="group cursor-pointer" onclick="showNewsModal('Manager\'s Pre-Match Press Conference', 'The gaffer shares his thoughts ahead of the big clash this weekend...', 'https://images.unsplash.com/photo-1579952363873-27f3bade9f55?q=80&w=2970&auto=format&fit=crop')">
                                <img src="https://images.unsplash.com/photo-1579952363873-27f3bade9f55?q=80&w=2970&auto=format&fit=crop" class="rounded-lg mb-2 h-40 w-full object-cover">
                                <h3 class="font-bold text-gray-800 group-hover:text-blue-600 transition">Manager's Pre-Match Press Conference</h3>
                                <p class="text-sm text-gray-600">The gaffer shares his thoughts ahead of the big clash this weekend...</p>
                            </div>
                            <!-- News Item -->
                            <div class="group cursor-pointer" onclick="showNewsModal('John Okoro Voted Player of the Month', 'Our star striker wins the fan-voted award after a stellar October...', 'https://images.unsplash.com/photo-1551958219-acbc608c6377?q=80&w=2970&auto=format&fit=crop')">
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
                        <button onclick="showProfileModal()" class="btn mt-4 w-full px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-full hover:bg-gray-300">Edit Profile</button>
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
                        <button onclick="showFormDetails()" class="btn mt-4 w-full px-4 py-2 text-sm font-semibold text-white bg-slate-800 rounded-full hover:bg-slate-900">View Match Details</button>
                    </div>

                    <!-- Fan Forum Card -->
                    <div id="forum" class="bg-white/90 backdrop-blur-sm rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Fan Forum</h3>
                        <p class="text-sm text-gray-500 mb-4">Share your thoughts on the last match!</p>
                        <form id="forumForm">
                            <textarea class="w-full h-24 p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="We need to be more clinical in front of goal..."></textarea>
                            <button type="submit" class="btn mt-3 w-full px-4 py-2 text-sm font-semibold text-white bg-slate-800 rounded-full hover:bg-slate-900">Post View</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Ticket Booking Modal -->
    <div id="ticketModal" class="modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Book Tickets</h3>
                    <button onclick="hideModal('ticketModal')" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="mb-4">
                    <h4 class="font-semibold text-gray-800" id="ticketMatchTitle">Match Title</h4>
                    <p class="text-sm text-gray-600" id="ticketMatchDate">Date</p>
                    <p class="text-sm text-gray-600" id="ticketMatchVenue">Venue</p>
                </div>
                <form id="ticketForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Number of Tickets</label>
                        <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Seat Category</label>
                        <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option>General Admission (KSh 500)</option>
                            <option>VIP (KSh 1,500)</option>
                            <option>Premium (KSh 3,000)</option>
                        </select>
                    </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" onclick="hideModal('ticketModal')" class="btn px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-full hover:bg-gray-300">
                            Cancel
                        </button>
                        <button type="submit" class="btn px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700">
                            Book Now
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Match Info Modal -->
    <div id="infoModal" class="modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Match Information</h3>
                    <button onclick="hideModal('infoModal')" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="mb-4">
                    <h4 class="font-semibold text-gray-800" id="infoMatchTitle">Match Title</h4>
                    <p class="text-sm text-gray-600" id="infoMatchDate">Date</p>
                    <p class="text-sm text-gray-600" id="infoMatchVenue">Venue</p>
                </div>
                <div class="space-y-3">
                    <div>
                        <h5 class="font-medium text-gray-800">Transportation</h5>
                        <p class="text-sm text-gray-600">Buses will depart from Mwatate town center at 1:00 PM</p>
                    </div>
                    <div>
                        <h5 class="font-medium text-gray-800">Fan Meeting Point</h5>
                        <p class="text-sm text-gray-600">Gate 3 - Blue Zone</p>
                    </div>
                    <div>
                        <h5 class="font-medium text-gray-800">Important Notes</h5>
                        <p class="text-sm text-gray-600">Please arrive at least 45 minutes before kickoff</p>
                    </div>
                </div>
                <div class="mt-6">
                    <button onclick="hideModal('infoModal')" class="btn w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- News Modal -->
    <div id="newsModal" class="modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800" id="newsTitle">News Title</h3>
                    <button onclick="hideModal('newsModal')" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <img id="newsImage" src="" class="rounded-lg mb-4 w-full h-48 object-cover">
                <p class="text-gray-700" id="newsContent">News content goes here...</p>
                <div class="mt-6">
                    <button onclick="hideModal('newsModal')" class="btn w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Modal -->
    <div id="profileModal" class="modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Edit Profile</h3>
                    <button onclick="hideModal('profileModal')" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="profileForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" value="Jane Doe" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" value="jane.doe@example.com" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Profile Picture</label>
                        <input type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" onclick="hideModal('profileModal')" class="btn px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-full hover:bg-gray-300">
                            Cancel
                        </button>
                        <button type="submit" class="btn px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Form Details Modal -->
    <div id="formDetailsModal" class="modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Recent Match Results</h3>
                    <button onclick="hideModal('formDetailsModal')" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="space-y-4">
                    <div class="p-3 bg-green-50 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Mwatate FC 3-1 Coastal United</span>
                            <span class="text-sm text-gray-500">22 Oct 2023</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">Goals: Okoro (2), Mwangi</p>
                    </div>
                    <div class="p-3 bg-green-50 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Mwatate FC 2-0 Mountain Stars</span>
                            <span class="text-sm text-gray-500">15 Oct 2023</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">Goals: Okoro, Kamau</p>
                    </div>
                    <div class="p-3 bg-red-50 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Lakeside FC 1-0 Mwatate FC</span>
                            <span class="text-sm text-gray-500">08 Oct 2023</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">Red card: Otieno (65')</p>
                    </div>
                </div>
                <div class="mt-6">
                    <button onclick="hideModal('formDetailsModal')" class="btn w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal Functions
        function showModal(modalId) {
            document.getElementById(modalId).classList.add('active');
        }

        function hideModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        function showTicketModal(matchTitle, matchDate, matchVenue) {
            document.getElementById('ticketMatchTitle').textContent = matchTitle;
            document.getElementById('ticketMatchDate').textContent = matchDate;
            document.getElementById('ticketMatchVenue').textContent = matchVenue;
            showModal('ticketModal');
        }

        function showInfoModal(matchTitle, matchDate, matchVenue) {
            document.getElementById('infoMatchTitle').textContent = matchTitle;
            document.getElementById('infoMatchDate').textContent = matchDate;
            document.getElementById('infoMatchVenue').textContent = matchVenue;
            showModal('infoModal');
        }

        function showNewsModal(title, content, imageUrl) {
            document.getElementById('newsTitle').textContent = title;
            document.getElementById('newsContent').textContent = content;
            document.getElementById('newsImage').src = imageUrl;
            showModal('newsModal');
        }

        function showProfileModal() {
            showModal('profileModal');
        }

        function showFormDetails() {
            showModal('formDetailsModal');
        }

        // Form Submissions
        document.getElementById('ticketForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Ticket booking successful!');
            hideModal('ticketModal');
        });

        document.getElementById('profileForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Profile updated successfully!');
            hideModal('profileModal');
        });

        document.getElementById('forumForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Your post has been submitted to the forum!');
            this.reset();
        });

        // Close modals when clicking outside
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                }
            });
        });

        // Navbar active link functionality
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link');
            const sections = document.querySelectorAll('main > div[id]');
            
            // Set initial active link based on hash or default to Home
            if (window.location.hash) {
                setActiveLink(window.location.hash);
            } else {
                setActiveLink('#home');
            }
            
            // Handle click on nav links
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    setActiveLink(targetId);
                    
                    // Scroll to section
                    const targetSection = document.querySelector(targetId);
                    if (targetSection) {
                        targetSection.scrollIntoView({ behavior: 'smooth' });
                    }
                    
                    // Update URL without page reload
                    history.pushState(null, null, targetId);
                });
            });
            
            // Handle back/forward navigation
            window.addEventListener('popstate', function() {
                setActiveLink(window.location.hash || '#home');
            });
            
            // Intersection Observer for scroll-based activation
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const id = '#' + entry.target.id;
                        if (id !== window.location.hash) {
                            history.replaceState(null, null, id);
                        }
                        setActiveLink(id);
                    }
                });
            }, { threshold: 0.5 });
            
            sections.forEach(section => {
                observer.observe(section);
            });
            
            function setActiveLink(targetId) {
                navLinks.forEach(link => {
                    if (link.getAttribute('href') === targetId) {
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                });
            }
        });
    </script>
</body>
</html>