<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dokter Register - Hanglekiu Dental Clinic</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background-color: #C58F59;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 28px 32px;
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(88, 44, 12, 0.08);
            width: 100%;
            max-width: 520px;
        }

        .logo {
            text-align: center;
            margin-bottom: 16px;
        }

        .logo-icon {
            width: 84px;
            height: 84px;
            margin: 0 auto;
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .title {
            text-align: center;
            color: #582C0C;
            margin-bottom: 16px;
            font-weight: 700;
            font-size: 20px;
        }

        .form-group {
            margin-bottom: 14px;
            position: relative;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #582C0C;
            margin-bottom: 6px;
        }

        .form-group input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #C58F59;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Instrument Sans', sans-serif;
            color: #582C0C;
            background: transparent;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            border-color: #582C0C;
        }

        .form-group input::placeholder {
            color: #C58F59;
            opacity: 0.6;
        }

        .form-group input[type="password"] {
            padding-right: 40px;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 36px;
            background: none;
            border: none;
            cursor: pointer;
            color: #582C0C;
            padding: 4px;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }

        .password-toggle:hover {
            color: #C58F59;
        }

        .password-toggle svg {
            width: 20px;
            height: 20px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: #582C0C;
            color: #F7F7F7;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Instrument Sans', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 6px;
        }

        .btn:hover {
            background: #3d1e08;
            box-shadow: 0 6px 20px rgba(88, 44, 12, 0.35);
            transform: translateY(-1px);
        }

        .muted {
            text-align: center;
            margin-top: 12px;
            font-size: 14px;
            color: #582C0C;
        }

        .muted a {
            color: #C58F59;
            text-decoration: none;
            font-weight: 600;
        }

        .error {
            background-color: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            font-size: 14px;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .error div + div {
            margin-top: 6px;
        }

        @media (max-width: 480px) {
            .card {
                padding: 24px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">
            <div class="logo-icon"><img src="{{ asset('images/logo-hds.png') }}" alt="Hanglekiu Dental Clinic"></div>
        </div>

        <h1 class="title">Daftar Akun Dokter</h1>

        @if($errors->any())
            <div class="error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('doctor.register.post') }}">
            @csrf

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" name="name" id="name" placeholder="Nama dokter" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="phone_number">No. Telepon</label>
                <input type="text" name="phone_number" id="phone_number" placeholder="08xxxxxxxxxx" value="{{ old('phone_number') }}">
            </div>

            <div class="form-group">
                <label for="specialization">Spesialisasi</label>
                <input type="text" name="specialization" id="specialization" placeholder="Contoh: Sp.Ortho" value="{{ old('specialization') }}">
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

            <button type="submit" class="btn">Daftar</button>
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
