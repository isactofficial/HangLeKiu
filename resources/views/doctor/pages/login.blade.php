<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Doctor Login - Hanglekiu Dental Clinic</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background: url('{{ asset('images/bg-clinic.png') }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 28px 36px;
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(88, 44, 12, 0.08);
            width: 100%;
            max-width: 430px;
        }

        .logo {
            text-align: center;
            margin-bottom: 14px;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            overflow: hidden;
            display: inline-flex;
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
            margin-bottom: 14px;
            font-size: 20px;
            font-weight: 700;
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
            color: #582C0C;
            outline: none;
        }

        .form-group input[type="password"] {
            padding-right: 42px;
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
            cursor: pointer;
            margin-top: 6px;
        }

        .error {
            background-color: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            font-size: 14px;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 16px;
        }

        .success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            font-size: 14px;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 16px;
        }

        .muted {
            text-align: center;
            margin-top: 12px;
            color: #582C0C;
            font-size: 14px;
        }

        .muted a {
            color: #C58F59;
            text-decoration: none;
            font-weight: 600;
        }

        .form-group input:-webkit-autofill {
            -webkit-text-fill-color: #582C0C !important;
            -webkit-box-shadow: 0 0 0px 1000px white inset !important;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">
            <div class="logo-icon"><img src="{{ asset('images/logo-hds.png') }}" alt="Hanglekiu Dental Clinic"></div>
        </div>

        <h1 class="title">Login Dokter</h1>

        @if(session('status'))
            <div class="success">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('doctor.login.post') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Dokter</label>
                <input type="email" name="email" id="email" placeholder="Email Dokter" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required autocomplete="current-password">
                <button type="button" class="password-toggle" onclick="togglePassword('password', 'eye-icon')">
                    <svg id="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>

            <div style="text-align: right; margin-bottom: 14px;">
                <a href="{{ route('doctor.password.request') }}" style="color: #C58F59; text-decoration: none; font-size: 14px; font-weight: 600;">Lupa Password?</a>
            </div>

            <button type="submit" class="btn">Masuk</button>
        </form>

        <div class="muted">
            Login sebagai user? <a href="{{ route('login') }}">Klik di sini</a>
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