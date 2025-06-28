<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Training;

class Instructor extends Model
{
    //
     protected $fillable = [
        'name',
        'phone',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function trainings(){
        return $this->hasMany(Training::class);
    }
}
