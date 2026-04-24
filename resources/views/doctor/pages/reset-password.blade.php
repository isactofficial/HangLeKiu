<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Dokter - Hanglekiu</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;600;700&display=swap" rel="stylesheet">

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
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(88, 44, 12, 0.08);
            width: 100%;
            max-width: 400px;
        }

        .title {
            text-align: center;
            color: #582C0C;
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #582C0C;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1.5px solid #C58F59;
            border-radius: 10px;
            outline: none;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: #582C0C;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 15px;
            font-size: 13px;
        }

        /* PASSWORD ICON */
        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 40px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #582C0C;
            font-size: 16px;
            user-select: none;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1 class="title">Atur Ulang Password</h1>

        @if($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ $email ?? old('email') }}" readonly style="background: #f9f9f9;">
            </div>

            <div class="form-group">
                <label>Password Baru</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" required>
                    <span class="toggle-password" onclick="togglePassword('password', this)">👁</span>
                </div>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password_confirmation" id="password_confirmation" required>
                    <span class="toggle-password" onclick="togglePassword('password_confirmation', this)">👁</span>
                </div>
            </div>

            <button type="submit" class="btn">Simpan Password</button>
        </form>
    </div>

    <script>
        function togglePassword(id, el) {
            const input = document.getElementById(id);

            if (input.type === "password") {
                input.type = "text";
                el.textContent = "🙈";
            } else {
                input.type = "password";
                el.textContent = "👁";
            }
        }
    </script>
</body>
</html>