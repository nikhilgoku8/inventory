<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'sub_category_id',
        'title',
        'slug',
        'description',
        'code',
        'image',
        'created_by',
        'updated_by',
    ];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function skus()
    {
        return $this->hasMany(Sku::class);
    }

    protected static function booted()
    {
        static::deleting(function ($product) {
            $product->skus->each->delete();
            $uploadRoot = base_path(env('UPLOAD_ROOT'));
            $imagesPath = $uploadRoot . '/products';
            
            if ($product->image && file_exists($imagesPath.'/'.$product->image)) {
                @unlink($imagesPath.'/'.$product->image);
            }
        });
    }
}
