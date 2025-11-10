<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart OLT</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#4A5C80] dark:bg-[#4A5C80] text-black-800 dark:text-black-100">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <x-sidebar />

        <!-- Main content -->
        <main class="flex-1 p-6 ml-64">
            {{ $slot }}
        </main>
    </div>

</body>
</html>
