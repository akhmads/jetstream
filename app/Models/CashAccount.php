<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Coa;

class CashAccount extends Model
{
    use HasFactory;

    protected $table = 'cash_account';
    protected $guarded = [];

    public function coa(): BelongsTo
    {
        return $this->belongsTo(Coa::class,'coa_code','code');
    }
}
