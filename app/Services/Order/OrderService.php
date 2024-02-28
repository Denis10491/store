<?php

namespace App\Services\Order;

use App\Contracts\OrderServiceContract;
use App\Http\Requests\Order\OrderStatisticsMonthlyAmountByDayRequest;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrderService implements OrderServiceContract
{
    public function index(): Collection
    {
        if (auth()->user()->isUser()) {
            return Order::query()->where('user_id', auth()->user()->id)->latest()->get();
        }
        return Order::query()->latest()->get();
    }

    public function store(StoreOrderRequest $request): Order
    {
        return DB::transaction(static function () use ($request): Order {
            $order = Order::query()->create([
                'user_id' => auth()->user()->id,
                'address' => $request->str('address')
            ]);

            foreach ($request->input('products') as $productInRequest) {
                $product = Product::query()->find($productInRequest['id']);
                if ($product) {
                    $order->products()->attach($product);
                }
            }

            return $order;
        });
    }

    public function monthlyAmountByDay(OrderStatisticsMonthlyAmountByDayRequest $request): Collection
    {
        $date = $request->str('year').'-'.$request->str('month');
        return Order::query()->whereBetween('created_at', [
            Carbon::parse($date)->startOfMonth(),
            Carbon::parse($date)->endOfMonth()
        ])->get()
            ->groupBy(function ($data) {
                return Carbon::parse($data->created_at)->format('d');
            })->map(function ($orders) {
                return $orders->count();
            });
    }
}
