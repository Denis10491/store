<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class RegisterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_error_validation(): void
    {
        $data = [
            'name' => null,
            'email' => 'example',
            'password' => null
        ];

        $response = $this->post(route('auth.register', $data));

        $response->assertUnprocessable();
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name',
                'email',
                'password'
            ]
        ]);
    }

    public function test_success(): void
    {
        $data = [
            'name' => fake()->name,
            'email' => fake()->email,
            'password' => fake()->password
        ];

        $response = $this->post(route('auth.register'), $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'id', 'name', 'email'
        ]);
        $response->assertJson([
            'name' => $data['name'],
            'email' => $data['email']
        ]);
    }
}
