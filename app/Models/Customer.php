<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='customers';

    protected $fillable=[
        'name',
        'email_id',
        'phone_number'
    ];

    public function existing_Connection()
    {
        return $this->hasOne(ConnectionRequest::class,'user_id','id')->where('type','customers');
    }

    public function existing_connections()
    {
        return $this->hasMany(ConnectionRequest::class,'user_id','id')->where('type','customers');
    }
}
