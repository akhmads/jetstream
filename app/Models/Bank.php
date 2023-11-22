<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bank extends Model
{
    use HasFactory;

    protected $table = 'bank';
    protected $guarded = [];

    public function scopeActive(Builder $query): void
    {
        $query->where('status', 'active');
    }
}
