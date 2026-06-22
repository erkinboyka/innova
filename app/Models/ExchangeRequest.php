<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRequest extends Model
{
    protected $fillable = ['company_id', 'title', 'description', 'budget', 'deadline', 'status'];

    protected $casts = [
        'budget' => 'decimal:2',
        'deadline' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return [
            'open' => 'Открыт',
            'in-progress' => 'В работе',
            'closed' => 'Закрыт',
        ][$this->status] ?? $this->status;
    }
}
