<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Currency extends Model
{
    use HasFactory;

    protected $table = 'currency';
    protected $guarded = [];

    public function scopeActive(Builder $query): void
    {
        $query->where('status', 'active');
    }
}
