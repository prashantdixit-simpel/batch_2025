<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Customer;

use App\Models\ConnectionRequest;
use App\Models\Otp;

use App\Http\Traits\AuthenticationTrait;

class AuthController extends Controller
{
    use AuthenticationTrait;
    //
    public function get_connection_id(Request $request)
    {
        $api_key = $request->api_key;

        if($api_key === 'DEMOproject2O2S')
        {
            $connection_id = rand(100000000,999999999);

            ConnectionRequest::insert(['connection_id'=>$connection_id,'created_at'=>now(),'updated_at'=>now()]);
            $response=[
                'connection_id'=>$connection_id
            ];
            return response()->json(['status'=>'success','message'=>'Connection Id generated successfully','data'=>$response]);
        }
        else
            return response()->json(['status'=>'error','message'=>'Failed to  generate connection id','data'=>null]);
    }

    public function request_otp(Request $request)
    {
        $valid = $this->validateConnection($request);
        if(!$valid)
            return response()->json(['status'=>'error','message'=>'Invalid Connection','data'=>[]]);

        $phone=$request->phone;
        $customer = Customer::where('phone_number',$phone)->first();

        // dd($request);
        $result = $this->genrate_otp($phone);
        if(!$result)
        {
            return response()->json(['status'=>'error','message'=>'Failed to send Otp','data'=>[]]);
        }

        if($customer)
        {
            return response()->json(['status'=>'success','message'=>'Otp Sent Successfully','data'=>[]]);
        }
        else
        {
            return response()->json(['status'=>'failed','message'=>'Otp Sent Successfully','data'=>[]]);
        }
        
    }


    public function login(Request $request)
    {
        $valid = $this->validateConnection($request);
        if(!$valid)
            return response()->json(['status'=>'error','message'=>'Invalid Connection','data'=>[]]);

        $phone=$request->phone;
        $otp =$request->otp;
        $customer = Customer::where('phone_number',$phone)->first();

        if(!$customer)
            return response()->json(['status'=>'error','message'=>'Customer  Does not exist . Please register first','data'=>[]]);

        $verify = $this->verify_otp($phone,$otp);
        if(!$verify)
            return response()->json(['status'=>'error','message'=>'Wrong OTP','data'=>[]]);
        else if($verify=='failed')
        {
            return response()->json(['status'=>'error','message'=>'OTP has been expired','data'=>[]]);
        }
        else
        {
            $auth_code =Str::random(15);

            //remove another devices
            ConnectionRequest::where('user_id',$customer->id)->update(['auth_code'=>null,'user_id'=>null]);

            $valid->auth_code = $auth_code;
            $valid->user_id = $customer->id;
            $valid->save();

            $response_data=[
                'customer_details'=>$customer,
                'connection_id'=>$request->connection_id,
                'auth_code'=>$auth_code,
            ];
            return response()->json(['status'=>'success','message'=>'Login Successfully','data'=>$response_data]);
        }
    }


    public function register_customer(Request $request)
    {
        $valid = $this->validateConnection($request);
        if(!$valid)
            return response()->json(['status'=>'error','message'=>'Invalid Connection','data'=>[]]);

        $phone=$request->phone;
        $otp =$request->otp;

        $verify = $this->verify_otp($phone,$otp);
        if(!$verify)
            return response()->json(['status'=>'error','message'=>'Wrong OTP','data'=>[]]);


        $customer = Customer::where('phone_number',$phone)->orWhere('email_id',$request->email)->first();

        if($customer)
            return response()->json(['status'=>'error','message'=>'Email or Phone Already Exist','data'=>[]]);

        $customer = new Customer;

        $customer->name = $request->name;
        $customer->email_id  = $request->email;
        $customer->phone_number  = $phone;

        $customer->save();



        // //after registration relogin
        // return response()->json(['status'=>'success','message'=>'Customer Registered Successfully. Please login to continue','data'=>[]]);


        //login at the time of registration
        $auth_code =Str::random(15);

        $valid->auth_code = $auth_code;
        $valid->user_id = $customer->id;
        $valid->save();

        $response_data=[
            'customer_details'=>$customer,
            'connection_id'=>$request->connection_id,
            'auth_code'=>$auth_code,
        ];

        return response()->json(['status'=>'success','message'=>'Customer Registered Successfully.','data'=>$response_data]);

    }


    // private function validateConnection($request)
    // {
    //     $valid = ConnectionRequest::where('connection_id',$request->connection_id)->first();

    //     return $valid;

    // }

    private function genrate_otp($phone)
    {
        //
        try{
            $record = Otp::firstOrNew(['phone'=>$phone]);
    
            $otp = rand(1000,9999);
            $record->otp = $otp;
            $record->expired_on = now()->addMinutes(5);
            $record->save();

            

            //logic to send otp
    
            return true;
        }
        catch(\Exception $e)
        {
            return false;
        }
    }

    private function verify_otp($phone,$otp)
    {
        // $result = Otp::where('phone',$phone)
        //                 ->where('otp',$otp)
        //                 ->first();

        if($otp = '1234')
            return "success";

        $result = Otp::where(['phone'=>$phone,'otp'=>$otp])->first();

        if(!$result)
            return false;
        else if($result->expired_on > now())
        {
            return "success";
        }
        else
        {
            return "failed";
        }
    }
}