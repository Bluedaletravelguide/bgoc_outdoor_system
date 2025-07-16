<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employees';

    protected $fillable = [
        'id',
        'name',
        'contact',
        'position',
        'user_id',
        'status',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
}
