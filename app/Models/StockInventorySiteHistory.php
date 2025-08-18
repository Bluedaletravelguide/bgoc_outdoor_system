<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockInventorySiteHistory extends Model
{
    use HasFactory;

    protected $table = 'stock_inventory_sites_history';

    protected $fillable = [
        'stock_inventory_site_id',
        'stock_inventory_id',
        'billboard_id',
        'type',
        'quantity',
        'change_type',
        'changed_by',
        'changed_at',
    ];

    public $timestamps = false; // we use changed_at instead

    // Relationships
    public function site()
    {
        return $this->belongsTo(StockInventorySite::class, 'stock_inventory_site_id');
    }

    public function inventory()
    {
        return $this->belongsTo(StockInventory::class, 'stock_inventory_id');
    }

    public function billboard()
    {
        return $this->belongsTo(Billboard::class, 'billboard_id');
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
