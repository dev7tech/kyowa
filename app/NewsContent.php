<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsContent extends Model
{
    protected $table = 'news_contents';

    public function product()
    {
        return $this->hasOne('App\Product', 'id', 'product_id')->with('images');
    }
}
