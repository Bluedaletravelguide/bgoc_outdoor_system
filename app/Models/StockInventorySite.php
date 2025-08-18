<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockInventorySite extends Model
{
    use HasFactory;

    protected $table = 'stock_inventory_sites';

    protected $fillable = [
        'stock_inventory_id',
        'billboard_id',
        'type',
        'quantity',
    ];

    // Relationships
    public function inventory()
    {
        return $this->belongsTo(StockInventory::class, 'stock_inventory_id');
    }

    public function billboard()
    {
        return $this->belongsTo(Billboard::class, 'billboard_id');
    }

    public function history()
    {
        return $this->hasMany(StockInventorySiteHistory::class, 'stock_inventory_site_id');
    }
}
