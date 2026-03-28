<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dokter - Hanglekiu Dental Clinic</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Instrument Sans', sans-serif;
            background: linear-gradient(135deg, #fdf7f0 0%, #f4e1cf 100%);
            color: #582C0C;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            width: 100%;
            max-width: 680px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 12px 40px rgba(88, 44, 12, 0.12);
            padding: 28px;
        }

        h1 {
            margin: 0 0 10px;
            font-size: 28px;
        }

        p {
            margin: 0 0 18px;
            color: #7a4a24;
        }

        .meta {
            background: #f9efe4;
            border: 1px solid #edd7c2;
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 16px;
        }

        .meta strong {
            color: #582C0C;
        }

        form {
            margin-top: 10px;
        }

        button {
            border: none;
            border-radius: 10px;
            background: #582C0C;
            color: #fff;
            padding: 10px 16px;
            font-weight: 600;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Dashboard Dokter</h1>
        <p>Berhasil login.</p>

        <div class="meta">
            <div><strong>Nama:</strong> {{ auth()->user()->name }}</div>
            <div><strong>Email:</strong> {{ auth()->user()->email }}</div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</body>
</html>
