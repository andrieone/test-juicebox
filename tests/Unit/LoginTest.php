<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * Test login user.
     */
    public function test_login_user()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'test_user@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure
        (
            [
                'data' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                ],
                'token',
            ]
        );

        $response->assertJsonFragment
        (
            [
                'email' => 'test_user@example.com',
            ]
        );

        $response->assertJsonMissingValidationErrors();

        $response->assertJsonValidationErrors(['email', 'password']);

        $response->assertJsonMissing(['message']);

        $response->assertJson(['status' => 'success']);

    }
}
