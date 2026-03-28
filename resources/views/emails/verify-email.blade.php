@component('mail::message')
# Halo, {{ $userName }}!

Terima kasih telah mendaftar di **HDS Dental Clinic**.

Klik tombol di bawah untuk memverifikasi email kamu:

@component('mail::button', ['url' => $verificationUrl, 'color' => 'blue'])
Verifikasi Email
@endcomponent

Link ini berlaku selama **24 jam**.

Jika kamu tidak merasa mendaftar, abaikan email ini.

Salam,
**HDS Dental Clinic**
@endcomponent