<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    protected $table = 'skus';

    protected $fillable = [
        'product_id',
        'sku_code',
        'barcode',
        'image',
        'price',
        'stock',
        'is_bundle',
        'created_by',
        'updated_by',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'sku_attributes')->withTimestamps();
    }

    protected static function booted()
    {
        static::deleting(function ($sku) {
            $uploadRoot = base_path(env('UPLOAD_ROOT'));
            $imagesPath = $uploadRoot . '/products/'.$sku->product->slug;
            
            if ($sku->image && file_exists($imagesPath.'/'.$sku->image)) {
                @unlink($imagesPath.'/'.$sku->image);
            }
            
            if ($sku->barcode && file_exists($imagesPath.'/'.$sku->barcode)) {
                @unlink($imagesPath.'/'.$sku->barcode);
            }
        });
    }
}
