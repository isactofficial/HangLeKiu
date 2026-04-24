<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Kustomisasi Email Reset Password
        ResetPassword::toMailUsing(function (object $notifiable, string $token) {

            // Tentukan route berdasarkan role user
            $roleCode = $notifiable->role?->code;

            if ($roleCode === 'ADM') {
                $url = route('admin.password.reset', [
                    'token' => $token,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ]);
            } elseif ($roleCode === 'DCT') {
                $url = route('doctor.password.reset', [
                    'token' => $token,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ]);
            } else {
                $url = route('password.reset', [
                    'token' => $token,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ]);
            }

            return (new MailMessage)
                ->subject('Permintaan Reset Password - HangLeKiu Dental')
                ->view('emails.custom-reset-password', [
                    'url'  => $url,
                    'name' => $notifiable->name, 
                    'roleCode' => $roleCode,
                ]);
        });

        // 2. Share clinic profile globally
        if (!app()->runningInConsole()) {
            try {
                \Illuminate\Support\Facades\View::share('clinicProfile', \App\Models\ClinicProfile::first());
            } catch (\Exception $e) {
                // Ignore if table doesn't exist yet
            }
        }
    }
}