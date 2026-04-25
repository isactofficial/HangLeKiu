<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verifikasi Email — Hanglekiu Dental Clinic</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Instrument Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(88, 44, 12, 0.05) 0%, rgba(197, 143, 89, 0.1) 100%), url('{{ asset('images/bg-clinic.png') }}') no-repeat center center fixed;
            background-size: cover;
            padding: 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(88, 44, 12, 0.15);
            padding: 48px 40px;
            width: 100%;
            max-width: 480px;
            text-align: center;
            border: 1px solid rgba(197, 143, 89, 0.2);
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo {
            margin-bottom: 24px;
        }

        .logo img {
            height: 64px;
            object-fit: contain;
        }

        .icon-box {
            width: 80px;
            height: 80px;
            background: rgba(197, 143, 89, 0.1);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }

        .icon-box svg {
            width: 40px;
            height: 40px;
            color: #C58F59;
        }

        h1 {
            font-size: 24px;
            color: #582C0C;
            margin-bottom: 12px;
            font-weight: 700;
        }

        .description {
            font-size: 15px;
            color: #6B513E;
            margin-bottom: 32px;
            line-height: 1.6;
        }

        .email-display {
            background: #F7F7F7;
            padding: 12px 20px;
            border-radius: 12px;
            color: #582C0C;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 32px;
            border: 1px solid rgba(88, 44, 12, 0.05);
        }

        .btn {
            width: 100%;
            padding: 16px;
            background: #582C0C;
            color: #F7F7F7;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 16px;
        }

        .btn:hover:not(:disabled) {
            background: #3d1e08;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(88, 44, 12, 0.3);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .back-link {
            display: block;
            font-size: 14px;
            color: #C58F59;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #582C0C;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            text-align: left;
        }

        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">
            <img src="{{ asset('images/logo-hds.png') }}" alt="Hanglekiu Dental Clinic">
        </div>

        <div class="icon-box">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                <polyline points="22,6 12,13 2,6"></polyline>
            </svg>
        </div>

        <h1>Verifikasi Email Anda</h1>
        <p class="description">
            Terima kasih telah bergabung! Kami telah mengirimkan tautan verifikasi ke email:
        </p>
        
        <div class="email-display">{{ $email }}</div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <button type="submit" class="btn" id="resend-btn">Kirim Ulang Tautan</button>
        </form>

        <a href="{{ route('login') }}" class="back-link">Kembali ke Halaman Masuk</a>
    </div>

    <script>
        document.getElementById('resend-btn').addEventListener('click', function() {
            const btn = this;
            btn.disabled = true;
            btn.innerText = 'Mengirim...';
            setTimeout(() => {
                btn.form.submit();
            }, 500);
        });
    </script>
</body>
</html>
