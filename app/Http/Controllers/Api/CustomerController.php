<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ConnectionRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function customer_list()
    {
        // $list = Customer::get();
        // $list = Customer::withTrashed()->get();
        $list = Customer::onlyTrashed()->get();

        $response_date=[
            'status'=>'success',
            'error'=>'00000',
            'data'=>[
                'list'=>$list,
                'total_data'=>count($list),
            ],
        ];

        return response()->json($response_date);
    }

    public function register_customer(Request $request)
    {

        $valid = $this->validateAuth($request->connection_id,$request->auth_code);

        if(!$valid)
        {
            $response_date=[
                'status'=>'error',
                'mesaage'=>'Invalid Connection'
            ];
    
            return response()->json($response_date);
        }

        $payload =[
            'name'=> $request->name,
            'email_id'=> $request->email,
            'phone_number'=> $request->phone_number,
            'dob'=>$request->dob,
        ];

        // $response = Customer::insert($payload);
        // $response = Customer::insertGetId($payload);

        $response = Customer::create($payload);

        dd($response);
    }


    public function customer_destroy()
    {
        //for soft delete

        
        $customer = Customer::where('id',1)->delete();

        //for permanent deete
        $customer = Customer::where('id',1)->forceDelete();
    }


    private function validateAuth($connection_id,$auth_code)
    {
        $valid = ConnectionRequest::where(['connection_id'=>$connection_id,'auth_code'=>$auth_code])->first();

        return $valid;

    }



    public function profile_details(Request $request)
    {
        
        $valid = $this->validateAuth($request->connection_id,$request->auth_code);
        if($valid)
        {
            $customer = Customer::find($valid->user_id);

            return response()->json(['status'=>'success','message'=>'Profile Details','data'=>$customer]);
        }
        else
            return response()->json(['status'=>'error','message'=>'Invalid Connection','data'=>[]]);
    }
}
