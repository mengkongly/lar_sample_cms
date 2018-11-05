<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //

    public function tags(){
        return $this->morphToMany('App\Model\Tag','taggable');
    }
}
