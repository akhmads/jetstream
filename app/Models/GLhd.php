<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GLhd extends Model
{
    use HasFactory;

    protected $table = 'glhd';
    protected $guarded = [];
    protected $casts = [
        'date' => 'date',
    ];
}
