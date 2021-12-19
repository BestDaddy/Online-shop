<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Services\Items\CategoriesService;
use App\Services\Items\ItemsService;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    private $itemsService;
    private $categoriesService;

    public function __construct(ItemsService $itemsService, CategoriesService $categoriesService) {
        $this->itemsService = $itemsService;
        $this->categoriesService = $categoriesService;
    }

    public function index()
    {
        return $this->itemsService->index();
    }

    public function show($id)
    {
        $item = $this->itemsService->findWith($id, ['subcategory']);
        return view('user.items.show', compact('item'));
    }

    public function cacheIndex()
    {
        $data['items'] = cache('items', function () {
            return Item::with([])->orderBy('created_at', 'desc')->take(5)->get();
        });

        return view('cache.index', compact('data'));
    }

    public function subcategory($id)
    {
        return $this->itemsService->index($id);
    }
}
