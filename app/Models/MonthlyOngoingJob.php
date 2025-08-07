<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyOngoingJob extends Model
{
    use HasFactory;

    protected $table = 'monthly_ongoing_jobs';

    protected $fillable = [
        'booking_id',
        'month',
        'year',
        'status',
    ];

    /**
     * Relationship: MonthlyOngoingJob belongs to one BillboardBooking
     */
    public function bookings()
    {
        return $this->belongsTo(BillboardBooking::class, 'booking_id');
    }
}
