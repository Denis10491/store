<?php

namespace Tests\Feature\User\Role;

use App\Enums\Role as EnumsRole;
use App\Models\Role;
use Tests\TestCase;

class GetRolesTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Role::factory(3)->create();
    }

    public function test_error_auth(): void
    {
        $response = $this->get(route('roles.index'));

        $response->assertUnauthorized();
    }

    public function test_error_forbidden(): void
    {
        $this->login(EnumsRole::User);

        $response = $this->get(route('roles.index'));

        $response->assertForbidden();
    }

    public function test_success(): void
    {
        $this->login(EnumsRole::Admin);

        $response = $this->get(route('roles.index'));

        $response->assertOk();
    }
}
