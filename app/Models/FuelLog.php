<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelLog extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'vehicle_id',
        'rental_id',
        'log_date',
        'liters',
        'cost',
        'odometer',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}
