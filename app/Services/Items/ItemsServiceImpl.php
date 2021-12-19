<?php


namespace App\Services\Items;


use App\Models\Category;
use App\Models\Item;
use App\Services\BaseServiceImpl;

class ItemsServiceImpl extends BaseServiceImpl implements ItemsService
{
    public function __construct(Item $model)
    {
        parent::__construct($model);
    }

    public function index($subcategory_id = null)
    {
        $categories = Category::with([
            'subcategories' => function ($q) {
                $q->select('id', 'name', 'category_id');
                $q->withCount('items');
            },
        ])
            ->whereHas('subcategories')
            ->select('id', 'name')
            ->get();

        if($subcategory_id != null) {
            $items = $this->getWhere(['subcategory_id' => $subcategory_id]);
        } else {
            $items = $this->all();
        }

        return view('user.items.index', compact('items', 'categories'));
    }
}
