<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function user_list(Request $request)
    {
        $limit = $request->limit ?? 5;
        $page = $request->page >=1 ? $request->page : 1;
        $offset = ($page-1)*$limit;


        $list = User::query();
        $total_records = $list->count();
        if($total_records < ( $offset) )
        {
            return response()->json(['status'=>'error','message'=>'No Page Available','data'=>[]]);
        }
        
        $list =  $list->skip($offset)->limit($limit)->get();


        // $user_list = User::paginate($limit);
        $response_date=[
            'status'=>'success',
            'error'=>'00000',
            'data'=>[
                // 'us_l'=>$user_list,
                'list'=>$list,
                'total_data'=>$total_records,
                'current_page'=>$page,
            ],
        ];

        return response()->json($response_date);
    }

    public function register_user(Request $request)
    {
        // dd($request);

        try{

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->input('email');
            $user->password = Hash::make($request->phone_number);
    
            $user->save();
    
            if($user->id)
            {
                $response_data=[
                    'status'=>'success','message'=>'register succesfull','data'=>$user
                ];
                return response()->json($response_data);
            }
            else
                return response()->json(['status'=>'error','message'=>'Failed to register','data'=>null]);
        }
        catch(\Exception $e)
        {
            return response()->json(['status'=>'error','message'=>$e->getMessage(),'data'=>null]);
        }
    }



    public function user_detail(Request $request)
    {
        $user_id = $request->user_id;

        $user = User::find($user_id);

        if($user)
        {
            $response_data=[
                'status'=>'success','message'=>'user details','data'=>$user
            ];
            return response()->json($response_data);
        }
        else
            return response()->json(['status'=>'error','message'=>'User Not Found','data'=>null]);

    }


    public function user_update(Request $request)
    {
        // dd($request);

        try{

            $user = User::where('id','=',$request->user_id)->first();
            // dd($user,$request);
            if(!$user)
            {
                return response()->json(['status'=>'error','message'=>'User not Found','data'=>null]);
            }

            $user->name = $request->name;
            $user->email = $request->input('email');

            if($request->password)
                $user->password = Hash::make($request->password);
    
            $user->save();

            return response()->json(['status'=>'success','message'=>'User Details Updated Successfully','data'=>$user]);

    
        }
        catch(\Exception $e)
        {
            return response()->json(['status'=>'error','message'=>$e->getMessage(),'data'=>null]);
        }
    }
}
