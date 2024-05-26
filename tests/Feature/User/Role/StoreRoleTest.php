<?php

namespace Tests\Feature\User\Role;

use App\Enums\Role;
use Tests\TestCase;

class StoreRoleTest extends TestCase
{
    public function test_error_auth(): void
    {
        $response = $this->post(route('roles.store'));

        $response->assertUnauthorized();
    }

    public function test_error_forbidden(): void
    {
        $this->login(Role::User);

        $response = $this->post(route('roles.store'));

        $response->assertForbidden();
    }

    public function test_error_validation(): void
    {

        $this->login(Role::Admin);

        $data = [
            'name' => ''
        ];

        $response = $this->post(route('roles.store'), $data);

        $response->assertUnprocessable();
    }

    public function test_success(): void
    {
        $this->login(Role::Admin);

        $data = [
            'name' => fake()->word
        ];

        $response = $this->post(route('roles.store'), $data);

        $response->assertCreated();
    }
}
