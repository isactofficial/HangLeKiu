<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">
    <x-navbar />
    <main class="grow container mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-lg p-8 text-center max-w-2xl mx-auto mt-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">User Dashboard</h1>
            <p class="text-gray-600 mb-8">Welcome, {{ Auth::user()->name }}! You are logged in as a User.</p>

            <a href="{{ route('appointments.create') }}"
                class="bg-amber-600 hover:bg-amber-700 text-white font-semibold py-2.5 px-6 rounded-lg transition duration-300 inline-block">
                + Daftar Kunjungan
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded-lg transition duration-300">Logout</button>
            </form>
        </div>
    </main>
</body>

</html>
