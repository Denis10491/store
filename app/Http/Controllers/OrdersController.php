<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductsInOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::select('id', 'address', 'created_at')->orderBy('created_at', 'DESC')->get();
        foreach ($orders as $key => $order) {
            $orders[$key]["products"] = ProductsInOrders::join('products', 'products_in_orders.product_id', '=', 'products.id')
                ->where('products_in_orders.order_id', $order["id"])
                ->select('products.name', 'products.price', 'products_in_orders.count', 'products_in_orders.product_id')
                ->get();
        }

        return response([
            'status' => true, 
            'data' => $orders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'products' => ['required'],
            'address' => ['required', 'string']
        ]);
        $user = Auth::user();

        $order = Order::create([
            'user_id' => $user->id,
            'address' => $credentials['address']
        ]);
        foreach(json_decode($credentials["products"], true) as $product) {
            if (Product::where('id', '=', $product["id"])->first()) ProductsInOrders::create([
                'order_id' => $order->id,
                'product_id' => $product["id"],
                'count' => $product["count"]
            ]);
        }

        return response(['status' => true]);
    }

    public function show()
    {
        if (!Auth::check()) return response(['status' => false, 'Unathorizated' => false], 401);

        $user = Auth::user();
        $orders = Order::query()->where('user_id', $user->id)->select('id', 'address', 'created_at')->latest()->get();
        foreach($orders as $key => $order) {
            $orders[$key]["products"] = DB::table('products_in_orders')
                ->join('orders', 'products_in_orders.order_id', '=', 'orders.id')
                ->join('products', 'products_in_orders.product_id', '=', 'products.id')
                ->where('products_in_orders.order_id', $order["id"])
                ->select('products.id as id', 'products.name as name', 'products.price as price', 'products_in_orders.count')
                ->get();
        }
        
        return response(['status' => true, 'data' => $orders], 200);
    }
}
