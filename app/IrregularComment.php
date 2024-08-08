<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IrregularComment extends Model
{
    use SoftDeletes;
    protected $fillable = ['cart_id', 'comment'];
    protected $dates = ['deleted_at'];
}
