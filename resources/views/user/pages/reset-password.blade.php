<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Atur Ulang Kata Sandi — Hanglekiu Dental Clinic</title>
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
            max-width: 440px;
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

        h1 {
            font-size: 24px;
            color: #582C0C;
            margin-bottom: 12px;
            font-weight: 700;
        }

        .description {
            font-size: 14px;
            color: #6B513E;
            margin-bottom: 32px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
            position: relative;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #582C0C;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 18px;
            border: 1.5px solid #C58F59;
            border-radius: 12px;
            font-size: 15px;
            font-family: 'Instrument Sans', sans-serif;
            color: #582C0C;
            background: white;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: #582C0C;
            box-shadow: 0 0 0 4px rgba(88, 44, 12, 0.05);
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 38px;
            background: none;
            border: none;
            cursor: pointer;
            color: #C58F59;
            display: flex;
            align-items: center;
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
            margin-top: 16px;
        }

        .btn:hover {
            background: #3d1e08;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(88, 44, 12, 0.3);
        }

        .status-message {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            text-align: left;
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

        <h1>Atur Ulang Kata Sandi</h1>
        <p class="description">Silakan masukkan email Anda dan ketikkan kata sandi baru untuk akun Anda.</p>

        @if ($errors->any())
            <div class="status-message">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ $email ?? old('email') }}" required readonly>
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi Baru</label>
                <input type="password" name="password" id="password" placeholder="Minimal 8 karakter" required autofocus>
                <button type="button" class="password-toggle" onclick="togglePassword('password', 'eye-1')">
                    <svg id="eye-1" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi kata sandi baru" required>
                <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', 'eye-2')">
                    <svg id="eye-2" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>

            <button type="submit" class="btn">Perbarui Kata Sandi</button>
        </form>
    </div>

    <script>
        function togglePassword(id, iconId) {
            const input = document.getElementById(id);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            }
        }
    </script>
</body>
</html>
