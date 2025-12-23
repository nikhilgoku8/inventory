<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'attributes';

    protected $fillable = [
        'title',
        'created_by',
        'updated_by',
    ];

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }
}
