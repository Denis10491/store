<?php

namespace App\Services;

use App\Contracts\OrdersServiceContract;
use App\Http\Resources\OrdersCollection;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrdersService implements OrdersServiceContract
{
    public function getPage(User $user, int $page): OrdersCollection
    {
        if ($user->hasRole('admin')) {
            $orders = Order::latest()->paginate(30, ['id', 'address', 'created_at'], 'page', $page);
        }
        else {
            $orders = Order::where('user_id', $user->id)
                ->latest()
                ->paginate(30, ['id', 'address', 'created_at'], 'page', $page);
        }
        foreach($orders as $key => $order) {
            $orders[$key]['products'] = OrderProduct::with('product')->where('order_id', $order['id']);
        }
        return new OrdersCollection($orders);
    }

    public function create(User $user, array $data): bool 
    {
        return DB::transaction(function() use ($data, $user): bool {
            $order = Order::create([
                'user_id' => $user->id,
                'address' => $data['address']
            ]);
            foreach(json_decode($data['products'], true) as $product) {
                if (Product::where('id', $product['id'])->first()) {
                    OrderProduct::create([
                        'order_id' => $order['id'],
                        'product_id' => $product['id'],
                        'count' => $product['count']
                    ]);
                }
            }
            return $order->id ? true : false;
        }, 2);
    }

    public function monthlyAmountByDay(int $year, int $month): Collection
    {
        return Order::whereBetween('created_at', [
                $year.'-'.$month.'-01 00:00:00', $year.'-'.$month.'-31 00:00:00'
            ])
            ->get()
            ->groupBy(function($data) {
                return Carbon::parse($data->created_at)->format('d');
            })
            ->map(function($orders) {
                return $orders->count();
            });
    }
}