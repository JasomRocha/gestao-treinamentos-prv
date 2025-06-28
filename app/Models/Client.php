<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Training;

class Client extends Model
{
    //
    protected $fillable = [
        'name',
        'cnpj',
        'person',
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
