<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationHistory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notification_history';

    protected $fillable = [
        'notification_content',
        'user_id',
        'status',
        'created_at',
        'updated_at'
    ];
}