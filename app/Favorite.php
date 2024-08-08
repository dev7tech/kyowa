<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favorite extends Model
{
    use SoftDeletes;

    protected $table='favorites';

    protected $dates = ['deleted_at'];

    public function product(){
        return $this->hasOne('App\Product', 'id', 'product_id')
                    ->with('images', 'retailsales');
    }
}