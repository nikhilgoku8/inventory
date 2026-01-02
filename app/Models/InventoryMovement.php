<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    protected $table = 'inventory_movements';

    protected $fillable = [
        'sku_id',
        'quantity',
        'movement_type',
        'remarks',
        'created_by',
        'updated_by',
    ];

    public function sku()
    {
        return $this->belongsTo(Sku::class);
    }
}
