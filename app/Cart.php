<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use softDeletes;

    protected $table='carts';
    
    protected $fillable=['id', 'user_id', 'product_id', 'qty', 'address_id', 'status'];

    public function product()
    {
        return $this->hasOne('App\Product', 'id', 'product_id')
                    ->with('images', 'unit', 'retailsales');
    }

    public function products()
    {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }

    public function irregularComment()
    {
        return $this->hasOne('App\IrregularComment', 'cart_id')
                    ->select('id', 'cart_id', 'comment', 'confirm');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function retailsales()
    {
        return $this->hasOne('App\RetailSale', 'product_id', 'product_id')->where('is_available', '1');
    }
}
