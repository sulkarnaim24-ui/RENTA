<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'brand', 'license_plate', 'price_per_day', 'status', 'image'];

    public function category()
    {
        return $this->belongsTo(VehicleCategory::class, 'category_id');
    }
}
