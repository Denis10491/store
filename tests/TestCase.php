<?php

namespace Tests;

use App\Enums\Role as RoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected User $user;

    public function login(RoleEnum $role = RoleEnum::User): void
    {
        $this->user = User::factory()->createOne([
            'role_id' => Role::where('name', $role)->first('id')->id
        ]);
        $this->actingAs($this->user, 'sanctum');
    }

    public function __construct(string $name)
    {
        parent::__construct($name);

        $this->withHeader('Accept', 'application/json');
    }
}
