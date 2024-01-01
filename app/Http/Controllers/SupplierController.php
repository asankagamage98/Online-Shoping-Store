<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
   public function addSupplier(Request $request){
    $validator = Validator::make($request->all(),[
        'name' => 'sometimes|required|string',
        'companyName' => 'sometimes|required|string',
        'mobile' => 'sometimes|required|string|regex:/^[0-9]{1,10}$/',
        'email' => 'sometimes|required|string|unique:users,email',
    ]);

    if ($validator->fails()) {
        $errors = $validator->errors()->toArray();
        return response()->json(['errors' => $errors], 422);
    }

    // If all fields are valid, proceed to create the Customer
    $user = Supplier::create($request->only('name','companyName', 'mobile', 'email'));

    $response = [
        'supplier' => $user,
    ];
    return response()->json($response, 201);
   }

   public function  getAllSupplier(){
        return Supplier::all();
}

    public function getSupplierById(string $id){
        return Supplier::find($id);
}
    public function updateSupplier(Request $request , string $id){
        $user = Supplier::find($id);
        $user ->update($request->all());
        return $user;

}
    public function search(string $name){
    return Supplier::where('name', 'like', '%'.$name.'%')->get();
}

}
