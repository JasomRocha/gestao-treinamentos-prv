<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Training;

class Resource extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'active'
    ];

    public function trainings() {
    return $this->belongsToMany(Training::class, 'booking_resources')
                ->withPivot('due_date', 'comment')
                ->withTimestamps();
    }
}
