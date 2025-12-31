<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DpsInstallment extends Model
{
    use HasFactory;


    protected $fillable = [
        'dps_id',
        'due_date',
        'amount',
        'status',
        'paid_amount',
    ];

    public function dps()
    {
        return $this->belongsTo(DpsAccount::class, 'dps_id');
    }
}
