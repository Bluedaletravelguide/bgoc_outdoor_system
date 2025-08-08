<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockInventory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stock_inventory';

    protected $fillable = [
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
        'created_at',
        'updated_at'
    ];

    // Relations for client companies
    public function clientIn()
    {
        return $this->belongsTo(ClientCompany::class, 'company_in_id');
    }

    public function clientOut()
    {
        return $this->belongsTo(ClientCompany::class, 'company_out_id');
    }

    // Relations for billboards
    public function billboardIn()
    {
        return $this->belongsTo(Billboard::class, 'billboard_in_id');
    }

    public function billboardOut()
    {
        return $this->belongsTo(Billboard::class, 'billboard_out_id');
    }
}
