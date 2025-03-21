<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConnectionRequest extends Model
{
    use HasFactory;

    public function customer_detail()
    {
        return $this->belongsTo(Customer::class,'user_id','id');
    }

    public function users_detail()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
