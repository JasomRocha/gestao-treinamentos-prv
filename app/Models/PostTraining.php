<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Training;

class PostTraining extends Model
{
    //
    protected $fillable = [
        'training_id',
        'event',
        'status',
        'conclusion_date',
        'comments'
    ];

    public function trainings(){
        return $this->belongsTo(Training::class);
    }
}
