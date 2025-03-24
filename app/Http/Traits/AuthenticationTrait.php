<?php
namespace App\Http\Traits;

use App\Models\ConnectionRequest;

trait AuthenticationTrait {


    public function validateConnection($request)
    {
        $valid = ConnectionRequest::where('connection_id',$request->connection_id)->first();

        return $valid;
    }
    

    private function validateAuth($connection_id,$auth_code)
    {
        $valid = ConnectionRequest::where(['connection_id'=>$connection_id,'auth_code'=>$auth_code])->first();

        return $valid;

    }


}