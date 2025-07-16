<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchase_orders';

    protected $fillable = [
        'receipt_reference_number',
        'price',
        'purchase_date',
        'warranty_from',
        'warranty_until',
        'description',
        'supplier_id',
        'created_at',
        'updated_at'
    ];
}