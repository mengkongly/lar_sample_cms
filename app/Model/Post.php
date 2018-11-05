<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Post extends Model
{
    use SoftDeletes;
    protected $dates    =   ['deleted_at'];
    protected $fillable  =   ['title','content','path']; 
    public $image_path =   '/images/';

    public function user(){
        return $this->belongsTo('App\User');
    }


    public function photos(){

        return $this->morphMany('App\Model\Photo','imagable');
    }


    public function tags(){

        return $this->morphToMany('App\Model\Tag','taggable');
    }


    // create query scope for call in controller
    // convention is scope+Name() then when call in controller Post::name();
    // example for this scope call: Post::latest();
    public static function scopeLatest($query){

        return $query->where('id','>','0')->orderBy('id','desc')->get();
        //return $query->orderBy('id','asc')->get();
    }

    public function getPathAttribute($value){
        return $this->image_path.$value;
    }
}
