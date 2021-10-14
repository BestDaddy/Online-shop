<?php


namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Services\Items\ItemsService;

class ItemsController extends Controller
{
    private $itemsService;

    public function __construct(ItemsService $itemsService) {
        $this->itemsService = $itemsService;
    }

    public function index() {
        $items = $this->itemsService->all();

        return view('test', compact('items'));
    }
}
