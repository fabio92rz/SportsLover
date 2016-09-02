<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: Fabio
 * Date: 31/08/2016
 * Time: 15.34
 */
class Posts extends Model{

    protected $guarded = [];

    public function comments(){

        return $this->hasMany('App\Model\Comments', 'on_post');
    }

    public function category(){

        return $this->hasOne('App\Model\Categories', 'on_post');
    }

    public function author(){

        return $this->belongsTo('App\User', 'author_id');
    }
}