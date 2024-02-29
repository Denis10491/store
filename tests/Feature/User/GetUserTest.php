<?php

namespace Tests\Feature\User;

use Tests\TestCase;

class GetUserTest extends TestCase
{
    public function test_error_auth(): void
    {
        $response = $this->get(route('users.show'));

        $response->assertUnauthorized();
        $response->assertJsonStructure([
            'error'
        ]);
        $response->assertJson([
            'error' => 'Unauthenticated.'
        ]);
    }

    public function test_success(): void
    {
        $this->login();

        $response = $this->get(route('users.show'));

        $response->assertOk();
        $response->assertJsonStructure([
            'id', 'name', 'email'
        ]);
    }
}
