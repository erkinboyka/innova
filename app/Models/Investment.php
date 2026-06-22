<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = ['technology_id', 'investor_id', 'amount', 'status', 'notes'];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function technology()
    {
        return $this->belongsTo(Technology::class);
    }

    public function investor()
    {
        return $this->belongsTo(User::class, 'investor_id');
    }
}
