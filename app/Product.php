<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table='products';

    protected $dates = ['deleted_at'];

    protected $fillable=['id',
                        'codeNo',
                        'name',
                        'price',
                        'qty',
                        'mark',
                        'description',
                        'is_avaliable',
                        'is_irregular',
                        'tax',
                        'order',
                    ];

    public function images()
    {
        return $this->hasMany('App\Image')->orderBy('id', 'asc');
    }

    public function medias()
    {
        return $this->hasMany('App\Media');
    }

    public function favorites()
    {
        return $this->hasMany('App\Favorite');
    }

    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'category_id')
                    ->select('id', 'parent_name', 'name', 'p_id');
    }

    public function unit()
    {
        return $this->hasOne('App\Unit', 'id', 'unit_id');
    }

    public function retailsales()
    {
        return $this->hasOne('App\RetailSale')->where('is_available', '1')->orderBy('retailsale', 'desc');
    }

    public function wholesales()
    {
        return $this->hasOne('App\WholeSale')->where('is_available', '1');
    }
}
