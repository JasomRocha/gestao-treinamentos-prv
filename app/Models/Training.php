<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use SoftDeletes;
    protected $fillable = [
    'title',
    'due_date',
    'description',
    'qtd_student',
    'type_training_id',
    'client_id',
    'instructor_id',
    'status_id',
    'financial_status_id',
    'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(TypeTraining::class, 'type_training_id');
    }

    public function financialStatus()
    {
        return $this->belongsTo(FinancialStatus::class, 'financial_status_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function post_training()
    {
        return $this->hasMany(PostTraining::class);
    }

    public function costs()
    {
        return $this->belongsToMany(Cost::class, 'training_cost')
                    ->withPivot('quantity', 'final_value')
                    ->withTimestamps();
    }

    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'booking_resources')
                    ->withPivot('due_date', 'comment')
                    ->withTimestamps();
    }
}
