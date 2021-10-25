<?php

namespace App\Models;

use App\Models\User;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    // use HasFactory;
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function orderdetail(){
        return $this->hasMany(OrderDetail::class);
    }
}