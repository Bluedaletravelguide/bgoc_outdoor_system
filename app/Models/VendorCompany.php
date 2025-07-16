<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorCompany extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vendor_company';

    protected $fillable = [
        'name',
        'address',
        'phone',
        'description',
        'services_offered',
        'created_at',
        'updated_at'
    ];
}
