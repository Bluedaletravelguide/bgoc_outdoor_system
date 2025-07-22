<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'locations';

    protected $fillable = [
        'district_id',
        'name',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];


    public function districts()
    {
        // Assuming type is used to determine the building
        // You can adjust this logic based on your actual data structure
        return $this->belongsTo(District::class);
    }
}