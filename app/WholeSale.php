<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WholeSale extends Model
{
    
    protected $table='wholesales';

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
