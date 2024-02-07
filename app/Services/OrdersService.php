<?php

namespace App\Services;

use App\Contracts\OrdersServiceContract;
use App\Http\Resources\OrdersCollection;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductsInOrders;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrdersService implements OrdersServiceContract
{
    public function getPage(User $user, int $page): OrdersCollection
    {
        if ($user->hasRole('admin')) {
            $orders = Order::select('id', 'address', 'created_at')
                ->orderBy('id', 'DESC')
                ->paginate(30, ['*'], 'page', $page);
            foreach ($orders as $key => $order) {
                $orders[$key]['products'] = ProductsInOrders::join('products', 'products_in_orders.product_id', '=', 'products.id')
                    ->where('products_in_orders.order_id', $order['id'])
                    ->select('products.name', 'products.price', 'products_in_orders.count', 'products_in_orders.product_id')
                    ->get();
            }
        } 
        else {
            $orders = Order::where('user_id', $user->id)
                ->select('id', 'address', 'created_at')
                ->orderBy('id', 'DESC')
                ->paginate(30, ['*'], 'page', $page);
            foreach($orders as $key => $order) {
                $orders[$key]['products'] = DB::table('products_in_orders')
                    ->join('orders', 'products_in_orders.order_id', '=', 'orders.id')
                    ->join('products', 'products_in_orders.product_id', '=', 'products.id')
                    ->where('products_in_orders.order_id', $order['id'])
                    ->select('products.id as id', 'products.name as name', 'products.price as price', 'products_in_orders.count')
                    ->get();
            }
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
                if (Product::where('id', '=', $product['id'])->first()) {
                    ProductsInOrders::create([
                        'order_id' => $order->id,
                        'product_id' => $product['id'],
                        'count' => $product['count']
                    ]);
                }
            }
            return $order->id ? true : false;
        }, 2);
    }

    public function monthlyAmountByDay(int $year, int $month): array
    {
        $productsInOrders = [];
        $stashProducts = [];
        $data = [];

        $ordersIds = Order::whereBetween('created_at', [$year.'-'.$month.'-01 00:00:00', $year.'-'.$month.'-31 00:00:00'])
            ->orderBy('created_at', 'DESC')
            ->pluck('id');

        foreach($ordersIds as $orderId) {
            $productsInOrders = ProductsInOrders::join('products', 'products.id', '=', 'products_in_orders.product_id')
                ->where('products_in_orders.order_id', '=', $orderId)
                ->select('products.id', 'products.name', 'products_in_orders.count')
                ->get();
            foreach($productsInOrders as $product) {
                if (isset($stashProducts[$product->id])) $stashProducts[$product->id]['count'] + $product->count;
                else $stashProducts[$product->id]['count'] = $product->count;
                $stashProducts[$product->id]['id'] = $product->id;
                $stashProducts[$product->id]['name'] = $product->name;
            }
        }
        uasort($stashProducts, function($a, $b) {
            return $b['count'] - $a['count'];
        });
        foreach($stashProducts as $item) {
            $data[] = $item;
        }

        return $data;
    }
}