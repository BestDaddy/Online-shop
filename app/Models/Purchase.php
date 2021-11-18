<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;
    protected $table = 'purchases';
    protected $fillable = [
        'user_id',
        'delivery_id',
        'paid',
        'status',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'purchase_item', 'purchase_id', 'item_id');
    }

//    public function delivery()
//    {
//
//    }

}
