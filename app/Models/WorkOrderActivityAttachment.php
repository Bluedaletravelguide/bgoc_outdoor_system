<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderActivityAttachment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'work_order_activity_attachment';

    protected $fillable = [
        'url',
        'wo_activity_id',
        'created_at',
        'updated_at'
    ];

    public function woa_attachment()
    {
        return $this->belongsToMany(WorkOrderActivity::class);
    }
}
