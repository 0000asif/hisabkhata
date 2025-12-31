<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "area_id",
        "joined_date",
        "date",
        "name",
        "phone",
        "address",
        "nid",
        "nid_front",
        "nid_back",
        "father_name",
        "guarantor",
        "nominee",
        "nominee_phone",
        "nominee_relation",
        "member_photo",
        "nominee_photo",
        "signature",
        "pdf_file",
        "password",
        "password",
        "status",
        "note",
        "membership_fee",
    ];


    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function area()
    {
        return $this->belongsTo(Area::class, "area_id");
    }
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
