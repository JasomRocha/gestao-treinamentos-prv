<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Training;

class Status extends Model
{
    //

    protected $fillable = [
        'status',
        'active'
    ];

    public function trainings(){
        return $this->hasMany(Training::class);
    }
}
