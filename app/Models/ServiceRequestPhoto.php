<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestPhoto extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'service_request_photos';

    protected $fillable = [
        'url',
        'service_request_id',
        'created_at',
        'updated_at'
    ];

    public function sr_photo()
    {
        return $this->belongsToMany(WorkOrderObservations::class);
    }
}
