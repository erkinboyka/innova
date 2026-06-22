<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrlQuestion extends Model
{
    protected $fillable = ['level', 'question', 'type', 'order'];
}
