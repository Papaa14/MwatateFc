<?php
// File: resources/views/layouts/coach.blade.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Coach Dashboard - Mwatate FC')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-blue-50 font-sans">
    <div class="flex h-screen overflow-hidden">
        @include('components.coach.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('components.coach.top-nav')

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-blue-50 p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
