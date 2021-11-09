<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public const TABLE_NAME = 'categories';

    public $fillable = [
        'name',
        ''
    ];
}
