<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DpsPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'duration_months',
        'monthly_deposit',
        'interest_rate',
    ];

    public function accounts()
    {
        return $this->hasMany(DpsAccount::class, 'plan_id');
    }
}
