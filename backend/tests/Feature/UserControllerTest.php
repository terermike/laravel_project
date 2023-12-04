<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_can_create_a_user()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
        ];

        $response = $this->json('POST', '/api/auth/register', $userData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'remember_token',
            ]);

        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'email' => $userData['email'],
        ]);
    }

    /** @test */
    public function it_cannot_create_a_user_with_invalid_data()
    {
        $response = $this->json('POST', '/api/auth/register', []);

        $response->assertStatus(401)
            ->assertJsonStructure([
                'status',
                'message',
                'errors',
            ]);
    }

    /** @test */
    public function it_can_login_a_user()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $loginData = [
            'email' => $user->email,
            'password' => 'password123',
        ];

        $response = $this->json('POST', '/api/auth/login', $loginData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'remember_token',
            ]);
    }

    /** @test */
    public function it_cannot_login_a_user_with_invalid_credentials()
    {
        $loginData = [
            'email' => $this->faker->safeEmail,
            'password' => 'invalidpassword',
        ];

        $response = $this->json('POST', '/api/auth/login', $loginData);

        $response->assertStatus(401)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    /** @test */
    public function it_returns_authenticated_user()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->json('GET', 'api/user');

        $response->assertStatus(200);

        $response->assertJson([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    /** @test */
    public function it_requires_authentication()
    {
        $response = $this->json('Get', 'api/user');

        $response->assertStatus(401);
        
    }
}
