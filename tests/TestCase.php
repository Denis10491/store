<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected User $user;

    public function login(): void
    {
        $this->user = User::factory()->createOne();
        $this->actingAs($this->user, 'sanctum');
    }

    public function __construct(string $name)
    {
        parent::__construct($name);

        $this->withHeader('Accept', 'application/json');
    }
}
