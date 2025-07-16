<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnsiteTeamMembers extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'onsite_team_members';

    protected $fillable = [
        'employee_id',
        'onsite_team_id',
        'created_at',
        'updated_at'
    ];
}
