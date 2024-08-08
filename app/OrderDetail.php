<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table="order_details";

    public function product()
    {
        return $this->hasOne('App\Product', 'id', 'product_id')->with('images', 'unit', 'retailsales');
    }

    public function adminproduct()
    {
        return $this->hasOne('App\Product', 'id', 'product_id')->with('images', 'unit', 'retailsales', 'wholesales');
    }
}
