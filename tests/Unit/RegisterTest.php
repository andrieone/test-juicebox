<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class RegisterTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * Test register user.
     */
    public function test_register_user()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test_user@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(201);

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
                'name' => 'Test User',
                'email' => 'test_user@example.com',
            ]
        );
    }
}
