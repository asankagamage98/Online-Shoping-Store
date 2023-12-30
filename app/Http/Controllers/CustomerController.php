<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function addCustomer(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'sometimes|required|string',
            'mobile' => 'sometimes|required|string|regex:/^[0-9]{1,10}$/',
            'address' => 'sometimes|required|string',
            'email' => 'sometimes|required|string|unique:users,email',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        }

        // If all fields are valid, proceed to create the Customer
        $user = Customer::create($request->only('name', 'mobile', 'address', 'email'));

        $response = [
            'customer' => $user,
        ];
        return response()->json($response, 201);
    }

    public function  getAllCustomer(){
        return Customer::all();
    }

    public function getCustomerById(string $id){
        return Customer::find($id);
    }
    public function updateCustomer(Request $request , string $id){
        $user = Customer::find($id);
        $user ->update($request->all());
        return $user;

    }
    public function search(string $name){
        return Customer::where('name', 'like', '%'.$name.'%')->get();
    }
}
