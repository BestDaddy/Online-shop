<?php

namespace App\Models;

use App\Events\ItemCreated;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = [
        'subcategory_id', 'name', 'description',
        'count', 'order', 'status', 'price', 'image'
    ];

    protected $dispatchesEvents = [
        'created' => ItemCreated::class //When a post is created then this Event will be fired
    ];

    public function subcategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }
}
