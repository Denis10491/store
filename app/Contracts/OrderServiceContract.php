<?php

namespace App\Contracts;

use App\Http\Requests\Order\OrderStatisticsMonthlyAmountByDayRequest;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Order;
use Illuminate\Support\Collection;

interface OrderServiceContract
{
    public function index(): Collection;

    public function store(StoreOrderRequest $request): Order;

    public function monthlyAmountByDay(OrderStatisticsMonthlyAmountByDayRequest $request): Collection;
}
