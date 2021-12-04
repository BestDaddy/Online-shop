<?php


namespace App\Http\Controllers\Api\Admin;


use App\Http\Controllers\ApiBaseController;
use App\Services\Items\ItemsService;

class ItemsController extends ApiBaseController
{
    private $itemsService;
    public function __construct(ItemsService $itemsService)
    {
        $this->itemsService = $itemsService;
    }

    public function index()
    {
        return $this->successResponse($this->itemsService->all());
    }

    public function show($id)
    {
        return $this->successResponse($this->itemsService->findWith($id, ['subcategory.category']));
    }
}
