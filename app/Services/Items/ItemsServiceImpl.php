<?php


namespace App\Services\Items;


use App\Models\Item;
use App\Services\BaseServiceImpl;

class ItemsServiceImpl extends BaseServiceImpl implements ItemsService
{
    public function __construct(Item $model)
    {
        parent::__construct($model);
    }
}
