<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billboard extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'billboards';

    protected $fillable = [
        'location_id',
        'site_number',
        'gps_latitude',
        'gps_longitude',
        'traffic_volume',
        'size',
        'type',
        'prefix',
        'lighting',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function billboard_bookings()
    {
        return $this->belongsToMany(BillboardBooking::class);
    }

    public function billboard_images()
    {
        return $this->hasMany(BillboardImage::class);
    }

    public function locations()
    {
        return $this->belongsTo(Location::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
