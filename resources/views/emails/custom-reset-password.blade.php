<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - HangLeKiu</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 0; }
        .email-wrapper { width: 100%; padding: 40px 0; background-color: #f3f4f6; }
        .email-card { max-width: 500px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { text-align: center; padding: 30px 20px 20px; }
        .header img { height: 70px; border-radius: 15px;}
        .content { padding: 0 30px 30px; color: #4b5563; font-size: 15px; line-height: 1.6; }
        .content h2 { color: #582C0C; font-size: 20px; margin-top: 0; }
        .btn-container { text-align: center; margin: 35px 0; }
        .btn { background-color: #582C0C; color: #ffffff; padding: 14px 28px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block; }
        .note { font-size: 13px; color: #9ca3af; text-align: center; margin-top: 20px; }
        .footer { background-color: #f9fafb; text-align: center; padding: 20px; font-size: 13px; color: #9ca3af; border-top: 1px solid #f3f4f6; }
        .content p { color: #C58F59; }
        .content strong { color: #582C0C; }
        .footer p { color: #C58F59; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-card">
            
            <div class="header">
                <img src="{{ asset('images/logo-hds.png') }}" alt="Logo HangLeKiu">
            </div>

            <div class="content">
                <h2>Halo, {{ $roleCode === 'ADM' ? 'Admin' : ($roleCode === 'DCT' ? 'Dr.' : '') }} {{ $name }}</h2>
                <p>Kami menerima permintaan untuk mereset password akun Anda di sistem <strong>HangLeKiu Dental Clinic</strong>.</p>
                <p>Silakan klik tombol di bawah ini untuk membuat password baru Anda:</p>
                
                <div class="btn-container">
                    <a href="{{ $url }}" class="btn" style="color: #ffffff;">Reset Password</a>
                </div>

                <p>Link reset password ini hanya berlaku selama <strong>60 menit</strong> ke depan.</p>
                <p>Jika Anda tidak merasa meminta reset password, Anda dapat mengabaikan email ini dan akun Anda akan tetap aman.</p>
            </div>

            <div class="footer">
                <p >&copy; {{ date('Y') }} HangLeKiu Dental Clinic. Semua hak cipta dilindungi.</p>
            </div>

        </div>
    </div>
</body>
</html>