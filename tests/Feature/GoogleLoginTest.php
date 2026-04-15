<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Tests\TestCase;
use Mockery;

class GoogleLoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test redirect to google.
     */
    public function test_redirect_to_google(): void
    {
        $response = $this->get(route('google.login'));
        $response->assertRedirect();
        $this->assertStringContainsString('accounts.google.com', $response->getTargetUrl());
    }

    /**
     * Test handle google callback with new user.
     */
    public function test_handle_google_callback_creates_new_user(): void
    {
        // Mock Socialite
        $abstractUser = Mockery::mock('Laravel\Socialite\Two\User');
        $abstractUser->shouldReceive('getId')->andReturn('google-id-123');
        $abstractUser->shouldReceive('getEmail')->andReturn('newuser@example.com');
        $abstractUser->shouldReceive('getName')->andReturn('Google User');
        $abstractUser->shouldReceive('getAvatar')->andReturn('https://avatar.com/123');

        Socialite::shouldReceive('driver')->with('google')->andReturn(Mockery::mock('Laravel\Socialite\Two\GoogleProvider', [
            'user' => $abstractUser
        ]));

        $response = $this->get('/auth/google/callback');
        if ($response->status() !== 302) {
            dd($response->getContent(), session()->all());
        }
        $response->assertRedirect('/user/dashboard');
        
        $this->assertDatabaseHas('user', [
            'email' => 'newuser@example.com',
            'google_id' => 'google-id-123'
        ]);

        $user = User::where('email', 'newuser@example.com')->first();
        $this->assertNotNull($user->patient);
        $this->assertEquals('Google User', $user->name);
    }
}
