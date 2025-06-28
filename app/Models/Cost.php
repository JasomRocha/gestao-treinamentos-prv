<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Training;

class Cost extends Model
{
    //
    protected $fillable = [
        'title',
        'value_unt',
        'description'
    ];

    public function trainings() {
    return $this->belongsToMany(Training::class, 'training_costs')
                ->withPivot('quantity', 'final_value')
                ->withTimestamps();
    }
}
