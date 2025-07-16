<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderActivity extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'work_order_activity';

    protected $fillable = [
        'id',
        'comments',
        'comment_by',
        'work_order_id',
        'created_at',
        'updated_at'
    ];

    public function work_order()
    {
        return $this->belongsToMany(WorkOrder::class);
    }
}
