<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\BankAccount;
use App\Models\Contact;
use App\Models\BankTransDetail;

class CashTrans extends Model
{
    use HasFactory;

    protected $table = 'bank_trans';
    protected $guarded = [];
    protected $casts = [
        'date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(CashAccount::class,'bank_account_id','id');
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class,'contact_id','id');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(BankTransDetail::class, 'code', 'code');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class,'created_id','id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class,'updated_id','id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class,'approved_id','id');
    }
}
