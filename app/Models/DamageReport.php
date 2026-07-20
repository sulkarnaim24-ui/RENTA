<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamageReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'rental_id',
        'description',
        'photo',
        'reported_date',
        'repair_cost',
        'status',
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
