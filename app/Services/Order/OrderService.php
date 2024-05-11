<?php

namespace App\Services\Order;

use App\Contracts\OrderServiceContract;
use App\Enums\OrderStatus;
use App\Http\Requests\Order\OrderStatisticsMonthlyAmountByDayRequest;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class OrderService implements OrderServiceContract
{
    protected Order $order;

    public function index(): Collection
    {
        if (Gate::denies('read-all-orders')) {
            return Order::query()->where('user_id', auth()->user()->id)->latest()->get();
        }
        return Order::query()->latest()->get();
    }

    public function store(StoreOrderRequest $request): Order
    {
        return DB::transaction(static function () use ($request): Order {
            $order = auth()->user()->orders()->create([
                'address' => $request->str('address')
            ]);

            foreach ($request->input('products') as $productInRequest) {
                $product = Product::query()->find($productInRequest['id']);
                if ($product) {
                    $order->products()->attach($product, ['count' => $productInRequest['count']]);
                }
            }

            return $order;
        });
    }

    public function update(UpdateOrderRequest $request): Order
    {
        if ($request->isMethod('put')) {
            $this->order->fill($request->only('address', 'status'));
        }

        if ($request->isMethod('patch')) {
            if ($request->has('address')) {
                $this->order->address = $request->str('address');
            }

            if ($request->has('status')) {
                $this->order->status = OrderStatus::tryFrom($request->str('status'));
            }

            $this->order->save();
        }

        return $this->order;
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

    public function setOrder(Order $order): static
    {
        $this->order = $order;

        return $this;
    }
}
