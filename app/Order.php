<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use softDeletes;

    protected $table="orders";

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function address()
    {
        return $this->hasOne('App\Address', 'id', 'address_id');
    }

    public function payment()
    {
        return $this->hasMany('App\Payment', 'id', 'payment_id');
    }

    public function orderDetail(){
        return $this->hasMany('App\OrderDetail', 'order_id', 'id')->with('adminproduct');
    }

    public function delivery(){
        return $this->hasOne('App\deliveryMethod', 'id', 'delivery_method');
    }
}
