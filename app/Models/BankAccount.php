<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

     protected $fillable = [
        'bank_name', 'branch_name', 'account_name', 'account_type',
        'account_number', 'opening_balance', 'status', 'user_id'
    ];

    public function transactions()
    {
        return $this->hasMany(BankTransaction::class);
    }

    public function getBalanceAttribute()
    {
        $deposit = $this->transactions()->where('type', 'deposit')->sum('amount');
        $withdraw = $this->transactions()->where('type', 'withdraw')->sum('amount');

        return ($this->opening_balance + $deposit) - $withdraw;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
