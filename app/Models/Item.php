<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'subcategory_id', 'name', 'description',
        'count', 'order', 'status'
    ];

    public function subcategory() {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }
}
