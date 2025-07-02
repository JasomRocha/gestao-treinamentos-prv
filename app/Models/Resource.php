<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
        'name',
        'description',
        'active',
    ];

    public function trainings()
    {
        return $this->belongsToMany(Training::class, 'booking_resources')
                    ->withPivot('due_date', 'comment')
                    ->withTimestamps();
    }
}
