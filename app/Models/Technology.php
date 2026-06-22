<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    protected $fillable = [
        'title', 'description', 'problem', 'solution', 'technology_details',
        'trl', 'status', 'owner_id', 'organization_id', 'authors',
        'images', 'files', 'video_url', 'model_3d_url', 'cost', 'currency',
        'category', 'investment_goal', 'roi'
    ];

    protected $casts = [
        'images' => 'json',
        'files' => 'json',
        'authors' => 'json',
        'cost' => 'decimal:2',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function patents()
    {
        return $this->hasMany(Patent::class);
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return [
            'draft' => 'Черновик',
            'research' => 'Исследование',
            'prototype' => 'Прототип',
            'selling' => 'Продажа патента',
            'licensing' => 'Лицензирование',
            'investor_searching' => 'Ищет инвестиции',
            'ready' => 'Готово к внедрению',
            'available' => 'Доступно',
        ][$this->status] ?? $this->status;
    }

    public function getTrlTitleAttribute(): string
    {
        return [
            1 => 'Базовые принципы',
            2 => 'Концепция технологии',
            3 => 'Экспериментальное подтверждение',
            4 => 'Лабораторный прототип',
            5 => 'Испытания в реалистичной среде',
            6 => 'Полный прототип',
            7 => 'Демонстрация в реальных условиях',
            8 => 'Готовая система',
            9 => 'Коммерческий продукт',
        ][$this->trl] ?? 'TRL';
    }
}
