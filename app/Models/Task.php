<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'completed', 'description', 'due_date']; // allow mass assignment of these fields
    protected $casts = [
        'due_date' => 'date',
        'completed' => 'boolean',
    ];
}
