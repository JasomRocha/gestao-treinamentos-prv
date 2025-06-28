<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training_Cost extends Model
{
    //
        protected $table = 'training_costs';

    protected $fillable = [
        'training_id',
        'cost_id',
        'quantity',
        'final_value'
    ];

    public function training() {
        return $this->belongsTo(Training::class);
    }

    public function cost() {
        return $this->belongsTo(Cost::class);
    }
}
