<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patent extends Model
{
    protected $fillable = ['technology_id', 'number', 'country', 'filing_date', 'holder', 'metadata'];

    protected $casts = [
        'filing_date' => 'date',
        'metadata' => 'array',
    ];

    public function technology()
    {
        return $this->belongsTo(Technology::class);
    }
}
