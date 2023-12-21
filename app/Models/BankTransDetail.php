<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankTransDetail extends Model
{
    use HasFactory;

    protected $table = 'bank_trans_detail';
    protected $guarded = [];
    protected $casts = [];
}
