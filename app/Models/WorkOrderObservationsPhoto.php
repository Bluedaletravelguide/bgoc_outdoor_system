<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderObservationsPhoto extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'work_order_observations_photos';

    protected $fillable = [
        'url',
        'wo_observations_id',
        'created_at',
        'updated_at'
    ];

    public function sr_photo()
    {
        return $this->belongsToMany(WorkOrderObservations::class);
    }
}
