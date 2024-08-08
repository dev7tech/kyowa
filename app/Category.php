<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table='categories';

    protected $dates = ['deleted_at'];

    protected $fillable=['id','p_id', 'name', 'order', 'is_available'];

    public function c_products()
    {
        return $this->hasMany('App\Product');
    }

    public function p_products()
    {
        return $this->hasMany('App\Product', 'pcategory_id', 'id');
    }
}
