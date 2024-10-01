<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test get user.
     */
    public function test_get_user()
    {
        $response = $this->getJson('/api/users/1');

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
            ]
        );

        $response->assertJsonFragment
            (
            [
                'id' => 1,
            ]
        );

        $response->assertJsonMissingValidationErrors();

        $response->assertJsonValidationErrors(['id']);

        $response->assertJsonMissing(['message']);

        $response->assertJson(['status' => 'success']);

    }
}
