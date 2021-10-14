<?php


namespace App\Services\Items;


use App\Models\Category;
use App\Services\BaseServiceImpl;

class CategoriesServiceImpl extends BaseServiceImpl implements CategoriesService
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }
}
