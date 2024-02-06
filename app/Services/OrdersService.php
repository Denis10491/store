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

    public function getPage(User $user, string $page): OrdersCollection
    {
        if ($user->hasRole('admin')) {
            $orders = Order::select('id', 'address', 'created_at')
                ->orderBy('id', 'DESC')
                ->paginate(30, ['*'], 'page', (int) $page);
            foreach ($orders as $key => $order) {
                $orders[$key]["products"] = ProductsInOrders::join('products', 'products_in_orders.product_id', '=', 'products.id')
                    ->where('products_in_orders.order_id', $order["id"])
                    ->select('products.name', 'products.price', 'products_in_orders.count', 'products_in_orders.product_id')
                    ->get();
            }
        } 
        else {
            $orders = Order::where('user_id', $user->id)
                ->select('id', 'address', 'created_at')
                ->orderBy('id', 'DESC')
                ->paginate(30, ['*'], 'page', (int) $page);
            foreach($orders as $key => $order) {
                $orders[$key]["products"] = DB::table('products_in_orders')
                    ->join('orders', 'products_in_orders.order_id', '=', 'orders.id')
                    ->join('products', 'products_in_orders.product_id', '=', 'products.id')
                    ->where('products_in_orders.order_id', $order["id"])
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
            foreach(json_decode($data["products"], true) as $product) {
                if (Product::where('id', '=', $product["id"])->first()) ProductsInOrders::create([
                    'order_id' => $order->id,
                    'product_id' => $product["id"],
                    'count' => $product["count"]
                ]);
            }
            return $order->id ? true : false;
        }, 2);
    }
}