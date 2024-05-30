<?php

namespace Tests\Feature\User\PermissionRole;

use App\Enums\Role as EnumsRole;
use App\Models\Permission;
use App\Models\Role;
use Tests\TestCase;

class DeletePermissionRoleTest extends TestCase
{
    protected Permission $permission;

    protected Role $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->permission = Permission::factory()->createOne();

        $this->role = Role::factory()->createOne();
    }

    public function test_error_auth(): void
    {
        $response = $this->delete(route('roles.permissions.destroy', [$this->role, $this->permission]));

        $response->assertUnauthorized();
    }

    public function test_error_forbidden(): void
    {
        $this->login(EnumsRole::User);

        $response = $this->delete(route('roles.permissions.destroy', [$this->role, $this->permission]));

        $response->assertForbidden();
    }

    public function test_error_notfound(): void
    {
        $this->login(EnumsRole::Admin);

        $response = $this->delete(route('roles.permissions.destroy', [$this->role, 0]));

        $response->assertNotFound();
    }

    public function test_success(): void
    {
        $this->login(EnumsRole::Admin);

        $response = $this->delete(route('roles.permissions.destroy', [$this->role, $this->permission]));

        $response->assertOk();
    }
}