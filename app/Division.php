<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use App\User;


class Division extends Model
{
    protected $table = 'division';

    public function user() {
        return $this->hasMany('App\User');
    }
    public function services() {
        return $this->hasMany('App\Service');
    }
}




