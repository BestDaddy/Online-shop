<?php


namespace App\Services\Items;


use App\Models\Subcategory;
use App\Services\BaseServiceImpl;

class SubcategoriesServiceImpl extends BaseServiceImpl implements SubcategoriesService
{
    public function __construct(Subcategory $model)
    {
        parent::__construct($model);
    }

}
