<?php

namespace Tests\Feature\User\Role;

use App\Enums\Role as EnumsRole;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetRoleTest extends TestCase
{
    protected Role $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->role = Role::factory()->createOne();
    }

    public function test_error_auth(): void
    {
        $response = $this->get(route('roles.show', $this->role));

        $response->assertUnauthorized();
    }

    public function test_error_forbidden(): void
    {
        $this->login(EnumsRole::User);

        $response = $this->get(route('roles.show', $this->role));

        $response->assertForbidden();
    }

    public function test_success(): void
    {
        $this->login(EnumsRole::Admin);

        $response = $this->get(route('roles.show', $this->role));

        $response->assertOk();
    }
}
