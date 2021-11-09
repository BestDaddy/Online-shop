<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Items\CategoriesService;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    private $categoriesService;

    public function __construct(CategoriesService $categoriesService) {
        $this->categoriesService = $categoriesService;
    }

    public function index()
    {
        return $this->categoriesService->datatables(Category::TABLE_NAME);
    }
}
