<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{

    protected $email = 'example@example.com';

    protected $password = 'example';

    protected function setUp(): void
    {
        parent::setUp();

        User::factory()->makeOne([
            'email' => $this->email,
            'password' => $this->password
        ]);
    }

    public function test_success(): void
    {
        $response = $this->post(route('auth.login', [
            'email' => $this->email,
            'password' => $this->password
        ]));

        $response->assertOk();
        $response->assertJsonStructure([
            'token'
        ]);
    }
}
