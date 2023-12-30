<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>'required|string',
            'code' =>'required|string',
            'price'=>'required|string',
            'count'=>'required|integer',
            'manufacture_date' =>'required|date',
            'expire_date' => 'required|date|after:date.manufacture_date',
            'description'=>'required|string',
        ]);
        return Product::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Product::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        $product ->update($request->all());
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::destroy($id);
        return Product::all();
    }
     /**
     * search data from storage.
     */
    public function search(string $name)
    {
        return Product::where('name', 'like', '%'.$name.'%')->get();
    }

}
