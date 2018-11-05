<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function post(){
        return $this->hasOne('App\Model\Post','user_id');
    }

    public function posts(){
        return $this->hasMany('App\Model\Post','user_id');
    }

    public function roles(){
        return $this->belongsToMany('App\Model\Role')->withPivot(['created_at','updated_at']);
    }

    public function photos(){

        return $this->morphMany('App\Model\Photo','imagable');
    }

    // accessor function, relate to the route getname in route.php
    // it automatic change by this function return
    // need to be this format: get+{column_name}+Attribute
    public function getNameAttribute($value){

        return 'Name: '.strtoupper($value);
    }

    public function setNameAttribute($value){

        $this->attributes['name']   =   strtoupper($value);
    }
    
}
