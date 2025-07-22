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
        'image_id',
        'site_number',
        'gps_latitude',
        'gps_longitude',
        'traffic_volume',
        'size',
        'type',
        'lighting',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function billboard_booking()
    {
        return $this->belongsToMany(BillboardBooking::class);
    }

    public function billboard_image()
    {
        return $this->hasMany(BillboardImage::class);
    }

    public function location()
    {
        return $this->hasMany(Location::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

}
