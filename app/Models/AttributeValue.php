<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $table = 'attribute_values';

    protected $fillable = [
        'attribute_id',
        'value',
        'code',
        'created_by',
        'updated_by'
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function skus()
    {
        return $this->belongsToMany(Sku::class, 'sku_attributes')->withTimestamps();
    }
}
