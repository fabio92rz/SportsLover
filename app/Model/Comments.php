<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: Fabio
 * Date: 31/08/2016
 * Time: 15.40
 */
class Comments extends Model{

    protected $guarded = [];

    public function author(){

        return $this->belongsTo('App\User', 'from_user');
    }

    public function post(){

        return $this->belongsTo('App\Model\Posts', 'on_post');
    }
}