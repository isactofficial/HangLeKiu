<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil — Hanglekiu Dental</title>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Instrument Sans',sans-serif; min-height:100vh; display:flex; align-items:center; justify-content:center; background:url('{{ asset("images/bg-clinic.png") }}') no-repeat center center fixed; background-size:cover; padding:20px; }
        .card { background:white; border-radius:20px; box-shadow:0 8px 40px rgba(88,44,12,.15); padding:52px 44px; text-align:center; max-width:440px; width:100%; }
        .icon { font-size:64px; margin-bottom:20px; }
        h2 { font-size:22px; font-weight:700; color:#582C0C; margin-bottom:10px; }
        p { font-size:14px; color:#6B513E; line-height:1.7; margin-bottom:28px; }
        .btn { display:inline-block; padding:13px 28px; background:#582C0C; color:white; border-radius:10px; font-size:14px; font-weight:700; text-decoration:none; font-family:'Instrument Sans',sans-serif; transition:all .3s; }
        .btn:hover { background:#3d1e08; box-shadow:0 6px 20px rgba(88,44,12,.3); transform:translateY(-1px); }
    </style>
</head>
<body>
<div class="card">
    <div class="icon">✅</div>
    <h2>Pendaftaran Berhasil!</h2>
    <p>Terima kasih telah mendaftar. Kami akan menghubungi kamu via WhatsApp untuk konfirmasi jadwal dalam 1×24 jam.</p>
    <a href="{{ route('appointments.create') }}" class="btn">Daftar Lagi</a>
</div>
</body>
</html>
