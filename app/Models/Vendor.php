<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vendors';

    protected $fillable = [
        'name',
        'contact',
        'company_id',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function vendor_company()
    {
        return $this->belongsToMany(VendorCompany::class);
    }
}
