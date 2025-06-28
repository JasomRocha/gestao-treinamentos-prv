<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Training;

class TypeTraining extends Model
{
    //
    protected $fillable = [
        'title',
        'hours',
    ];

    public function trainings(){
        return $this->hasMany(Training::class);
    }
}
