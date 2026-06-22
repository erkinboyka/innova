<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'type',
        'region',
        'website',
        'description',
        'logo',
        'verification_status',
        'verified_at',
        'created_by',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function technologies()
    {
        return $this->hasMany(Technology::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members()
    {
        return $this->hasMany(User::class);
    }
}
