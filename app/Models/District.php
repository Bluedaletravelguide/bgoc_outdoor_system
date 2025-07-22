<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'districts';

    protected $fillable = [
        'state_id',
        'name',
        'created_at',
        'updated_at',
    ];


    public function states()
    {
        // Assuming type is used to determine the building
        // You can adjust this logic based on your actual data structure
        return $this->belongsTo(State::class);
    }
}