<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
    ];
    public $timestamps = false;

    const ADMIN_ID = 1;
    const MANAGER_ID = 2;
    const USER_ID = 3;
    const COURIER_ID = 4;

}
