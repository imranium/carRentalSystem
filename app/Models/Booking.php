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

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function cars()
    {
        return $this->belongsToMany(Car::class, 'booking_car')
            ->withTimestamps();
    }

}
