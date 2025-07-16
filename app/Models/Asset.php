<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'assets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'asset_category_id',
        'description',
        'asset_id',
        'location_id',
        'purchase_order_id',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the parent asset if this asset belongs to another asset.
     */
    public function parentAsset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    /**
     * Get the location associated with the asset.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the purchase order associated with the asset.
     */
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
