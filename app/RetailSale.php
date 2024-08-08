<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetailSale extends Model
{
    
    protected $table='retailsales';

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
