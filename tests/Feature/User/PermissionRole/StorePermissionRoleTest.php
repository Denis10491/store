<?php

namespace Tests\Feature\User\PermissionRole;

use App\Enums\Role as EnumsRole;
use App\Models\Permission;
use App\Models\Role;
use Tests\TestCase;

class StorePermissionRoleTest extends TestCase
{
    protected Role $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->role = Role::factory()->createOne();
    }

    public function test_error_auth(): void
    {
        $response = $this->post(route('roles.permissions.store', $this->role));

        $response->assertUnauthorized();
    }

    public function test_error_forbidden(): void
    {
        $this->login(EnumsRole::User);

        $response = $this->post(route('roles.permissions.store', $this->role));

        $response->assertForbidden();
    }

    public function test_error_validation(): void
    {
        $this->login(EnumsRole::Admin);

        $data = [
            'permission_id' => 0
        ];

        $response = $this->post(route('roles.permissions.store', $this->role), $data);

        $response->assertUnprocessable();
    }

    public function test_success(): void
    {
        $this->login(EnumsRole::Admin);

        $data = [
            'permission_id' => Permission::factory()->createOne()->id
        ];

        $response = $this->post(route('roles.permissions.store', $this->role), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'name',
            'permissions' => [
                '*' => [
                    'id',
                    'name',
                ]
            ],
        ]);
    }
}
