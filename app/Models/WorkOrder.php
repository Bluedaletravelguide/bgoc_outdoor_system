<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'work_order';

    protected $fillable = [
        'work_order_no',
        'type',
        'status',
        'priority',
        'service_request_id',
        'status_changed_by',
        'assign_to_supervisor',
        'assign_to_technician',
        'contract_id',
        'asset_id',
        'due_date',
        'created_at',
        'updated_at'
    ];

    public function service_request()
    {
        return $this->belongsToMany(ServiceRequest::class);
    }

    public function contracts()
    {
        return $this->belongsToMany(Contract::class);
    }

    public function assets()
    {
        return $this->belongsTo(Asset::class);
    }
}
