<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $table='news_categories';

    public function newstitles()
    {
        return $this->hasMany('App\NewsTitle', 'category_id')->with('readnews');
    }

}
