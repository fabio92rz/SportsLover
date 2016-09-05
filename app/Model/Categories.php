<?php

namespace App\Model;
Use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: Fabio
 * Date: 02/09/2016
 * Time: 16.53
 */

Class Categories extends Model{

    public function category(){

        return $this->belongsTo('App\Model\Posts', 'on_post');
    }
}
