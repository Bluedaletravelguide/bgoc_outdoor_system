<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillboardBooking extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'billboard_bookings';

    protected $fillable = [
        'billboard_id',
        'company_id',
        'start_date',
        'end_date',
        'status',
        'artwork_by',
        'dbp_approval',
        'remarks',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function billboard()
    {
        return $this->belongsTo(Billboard::class);
    }

    public function client_company()
    {
        return $this->belongsTo(ClientCompany::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

}
