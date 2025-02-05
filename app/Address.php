<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use softDeletes;
    
    protected $table='address';

    public function user(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
