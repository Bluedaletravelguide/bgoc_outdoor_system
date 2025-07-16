<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderObservations extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'work_order_observations';

    protected $fillable = [
        'remarks',
        'type',
        'work_order_id',
        'work_order_history_id',
        'created_at',
        'updated_at'
    ];

    public function work_order()
    {
        return $this->belongsToMany(WorkOrder::class);
    }
}
