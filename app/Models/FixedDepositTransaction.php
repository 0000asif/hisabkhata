<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedDepositTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function fd()
    {
        return $this->belongsTo(FixedDeposit::class);
    }
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
