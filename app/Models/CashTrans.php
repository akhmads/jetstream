<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\CashAccount;
use App\Models\Contact;
use App\Models\CashTransDetail;

class CashTrans extends Model
{
    use HasFactory;

    protected $table = 'cash_trans';
    protected $guarded = [];
    protected $casts = [
        'date' => 'date',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(CashAccount::class,'cash_account_id','id');
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class,'contact_id','id');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(CashTransDetail::class, 'number', 'number');
    }


}
