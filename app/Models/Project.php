<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projects';

    protected $fillable = [
        'project_prefix',
        'from_date',
        'to_date',
        'type',
        'client_company_id',
        'created_at',
        'updated_at'
    ];

    public function client_company()
    {
        return $this->belongsToMany(ClientCompany::class);
    }
}
