<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    use HasFactory;

    protected $table = 'item';
    protected $guarded = [];

    public function coaselling(): BelongsTo
    {
        return $this->belongsTo(Coa::class,'coa_selling','code');
    }

    public function coabuying(): BelongsTo
    {
        return $this->belongsTo(Coa::class,'coa_buying','code');
    }

    public function coacogs(): BelongsTo
    {
        return $this->belongsTo(Coa::class,'coa_cogs','code');
    }
}

