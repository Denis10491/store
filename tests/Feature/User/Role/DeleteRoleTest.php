<?php

namespace Tests\Feature\User\Role;

use App\Enums\Role as EnumsRole;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteRoleTest extends TestCase
{
    protected Role $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->role = Role::factory()->createOne();
    }

    public function test_error_auth(): void
    {
        $response = $this->delete(route('roles.destroy', $this->role));

        $response->assertUnauthorized();
    }

    public function test_error_forbidden(): void
    {
        $this->login(EnumsRole::User);

        $response = $this->delete(route('roles.destroy', $this->role));

        $response->assertForbidden();
    }

    public function test_success(): void
    {
        $this->login(EnumsRole::Admin);

        $response = $this->delete(route('roles.destroy', $this->role));

        $response->assertOk();
    }
}
