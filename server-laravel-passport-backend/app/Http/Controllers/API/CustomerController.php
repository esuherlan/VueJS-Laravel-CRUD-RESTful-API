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
        } else {
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
        } else {
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
                        'code' => 200,
                        'response' => 'failed',
                        'message' => 'please fill required fields.'
                    ],
                    'result' => '',
                    'validation_errors' => $validator->errors()
                ]);
            }

            $inputs = $request->all();
            $inputs['password'] = bcrypt($inputs['password']);
            $customer = Customer::create($inputs);
            return response()->json([
                'status' => [
                    'code' => 200,
                    'response' => 'success',
                    'message' => 'insert new customer data successfully.'
                ],
                'result' => $customer
            ]);
        }
    }
}
