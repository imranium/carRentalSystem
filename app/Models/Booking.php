<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
        use HasFactory, SoftDeletes;

        protected $fillable = [
            'customer_id',
            'start_date',
            'end_date',
            'status',
            'branch_id',
        ];

        protected $casts = [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];

        public function customer()
        {
            return $this->belongsTo(Customer::class);
        }

        public function cars()
        {
            return $this->belongsToMany(Car::class, 'booking_car')
                ->withTimestamps();
        }
        public function branch()
        {
            return $this->belongsTo(Branch::class);
        }

        public function getTotalAmountAttribute()
    {
        $days = \Carbon\Carbon::parse($this->start_date)->diffInDays($this->end_date) + 1;

        return $this->cars->sum(function ($car) use ($days) {
            return $car->daily_rate * $days;
        });


    }

}
