<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //

    public function users(){
        return $this->belongsToMany('App\User');

        //if the table name is not match laravel relationship convention
        // you need to specific table name and columns name as below
        //return $this->belongsToMany('App\User','table_name','user_id','role_id');

    }
}
