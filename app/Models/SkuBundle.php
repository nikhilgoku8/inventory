<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkuBundle extends Model
{
    protected $table = 'sku_bundles';

    protected $fillable = [
        'bundle_sku_id',
        'child_sku_id',
        'quantity',
        'created_by',
        'updated_by',
    ];

    public function childSku()
    {
        return $this->belongsTo(Sku::class, 'child_sku_id');
    }
    
}
