<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestSubCategory extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sr_sub_category';

    protected $fillable = [
        'name',
        'sr_category_id'
    ];

    public function sr_category()
    {
        return $this->belongsToMany(ServiceRequestCategory::class);
    }
}
