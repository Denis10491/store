<?php

namespace Tests\Feature\User\Role;

use App\Enums\Role as EnumsRole;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateRoleTest extends TestCase
{
    protected Role $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->role = Role::factory()->createOne();
    }

    public function test_error_auth(): void
    {
        $response = $this->patch(route('roles.update', $this->role));

        $response->assertUnauthorized();
    }

    public function test_error_forbidden(): void
    {
        $this->login(EnumsRole::User);

        $response = $this->patch(route('roles.update', $this->role));

        $response->assertForbidden();
    }

    public function test_error_validation(): void
    {
        $this->login(EnumsRole::Admin);

        $data = [
            'name' => ''
        ];

        $response = $this->patch(route('roles.update', $this->role), $data);

        $response->assertUnprocessable();
    }

    public function test_success(): void
    {
        $this->login(EnumsRole::Admin);

        $data = [
            'name' => fake()->word
        ];

        $response = $this->patch(route('roles.update', $this->role), $data);

        $response->assertOk();
    }
}
