<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $customers = [];
        if(!auth()->user()->token) {
            return response()->json([
                'status' => [
                    'code' => 401,
                    'response' => 'failed',
                    'message' => 'Unauthenticated.'
                ],
                'result' => $customers
            ]);
        }

        $customers = Customer::all();
        return response()->json([
            'status' => [
                'code' => 200,
                'response' => 'success',
                'message' => 'List of Customers'
            ],
            'result' => $customers
        ]);
    }

    public function store(Request $request)
    {
        if(!auth()->user()->token) {
            return response()->json([
                'status' => [
                    'code' => 401,
                    'response' => 'failed',
                    'message' => 'Unauthenticated.'
                ],
                'result' => ''
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name'     => 'required|min:4',
            'email'   => 'required|email',
            'password'   => 'required|alpha_num|min:5',
            'gender'   => 'required',
            'is_married'   => 'required',
            'address'   => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => [
                    'code' => 400,
                    'response' => 'failed',
                    'message' => 'please fill required fields.'
                ],
                'result' => '',
                'validation_errors' => $validator->errors()
            ]);
        }

        $inputs = $request->all();
        $customer = Customer::create([
            'name' => $inputs['name'],
            'email' => $inputs['email'],
            'password' => bcrypt($inputs['password']),
            'gender' => $inputs['gender'],
            'is_married' => $inputs['is_married'],
            'address' => $inputs['address']
        ]);

        return response()->json([
            'status' => [
                'code' => 201,
                'response' => 'success',
                'message' => 'insert new customer data successfully.'
            ],
            'result' => $customer
        ]);
    }

    public function detail($id)
    {
        if(!auth()->user()->token) {
            return response()->json([
                'status' => [
                    'code' => 401,
                    'response' => 'failed',
                    'message' => 'Unauthenticated.'
                ],
                'result' => ''
            ]);
        }
        
        $customer = Customer::find($id);
        if(is_null($customer)) {
            return response()->json([
                'status' => [
                    'code' => 200,
                    'response' => 'error',
                    'message' => 'sorry, no customer found.'
                ],
                'result' => ''
            ]);
        } else {
            return response()->json([
                'status' => [
                    'code' => 200,
                    'response' => 'success',
                    'message' => 'customer found.'
                ],
                'result' => $customer
            ]);
        }
    }

    public function update($id, Request $request)
    {
        if(!auth()->user()->token) {
            return response()->json([
                'status' => [
                    'code' => 401,
                    'response' => 'failed',
                    'message' => 'Unauthenticated.'
                ],
                'result' => ''
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name'     => 'required|min:4',
            'email'   => 'required|email',
            'password'   => 'required|alpha_num|min:5',
            'gender'   => 'required',
            'is_married'   => 'required',
            'address'   => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => [
                    'code' => 400,
                    'response' => 'failed',
                    'message' => 'please fill required fields.'
                ],
                'result' => '',
                'validation_errors' => $validator->errors()
            ]);
        }

        $inputs = $request->all();
        $customer = Customer::whereId($inputs['id'])->update([
            'name' => $inputs['name'],
            'email' => $inputs['email'],
            'password' => bcrypt($inputs['email']),
            'gender' => $inputs['gender'],
            'is_married' => $inputs['is_married'],
            'address' => $inputs['address']
        ]);

         if($customer) {
            return response()->json([
                'status' => [
                    'code' => 201,
                    'response' => 'success',
                    'message' => 'update customer data successfully.'
                ],
                'result' => $customer
            ]);
         } else {
            return response()->json([
                'status' => [
                    'code' => 400,
                    'response' => 'failed',
                    'message' => 'sorry, update customer data failed.'
                ],
                'result' => []
            ]);
         }
    }

    public function delete($id)
    {
        if(!auth()->user()->token) {
            return response()->json([
                'status' => [
                    'code' => 401,
                    'response' => 'failed',
                    'message' => 'Unauthenticated.'
                ],
                'result' => []
            ]);
        }
        
        $customer = Customer::findOrFail($id);
        $customer->delete();

        if($customer) {
            return response()->json([
                'status' => [
                    'code' => 201,
                    'response' => 'success',
                    'message' => 'Customer data deleted successfully.'
                ],
                'result' => []
            ]);
        } else {
            return response()->json([
                'status' => [
                    'code' => 400,
                    'response' => 'failed',
                    'message' => 'Customer data failed to delete.'
                ],
                'result' => []
            ]);
        }
    }
}