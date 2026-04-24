<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Kata Sandi — Hanglekiu Dental Clinic</title>
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
            margin-bottom: 24px;
            text-align: left;
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
            margin-top: 8px;
        }

        .btn:hover {
            background: #3d1e08;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(88, 44, 12, 0.3);
        }

        .back-link {
            margin-top: 24px;
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

        .status-message {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            text-align: left;
        }

        .status-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .status-error {
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

        <h1>Lupa Kata Sandi?</h1>
        <p class="description">Jangan khawatir! Berikan kami alamat email Anda, dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.</p>

        @if (session('status'))
            <div class="status-message status-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="status-message status-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" name="email" id="email" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
            </div>

            <button type="submit" class="btn">Kirim Tautan Atur Ulang</button>
        </form>

        <a href="{{ route('login') }}" class="back-link">← Kembali ke Halaman Masuk</a>
    </div>
</body>
</html>
