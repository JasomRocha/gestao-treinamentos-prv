<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Resource;
use App\Models\Training;

class Booking_Resources extends Model
{
    //
     protected $fillable = [
        'training_id',
        'resource_id',
        'due_date',
        'comment'
    ];

    public function training() {
        return $this->belongsTo(Training::class);
    }

    public function resource() {
        return $this->belongsTo(Resource::class);
    }
}
