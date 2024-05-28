<?php

namespace Tests\Feature\User\Permission;

use App\Enums\Role;
use App\Models\Permission;
use Tests\TestCase;

class DeletePermissionTest extends TestCase
{
    protected Permission $permission;

    public function setUp(): void
    {
        parent::setUp();

        $this->permission = Permission::factory()->createOne();
    }

    public function test_error_auth(): void
    {
        $response = $this->delete(route('permissions.destroy', $this->permission));

        $response->assertUnauthorized();
    }

    public function test_error_forbidden(): void
    {
        $this->login(Role::User);

        $response = $this->delete(route('permissions.destroy', $this->permission));

        $response->assertForbidden();
    }

    public function test_error_notfound(): void
    {
        $this->login(Role::Admin);

        $response = $this->delete(route('permissions.destroy', 99999));

        $response->assertNotFound();
    }

    public function test_success(): void
    {
        $this->login(Role::Admin);

        $response = $this->delete(route('permissions.destroy', $this->permission));

        $response->assertOk();
    }
}
