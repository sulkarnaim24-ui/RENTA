<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'policy_number',
        'provider',
        'start_date',
        'end_date',
        'premium_cost',
        'document_file',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
