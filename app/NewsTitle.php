<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsTitle extends Model
{
    use SoftDeletes;

    protected $table='news_titles';

    protected $dates = ['deleted_at'];

    public function readnews()
    {
        return $this->hasMany('App\ReadNews', 'title_id');
    }

    public function contents()
    {
        return $this->hasMany('App\NewsContent');
    }
}
