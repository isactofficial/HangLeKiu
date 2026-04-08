<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil — Hanglekiu Dental</title>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --font-color-primary: #582C0C;
            --font-color-secondary: #6B513E;
            --color-background-secondary: #E5D6C5;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Instrument Sans', sans-serif;
            background: url('{{ asset("images/bg-clinic.png") }}') no-repeat center center fixed;
            background-size: cover;
        }

        .success-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 7.5rem 1rem 2rem;
            box-sizing: border-box;
        }

        .success-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 40px rgba(88, 44, 12, 0.15);
            padding: 52px 44px;
            text-align: center;
            max-width: 440px;
            width: 100%;
        }

        .success-icon {
            font-size: 64px;
            margin-bottom: 20px;
        }

        .success-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--font-color-primary);
            margin: 0 0 10px;
        }

        .success-text {
            font-size: 14px;
            color: var(--font-color-secondary);
            line-height: 1.7;
            margin: 0 0 28px;
        }

        .success-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .success-btn {
            display: inline-block;
            padding: 13px 28px;
            background: var(--font-color-primary);
            color: white;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            font-family: inherit;
            transition: all 0.3s;
        }

        .success-btn:hover {
            background: #3d1e08;
            box-shadow: 0 6px 20px rgba(88, 44, 12, 0.3);
            transform: translateY(-1px);
        }

        .success-btn-secondary {
            background: #F7EFE7;
            color: var(--font-color-primary);
            border: 1px solid #D8B99D;
        }

        .success-btn-secondary:hover {
            background: #EEDFCC;
            box-shadow: none;
        }
    </style>
</head>
<body>
 @include('user.components.navbarWelcome')

<div class="success-page">
<div class="success-card">
    <div class="success-icon">✅</div>
    <h2 class="success-title">Pendaftaran Berhasil!</h2>
    <p class="success-text">Terima kasih telah mendaftar. Kami akan menghubungi kamu via WhatsApp untuk konfirmasi jadwal dalam 1×24 jam.</p>
    <div class="success-actions">
        <a href="{{ route('appointments.create') }}" class="success-btn">Daftar Lagi</a>
        <a href="{{ auth()->check() ? route('user.dashboard') : url('/') }}" class="success-btn success-btn-secondary">
            {{ auth()->check() ? 'Kembali ke Dashboard Akun' : 'Kembali ke Beranda' }}
        </a>
    </div>
</div>
</div>
</body>
</html>
