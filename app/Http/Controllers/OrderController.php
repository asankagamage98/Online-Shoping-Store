<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function addOrder(Request $request){

        Log::info($request->all());

        $request->validate([
            'orderType'=>"required|string",
            'date' =>'required|date',
            'time' =>'required|string',
            'description'=>'required|string',
        ]);
        return Order::create($request->all());

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

}
