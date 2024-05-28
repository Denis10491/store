<?php

namespace Tests\Feature\User\Permission;

use App\Enums\Role;
use Tests\TestCase;

class StorePermissionTest extends TestCase
{
    public function test_error_auth(): void
    {
        $response = $this->post(route('permissions.store'));

        $response->assertUnauthorized();
    }

    public function test_error_forbidden(): void
    {
        $this->login(Role::User);

        $response = $this->post(route('permissions.store'));

        $response->assertForbidden();
    }

    public function test_error_validation(): void
    {
        $this->login(Role::Admin);

        $data = [
            'name' => null
        ];

        $response = $this->post(route('permissions.store'), $data);

        $response->assertUnprocessable();
    }

    public function test_success(): void
    {
        $this->login(Role::Admin);

        $data = [
            'name' => fake()->word
        ];

        $response = $this->post(route('permissions.store'), $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'name'
        ]);
        $response->assertJson([
            'name' => $data['name']
        ]);
    }
}
