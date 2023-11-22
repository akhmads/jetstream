<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Bank;
use App\Models\Coa;

class BankAccount extends Model
{
    use HasFactory;

    protected $table = 'bank_account';
    protected $guarded = [];

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class,'bank_id','id');
    }

    public function coa(): BelongsTo
    {
        return $this->belongsTo(Coa::class,'coa_code','code');
    }
}
