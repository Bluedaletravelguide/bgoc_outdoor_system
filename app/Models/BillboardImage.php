<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillboardImage extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'billboard_images';

    protected $fillable = [
        'billboard_id',
        'image_path',
        'image_type',
        'created_at',
        'updated_at'
    ];

    public function billboard()
    {
        return $this->belongsTo(Billboard::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

}
