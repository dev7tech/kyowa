<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purse extends Model
{
    protected $table='purse';
    
    protected $fillable=['id', 'user_id', 'point'];

    public function user()
    {
        return $this->hasOne('App\User', 'id' ,'user_id');
    }
}
