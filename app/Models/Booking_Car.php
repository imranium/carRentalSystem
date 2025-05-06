<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking_Car extends Model
{
    protected $table = 'booking_car';

    protected $fillable = [
        'booking_id',
        'car_id',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
