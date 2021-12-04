<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Services\Items\ItemsService;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    private $itemsService;

    public function __construct(ItemsService $itemsService) {
        $this->itemsService = $itemsService;
    }

    public function index()
    {
        $items = $this->itemsService->all();
        return view('user.items.index', compact('items'));
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
}
