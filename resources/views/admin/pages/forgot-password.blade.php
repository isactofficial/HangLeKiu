<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password Admin - Hanglekiu</title>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Instrument Sans', sans-serif; background: url('{{ asset('images/bg-clinic.png') }}') no-repeat center center fixed; background-size: cover; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .card { background: white; padding: 30px; border-radius: 20px; box-shadow: 0 4px 24px rgba(88, 44, 12, 0.08); width: 100%; max-width: 400px; }
        .title { text-align: center; color: #582C0C; margin-bottom: 10px; font-size: 20px; font-weight: 700; }
        .desc { text-align: center; font-size: 14px; color: #666; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 14px; font-weight: 600; color: #582C0C; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 12px; border: 1.5px solid #C58F59; border-radius: 10px; outline: none; }
        .btn { width: 100%; padding: 12px; background: #582C0C; color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; }
        .alert { padding: 10px; border-radius: 10px; margin-bottom: 15px; font-size: 13px; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .back-link { display: block; text-align: center; margin-top: 15px; font-size: 14px; color: #C58F59; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="card">
        <h1 class="title">Lupa Password</h1>
        <p class="desc" style="color: #C58F59;">Masukkan email admin Anda untuk menerima link reset.</p>

        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.password.email') }}">
            @csrf
            <div class="form-group">
                <label>Email Admin</label>
                <input type="email" name="email" placeholder="admin@gmail.com" required>
            </div>
            <button type="submit" class="btn">Kirim Link Reset</button>
        </form>
        <a href="{{ route('admin.login') }}" class="back-link">Kembali ke Login</a>
    </div>
</body>
</html>