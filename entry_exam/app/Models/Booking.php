<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    protected $primaryKey = 'booking_id'; // Vì bạn đặt 'booking_id' là khóa chính
    public $incrementing = false; // Vì 'booking_id' không tự động tăng

    protected $fillable = [
        'hotel_id',
        'customer_name',
        'customer_contact',
        'chekin_time',
        'checkout_time',
    ];
}
