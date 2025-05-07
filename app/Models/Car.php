<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'brand',
        'model',
        'type', // e.g. SUV, sedan
        'transmission', // e.g. automatic, manual
        'color',
        'year',
        'daily_rate',
        'plate_number',
        'branch_id',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_car')
            ->withTimestamps();
    }
    
}
