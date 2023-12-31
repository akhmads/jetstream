<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BeginningBalance extends Model
{
    use HasFactory;

    protected $table = 'beginning_balance';
    protected $guarded = [];

    public function coa(): BelongsTo
    {
        return $this->belongsTo(Coa::class, 'coa_code','code');
    }
}
