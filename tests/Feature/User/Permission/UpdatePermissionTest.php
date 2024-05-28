<?php

namespace Tests\Feature\User\Permission;

use App\Enums\Role;
use App\Models\Permission;
use Tests\TestCase;

class UpdatePermissionTest extends TestCase
{
    protected Permission $permission;

    public function setUp(): void
    {
        parent::setUp();

        $this->permission = Permission::factory()->createOne();
    }

    public function test_error_auth(): void
    {
        $response = $this->put(route('permissions.update', $this->permission));

        $response->assertUnauthorized();
    }

    public function test_error_forbidden(): void
    {
        $this->login(Role::User);

        $response = $this->put(route('permissions.update', $this->permission));

        $response->assertForbidden();
    }

    public function test_error_validation(): void
    {
        $this->login(Role::Admin);

        $data = [
            'name' => null
        ];

        $response = $this->put(route('permissions.update', $this->permission), $data);

        $response->assertUnprocessable();
    }

    public function test_error_notfound(): void
    {
        $this->login(Role::Admin);

        $data = [
            'name' => null
        ];

        $response = $this->put(route('permissions.update', 99999), $data);

        $response->assertNotFound();
    }

    public function test_success(): void
    {
        $this->login(Role::Admin);

        $data = [
            'name' => fake()->word
        ];

        $response = $this->put(route('permissions.update', $this->permission), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'name'
        ]);
        $response->assertJson([
            'name' => $data['name']
        ]);
    }
}
