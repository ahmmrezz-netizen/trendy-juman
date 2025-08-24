<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone'
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function getTotalPurchasesAttribute()
    {
        return $this->purchases()->sum('qty');
    }
}
