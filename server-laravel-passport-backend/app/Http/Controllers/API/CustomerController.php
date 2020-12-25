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
        if(auth()->user()->token) {
            $customers = Customer::all();
            return response()->json([
                'status' => [
                    'code' => 200,
                    'response' => 'success',
                    'message' => 'List of Customers'
                ],
                'result' => $customers
            ]);
        } else {
            return response()->json([
                'status' => [
                    'code' => 401,
                    'response' => 'failed',
                    'message' => 'Unauthenticated.'
                ],
                'result' => $customers
            ]);
        }
    }
}
