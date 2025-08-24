<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'size',
        'color',
        'available_qty',
        'image',
        'added_by'
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function getTotalSoldAttribute()
    {
        return $this->purchases()->sum('qty');
    }
}
