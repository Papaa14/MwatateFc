<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mwatate FC Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Toastify CSS for notifications -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        .error-message {
            color: #ef4444;
            /* red-500 */
            font-size: 0.875rem;
            margin-top: 0.5rem;
            text-align: center;
            min-height: 1.25rem;
            /* Prevents layout shift */
        }
    </style>

    <!-- Custom Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#16a34a', // A nice, modern green
                        'brand-green-dark': '#15803d',
                        'brand-purple': '#6d28d9', // A vibrant purple for links
                        'brand-light': '#f5fbf9'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-brand-light flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-sm">
        <!-- Branding Section -->
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-full shadow-md mx-auto">
                <svg class="w-9 h-9 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-2.757 0-5-3.228-5-9S5.243 3 8 3s5 4.772 5 9">
                    </path>
                </svg>
            </div>
            <h1 class="mt-6 text-3xl font-extrabold text-gray-900">Mwatate FC Management</h1>
            <p class="mt-2 text-sm text-gray-600">🎉 Welcome back !!</p>
        </div>

        <!-- Form Card -->
        <div class="mt-8 bg-white py-8 px-8 shadow-xl rounded-xl">
            <form id="loginForm" class="space-y-6" method="POST">

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" placeholder="johndoe@gmail.com"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400  placeholder:text-sm
                                      focus:outline-none focus:ring-1 focus:ring-brand-green focus:border-brand-green">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" placeholder="password must be at least 8 characters"
                            type="password" autocomplete="current-password" required class="w-full px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400  placeholder:text-sm
                                      focus:outline-none focus:ring-1 focus:ring-brand-green focus:border-brand-green">
                    </div>
                </div>

                <!-- Forgot Password Link -->
                <div class="flex items-center justify-end mb-2">
                    <div class="text-sm">
                        <a href="{{ route('reset') }}" class="font-medium text-brand-purple hover:underline">
                            Forgot password?
                        </a>
                    </div>
                </div>

                <!-- Container for displaying login errors (hidden by default) -->
                <div id="login-error" class="error-message hidden text-red-600 text-sm min-h-[1.5rem] mb-2"></div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" id="submit-button" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white
               bg-brand-green hover:bg-brand-green-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-green
               transition-colors duration-200">
                        Sign In
                    </button>
                </div>
                <!-- Sign Up Prompt -->
                <div class="mt-4 text-center text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-medium text-brand-purple hover:underline">
                        Sign Up
                    </a>
                </div>
                <!-- The JavaScript for AJAX submission remains unchanged -->
                <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
                <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
                <script>
                    // Your existing, excellent JavaScript logic goes here.
                    document.addEventListener('DOMContentLoaded', function () {
                        const loginForm = document.getElementById('loginForm');
                        const submitButton = document.getElementById('submit-button');
                        const errorContainer = document.getElementById('login-error');

                        loginForm.addEventListener('submit', async function (event) {
                            event.preventDefault();
                            submitButton.disabled = true;
                            submitButton.textContent = 'Signing In...';
                            errorContainer.textContent = '';
                            const formData = new FormData(loginForm);
                            const data = Object.fromEntries(formData.entries());

                            try {
                                const response = await axios.post('{{ url("/api/login") }}', data, {
                                    headers: { 'Accept': 'application/json' }
                                });
                                localStorage.setItem('api_token', response.data.token);
                                localStorage.setItem('user', JSON.stringify(response.data.user));
                                Toastify({
                                    text: "Login Successful! Redirecting...", duration: 2000, gravity: "top", position: "centre",
                                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                                }).showToast();
                                const userRole = response.data.user.role;
                                let redirectUrl = '/';
                                switch (userRole) {
                                    case 'admin': redirectUrl = '{{ route("dashboard") }}'; break;
                                    case 'coach': redirectUrl = '{{ route("coach-dashboard") }}'; break;
                                    case 'player': redirectUrl = '{{ route("players-dashboard") }}'; break;
                                    case 'fan': redirectUrl = '{{ route("fan-dashboard") }}'; break;
                                }
                                setTimeout(() => { window.location.href = redirectUrl; }, 2000);
                            } catch (error) {
                                submitButton.disabled = false;
                                submitButton.textContent = 'Sign In';
                                const message = error.response?.data?.message || 'An unknown error occurred.';
                                errorContainer.textContent = message;
                                Toastify({
                                    text: message, duration: 3000, gravity: "top", position: "right",
                                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                                }).showToast();
                            }
                        });
                    });
                </script>

</body>

</html>