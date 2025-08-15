<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockInventoryHistory extends Model
{
    use HasFactory;

    protected $table = 'stock_inventory_history';

    protected $fillable = [
        'stock_inventory_id',
        'contractor_pic',
        'billboard_in_id',
        'billboard_out_id',
        'company_in_id',
        'company_out_id',
        'date_in',
        'date_out',
        'remarks_in',
        'remarks_out',
        'balance_contractor',
        'balance_bgoc',
        'quantity_in',
        'quantity_out',
        'changed_at',
        'changed_by',
        'change_type',
        'change_notes',
    ];

    protected $casts = [
        'date_in' => 'date',
        'date_out' => 'date',
        'changed_at' => 'datetime',
        'balance_contractor' => 'integer',
        'balance_bgoc' => 'integer',
        'quantity_in' => 'integer',
        'quantity_out' => 'integer',
    ];

    /**
     * Relationships
     */
    public function stockInventory()
    {
        return $this->belongsTo(StockInventory::class);
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_pic');
    }

    public function billboardIn()
    {
        return $this->belongsTo(Billboard::class, 'billboard_in_id');
    }

    public function billboardOut()
    {
        return $this->belongsTo(Billboard::class, 'billboard_out_id');
    }

    public function companyIn()
    {
        return $this->belongsTo(ClientCompany::class, 'company_in_id');
    }

    public function companyOut()
    {
        return $this->belongsTo(ClientCompany::class, 'company_out_id');
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
