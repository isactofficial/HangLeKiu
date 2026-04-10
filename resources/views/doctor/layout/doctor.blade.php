<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dokter') — HDS</title>

    {{-- Tailwind (sesuaikan jika sudah ada via Vite/Mix) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- CSS admin EMR (reuse) --}}
    <link rel="stylesheet" href="{{ asset('css/admin/pages/emr.css') }}">

    <style>
        :root {
            --color-background-secondary: #f0e8df;
            --font-color-primary: #3b331e;
            --font-color-secondary: #8e6a45;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background-color: #f7f3ef;
            color: #3b331e;
        }

        /* Beri ruang atas untuk navbar fixed */
        .doctor-page-wrapper {
            padding-top: 70px;
            min-height: 100vh;
        }
    </style>

    @stack('styles')
</head>
<body>

    @include('doctor.components.navbarDoctor', ['activeNav' => ''])

    {{-- KONTEN UTAMA --}}
    <div class="doctor-page-wrapper">
        @yield('content')
    </div>

    {{-- JS Global --}}
    <script>
        // Tutup dropdown saat klik di luar
        document.addEventListener('click', function () {
            document.querySelectorAll('.emr-filter-box.open').forEach(el => el.classList.remove('open'));
            document.querySelectorAll('#diagnosa-menu:not(.hidden)').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('#status-menu-dynamic:not(.hidden)').forEach(el => el.classList.add('hidden'));
        });
    </script>

    @stack('scripts')
</body>
</html>