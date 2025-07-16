<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnsiteTeam extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'onsite_team';

    protected $fillable = [
        'id',
        'team_name',
        'contract_id',
        'type',
        'created_at',
        'updated_at'
    ];

    public function teams()
    {
        return $this->belongsToMany(OnsiteTeamMembers::class);
    }
}
