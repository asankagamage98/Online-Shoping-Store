<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function addOrder(Request $request){

        Log::info($request->all());

        $request->validate([
            'orderItem'=>"required|string",
            'product_id' => 'required|integer|exists:products,id',
            'quantity'=>'required|integer',
            'orderType'=>"required|string",
            'date' =>'required|date',
            'time' =>'required|string',
            'description'=>'required|string',


        ]);
        $order = Order::create($request->all());

        $productId = $request->input('product_id');
        $product = Product::find($productId);

        if ($product) {
            $order->products()->attach($product, ['quantity' => $request->input('quantity')]);
            return $order;
        } else {
            return response()->json(['error' => 'No product with the specified product_id in the database'], 404);
        }


    }

    public function getAllOrder(){

        return Order::all();

    }

    public function getOrderById(string $id){

        return Order::find($id);

    }

    public function updateOrder(Request $request ,string $id){

        $order = Order::find($id);
        $order ->update($request->all());
        return $order;

    }
     /**
     * Search data from storage.
     */
    public function search(string $orderItem)
    {
        return Order::where('orderItem', 'like', '%' . $orderItem . '%')->get();
    }


}
