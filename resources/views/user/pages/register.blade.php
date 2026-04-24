<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register — Hanglekiu Dental Clinic</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background: linear-gradient(135deg, rgba(88, 44, 12, 0.05) 0%, rgba(197, 143, 89, 0.1) 100%), url('{{ asset('images/bg-clinic.png') }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 40px 48px;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(88, 44, 12, 0.15);
            width: 520px;
            border: 1px solid rgba(197, 143, 89, 0.2);
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo {
            text-align: center;
            margin-bottom: 24px;
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-icon {
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-icon img {
            height: 100%;
            object-fit: contain;
        }

        .form-group {
            margin-bottom: 18px;
            position: relative;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #582C0C;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #C58F59;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Instrument Sans', sans-serif;
            color: #582C0C;
            background: white;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-group input::placeholder {
            color: #C58F59;
            opacity: 0.6;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #582C0C;
            box-shadow: 0 0 0 4px rgba(88, 44, 12, 0.05);
        }

        /* Password field needs right padding for toggle button */
        .form-group input[type="password"] {
            padding-right: 44px;
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 38px;
            background: none;
            border: none;
            cursor: pointer;
            color: #C58F59;
            padding: 4px;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }

        .password-toggle:hover {
            color: #582C0C;
        }

        .password-toggle svg {
            width: 20px;
            height: 20px;
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
            font-family: 'Instrument Sans', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn:hover {
            background: #3d1e08;
            box-shadow: 0 8px 25px rgba(88, 44, 12, 0.3);
            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .muted {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #582C0C;
        }

        .muted a {
            color: #C58F59;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .muted a:hover {
            color: #582C0C;
        }

        .error {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            font-size: 14px;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
        }

        .error div {
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .card { width: 100%; max-width: 440px; padding: 32px 28px; }
        }

        @media (max-width: 480px) {
            .card { padding: 28px 22px; }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">
            <div class="logo-container">
                <div class="logo-icon"><img src="{{ asset('images/logo-hds.png') }}" alt="Hanglekiu Dental Clinic"></div>
            </div>
        </div>

        @if($errors->any())
            <div class="error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" name="name" id="name" placeholder="Nama lengkap" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="phone_number">No. HP</label>
                <input type="text" name="phone_number" id="phone_number" placeholder="08xxxxxxxxxx" value="{{ old('phone_number') }}" required>
            </div>

            <div class="form-group">
                <label for="date_of_birth">Tanggal Lahir</label>
                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" required>
            </div>

            <div class="form-group">
                <label for="gender">Jenis Kelamin</label>
                <select name="gender" id="gender" required>
                    <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Pilih jenis kelamin</option>
                    <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password (min 8)" required autocomplete="new-password">
                <button type="button" class="password-toggle" onclick="togglePassword('password', 'eye-icon-1')">
                    <svg id="eye-icon-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password" required autocomplete="new-password">
                <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', 'eye-icon-2')">
                    <svg id="eye-icon-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>

            <button type="submit" class="btn" id="register-button">Daftar</button>
        </form>

        <div class="muted">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                    <line x1="1" y1="1" x2="23" y2="23"/>
                `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                `;
            }
        }
    </script>
</body>
</html>
