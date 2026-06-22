<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grant extends Model
{
    protected $fillable = ['title', 'description', 'requirements', 'budget', 'deadline', 'provider', 'link', 'documents', 'status'];

    protected $casts = [
        'budget' => 'decimal:2',
        'deadline' => 'date',
        'documents' => 'json',
    ];
}
