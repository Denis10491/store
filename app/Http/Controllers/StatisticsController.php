<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductsInOrders;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{

    public function countOfOrdersByMonth(Request $request)
    {
        $credentials = $request->validate([
            'year' => ['required'],
            'month' => ['required']
        ]);
        $dateStart = $credentials["year"].'-'.$credentials["month"].'-01 00:00:00';
        $dateEnd = $credentials["year"].'-'.$credentials["month"].'-31 00:00:00';
        $data = [];

        $data = Order::whereBetween('created_at', [$dateStart, $dateEnd])
            ->orderBy('created_at')
            ->get()
            ->groupBy(function($data) {
                return Carbon::parse($data->created_at)->format('d');
            });

        return response([
            'status' => true,
            'year' => $credentials["year"],
            'month' => $credentials["month"],
            'data' => $data
        ]);
    }

    public function bestSellingByMonth(Request $request)
    {
        $credentials = $request->validate([
            'year' => ['required'],
            'month' => ['required']
        ]);

        $ordersIds = Order::whereBetween('created_at', [
            $credentials["year"].'-'.$credentials["month"].'-01 00:00:00',
            $credentials["year"].'-'.$credentials["month"].'-31 00:00:00'
        ])->orderBy('created_at', 'DESC')->pluck('id');
        
        $productsInOrders = []; $stashProducts = []; $data = [];
        foreach($ordersIds as $orderId) {
            $productsInOrders = ProductsInOrders::join('products', 'products.id', '=', 'products_in_orders.product_id')
                ->where('products_in_orders.order_id', '=', $orderId)
                ->select('products.id', 'products.name', 'products_in_orders.count')
                ->get();
            foreach($productsInOrders as $product) {
                if (isset($stashProducts[$product->id])) $stashProducts[$product->id]["count"] + $product->count;
                else $stashProducts[$product->id]["count"] = $product->count;
                $stashProducts[$product->id]["id"] = $product->id;
                $stashProducts[$product->id]["name"] = $product->name;
            }
        }
        uasort($stashProducts, function($a, $b) {
            return $b['count'] - $a['count'];
        });
        foreach($stashProducts as $item) {
            $data[] = $item;
        }

        return response([
            'status' => true,
            'year' => $credentials["year"],
            'month' => $credentials["month"],
            'data' => $data
        ]);
    }
}
