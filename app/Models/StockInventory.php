<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockInventory extends Model
{
    use HasFactory;

    protected $table = 'stock_inventory';

    protected $fillable = [
        'contractor_pic',
        'client_in',
        'client_out',
        'date_in',
        'date_out',
        'remarks_in',
        'remarks_out',
        'balance_contractor',
        'balance_bgoc',
    ];

    // Relationships
    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_pic');
    }

    public function clientIn()
    {
        return $this->belongsTo(ClientCompany::class, 'client_in');
    }

    public function clientOut()
    {
        return $this->belongsTo(ClientCompany::class, 'client_out');
    }

    public function sites()
    {
        return $this->hasMany(StockInventorySite::class, 'stock_inventory_id');
    }

    public function history()
    {
        return $this->hasMany(StockInventoryHistory::class, 'stock_inventory_id');
    }
}
