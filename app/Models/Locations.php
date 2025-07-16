<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'locations';

    protected $fillable = [
        'name',
        'type',
        'parent_id'
    ];

    /**
     * Get the parent location (department or building).
     */
    public function parent()
    {
        return $this->belongsTo(Locations::class, 'parent_id');
    }

    /**
     * Get the child locations (departments or buildings).
     */
    public function children()
    {
        return $this->hasMany(Locations::class, 'parent_id');
    }

    /**
     * Get the level of the location.
     */
    public function level()
    {
        // Assuming type is used to determine the level
        // You can adjust this logic based on your actual data structure
        return $this->belongsTo(Locations::class, 'parent_id')->where('type', 'level');
    }

    /**
     * Get the building of the location.
     */
    public function building()
    {
        // Assuming type is used to determine the building
        // You can adjust this logic based on your actual data structure
        return $this->belongsTo(Locations::class, 'parent_id')->where('type', 'building');
    }
}