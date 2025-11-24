<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DpsAccount extends Model
{
    use HasFactory;


    protected $fillable = [
        'start_date',
        'member_id',
        'plan_id',
        'monthly_deposit',
        'duration_months',
        'interest_rate',
        'total_deposit',
        'mature_amount',
        'mature_date',
        'status',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function plan()
    {
        return $this->belongsTo(DpsPlan::class, 'plan_id');
    }

    public function installments()
    {
        return $this->hasMany(DpsInstallment::class, 'dps_id');
    }
}
