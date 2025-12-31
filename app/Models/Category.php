<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
  protected $fillable = ['name', 'status', 'type'];

    // Optional: helper for status label
    public function statusLabel()
    {
        return $this->status == 1 ? 'Active' : 'Inactive';
    }
}
