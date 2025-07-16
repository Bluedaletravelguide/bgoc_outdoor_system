<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderHistory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'work_order_history';

    protected $fillable = [
        'status',
        'status_changed_by',
        'assigned_teamleader',
        'assign_to_technician',
        'work_order_id',
        'created_at',
        'updated_at'
    ];

    public function work_order_activity()
    {
        return $this->belongsToMany(WorkOrderActivity::class);
    }

    public function work_order()
    {
        return $this->belongsToMany(WorkOrder::class);
    }
}
