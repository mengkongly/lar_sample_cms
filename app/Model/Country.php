<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    
    public function posts(){

        //relationship between posts->users->country 
        //users table is the pivot of posts table and country table
        return $this->hasManyThrough('App\Model\Post','App\User');
    }
}
