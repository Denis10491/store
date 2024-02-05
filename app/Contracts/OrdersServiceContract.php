<?php

namespace App\Contracts;

use App\Http\Resources\OrdersCollection;
use App\Models\User;

interface OrdersServiceContract
{
    public function getPage(User $user, string $page): OrdersCollection;
    public function create(User $user, array $data): bool;
}