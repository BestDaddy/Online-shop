<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $fillable = [
        'name',
        'order'
    ];

    public function subcategories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Subcategory::class, 'category_id');
    }

    public function subcategory(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Subcategory::class, 'category_id');
    }
}
