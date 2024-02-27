<?php

namespace App\Contracts;

use App\Http\Requests\OrdersStatisticsMonthlyAmountByDayRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use Illuminate\Support\Collection;

interface OrderServiceContract
{
    public function index(): Collection;

    public function store(StoreOrderRequest $request): Order;

    public function monthlyAmountByDay(OrdersStatisticsMonthlyAmountByDayRequest $request): Collection;
}
