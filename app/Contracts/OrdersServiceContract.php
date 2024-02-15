<?php

namespace App\Contracts;

use App\Http\Resources\OrdersCollection;
use App\Models\User;
use Illuminate\Support\Collection;

interface OrdersServiceContract
{
    public function getPage(User $user, int $page): OrdersCollection;
    public function create(User $user, array $data): bool;
    public function monthlyAmountByDay(int $year, int $month): Collection;
}