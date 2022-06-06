<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demande_Conge extends Model
{
    protected $table = 'conges';

    public function congé(){
        return $this->belongsTo("App\Demande");
    }
}
