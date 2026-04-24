<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — Hanglekiu Dental Clinic</title>
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
            background: url('{{ asset('images/bg-clinic.png') }}') no-repeat center center fixed;
            background-size: cover;
        }

        .card {
            display: flex;
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 40px rgba(88, 44, 12, 0.15);
            overflow: hidden;
            width: 900px;
            min-height: 540px;
        }

        .card-image {
            width: 45%;
            min-height: 100%;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top;
            display: block;
        }

        .card-form {
            width: 55%;
            padding: 48px 44px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo {
            margin-bottom: 8px;
        }

        .logo img {
            height: 60px;
            object-fit: contain;
        }

        .tagline {
            font-size: 14px;
            color: #6B513E;
            margin-bottom: 28px;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 20px;
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
            padding: 12px 16px;
            border: 1.5px solid #C58F59;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Instrument Sans', sans-serif;
            color: #582C0C;
            background: transparent;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .form-group input::placeholder {
            color: #C58F59;
            opacity: 0.6;
        }

        .form-group input:focus {
            border-color: #582C0C;
        }

        .form-group input[type="password"] {
            padding-right: 40px;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
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

        .forgot-link {
            text-align: right;
            margin-top: 8px;
        }

        .forgot-link a {
            font-size: 14px;
            color: #C58F59;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-link a:hover {
            color: #582C0C;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background: #582C0C;
            color: #F7F7F7;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Instrument Sans', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 8px;
        }

        .btn:hover {
            background: #3d1e08;
            box-shadow: 0 6px 20px rgba(88, 44, 12, 0.35);
            transform: translateY(-1px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .divider {
            text-align: center;
            margin: 16px 0;
            font-size: 14px;
            color: #6B513E;
            opacity: 0.6;
        }

        .google-btn {
            width: 100%;
            padding: 12px;
            background: white;
            border: 2px solid #582C0C;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Instrument Sans', sans-serif;
            color: #582C0C;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .google-btn:hover {
            border-color: #582C0C;
            box-shadow: 0 2px 8px rgba(197, 143, 89, 0.15);
        }

        .google-btn svg {
            width: 20px;
            height: 20px;
        }

        .muted {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6B513E;
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

        .form-group input:-webkit-autofill {
            -webkit-text-fill-color: #582C0C !important;
            -webkit-box-shadow: 0 0 0px 1000px white inset !important;
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

        .error div {
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 992px) {
            body { padding: 20px; }
            .card { width: 100%; max-width: 900px; }
        }

        @media (max-width: 768px) {
            .card { flex-direction: column; width: 100%; max-width: 480px; }
            .card-image { width: 100%; height: 280px; }
            .card-form { width: 100%; padding: 32px 28px; }
        }

        @media (max-width: 480px) {
            .card-form { padding: 24px 20px; }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-image">
            <img src="{{ asset('images/dentist.png') }}" alt="Dokter Gigi Hanglekiu Dental Clinic">
        </div>

        <div class="card-form">
            <div class="logo">
                <img src="{{ asset('images/logo-hds.png') }}" alt="Hanglekiu Dental Clinic">
            </div>

            <p class="tagline">Wujudkan Senyum Impian Anda Bersama Tim Spesialis Kami</p>

            @if($errors->any())
                <div class="error">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}" required autofocus autocomplete="email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password" required autocomplete="current-password">
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <svg id="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                    <div class="forgot-link">
                        <a href="{{ route('password.request') }}">Lupa Kata Sandi?</a>
                    </div>
                </div>

                <button type="submit" class="btn" id="login-button">Masuk</button>
            </form>

            <div class="divider">Atau</div>

            <a href="{{ route('google.login') }}" class="google-btn" style="text-decoration: none;">
                <svg viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Masuk dengan Google
            </a>

            <div class="muted">
                Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                    <line x1="1" y1="1" x2="23" y2="23"/>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                `;
            }
        }
    </script>
</body>
</html>
