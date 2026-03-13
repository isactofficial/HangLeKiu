<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil — Hanglekiu Dental</title>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/user/components/success.css') }}">
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
