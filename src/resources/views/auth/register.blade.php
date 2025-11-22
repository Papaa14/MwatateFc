<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Mwatate FC Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Toastify CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <style>
        body { font-family: 'Montserrat', sans-serif; }
        .error-message { color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; }
    </style>
</head>
<body class="bg-[#f5fbf9] flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md">
        <!-- Branding Section -->
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-full shadow-md mx-auto">
                <svg class="w-9 h-9 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-2.757 0-5-3.228-5-9S5.243 3 8 3s5 4.772 5 9"></path></svg>
            </div>
            <h1 class="mt-6 text-3xl font-extrabold text-gray-900">Create an Account</h1>
            <p class="mt-2 text-sm text-gray-600">Join us to be our number one fan.</p>
        </div>

        <!-- Form Card -->
        <div class="mt-8 bg-white py-8 px-10 shadow-lg rounded-lg">
            <!-- Give form an ID for JS targeting. We leave action/method for non-JS fallback -->
            <form id="registerForm" class="space-y-6" action="{{ url('/api/register') }}" method="POST">
                @csrf <!-- Good practice, though not used by our API token route -->

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Username</label>
                    <div class="mt-1">
                        <!-- Changed name="fullname" to name="name" to match API -->
                        <input id="name" name="name" type="text" autocomplete="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm ...">
                    </div>
                    <!-- Error message container -->
                    <div id="name-error" class="error-message"></div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm ...">
                    </div>
                    <div id="email-error" class="error-message"></div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="new-password" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm ...">
                    </div>
                    <div id="password-error" class="error-message"></div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <div class="mt-1">
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm ...">
                    </div>
                    <!-- No error needed here, password error will show "confirmation does not match" -->
                </div>
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Select Role</label>
                    <div class="mt-1">
                        <select id="role" name="role" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Choose a role</option>
                            <option value="admin">Admin</option>
                            <option value="fan">Fan</option>
                            <option value="coach">Coach</option>
                            <option value="player">Player</option>
                        </select>
                    </div>
                    <div id="role-error" class="error-message"></div>
                </div>


                <div>
                    <button type="submit" id="submit-button"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none ...">
                        Create Account
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Already have an account?
                    <!-- Assuming you have a named route for login -->
                    <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        Sign in
                    </a>
                </p>
            </div>

        </div>
    </div>

<!-- Axios and Toastify JS -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('registerForm');
        const submitButton = document.getElementById('submit-button');

        form.addEventListener('submit', async function (event) {
            // 1. Prevent the default synchronous form submission
            event.preventDefault();

            // Clear previous errors and disable button
            clearErrors();
            submitButton.disabled = true;
            submitButton.textContent = 'Creating...';

            // 2. Get form data
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());


            try {
                // 4. Send the data asynchronously to our Laravel API
                const response = await axios.post('{{ url("/api/register") }}', data, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                // 5. Handle SUCCESS
                // Show a success toast
                Toastify({
                    text: "Registration successful! Redirecting to login...",
                    duration: 3000,
                    gravity: "top", // `top` or `bottom`
                    position: "centre", // `left`, `center` or `right`
                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                }).showToast();

                // Redirect to the login page after a short delay
                setTimeout(() => {
                    // Replace '#' with your actual login route
                    window.location.href ='{{ route("login") }}'; ;
                }, 3000);

            } catch (error) {
                // 6. Handle ERRORS
                submitButton.disabled = false;
                submitButton.textContent = 'Create Account';

                if (error.response && error.response.status === 422) {
                    // This is a validation error
                    displayErrors(error.response.data.errors);
                    Toastify({
                        text: "Please fix the errors below.",
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                    }).showToast();
                } else {
                    // Other errors (e.g., server error)
                    console.error('An unexpected error occurred:', error);
                    Toastify({
                        text: "An unexpected error occurred. Please try again.",
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                    }).showToast();
                }
            }
        });

        function displayErrors(errors) {
            for (const field in errors) {
                const errorElement = document.getElementById(`${field}-error`);
                if (errorElement) {
                    errorElement.textContent = errors[field][0];
                }
            }
        }

        function clearErrors() {
            const errorElements = document.querySelectorAll('.error-message');
            errorElements.forEach(el => el.textContent = '');
        }
    });
</script>

</body>
</html>
