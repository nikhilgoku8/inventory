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
        'created_by',
        'updated_by',
    ];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    // public function skus()
    // {
    //     return $this->hasMany(Sku::class);
    // }
}
