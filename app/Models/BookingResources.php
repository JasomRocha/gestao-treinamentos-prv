<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingResources extends Model
{
    protected $fillable = [
        'training_id',
        'resource_id',
        'due_date',
        'comment',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
